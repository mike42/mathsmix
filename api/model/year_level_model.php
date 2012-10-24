<?php
class year_level_model {
	/* Fields */
	public $yl_id;
	public $yl_name;
	public $yl_level;
	public $district_id;
	public $yl_created;

	/* Referenced tables */
	public $district;

	/* Tables which reference this */
	public $list_classes              = array();
	public $list_task_template        = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("district_model");
		core::loadClass("classes_model");
		core::loadClass("task_template_model");
	}

	/**
	 * Create new year_level based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function year_level_model(array $row = array()) {
		$this -> yl_id       = isset($row['yl_id'])       ? $row['yl_id']      : '';
		$this -> yl_name     = isset($row['yl_name'])     ? $row['yl_name']    : '';
		$this -> yl_level    = isset($row['yl_level'])    ? $row['yl_level']   : '';
		$this -> district_id = isset($row['district_id']) ? $row['district_id']: '';
		$this -> yl_created  = isset($row['yl_created'])  ? $row['yl_created'] : '';

		/* Fields from related tables */
		$this -> district = new district_model($row);
	}

	public static function get($yl_id) {
		$sql = "SELECT * FROM year_level LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE year_level.yl_id='%s'";
		$res = database::retrieve($sql, array($yl_id));
		if($row = database::get_row($res)) {
			return new year_level_model($row);
		}
		return false;
	}

	public static function get_by_yl_level($yl_level, $district_id) {
		$sql = "SELECT * FROM year_level LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE year_level.yl_level='%s' AND year_level.district_id='%s'";
		$res = database::retrieve($sql, array($yl_level, $district_id));
		if($row = database::get_row($res)) {
			return new year_level_model($row);
		}
		return false;
	}

	public static function get_by_yl_name($yl_name, $district_id) {
		$sql = "SELECT * FROM year_level LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE year_level.yl_name='%s' AND year_level.district_id='%s'";
		$res = database::retrieve($sql, array($yl_name, $district_id));
		if($row = database::get_row($res)) {
			return new year_level_model($row);
		}
		return false;
	}

	public static function list_by_district_id($district_id) {
		$sql = "SELECT * FROM year_level LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE year_level.district_id='%s';";
		$res = database::retrieve($sql, array($district_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new year_level_model($row);
		}
		return $ret;
	}

	public function populate_list_classes() {
		$this -> list_classes = classes_model::list_by_yl_id($this -> yl_id);
	}

	public function populate_list_task_template() {
		$this -> list_task_template = task_template_model::list_by_yl_id($this -> yl_id);
	}

	public function insert() {
		$sql = "INSERT INTO year_level(yl_name, yl_level, district_id) VALUES ('%s', '%s', '%s');";
		return database::insert($sql, array($this -> yl_name, $this -> yl_level, $this -> district_id));
	}

	public function update() {
		$sql = "UPDATE year_level SET yl_name, yl_level, district_id WHERE yl_id ='%s';";
		return database::update($sql, array($this -> yl_name, $this -> yl_level, $this -> district_id, $this -> yl_id));
	}
}
?>