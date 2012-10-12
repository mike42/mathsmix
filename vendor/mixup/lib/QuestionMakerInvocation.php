<?php 
class QuestionMakerInvocation {
	public $invocation_string;
	public $viewer;
	public $maker;
	public $arg;
	
	public function QuestionMakerInvocation($string) {
		/* Set original invocation string */
		$this -> invocation_string = $string;
		
		/* Get the viewer name */
		$remainder = $this -> process_viewer();
		
		/* Get the question maker name */
		$remainder = $this -> process_maker($remainder);
		
		/* Grab arguments */
		$part = $this -> get_arguments(substr($remainder, 1, strlen($remainder) - 1));
		$this -> arg = $part['arg'];
		$remainder = $part['remainder'];
		
		/* AAAAA */
		echo $remainder;
		
		return;
	}
	
	/**
	 * Find the viewer part of the invocation string
	 * 
	 * @return string the invocation string minus the viewer name
	 */
	private function process_viewer() {
		$l = strpos($this -> invocation_string, ' ');
		// TODO: failure case if string contains no spaces before first open bracket */
		$this -> viewer = substr($this -> invocation_string, 0, $l);
		/* Now skip the space and return the rest of the string */
		$l++;
		return substr($this -> invocation_string, $l, strlen($this -> invocation_string) - $l);
	}
	
	/**
	 * @param string $remaining_invocation_string	The string without the viewer name
	 * @return string portion of the invocation to the right of the viewer name
	 */
	private function process_maker($remaining_invocation_string) {
		$l = strpos($remaining_invocation_string, '(');
		$this -> maker = trim(substr($remaining_invocation_string, 0, $l));
		return trim(substr($remaining_invocation_string, $l, strlen($remaining_invocation_string) - $l));
	}
	
	private function get_arguments($text) {
		echo $text."\n";
		sleep(1);
		$arg = array();
		$current = "";
		
		for($i = 0; $i < strlen($text); $i++) {
			$c = substr($text, $i, 1);
			switch($c) {
				case ")":
					$arg[] = $current;
					$i++;
					$remainder = substr($text, $i, strlen($text) - $i);
					return array('arg' => $arg, 'remainder' => $remainder);
					break;
				case "(":
					if(is_array($current)) {
						throw new Exception('Syntax error: Bracketed expressions must be separated by commas.');
					}
					$i++;
					$remainder = substr($text, $i, strlen($text) - $i);
					$part = $this -> get_arguments($remainder);
					$current = $part['arg'];
					$text = $part['remainder'];
					$i = -1;
					break;
				case "{":
					/* Curly brace. Get random number */
					if(is_array($current)) {
						throw new Exception('Syntax error: Bracketed expression must be followed by a comma, but a range { .. } was found.');
					}
					$i++;
					$text = substr($text, $i, strlen($text) - $i);
					$part = $this -> get_random_in_range($text);
					$current .= $part['arg'];
					$i = -1;
					$text = $part['remainder'];
					break;
				case "\"":
					/* This argument is a string literal */
					if(is_array($current)) {
						throw new Exception('Syntax error: Bracketed expression must be followed by a comma, but a string literal was found.');
					}
					$i++;
					$text = substr($text, $i, strlen($text) - $i);
					$part = $this -> get_string_literal($text);
					$current .= $part['arg'];
					$i = -1;
					$text = $part['remainder'];
					break;
				case ",":
					$arg[] = $current;
					$current = "";
					break;
				default:
					if(!is_array($current) && ($current != "" || $c != " ")) {
						/* If current is not an array, and we're not adding a space to an empty string ... */
						$current .= $c;
					} else if(is_array($current) && $c != " ") {
						throw new Exception('Syntax error: Bracketed expressions must be followed by a comma.');
					}
			}
		}
		
		throw new Exception("No matching close-bracket in expression.");
	}
	
	private function get_string_literal($text) {
		$outp = "";
		$l = strlen($text);
		for($i = 0; $i < $l; $i++) {
			if(substr($text, $i, 2) == "\\\"") {
				/* Hit escaped quote. Add to output. */
				$outp .= "\"";
				$i++;
			} else if(substr($text, $i, 1) == "\"") {
				/* Hit close-quote */
				$i++;
				/* Find out what is beyond the quote and return that */
				$remainder = substr($text, $i, strlen($text) - $i);
				return array('arg' => $outp, 'remainder' => $remainder);
			} else {
				$outp .= substr($text, $i, 1);
			}
		}
		
		throw new Exception('Missing close quote in expression.');
	}
	
	private function get_random_in_range($text) {
		$outp = "";
		$l = strlen($text);
		for($i = 0; $i < $l; $i++) {
			if(substr($text, $i, 1) == "}") {
				$part = explode(",", substr($text, 0, $i));
				if(count($part) != 2) {
					throw new Exception('Must be two terms inside curly braces, separated by a comma, eg {0, 1}.');
				} else if(!(is_numeric($part[0]) && is_numeric($part[1]))) {
					throw new Exception('Terms inside curly braces must be text.');
				}
				/* Cast to integer and check that these are in order*/
				$part[0] = (int)$part[0];
				$part[1] = (int)$part[1];
				if($part[0] > $part[1]) {
					throw new Exception('Smaller term must appear first in expression');
				}
				
				/* Choose and return random number */
				$num = rand($part[0], $part[1]);		
				$i++;
				$remainder = substr($text, $i, strlen($text) - $i);
				return array('arg' => $num, 'remainder' => $remainder);
			}
		}
	
		/* No close brace */
		throw new Exception('Missing close brace in expression.');
	}
}
?>