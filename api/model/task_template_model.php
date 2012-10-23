<?php
class task_template_model {
	/* Fields */
	public $tt_id;
	public $at_id;
	public $yl_id;
	public $user_id;
	public $tt_name;
	public $tt_week;
	public $tt_sequence;
	public $tt_created;
	public $tt_public;
	public $tt_shared;

	/* Referenced tables */
	public $activity_template;
	public $year_level;
	public $user;

	/* Tables which reference this */
	public $list_class_selection      = array();
	public $list_task                 = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("activity_template_model");
		core::loadClass("year_level_model");
		core::loadClass("user_model");
		core::loadClass("class_selection_model");
		core::loadClass("task_model");
	}

	/**
	 * Create new task_template based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function task_template_model(array $row) {
		$this -> tt_id       = isset($row['tt_id'])       ? $row['tt_id']      : '';
		$this -> at_id       = isset($row['at_id'])       ? $row['at_id']      : '';
		$this -> yl_id       = isset($row['yl_id'])       ? $row['yl_id']      : '';
		$this -> user_id     = isset($row['user_id'])     ? $row['user_id']    : '';
		$this -> tt_name     = isset($row['tt_name'])     ? $row['tt_name']    : '';
		$this -> tt_week     = isset($row['tt_week'])     ? $row['tt_week']    : '';
		$this -> tt_sequence = isset($row['tt_sequence']) ? $row['tt_sequence']: '';
		$this -> tt_created  = isset($row['tt_created'])  ? $row['tt_created'] : '';
		$this -> tt_public   = isset($row['tt_public'])   ? $row['tt_public']  : '';
		$this -> tt_shared   = isset($row['tt_shared'])   ? $row['tt_shared']  : '';

		/* Fields from related tables */
		$this -> activity_template = new activity_template_model($row);
		$this -> year_level = new year_level_model($row);
		$this -> user = new user_model($row);
	}

	public static function get($tt_id) {
		$sql = "SELECT * FROM task_template LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN year_level ON task_template.yl_id = year_level.yl_id LEFT JOIN user ON task_template.user_id = user.user_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN country ON district.country_iso = country.country_iso LEFT JOIN school ON domain.school_id = school.school_id WHERE tt_id='%s'";
		$res = database::retrieve($sql, array($tt_id));
		if($row = database::get_row($res)) {
			return new task_template_model($row);
		}
		return false;
	}

	public static function list_by_at_id($at_id) {
		$sql = "SELECT * FROM task_template LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN year_level ON task_template.yl_id = year_level.yl_id LEFT JOIN user ON task_template.user_id = user.user_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN country ON district.country_iso = country.country_iso LEFT JOIN school ON domain.school_id = school.school_id WHERE at_id='%s';";
		$res = database::retrieve($sql, array($at_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new task_template_model($row);
		}
		return $ret;
	}

	public static function list_by_yl_id($yl_id) {
		$sql = "SELECT * FROM task_template LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN year_level ON task_template.yl_id = year_level.yl_id LEFT JOIN user ON task_template.user_id = user.user_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN country ON district.country_iso = country.country_iso LEFT JOIN school ON domain.school_id = school.school_id WHERE yl_id='%s';";
		$res = database::retrieve($sql, array($yl_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new task_template_model($row);
		}
		return $ret;
	}

	public static function list_by_user_id($user_id) {
		$sql = "SELECT * FROM task_template LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN year_level ON task_template.yl_id = year_level.yl_id LEFT JOIN user ON task_template.user_id = user.user_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN country ON district.country_iso = country.country_iso LEFT JOIN school ON domain.school_id = school.school_id WHERE user_id='%s';";
		$res = database::retrieve($sql, array($user_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new task_template_model($row);
		}
		return $ret;
	}

	public function populate_list_class_selection() {
		$this -> list_class_selection = class_selection::list_by_tt_id($this -> tt_id);
	}

	public function populate_list_task() {
		$this -> list_task = task::list_by_tt_id($this -> tt_id);
	}

	public function insert() {
		$sql = "INSERT INTO task_template(at_id, yl_id, user_id, tt_name, tt_week, tt_sequence, tt_public, tt_shared) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');";
		return database::insert($sql, array($this -> at_id, $this -> yl_id, $this -> user_id, $this -> tt_name, $this -> tt_week, $this -> tt_sequence, $this -> tt_public, $this -> tt_shared));
	}

	public function update() {
		$sql = "UPDATE task_template SET at_id, yl_id, user_id, tt_name, tt_week, tt_sequence, tt_public, tt_shared WHERE tt_id ='%s';";
		return database::update($sql, array($this -> at_id, $this -> yl_id, $this -> user_id, $this -> tt_name, $this -> tt_week, $this -> tt_sequence, $this -> tt_public, $this -> tt_shared, $this -> tt_id));
	}
}
?>