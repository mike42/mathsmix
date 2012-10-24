<?php
class user_view {
	public function login_html($data) {
		self::useTemplate("login", $data);
	}
	
	public function home_html($data) {
		self::useTemplate("home", $data);
	}
		
	public function error_html($data) {
		core::loadClass("page_view");
		page_view::error_html($data);
	}
	
	private function useTemplate($page, $data) {
		$template = "user/$page";
		$fn = dirname(__FILE__)."/template/".$template . ".inc";
		include(dirname(__FILE__)."/template/htmlLayout.php");
	}
	
	
}