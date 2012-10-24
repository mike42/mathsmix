<div id="featured" class="grid col-940">
	<div id="content">
<?php
if(isset($data['year_levels'])) {
	echo "<h1>Classes at " . core::escapeHTML($data['school'] -> school_name) . "</h1>";
	foreach($data['year_levels'] as $year_level) {
		echo "<h3>" . $year_level -> yl_name . " [<a href=\"" . core::constructURL('classes', 'create', array($year_level -> yl_id), 'html') . "\">+</a>]</h3>";
		echo "";
		if(count($year_level -> list_classes) > 0) {
			echo "<ul>";
			foreach($year_level -> list_classes as $class) {
				echo "<li><a href=\"". core::constructURL('classes', 'view', array($class -> class_id), 'html') . "\">". core::escapeHTML($class -> class_name) ."</a> <small>&mdash; ". core::escapeHTML($class -> class_year) . "</small></li>";
			}
			echo "</ul>";
		}
	}
} else {
	/* Class membership box */
	echo "<div class=\"class-members\">";
	/* Teacher edit button */
	echo "<a style=\"float: right\" href=\"".core::constructURL('classes', 'teaches', array($data['class'] -> class_id), 'html') . "\">";
	echo "<img src=\"".$config['webroot']."img/edit.jpg\" alt=\"edit\" /></a>";
	echo "<h3>Teachers</h3>";
	if(count($data['class'] -> list_teaches) > 0) {
		echo "<ul>";
		foreach($data['class'] -> list_teaches as $teaches) {
			echo "<li>".core::escapeHTML($teaches -> user -> user_firstname . " " . $teaches -> user -> user_surname)."</li>";
		}
		echo "</ul>";
	} else {
		echo "<i>None yet!</i>";
	}

	echo "<div style=\"clear: both\"></div>";
	/* Student edit button */
	echo "<a style=\"float: right\" href=\"".core::constructURL('classes', 'attends', array($data['class'] -> class_id), 'html') . "\">";
	echo "<img src=\"".$config['webroot']."img/edit.jpg\" alt=\"edit\" /></a>";
	echo "<h3>Students</h3>";
	if(count($data['class'] -> list_attends) > 0) {
		echo "<ul>";
		foreach($data['class'] -> list_attends as $attends) {
			echo "<li>".core::escapeHTML($attends -> user -> user_firstname . " " . $attends -> user -> user_surname)."</li>";
		}
		echo "</ul>";
	} else {
		echo "<i>None yet!</i>";
	}
	echo "</div>\n";

	echo "<h1>". core::escapeHTML($data['class'] -> class_name) . "</h1>";
	echo "<div class=\"subtitle\">" . core::escapeHTML($data['class'] -> year_level -> yl_name . ", " . $data['class'] -> class_year) . "</div>";
}
?>
	</div>
</div>