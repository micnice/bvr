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
include 'dbconnect.php';
$distributor = $_GET['distributor'];
$facilityname = trim(urldecode($_GET['facilityname']));
//$period=$_POST['period'];

$strSQL
    = "select b.vouchertype,a.shortname,a.price,count(*) from vouchertype a,redeemedvouchers b"
    ." where a.usage=b.vouchertype and distributorno=$distributor "
    ."group by b.vouchertype,a.shortname,a.price order by b.vouchertype";

//echo $strSQL.'<br />';

$result = pg_exec($conn, $strSQL);
$numrows = pg_numrows($result);
//echo $numrows;
?>

<h3 style="text-align: center">Summary of Redeemed Vouchers<br/><br/>
  <?php echo $facilityname; ?>
</h3>

<table>
    <tr style="background-color: #C0C0C0">
        <td>Voucher Type</td>
        <td>Total Redeemed</td>
        <td>Price</td>
        <td>Total Amount</td>
    </tr>

  <?php
  $totalamount = 0;
  for ($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    ?>
      <tr>
          <td><?php echo $row[1]; ?> </td>
          <td style="text-align: right"><?php echo $row[3]; ?> </td>
          <td style="text-align: right"><?php echo $row[2]; ?> </td>
          <td style="text-align: right"><?php echo number_format(
                $row[2] * $row[3],
                2,
                '.',
                ','
            ); ?> </td>
        <?php $totalamount = $totalamount + ($row[2] * $row[3]); ?>
      </tr>
    <?php
  }
  ?>
    <tr style="background-color: #C0C0C0">
        <td colspan="3">Grand Total</td>
        <td style="text-align: right"><?php echo number_format(
              $totalamount,
              2,
              '.',
              ','
          ); ?></td>
    </tr>
  <?php
  pg_close($conn);
  ?>
</table>
<div style="text-align: center"><a href="voucherredeemedsummary.php">Voucher
        Redeemed Summary</a></div>
</body>
</html>