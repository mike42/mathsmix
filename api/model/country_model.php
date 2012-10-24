<?php
class country_model {
	/* Fields */
	public $country_iso;
	public $country_name;

	/* Tables which reference this */
	public $list_district             = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("district_model");
	}

	/**
	 * Create new country based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function country_model(array $row = array()) {
		$this -> country_iso  = isset($row['country_iso'])  ? $row['country_iso'] : '';
		$this -> country_name = isset($row['country_name']) ? $row['country_name']: '';
	}

	public static function get($country_iso) {
		$sql = "SELECT * FROM country WHERE country.country_iso='%s'";
		$res = database::retrieve($sql, array($country_iso));
		if($row = database::get_row($res)) {
			return new country_model($row);
		}
		return false;
	}

	public function populate_list_district() {
		$this -> list_district = district_model::list_by_country_iso($this -> country_iso);
	}

	public function insert() {
		$sql = "INSERT INTO country(country_iso, country_name) VALUES ('%s', '%s');";
		return database::insert($sql, array($this -> country_iso, $this -> country_name));
	}

	public function update() {
		$sql = "UPDATE country SET country_name WHERE country_iso ='%s';";
		return database::update($sql, array($this -> country_name, $this -> country_iso));
	}
}
?>