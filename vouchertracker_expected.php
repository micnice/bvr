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
include 'dbconnect.php';
$filteron = 0;

$period = trim($_POST['period']);
$district = trim($_POST['district']);
if (isset($_POST['voucherserial'])) {
  $voucherserial = trim($_POST['voucherserial']);
  $filteron = 1;
}

if ($filteron == 0) {
  $strSQL
      = "select b.saledate,b.voucherserial,c.facilityname,a.firstname,a.surname,a.nationalid,a.phone,a.location,a.village,a.lmp,a.edd from beneficiarymaster a,vouchersales b,facility c "
      ." where a.nationalid = b.nationalid and b.distributorno = c.idfacility and substring(a.edd,4,7) = '$period' and city='$district' and "
      ." b.voucherserial not in (select redeemserial from redeemedvouchers where vouchertype in (6,5,7,9,16))";
} else {
  $strSQL
      = "select b.saledate,b.voucherserial,c.facilityname,a.firstname,a.surname,a.nationalid,a.phone,a.location,a.village,a.lmp,a.edd from beneficiarymaster a,vouchersales b,facility c "
      ." where a.nationalid = b.nationalid and b.distributorno = c.idfacility and substring(a.edd,4,7) = '$period' and city='$district' and "
      ." b.voucherserial not in (select redeemserial from redeemedvouchers where vouchertype in (6,5,7,9,16)) and b.voucherserial=$voucherserial";
}

//echo $strSQL;
$result = pg_exec($conn, $strSQL);
$numrows = pg_numrows($result);
?>

<h3 style="text-align: center">Voucher Tracker</h3>
<table>
    <tr>
        <td colspan="19">
            <div align="left">
                <form action="vouchertracker_old.php" method="POST">
                    Search by Voucher Serial: <input type="text"
                                                     name="voucherserial"
                                                     size="15">
                    <input type="hidden" name="period"
                           value="<?php echo $period; ?>">
                    <input type="hidden" name="district"
                           value="<?php echo $district; ?>">
                    <input type="submit" value="Search">
                </form>
            </div>
        </td>
    </tr>
    <tr style="background-image: url(images/green_bg.png);">
        <th>Voucher Date</th>
        <th>Voucher Serial</th>
        <th>Facility</th>
        <th>First name</th>
        <th>Surname</th>
        <th>National ID</th>
        <th>Address</th>
        <th>Phone</th>
        <th>LMP</th>
        <th>EDD</th>
        <th>Weeks after EDD+6</th>
        <th>Status</th>
    </tr>

  <?php
  // Loop on rows in the result set.
  //echo '1';

  for ($i = 0; $i < $numrows; $i++) {
    //echo '2';
    $row = pg_fetch_array($result, $i);

    $lmp = substr(str_replace('/', '-', trim($row['lmp'])), 0, 10);
    $lmp1 = $lmp;
    $lmptemp = explode('-', $lmp);
    if (intval($lmptemp[1]) > 12 && $lmptemp[0] <= 12) {
      $lmp = $lmptemp[1].'-'.$lmptemp[0].'-'.$lmptemp[2];
    } else {
      $lmp = '';
    }

    $lmpdate = date('Y-m-d', strtotime($lmp));
    $edd = substr(str_replace('/', '-', trim($row['edd'])), 0, 10);
    $edddate = date('Y-m-d', strtotime($edd));


    if ($i % 2 == 0) {
      $color = '#eeeeee';
    } else {
      $color = '#ffffff';
    }
    $splitLmp = explode('-', $lmpdate);

    $newLmp = $splitLmp[2].'-'.$splitLmp[1].'-'.$splitLmp[0];

    $splitEdd = explode('-', $edddate);
    $newEdd = $splitEdd[2].'-'.$splitEdd[1].'-'.$splitEdd[0];

    if (strlen($lmp1) > 8) {
      $edd = date('Y-m-d', strtotime($lmp1.' + 280 days'));
      //echo $edd.' -> '.$lmp.' :: ';
      //$date1 = new DateTime($lmp);


      $splitEdd = explode('-', $edd);
      $newEdd = $splitEdd[2].'-'.$splitEdd[1].'-'.$splitEdd[0];

    } elseif (strlen($edd) > 8 && strlen($lmp) < 8) {
      $lmp = date('Y-m-d', strtotime($newEdd.' - 280 days'));
      //$date1 = new DateTime($lmp);
      $splitEdd = explode('-', $edd);
      $newEdd = $splitEdd[2].'-'.$splitEdd[1].'-'.$splitEdd[0];

      //$splitLmp = explode('-',$lmp);

    }

    $deliveryDeadline = date('Y-m-d', strtotime($newEdd.' + 42 days'));
    $currentDate = date('Y-m-d');
    //echo $edd.' -> '.$lmp.' :: ';
    //echo '3';
    $date1 = new DateTime($deliveryDeadline);
    $date2 = new DateTime($currentDate);
    $interval = $date1->diff($date2);

    //echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days ";

    // shows the total amount of days (not divided into years, months and days like above)
    $days = $interval->days;
    //$weeks = floor($days/7);
    $weeks = floor($interval->format("%r%a days") / 7);
    if ($weeks > 160 || $weeks < -160) {
      $weeks = "N/A";
    }
    ?>
      <tr style="vertical-align:top">
          <td style="background-color: <?php echo $color; ?>"><?php echo $row["saledate"]; ?> </td>
          <td style="background-color: <?php echo $color; ?>"><?php echo $row["voucherserial"]; ?> </td>
          <td style="background-color: <?php echo $color; ?>"><?php echo $row["facilityname"]; ?> </td>
          <td style="background-color: <?php echo $color; ?>"><?php echo $row["firstname"]; ?> </td>
          <td style="background-color: <?php echo $color; ?>"><?php echo $row["surname"]; ?> </td>
          <td style="background-color: <?php echo $color; ?>"><?php echo $row["nationalid"]; ?> </td>
          <td style="background-color: <?php echo $color; ?>"><?php echo $row["location"]
                .', '.$row["village"]; ?> </td>
          <td style="background-color: <?php echo $color; ?>">
              <nobr><?php echo $row["phone"]; ?> </nobr>
          </td>
          <td style="background-color: <?php echo $color; ?>">
              <nobr><?php echo $lmp1; ?> </nobr>
          </td>
          <td style="background-color: <?php echo $color; ?>">
              <nobr><?php echo $edd; ?> </nobr>
          </td>
          <td style="background-color: <?php echo $color; ?>">
              <nobr><?php echo $weeks; ?> </nobr>
          </td>

        <?php

        $voucherserial = $row["voucherserial"];
        if ($weeks < 0) {
          $redeemed = "Pending Redeem";
        } else {
          $redeemed = 'Unredeemed';
        }

        ?>
          <td style="background-color: <?php echo $color; ?>"><?php echo $redeemed; ?> </td>

      </tr>
    <?php
  }
  pg_close($conn);
  ?>
</table>
-----Report Complete-----
</body>
</html>