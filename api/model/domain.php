<?php
class domain {
	public $domain_id;
	public $school_id;
	public $domain_defaultrole;
	public $domain_host;
	public $domain_created;

	/* Referenced tables */
	public $school;

	/* Tables which reference this */
	public $list_user;

	public function domain($row) {
		$this -> domain_id          = $row['domain_id'];
		$this -> school_id          = $row['school_id'];
		$this -> domain_defaultrole = $row['domain_defaultrole'];
		$this -> domain_host        = $row['domain_host'];
		$this -> domain_created     = $row['domain_created'];

		/* Fields from related tables */
		$this -> school = new school($row);
	}

	public static function get($domain_id) {
		$sql = "SELECT * FROM domain LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN user ON school.user_id = user.user_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE domain_id='%s'";
		$res = Database::retrieve($sql, array($domain_id))
		if($row = Database::get_row($res) {
			return new domain($row);
		}
		return false;
	}

	public static function get_by_domain_host($domain_host) {
		$sql = "SELECT * FROM domain LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN user ON school.user_id = user.user_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE domain_host='%s'";
		$res = Database::retrieve($sql, array($domain_host))
		if($row = Database::get_row($res) {
			return new domain($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public static function list_by_school_id($school_id) {
		$sql = "SELECT * FROM domain LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN user ON school.user_id = user.user_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE school_id='%s';";
		$res = Database::retrieve($sql, array($school_id))
		$ret = array();
		while($row = Database::get_row($res) {
			$ret[] = new domain($row);
		}
		return $ret;
	}

	public function populate_list_school() {
		$this -> list_user = user::list_by_domain_id($this -> domain_id);
	}
}
?>