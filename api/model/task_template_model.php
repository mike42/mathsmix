<?php
class task_template_model {
	/* Fields */
	public $tt_id;
	public $at_id;
	public $class_id;
	public $user_id;
	public $tt_name;
	public $tt_created;
	public $tt_shared;

	/* Referenced tables */
	public $classes;
	public $activity_template;
	public $user;

	/* Tables which reference this */
	public $list_task                 = array();

	/**
	 * Load all related models.
	*/
	public static function init() {
		core::loadClass("database");
		core::loadClass("classes_model");
		core::loadClass("activity_template_model");
		core::loadClass("user_model");
		core::loadClass("task_model");
	}

	/**
	 * Create new task_template based on a row from the database.
	 * @param array $row The database row to use.
	*/
	public function task_template_model(array $row = array()) {
		$this -> tt_id      = isset($row['tt_id'])      ? $row['tt_id']     : '';
		$this -> at_id      = isset($row['at_id'])      ? $row['at_id']     : '';
		$this -> class_id   = isset($row['class_id'])   ? $row['class_id']  : '';
		$this -> user_id    = isset($row['user_id'])    ? $row['user_id']   : '';
		$this -> tt_name    = isset($row['tt_name'])    ? $row['tt_name']   : '';
		$this -> tt_created = isset($row['tt_created']) ? $row['tt_created']: '';
		$this -> tt_shared  = isset($row['tt_shared'])  ? $row['tt_shared'] : '';

		/* Fields from related tables */
		$this -> classes = new classes_model($row);
		$this -> activity_template = new activity_template_model($row);
		$this -> user = new user_model($row);
	}

	public static function get($tt_id) {
		$sql = "SELECT * FROM task_template LEFT JOIN classes ON task_template.class_id = classes.class_id LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN user ON task_template.user_id = user.user_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE task_template.tt_id='%s'";
		$res = database::retrieve($sql, array($tt_id));
		if($row = database::get_row($res)) {
			return new task_template_model($row);
		}
		return false;
	}

	public static function list_by_at_id($at_id) {
		$sql = "SELECT * FROM task_template LEFT JOIN classes ON task_template.class_id = classes.class_id LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN user ON task_template.user_id = user.user_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE task_template.at_id='%s';";
		$res = database::retrieve($sql, array($at_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new task_template_model($row);
		}
		return $ret;
	}

	public static function list_by_user_id($user_id) {
		$sql = "SELECT * FROM task_template LEFT JOIN classes ON task_template.class_id = classes.class_id LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN user ON task_template.user_id = user.user_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE task_template.user_id='%s';";
		$res = database::retrieve($sql, array($user_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new task_template_model($row);
		}
		return $ret;
	}

	public static function list_by_class_id($class_id) {
		$sql = "SELECT * FROM task_template LEFT JOIN classes ON task_template.class_id = classes.class_id LEFT JOIN activity_template ON task_template.at_id = activity_template.at_id LEFT JOIN user ON task_template.user_id = user.user_id LEFT JOIN year_level ON classes.yl_id = year_level.yl_id LEFT JOIN school ON classes.school_id = school.school_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN district ON year_level.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE task_template.class_id='%s';";
		$res = database::retrieve($sql, array($class_id));
		$ret = array();
		while($row = database::get_row($res)) {
			$ret[] = new task_template_model($row);
		}
		return $ret;
	}

	public function populate_list_task() {
		$this -> list_task = task_model::list_by_tt_id($this -> tt_id);
	}

	public function insert() {
		$sql = "INSERT INTO task_template(at_id, class_id, user_id, tt_name, tt_shared) VALUES ('%s', '%s', '%s', '%s', '%s');";
		return database::insert($sql, array($this -> at_id, $this -> class_id, $this -> user_id, $this -> tt_name, $this -> tt_shared));
	}

	public function update() {
		$sql = "UPDATE task_template SET at_id, class_id, user_id, tt_name, tt_shared WHERE tt_id ='%s';";
		return database::update($sql, array($this -> at_id, $this -> class_id, $this -> user_id, $this -> tt_name, $this -> tt_shared, $this -> tt_id));
	}
}
?>