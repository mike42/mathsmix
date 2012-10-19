#!/usr/bin/php
<?php
/**
 * render.php:
 * 		Render a generated worksheet (list of viewer invocations)
 **/

require_once("MixUp.php");
$file = file_get_contents("php://stdin");
$lines = explode("\n", $file);

foreach($lines as $line) {
	$line = trim($line);
	if(strlen($line) > 0 && substr($line, 0, 1) != "#") {
		try{ 
			/* Generate question */
			echo MixUp::questionToHTML($line)."\n";
		} catch(Exception $e) {
			/* Show errors for failed questions */
			echo "# Viewer error: " . $e -> getMessage() ."\n";
			echo "# $line\n";
		}
	}
}
?>