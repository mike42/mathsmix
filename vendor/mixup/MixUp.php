<?php
function __autoload($class_name) {
	switch(substr($class_name, 0 ,3)) {
		case "QM_":
			require_once(dirname(__FILE__). "/module/maker/$class_name.php");
			break;
		case "QV_":
			require_once(dirname(__FILE__). "/module/viewer/$class_name.php");
			break;
		default:
			require_once(dirname(__FILE__). "/lib/$class_name.php");
	}
}

class MixUp {
	/* Number of digits to perform all calculations to */
	public static $PRECISION_MAX = 100;

	public static function generateQuestion($string) {
		$invocation = new QuestionMakerInvocation($string);
		return call_user_func_array(array("QM_". $invocation -> maker, "make"), array($invocation));
	}

	public static function questionToHTML($string) {
		$invocation = new QuestionViewerInvocation($string);
		return call_user_func_array(array("QV_". $invocation -> viewer, "toHTML"), array($invocation));
		return false;
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
