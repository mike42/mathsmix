<script type="text/javascript">
	function updateResult() {
		$('#search-result').load('<?php echo core::constructURL('question_usage', 'search', array(''), 'html')?>', { 'search_term' : $('#search-bar').val() } );
	}
</script>

<div id="featured" class="grid col-940">
	<div class="grid">
	<div id="content">
	
<div style="float: right">
<input type="text" id="search-bar" value="" onChange="updateResult()">

<div id="search-result">
	
</div>

</div>
	
<h2><?php  echo core::escapeHTML($data['activity_template'] -> at_name); ?></h2>


<?php

//print_r($data);


?>

	</div>
	</div>
</div>