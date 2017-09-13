<?php
include_once 'dbconnect.php';

$q1 = $_POST['q1'];
$q2 = $_POST['q2'];
$q3 = $_POST['q3'];
$q4 = $_POST['q4'];
$q5 = $_POST['q5'];
$q6 = $_POST['q6'];
$q7 = $_POST['q7'];
$q8 = $_POST['q8'];
$q9 = $_POST['q9'];
$q10 = $_POST['q10'];
$q11 = $_POST['q11'];
$q12 = $_POST['q12'];
$q13 = $_POST['q13'];
$q14 = $_POST['q14'];
$q15 = $_POST['q15'];
$q16 = $_POST['q16'];
$q17 = $_POST['q17'];
$q18 = $_POST['q18'];
$update = $_POST['update'];
$period = $_POST['period'];
$totalscore = $_POST['totalscore'];
$orgunitid = $_POST['orgunitid'];

if (trim($q1) == '') {
  $q1 = 'null';
}
if (trim($q2) == '') {
  $q2 = 'null';
}
if (trim($q3) == '') {
  $q3 = 'null';
}
if (trim($q4) == '') {
  $q4 = 'null';
}
if (trim($q5) == '') {
  $q5 = 'null';
}
if (trim($q6) == '') {
  $q6 = 'null';
}
if (trim($q7) == '') {
  $q7 = 'null';
}
if (trim($q8) == '') {
  $q8 = 'null';
}
if (trim($q9) == '') {
  $q9 = 'null';
}
if (trim($q10) == '') {
  $q10 = 'null';
}
if (trim($q11) == '') {
  $q11 = 'null';
}
if (trim($q12) == '') {
  $q12 = 'null';
}
if (trim($q13) == '') {
  $q13 = 'null';
}
if (trim($q14) == '') {
  $q14 = 'null';
}
if (trim($q15) == '') {
  $q15 = 'null';
}
if (trim($q16) == '') {
  $q16 = 'null';
}
if (trim($q17) == '') {
  $q17 = 'null';
}
if (trim($q18) == '') {
  $q18 = 'null';
}
if (trim($totalscore) == '') {
  $totalscore = 'null';
}

$username = $_SESSION['username'];
$dateadded = date('d/m/Y');

if (strcmp($update, 'no') == 0) {
  $query
      = "INSERT INTO qualitychecklist(q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,q11,q12,q13,q14,q15,q16,q17,q18,periodid,facilityid,totalscore,addedby,dateadded) "
      ." VALUES ($q1,$q2,$q3,$q4,$q5,$q6,$q7,$q8,$q9,$q10,$q11,$q12,$q13,$q14,$q15,$q16,$q17,$q18,$period,$orgunitid,$totalscore,'$username','$dateadded')";
} else {
  $query
      = "update qualitychecklist set q1=$q1,q2=$q2,q3=$q3,q4=$q4,q5=$q5,q6=$q6,q7=$q7,q8=$q8,q9=$q9,q10=$q10,q11=$q11,q12=$q12,q13=$q13,q14=$q14,q15=$q15,q16=$q16,q17=$q17,q18=$q18,"
      ." totalscore=$totalscore where periodid=$period and facilityid=$orgunitid";
}


$result = pg_query($query);
if ( ! $result) {
  $errormessage = pg_last_error();
  echo "Error with query: ".$errormessage;
  exit();
}
$msg = "success";
echo "Quality Checklist updated successfully";
pg_close();

header("Location: main.php?page=qualitychecklist_form");
pg_close();
?>

