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

$nationalid = $_POST['nationalid'];
$refer_to = $_POST['refer_to'];
$ambulanceid = $_POST['ambulance'];
$distributor = $_POST['distributor'];
$reason = $_POST['reason'];
$username = $_SESSION['username'];


$sql1 = pg_query(
    $conn,
    "SELECT facilityname From facility where idfacility='$distributor'"
);
$row2 = pg_fetch_row($sql1);
$facilityname = $row2[0];

$sql1 = pg_query(
    $conn,
    "SELECT facilityname From facility where idfacility='$refer_to'"
);
$row2 = pg_fetch_row($sql1);
$referto_name = $row2[0];

$sql1 = pg_query(
    $conn,
    "SELECT facilityname From facility where idfacility='$ambulanceid'"
);
$row2 = pg_fetch_row($sql1);
$ambulance = $row2[0];

//----------------------

if (ambulanceid == 0) {
  $ambulance = 'Own Transport';
}

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

if ($count == 0) {
  die(
      "<div align='center'><br /><br />Beneficiary with National ID <em>"
      .$nationalid."</em> does not exist!</div>"
  );
} else {
}
?>
<div align="center">
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
            <td><font style="color:#537313">Referring Facility:</font></td>
            <td><?php echo $facilityname; ?></td>
        </tr>
        <tr>
            <td><font style="color:#537313">Referring To:</font></td>
            <td><?php echo $referto_name; ?></td>
        </tr>
        <tr>
            <td><font style="color:#537313">Ambulance:</font></td>
            <td><?php echo $ambulance; ?></td>
        </tr>
        <tr>
            <td><font style="color:#537313">Referral Reason:</font></td>
            <td><?php echo $reason; ?></td>
        </tr>

    </table>
  <?php
  $strSQL = "select coalesce(max(referralnumber),0) from referrals";
  $result = pg_exec($conn, $strSQL);
  $row = pg_fetch_row($result);

  $referralnumber = $row[0];
  $referralnumber = $referralnumber + 1;

  $query
      = "insert into referrals (nationalid,referralnumber,reason,facilityfrom,facilityto,ambulance,calltime,addedby) "
      ."values('$nationalid',$referralnumber,'$reason',$distributor,$refer_to,$ambulanceid,'"
      .date('d-m-Y h:i')."','$username')";
  $result = pg_query($query);
  //echo $query;

  if ( ! $result) {
    $errormessage = pg_last_error();
    echo "<br /><br /><font color='red' size='+2'>e-Referral Note for patient with National ID $nationalid was already generated!<br /><br></font> ";
    include "footer.php";
    exit();
  }
  echo "<h2>e-Referral Note Successfully generated for patient with ID:<font color='red'> $nationalid</font></h2>";
  ?>

  <?php
  pg_close();
  ?>
    <br/>
  <?php include "footer.php"; ?>
</body>
</html>