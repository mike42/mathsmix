<?php
class question_usage_controller {
	public function search() {
		if(isset($_REQUEST['search_term'])) {
			$search_term = $_REQUEST['search_term'];
		}
		
		$question_usage = question_usage_model::search_by_comment($search_term);
		
		return array('search_term' => $search_term, 'question_usage' => $question_usage);
	}
}