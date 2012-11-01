<script type="text/javascript">
	function updateResult() {
		$('#search-result').load('<?php echo core::constructURL('question_usage', 'search', array(''), 'html')?>', { 'search_term' : $('#search-bar').val() } );
	}

	function addQuestion(qu_id) {
		$('#add-qu_id').val(qu_id);
		$('#add-question').submit();
	}

	function deleteQuestion(atqm_no) {
		$('#delete-atqm_no').val(qtqm_no);
		$('#delete-question').submit();
	}
</script>

<div id="featured">
	<div id="content">
	
<div class="question-usage-search">
	<input type="text" id="search-bar" value="" onChange="updateResult()">

	<div id="search-result">
		
	</div>
</div>

<form id="add-question" style="display: none" method="post" action="<?php echo core::constructURL('activity_template', 'edit', array($data['activity_template'] -> at_id), 'html'); ?>">
	<input type="hidden" id="add-action" name="action" value="add-question" />
	<input type="hidden" id="add-qu_id" name="qu_id" value="" />
</form>

<form id="delete-question" style="display: none" method="post" action="<?php echo core::constructURL('activity_template', 'edit', array($data['activity_template'] -> at_id), 'html'); ?>">
	<input type="hidden" id="delete-action" name="action" value="delete-question" />
	<input type="hidden" id="delete-atqm_no" name="atqm_no" value="" />
</form>

<h2><?php  echo core::escapeHTML($data['activity_template'] -> at_name); ?></h2>


<?php
foreach($data['activity_template'] -> list_activity_template_qm as $activity_template_qm) {
	/* Now render */
	echo "<div class=\"question-usage\">\n";
	$question = MixUp::generateQuestion($activity_template_qm -> question_usage -> qu_content);
	echo MixUp::questionToHTML($question);
	echo "<div class=\"question-usage-comment\">\n";
	echo core::escapeHTML($activity_template_qm -> question_usage -> qu_comment);
	echo "</div></div>";
}

?>
	<div style="clear: both"></div>
	</div>
</div>