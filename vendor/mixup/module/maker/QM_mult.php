<?php 
class QM_mult extends QuestionMaker {
	public static function listExamples() {
		return array(
			"mult inline(5, 2)");
	}

	public static function listViewers() {
		return array("inline");
	}
	
	public static function getDescription() {
		return "Multiplication problems";
	}
	
	public static function make(QuestionMakerInvocation $invocation) {
		$terms = self::generateTerms($invocation);
		
		/* Sum them up */
		bcscale(MixUp::$PRECISION_MAX);
		$product = array_shift($terms);
		foreach($terms as $term) {
			$product = bcmul($product, $term);
		}
		
		$product = self::removeTrailingZeroes($product);
		return "inline(\"".implode(" × ", $terms)."\") = (" . $product. ")";
	}
}
?>