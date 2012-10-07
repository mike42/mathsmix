<?php
class class_selection {
	public $class_id;
	public $tt_id;
	public $yw_id;
	public $cs_due;
	public $cs_visible_from;
	public $cs_enabled;
	public $cs_compulsory;
	public $cs_created;

	/* Referenced tables */
	public $classes;
	public $task_template;
	public $year_week;

	public function class_selection($row) {
		$this -> class_id        = $row['class_id'];
		$this -> tt_id           = $row['tt_id'];
		$this -> yw_id           = $row['yw_id'];
		$this -> cs_due          = $row['cs_due'];
		$this -> cs_visible_from = $row['cs_visible_from'];
		$this -> cs_enabled      = $row['cs_enabled'];
		$this -> cs_compulsory   = $row['cs_compulsory'];
		$this -> cs_created      = $row['cs_created'];

		/* Fields from related tables */
		$this -> classes = new classes($row);
		$this -> task_template = new task_template($row);
		$this -> year_week = new year_week($row);
	}

	public static function get($class_id, $tt_id) {
		$sql = "SELECT * FROM class_selection LEFT JOIN classes ON class_selection.class_id = classes.class_id LEFT JOIN task_template ON class_selection.tt_id = task_template.tt_id LEFT JOIN year_week ON class_selection.yw_id = year_week.yw_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN user ON task_template.user_id = user.user_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE class_id='%s' AND tt_id='%s'";
		$res = Database::retrieve($sql, array($class_id, $tt_id))
		if($row = Database::get_row($res) {
			return new class_selection($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public static function list_by_yw_id($yw_id) {
		$sql = "SELECT * FROM class_selection LEFT JOIN classes ON class_selection.class_id = classes.class_id LEFT JOIN task_template ON class_selection.tt_id = task_template.tt_id LEFT JOIN year_week ON class_selection.yw_id = year_week.yw_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN user ON task_template.user_id = user.user_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE yw_id='%s';";
		$res = Database::retrieve($sql, array($yw_id))
		$ret = array();
		while($row = Database::get_row($res) {
			$ret[] = new class_selection($row);
		}
		return $ret;
	}

	public static function list_by_class_id($class_id) {
		$sql = "SELECT * FROM class_selection LEFT JOIN classes ON class_selection.class_id = classes.class_id LEFT JOIN task_template ON class_selection.tt_id = task_template.tt_id LEFT JOIN year_week ON class_selection.yw_id = year_week.yw_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN user ON task_template.user_id = user.user_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE class_id='%s';";
		$res = Database::retrieve($sql, array($class_id))
		$ret = array();
		while($row = Database::get_row($res) {
			$ret[] = new class_selection($row);
		}
		return $ret;
	}

	public static function list_by_tt_id($tt_id) {
		$sql = "SELECT * FROM class_selection LEFT JOIN classes ON class_selection.class_id = classes.class_id LEFT JOIN task_template ON class_selection.tt_id = task_template.tt_id LEFT JOIN year_week ON class_selection.yw_id = year_week.yw_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN user ON task_template.user_id = user.user_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE tt_id='%s';";
		$res = Database::retrieve($sql, array($tt_id))
		$ret = array();
		while($row = Database::get_row($res) {
			$ret[] = new class_selection($row);
		}
		return $ret;
	}
}
?>