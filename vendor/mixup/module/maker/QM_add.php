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
		$terms = self::generateTerms($invocation);

		/* Sum them up */
		$sum = '0';
		foreach($terms as $term) {
			// TODO 
			$sum = bcadd($sum, $term, 0);
		}

		print_r($terms);
		echo "inline(\"".implode(" + ", $terms)."\") = " . $sum;
	}
}
?>