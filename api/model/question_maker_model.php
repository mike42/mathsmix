<?php
class question_maker {
	public $qm_id;
	public $qm_name;
	public $qm_class;
	public $qm_created;

	/* Tables which reference this */
	public $list_format_option;
	public $list_question_usage;
	public $list_tag_qm;

	public function question_maker($row) {
		$this -> qm_id      = $row['qm_id'];
		$this -> qm_name    = $row['qm_name'];
		$this -> qm_class   = $row['qm_class'];
		$this -> qm_created = $row['qm_created'];
	}

	public static function get($qm_id) {
		$sql = "SELECT * FROM question_maker WHERE qm_id='%s'";
		$res = Database::retrieve($sql, array($qm_id));
		if($row = Database::get_row($res)) {
			return new question_maker($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public function populate_list_question_maker() {
		$this -> list_format_option = format_option::list_by_qm_id($this -> qm_id);
	}

	public function populate_list_question_maker() {
		$this -> list_question_usage = question_usage::list_by_qm_id($this -> qm_id);
	}

	public function populate_list_question_maker() {
		$this -> list_tag_qm = tag_qm::list_by_qm_id($this -> qm_id);
	}
}
?>