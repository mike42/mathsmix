<?php
class question_viewer_model {
	/* Fields */
	public $qv_id;
	public $qv_name;
	public $qv_class;
	public $qv_created;

	/* Tables which reference this */
	public $list_format_option        = array();
	public $list_question_usage       = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("format_option_model");
		core::loadClass("question_usage_model");
	}

	/**
	 * Create new question_viewer based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function question_viewer_model(array $row = array()) {
		$this -> qv_id      = isset($row['qv_id'])      ? $row['qv_id']     : '';
		$this -> qv_name    = isset($row['qv_name'])    ? $row['qv_name']   : '';
		$this -> qv_class   = isset($row['qv_class'])   ? $row['qv_class']  : '';
		$this -> qv_created = isset($row['qv_created']) ? $row['qv_created']: '';
	}

	public static function get($qv_id) {
		$sql = "SELECT * FROM question_viewer WHERE question_viewer.qv_id='%s'";
		$res = database::retrieve($sql, array($qv_id));
		if($row = database::get_row($res)) {
			return new question_viewer_model($row);
		}
		return false;
	}

	public function populate_list_format_option() {
		$this -> list_format_option = format_option_model::list_by_qv_id($this -> qv_id);
	}

	public function populate_list_question_usage() {
		$this -> list_question_usage = question_usage_model::list_by_qv_id($this -> qv_id);
	}

	public function insert() {
		$sql = "INSERT INTO question_viewer(qv_id, qv_name, qv_class) VALUES ('%s', '%s', '%s');";
		return database::insert($sql, array($this -> qv_id, $this -> qv_name, $this -> qv_class));
	}

	public function update() {
		$sql = "UPDATE question_viewer SET qv_name, qv_class WHERE qv_id ='%s';";
		return database::update($sql, array($this -> qv_name, $this -> qv_class, $this -> qv_id));
	}
}
?>