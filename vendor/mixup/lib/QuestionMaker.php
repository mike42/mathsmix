<?php
abstract class QuestionMaker {
	/* Provide a few invocation examples */
	public abstract function listExamples();

	/* Return list of viewers this question maker can output */
	public abstract function listViewers();

	/* Provide a short description of the question maker */
	public abstract function getDescription();

	/* Generate question. $viewer is the name of the viewer to output to, $input is an array of arguments */
	public abstract function generate($viewer, $input);
}
?>
