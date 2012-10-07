<?php
class year_week {
	public $yw_id;
	public $yw_year;
	public $yw_week;
	public $yw_start;
	public $yw_end;

	/* Tables which reference this */
	public $list_class_selection;
	public $list_task;

	public function year_week($row) {
		$this -> yw_id    = $row['yw_id'];
		$this -> yw_year  = $row['yw_year'];
		$this -> yw_week  = $row['yw_week'];
		$this -> yw_start = $row['yw_start'];
		$this -> yw_end   = $row['yw_end'];

	public static function get($yw_id) {
		$sql = "SELECT * FROM year_week WHERE yw_id='%s'";
		$res = Database::retrieve($sql, array($yw_id))
		if($row = Database::get_row($res) {
			return new year_week($row);
		}
		return false;
	}

	public static function get_by_yw_yearwk($yw_year, $yw_week) {
		$sql = "SELECT * FROM year_week WHERE yw_year='%s' AND yw_week='%s'";
		$res = Database::retrieve($sql, array($yw_year, $yw_week))
		if($row = Database::get_row($res) {
			return new year_week($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public static function list_by_yw_year($yw_year) {
		$sql = "SELECT * FROM year_week WHERE yw_year='%s';";
		$res = Database::retrieve($sql, array($yw_year))
		$ret = array();
		while($row = Database::get_row($res) {
			$ret[] = new year_week($row);
		}
		return $ret;
	}

	public function populate_list_district() {
		$this -> list_class_selection = class_selection::list_by_yw_id($this -> yw_id);
	}

	public function populate_list_district() {
		$this -> list_task = task::list_by_yw_id($this -> yw_id);
	}
}
?>