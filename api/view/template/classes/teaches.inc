<div id="featured" class="grid col-940">
	<div class="grid">
	<div id="content">
<h2>Teachers in <?php  echo core::escapeHTML($data['class'] -> class_name); ?></h2>
<h3>Remove current</h3>

<form action="<? echo core::constructURL('classes', 'teaches', array((int)$data['class'] -> class_id), 'html'); ?>" method="post">
<?php
	if(count($data['members']) > 0) {
		echo "<p>Un-check any people on this list who you wish to remove from the class.</p>";
		echo "<table>";
		foreach($data['members'] as $teaches) {
			echo "<tr>";
			echo "<td width=\"1em\"><input type=\"checkbox\" checked name=\"keep_" . $teaches -> user -> user_id."\"></td>";
			echo "<td>".$teaches -> user -> user_firstname . " " . $teaches -> user -> user_surname ."</td>";
			echo "</tr>";
		}
		echo "</table>";
	} else {
		echo "<p><i>There are currently no teachers for this class!</i></p>";
	}
	?>

<h3>Add others</h3>

<?php
	echo "<p>Check the names of teachers below to add them to the class.</p>";
	echo "<table>";
	foreach($data['candidates'] as $user) {
		echo "<tr>";
		echo "<td width=\"1em\"><input type=\"checkbox\" name=\"add_".$user -> user_id."\"></td>";
		echo "<td>".$user -> user_firstname . " ". $user -> user_surname ."</td>";
		echo "</tr>";
	}
	echo "</table>";
	?>

<div style="float: right">
	<input type="button" name="cancel" value="Go back" onClick="window.location='<?php echo core::constructURL('classes', 'view', array($data['class'] -> class_id), 'html'); ?>'" />
	<input type="submit" name="submit" value="Submit changes" />
</div>
</form>
	</div>
	</div>
</div>

