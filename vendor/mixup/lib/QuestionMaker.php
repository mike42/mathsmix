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
	
	/**
	 * @param integer $digit_count		Number of digits (before decimal place) for this number
	 * @param integer $decimal_count	Number of digits (after decimal place) for this number
	 * @param boolean $is_negative		True if the number should be negative, false otherwise
	 * @return string					The generated number. This will never have a leading zero (or trailing zero if it has decimals)
	 */
	public static function makeNumber($digit_count, $decimal_count = 0, $is_negative = false) {
		$digits = "0123456789";
		$number = $is_negative ? "-" : "";
	
		/* Make number */
		for($i = 0; $i < $digit_count; $i++) {
			/* First digit cannot be 0 */
			$number .= substr($digits, rand(($i == 0)? 1 : 0, strlen($digits) - 1), 1);
		}
	
		/* Add decimal digits */
		if($decimal_count > 0) {
			$number .= ".";
			for($i = 0; $i < $decimal_count; $i++) {
				/* Last digit cannot be 0 */
				$number .= substr($digits, rand(($i == $decimal_count - 1)? 1 : 0, strlen($digits) - 1), 1);
			}
		}
		return $number;
	}	
	
	/**
	 * Generate a series of terms based on the invovation (the common format for arithmetic functions)
	 * 
	 * @param QuestionMakerInvocation $invocation
	 * @throws Exception
	 */
	public static function generateTerms(QuestionMakerInvocation $invocation) {
		$number = array();
		/* Verify input and construct terms */
		if(is_array($invocation -> arg[0])) {
			/* If it starts with an array, check that it is only array through the whole thing */
			if(!MixUp::onlyArray($invocation -> arg)) {
				throw new Exception('List of terms expected');
			}
			
			/* A list of definitions for each term has been provided */
			foreach($invocation -> arg as $arg){
				if(!MixUp::onlyNumbers($arg)) {
					throw new Exception('Expected definition of a term, but found a list');
				}
				while(count($arg) < 3) {
					$arg[] = "0";
				}
				/* Add to $number */
				$digits = $arg[0];
				$decimals = $arg[1];
				$negative = $arg[2];
				$number[] = self::makeNumber($digits, $decimals, $negative);
			}				
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
			
			for($i = 0; $i < $invocation -> arg[0]; $i++) {
				/* Randomly choose lengths up to this */
				$digits = rand(1, $invocation -> arg[1]);
				$decimals = rand(0, $invocation -> arg[2]);
				$negative = rand(0, $invocation -> arg[3]) == 1;
				$number[] = self::makeNumber($digits, $decimals, $negative);
			}
		}
		return $number;
	}

	/**
	 * Remove trailing zeroes from a calculation.
	 * Retrieved from http://www.php.net/manual/en/function.bcscale.php#107259
	 **/
	public static function removeTrailingZeroes($input) {
		$patterns = array('/[\.][0]+$/','/([\.][0-9]*[1-9])([0]*)$/');
		$replaces = array('','$1');
		return preg_replace($patterns,$replaces,$input);
	}
}
?>
