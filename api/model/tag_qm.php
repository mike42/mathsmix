<?php
class tag_qm {
	public $qm_id;
	public $tag_id;

	/* Referenced tables */
	public $question_maker;
	public $tag;

	public function tag_qm($row) {
		$this -> qm_id  = $row['qm_id'];
		$this -> tag_id = $row['tag_id'];

		/* Fields from related tables */
		$this -> question_maker = new question_maker($row);
		$this -> tag = new tag($row);
	}

	public static function get($qm_id, $tag_id) {
		$sql = "SELECT * FROM tag_qm LEFT JOIN question_maker ON tag_qm.qm_id = question_maker.qm_id LEFT JOIN tag ON tag_qm.tag_id = tag.tag_id WHERE qm_id='%s' AND tag_id='%s'";
		$res = Database::retrieve($sql, array($qm_id, $tag_id))
		if($row = Database::get_row($res) {
			return new tag_qm($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public static function list_by_qm_id($qm_id) {
		$sql = "SELECT * FROM tag_qm LEFT JOIN question_maker ON tag_qm.qm_id = question_maker.qm_id LEFT JOIN tag ON tag_qm.tag_id = tag.tag_id WHERE qm_id='%s';";
		$res = Database::retrieve($sql, array($qm_id))
		$ret = array();
		while($row = Database::get_row($res) {
			$ret[] = new tag_qm($row);
		}
		return $ret;
	}

	public static function list_by_tag_id($tag_id) {
		$sql = "SELECT * FROM tag_qm LEFT JOIN question_maker ON tag_qm.qm_id = question_maker.qm_id LEFT JOIN tag ON tag_qm.tag_id = tag.tag_id WHERE tag_id='%s';";
		$res = Database::retrieve($sql, array($tag_id))
		$ret = array();
		while($row = Database::get_row($res) {
			$ret[] = new tag_qm($row);
		}
		return $ret;
	}
}
?>