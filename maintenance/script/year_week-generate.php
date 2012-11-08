#!/usr/bin/php
<?php
require_once(dirname(__FILE__)."/../../api/core.php");
core::loadClass('year_week_model');

/* Number the next 3 decades worth of weeks */
$date = new DateTime('2012-01-01');

$yw_year = "";
$yw_week = "";

for($i = 0; $i < (52 * 10); $i++) {	
	/* Adjust current week and year */
	$year = $date -> format('Y');
	if($year != $yw_year) {
		$yw_year = $year;
		$yw_week = 0;
	}
	$yw_week++;
	
	/* Make object */
	$year_week = new year_week_model();
	$year_week -> yw_year = $yw_year;
	$year_week -> yw_week = $yw_week;

	$year_week -> yw_start = $date -> format('Y-m-d');
	$date -> add(date_interval_create_from_date_string('6 days'));
	$year_week -> yw_end = $date -> format('Y-m-d');
	$date = $date -> add(date_interval_create_from_date_string('1 day'));
	
	if(!$year_week_test = year_week_model::get_by_yw_yearwk($yw_year, $yw_week)) {
		$year_week -> year_week_id = $year_week -> insert();
	}
	echo $date->format('Y-m-d') . "\n";
}
?>