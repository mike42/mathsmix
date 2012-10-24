<?php
class class_selection_model {
	/* Fields */
	public $class_id;
	public $tt_id;
	public $yw_id;
	public $cs_due;
	public $cs_visible_from;
	public $cs_enabled;
	public $cs_compulsory;
	public $cs_created;

	/* Referenced tables */
	public $classes;
	public $task_template;
	public $year_week;

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("classes_model");
		core::loadClass("task_template_model");
		core::loadClass("year_week_model");
	}

	/**
	 * Create new class_selection based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function class_selection_model(array $row = array()) {
		$this -> class_id        = isset($row['class_id'])        ? $row['class_id']       : '';
		$this -> tt_id           = isset($row['tt_id'])           ? $row['tt_id']          : '';
		$this -> yw_id           = isset($row['yw_id'])           ? $row['yw_id']          : '';
		$this -> cs_due          = isset($row['cs_due'])          ? $row['cs_due']         : '';
		$this -> cs_visible_from = isset($row['cs_visible_from']) ? $row['cs_visible_from']: '';
		$this -> cs_enabled      = isset($row['cs_enabled'])      ? $row['cs_enabled']     : '';
		$this -> cs_compulsory   = isset($row['cs_compulsory'])   ? $row['cs_compulsory']  : '';
		$this -> cs_created      = isset($row['cs_created'])      ? $row['cs_created']     : '';

		/* Fields from related tables */
		$this -> classes = new classes_model($row);
		$this -> task_template = new task_template_model($row);
		$this -> year_week = new year_week_model($row);
	}

	public static function get($class_id, $tt_id) {
		$sql = "SELECT * FROM class_selection LEFT JOIN classes ON class_selection.class_id = classes.class_id LEFT JOIN task_template ON class_selection.tt_id = task_template.tt_id LEFT JOIN year_week ON class_selection.yw_id = year_week.yw_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN user ON task_template.user_id = user.user_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE class_selection.class_id='%s' AND class_selection.tt_id='%s'";
		$res = database::retrieve($sql, array($class_id, $tt_id));
		if($row = database::get_row($res)) {
			return new class_selection_model($row);
		}
		return false;
	}

	public static function list_by_yw_id($yw_id) {
		$sql = "SELECT * FROM class_selection LEFT JOIN classes ON class_selection.class_id = classes.class_id LEFT JOIN task_template ON class_selection.tt_id = task_template.tt_id LEFT JOIN year_week ON class_selection.yw_id = year_week.yw_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN user ON task_template.user_id = user.user_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE class_selection.yw_id='%s';";
		$res = database::retrieve($sql, array($yw_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new class_selection_model($row);
		}
		return $ret;
	}

	public static function list_by_class_id($class_id) {
		$sql = "SELECT * FROM class_selection LEFT JOIN classes ON class_selection.class_id = classes.class_id LEFT JOIN task_template ON class_selection.tt_id = task_template.tt_id LEFT JOIN year_week ON class_selection.yw_id = year_week.yw_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN user ON task_template.user_id = user.user_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE class_selection.class_id='%s';";
		$res = database::retrieve($sql, array($class_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new class_selection_model($row);
		}
		return $ret;
	}

	public static function list_by_tt_id($tt_id) {
		$sql = "SELECT * FROM class_selection LEFT JOIN classes ON class_selection.class_id = classes.class_id LEFT JOIN task_template ON class_selection.tt_id = task_template.tt_id LEFT JOIN year_week ON class_selection.yw_id = year_week.yw_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN user ON task_template.user_id = user.user_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE class_selection.tt_id='%s';";
		$res = database::retrieve($sql, array($tt_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new class_selection_model($row);
		}
		return $ret;
	}

	public function insert() {
		$sql = "INSERT INTO class_selection(class_id, tt_id, yw_id, cs_due, cs_visible_from, cs_enabled, cs_compulsory) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s');";
		return database::insert($sql, array($this -> class_id, $this -> tt_id, $this -> yw_id, $this -> cs_due, $this -> cs_visible_from, $this -> cs_enabled, $this -> cs_compulsory));
	}

	public function update() {
		$sql = "UPDATE class_selection SET yw_id, cs_due, cs_visible_from, cs_enabled, cs_compulsory WHERE class_id ='%s'ANDtt_id ='%s';";
		return database::update($sql, array($this -> yw_id, $this -> cs_due, $this -> cs_visible_from, $this -> cs_enabled, $this -> cs_compulsory, $this -> class_id, $this -> tt_id));
	}
}
?>