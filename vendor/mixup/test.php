#!/usr/bin/php
<?php
require_once("MixUp.php");

/* Example of the kind of interface we're aiming for */
echo MixUp::generateQuestion("inline add({2,3}, 0, \"foo{ aaa\\\" } \", foo foo random: {1,100} foo bar, (baz, quux, {3,5}))");
//echo MixUp::questionToHTML("inline(\"5 + 4 + 2\") = 11");


?>
