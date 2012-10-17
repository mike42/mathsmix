<?php
abstract class QuestionMaker {
	/* Provide a few invocation examples */
	public abstract static function listExamples();

	/* Return list of viewers this question maker can output */
	public abstract static function listViewers();

	/* Provide a short description of the question maker */
	public abstract static function getDescription();

	/* Generate question. $viewer is the name of the viewer to output to, $input is an array of arguments */
	public abstract static function make(QuestionMakerInvocation $invocation);
}
?>
