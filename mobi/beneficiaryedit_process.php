<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN"
        "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<?php
session_start();
if (strcmp(trim($_SESSION['login']), 'false') == 0) {
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

$nationalid = trim($_POST['nationalid']);
$beneficiary = trim($_POST['beneficiary']);

$username = $_SESSION['username'];
$dateadded = date('d/m/Y');

$dob = $_POST['dob'];
if ($dob == '') {
  $dob = '';
}

$lmp = $_POST['lmp'];
if ($lmp == '') {
  $lmp = '';
}

$edd = $_POST['edd'];
if ($edd == '') {
  $edd = '';
}

$surname = $_POST['surname'];

$firstname = $_POST['firstname'];

$sex = "F";

$guardian = $_POST['guardian'];
if ($guardian == '') {
  $guardian = '';
}

$maritalstatus = $_POST['maritalstatus'];
if ($maritalstatus == '') {
  $maritalstatus = '';
}

$parity = $_POST['parity'];
if ($parity == '') {
  $parity = '';
}

$location = $_POST['location'];
if ($location == '') {
  $location = '';
}

$village = $_POST['village'];
if ($village == '') {
  $village = '';
}

$postaladdress = $_POST['postaladdress'];
if ($postaladdress == '') {
  $postaladdress = '';
}

$serialno = $_POST['serialno'];
if ($serialno == '') {
  $serialno = '';
}

$phone = $_POST['phone'];
if ($phone == '') {
  $phone = 'null';
}

$city = $_POST['city'];
if ($city == '') {
  $city = '';
}


if (strcmp($beneficiary, 'update') == 0) {
  $query
      = "UPDATE BENEFICIARYMASTER SET dob='$dob', lmp='$lmp', guardian='$guardian',maritalstatus='$maritalstatus',parity='$parity',location='$location',village='$village',postaladdress='$postaladdress'"
      .", serialno='$serialno', phone=$phone,city='$city', surname='$surname', firstname='$firstname',edd='$edd' where nationalid='$nationalid'";

  //echo '<br />'.$query.'<br />';
  $result = pg_query($query);
  if ( ! $result) {
    $errormessage = pg_last_error();
    echo "Error with query: ".$errormessage;
    exit();
  }
} else {
  if (strcmp($beneficiary, 'new') == 0) {
    $query
        = "insert into beneficiarymaster (surname,firstname,nationalid,dob,lmp,sex,edd,guardian,maritalstatus,parity,location,village,postaladdress,serialno,phone,city,addedby,reg_date) "
        ."values('$surname','$firstname','$nationalid','$dob','$lmp','$sex','$edd','$guardian','$maritalstatus','$parity','$location','$village','$postaladdress','$serialno',$phone,'$city','$username','$dateadded')";
    //echo '<br />'.$query.'<br />';

    $result = pg_query($query);

    if ( ! $result) {
      $errormessage = pg_last_error();
      echo "Error with query: ".$errormessage;
      exit();
    }
  }
}

echo "<h3><font color='green'>Records updated Successfully</font></h3>";
pg_close();
?>


<?php include "footer.php"; ?>

</body>
</html>