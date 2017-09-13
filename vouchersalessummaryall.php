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
$distributor = $_POST['distributor'];
include 'dbconnect.php';
$strSQL
    = "select facilityname,substring(saledate,7,4),substring(saledate,4,2),count(*) from facility a, vouchersales b where "
    ."b.distributorno=a.idfacility and a.idfacility=$distributor group by facilityname,substring(saledate,7,4),substring(saledate,4,2) order by facilityname,substring(saledate,7,4),substring(saledate,4,2)";

//echo $strSQL.'<br />';

$result = pg_exec($conn, $strSQL);
$numrows = pg_numrows($result);
?>

<h3 style="text-align: center">Summary of Voucher Sales</h3>

<table>
    <tr style="background-image: url(images/green_bg.png);">
        <th>Facility Name</th>
        <th>Period (mm/yyyy)</th>
        <th>Total Vouchers Sold</th>
    </tr>

  <?php

  // Loop on rows in the result set.

  for ($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    ?>
      <tr>
          <td><?php echo $row[0]; ?> </td>
          <td><?php echo date("F", mktime(0, 0, 0, $row[2], 10))." "
                .$row[1]; ?> </td>
          <td><?php echo $row[3]; ?> </td>
      </tr>
    <?php
  }
  pg_close($conn);
  ?>
</table>

<?php include "footer.php"; ?>

</body>
</html>