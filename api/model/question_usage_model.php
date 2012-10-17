<?php
class question_usage {
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
	public $list_activity_template_qm;

	public function question_usage($row) {
		$this -> qu_id      = $row['qu_id'];
		$this -> qu_comment = $row['qu_comment'];
		$this -> qv_id      = $row['qv_id'];
		$this -> qu_content = $row['qu_content'];
		$this -> qm_id      = $row['qm_id'];
		$this -> qu_created = $row['qu_created'];

		/* Fields from related tables */
		$this -> question_viewer = new question_viewer($row);
		$this -> question_maker = new question_maker($row);
	}

	public static function get($qu_id) {
		$sql = "SELECT * FROM question_usage LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id WHERE qu_id='%s'";
		$res = Database::retrieve($sql, array($qu_id));
		if($row = Database::get_row($res)) {
			return new question_usage($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public static function list_by_qm_id($qm_id) {
		$sql = "SELECT * FROM question_usage LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id WHERE qm_id='%s';";
		$res = Database::retrieve($sql, array($qm_id));
		$ret = array();
		while($row = Database::get_row($res)) {
			$ret[] = new question_usage($row);
		}
		return $ret;
	}

	public static function list_by_qv_id($qv_id) {
		$sql = "SELECT * FROM question_usage LEFT JOIN question_viewer ON question_usage.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON question_usage.qm_id = question_maker.qm_id WHERE qv_id='%s';";
		$res = Database::retrieve($sql, array($qv_id));
		$ret = array();
		while($row = Database::get_row($res)) {
			$ret[] = new question_usage($row);
		}
		return $ret;
	}

	public function populate_list_question_maker() {
		$this -> list_activity_template_qm = activity_template_qm::list_by_qu_id($this -> qu_id);
	}
}
?>