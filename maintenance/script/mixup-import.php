#!/usr/bin/php
<?php
require_once(dirname(__FILE__)."/../../api/core.php");

core::loadClass("question_maker_model");
core::loadClass("MixUp");

/* Make sure all the makers are in the database */
$makers = scandir(dirname(__FILE__)."/../../vendor/mixup/module/maker/");
foreach($makers as $maker) {
	if(substr($maker, 0, 1) != '.') {
		addMaker(basename($maker, ".php"));
		require_once(dirname(__FILE__)."/../../vendor/mixup/module/maker/$maker");
	}
}

/* Make sure all the viewers are in the database */
$viewers = scandir(dirname(__FILE__)."/../../vendor/mixup/module/viewer/");
foreach($viewers as $viewer) {
	if(substr($viewer, 0, 1) != '.') {
		addViewer(basename($viewer, ".php"));
	}
}

function addMaker($qm_class) {
	if(!$question_maker = question_maker_model::get_by_qm_class($qm_class)) {
		$question_maker = new question_maker_model();
		$question_maker -> qm_class = $class_name;
		$question_maker -> qm_name  = substr($qm_class, 3, strlen($qm_class) - 3);
		$question_maker -> qm_id    = $question_maker-> insert();
		
	}
}

function addViewer($qv_class) {
	if(!$question_viewer = question_viewer_model::get_by_qv_class($qv_class)) {
		$question_viewer = new question_viewer_model();
		$question_viewer -> qv_class = $qv_class;
		$question_viewer -> qv_name  = substr($qv_class, 3, strlen($qv_class) - 3);
		$question_viewer -> qv_id    = $question_viewer -> insert();
	}
}


?>
