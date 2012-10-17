<?php
abstract class QuestionViewer {
	/* Provide a few invocation examples */
	public abstract static function listExamples();

	/* Provide a short description of the question viewer */
	public abstract static function getDescription();

	/* Output to HTML form */
	public abstract static function toHTML(QuestionViewerInvocation $invocation);
}
?>
