<?php
class question_viewer {
	public $qv_id;
	public $qv_name;
	public $qv_class;
	public $qv_created;

	/* Tables which reference this */
	public $list_format_option;
	public $list_question_usage;

	public function question_viewer($row) {
		$this -> qv_id      = $row['qv_id'];
		$this -> qv_name    = $row['qv_name'];
		$this -> qv_class   = $row['qv_class'];
		$this -> qv_created = $row['qv_created'];

	public static function get($qv_id) {
		$sql = "SELECT * FROM question_viewer WHERE qv_id='%s'";
		$res = Database::retrieve($sql, array($qv_id))
		if($row = Database::get_row($res) {
			return new question_viewer($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public function populate_list_question_maker() {
		$this -> list_format_option = format_option::list_by_qv_id($this -> qv_id);
	}

	public function populate_list_question_maker() {
		$this -> list_question_usage = question_usage::list_by_qv_id($this -> qv_id);
	}
}
?>