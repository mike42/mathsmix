<?php 
class QM_add extends QuestionMaker {
	public static function listExamples() {
		return array(
			"sub inline(5, 2)");
	}

	public static function listViewers() {
		return array("inline");
	}
	
	public static function getDescription() {
		return "Subtraction problems";
	}
	
	public static function make(QuestionMakerInvocation $invocation) {
		$terms = self::generateTerms($invocation);
		
		/* Sum them up */
		bcscale(MixUp::$PRECISION_MAX);
		$sum = '0';
		foreach($terms as $term) {
			$sum = bcsub($sum, $term);
		}
		
		$sum = self::removeTrailingZeroes($sum);
		return "inline(\"".implode(" - ", $terms)."\") = (" . $sum . ")";
	}
}
?>
