<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN"
        "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<?php
session_start();
if (strcmp($_SESSION['login'], 'false') == 0) {
  header('Location: index.php');
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Beneficiary Voucher Repository System</title>
    <link rel="stylesheet" href="../css/style.css" type="text/css"
          media="screen">
</head>
<body>

<?php
include_once 'dbconnect.php';

$q1 = $_POST['q1'];
$q2 = $_POST['q2'];
$q2mins = $_POST['minutes'];
$q2hrs = $_POST['hours'];
$comment = $_POST['comment'];
$q3 = $_POST['q3'];
$q4 = $_POST['q4'];
$q5 = $_POST['q5'];
$q6 = $_POST['q6'];

$serialno = $_POST['serialno'];
$update = $_POST['update'];
$period = $_POST['period'];
$orgunitid = $_POST['orgunitid'];

$username = $_SESSION['username'];
$dateadded = date("d/m/Y");

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

if (trim($q2hrs) == '') {
  $q2hrs = 'null';
}
if (trim($q2mins) == '') {
  $q2mins = 'null';
}

if (strcmp($update, 'no') == 0) {
  $query
      = "INSERT INTO cboscore(q1,q2,q3,q4,q5,q6,serialno,periodid,facilityid,hours,minutes,comment,addedby,dateadded) "
      ." VALUES ($q1,$q2,$q3,$q4,$q5,$q6,'$serialno',$period,$orgunitid,$q2mins,$q2hrs,'$comment','$username','$dateadded')";
} else {
  $query
      = "update cboscore set q1=$q1,q2=$q2,q3=$q3,q4=$q4,q5=$q5,q6=$q6,hours=$q2hrs,minutes=$q2mins,comment='$comment'"
      ." where periodid=$period and facilityid=$orgunitid and serialno='$serialno'";
}

//echo '<br />'.$query.'<br />';

$result = pg_query($query);
if ( ! $result) {
  $errormessage = pg_last_error();
  echo "Error with query: ".$errormessage;
  exit();
}
$msg = "success";
pg_close();
echo "<br />Questionnaire <em>$serialno</em> updated successfully<br />";
?>
<form action="cboscore.php" method="POST">
    <input type="hidden" name="period" value="<?php echo $period; ?>"/>
    <input type="hidden" name="distributor" value="<?php echo $orgunitid; ?>"/>
    Next Serial No: <input type="text" name="serialno"/>
    <input type="submit" value="Next Questionnaire"/>
</form>
<?php
//header("Location: main.php?page=cboscore_form");    
pg_close();
?>
<?php include "footer.php"; ?>
</body>
</html>