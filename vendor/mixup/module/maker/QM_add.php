<?php 
class QM_add extends QuestionMaker {
	public static function listExamples() {
		return array(
				"inline add(5, 2)");
	}

	public static function listViewers() {
		return array("inline");
	}
	
	public static function getDescription() {
		return "Addition problems";
	}
	
	public static function make(QuestionMakerInvocation $invocation) {
		/* Verify input and construct terms */
		if(is_array($invocation -> arg[0])) {
			/* If it starts with an array, check that it is only array through the whole thing */
			if(!MixUp::onlyArray($invocation -> arg)) {
				throw new Exception('Invalid call');
			}
			
			// TODO: processing here
			
		} else {
			if(!MixUp::onlyNumbers($invocation -> arg)) {
				throw new Exception('Invalid call');
			}
			
			if(count($invocation -> arg) == 2) {
				/* Assume no decimal digits if not specified */
				$invocation[] = "0";
			}
			if(count($invocation -> arg) == 3) {
				/* Assume non-negatives if not specified */
				$invocation[] = "0";
			}
			if(count($invocation -> arg) > 4) {
				throw new Exception('Too many arguments');
			}

			// TODO: process here
		}
		return "inline(\" ... \") = 0";
	}
}
?>