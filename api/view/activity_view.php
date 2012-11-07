<?php
class activity_view {
	public static function init() {
		core::loadClass("MixUp");
	}
	
	function attempt_html($data) {
		$type = $data['attempt'] -> activity -> activity_template -> at_type;
		self::useTemplate($type, $data);
	}
	
	function view_html($data) {
		self::useTemplate('view', $data);
	}
	
	function error_html($data) {
		core::loadClass("page_view");
		page_view::error_html($data);
	}

	private function useTemplate($page, $data) {
		$template = "activity/$page";
		$fn = dirname(__FILE__)."/template/".$template . ".inc";
		include(dirname(__FILE__)."/template/htmlLayout.php");
	}
}