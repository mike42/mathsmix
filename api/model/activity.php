<?php
class activity {
	public $activity_id;
	public $at_id;
	public $user_id;
	public $activity_created;
	public $activity_isgen;

	/* Referenced tables */
	public $activity_template;
	public $user;

	/* Tables which reference this */
	public $list_activity_question;
	public $list_task;

	public function activity($row) {
		$this -> activity_id      = $row['activity_id'];
		$this -> at_id            = $row['at_id'];
		$this -> user_id          = $row['user_id'];
		$this -> activity_created = $row['activity_created'];
		$this -> activity_isgen   = $row['activity_isgen'];

		/* Fields from related tables */
		$this -> activity_template = new activity_template($row);
		$this -> user = new user($row);
	}

	public static function get($activity_id) {
		$sql = "SELECT * FROM activity LEFT JOIN activity_template ON activity.at_id = activity_template.at_id LEFT JOIN user ON activity.user_id = user.user_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE activity_id='%s'";
		$res = Database::retrieve($sql, array($activity_id));
		if($row = Database::get_row($res)) {
			return new activity($row);
		}
		return false;
	}

	public function insert() {

	}

	public function update() {

	}

	public static function list_by_at_id($at_id) {
		$sql = "SELECT * FROM activity LEFT JOIN activity_template ON activity.at_id = activity_template.at_id LEFT JOIN user ON activity.user_id = user.user_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE at_id='%s';";
		$res = Database::retrieve($sql, array($at_id));
		$ret = array();
		while($row = Database::get_row($res)) {
			$ret[] = new activity($row);
		}
		return $ret;
	}

	public static function list_by_user_id($user_id) {
		$sql = "SELECT * FROM activity LEFT JOIN activity_template ON activity.at_id = activity_template.at_id LEFT JOIN user ON activity.user_id = user.user_id LEFT JOIN domain ON user.domain_id = domain.domain_id LEFT JOIN school ON domain.school_id = school.school_id LEFT JOIN district ON school.district_id = district.district_id LEFT JOIN country ON district.country_iso = country.country_iso WHERE user_id='%s';";
		$res = Database::retrieve($sql, array($user_id));
		$ret = array();
		while($row = Database::get_row($res)) {
			$ret[] = new activity($row);
		}
		return $ret;
	}

	public function populate_list_user() {
		$this -> list_activity_question = activity_question::list_by_activity_id($this -> activity_id);
	}

	public function populate_list_user() {
		$this -> list_task = task::list_by_activity_id($this -> activity_id);
	}
}
?>