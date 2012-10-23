<?php
class user_model {
	/* Fields */
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
	public $list_activity             = array();
	public $list_activity_template    = array();
	public $list_attends              = array();
	public $list_task                 = array();
	public $list_task_template        = array();
	public $list_teaches              = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("domain_model");
		core::loadClass("activity_model");
		core::loadClass("activity_template_model");
		core::loadClass("attends_model");
		core::loadClass("task_model");
		core::loadClass("task_template_model");
		core::loadClass("teaches_model");
	}

	/**
	 * Create new user based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function user_model(array $row = array()) {
		$this -> user_id        = isset($row['user_id'])        ? $row['user_id']       : '';
		$this -> user_firstname = isset($row['user_firstname']) ? $row['user_firstname']: '';
		$this -> user_surname   = isset($row['user_surname'])   ? $row['user_surname']  : '';
		$this -> user_email     = isset($row['user_email'])     ? $row['user_email']    : '';
		$this -> domain_id      = isset($row['domain_id'])      ? $row['domain_id']     : '';
		$this -> user_password  = isset($row['user_password'])  ? $row['user_password'] : '';
		$this -> user_salt      = isset($row['user_salt'])      ? $row['user_salt']     : '';
		$this -> user_role      = isset($row['user_role'])      ? $row['user_role']     : '';
		$this -> user_created   = isset($row['user_created'])   ? $row['user_created']  : '';

		/* Fields from related tables */
		$this -> domain = new domain_model($row);
	}

	public static function get($user_id) {
		$sql = "SELECT * FROM user LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE user_id='%s'";
		$res = database::retrieve($sql, array($user_id));
		if($row = database::get_row($res)) {
			return new user_model($row);
		}
		return false;
	}

	public static function get_by_user_email($user_email) {
		$sql = "SELECT * FROM user LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE user_email='%s'";
		$res = database::retrieve($sql, array($user_email));
		if($row = database::get_row($res)) {
			return new user_model($row);
		}
		return false;
	}

	public static function list_by_domain_id($domain_id) {
		$sql = "SELECT * FROM user LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE domain_id='%s';";
		$res = database::retrieve($sql, array($domain_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new user_model($row);
		}
		return $ret;
	}

	public function populate_list_activity() {
		$this -> list_activity = activity::list_by_user_id($this -> user_id);
	}

	public function populate_list_activity_template() {
		$this -> list_activity_template = activity_template::list_by_user_id($this -> user_id);
	}

	public function populate_list_attends() {
		$this -> list_attends = attends::list_by_user_id($this -> user_id);
	}

	public function populate_list_task() {
		$this -> list_task = task::list_by_user_id($this -> user_id);
	}

	public function populate_list_task_template() {
		$this -> list_task_template = task_template::list_by_user_id($this -> user_id);
	}

	public function populate_list_teaches() {
		$this -> list_teaches = teaches::list_by_user_id($this -> user_id);
	}

	public function insert() {
		$sql = "INSERT INTO user(user_firstname, user_surname, user_email, domain_id, user_password, user_salt, user_role) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s');";
		return database::insert($sql, array($this -> user_firstname, $this -> user_surname, $this -> user_email, $this -> domain_id, $this -> user_password, $this -> user_salt, $this -> user_role));
	}

	public function update() {
		$sql = "UPDATE user SET user_firstname, user_surname, user_email, domain_id, user_password, user_salt, user_role WHERE user_id ='%s';";
		return database::update($sql, array($this -> user_firstname, $this -> user_surname, $this -> user_email, $this -> domain_id, $this -> user_password, $this -> user_salt, $this -> user_role, $this -> user_id));
	}
}
?>