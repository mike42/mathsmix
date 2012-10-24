<?php
class classes_controller {
	static $permissions;
	
	public static function init() {
		self::$permissions = core::getPermissions('classes');
		core::loadClass('classes_model');
	}
	
	public static function create($yl_id = '') {
		if(!self::$permissions['create']) {
			return array('error' => '403', 'message' => 'You do not have permission to manage classes');
		}
		$user = session::getUser();
		
		if(isset($_REQUEST['submit']) && isset($_REQUEST['yl_id']) && isset($_REQUEST['class_year']) && isset($_REQUEST['class_name'])) {
			/* Some checks around submitted data */
			if(!$year_level = year_level_model::get($yl_id)) {
				return array('error' => '404', 'message' => "Cannot create class - No such year level");
			}
			if($year_level -> district_id != $user -> domain -> school -> district_id) {
				return array('error' => '404', 'message' => "That year level doesn't exist in your district");
			}
			
			/* Add a student */
			$class = new classes_model();
			$class -> class_name	= $_REQUEST['class_name'];
			$class -> yl_id			= (int)$_REQUEST['yl_id'];
			$class -> class_year	= (int)$_REQUEST['class_year'];
			$class -> school_id		= $user -> domain -> school_id;
			$class -> class_id		= $class -> insert();
			
			/* Add self as teacher */
			$teaches = new teaches_model();
			$teaches -> user_id = $user -> user_id;
			$teaches -> class_id = $class -> class_id;
			$teaches -> insert();
			
			core::redirect(core::constructURL('classes', 'view', array($class -> class_id), 'html'));

			return;
		} else {
			/* Show form */
			if(!$year_level = year_level_model::get($yl_id)) {
				return array('error' => '404', 'message' => "Cannot create class - No such year level");
			}
			if($year_level -> district_id != $user -> domain -> school -> district_id) {
				return array('error' => '404', 'message' => "That year level doesn't exist in your district");
			}
		
			return array('year_level' => $year_level);
		}
	}

	public static function edit($class_id = '') {
		if(!self::$permissions['edit']) {
			return array('error' => '403', 'message' => 'You do not have permission to manage classes');
		}
		
		if($class_id != '' && $class = classes_model::get($class_id)) {
			if($class -> school_id != $user -> domain -> school_id) {
				return array('error' => '403', 'message' => 'That class belongs to another school, so you do not have access.');
			}
			return array('class' => $class);
		} else {
			return array('error' => '404');
		}
	}
	
	public static function view($class_id = '') {
		if(!self::$permissions['edit']) {
			return array('error' => '403', 'message' => 'You do not have permission to manage classes');
		}

		$user = session::getUser();
		if($class_id != '') {
			if(!$class = classes_model::get($class_id)) {
				return array('error' => '404', 'message' => 'No such class.');
			}
			if($class -> school_id != $user -> domain -> school_id) {
				return array('error' => '403', 'message' => 'That class belongs to another school, so you do not have access.');
			}
			
			/* List out teachers and students */
			$class -> populate_list_teaches();
			$class -> populate_list_attends();
			
			return array('class' => $class);
		} else {
			/* Enumerate classes per year-level */
			$year_levels = year_level_model::list_by_district_id($user -> domain -> school -> district_id);
			foreach($year_levels as $key => $val) {
				/* Load up classes on per-yearlevel basis */
				$year_levels[$key] -> list_classes = classes_model::list_by_yl_and_school($val -> yl_id, $user -> domain -> school_id);
			}
			return array('year_levels' => $year_levels, 'school' => $user -> domain -> school);
		}
	}
	
	public static function delete($class_id = '') {
		if(!self::$permissions['delete']) {
			return array('error' => '403', 'message' => 'You do not have permission to delete classes');
		}
		if(!$class = classes_model::get($class_id)) {
			return array('error' => '404', 'message' => 'No such class.');
		}
		$user = session::getUser();
		if($class -> school_id != $user -> domain -> school_id) {
			return array('error' => '403', 'message' => 'That class belongs to another school, so you do not have access.');
		}
		
		die('delete not implemented');
	}
	
	public static function teaches($class_id) {
		/* Normal checks */
		if(!self::$permissions['edit']) {
			return array('error' => '403', 'message' => 'You do not have permission to edit classes');
		}
		if(!$class = classes_model::get($class_id)) {
			return array('error' => '404', 'message' => 'No such class.');
		}
		$user = session::getUser();
		if($class -> school_id != $user -> domain -> school_id) {
			return array('error' => '403', 'message' => 'That class belongs to another school, so you do not have access.');
		}
		
		/* Make and output some lists */
		$candidates = user_model::list_teaches_candidates($class_id);
		$members = teaches_model::list_by_class_id($class_id);
		return array('members' => $members, 'candidates' => $candidates, 'class' => $class);
	}
	
	public static function attends($class_id) {
		/* Normal checks */
		if(!self::$permissions['edit']) {
			return array('error' => '403', 'message' => 'You do not have permission to edit classes');
		}
		if(!$class = classes_model::get($class_id)) {
			return array('error' => '404', 'message' => 'No such class.');
		}
		$user = session::getUser();
		if($class -> school_id != $user -> domain -> school_id) {
			return array('error' => '403', 'message' => 'That class belongs to another school, so you do not have access.');
		}

		$candidates = user_model::list_attends_candidates($class_id);
		$members = attends_model::list_by_class_id($class_id);
		return array('members' => $members, 'candidates' => $candidates, 'class' => $class);
	}
}