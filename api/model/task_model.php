<?php
class task {
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
	public $list_activity_question_response;

	public function task($row) {
		$this -> task_id       = $row['task_id'];
		$this -> user_id       = $row['user_id'];
		$this -> task_due      = $row['task_due'];
		$this -> task_complete = $row['task_complete'];
		$this -> task_grade    = $row['task_grade'];
		$this -> yw_id         = $row['yw_id'];
		$this -> activity_id   = $row['activity_id'];
		$this -> tt_id         = $row['tt_id'];

		/* Fields from related tables */
		$this -> user = new user($row);
		$this -> activity = new activity($row);
		$this -> task_template = new task_template($row);
		$this -> year_week = new year_week($row);
	}

	public static function get($task_id) {
		$sql = "SELECT * FROM task LEFT JOIN user ON task.user_id = user.user_id LEFT JOIN activity ON task.activity_id = activity.activity_id LEFT JOIN task_template ON task.tt_id = task_template.tt_id LEFT JOIN year_week ON task.yw_id = year_week.yw_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN activity_template ON activity.at_id = activity_template.at_id LEFT JOIN year_level ON task_template.yl_id = year_level.yl_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE task_id='%s'";
		$res = Database::retrieve($sql, array($task_id));
		if($row = Database::get_row($res)) {
			return new task($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public static function list_by_activity_id($activity_id) {
		$sql = "SELECT * FROM task LEFT JOIN user ON task.user_id = user.user_id LEFT JOIN activity ON task.activity_id = activity.activity_id LEFT JOIN task_template ON task.tt_id = task_template.tt_id LEFT JOIN year_week ON task.yw_id = year_week.yw_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN activity_template ON activity.at_id = activity_template.at_id LEFT JOIN year_level ON task_template.yl_id = year_level.yl_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE activity_id='%s';";
		$res = Database::retrieve($sql, array($activity_id));
		$ret = array();
		while($row = Database::get_row($res)) {
			$ret[] = new task($row);
		}
		return $ret;
	}

	public static function list_by_tt_id($tt_id) {
		$sql = "SELECT * FROM task LEFT JOIN user ON task.user_id = user.user_id LEFT JOIN activity ON task.activity_id = activity.activity_id LEFT JOIN task_template ON task.tt_id = task_template.tt_id LEFT JOIN year_week ON task.yw_id = year_week.yw_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN activity_template ON activity.at_id = activity_template.at_id LEFT JOIN year_level ON task_template.yl_id = year_level.yl_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE tt_id='%s';";
		$res = Database::retrieve($sql, array($tt_id));
		$ret = array();
		while($row = Database::get_row($res)) {
			$ret[] = new task($row);
		}
		return $ret;
	}

	public static function list_by_user_id($user_id) {
		$sql = "SELECT * FROM task LEFT JOIN user ON task.user_id = user.user_id LEFT JOIN activity ON task.activity_id = activity.activity_id LEFT JOIN task_template ON task.tt_id = task_template.tt_id LEFT JOIN year_week ON task.yw_id = year_week.yw_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN activity_template ON activity.at_id = activity_template.at_id LEFT JOIN year_level ON task_template.yl_id = year_level.yl_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE user_id='%s';";
		$res = Database::retrieve($sql, array($user_id));
		$ret = array();
		while($row = Database::get_row($res)) {
			$ret[] = new task($row);
		}
		return $ret;
	}

	public static function list_by_yw_id($yw_id) {
		$sql = "SELECT * FROM task LEFT JOIN user ON task.user_id = user.user_id LEFT JOIN activity ON task.activity_id = activity.activity_id LEFT JOIN task_template ON task.tt_id = task_template.tt_id LEFT JOIN year_week ON task.yw_id = year_week.yw_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN activity_template ON activity.at_id = activity_template.at_id LEFT JOIN year_level ON task_template.yl_id = year_level.yl_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE yw_id='%s';";
		$res = Database::retrieve($sql, array($yw_id));
		$ret = array();
		while($row = Database::get_row($res)) {
			$ret[] = new task($row);
		}
		return $ret;
	}

	public function populate_list_year_week() {
		$this -> list_activity_question_response = activity_question_response::list_by_task_id($this -> task_id);
	}
}
?>