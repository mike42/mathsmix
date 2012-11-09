<?php
class classes_model {
	/* Fields */
	public $class_id;
	public $class_name;
	public $yl_id;
	public $class_open;
	public $class_year;
	public $class_created;
	public $school_id;

	/* Referenced tables */
	public $year_level;
	public $school;

	/* Tables which reference this */
	public $list_attends              = array();
	public $list_task_template        = array();
	public $list_teaches              = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("year_level_model");
		core::loadClass("school_model");
		core::loadClass("attends_model");
		core::loadClass("task_template_model");
		core::loadClass("teaches_model");
	}

	/**
	 * Create new classes based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function classes_model(array $row = array()) {
		$this -> class_id      = isset($row['class_id'])      ? $row['class_id']     : '';
		$this -> class_name    = isset($row['class_name'])    ? $row['class_name']   : '';
		$this -> yl_id         = isset($row['yl_id'])         ? $row['yl_id']        : '';
		$this -> class_open    = isset($row['class_open'])    ? $row['class_open']   : '';
		$this -> class_year    = isset($row['class_year'])    ? $row['class_year']   : '';
		$this -> class_created = isset($row['class_created']) ? $row['class_created']: '';
		$this -> school_id     = isset($row['school_id'])     ? $row['school_id']    : '';

		/* Fields from related tables */
		$this -> year_level = new year_level_model($row);
		$this -> school = new school_model($row);
	}

	public static function get($class_id) {
		$sql = "SELECT * FROM classes LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE classes.class_id='%s'";
		$res = database::retrieve($sql, array($class_id));
		if($row = database::get_row($res)) {
			return new classes_model($row);
		}
		return false;
	}

	public static function list_by_yl_id($yl_id) {
		$sql = "SELECT * FROM classes LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE classes.yl_id='%s';";
		$res = database::retrieve($sql, array($yl_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new classes_model($row);
		}
		return $ret;
	}

	public static function list_by_school_id($school_id) {
		$sql = "SELECT * FROM classes LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE classes.school_id='%s';";
		$res = database::retrieve($sql, array($school_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new classes_model($row);
		}
		return $ret;
	}

	public static function list_by_yl_and_school($yl_id, $school_id) {
		$sql = "SELECT * FROM classes LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE classes.yl_id='%s' AND classes.school_id='%s';";
		$res = database::retrieve($sql, array($yl_id, $school_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new classes_model($row);
		}
		return $ret;
	}

	public function populate_list_attends() {
		$this -> list_attends = attends_model::list_by_class_id($this -> class_id);
	}

	public function populate_list_task_template() {
		$this -> list_task_template = task_template_model::list_by_class_id($this -> class_id);
	}

	public function populate_list_teaches() {
		$this -> list_teaches = teaches_model::list_by_class_id($this -> class_id);
	}

	public function insert() {
		$sql = "INSERT INTO classes(class_name, yl_id, class_open, class_year, school_id) VALUES ('%s', '%s', '%s', '%s', '%s');";
		return database::insert($sql, array($this -> class_name, $this -> yl_id, $this -> class_open, $this -> class_year, $this -> school_id));
	}

	public function update() {
		$sql = "UPDATE classes SET class_name, yl_id, class_open, class_year, school_id WHERE class_id ='%s';";
		return database::update($sql, array($this -> class_name, $this -> yl_id, $this -> class_open, $this -> class_year, $this -> school_id, $this -> class_id));
	}
}
?>