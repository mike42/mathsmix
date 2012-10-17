<?php
class teaches {
	public $user_id;
	public $class_id;

	/* Referenced tables */
	public $user;
	public $classes;

	public function teaches($row) {
		$this -> user_id  = $row['user_id'];
		$this -> class_id = $row['class_id'];

		/* Fields from related tables */
		$this -> user = new user($row);
		$this -> classes = new classes($row);
	}

	public static function get($user_id, $class_id) {
		$sql = "SELECT * FROM teaches LEFT JOIN user ON teaches.user_id = user.user_id LEFT JOIN classes ON teaches.class_id = classes.class_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE user_id='%s' AND class_id='%s'";
		$res = Database::retrieve($sql, array($user_id, $class_id));
		if($row = Database::get_row($res)) {
			return new teaches($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public static function list_by_user_id($user_id) {
		$sql = "SELECT * FROM teaches LEFT JOIN user ON teaches.user_id = user.user_id LEFT JOIN classes ON teaches.class_id = classes.class_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE user_id='%s';";
		$res = Database::retrieve($sql, array($user_id));
		$ret = array();
		while($row = Database::get_row($res)) {
			$ret[] = new teaches($row);
		}
		return $ret;
	}

	public static function list_by_class_id($class_id) {
		$sql = "SELECT * FROM teaches LEFT JOIN user ON teaches.user_id = user.user_id LEFT JOIN classes ON teaches.class_id = classes.class_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE class_id='%s';";
		$res = Database::retrieve($sql, array($class_id));
		$ret = array();
		while($row = Database::get_row($res)) {
			$ret[] = new teaches($row);
		}
		return $ret;
	}
}
?>