<?php
class district_model {
	/* Fields */
	public $district_id;
	public $district_name;
	public $country_iso;
	public $district_term_count;
	public $district_created;

	/* Referenced tables */
	public $country;

	/* Tables which reference this */
	public $list_school               = array();
	public $list_year_level           = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("country_model");
		core::loadClass("school_model");
		core::loadClass("year_level_model");
	}

	/**
	 * Create new district based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function district_model(array $row = array()) {
		$this -> district_id         = isset($row['district_id'])         ? $row['district_id']        : '';
		$this -> district_name       = isset($row['district_name'])       ? $row['district_name']      : '';
		$this -> country_iso         = isset($row['country_iso'])         ? $row['country_iso']        : '';
		$this -> district_term_count = isset($row['district_term_count']) ? $row['district_term_count']: '';
		$this -> district_created    = isset($row['district_created'])    ? $row['district_created']   : '';

		/* Fields from related tables */
		$this -> country = new country_model($row);
	}

	public static function get($district_id) {
		$sql = "SELECT * FROM district LEFT JOIN country ON district.country_iso = country.country_iso WHERE district_id='%s'";
		$res = database::retrieve($sql, array($district_id));
		if($row = database::get_row($res)) {
			return new district_model($row);
		}
		return false;
	}

	public static function list_by_country_iso($country_iso) {
		$sql = "SELECT * FROM district LEFT JOIN country ON district.country_iso = country.country_iso WHERE country_iso='%s';";
		$res = database::retrieve($sql, array($country_iso));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new district_model($row);
		}
		return $ret;
	}

	public function populate_list_school() {
		$this -> list_school = school::list_by_district_id($this -> district_id);
	}

	public function populate_list_year_level() {
		$this -> list_year_level = year_level::list_by_district_id($this -> district_id);
	}

	public function insert() {
		$sql = "INSERT INTO district(district_name, country_iso, district_term_count) VALUES ('%s', '%s', '%s');";
		return database::insert($sql, array($this -> district_name, $this -> country_iso, $this -> district_term_count));
	}

	public function update() {
		$sql = "UPDATE district SET district_name, country_iso, district_term_count WHERE district_id ='%s';";
		return database::update($sql, array($this -> district_name, $this -> country_iso, $this -> district_term_count, $this -> district_id));
	}
}
?>