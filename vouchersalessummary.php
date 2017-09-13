<?php
include 'dbconnect.php';

$district = $_POST['district'];
$startdate = $_POST['startdate'];
$enddate = $_POST['enddate'];

if (strcmp($district, 'Harare') == 0) {
  $districtid = 2;
}
if (strcmp($district, 'Nkulumane') == 0) {
  $districtid = 1;
}

$strSQL = "select facilityname,count(*) from facility a, vouchersales b where"
    ." b.distributorno=a.idfacility and iddistrict=$districtid and to_date(saledate,'dd/mm/yyyy')>=to_date('$startdate','dd/mm/yyyy') "
    ." and to_date(saledate,'dd/mm/yyyy')<=to_date('$enddate','dd/mm/yyyy')"
    ." group by facilityname"
    ." order by facilityname";

//echo $strSQL.'<br />';

$result = pg_exec($conn, $strSQL);
$numrows = pg_numrows($result);
?>

<h3 style="text-align: center">Summary of Voucher Sales</h3>

<table>
    <tr>
        <td colspan="2">
            <h2>Period: </h2>
            <h3><?php echo $startdate; ?> - <?php echo $enddate; ?></h3>
        </td>
    </tr>
    <tr style="background-image: url(images/green_bg.png);">
        <th>Facility Name</th>
        <th>Vouchers Sold</th>
    </tr>

  <?php

  // Loop on rows in the result set.
  //
  //$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
  //

  for ($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    ?>
      <tr>
          <td><?php echo $row[0]; ?> </td>
          <td><?php echo $row[1]; ?> </td>
      </tr>
    <?php
  }
  pg_close($conn);
  ?>
</table>