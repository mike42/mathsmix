<div id="featured" class="grid col-940">
	<div class="grid">
	<div id="content">
<?php 
if($data['role'] == 'teacher') {
	echo "<h2>Teachers in ". core::escapeHTML($data['class'] -> class_name) . "</h2>";
} else {
	echo "<h2>Students in ". core::escapeHTML($data['class'] -> class_name) . "</h2>";
}
?>	
<h3>Remove current</h3>
<p>Un-check any people on this list who you wish to remove from the class.</p>
<table>
<?php
	foreach($data['members'] as $member) {
		echo $member -> user_firstname;		
	}?>


</table>

<h3>Add others</h3>
<p>Check the names of people below to add them to the class.</p>
	<?php
print_r($data); ?>
	</div>
	</div>
</div>

