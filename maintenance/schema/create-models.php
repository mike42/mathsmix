#!/usr/bin/php
<?
/* This is an extremely crude model generator.
 * 	Works with phpmyadmin exports of this specific database.
 * 	Will probably not work on other datbases, other exports of
 *	the same database, etc. */

$sql = file_get_contents(dirname(__FILE__)."/mathsmix-schema.sql");
$lines = explode("\n", $sql);
$table = array();

$create = "CREATE TABLE";
$alter = "ALTER TABLE";
$primary = "PRIMARY KEY";
$key = "KEY";
$unique = "UNIQUE KEY";
$constraint = "ADD CONSTRAINT";

$action = "";
$inTable = "";

foreach($lines as $line) {
	$line = trim($line);
	if($line == "") {
		$action = "";
	} elseif($action == $create) {
		/* Look for fields and keys */
		$part = explode("`", $line);
		$key = "";
		if(isset($part[1])) {
			$field = $part[1];
			$fields = array();
			if(substr($line,0,1) == "`") {
				/* Just pull list of fields */
				$table[$inTable]['field'][$field] = true;
			} elseif(substr($line,0,strlen($primary)) == $primary) {
				for($i = 1; $i < count($part); $i += 2) {
					$fields[] = $part[$i];
				}
				$table[$inTable]['index']['primary'] = $fields;
			} elseif(substr($line,0,strlen($unique)) == $unique || substr($line,0,strlen($key)) == $key) {
				$key = "unique";
				for($i = 3; $i < count($part); $i += 2) {
					$fields[] = $part[$i];
				}
				$table[$inTable]['index']['index'][$part[1]] = $fields;
				if(substr($line,0,strlen($unique)) == $unique) {
					$table[$inTable]['index']['unique'][$part[1]] = true;
				}
			}
		}
	} elseif($action == $alter && substr($line,0,strlen($constraint)) == $constraint) {
		$part = explode("(", $line);
		$sub_part = explode("`",$part[1]);
		$field = $sub_part[1];
		$dest_table = $sub_part[3];
		$sub_part = explode("`",$part[2]);
		$dest_key = $sub_part[1];
		
		$table[$inTable]['references'][$dest_table]['local'] = $field;
		$table[$inTable]['references'][$dest_table]['remote'] = $dest_key;
		
		$table[$dest_table]['referenced'][$inTable]['local'] = $dest_key;
		$table[$dest_table]['referenced'][$inTable]['remote'] = $field;
	} else {
		/* Look for an action to start */
		if(substr($line,0,strlen($create)) == $create) {
			$action = $create;
			$part = explode("`", $line);
			$inTable = $part[1];
		} elseif(substr($line,0,strlen($alter)) == $alter) {
			$action = $alter;
			$part = explode("`", $line);
			$inTable = $part[1];
		}
	}
}

@mkdir(dirname(__FILE__)."/model/");
foreach($table as $name => $current) {
	$str = "<?php\n";
	$str .= "class $name {\n";
	$max = 0;
	/* Fields */
	foreach($current['field'] as $field => $exists) {
		if(strlen($field) > $max) {
			$max = strlen($field);
		}
		$str .= "\tpublic $".$field.";\n";
	}
	if(isset($current['references'])) {
		$str .= "\n\t/* Referenced tables */\n";
		foreach($current['references'] as $other_table => $fields) {
			$str .=  "\tpublic \$$other_table;\n";
		}
	}
	
	if(isset($current['referenced'])) {
		$str .= "\n\t/* Tables which reference this */\n";
		foreach($current['referenced'] as $other_table => $fields) {
			$str .=  "\tpublic \$list_$other_table;\n";
		}
	}
	
	/* Constructor */
	$str .= "\n\tpublic function $name(\$row) {\n";
	foreach($current['field'] as $field => $exists) {
		$str .= "\t\t\$this -> " . str_pad($field, $max, " ") . " = \$row['$field'];\n";
	}
	
	if(isset($current['references'])) {
		$str .= "\n\t\t/* Fields from related tables */\n";
		foreach($current['references'] as $references => $fields) {
			$str .= "\t\t\$this -> " . $references . " = new $references(\$row);\n";
		}
		$str .= "\t}\n";
	}
		
	if(!isset($current['index']['primary'])) {
		/* PK check */
		die("\nERROR: No primary key defined on $name\n");
	}
	
	/* Get by primary key and other unique keys */
	$str .= get($table, "get", $name, $current, $current['index']['primary']);
	if(isset($current['index']['unique'])) {
		foreach($current['index']['unique'] as $fname => $index) {
			$str .= get($table, "get_by_$fname", $name, $current, $current['index']['index'][$fname]);
		}
	}
	
	/* TODO: Update, delete, insert */
	$str .= "\n\tpublic function insert() {\n";
	$str .= "\n";
	$str .= "\t}\n";

	$str .= "\n\tpublic function update() {\n";
	$str .= "\n";
	$str .= "\t}\n";

	/* List by non-unique keys */
	if(isset($current['index']['index'])) {
		foreach($current['index']['index'] as $fname => $index) {
			if(!isset($current['index']['unique'][$fname])) {
				$str .= listBy($table, "list_by_$fname", $name, $current, $index);
			}
		}
	}
		
	/* Find related records */
	if(isset($current['referenced'])) {
		foreach($current['referenced'] as $referenced => $fields) {
			$str .= "\n\tpublic function populate_list_$references() {\n";
			$str .= "\t\t\$this -> list_$referenced = $referenced::list_by_".$fields['remote']."(\$this -> ".$fields['local'].");\n";
			$str .= "\t}\n";
		}
	}
	
	$str .= "}\n";
	$str .= "?>";
	
	file_put_contents(dirname(__FILE__)."/model/$name.php", $str);
}

