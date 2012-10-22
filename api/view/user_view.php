<?php
class user_view {
	public function login_html($data) {
		if(isset($data['error'])) {
			/* Serve up error if needed */
			loadClass("page_view");
			page_view::error_html($data);
			return;
		}
		
		self::useTemplate("login", $data);
	}
	
	private function useTemplate($page, $data) {
		$template = "user/$page";
		$fn = dirname(__FILE__)."/template/".$template . ".inc";
		include(dirname(__FILE__)."/template/htmlLayout.php");
	}
}