<?php
class activity_template_qm {
	public $atqm_id;
	public $at_id;
	public $atqm_no;
	public $qu_id;
	public $atqm_created;
	public $atqm_marks;

	/* Referenced tables */
	public $activity_template;
	public $question_usage;

	/* Tables which reference this */
	public $list_activity_question;

	public function activity_template_qm($row) {
		$this -> atqm_id      = $row['atqm_id'];
		$this -> at_id        = $row['at_id'];
		$this -> atqm_no      = $row['atqm_no'];
		$this -> qu_id        = $row['qu_id'];
		$this -> atqm_created = $row['atqm_created'];
		$this -> atqm_marks   = $row['atqm_marks'];

		/* Fields from related tables */
		$this -> activity_template = new activity_template($row);
		$this -> question_usage = new question_usage($row);
	}

	public static function get($atqm_id) {
		$sql = "SELECT * FROM activity_template_qm LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN user ON activity_template.user_id = user.user_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE atqm_id='%s'";
		$res = Database::retrieve($sql, array($atqm_id))
		if($row = Database::get_row($res) {
			return new activity_template_qm($row);
		}
		return false;
	}

	public static function get_by_activity_template($at_id, $atqm_no) {
		$sql = "SELECT * FROM activity_template_qm LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN user ON activity_template.user_id = user.user_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE at_id='%s' AND atqm_no='%s'";
		$res = Database::retrieve($sql, array($at_id, $atqm_no))
		if($row = Database::get_row($res) {
			return new activity_template_qm($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public static function list_by_qu_id($qu_id) {
		$sql = "SELECT * FROM activity_template_qm LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN user ON activity_template.user_id = user.user_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE qu_id='%s';";
		$res = Database::retrieve($sql, array($qu_id))
		$ret = array();
		while($row = Database::get_row($res) {
			$ret[] = new activity_template_qm($row);
		}
		return $ret;
	}

	public static function list_by_at_id($at_id) {
		$sql = "SELECT * FROM activity_template_qm LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN user ON activity_template.user_id = user.user_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE at_id='%s';";
		$res = Database::retrieve($sql, array($at_id))
		$ret = array();
		while($row = Database::get_row($res) {
			$ret[] = new activity_template_qm($row);
		}
		return $ret;
	}

	public function populate_list_question_usage() {
		$this -> list_activity_question = activity_question::list_by_atqm_id($this -> atqm_id);
	}
}
?>