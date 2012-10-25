<?php
class MixUp {
	/* Number of digits to perform all calculations to */
	public static $PRECISION_MAX = 100;

	public static function generateQuestion($string) {
		/* Parse invocation */
		require_once(dirname(__FILE__). "/lib/QuestionMakerInvocation.php");
		require_once(dirname(__FILE__). "/lib/QuestionMaker.php");
		$invocation = new QuestionMakerInvocation($string);

		/* Generate question */
		$class_name = "QM_". $invocation -> maker;
		require_once(dirname(__FILE__). "/module/maker/$class_name.php");
		return call_user_func_array(array($class_name, "make"), array($invocation));
	}

	public static function questionToHTML($string) {
		/* Parse invocation */
		require_once(dirname(__FILE__). "/lib/QuestionViewerInvocation.php");
		require_once(dirname(__FILE__). "/lib/QuestionViewer.php");
		$invocation = new QuestionViewerInvocation($string);
		
		/* Generate HTML */
		$class_name = "QV_". $invocation -> viewer;
		require_once(dirname(__FILE__). "/module/viewer/$class_name.php");
		return call_user_func_array(array($class_name, "toHTML"), array($invocation));
	}
	
	public static function onlyArray($input) {
		foreach($input as $item) {
			if(!is_array($item)) {
				return false;
			}
		}
		return true;
	}
	
	public static function onlyNumbers($input) {
		foreach($input as $item) {
			if(!is_numeric($item)) {
				return false;
			}
		}
		return true;
	}
	
	public static function noArray($input) {
		foreach($input as $item) {
			if(is_array($item)) {
				return false;
			}
		}
		return true;
	}
}
?>
