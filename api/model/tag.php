<?php
class tag {
	public $tag_id;
	public $tag_name;

	/* Tables which reference this */
	public $list_tag_qm;

	public function tag($row) {
		$this -> tag_id   = $row['tag_id'];
		$this -> tag_name = $row['tag_name'];
	}

	public static function get($tag_id) {
		$sql = "SELECT * FROM tag WHERE tag_id='%s'";
		$res = Database::retrieve($sql, array($tag_id));
		if($row = Database::get_row($res)) {
			return new tag($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public function populate_list_district() {
		$this -> list_tag_qm = tag_qm::list_by_tag_id($this -> tag_id);
	}
}
?>