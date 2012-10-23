<?php
class task_model {
	/* Fields */
	public $task_id;
	public $user_id;
	public $task_due;
	public $task_complete;
	public $task_grade;
	public $yw_id;
	public $activity_id;
	public $tt_id;

	/* Referenced tables */
	public $user;
	public $activity;
	public $task_template;
	public $year_week;

	/* Tables which reference this */
	public $list_activity_question_response = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("user_model");
		core::loadClass("activity_model");
		core::loadClass("task_template_model");
		core::loadClass("year_week_model");
		core::loadClass("activity_question_response_model");
	}

	/**
	 * Create new task based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function task_model(array $row) {
		$this -> task_id       = isset($row['task_id'])       ? $row['task_id']      : '';
		$this -> user_id       = isset($row['user_id'])       ? $row['user_id']      : '';
		$this -> task_due      = isset($row['task_due'])      ? $row['task_due']     : '';
		$this -> task_complete = isset($row['task_complete']) ? $row['task_complete']: '';
		$this -> task_grade    = isset($row['task_grade'])    ? $row['task_grade']   : '';
		$this -> yw_id         = isset($row['yw_id'])         ? $row['yw_id']        : '';
		$this -> activity_id   = isset($row['activity_id'])   ? $row['activity_id']  : '';
		$this -> tt_id         = isset($row['tt_id'])         ? $row['tt_id']        : '';

		/* Fields from related tables */
		$this -> user = new user_model($row);
		$this -> activity = new activity_model($row);
		$this -> task_template = new task_template_model($row);
		$this -> year_week = new year_week_model($row);
	}

	public static function get($task_id) {
		$sql = "SELECT * FROM task LEFT JOIN user ON task.user_id = user.user_id LEFT JOIN activity ON task.activity_id = activity.activity_id LEFT JOIN task_template ON task.tt_id = task_template.tt_id LEFT JOIN year_week ON task.yw_id = year_week.yw_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN activity_template ON activity.at_id = activity_template.at_id LEFT JOIN year_level ON task_template.yl_id = year_level.yl_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE task_id='%s'";
		$res = database::retrieve($sql, array($task_id));
		if($row = database::get_row($res)) {
			return new task_model($row);
		}
		return false;
	}

	public static function list_by_activity_id($activity_id) {
		$sql = "SELECT * FROM task LEFT JOIN user ON task.user_id = user.user_id LEFT JOIN activity ON task.activity_id = activity.activity_id LEFT JOIN task_template ON task.tt_id = task_template.tt_id LEFT JOIN year_week ON task.yw_id = year_week.yw_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN activity_template ON activity.at_id = activity_template.at_id LEFT JOIN year_level ON task_template.yl_id = year_level.yl_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE activity_id='%s';";
		$res = database::retrieve($sql, array($activity_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new task_model($row);
		}
		return $ret;
	}

	public static function list_by_tt_id($tt_id) {
		$sql = "SELECT * FROM task LEFT JOIN user ON task.user_id = user.user_id LEFT JOIN activity ON task.activity_id = activity.activity_id LEFT JOIN task_template ON task.tt_id = task_template.tt_id LEFT JOIN year_week ON task.yw_id = year_week.yw_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN activity_template ON activity.at_id = activity_template.at_id LEFT JOIN year_level ON task_template.yl_id = year_level.yl_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE tt_id='%s';";
		$res = database::retrieve($sql, array($tt_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new task_model($row);
		}
		return $ret;
	}

	public static function list_by_user_id($user_id) {
		$sql = "SELECT * FROM task LEFT JOIN user ON task.user_id = user.user_id LEFT JOIN activity ON task.activity_id = activity.activity_id LEFT JOIN task_template ON task.tt_id = task_template.tt_id LEFT JOIN year_week ON task.yw_id = year_week.yw_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN activity_template ON activity.at_id = activity_template.at_id LEFT JOIN year_level ON task_template.yl_id = year_level.yl_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE user_id='%s';";
		$res = database::retrieve($sql, array($user_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new task_model($row);
		}
		return $ret;
	}

	public static function list_by_yw_id($yw_id) {
		$sql = "SELECT * FROM task LEFT JOIN user ON task.user_id = user.user_id LEFT JOIN activity ON task.activity_id = activity.activity_id LEFT JOIN task_template ON task.tt_id = task_template.tt_id LEFT JOIN year_week ON task.yw_id = year_week.yw_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN activity_template ON activity.at_id = activity_template.at_id LEFT JOIN year_level ON task_template.yl_id = year_level.yl_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE yw_id='%s';";
		$res = database::retrieve($sql, array($yw_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new task_model($row);
		}
		return $ret;
	}

	public function populate_list_activity_question_response() {
		$this -> list_activity_question_response = activity_question_response::list_by_task_id($this -> task_id);
	}

	public function insert() {
		$sql = "INSERT INTO task(user_id, task_due, task_complete, task_grade, yw_id, activity_id, tt_id) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s');";
		return database::insert($sql, array($this -> user_id, $this -> task_due, $this -> task_complete, $this -> task_grade, $this -> yw_id, $this -> activity_id, $this -> tt_id));
	}

	public function update() {
		$sql = "UPDATE task SET user_id, task_due, task_complete, task_grade, yw_id, activity_id, tt_id WHERE task_id ='%s';";
		return database::update($sql, array($this -> user_id, $this -> task_due, $this -> task_complete, $this -> task_grade, $this -> yw_id, $this -> activity_id, $this -> tt_id, $this -> task_id));
	}
}
?>