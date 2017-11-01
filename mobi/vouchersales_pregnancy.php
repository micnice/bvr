<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN"
        "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<?php
session_start();
$_SESSION['social_process'] = "false";
if (strcmp($_SESSION['login'], 'false') == 0) {
  header('Location: index.php');
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Welcome to the Beneficiary Voucher Repository System</title>
    <link rel="stylesheet" href="../css/style.css" type="text/css"
          media="screen">
</head>
<body style="text-align: center;">

<?php
include_once 'dbconnect.php';

$firstname = strtolower(trim($_POST['firstname']));
$surname = strtolower(trim($_POST['surname']));
$nationalid = strtolower(trim($_POST['nationalid']));
$pregnancy = intval(strtolower(trim($_POST['pregnancy'])));

?>
<?php
$query
    = "UPDATE beneficiarymaster SET pregnancy=$pregnancy where lower(trim(nationalid))=lower(trim('$nationalid'))";
//echo '<br />'.$query.'<br />';
$result = pg_query($query);
if ( ! $result) {
  $errormessage = pg_last_error();
  echo "Error with query: ".$errormessage;
  exit();
}

$pregQuery
    = "UPDATE pregnancyregistration SET closed=TRUE where idbeneficiarymaster = (select idbeneficiarymaster from beneficiarymaster where lower(trim(nationalid))=lower(trim('$nationalid')))";
//echo '<br />'.$query.'<br />';
$result = pg_query($pregQuery);
if ( ! $result) {
  $errormessage = pg_last_error();
  echo "Error with query: ".$errormessage;
  exit();
}

$saleQuery
    = "UPDATE vouchersales SET closed=TRUE where lower(trim(nationalid))=lower(trim('$nationalid'))";

$result = pg_query($saleQuery);
if ( ! $result) {
  $errormessage = pg_last_error();
  echo "Error with query 1: ".$errormessage;
  exit();
}

pg_close();
?>
<h3 style="text-align: center; color: green;">Second Pregnancy Activation
    Succssful</h3>
<form action="vouchersales_search.php" method="POST">
    <input type="hidden" name="nationalid" value="<?php echo $nationalid; ?>">
    <input type="hidden" name="firstname" value="<?php echo $firstname; ?>">
    <input type="hidden" name="surname" value="<?php echo $surname; ?>">
    <input type="submit" value="Return">
</form>

<?php include "footer.php"; ?>

</body>
</html>
