<?php
abstract class QuestionViewer {
	/* Provide a few invocation examples */
	public abstract function listExamples();

	/* Provide a short description of the question viewer */
	public abstract function getDescription();

	/* Output to HTML form */
	public abstract function toHTML($question, $answers);
}
?>
