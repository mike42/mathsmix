<?php
class activity_template_model {
	/* Fields */
	public $at_id;
	public $at_type;
	public $at_name;
	public $at_created;
	public $user_id;

	/* Referenced tables */
	public $user;

	/* Tables which reference this */
	public $list_activity             = array();
	public $list_activity_template_qm = array();
	public $list_task_template        = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("user_model");
		core::loadClass("activity_model");
		core::loadClass("activity_template_qm_model");
		core::loadClass("task_template_model");
	}

	/**
	 * Create new activity_template based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function activity_template_model(array $row = array()) {
		$this -> at_id      = isset($row['at_id'])      ? $row['at_id']     : '';
		$this -> at_type    = isset($row['at_type'])    ? $row['at_type']   : '';
		$this -> at_name    = isset($row['at_name'])    ? $row['at_name']   : '';
		$this -> at_created = isset($row['at_created']) ? $row['at_created']: '';
		$this -> user_id    = isset($row['user_id'])    ? $row['user_id']   : '';

		/* Fields from related tables */
		$this -> user = new user_model($row);
	}

	public static function get($at_id) {
		$sql = "SELECT * FROM activity_template LEFT JOIN user ON activity_template.user_id = user.user_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE activity_template.at_id='%s'";
		$res = database::retrieve($sql, array($at_id));
		if($row = database::get_row($res)) {
			return new activity_template_model($row);
		}
		return false;
	}

	public static function list_by_user_id($user_id) {
		$sql = "SELECT * FROM activity_template LEFT JOIN user ON activity_template.user_id = user.user_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE activity_template.user_id='%s';";
		$res = database::retrieve($sql, array($user_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new activity_template_model($row);
		}
		return $ret;
	}

	public function populate_list_activity() {
		$this -> list_activity = activity_model::list_by_at_id($this -> at_id);
	}

	public function populate_list_activity_template_qm() {
		$this -> list_activity_template_qm = activity_template_qm_model::list_by_at_id($this -> at_id);
	}

	public function populate_list_task_template() {
		$this -> list_task_template = task_template_model::list_by_at_id($this -> at_id);
	}

	public function insert() {
		$sql = "INSERT INTO activity_template(at_type, at_name, user_id) VALUES ('%s', '%s', '%s');";
		return database::insert($sql, array($this -> at_type, $this -> at_name, $this -> user_id));
	}

	public function update() {
		$sql = "UPDATE activity_template SET at_type, at_name, user_id WHERE at_id ='%s';";
		return database::update($sql, array($this -> at_type, $this -> at_name, $this -> user_id, $this -> at_id));
	}
}
?>