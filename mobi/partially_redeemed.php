<?php
session_start();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Beneficiary Voucher Repository System</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>

<?php
include 'dbconnect.php';
$distributor = trim($_POST['distributor']);
$period = trim($_POST['period']);
$vserial = 0;

if (isset($_GET['voucherserial']) || ! empty($_GET['voucherserial'])) {
  $voucherserial = trim($_GET['voucherserial']);
  $vserial = 1;
}

if (( ! isset($period) || empty($period)) && $vserial == 0) {
  $vserial = 2;
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

if ($vserial == 0) {
  $strSQL
      = "select a.redeemserial,a.claimserial,a.nationalid,a.vouchertype,a.redeemdate,a.periodid,a.distributorno,b.firstname,b.surname,b.phone,a.idredeemedvouchers,a.ref "
      ." from beneficiarymaster b, redeemedvouchers a where a.nationalid=b.nationalid and a.distributorno=$distributor and a.periodid=$period"
      ." and a.claimed is null and a.finalredeem=0 order by redeemserial asc";
} elseif ($vserial == 1) {
  $strSQL
      = "select a.redeemserial,a.claimserial,a.nationalid,a.vouchertype,a.redeemdate,a.periodid,a.distributorno,b.firstname,b.surname,b.phone,a.idredeemedvouchers,a.ref "
      ." from beneficiarymaster b, redeemedvouchers a where a.nationalid=b.nationalid"
      ." and a.claimed is null and a.finalredeem=0 and a.redeemserial='$voucherserial'  order by a.distributorno,redeemserial asc";
} elseif ($vserial == 2) {
  $strSQL
      = "select a.redeemserial,a.claimserial,a.nationalid,a.vouchertype,a.redeemdate,a.periodid,a.distributorno,b.firstname,b.surname,b.phone,a.idredeemedvouchers,a.ref "
      ." from beneficiarymaster b, redeemedvouchers a where a.nationalid=b.nationalid"
      ." and a.claimed is null and a.finalredeem=0 order by a.distributorno,redeemserial asc";
}

$result = pg_exec($conn, $strSQL);
$numrows = pg_numrows($result);
?>

<h3 style="text-align: center">Partially Redeemed Vouchers<br/><br/>
  <?php
  echo "$facilityname, $periodname";
  ?>
</h3>

<div align="center">
    <form action="partially_redeemed.php" method="GET">
        Search by Voucher Serial: <input type="text" name="voucherserial"
                                         size="15">
        <input type="submit" value="Search">
    </form>
</div>
<table>
    <tr style="background-image: url(images/green_bg.png);">
        <th>Redeem Date</th>
        <th>Voucher Serial</th>
        <th>Ref No.</th>
        <th>Voucher Type</th>
        <th>Facility Name</th>
        <th>Patient ID</th>
        <th>First Name</th>
        <th>Surname</th>
        <th>Phone</th>
    </tr>

  <?php

  // Loop on rows in the result set.

  for ($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);

    $sql2 = pg_query(
        $conn,
        "SELECT shortname From vouchertype where usage='".$row["vouchertype"]
        ."'"
    );

    $row3 = pg_fetch_row($sql2);
    $vouchertype = $row3[0];
    $period = $row["periodid"];
    $distributor = $row["distributorno"];

    $sql1 = pg_query(
        $conn,
        "SELECT facilityname From facility where idfacility=$distributor"
    );

    $row2 = pg_fetch_row($sql1);
    $facilityname = $row2[0];
    ?>
      <tr>
          <td><?php echo $row["redeemdate"]; ?> </td>
          <td><?php echo $row["redeemserial"]; ?> </td>
          <td><?php echo $row["ref"]; ?> </td>
          <td><?php echo $vouchertype; ?> </td>
          <td><?php echo $facilityname; ?> </td>
          <td><?php echo $row["nationalid"]; ?> </td>
          <td><?php echo $row["firstname"]; ?> </td>
          <td><?php echo $row["surname"]; ?> </td>
          <td><?php echo $row["phone"]; ?> </td>
      </tr>
    <?php
  }
  pg_close($conn);
  ?>
</table>
<?php include 'footer.php'; ?>
</body>
</html>
