<?php
include_once 'dbconnect.php';

$nationalid = $_POST['nationalid'];
$idredeemedvoucher = $_POST['idredeemedvoucher'];
$vouchertype = $_POST['vouchertype'];

$query
    = "delete from voucherclaims where patientid='$nationalid' and vouchertype=$vouchertype";

$result = pg_query($query);
if ( ! $result) {
  $errormessage = pg_last_error();
  //echo "Error with query: " . $errormessage;
  exit();
}

$query
    = "delete from redeemedvouchers where idredeemedvouchers=$idredeemedvoucher";

$result = pg_query($query);
if ( ! $result) {
  $errormessage = pg_last_error();
  echo "Error with query: ".$errormessage;
  exit();
}
$msg = "success";
echo "Voucher Revoked successfully<br /><br />";

pg_close();
?>

