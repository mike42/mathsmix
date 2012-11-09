<?php
class task_template_controller {
	public function init() {
		core::loadClass("task_template_model");
	}
	
	public function edit($tt_id) {
		if($user = session::getUser()) {
			return array('error' => '403', 'message' => 'You must be logged in to view task templates');
		}
		
		if(!$template = task_template_model::get($tt_id)) {
			return array('error' => '404', 'message' => 'No such task template');
		}
	}
	
	public function create($at_id) {
		
	}
}