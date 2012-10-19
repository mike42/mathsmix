#!/usr/bin/php
<?php
/**
 * generate.php:
 * 		Generate a worksheet based on a template (list of question invocations)
 **/

require_once("MixUp.php");
$file = file_get_contents("php://stdin");
$lines = explode("\n", $file);

foreach($lines as $line) {
	$line = trim($line);
	if(strlen($line) > 0 && substr($line, 0, 1) != "#") {
		try{ 
			/* Generate question */
			echo MixUp::generateQuestion($line)."\n";
		} catch(Exception $e) {
			/* Show errors for failed questions */
			echo "# Maker error: " . $e -> getMessage() ."\n";
			echo "# $line\n";
		}
	}
}
?>