<?php
class task_model {
	/* Fields */
	public $task_id;
	public $user_id;
	public $task_visible_from;
	public $task_due;
	public $task_complete;
	public $task_grade;
	public $attempt_id;
	public $tt_id;

	/* Referenced tables */
	public $user;
	public $task_template;
	public $attempt;

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("user_model");
		core::loadClass("task_template_model");
		core::loadClass("attempt_model");
	}

	/**
	 * Create new task based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function task_model(array $row = array()) {
		$this -> task_id           = isset($row['task_id'])           ? $row['task_id']          : '';
		$this -> user_id           = isset($row['user_id'])           ? $row['user_id']          : '';
		$this -> task_visible_from = isset($row['task_visible_from']) ? $row['task_visible_from']: '';
		$this -> task_due          = isset($row['task_due'])          ? $row['task_due']         : '';
		$this -> task_complete     = isset($row['task_complete'])     ? $row['task_complete']    : '';
		$this -> task_grade        = isset($row['task_grade'])        ? $row['task_grade']       : '';
		$this -> attempt_id        = isset($row['attempt_id'])        ? $row['attempt_id']       : '';
		$this -> tt_id             = isset($row['tt_id'])             ? $row['tt_id']            : '';

		/* Fields from related tables */
		$this -> user = new user_model($row);
		$this -> task_template = new task_template_model($row);
		$this -> attempt = new attempt_model($row);
	}

	public static function get($task_id) {
		$sql = "SELECT * FROM task LEFT JOIN user ON task.user_id = user.user_id LEFT JOIN task_template ON task.tt_id = task_template.tt_id LEFT JOIN attempt ON task.attempt_id = attempt.attempt_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN classes ON task_template.class_id = classes.class_id LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN activity ON attempt.activity_id = activity.activity_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE task.task_id='%s'";
		$res = database::retrieve($sql, array($task_id));
		if($row = database::get_row($res)) {
			return new task_model($row);
		}
		return false;
	}

	public static function list_by_tt_id($tt_id) {
		$sql = "SELECT * FROM task LEFT JOIN user ON task.user_id = user.user_id LEFT JOIN task_template ON task.tt_id = task_template.tt_id LEFT JOIN attempt ON task.attempt_id = attempt.attempt_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN classes ON task_template.class_id = classes.class_id LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN activity ON attempt.activity_id = activity.activity_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE task.tt_id='%s';";
		$res = database::retrieve($sql, array($tt_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new task_model($row);
		}
		return $ret;
	}

	public static function list_by_user_id($user_id) {
		$sql = "SELECT * FROM task LEFT JOIN user ON task.user_id = user.user_id LEFT JOIN task_template ON task.tt_id = task_template.tt_id LEFT JOIN attempt ON task.attempt_id = attempt.attempt_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN classes ON task_template.class_id = classes.class_id LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN activity ON attempt.activity_id = activity.activity_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE task.user_id='%s';";
		$res = database::retrieve($sql, array($user_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new task_model($row);
		}
		return $ret;
	}

	public static function list_by_attempt_id($attempt_id) {
		$sql = "SELECT * FROM task LEFT JOIN user ON task.user_id = user.user_id LEFT JOIN task_template ON task.tt_id = task_template.tt_id LEFT JOIN attempt ON task.attempt_id = attempt.attempt_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN classes ON task_template.class_id = classes.class_id LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN activity ON attempt.activity_id = activity.activity_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE task.attempt_id='%s';";
		$res = database::retrieve($sql, array($attempt_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new task_model($row);
		}
		return $ret;
	}

	public function insert() {
		$sql = "INSERT INTO task(user_id, task_visible_from, task_due, task_complete, task_grade, attempt_id, tt_id) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s');";
		return database::insert($sql, array($this -> user_id, $this -> task_visible_from, $this -> task_due, $this -> task_complete, $this -> task_grade, $this -> attempt_id, $this -> tt_id));
	}

	public function update() {
		$sql = "UPDATE task SET user_id, task_visible_from, task_due, task_complete, task_grade, attempt_id, tt_id WHERE task_id ='%s';";
		return database::update($sql, array($this -> user_id, $this -> task_visible_from, $this -> task_due, $this -> task_complete, $this -> task_grade, $this -> attempt_id, $this -> tt_id, $this -> task_id));
	}
}
?>