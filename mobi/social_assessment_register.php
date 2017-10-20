<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN"
        "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<?php
session_start();
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
<body>
<?php
include_once 'dbconnect.php';

$nationalid = trim($_POST['nationalid']);
$beneficiary = trim($_POST['beneficiary']);

include_once 'generate_nationalid.php';

$dob = $_POST['dob'];
if ($dob == '') {
  $dob = '';
}

$pregnancy = $_POST['pregnancy'];
if ($pregnancy == '') {
  echo "Please enter Pregnancy Number";
  exit();
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

$username = $_SESSION['username'];
$dateadded = date("d/m/Y");

if (strcmp($beneficiary, 'update') == 0) {
  $query
      = "UPDATE BENEFICIARYMASTER SET dob='$dob', guardian='$guardian',maritalstatus='$maritalstatus',location='$location',village='$village',postaladdress='$postaladdress'"
      .", serialno='$serialno', phone=$phone,city='$city', surname='$surname', firstname='$firstname' where nationalid='$nationalid'";

  //echo '<br />'.$query.'<br />';
  $result = pg_query($query);
  if ( ! $result) {
    $errormessage = pg_last_error();
    echo "Error with query: ".$errormessage;
    exit();
  }
  $pregnancyQuery = "insert into pregnancyregistration (lmp, reg_date, edd, pregnancy, parity, idbeneficiarymaster) values('$lmp', '$dateadded', '$edd', '$pregnancy', '$parity', (select idbeneficiarymaster from beneficiarymaster where nationalid='$nationalid'))";

  $result =pg_query($pregnancyQuery);
  if ( ! $result) {
    $errormessage = pg_last_error();
    echo "Error with query: ".$errormessage;
    exit();
  }
} else {
  if (strcmp($beneficiary, 'new') == 0) {
    $beneficiaryQuery
        = "insert into beneficiarymaster (surname,firstname,nationalid,dob,sex,guardian,maritalstatus,location,village,postaladdress,serialno,phone,city,addedby) "
        ."values('$surname','$firstname','$nationalid','$dob','$sex','$guardian','$maritalstatus','$location','$village','$postaladdress','$serialno',$phone,'$city','$username')";
    //echo '<br />'.$query.'<br />';

    $result = pg_query($beneficiaryQuery);

    if ( ! $result) {
      $errormessage = pg_last_error();
      echo "Error with query: ".$errormessage;
      exit();
    }

    $pregnancyQuery = "insert into pregnancyregistration (lmp, reg_date, edd, pregnancy, parity, idbeneficiarymaster) values('$lmp', '$dateadded', '$edd', '$pregnancy', '$parity', (select idbeneficiarymaster from beneficiarymaster where nationalid='$nationalid'))";

    $result =pg_query($pregnancyQuery);
    if ( ! $result) {
      $errormessage = pg_last_error();
      echo "Error with query: ".$errormessage;
      exit();
    }
  }
}


header("Location: social_vouchersales_search.php?nationalid=$nationalid");
pg_close();
?>

<?php include "social_nextsale.php"; ?>

</body>
</html>

