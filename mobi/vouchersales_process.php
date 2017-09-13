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
<body>

<?php
include_once 'dbconnect.php';

$nationalid = trim($_POST['nationalid']);
$beneficiary = trim($_POST['beneficiary']);
$voucher = trim($_POST['voucher']);

include_once 'generate_nationalid.php';


$dob = trim($_POST['dob']);
if ($dob == '') {
  $dob = '';
}

$lmp = trim($_POST['lmp']);
if ($lmp == '') {
  $lmp = '';
}

$edd = trim($_POST['edd']);
if ($edd == '') {
  $edd = '';
}

$surname = trim($_POST['surname']);

$firstname = trim($_POST['firstname']);

$sex = "F";

$guardian = trim($_POST['guardian']);
if ($guardian == '') {
  $guardian = '';
}

$maritalstatus = trim($_POST['maritalstatus']);
if ($maritalstatus == '') {
  $maritalstatus = '';
}

$parity = trim($_POST['parity']);
if ($parity == '') {
  $parity = '';
}

$location = trim($_POST['location']);
if ($location == '') {
  $location = '';
}

$village = trim($_POST['village']);
if ($village == '') {
  $village = '';
}

$postaladdress = trim($_POST['postaladdress']);
if ($postaladdress == '') {
  $postaladdress = '';
}

$saledate = trim($_POST['saledate']);
if ($saledate == '') {
  $saledate = '';
}

$voucherserial = trim($_POST['voucherserial']);
if ($voucherserial == '') {
  $voucherserial = '';
}

if (strcmp($voucher, 'new') == 0) {
  $strSQL = "select coalesce(max(voucherserial),0) from vouchersales";
  $result = pg_exec($conn, $strSQL);
  $row = pg_fetch_row($result);

  $uniquenumber = $row[0];
  if ($uniquenumber < 10000) {
    $uniquenumber = 10000;
  }
  if ($uniquenumber >= 10000) {
    $uniquenumber = $uniquenumber + 1;
  }
  $voucherserial = $uniquenumber;
}

$salerecord = trim($_POST['salerecord']);
if ($salerecord == '') {
  $salerecord = '';
}

$distributor = trim($_POST['distributor']);
if ($distributor == '') {
  $distributor = '';
}

$serialno = trim($_POST['serialno']);
if ($serialno == '') {
  $serialno = '';
}

$phone = trim($_POST['phone']);
if ($phone == '') {
  $phone = 'null';
}

$city = trim($_POST['city']);
if ($city == '') {
  $city = '';
}

$username = $_SESSION['username'];
$dateadded = date('d/m/Y');

if (strcmp($beneficiary, 'update') == 0) {
  $query
      = "UPDATE BENEFICIARYMASTER SET dob='$dob', lmp='$lmp', guardian='$guardian',maritalstatus='$maritalstatus',parity='$parity',location='$location',village='$village',postaladdress='$postaladdress'"
      .", serialno='$serialno', phone=$phone,city='$city', surname='$surname', firstname='$firstname',edd='$edd',reg_date='$saledate' where nationalid='$nationalid'";

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
        = "insert into beneficiarymaster (surname,firstname,nationalid,dob,lmp,sex,edd,guardian,maritalstatus,parity,location,village,postaladdress,serialno,phone,city,reg_date,addedby) "
        ."values('$surname','$firstname','$nationalid','$dob','$lmp','$sex','$edd','$guardian','$maritalstatus','$parity','$location','$village','$postaladdress','$serialno',$phone,'$city','$saledate','$username')";
    //echo '<br />'.$query.'<br />';

    $result = pg_query($query);

    if ( ! $result) {
      $errormessage = pg_last_error();
      echo "Error with query: ".$errormessage;
      exit();
    }
  }
}

if (strcmp($voucher, 'update') == 0) {
  $query
      = "UPDATE vouchersales SET voucherserial=$voucherserial,saledate='$saledate',salerecord='$salerecord',distributorno=$distributor"
      ." where nationalid='$nationalid'";
  //echo '<br />'.$query.'<br />';
  $result = pg_query($query);
  if ( ! $result) {
    $errormessage = pg_last_error();
    echo "Error with query: ".$errormessage;
    exit();
  }
} else {
  if (strcmp($voucher, 'new') == 0) {
    $strSQL
        = "select coalesce(count(*),0) from vouchersales where voucherserial=$voucherserial";
    $result = pg_exec($conn, $strSQL);
    $row = pg_fetch_row($result);

    $voucherduplicate = $row[0];

    if ($voucherduplicate > 0) {
      echo "<h2>This voucher already exists in the database: $voucherserial</h2>";
      exit();
    } else {

      $strSQL
          = "select coalesce(count(*),0) from beneficiarymaster where nationalid='$nationalid'";
      $result = pg_exec($conn, $strSQL);
      $row = pg_fetch_row($result);

      $beneficiarycheck = $row[0];

      if ($beneficiarycheck == 0) {
        echo "<h2>The National ID does not exists in Beneficiary List: $nationalid</h2>";
        exit();
      } else {
        $query
            = "insert into vouchersales (voucherserial,nationalid,distributorno,saledate,salerecord,addedby,dateadded) "
            ."values($voucherserial,'$nationalid',$distributor,'$saledate','$salerecord','$username','$dateadded')";
        //echo '<br />'.$query.'<br />';
        $result = pg_query($query);
        if ( ! $result) {
          $errormessage = pg_last_error();
          echo "Error with query: ".$errormessage;
          exit();
        }
      }

    }
  }
}

echo "<h3><font color='green'>Records for <font color='red'>$firstname $surname, </font>ID Number: <font color='red'>$nationalid</font> updated Successfully! <br />Voucher Number: <font color='red'>$voucherserial</font></font></h3>";
pg_close();
?>

<?php include "footer.php"; ?>

</body>
</html>
