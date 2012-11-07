<?php

foreach($data['attempt'] -> activity -> list_activity_question as $activity_question) {
	$content = $activity_question -> aq_content;
	echo MixUp::questionToHTML($content);
}