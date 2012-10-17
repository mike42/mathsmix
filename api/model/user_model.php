<?php
class user {
	public $user_id;
	public $user_firstname;
	public $user_surname;
	public $user_email;
	public $domain_id;
	public $user_password;
	public $user_salt;
	public $user_role;
	public $user_created;

	/* Referenced tables */
	public $domain;

	/* Tables which reference this */
	public $list_activity;
	public $list_activity_template;
	public $list_attends;
	public $list_school;
	public $list_task;
	public $list_task_template;
	public $list_teaches;

	public function user($row) {
		$this -> user_id        = $row['user_id'];
		$this -> user_firstname = $row['user_firstname'];
		$this -> user_surname   = $row['user_surname'];
		$this -> user_email     = $row['user_email'];
		$this -> domain_id      = $row['domain_id'];
		$this -> user_password  = $row['user_password'];
		$this -> user_salt      = $row['user_salt'];
		$this -> user_role      = $row['user_role'];
		$this -> user_created   = $row['user_created'];

		/* Fields from related tables */
		$this -> domain = new domain($row);
	}

	public static function get($user_id) {
		$sql = "SELECT * FROM user LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE user_id='%s'";
		$res = Database::retrieve($sql, array($user_id));
		if($row = Database::get_row($res)) {
			return new user($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public static function list_by_domain_id($domain_id) {
		$sql = "SELECT * FROM user LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE domain_id='%s';";
		$res = Database::retrieve($sql, array($domain_id));
		$ret = array();
		while($row = Database::get_row($res)) {
			$ret[] = new user($row);
		}
		return $ret;
	}

	public function populate_list_domain() {
		$this -> list_activity = activity::list_by_user_id($this -> user_id);
	}

	public function populate_list_domain() {
		$this -> list_activity_template = activity_template::list_by_user_id($this -> user_id);
	}

	public function populate_list_domain() {
		$this -> list_attends = attends::list_by_user_id($this -> user_id);
	}

	public function populate_list_domain() {
		$this -> list_school = school::list_by_user_id($this -> user_id);
	}

	public function populate_list_domain() {
		$this -> list_task = task::list_by_user_id($this -> user_id);
	}

	public function populate_list_domain() {
		$this -> list_task_template = task_template::list_by_user_id($this -> user_id);
	}

	public function populate_list_domain() {
		$this -> list_teaches = teaches::list_by_user_id($this -> user_id);
	}
}
?>