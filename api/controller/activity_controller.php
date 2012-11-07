<?php
class activity_controller {
	public static function init() {
		core::loadClass("activity_model");
	}
	
	public static function view($activity_id) {
		if(!$user = session::getUser()) {
			return array('error' => '403', 'message' => 'You must be logged in to do an activity');
		}

		if(!$activity = activity_model::get($activity_id)) {
			return array("404", "No such activity");
		}
		
		if(!($user_id == $activity -> user_id)) {
			return array('error' => '403', 'message' => 'This is not your activity.');
		}
		
		return array('activity' => $activity);
	}
}