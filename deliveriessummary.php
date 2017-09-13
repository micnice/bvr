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
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>


<h3 style="text-align: center">Summary of Deliveries<br/><br/>
</h3>


<table>
    <tr style="background-color: #C0C0C0">
        <td>Facility Name</td>
        <td>Period</td>
        <td>Normal Clinic</td>
        <td>Complicated Clinic</td>
        <td>Complicated Hospital</td>
        <td>Caesarean</td>
    </tr>


  <?php
  include 'dbconnect.php';
  $period = $_POST['period'];
  $period2 = $_POST['period2'];

  $sqlFacility = "select idfacility,facilityname "
      ."from facility where idfacility in (select distributorno from redeemedvouchers)  order by facilityname";
  $resultFacility = pg_query($conn, $sqlFacility);
  while ($facilityrow = pg_fetch_assoc($resultFacility)) {
    $facilityid = $facilityrow["idfacility"];
    for ($x = $period; $x <= $period2; $x++) {
      $sql = pg_query(
          $conn,
          "SELECT monthcode,monthname,yearname FROM period where monthcode=$x"
      );
      $periodrow = pg_fetch_assoc($sql);
      $periodname = trim($periodrow['monthname'])." ".trim(
              $periodrow['yearname']
          );
      //echo $periodname.' , ';
      $strSQL = "select idfacility,facilityname, "
          ."(select count(*) from redeemedvouchers where vouchertype=5 and distributorno=idfacility and periodid=$x and finalredeem=1), "
          ."(select count(*) from redeemedvouchers where vouchertype=6 and distributorno=idfacility and periodid=$x and finalredeem=1), "
          ."(select count(*) from redeemedvouchers where vouchertype=7 and distributorno=idfacility and periodid=$x and finalredeem=1), "
          ."(select count(*) from redeemedvouchers where vouchertype=9 and distributorno=idfacility and periodid=$x and finalredeem=1) "
          ."from facility where idfacility in (select distributorno from redeemedvouchers) and idfacility=$facilityid  order by facilityname";
      //echo $strSQL.'<br />';

      $result = pg_exec($conn, $strSQL);
      $numrows = pg_numrows($result);
      //echo $numrows;
      ?>

      <?php
      for ($i = 0; $i < $numrows; $i++) {
        $row = pg_fetch_array($result, $i);
        ?>
          <tr>
              <td>
                  <a href="voucherredeemed.php?distributor=<?php echo $row[0]; ?>&facilityname=<?php echo urlencode(
                      trim($row[1])
                  ); ?>"><?php echo $row[1]; ?> </a></td>
              <td><?php echo $periodname; ?> </td>
              <td><?php echo $row[2]; ?> </td>
              <td><?php echo $row[3]; ?> </td>
              <td><?php echo $row[4]; ?> </td>
              <td><?php echo $row[5]; ?> </td>

          </tr>
        <?php
      }
    }
  }
  pg_close($conn);
  ?>
</table>
</body>
</html>