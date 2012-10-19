<?php 
class QV_worded extends QuestionViewer {
	public static function listExamples() {
		return array(
			"worded(\"Find the sum of 1 and 2\") = (3)");
	}

	public static function getDescription() {
		return "Show a worded question with the answer box below it, without an 'equals' sign.";
	}

	public static function toHTML(QuestionViewerInvocation $invocation) {
		return "<div class=\"qv-inline\">" . 
				$invocation -> arg[0] . 
				"<br /><input type=\"text\" value=\"\"/>" .
				"</div>";
	}
}
?>
