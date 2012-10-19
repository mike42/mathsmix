<?php 
class QM_pow extends QuestionMaker {
	public static function listExamples() {
		return array(
			"pow inline({1, 12}, 2) # Base from 1-12, power of 2");
	}
	
	public static function listViewers() {
		return array("inline", "worded");
	}
	
	public static function getDescription() {
		return "Simple integer exponentation problems";
	}

	public static function make(QuestionMakerInvocation $invocation) {
		if(!MixUp::onlyNumbers($invocation -> arg)) {
			throw new Exception("This maker only accepts numbers");
		}
		if(!count($invocation -> arg == 2)) {
			throw new Exception("This maker needs 2 arguments");
		}
		
		$base = $invocation -> arg[0];
		$power = $invocation -> arg[1];
		
		$result = bcpow($base, $power);
		switch($invocation -> viewer) {
			case "worded":
				return "worded(\"Find $base to the power of $power\") = ($result)";
			case "inline":
				return "inline(\"$base<sup>$power</sup>\") = ($result)";
			default:
				throw new Exception("Maker does not support that viewer");
		}
	}
}

?>