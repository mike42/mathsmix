<?php
class country {
	public $country_iso;
	public $country_name;

	/* Tables which reference this */
	public $list_district;

	public function country($row) {
		$this -> country_iso  = $row['country_iso'];
		$this -> country_name = $row['country_name'];

	public static function get($country_iso) {
		$sql = "SELECT * FROM country WHERE country_iso='%s'";
		$res = Database::retrieve($sql, array($country_iso))
		if($row = Database::get_row($res) {
			return new country($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public function populate_list_year_week() {
		$this -> list_district = district::list_by_country_iso($this -> country_iso);
	}
}
?>