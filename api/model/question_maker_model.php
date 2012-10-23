<?php
class question_maker_model {
	/* Fields */
	public $qm_id;
	public $qm_name;
	public $qm_class;
	public $qm_created;

	/* Tables which reference this */
	public $list_format_option        = array();
	public $list_question_usage       = array();
	public $list_tag_qm               = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("format_option_model");
		core::loadClass("question_usage_model");
		core::loadClass("tag_qm_model");
	}

	/**
	 * Create new question_maker based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function question_maker_model(array $row = array()) {
		$this -> qm_id      = isset($row['qm_id'])      ? $row['qm_id']     : '';
		$this -> qm_name    = isset($row['qm_name'])    ? $row['qm_name']   : '';
		$this -> qm_class   = isset($row['qm_class'])   ? $row['qm_class']  : '';
		$this -> qm_created = isset($row['qm_created']) ? $row['qm_created']: '';
	}

	public static function get($qm_id) {
		$sql = "SELECT * FROM question_maker WHERE qm_id='%s'";
		$res = database::retrieve($sql, array($qm_id));
		if($row = database::get_row($res)) {
			return new question_maker_model($row);
		}
		return false;
	}

	public function populate_list_format_option() {
		$this -> list_format_option = format_option::list_by_qm_id($this -> qm_id);
	}

	public function populate_list_question_usage() {
		$this -> list_question_usage = question_usage::list_by_qm_id($this -> qm_id);
	}

	public function populate_list_tag_qm() {
		$this -> list_tag_qm = tag_qm::list_by_qm_id($this -> qm_id);
	}

	public function insert() {
		$sql = "INSERT INTO question_maker(qm_name, qm_class) VALUES ('%s', '%s');";
		return database::insert($sql, array($this -> qm_name, $this -> qm_class));
	}

	public function update() {
		$sql = "UPDATE question_maker SET qm_name, qm_class WHERE qm_id ='%s';";
		return database::update($sql, array($this -> qm_name, $this -> qm_class, $this -> qm_id));
	}
}
?>