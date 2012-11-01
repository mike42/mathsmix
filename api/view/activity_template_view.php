<?php
class activity_template_view {
	function edit_html($data) {
		
		self::useTemplate('edit', $data);
	}
	
	function error_html($data) {
		core::loadClass("page_view");
		page_view::error_html($data);
	}
	
	private function useTemplate($page, $data) {
		$template = "activity_template/$page";
		$fn = dirname(__FILE__)."/template/".$template . ".inc";
		include(dirname(__FILE__)."/template/htmlLayout.php");
	}
}
?>