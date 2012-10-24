<?php
class activity_template_qm_model {
	/* Fields */
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
	public $list_activity_question    = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("activity_template_model");
		core::loadClass("question_usage_model");
		core::loadClass("activity_question_model");
	}

	/**
	 * Create new activity_template_qm based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function activity_template_qm_model(array $row = array()) {
		$this -> atqm_id      = isset($row['atqm_id'])      ? $row['atqm_id']     : '';
		$this -> at_id        = isset($row['at_id'])        ? $row['at_id']       : '';
		$this -> atqm_no      = isset($row['atqm_no'])      ? $row['atqm_no']     : '';
		$this -> qu_id        = isset($row['qu_id'])        ? $row['qu_id']       : '';
		$this -> atqm_created = isset($row['atqm_created']) ? $row['atqm_created']: '';
		$this -> atqm_marks   = isset($row['atqm_marks'])   ? $row['atqm_marks']  : '';

		/* Fields from related tables */
		$this -> activity_template = new activity_template_model($row);
		$this -> question_usage = new question_usage_model($row);
	}

	public static function get($atqm_id) {
		$sql = "SELECT * FROM activity_template_qm LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN user ON activity_template.user_id = user.user_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE activity_template_qm.atqm_id='%s'";
		$res = database::retrieve($sql, array($atqm_id));
		if($row = database::get_row($res)) {
			return new activity_template_qm_model($row);
		}
		return false;
	}

	public static function get_by_activity_template($at_id, $atqm_no) {
		$sql = "SELECT * FROM activity_template_qm LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN user ON activity_template.user_id = user.user_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE activity_template_qm.at_id='%s' AND activity_template_qm.atqm_no='%s'";
		$res = database::retrieve($sql, array($at_id, $atqm_no));
		if($row = database::get_row($res)) {
			return new activity_template_qm_model($row);
		}
		return false;
	}

	public static function list_by_qu_id($qu_id) {
		$sql = "SELECT * FROM activity_template_qm LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN user ON activity_template.user_id = user.user_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE activity_template_qm.qu_id='%s';";
		$res = database::retrieve($sql, array($qu_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new activity_template_qm_model($row);
		}
		return $ret;
	}

	public static function list_by_at_id($at_id) {
		$sql = "SELECT * FROM activity_template_qm LEFT JOIN activity_template ON activity_template_qm.at_id = activity_template.at_id LEFT JOIN question_usage ON activity_template_qm.qu_id = question_usage.qu_id LEFT JOIN user ON activity_template.user_id = user.user_id LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE activity_template_qm.at_id='%s';";
		$res = database::retrieve($sql, array($at_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new activity_template_qm_model($row);
		}
		return $ret;
	}

	public function populate_list_activity_question() {
		$this -> list_activity_question = activity_question_model::list_by_atqm_id($this -> atqm_id);
	}

	public function insert() {
		$sql = "INSERT INTO activity_template_qm(at_id, atqm_no, qu_id, atqm_marks) VALUES ('%s', '%s', '%s', '%s');";
		return database::insert($sql, array($this -> at_id, $this -> atqm_no, $this -> qu_id, $this -> atqm_marks));
	}

	public function update() {
		$sql = "UPDATE activity_template_qm SET at_id, atqm_no, qu_id, atqm_marks WHERE atqm_id ='%s';";
		return database::update($sql, array($this -> at_id, $this -> atqm_no, $this -> qu_id, $this -> atqm_marks, $this -> atqm_id));
	}
}
?>