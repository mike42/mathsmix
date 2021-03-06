<?php
class school_model {
	/* Fields */
	public $school_id;
	public $school_name;
	public $school_location;
	public $school_tz;
	public $school_created;
	public $district_id;

	/* Referenced tables */
	public $district;

	/* Tables which reference this */
	public $list_classes              = array();
	public $list_domain               = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("district_model");
		core::loadClass("classes_model");
		core::loadClass("domain_model");
	}

	/**
	 * Create new school based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function school_model(array $row = array()) {
		$this -> school_id       = isset($row['school_id'])       ? $row['school_id']      : '';
		$this -> school_name     = isset($row['school_name'])     ? $row['school_name']    : '';
		$this -> school_location = isset($row['school_location']) ? $row['school_location']: '';
		$this -> school_tz       = isset($row['school_tz'])       ? $row['school_tz']      : '';
		$this -> school_created  = isset($row['school_created'])  ? $row['school_created'] : '';
		$this -> district_id     = isset($row['district_id'])     ? $row['district_id']    : '';

		/* Fields from related tables */
		$this -> district = new district_model($row);
	}

	public static function get($school_id) {
		$sql = "SELECT * FROM school LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE school.school_id='%s'";
		$res = database::retrieve($sql, array($school_id));
		if($row = database::get_row($res)) {
			return new school_model($row);
		}
		return false;
	}

	public static function list_by_district_id($district_id) {
		$sql = "SELECT * FROM school LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE school.district_id='%s';";
		$res = database::retrieve($sql, array($district_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new school_model($row);
		}
		return $ret;
	}

	public function populate_list_classes() {
		$this -> list_classes = classes_model::list_by_school_id($this -> school_id);
	}

	public function populate_list_domain() {
		$this -> list_domain = domain_model::list_by_school_id($this -> school_id);
	}

	public function insert() {
		$sql = "INSERT INTO school(school_name, school_location, school_tz, district_id) VALUES ('%s', '%s', '%s', '%s');";
		return database::insert($sql, array($this -> school_name, $this -> school_location, $this -> school_tz, $this -> district_id));
	}

	public function update() {
		$sql = "UPDATE school SET school_name, school_location, school_tz, district_id WHERE school_id ='%s';";
		return database::update($sql, array($this -> school_name, $this -> school_location, $this -> school_tz, $this -> district_id, $this -> school_id));
	}
}
?>