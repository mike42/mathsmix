<?php
class activity_template {
	public $at_id;
	public $at_type;
	public $at_name;
	public $at_created;
	public $user_id;

	/* Referenced tables */
	public $user;

	/* Tables which reference this */
	public $list_activity;
	public $list_activity_template_qm;
	public $list_task_template;

	public function activity_template($row) {
		$this -> at_id      = $row['at_id'];
		$this -> at_type    = $row['at_type'];
		$this -> at_name    = $row['at_name'];
		$this -> at_created = $row['at_created'];
		$this -> user_id    = $row['user_id'];

		/* Fields from related tables */
		$this -> user = new user($row);
	}

	public static function get($at_id) {
		$sql = "SELECT * FROM activity_template LEFT JOIN user ON activity_template.user_id = user.user_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE at_id='%s'";
		$res = Database::retrieve($sql, array($at_id));
		if($row = Database::get_row($res)) {
			return new activity_template($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public static function list_by_user_id($user_id) {
		$sql = "SELECT * FROM activity_template LEFT JOIN user ON activity_template.user_id = user.user_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE user_id='%s';";
		$res = Database::retrieve($sql, array($user_id));
		$ret = array();
		while($row = Database::get_row($res)) {
			$ret[] = new activity_template($row);
		}
		return $ret;
	}

	public function populate_list_user() {
		$this -> list_activity = activity::list_by_at_id($this -> at_id);
	}

	public function populate_list_user() {
		$this -> list_activity_template_qm = activity_template_qm::list_by_at_id($this -> at_id);
	}

	public function populate_list_user() {
		$this -> list_task_template = task_template::list_by_at_id($this -> at_id);
	}
}
?>