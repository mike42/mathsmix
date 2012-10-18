#!/usr/bin/php
<?php
require_once("MixUp.php");

/* Example of the kind of interface we're aiming for */
$a = MixUp::generateQuestion("add inline(3, 2, 1, 0) # 3 term addition, 2 digit numbers + 1 after decimal place, no negatives");
echo MixUp::questionToHTML($a);

$b = MixUp::generateQuestion("add inline(5, 2, 1, 1) # 5 term addition, 3 digit numbers (no decimals), negatives allowed");
echo $b."\n";
echo MixUp::questionToHTML($b);

$c = MixUp::generateQuestion("add inline((5, 1, 0), (7, 1, 1)) # add a 5 digit positive number and a 7 digit negative number, 1 decimal place.");
echo $c."\n";
echo MixUp::questionToHTML($c);

//echo MixUp::questionToHTML("inline(\"5 + 4 + 2\") = 11");


?>
