<?php 
require_once(dirname(__FILE__) . "/Invocation.php");
/**
 * This class parses a string constaining a question, in order to pass it on to a question viewer
 */
class QuestionViewerInvocation extends Invocation {
	public $invocation_string;
	public $viewer;
	public $arg;
	public $ans;
	public $comment;
	
	public function QuestionViewerInvocation($string) {
		if(trim($string) == "") {
			throw new Exception("Invocation string was empty.");
		}
		
		/* Set original invocation string */
		$this -> invocation_string = $string;
		
		/* Get the viewer name */
		$remainder = $this -> get_viewer($string);
		
		/* Grab arguments */
		$part = $this -> get_arguments(substr($remainder, 1, strlen($remainder) - 1));
		$this -> arg = $part['arg'];
		$remainder = $part['remainder'];
		
		$remainder = trim($remainder);
		if(substr($remainder, 0, 1) != "=") {
			throw new Exception("No answer given in QuestionViewer");
		}
		
		/* Get comment if set */
		if(!(strpos($remainder, "#") === false)) {
			$i = strpos($remainder, "#") + 1;
			$this -> comment = trim(substr($remainder, $i, strlen($remainder) - $i));
		}
		return;
	}
}
?>