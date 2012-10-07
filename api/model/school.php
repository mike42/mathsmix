<?php
class school {
	public $school_id;
	public $school_name;
	public $school_location;
	public $school_tz;
	public $user_id;
	public $school_created;
	public $district_id;

	/* Referenced tables */
	public $user;
	public $district;

	/* Tables which reference this */
	public $list_classes;
	public $list_domain;

	public function school($row) {
		$this -> school_id       = $row['school_id'];
		$this -> school_name     = $row['school_name'];
		$this -> school_location = $row['school_location'];
		$this -> school_tz       = $row['school_tz'];
		$this -> user_id         = $row['user_id'];
		$this -> school_created  = $row['school_created'];
		$this -> district_id     = $row['district_id'];

		/* Fields from related tables */
		$this -> user = new user($row);
		$this -> district = new district($row);
	}

	public static function get($school_id) {
		$sql = "SELECT * FROM school LEFT JOIN user ON school.user_id = user.user_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE school_id='%s'";
		$res = Database::retrieve($sql, array($school_id));
		if($row = Database::get_row($res)) {
			return new school($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public static function list_by_district_id($district_id) {
		$sql = "SELECT * FROM school LEFT JOIN user ON school.user_id = user.user_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE district_id='%s';";
		$res = Database::retrieve($sql, array($district_id));
		$ret = array();
		while($row = Database::get_row($res)) {
			$ret[] = new school($row);
		}
		return $ret;
	}

	public static function list_by_user_id($user_id) {
		$sql = "SELECT * FROM school LEFT JOIN user ON school.user_id = user.user_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE user_id='%s';";
		$res = Database::retrieve($sql, array($user_id));
		$ret = array();
		while($row = Database::get_row($res)) {
			$ret[] = new school($row);
		}
		return $ret;
	}

	public function populate_list_district() {
		$this -> list_classes = classes::list_by_school_id($this -> school_id);
	}

	public function populate_list_district() {
		$this -> list_domain = domain::list_by_school_id($this -> school_id);
	}
}
?>