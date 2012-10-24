<?php
class tag_model {
	/* Fields */
	public $tag_id;
	public $tag_name;

	/* Tables which reference this */
	public $list_tag_qm               = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("tag_qm_model");
	}

	/**
	 * Create new tag based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function tag_model(array $row = array()) {
		$this -> tag_id   = isset($row['tag_id'])   ? $row['tag_id']  : '';
		$this -> tag_name = isset($row['tag_name']) ? $row['tag_name']: '';
	}

	public static function get($tag_id) {
		$sql = "SELECT * FROM tag WHERE tag.tag_id='%s'";
		$res = database::retrieve($sql, array($tag_id));
		if($row = database::get_row($res)) {
			return new tag_model($row);
		}
		return false;
	}

	public function populate_list_tag_qm() {
		$this -> list_tag_qm = tag_qm_model::list_by_tag_id($this -> tag_id);
	}

	public function insert() {
		$sql = "INSERT INTO tag(tag_name) VALUES ('%s');";
		return database::insert($sql, array($this -> tag_name));
	}

	public function update() {
		$sql = "UPDATE tag SET tag_name WHERE tag_id ='%s';";
		return database::update($sql, array($this -> tag_name, $this -> tag_id));
	}
}
?>