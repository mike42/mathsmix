<?php
class question_usage_view {
	function init() {
		core::loadClass("MixUp");
	}
	
	function search_html($data) {
		if($data['search_term'] == '') {
			echo "Enter search terms in the box above to find questions.";
		} else if(count($data['question_usage']) == 0) {
			echo "No questions found";
		} else {
			/* Print unencapsulated search results */
			foreach($data['question_usage'] as $question_usage) {
				echo "<div class=\"question-usage\" onClick=\"addQuestion(".$question_usage -> qu_id.")\">\n";
				$question = MixUp::generateQuestion($question_usage -> qu_content);
				echo MixUp::questionToHTML($question);
				echo "<div class=\"question-usage-comment\">\n";
				
				$split = explode($data['search_term'], $question_usage -> qu_comment);
				foreach($split as $key => $val) {
					$split[$key] = core::escapeHTML($split[$key]);
				}
				echo implode("<span class=\"highlight\">".core::escapeHTML($data['search_term'])."</span>", $split);
				echo "</div>\n";
				echo "</div>\n";
			}
		}
	}
}