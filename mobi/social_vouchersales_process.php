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
$voucher = trim($_POST['voucher']);

$username = $_SESSION['username'];
$dateadded = date('d/m/Y');

include_once 'generate_nationalid.php';

$saledate = $_POST['saledate'];
if ($saledate == '') {
  $saledate = '';
}

$voucherserial = $_POST['voucherserial'];
if ($voucherserial == '') {
  $voucherserial = 0;
}

$distributor = $_POST['distributor'];
if ($distributor == '') {
  $distributor = '';
}

$serialno = $_POST['serialno'];
if ($serialno == '') {
  $serialno = '';
}

echo "<h1 style='color:red'>".$voucherserial."</h2>";

if ($voucherserial == 0) {
  $sqlVoucher = pg_query(
      $conn,
      "SELECT max(voucherserial)+1 FROM vouchersales"
  );

  $row = pg_fetch_row($sqlVoucher);
  $voucherserial = $row[0];
  if ($voucherserial < 10000) {
    $voucherserial = 10000;
  }


}

if (strcmp($voucher, 'update') == 0) {
  $query
      = "UPDATE vouchersales SET voucherserial=$voucherserial,saledate='$saledate',distributorno=$distributor"
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
            = "insert into vouchersales (voucherserial,nationalid,distributorno,saledate,addedby,dateadded) "
            ."values($voucherserial,'$nationalid',$distributor,'$saledate','$username','$dateadded')";
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

echo "<h3><font color='green'>Records for <font color='red'>$nationalid</font> updated Successfully. Allocated Voucher Serial is <font color='red'>$voucherserial</font></font></h3>";
pg_close();
?>

<?php include "social_nextsale.php"; ?>

</body>
</html>

