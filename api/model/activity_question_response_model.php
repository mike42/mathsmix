<?php
class activity_question_response_model {
	/* Fields */
	public $aq_id;
	public $attempt_id;
	public $aqr_marks;
	public $aqr_created;
	public $aqr_response;

	/* Referenced tables */
	public $activity_question;
	public $attempt;

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("activity_question_model");
		core::loadClass("attempt_model");
	}

	/**
	 * Create new activity_question_response based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function activity_question_response_model(array $row = array()) {
		$this -> aq_id        = isset($row['aq_id'])        ? $row['aq_id']       : '';
		$this -> attempt_id   = isset($row['attempt_id'])   ? $row['attempt_id']  : '';
		$this -> aqr_marks    = isset($row['aqr_marks'])    ? $row['aqr_marks']   : '';
		$this -> aqr_created  = isset($row['aqr_created'])  ? $row['aqr_created'] : '';
		$this -> aqr_response = isset($row['aqr_response']) ? $row['aqr_response']: '';

		/* Fields from related tables */
		$this -> activity_question = new activity_question_model($row);
		$this -> attempt = new attempt_model($row);
	}

	public static function get($aq_id, $attempt_id) {
		$sql = "SELECT * FROM activity_question_response LEFT JOIN activity_question ON activity_question_response.aq_id = activity_question.aq_id LEFT JOIN attempt ON activity_question_response.attempt_id = attempt.attempt_id LEFT JOIN activity_template_qm ON activity_question.atqm_id = activity_template_qm.atqm_id LEFT JOIN activity ON activity_question.activity_id = activity.activity_id LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN user ON activity.user_id = user.user_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE activity_question_response.aq_id='%s' AND activity_question_response.attempt_id='%s'";
		$res = database::retrieve($sql, array($aq_id, $attempt_id));
		if($row = database::get_row($res)) {
			return new activity_question_response_model($row);
		}
		return false;
	}

	public static function list_by_aq_id($aq_id) {
		$sql = "SELECT * FROM activity_question_response LEFT JOIN activity_question ON activity_question_response.aq_id = activity_question.aq_id LEFT JOIN attempt ON activity_question_response.attempt_id = attempt.attempt_id LEFT JOIN activity_template_qm ON activity_question.atqm_id = activity_template_qm.atqm_id LEFT JOIN activity ON activity_question.activity_id = activity.activity_id LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN user ON activity.user_id = user.user_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE activity_question_response.aq_id='%s';";
		$res = database::retrieve($sql, array($aq_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new activity_question_response_model($row);
		}
		return $ret;
	}

	public static function list_by_attempt_id($attempt_id) {
		$sql = "SELECT * FROM activity_question_response LEFT JOIN activity_question ON activity_question_response.aq_id = activity_question.aq_id LEFT JOIN attempt ON activity_question_response.attempt_id = attempt.attempt_id LEFT JOIN activity_template_qm ON activity_question.atqm_id = activity_template_qm.atqm_id LEFT JOIN activity ON activity_question.activity_id = activity.activity_id LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN user ON activity.user_id = user.user_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE activity_question_response.attempt_id='%s';";
		$res = database::retrieve($sql, array($attempt_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new activity_question_response_model($row);
		}
		return $ret;
	}

	public function insert() {
		$sql = "INSERT INTO activity_question_response(aq_id, attempt_id, aqr_marks, aqr_response) VALUES ('%s', '%s', '%s', '%s');";
		return database::insert($sql, array($this -> aq_id, $this -> attempt_id, $this -> aqr_marks, $this -> aqr_response));
	}

	public function update() {
		$sql = "UPDATE activity_question_response SET aqr_marks, aqr_response WHERE aq_id ='%s'ANDattempt_id ='%s';";
		return database::update($sql, array($this -> aqr_marks, $this -> aqr_response, $this -> aq_id, $this -> attempt_id));
	}
}
?>