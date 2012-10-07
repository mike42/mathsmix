<?php
class year_level {
	public $yl_id;
	public $yl_name;
	public $yl_level;
	public $district_id;
	public $yl_created;

	/* Referenced tables */
	public $district;

	/* Tables which reference this */
	public $list_classes;
	public $list_task_template;

	public function year_level($row) {
		$this -> yl_id       = $row['yl_id'];
		$this -> yl_name     = $row['yl_name'];
		$this -> yl_level    = $row['yl_level'];
		$this -> district_id = $row['district_id'];
		$this -> yl_created  = $row['yl_created'];

		/* Fields from related tables */
		$this -> district = new district($row);
	}

	public static function get($yl_id) {
		$sql = "SELECT * FROM year_level LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE yl_id='%s'";
		$res = Database::retrieve($sql, array($yl_id))
		if($row = Database::get_row($res) {
			return new year_level($row);
		}
		return false;
	}

	public static function get_by_yl_level($yl_level, $district_id) {
		$sql = "SELECT * FROM year_level LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE yl_level='%s' AND district_id='%s'";
		$res = Database::retrieve($sql, array($yl_level, $district_id))
		if($row = Database::get_row($res) {
			return new year_level($row);
		}
		return false;
	}

	public static function get_by_yl_name($yl_name, $district_id) {
		$sql = "SELECT * FROM year_level LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE yl_name='%s' AND district_id='%s'";
		$res = Database::retrieve($sql, array($yl_name, $district_id))
		if($row = Database::get_row($res) {
			return new year_level($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public static function list_by_district_id($district_id) {
		$sql = "SELECT * FROM year_level LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE district_id='%s';";
		$res = Database::retrieve($sql, array($district_id))
		$ret = array();
		while($row = Database::get_row($res) {
			$ret[] = new year_level($row);
		}
		return $ret;
	}

	public function populate_list_district() {
		$this -> list_classes = classes::list_by_yl_id($this -> yl_id);
	}

	public function populate_list_district() {
		$this -> list_task_template = task_template::list_by_yl_id($this -> yl_id);
	}
}
?>