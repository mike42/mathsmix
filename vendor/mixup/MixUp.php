<?php
require_once(dirname(__FILE__)."/lib/QuestionMaker.php");
require_once(dirname(__FILE__)."/lib/QuestionViewer.php");
require_once(dirname(__FILE__)."/lib/QuestionMakerInvocation.php");
require_once(dirname(__FILE__)."/lib/QuestionViewerInvocation.php");

class MixUp {
	public static function generateQuestion($string) {
		$invocation = new QuestionMakerInvocation($string);
		print_r($invocation);
		return false;
	}

	public static function questionToHTML($string) {
		return false;
	}
}
?>
