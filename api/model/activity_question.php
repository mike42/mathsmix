<?php
class activity_question {
	public $aq_id;
	public $atqm_id;
	public $activity_id;
	public $aq_created;
	public $aq_content;

	/* Referenced tables */
	public $activity_template_qm;
	public $activity;

	/* Tables which reference this */
	public $list_activity_question_response;

	public function activity_question($row) {
		$this -> aq_id       = $row['aq_id'];
		$this -> atqm_id     = $row['atqm_id'];
		$this -> activity_id = $row['activity_id'];
		$this -> aq_created  = $row['aq_created'];
		$this -> aq_content  = $row['aq_content'];

		/* Fields from related tables */
		$this -> activity_template_qm = new activity_template_qm($row);
		$this -> activity = new activity($row);
	}

	public static function get($aq_id) {
		$sql = "SELECT * FROM activity_question LEFT JOIN activity_template_qm ON activity_question.atqm_id = activity_template_qm.atqm_id LEFT JOIN activity ON activity_question.activity_id = activity.activity_id LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN user ON activity.user_id = user.user_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE aq_id='%s'";
		$res = Database::retrieve($sql, array($aq_id));
		if($row = Database::get_row($res)) {
			return new activity_question($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public static function list_by_atqm_id($atqm_id) {
		$sql = "SELECT * FROM activity_question LEFT JOIN activity_template_qm ON activity_question.atqm_id = activity_template_qm.atqm_id LEFT JOIN activity ON activity_question.activity_id = activity.activity_id LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN user ON activity.user_id = user.user_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE atqm_id='%s';";
		$res = Database::retrieve($sql, array($atqm_id));
		$ret = array();
		while($row = Database::get_row($res)) {
			$ret[] = new activity_question($row);
		}
		return $ret;
	}

	public static function list_by_activity_id($activity_id) {
		$sql = "SELECT * FROM activity_question LEFT JOIN activity_template_qm ON activity_question.atqm_id = activity_template_qm.atqm_id LEFT JOIN activity ON activity_question.activity_id = activity.activity_id LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN user ON activity.user_id = user.user_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE activity_id='%s';";
		$res = Database::retrieve($sql, array($activity_id));
		$ret = array();
		while($row = Database::get_row($res)) {
			$ret[] = new activity_question($row);
		}
		return $ret;
	}

	public function populate_list_activity() {
		$this -> list_activity_question_response = activity_question_response::list_by_aq_id($this -> aq_id);
	}
}
?>