<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Beneficiary Voucher Repository System</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>

<?php
include 'dbconnect.php';

$distributor = $_POST['distributor'];
$period = $_POST['period'];
$vserial = 0;

if (isset($_POST['voucherserial']) || ! empty($_POST['voucherserial'])) {
  $voucherserial = $_POST['voucherserial'];
  $vserial = 1;
}

if ($vserial == 0) {
  $strSQL
      = "SELECT idvoucherclaims,voucherserial,patientid,serviceoffered,amount,facilityname,shortname,firstname,surname,ref,vouchertype"
      ." From voucherclaims,facility, vouchertype,beneficiarymaster  where approval='yes' and distributorno=idfacility and usage=vouchertype"
      ." and idfacility=$distributor and periodid='$period' and patientid=nationalid order by facilityname,shortname,voucherserial asc";
} else {
  $strSQL
      = "SELECT idvoucherclaims,voucherserial,patientid,serviceoffered,amount,facilityname,shortname,firstname,surname,ref"
      ." From voucherclaims,facility, vouchertype,beneficiarymaster  where approval='yes' and distributorno=idfacility and usage=vouchertype"
      ." and voucherserial=$voucherserial and patientid=nationalid order by facilityname,shortname,voucherserial asc";
}
$result = pg_exec($conn, $strSQL);
$numrows = pg_numrows($result);
?>

<h3 style="text-align: center">Approved Claims</h3>

<div align="center">
    <form action="main.php?page=claimsapproved" method="POST">
        Search by Voucher Serial: <input type="text" name="voucherserial"
                                         size="15">
        <input type="hidden" name="period" value="<?php echo $period; ?>">
        <input type="hidden" name="distributor"
               value="<?php echo $distributor; ?>">
        <input type="submit" value="Search">
    </form>
</div>
<table>
    <tr style="background-image: url(images/green_bg.png);">
        <th></th>
        <th>Redeem Date</th>
        <th>Voucher Serial</th>
        <th>Ref No.</th>
        <th>Voucher Type</th>
        <th>Facility</th>
        <th>Patient ID</th>
        <th>Firstname</th>
        <th>Surname</th>
        <th>Service Offered</th>
        <th>Amount</th>
    </tr>

  <?php

  // Loop on rows in the result set.

  for ($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);

    $voucherserial = $row["voucherserial"];
    $nationalid = $row["patientid"];
    $vouchertype = $row["vouchertype"];

    $sqlRedeem = "select redeemdate from redeemedvouchers"
        ." where redeemserial = $voucherserial and vouchertype = $vouchertype and nationalid = '$nationalid'";

    //echo $voucherserial." .... ".$sqlBeneficiary."<br />";
    $resultRedeem = pg_query($conn, $sqlRedeem);
    $rowRedeem = pg_fetch_row($resultRedeem);
    $redeemDate = str_replace('-', '/', $rowRedeem[0]);

    $sqlRedeemRef
        = "select ref from redeemedvouchers where redeemserial = $voucherserial and vouchertype = $vouchertype and nationalid = '$nationalid'";
    $resultRedeemRef = pg_query($conn, $sqlRedeemRef);
    $rowRedeemRef = pg_fetch_row($resultRedeemRef);
    $redeemRef = $rowRedeemRef[0];

    ?>
      <tr>
          <td><?php echo $i + 1; ?></td>
          <td><?php echo $redeemDate; ?> </td>
          <td><?php echo $row["voucherserial"]; ?> </td>
          <td><?php echo $redeemRef; ?> </td>
          <td><?php echo $row["serviceoffered"]; ?> </td>
          <td><?php echo $row["facilityname"]; ?> </td>
          <td><?php echo $row["patientid"]; ?> </td>
          <td><?php echo $row["firstname"]; ?> </td>
          <td><?php echo $row["surname"]; ?> </td>
          <td><?php echo $row["serviceoffered"]; ?> </td>
          <td><?php echo $row["amount"]; ?> </td>
      </tr>
    <?php
  }
  pg_close($conn);
  ?>
</table>

</body>
</html>
