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
include "../dbconnect.php";

include "generate_redeem_serial.php";

$nationalid = $_POST['nationalid'];
//$newnationalid=$_POST['newnationalid'];
$ref = $_POST['ref'];
$label = $_POST['label'];
$vouchertype = $_POST['vouchertype'];
$period = $_POST['period'];
$distributor = $_POST['distributor'];
$redeemserial = $_POST['redeemserial'];
$claimserial = $_POST['claimserial'];
$finalredeem = 0;
$username = $_SESSION['username'];

if ($redeemserial > 0) {

} else {
  $redeemserial = $uniquenumber;
}
$sql1 = pg_query(
    $conn,
    "SELECT facilityname From facility where idfacility='$distributor'"
);

$row2 = pg_fetch_row($sql1);
$facilityname = $row2[0];

$sql2 = pg_query(
    $conn,
    "SELECT monthname,yearname From period where monthcode=$period"
);

$row3 = pg_fetch_row($sql2);
$periodname = $row3[0].' '.$row3[1];


$sql = pg_query(
    $conn,
    "SELECT * From beneficiarymaster where nationalid='$nationalid'"
);

$count = 0;
$amount = 0;
while ($row = pg_fetch_row($sql)) {
  $count = $count + 1;
  $firstname = $row[1];
  $surname = $row[2];
  //$dob = $row[3];
}

if (in_array($vouchertype, array(5, 6, 7, 9))) {
  $finalredeem = 0;
  $redeemStr
      = "Voucher Partially Redeemed. The Matron / Sister-In-Charge should complete the process by redeeming the corresponding Cash Token";
} else {
  $finalredeem = 1;
  $redeemStr = "Voucher Redeemed Successfully";
}
if ($count == 0) {
  die(
      "<div align='center'><br /><br />Beneficiary with National ID <em>"
      .$nationalid."</em> does not exist!</div>"
  );
} else {
}
?>
<div align="left">
    <table style="margin:auto 0;">
        <tr>
            <td><font style="color:#537313">ID No/BVR No:</font></td>
            <td><?php echo $nationalid; ?></td>
        </tr>
        <tr>
            <td><font style="color:#537313"><?php echo str_pad(
                    'First Name:',
                    100
                ); ?></font></td>
            <td> <?php echo $firstname; ?></td>
        </tr>
        <tr>
            <td><font style="color:#537313">Surname:</font></td>
            <td><?php echo $surname; ?></td>
        </tr>
        <tr>
            <td><font style="color:#537313"><?php echo $label; ?> No. :</font>
            </td>
            <td><?php echo $ref; ?></td>
        </tr>
        <tr>
            <td><font style="color:#537313">Facility:</font></td>
            <td><?php echo $facilityname; ?></td>
        </tr>
        <tr>
            <td><font style="color:#537313">Period:</font></td>
            <td><?php echo $periodname; ?></td>
        </tr>

    </table>
  <?php
  $query
      = "insert into redeemedvouchers (nationalid,vouchertype,redeemserial,periodid,distributorno,redeemdate,ref,finalredeem,addedby) "
      ."values('$nationalid',$vouchertype,$redeemserial,$period,$distributor,'"
      .date('d-m-Y')."','$ref',$finalredeem,'$username')";
  $result = pg_query($query);
  //echo $query;

  if ( ! $result) {
    $errormessage = pg_last_error();
    echo "Error with query: ".$errormessage;
    exit();
  }

  if (in_array($vouchertype, array(12, 13))) {
    $query
        = "update redeemedvouchers set finalredeem=1,periodid=$period where vouchertype in (5,6,7,9) and nationalid='$nationalid'";
    $result = pg_query($query);
    //echo $query;

    if ( ! $result) {
      $errormessage = pg_last_error();
      echo "Error with query: ".$errormessage;
      exit();
    }

  }
  echo "<br />$redeemStr. Voucher Number: <h3 color='red'>$redeemserial</h3> <br /><br /><a href='verifyvoucher.php'>Next Voucher</a>";
  ?>

    <!--
    <form action="redeemvoucher_confirm.php" method="POST">
        <input type="hidden" name="vouchertype" value="<?php echo $vouchertype; ?>">
        <input type="hidden" name="nationalid" value="<?php echo $nationalid; ?>" required>
        <input type="hidden" name="period" value="<?php echo $period; ?>">
        <input type="hidden" name="label" value="<?php echo $label; ?>">
        <input type="hidden" name="distributor" value="<?php echo $distributor; ?>">
        <input type="hidden" name="ref" value="<?php echo $ref; ?>">
        <input type="hidden" name="redeemserial" value="<?php echo $redeemserial; ?>">
        <input type="submit" value="Next Voucher" style="margin:0 auto">
    </form>  
    -->
  <?php
  pg_close();
  ?>
    <br/>
  <?php include "footer.php"; ?>
</body>
</html>