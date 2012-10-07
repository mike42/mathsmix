<?php
class district {
	public $district_id;
	public $district_name;
	public $country_iso;
	public $district_term_count;
	public $district_created;

	/* Referenced tables */
	public $country;

	/* Tables which reference this */
	public $list_school;
	public $list_year_level;

	public function district($row) {
		$this -> district_id         = $row['district_id'];
		$this -> district_name       = $row['district_name'];
		$this -> country_iso         = $row['country_iso'];
		$this -> district_term_count = $row['district_term_count'];
		$this -> district_created    = $row['district_created'];

		/* Fields from related tables */
		$this -> country = new country($row);
	}

	public static function get($district_id) {
		$sql = "SELECT * FROM district LEFT JOIN country ON district.country_iso = country.country_iso WHERE district_id='%s'";
		$res = Database::retrieve($sql, array($district_id));
		if($row = Database::get_row($res)) {
			return new district($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public static function list_by_country_iso($country_iso) {
		$sql = "SELECT * FROM district LEFT JOIN country ON district.country_iso = country.country_iso WHERE country_iso='%s';";
		$res = Database::retrieve($sql, array($country_iso));
		$ret = array();
		while($row = Database::get_row($res)) {
			$ret[] = new district($row);
		}
		return $ret;
	}

	public function populate_list_country() {
		$this -> list_school = school::list_by_district_id($this -> district_id);
	}

	public function populate_list_country() {
		$this -> list_year_level = year_level::list_by_district_id($this -> district_id);
	}
}
?>