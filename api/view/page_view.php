<?php
class page_view {
	/**
	 * Show one of the pages
	 */
	public static function view_html($data) {
		$template = "page/" . core::alphanumeric($data['page']);
		$fn = dirname(__FILE__)."/template/".$template . ".inc";
		if(file_exists($fn)) {
			include(dirname(__FILE__)."/template/htmlLayout.php");
		} else {
			self::error_html(array("error" => "404"));
		}
	}
	
	/**
	 * Serve up an error.
	 */
	public static function error_html($data) {
		switch($data['error']) {
			case "403":
				header("HTTP/1.1 403 Forbidden");
				$template = "page/403";
				break;
			case "404":
			default:
				header("HTTP/1.1 404 Not Found");
				$template = "page/404";
		}
		include(dirname(__FILE__)."/template/htmlLayout.php");
	}
}