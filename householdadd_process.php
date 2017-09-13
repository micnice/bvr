<?php
include_once 'dbconnect.php';
$nationalid = $_POST['nationalid'];
$firstname = $_POST['firstname'];
$surname = $_POST['surname'];
$ward = $_POST['ward'];
$dob = $_POST['dob'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$district = $_POST['district'];
//$action=$_POST['action'];

$query
    = "INSERT INTO household(address,firstname,surname,phone,nationalid,wardnumber,numerator) 
        . VALUES ('$address','$firstname','$surname',$phone,'$nationalid','$ward',$numerator')";
$result = pg_query($query);
if ( ! $result) {
  $errormessage = pg_last_error();
  echo "Error with query: ".$errormessage;
  exit();
}
$msg = "success";
pg_close();

header("Location: beneficiaryadd.php?msg='$msg'");
pg_close();
?>

