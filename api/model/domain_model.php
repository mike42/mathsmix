<?php
class domain_model {
	/* Fields */
	public $domain_id;
	public $school_id;
	public $domain_defaultrole;
	public $domain_host;
	public $domain_created;

	/* Referenced tables */
	public $school;

	/* Tables which reference this */
	public $list_user                 = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("school_model");
		core::loadClass("user_model");
	}

	/**
	 * Create new domain based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function domain_model(array $row) {
		$this -> domain_id          = isset($row['domain_id'])          ? $row['domain_id']         : '';
		$this -> school_id          = isset($row['school_id'])          ? $row['school_id']         : '';
		$this -> domain_defaultrole = isset($row['domain_defaultrole']) ? $row['domain_defaultrole']: '';
		$this -> domain_host        = isset($row['domain_host'])        ? $row['domain_host']       : '';
		$this -> domain_created     = isset($row['domain_created'])     ? $row['domain_created']    : '';

		/* Fields from related tables */
		$this -> school = new school_model($row);
	}

	public static function get($domain_id) {
		$sql = "SELECT * FROM domain LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN user ON school.user_id = user.user_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE domain_id='%s'";
		$res = database::retrieve($sql, array($domain_id));
		if($row = database::get_row($res)) {
			return new domain_model($row);
		}
		return false;
	}

	public static function get_by_domain_host($domain_host) {
		$sql = "SELECT * FROM domain LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN user ON school.user_id = user.user_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE domain_host='%s'";
		$res = database::retrieve($sql, array($domain_host));
		if($row = database::get_row($res)) {
			return new domain_model($row);
		}
		return false;
	}

	public static function list_by_school_id($school_id) {
		$sql = "SELECT * FROM domain LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN user ON school.user_id = user.user_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE school_id='%s';";
		$res = database::retrieve($sql, array($school_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new domain_model($row);
		}
		return $ret;
	}

	public function populate_list_user() {
		$this -> list_user = user::list_by_domain_id($this -> domain_id);
	}

	public function insert() {
		$sql = "INSERT INTO domain(school_id, domain_defaultrole, domain_host) VALUES ('%s', '%s', '%s');";
		return database::insert($sql, array($this -> school_id, $this -> domain_defaultrole, $this -> domain_host));
	}

	public function update() {
		$sql = "UPDATE domain SET school_id, domain_defaultrole, domain_host WHERE domain_id ='%s';";
		return database::update($sql, array($this -> school_id, $this -> domain_defaultrole, $this -> domain_host, $this -> domain_id));
	}
}
?>