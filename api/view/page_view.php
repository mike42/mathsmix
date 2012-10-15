<?php
class page_view {
	public static function view_html($data) {
		$template = "page/" . core::alphanumeric($data['page']);
		$fn = dirname(__FILE__)."/template/".$template . ".inc";
		if(file_exists($fn)) {
			include(dirname(__FILE__)."/template/htmlLayout.php");
		} else {
			// TODO: do a 404 here
			echo "No such page";
		}
	}
	
}