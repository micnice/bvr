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

$distributor = $_POST['distributor'];
$period = $_POST['period'];

$strSQL
    = "SELECT serialno,q1,q2,q3,q4,q5,q6,facilityname,coalesce(q1,0)+coalesce(q2,0)+coalesce(q3,0)+coalesce(q4,0)+coalesce(q5,0)+coalesce(q6,0) total"
    ." From cboscore,facility  where facilityid=idfacility"
    ." and idfacility=$distributor and periodid='$period' order by facilityname,serialno asc";

$result = pg_exec($conn, $strSQL);
$numrows = pg_numrows($result);
?>

<h3 style="text-align: center">View CBO Questionnaires</h3>

<table>
    <tr style="background-image: url(images/green_bg.png);">
        <th>No.</th>
        <th>Facility</th>
        <th>Serial No.</th>
        <th>Q1</th>
        <th>Q2</th>
        <th>Q3</th>
        <th>Q4</th>
        <th>Q5</th>
        <th>Q6</th>
        <th>Total</th>
    </tr>

  <?php

  // Loop on rows in the result set.
  $grandtotal = 0;
  $count = 0;

  for ($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    $count = $i + 1;
    ?>
      <tr>
          <td><?php echo $count; ?> </td>
          <td><?php echo $row["facilityname"]; ?> </td>
          <td><?php echo $row["serialno"]; ?> </td>
          <td><?php echo $row["q1"]; ?> </td>
          <td><?php echo $row["q2"]; ?> </td>
          <td><?php echo $row["q3"]; ?> </td>
          <td><?php echo $row["q4"]; ?> </td>
          <td><?php echo $row["q5"]; ?> </td>
          <td><?php echo $row["q6"]; ?> </td>
          <td><?php echo $row["total"]; ?> </td>
      </tr>
    <?php
    $grandtotal = $grandtotal + $row["total"];
  }
  pg_close($conn);
  ?>
    <tr>
        <td colspan="9" style="text-align: right;"><h3>Grant Total</h3></td>
        <td><h3><?php echo $grandtotal." / ".$count * 45; ?></h3></td>
    </tr>
    <tr>
        <td colspan="10">
            <form action="cboscore_summary.php" method="POST">
                <div align="center">
                    <input type="hidden" name="distributor"
                           value="<?php echo $distributor; ?>">
                    <input type="hidden" name="period"
                           value="<?php echo $period; ?>">
                    <input type="submit" value="View CBO Score Summary"/>
                </div>
            </form>
        </td>
    </tr>
</table>
<?php include "footer.php"; ?>
</body>
</html>