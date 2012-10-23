<?php
class tag_qm_model {
	/* Fields */
	public $qm_id;
	public $tag_id;

	/* Referenced tables */
	public $question_maker;
	public $tag;

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("question_maker_model");
		core::loadClass("tag_model");
	}

	/**
	 * Create new tag_qm based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function tag_qm_model(array $row = array()) {
		$this -> qm_id  = isset($row['qm_id'])  ? $row['qm_id'] : '';
		$this -> tag_id = isset($row['tag_id']) ? $row['tag_id']: '';

		/* Fields from related tables */
		$this -> question_maker = new question_maker_model($row);
		$this -> tag = new tag_model($row);
	}

	public static function get($qm_id, $tag_id) {
		$sql = "SELECT * FROM tag_qm LEFT JOIN question_maker ON tag_qm.qm_id = question_maker.qm_id LEFT JOIN tag ON tag_qm.tag_id = tag.tag_id WHERE qm_id='%s' AND tag_id='%s'";
		$res = database::retrieve($sql, array($qm_id, $tag_id));
		if($row = database::get_row($res)) {
			return new tag_qm_model($row);
		}
		return false;
	}

	public static function list_by_qm_id($qm_id) {
		$sql = "SELECT * FROM tag_qm LEFT JOIN question_maker ON tag_qm.qm_id = question_maker.qm_id LEFT JOIN tag ON tag_qm.tag_id = tag.tag_id WHERE qm_id='%s';";
		$res = database::retrieve($sql, array($qm_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new tag_qm_model($row);
		}
		return $ret;
	}

	public static function list_by_tag_id($tag_id) {
		$sql = "SELECT * FROM tag_qm LEFT JOIN question_maker ON tag_qm.qm_id = question_maker.qm_id LEFT JOIN tag ON tag_qm.tag_id = tag.tag_id WHERE tag_id='%s';";
		$res = database::retrieve($sql, array($tag_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new tag_qm_model($row);
		}
		return $ret;
	}

	public function insert() {
		$sql = "INSERT INTO tag_qm(qm_id, tag_id) VALUES ('%s', '%s');";
		return database::insert($sql, array($this -> qm_id, $this -> tag_id));
	}

	public function update() {
		$sql = "UPDATE tag_qm SET  WHERE qm_id ='%s'ANDtag_id ='%s';";
		return database::update($sql, array($this -> qm_id, $this -> tag_id));
	}
}
?>