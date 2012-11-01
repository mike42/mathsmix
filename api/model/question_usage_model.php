<?php
class question_usage_model {
	/* Fields */
	public $qu_id;
	public $qu_comment;
	public $qv_id;
	public $qu_content;
	public $qm_id;
	public $qu_created;

	/* Referenced tables */
	public $question_viewer;
	public $question_maker;

	/* Tables which reference this */
	public $list_activity_template_qm = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("question_viewer_model");
		core::loadClass("question_maker_model");
		core::loadClass("activity_template_qm_model");
	}

	/**
	 * Create new question_usage based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function question_usage_model(array $row = array()) {
		$this -> qu_id      = isset($row['qu_id'])      ? $row['qu_id']     : '';
		$this -> qu_comment = isset($row['qu_comment']) ? $row['qu_comment']: '';
		$this -> qv_id      = isset($row['qv_id'])      ? $row['qv_id']     : '';
		$this -> qu_content = isset($row['qu_content']) ? $row['qu_content']: '';
		$this -> qm_id      = isset($row['qm_id'])      ? $row['qm_id']     : '';
		$this -> qu_created = isset($row['qu_created']) ? $row['qu_created']: '';

		/* Fields from related tables */
		$this -> question_viewer = new question_viewer_model($row);
		$this -> question_maker = new question_maker_model($row);
	}

	public static function get($qu_id) {
		$sql = "SELECT * FROM question_usage LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id WHERE question_usage.qu_id='%s'";
		$res = database::retrieve($sql, array($qu_id));
		if($row = database::get_row($res)) {
			return new question_usage_model($row);
		}
		return false;
	}

	public static function list_by_qm_id($qm_id) {
		$sql = "SELECT * FROM question_usage LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id WHERE question_usage.qm_id='%s';";
		$res = database::retrieve($sql, array($qm_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new question_usage_model($row);
		}
		return $ret;
	}

	public static function list_by_qv_id($qv_id) {
		$sql = "SELECT * FROM question_usage LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id WHERE question_usage.qv_id='%s';";
		$res = database::retrieve($sql, array($qv_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new question_usage_model($row);
		}
		return $ret;
	}

	public function populate_list_activity_template_qm() {
		$this -> list_activity_template_qm = activity_template_qm_model::list_by_qu_id($this -> qu_id);
	}

	public function insert() {
		$sql = "INSERT INTO question_usage(qu_comment, qv_id, qu_content, qm_id) VALUES ('%s', '%s', '%s', '%s');";
		return database::insert($sql, array($this -> qu_comment, $this -> qv_id, $this -> qu_content, $this -> qm_id));
	}

	public function update() {
		$sql = "UPDATE question_usage SET qu_comment, qv_id, qu_content, qm_id WHERE qu_id ='%s';";
		return database::update($sql, array($this -> qu_comment, $this -> qv_id, $this -> qu_content, $this -> qm_id, $this -> qu_id));
	}
	
	/* Non-generated functions */
	public static function search_by_comment($keyword) {
		$keyword = "%" . str_replace("%", "\%", $keyword) . "%";
		$sql = "SELECT * FROM question_usage LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id WHERE qu_comment LIKE '%s';";
		$res = database::retrieve($sql, array($keyword));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new question_usage_model($row);
		}
		return $ret;
	}
}
?>