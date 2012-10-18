<?php 
require_once(dirname(__FILE__) . "/Invocation.php");

class QuestionMakerInvocation extends Invocation {	
	public function QuestionMakerInvocation($string) {
		if(trim($string) == "") {
			throw new Exception("Invocation string was empty.");
		}
		
		/* Set original invocation string */
		$this -> invocation_string = $string;
		
		/* Get the viewer name */
		$remainder = $this -> get_maker();
		
		/* Get the question maker name */
		$remainder = $this -> get_viewer($remainder);
		
		/* Grab arguments */
		$part = $this -> get_arguments(substr($remainder, 1, strlen($remainder) - 1));
		$this -> arg = $part['arg'];
		$remainder = $part['remainder'];
		
		/* Get comment if set */
		if(!(strpos($remainder, "#") === false)) {
			$i = strpos($remainder, "#") + 1;
			$this -> comment = trim(substr($remainder, $i, strlen($remainder) - $i));
		}		
		return;
	}
}
?>