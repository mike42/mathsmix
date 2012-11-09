<?php
class activity_controller {
	public static function init() {
		core::loadClass("activity_model");
	}
	
	public static function attempt($activity_id, $attempt_id) {
		/* Create a new attempt for an activity and go there */
		if(!$user = session::getUser()) {
			return array('error' => '403', 'message' => 'You must be logged in to do an activity');
		}
		
		if($attempt_id == 'new') {
			/* Make a new attempt for this activity */
			if(!$activity = activity_model::get($activity_id)) {
				return array("404", "No such activity");
			}
			
			if(!($user -> user_id == $activity -> user_id)) {
				return array('error' => '403', 'message' => 'This is not your activity.');
			}
		
			/* Insert */
			$attempt = new attempt_model();
			$attempt -> activity_id = $activity -> activity_id;
			$attempt -> attempt_id = $attempt -> insert();
			
			$url = core::constructURL('activity', 'attempt', array($activity -> activity_id, $attempt -> attempt_id), 'html');
			core::redirect($url);
		}
		
		if(!$attempt = attempt_model::get($attempt_id)) {
			return array('error' => '404', 'message' => 'No such attempt.');
		}
		
		/* Verify that this attempt is ours / mathces the activity_id*/
		if(!($user -> user_id == $attempt -> activity -> user_id)) {
			return array('error' => '403', 'message' => 'This is not your activity.');
		}
		
		if($activity_id != $attempt -> activity_id) {
			return array("404", 'That attempt does not belong to the activity you requested.');
		}
		
		$attempt -> activity -> populate_list_activity_question();
		return array('attempt' => $attempt);
	}
	
	public static function view($activity_id) {
		return self::attempt($activity_id, 'new');
	}
}