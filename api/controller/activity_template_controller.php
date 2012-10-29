<?php
class activity_template_controller {
	static $permissions;
	
	public function init() {
		self::$permissions = core::getPermissions('activity_template');
		core::loadClass("activity_template_model");
	}
	
	public function view($at_id) {
		/* Check for view permission */
		if(!self::$permissions['view']) {
			return array('error' => '403');
		}
		
		if(!$activity_template = activity_template_model::get($at_id)) {
			return array('error' => '404');
		}
		
		/* Grab the questions */
		$activity_template -> populate_list_activity_template_qm();
		
		return array('activity_template' => $activity_template);
	}
	
	public function edit($at_id) {
		/* Check for edit permission */
		if(!self::$permissions['edit']) {
			return array('error' => '403');
		}
		
		if(!$activity_template = activity_template_model::get($at_id)) {
			return array('error' => '404');
		}
		$activity_template -> populate_list_activity_template_qm();
		return array('activity_template' => $activity_template);
	}

	public function create() {
		/* Check for create permission */
		if(!self::$permissions['create']) {			
			return array('error' => '403');
		}
		if(!$user = session::getUser()) {
			return array('error' => '403', 'message' => 'You must be logged in to create activity templates');
		}

		/* Insert a new activity with some sane defaults */
		$activity_template = new activity_template_model();
		$activity_template -> at_name = $user -> user_firstname . "'s Activity Template";
		$activity_template -> at_type = "worksheet";
		$activity_template -> user_id = $user -> user_id;
		$activity_template -> user = $user;
		$activity_template -> at_id = $activity_template -> insert();
		
		/* Go to the new activity */
		$url = core::constructURL('activity_template', 'edit', array($activity_template -> at_id), 'html');
		core::redirect($url);
	}
}