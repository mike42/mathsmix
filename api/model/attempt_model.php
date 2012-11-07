<?php
class attempt_model {
	/* Fields */
	public $attempt_id;
	public $activity_id;
	public $attempt_created;

	/* Referenced tables */
	public $activity;

	/* Tables which reference this */
	public $list_activity_question_response = array();
	public $list_task                 = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("activity_model");
		core::loadClass("activity_question_response_model");
		core::loadClass("task_model");
	}

	/**
	 * Create new attempt based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function attempt_model(array $row = array()) {
		$this -> attempt_id      = isset($row['attempt_id'])      ? $row['attempt_id']     : '';
		$this -> activity_id     = isset($row['activity_id'])     ? $row['activity_id']    : '';
		$this -> attempt_created = isset($row['attempt_created']) ? $row['attempt_created']: '';

		/* Fields from related tables */
		$this -> activity = new activity_model($row);
	}

	public static function get($attempt_id) {
		$sql = "SELECT * FROM attempt LEFT JOIN activity ON attempt.activity_id = activity.activity_id LEFT JOIN activity_template ON activity.at_id = activity_template.at_id LEFT JOIN user ON activity.user_id = user.user_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE attempt.attempt_id='%s'";
		$res = database::retrieve($sql, array($attempt_id));
		if($row = database::get_row($res)) {
			return new attempt_model($row);
		}
		return false;
	}

	public static function list_by_activity_id($activity_id) {
		$sql = "SELECT * FROM attempt LEFT JOIN activity ON attempt.activity_id = activity.activity_id LEFT JOIN activity_template ON activity.at_id = activity_template.at_id LEFT JOIN user ON activity.user_id = user.user_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE attempt.activity_id='%s';";
		$res = database::retrieve($sql, array($activity_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new attempt_model($row);
		}
		return $ret;
	}

	public function populate_list_activity_question_response() {
		$this -> list_activity_question_response = activity_question_response_model::list_by_attempt_id($this -> attempt_id);
	}

	public function populate_list_task() {
		$this -> list_task = task_model::list_by_attempt_id($this -> attempt_id);
	}

	public function insert() {
		$sql = "INSERT INTO attempt(activity_id) VALUES ('%s');";
		return database::insert($sql, array($this -> activity_id));
	}

	public function update() {
		$sql = "UPDATE attempt SET activity_id WHERE attempt_id ='%s';";
		return database::update($sql, array($this -> activity_id, $this -> attempt_id));
	}
}
?>