function get($table, $fname, $name, $current, $index) {
	$fieldlist = $fieldlist_sql = array();
	foreach($index as $field) {
		$fieldlist[] = "\$".$field;
		$fieldlist_sql[] = $field . "='%s'";
	}
	$str = "\n\tpublic static function $fname(".implode(", ", $fieldlist).") {\n";
	$str .= "\t\t\$sql = \"".build_w_references($table, $name, $current)." WHERE " . implode(" AND ", $fieldlist_sql)."\";\n";	
	$str .= "\t\t\$res = Database::retrieve(\$sql, array(".implode(", ", $fieldlist)."))\n";
	$str .= "\t\tif(\$row = Database::get_row(\$res) {\n";
	$str .= "\t\t\treturn new $name(\$row);\n";
	$str .= "\t\t}\n";
	$str .= "\t\treturn false;\n";
	$str .= "\t}\n";
	return $str;
}

function listBy($table, $fname, $name, $current, $index) {
	$fieldlist = $fieldlist_sql = array();
	foreach($index as $field) {
		$fieldlist[] = "\$".$field;
		$fieldlist_sql[] = $field . "='%s'";
	}
	$str = "\n\tpublic static function $fname(".implode(", ", $fieldlist).") {\n";
	$str .= "\t\t\$sql = \"".build_w_references($table, $name, $current)." WHERE " . implode(" AND ", $fieldlist_sql).";\";\n";
	$str .= "\t\t\$res = Database::retrieve(\$sql, array(".implode(", ", $fieldlist)."))\n";
	$str .= "\t\t\$ret = array();\n";
	$str .= "\t\twhile(\$row = Database::get_row(\$res) {\n";
	$str .= "\t\t\t\$ret[] = new $name(\$row);\n";
	$str .= "\t\t}\n";
	$str .= "\t\treturn \$ret;\n";
	$str .= "\t}\n";
	return $str;
}

function build_w_references($table, $name, $current) {
	$q = "SELECT * FROM ".$name;
	if(!isset($current['references'])) {
		return $q;
	}	

	/* Build up a queue of other tables to join */
	$jointo = array();
	$joined = array();
	foreach($current['references'] as $join => $field) {
		$jointo[] = array('from' => $name, 'join' => $join, 'field' => $field);
	}

	while(count($jointo) > 0) {
		$next = array_shift($jointo);
		$join = $next['join'];
		if(!isset($joined[$join]) && $join != $name) {
			$field = $next['field'];
			$from = $next['from'];
			$q .= " LEFT JOIN $join ON $from.".$field['local']. " = $join.".$field['remote'];
			$joined[$join] = true;

			/* And add other joining fields */
			if(isset($table[$join]['references'])) {
				foreach($table[$join]['references'] as $to => $field) {
					$jointo[] = array('from' => $join, 'join' => $to, 'field' => $field);
				}
			}
		}
	}

	return $q;
}
?>
