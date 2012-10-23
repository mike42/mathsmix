<?php
class activity_question_response_model {
	/* Fields */
	public $aq_id;
	public $task_id;
	public $aqr_marks;
	public $aqr_created;
	public $aqr_response;

	/* Referenced tables */
	public $activity_question;
	public $task;

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("activity_question_model");
		core::loadClass("task_model");
	}

	/**
	 * Create new activity_question_response based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function activity_question_response_model(array $row) {
		$this -> aq_id        = isset($row['aq_id'])        ? $row['aq_id']       : '';
		$this -> task_id      = isset($row['task_id'])      ? $row['task_id']     : '';
		$this -> aqr_marks    = isset($row['aqr_marks'])    ? $row['aqr_marks']   : '';
		$this -> aqr_created  = isset($row['aqr_created'])  ? $row['aqr_created'] : '';
		$this -> aqr_response = isset($row['aqr_response']) ? $row['aqr_response']: '';

		/* Fields from related tables */
		$this -> activity_question = new activity_question_model($row);
		$this -> task = new task_model($row);
	}

	public static function get($aq_id, $task_id) {
		$sql = "SELECT * FROM activity_question_response LEFT JOIN activity_question ON activity_question_response.aq_id = activity_question.aq_id LEFT JOIN task ON activity_question_response.task_id = task.task_id LEFT JOIN activity_template_qm ON activity_question.atqm_id = activity_template_qm.atqm_id LEFT JOIN activity ON activity_question.activity_id = activity.activity_id LEFT JOIN user ON task.user_id = user.user_id LEFT JOIN task_template ON task.tt_id = task_template.tt_id LEFT JOIN year_week ON task.yw_id = year_week.yw_id LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN year_level ON task_template.yl_id = year_level.yl_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE aq_id='%s' AND task_id='%s'";
		$res = database::retrieve($sql, array($aq_id, $task_id));
		if($row = database::get_row($res)) {
			return new activity_question_response_model($row);
		}
		return false;
	}

	public static function list_by_aq_id($aq_id) {
		$sql = "SELECT * FROM activity_question_response LEFT JOIN activity_question ON activity_question_response.aq_id = activity_question.aq_id LEFT JOIN task ON activity_question_response.task_id = task.task_id LEFT JOIN activity_template_qm ON activity_question.atqm_id = activity_template_qm.atqm_id LEFT JOIN activity ON activity_question.activity_id = activity.activity_id LEFT JOIN user ON task.user_id = user.user_id LEFT JOIN task_template ON task.tt_id = task_template.tt_id LEFT JOIN year_week ON task.yw_id = year_week.yw_id LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN year_level ON task_template.yl_id = year_level.yl_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE aq_id='%s';";
		$res = database::retrieve($sql, array($aq_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new activity_question_response_model($row);
		}
		return $ret;
	}

	public static function list_by_task_id($task_id) {
		$sql = "SELECT * FROM activity_question_response LEFT JOIN activity_question ON activity_question_response.aq_id = activity_question.aq_id LEFT JOIN task ON activity_question_response.task_id = task.task_id LEFT JOIN activity_template_qm ON activity_question.atqm_id = activity_template_qm.atqm_id LEFT JOIN activity ON activity_question.activity_id = activity.activity_id LEFT JOIN user ON task.user_id = user.user_id LEFT JOIN task_template ON task.tt_id = task_template.tt_id LEFT JOIN year_week ON task.yw_id = year_week.yw_id LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN year_level ON task_template.yl_id = year_level.yl_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE task_id='%s';";
		$res = database::retrieve($sql, array($task_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new activity_question_response_model($row);
		}
		return $ret;
	}

	public function insert() {
		$sql = "INSERT INTO activity_question_response(aq_id, task_id, aqr_marks, aqr_response) VALUES ('%s', '%s', '%s', '%s');";
		return database::insert($sql, array($this -> aq_id, $this -> task_id, $this -> aqr_marks, $this -> aqr_response));
	}

	public function update() {
		$sql = "UPDATE activity_question_response SET aqr_marks, aqr_response WHERE aq_id ='%s'ANDtask_id ='%s';";
		return database::update($sql, array($this -> aqr_marks, $this -> aqr_response, $this -> aq_id, $this -> task_id));
	}
}
?>