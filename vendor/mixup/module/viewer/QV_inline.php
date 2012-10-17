<?php 
class QV_inline extends QuestionViewer {
	public function listExamples() {
		return array(
			"inline(\"1 + 1\") = (2)");
	}

	public function getDescription() {
		return "Show a question in a single line with the answer box on the right";
	}
	
	public function toHTML($invocation) {
		print_r($invocation);
		return "";
	}
}

?>