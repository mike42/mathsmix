<?php
class activity_model {
	/* Fields */
	public $activity_id;
	public $at_id;
	public $user_id;
	public $activity_created;
	public $activity_isgen;

	/* Referenced tables */
	public $activity_template;
	public $user;

	/* Tables which reference this */
	public $list_activity_question    = array();
	public $list_task                 = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("activity_template_model");
		core::loadClass("user_model");
		core::loadClass("activity_question_model");
		core::loadClass("task_model");
	}

	/**
	 * Create new activity based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function activity_model(array $row = array()) {
		$this -> activity_id      = isset($row['activity_id'])      ? $row['activity_id']     : '';
		$this -> at_id            = isset($row['at_id'])            ? $row['at_id']           : '';
		$this -> user_id          = isset($row['user_id'])          ? $row['user_id']         : '';
		$this -> activity_created = isset($row['activity_created']) ? $row['activity_created']: '';
		$this -> activity_isgen   = isset($row['activity_isgen'])   ? $row['activity_isgen']  : '';

		/* Fields from related tables */
		$this -> activity_template = new activity_template_model($row);
		$this -> user = new user_model($row);
	}

	public static function get($activity_id) {
		$sql = "SELECT * FROM activity LEFT JOIN activity_template ON activity.at_id = activity_template.at_id LEFT JOIN user ON activity.user_id = user.user_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE activity.activity_id='%s'";
		$res = database::retrieve($sql, array($activity_id));
		if($row = database::get_row($res)) {
			return new activity_model($row);
		}
		return false;
	}

	public static function list_by_at_id($at_id) {
		$sql = "SELECT * FROM activity LEFT JOIN activity_template ON activity.at_id = activity_template.at_id LEFT JOIN user ON activity.user_id = user.user_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE activity.at_id='%s';";
		$res = database::retrieve($sql, array($at_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new activity_model($row);
		}
		return $ret;
	}

	public static function list_by_user_id($user_id) {
		$sql = "SELECT * FROM activity LEFT JOIN activity_template ON activity.at_id = activity_template.at_id LEFT JOIN user ON activity.user_id = user.user_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE activity.user_id='%s';";
		$res = database::retrieve($sql, array($user_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new activity_model($row);
		}
		return $ret;
	}

	public function populate_list_activity_question() {
		$this -> list_activity_question = activity_question_model::list_by_activity_id($this -> activity_id);
	}

	public function populate_list_task() {
		$this -> list_task = task_model::list_by_activity_id($this -> activity_id);
	}

	public function insert() {
		$sql = "INSERT INTO activity(at_id, user_id, activity_isgen) VALUES ('%s', '%s', '%s');";
		return database::insert($sql, array($this -> at_id, $this -> user_id, $this -> activity_isgen));
	}

	public function update() {
		$sql = "UPDATE activity SET at_id, user_id, activity_isgen WHERE activity_id ='%s';";
		return database::update($sql, array($this -> at_id, $this -> user_id, $this -> activity_isgen, $this -> activity_id));
	}
}
?>