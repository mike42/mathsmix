<?php
class question_usage_controller {
	public function search() {
		if(isset($_REQUEST['search_term'])) {
			$search_term = $_REQUEST['search_term'];
		}
		return array('search_term' => $search_term);
	}
}