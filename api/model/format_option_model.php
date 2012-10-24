<?php
class format_option_model {
	/* Fields */
	public $qv_id;
	public $qm_id;

	/* Referenced tables */
	public $question_viewer;
	public $question_maker;

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("question_viewer_model");
		core::loadClass("question_maker_model");
	}

	/**
	 * Create new format_option based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function format_option_model(array $row = array()) {
		$this -> qv_id = isset($row['qv_id']) ? $row['qv_id']: '';
		$this -> qm_id = isset($row['qm_id']) ? $row['qm_id']: '';

		/* Fields from related tables */
		$this -> question_viewer = new question_viewer_model($row);
		$this -> question_maker = new question_maker_model($row);
	}

	public static function get($qv_id, $qm_id) {
		$sql = "SELECT * FROM format_option LEFT JOIN question_viewer ON format_option.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON format_option.qm_id = question_maker.qm_id WHERE format_option.qv_id='%s' AND format_option.qm_id='%s'";
		$res = database::retrieve($sql, array($qv_id, $qm_id));
		if($row = database::get_row($res)) {
			return new format_option_model($row);
		}
		return false;
	}

	public static function list_by_qv_id($qv_id) {
		$sql = "SELECT * FROM format_option LEFT JOIN question_viewer ON format_option.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON format_option.qm_id = question_maker.qm_id WHERE format_option.qv_id='%s';";
		$res = database::retrieve($sql, array($qv_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new format_option_model($row);
		}
		return $ret;
	}

	public static function list_by_qm_id($qm_id) {
		$sql = "SELECT * FROM format_option LEFT JOIN question_viewer ON format_option.qv_id = question_viewer.qv_id LEFT JOIN question_maker ON format_option.qm_id = question_maker.qm_id WHERE format_option.qm_id='%s';";
		$res = database::retrieve($sql, array($qm_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new format_option_model($row);
		}
		return $ret;
	}

	public function insert() {
		$sql = "INSERT INTO format_option(qv_id, qm_id) VALUES ('%s', '%s');";
		return database::insert($sql, array($this -> qv_id, $this -> qm_id));
	}

	public function update() {
		$sql = "UPDATE format_option SET  WHERE qv_id ='%s'ANDqm_id ='%s';";
		return database::update($sql, array($this -> qv_id, $this -> qm_id));
	}
}
?>