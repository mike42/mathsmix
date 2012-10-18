<?php 
class QV_inline extends QuestionViewer {
	public static function listExamples() {
		return array(
			"inline(\"1 + 1\") = (2)");
	}

	public static function getDescription() {
		return "Show a question in a single line with the answer box on the right";
	}

	public static function toHTML(QuestionViewerInvocation $invocation) {
		return "<div class=\"qv-inline\">" . 
				$invocation -> arg[0] . 
				" = <input type=\"text\" value=\"\"/>" .
				"</div>";
	}
}

?>
