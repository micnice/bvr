<?php
date_default_timezone_set('Africa/Harare');

$monthNum = 5;
$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
echo $monthName; //output: May
?>