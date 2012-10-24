<?php
class classes_view {
	public function view_html($data) {
		self::useTemplate('view', $data);
	}
	
	public function create_html($data) {
		self::useTemplate('create', $data);
	}
	
	public function attends_html($data) {
		self::useTemplate('attends', $data);
	}
	
	public function teaches_html($data) {
		self::useTemplate('teaches', $data);
	}
	
	public function edit_html($data) {
		self::useTemplate('edit', $data);
	}

	public function error_html($data) {
		/* Serve up error if needed */
		core::loadClass("page_view");
		page_view::error_html($data);
		return;
	}
	
	private function useTemplate($page, $data) {
		$template = "classes/$page";
		$fn = dirname(__FILE__)."/template/".$template . ".inc";
		include(dirname(__FILE__)."/template/htmlLayout.php");
	}
}