<?php
class classes {
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
	public $list_attends;
	public $list_class_selection;
	public $list_teaches;

	public function classes($row) {
		$this -> class_id      = $row['class_id'];
		$this -> class_name    = $row['class_name'];
		$this -> yl_id         = $row['yl_id'];
		$this -> class_open    = $row['class_open'];
		$this -> class_year    = $row['class_year'];
		$this -> class_created = $row['class_created'];
		$this -> school_id     = $row['school_id'];

		/* Fields from related tables */
		$this -> year_level = new year_level($row);
		$this -> school = new school($row);
	}

	public static function get($class_id) {
		$sql = "SELECT * FROM classes LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN user ON school.user_id = user.user_id LEFT JOIN country ON district.country_iso = country.country_iso LEFT JOIN domain ON user.domain_id = domain.domain_id WHERE class_id='%s'";
		$res = Database::retrieve($sql, array($class_id));
		if($row = Database::get_row($res)) {
			return new classes($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public static function list_by_yl_id($yl_id) {
		$sql = "SELECT * FROM classes LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN user ON school.user_id = user.user_id LEFT JOIN country ON district.country_iso = country.country_iso LEFT JOIN domain ON user.domain_id = domain.domain_id WHERE yl_id='%s';";
		$res = Database::retrieve($sql, array($yl_id));
		$ret = array();
		while($row = Database::get_row($res)) {
			$ret[] = new classes($row);
		}
		return $ret;
	}

	public static function list_by_school_id($school_id) {
		$sql = "SELECT * FROM classes LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN user ON school.user_id = user.user_id LEFT JOIN country ON district.country_iso = country.country_iso LEFT JOIN domain ON user.domain_id = domain.domain_id WHERE school_id='%s';";
		$res = Database::retrieve($sql, array($school_id));
		$ret = array();
		while($row = Database::get_row($res)) {
			$ret[] = new classes($row);
		}
		return $ret;
	}

	public function populate_list_school() {
		$this -> list_attends = attends::list_by_class_id($this -> class_id);
	}

	public function populate_list_school() {
		$this -> list_class_selection = class_selection::list_by_class_id($this -> class_id);
	}

	public function populate_list_school() {
		$this -> list_teaches = teaches::list_by_class_id($this -> class_id);
	}
}
?>