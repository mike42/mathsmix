<?php
class activity_question_model {
	/* Fields */
	public $aq_id;
	public $atqm_id;
	public $activity_id;
	public $aq_created;
	public $aq_content;

	/* Referenced tables */
	public $activity_template_qm;
	public $activity;

	/* Tables which reference this */
	public $list_activity_question_response = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("activity_template_qm_model");
		core::loadClass("activity_model");
		core::loadClass("activity_question_response_model");
	}

	/**
	 * Create new activity_question based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function activity_question_model(array $row) {
		$this -> aq_id       = isset($row['aq_id'])       ? $row['aq_id']      : '';
		$this -> atqm_id     = isset($row['atqm_id'])     ? $row['atqm_id']    : '';
		$this -> activity_id = isset($row['activity_id']) ? $row['activity_id']: '';
		$this -> aq_created  = isset($row['aq_created'])  ? $row['aq_created'] : '';
		$this -> aq_content  = isset($row['aq_content'])  ? $row['aq_content'] : '';

		/* Fields from related tables */
		$this -> activity_template_qm = new activity_template_qm_model($row);
		$this -> activity = new activity_model($row);
	}

	public static function get($aq_id) {
		$sql = "SELECT * FROM activity_question LEFT JOIN activity_template_qm ON activity_question.atqm_id = activity_template_qm.atqm_id LEFT JOIN activity ON activity_question.activity_id = activity.activity_id LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN user ON activity.user_id = user.user_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE aq_id='%s'";
		$res = database::retrieve($sql, array($aq_id));
		if($row = database::get_row($res)) {
			return new activity_question_model($row);
		}
		return false;
	}

	public static function list_by_atqm_id($atqm_id) {
		$sql = "SELECT * FROM activity_question LEFT JOIN activity_template_qm ON activity_question.atqm_id = activity_template_qm.atqm_id LEFT JOIN activity ON activity_question.activity_id = activity.activity_id LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN user ON activity.user_id = user.user_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE atqm_id='%s';";
		$res = database::retrieve($sql, array($atqm_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new activity_question_model($row);
		}
		return $ret;
	}

	public static function list_by_activity_id($activity_id) {
		$sql = "SELECT * FROM activity_question LEFT JOIN activity_template_qm ON activity_question.atqm_id = activity_template_qm.atqm_id LEFT JOIN activity ON activity_question.activity_id = activity.activity_id LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN user ON activity.user_id = user.user_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE activity_id='%s';";
		$res = database::retrieve($sql, array($activity_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new activity_question_model($row);
		}
		return $ret;
	}

	public function populate_list_activity_question_response() {
		$this -> list_activity_question_response = activity_question_response::list_by_aq_id($this -> aq_id);
	}

	public function insert() {
		$sql = "INSERT INTO activity_question(atqm_id, activity_id, aq_content) VALUES ('%s', '%s', '%s');";
		return database::insert($sql, array($this -> atqm_id, $this -> activity_id, $this -> aq_content));
	}

	public function update() {
		$sql = "UPDATE activity_question SET atqm_id, activity_id, aq_content WHERE aq_id ='%s';";
		return database::update($sql, array($this -> atqm_id, $this -> activity_id, $this -> aq_content, $this -> aq_id));
	}
}
?>