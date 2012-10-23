<?php
class year_week_model {
	/* Fields */
	public $yw_id;
	public $yw_year;
	public $yw_week;
	public $yw_start;
	public $yw_end;

	/* Tables which reference this */
	public $list_class_selection      = array();
	public $list_task                 = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("class_selection_model");
		core::loadClass("task_model");
	}

	/**
	 * Create new year_week based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function year_week_model(array $row = array()) {
		$this -> yw_id    = isset($row['yw_id'])    ? $row['yw_id']   : '';
		$this -> yw_year  = isset($row['yw_year'])  ? $row['yw_year'] : '';
		$this -> yw_week  = isset($row['yw_week'])  ? $row['yw_week'] : '';
		$this -> yw_start = isset($row['yw_start']) ? $row['yw_start']: '';
		$this -> yw_end   = isset($row['yw_end'])   ? $row['yw_end']  : '';
	}

	public static function get($yw_id) {
		$sql = "SELECT * FROM year_week WHERE yw_id='%s'";
		$res = database::retrieve($sql, array($yw_id));
		if($row = database::get_row($res)) {
			return new year_week_model($row);
		}
		return false;
	}

	public static function get_by_yw_yearwk($yw_year, $yw_week) {
		$sql = "SELECT * FROM year_week WHERE yw_year='%s' AND yw_week='%s'";
		$res = database::retrieve($sql, array($yw_year, $yw_week));
		if($row = database::get_row($res)) {
			return new year_week_model($row);
		}
		return false;
	}

	public static function list_by_yw_year($yw_year) {
		$sql = "SELECT * FROM year_week WHERE yw_year='%s';";
		$res = database::retrieve($sql, array($yw_year));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new year_week_model($row);
		}
		return $ret;
	}

	public function populate_list_class_selection() {
		$this -> list_class_selection = class_selection::list_by_yw_id($this -> yw_id);
	}

	public function populate_list_task() {
		$this -> list_task = task::list_by_yw_id($this -> yw_id);
	}

	public function insert() {
		$sql = "INSERT INTO year_week(yw_year, yw_week, yw_start, yw_end) VALUES ('%s', '%s', '%s', '%s');";
		return database::insert($sql, array($this -> yw_year, $this -> yw_week, $this -> yw_start, $this -> yw_end));
	}

	public function update() {
		$sql = "UPDATE year_week SET yw_year, yw_week, yw_start, yw_end WHERE yw_id ='%s';";
		return database::update($sql, array($this -> yw_year, $this -> yw_week, $this -> yw_start, $this -> yw_end, $this -> yw_id));
	}
}
?>