<?php
class activity_template_controller {
	static $permissions;
	
	public function init() {
		self::$permissions = core::getPermissions('activity_template');
		core::loadClass("activity_template_model");
		core::loadClass("activity_question_model");
		core::loadClass("MixUp");
	}
	
	public function view($at_id) {
		/* Check for view permission */
		if(!self::$permissions['view']) {
			return array('error' => '403');
		}
		
		if(!$user = session::getUser()) {
			return array('error' => '403', 'message' => 'You must be logged in to do an activity');
		}
		
		if(!$activity_template = activity_template_model::get($at_id)) {
			return array('error' => '404');
		}
		
		/* Grab the questions */
		$activity_template -> populate_list_activity_template_qm();
		
		/* Create an activity */
		$activity = new activity_model();
		$activity -> at_id = $activity_template -> at_id;
		$activity -> user_id = $user -> user_id;
		$activity -> activity_isgen = 1;
		$activity -> activity_id = $activity -> insert();
		$activity_template_qm = new activity_template_qm_model();

		/* Create questions */
		foreach($activity_template -> list_activity_template_qm as $activity_template_qm) {
			$activity_question = new activity_question_model();
			$activity_question -> activity_id = $activity -> activity_id;
			$activity_question -> atqm_id = $activity_template_qm -> atqm_id;
			$activity_question -> aq_content = MixUp::generateQuestion($activity_template_qm -> question_usage -> qu_content);
			$activity_question -> aq_id = $activity_question -> insert();
		}

		/* Go to new activity */
		core::redirect(core::constructURL('activity', 'view', array($activity -> activity_id), 'html'));
		return;
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
		if(isset($_POST['action']) && isset($_POST['qu_id'])) {
			$atqm_no_taken = array();
			foreach($activity_template -> list_activity_template_qm as $atqm) {
				$atqm_no_taken[$atqm -> atqm_no] = true;
			}
			/* Find un-used number */
			$atqm_no = 1;
			while(isset($atqm_no_taken[$atqm_no])) {
				$atqm_no++;
			}

			$question_usage = question_usage_model::get($_POST['qu_id']);
			
			/* Add new activity template */
			$activity_template_qm = new activity_template_qm_model();
			$activity_template_qm -> at_id		= $at_id;
			$activity_template_qm -> atqm_no	= $atqm_no;
			$activity_template_qm -> atqm_marks = 1;
			$activity_template_qm -> qu_id		= $question_usage -> qu_id;
			$activity_template_qm -> atqm_id	= $activity_template_qm -> insert();
			
			/* Refresh the list */
			$activity_template -> populate_list_activity_template_qm();
		}
		
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