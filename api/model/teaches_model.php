<?php
class teaches_model {
	/* Fields */
	public $user_id;
	public $class_id;

	/* Referenced tables */
	public $user;
	public $classes;

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("user_model");
		core::loadClass("classes_model");
	}

	/**
	 * Create new teaches based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function teaches_model(array $row = array()) {
		$this -> user_id  = isset($row['user_id'])  ? $row['user_id'] : '';
		$this -> class_id = isset($row['class_id']) ? $row['class_id']: '';

		/* Fields from related tables */
		$this -> user = new user_model($row);
		$this -> classes = new classes_model($row);
	}

	public static function get($user_id, $class_id) {
		$sql = "SELECT * FROM teaches LEFT JOIN user ON teaches.user_id = user.user_id LEFT JOIN classes ON teaches.class_id = classes.class_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE user_id='%s' AND class_id='%s'";
		$res = database::retrieve($sql, array($user_id, $class_id));
		if($row = database::get_row($res)) {
			return new teaches_model($row);
		}
		return false;
	}

	public static function list_by_user_id($user_id) {
		$sql = "SELECT * FROM teaches LEFT JOIN user ON teaches.user_id = user.user_id LEFT JOIN classes ON teaches.class_id = classes.class_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE user_id='%s';";
		$res = database::retrieve($sql, array($user_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new teaches_model($row);
		}
		return $ret;
	}

	public static function list_by_class_id($class_id) {
		$sql = "SELECT * FROM teaches LEFT JOIN user ON teaches.user_id = user.user_id LEFT JOIN classes ON teaches.class_id = classes.class_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE class_id='%s';";
		$res = database::retrieve($sql, array($class_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new teaches_model($row);
		}
		return $ret;
	}

	public function insert() {
		$sql = "INSERT INTO teaches(user_id, class_id) VALUES ('%s', '%s');";
		return database::insert($sql, array($this -> user_id, $this -> class_id));
	}

	public function update() {
		$sql = "UPDATE teaches SET  WHERE user_id ='%s'ANDclass_id ='%s';";
		return database::update($sql, array($this -> user_id, $this -> class_id));
	}
}
?>