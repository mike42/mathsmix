<?php
class format_option {
	public $qv_id;
	public $qm_id;

	/* Referenced tables */
	public $question_viewer;
	public $question_maker;

	public function format_option($row) {
		$this -> qv_id = $row['qv_id'];
		$this -> qm_id = $row['qm_id'];

		/* Fields from related tables */
		$this -> question_viewer = new question_viewer($row);
		$this -> question_maker = new question_maker($row);
	}

	public static function get($qv_id, $qm_id) {
		$sql = "SELECT * FROM format_option LEFT JOIN question_viewer ON format_option.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON format_option.qm_id = question_maker.qm_id WHERE qv_id='%s' AND qm_id='%s'";
		$res = Database::retrieve($sql, array($qv_id, $qm_id))
		if($row = Database::get_row($res) {
			return new format_option($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public static function list_by_qv_id($qv_id) {
		$sql = "SELECT * FROM format_option LEFT JOIN question_viewer ON format_option.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON format_option.qm_id = question_maker.qm_id WHERE qv_id='%s';";
		$res = Database::retrieve($sql, array($qv_id))
		$ret = array();
		while($row = Database::get_row($res) {
			$ret[] = new format_option($row);
		}
		return $ret;
	}

	public static function list_by_qm_id($qm_id) {
		$sql = "SELECT * FROM format_option LEFT JOIN question_viewer ON format_option.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON format_option.qm_id = question_maker.qm_id WHERE qm_id='%s';";
		$res = Database::retrieve($sql, array($qm_id))
		$ret = array();
		while($row = Database::get_row($res) {
			$ret[] = new format_option($row);
		}
		return $ret;
	}
}
?>