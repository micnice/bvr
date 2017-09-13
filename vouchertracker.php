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
      ." where a.nationalid = b.nationalid and b.distributorno = c.idfacility and substring(b.saledate,4,7) = '$period' and city='$district' and "
      ." b.voucherserial in (select redeemserial from redeemedvouchers)";
} else {
  $strSQL
      = "select b.saledate,b.voucherserial,c.facilityname,a.firstname,a.surname,a.nationalid,a.phone,a.location,a.village,a.lmp,a.edd from beneficiarymaster a,vouchersales b,facility c "
      ." where a.nationalid = b.nationalid and b.distributorno = c.idfacility and substring(b.saledate,4,7) = '$period' and city='$district' and "
      ." b.voucherserial in (select redeemserial from redeemedvouchers) and b.voucherserial=$voucherserial";
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
                <form action="vouchertracker.php" method="POST">
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
        <th>Booking Date</th>
        <th>EDD</th>
        <th>Booking GA</th>
        <th>GA Weeks</th>

        <th>Voucher Type</th>
        <th>Status</th>
        <th>Redeem Facility</th>
        <th>Date</th>
        <th>Ref Number</th>
        <th>Approval</th>
    </tr>

  <?php
  // Loop on rows in the result set.

  for ($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);

    $voucherserial = $row["voucherserial"];
    $redeemSQL
        = "select b.usage, b.shortname,'Redeemed' as status,facilityname,redeemdate,ref from redeemedvouchers a, vouchertype b, facility c where a.distributorno = c.idfacility and b.usage = a.vouchertype and redeemserial='$voucherserial' "
        ." order by usage asc";
    $resultRedeem = pg_exec($conn, $redeemSQL);
    $numrowsRedeem = pg_numrows($resultRedeem);

    $lmp = substr(str_replace('/', '-', trim($row['lmp'])), 0, 10);

    $lmptemp = explode('-', $lmp);
    if (intval($lmptemp[1]) > 12 && $lmptemp[0] <= 12) {
      $lmp = $lmptemp[1].'-'.$lmptemp[0].'-'.$lmptemp[2];
    } else {
      $lmp = '';
    }

    $lmpdate = date('Y-m-d', strtotime($lmp));
    $edd = substr(str_replace('/', '-', trim($row['edd'])), 0, 10);
    $edddate = date('Y-m-d', strtotime($edd));


    for ($x = 0; $x < $numrowsRedeem; $x++) {
      $rowRedeem = pg_fetch_array($resultRedeem, $x);
      if ($x % 2 == 0) {
        $color = '#eeeeee';
      } else {
        $color = '#ffffff';
      }
      $ref = $rowRedeem["ref"];

      if ($x == 0) {
        $redeemdate = str_replace('/', '-', trim($rowRedeem["redeemdate"]));
        $splitRedeemDate = explode('-', $redeemdate);
        $splitLmp = explode('-', $lmpdate);
        $bookdate = $splitRedeemDate[2].'-'.$splitRedeemDate[1].'-'
            .$splitRedeemDate[0];

        $newLmp = $splitLmp[2].'-'.$splitLmp[1].'-'.$splitLmp[0];

        $splitEdd = explode('-', $edddate);
        $newEdd = $splitEdd[2].'-'.$splitEdd[1].'-'.$splitEdd[0];

        if (strlen($lmp) > 8 && strlen($bookdate) > 8) {
          $edd = date('Y-m-d', strtotime($newLmp.' + 280 days'));
          //echo $edd.' -> '.$lmp.' :: ';
          $date1 = new DateTime($lmp);
          $date2 = new DateTime($bookdate);
          $interval = $date2->diff($date1);

          //echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days ";

          // shows the total amount of days (not divided into years, months and days like above)
          $days = $interval->days;
          $weeks = floor($days / 7);

          $splitEdd = explode('-', $edd);
          $newEdd = $splitEdd[2].'-'.$splitEdd[1].'-'.$splitEdd[0];

        } elseif (strlen($edd) > 8 && strlen($bookdate) > 8) {
          $lmp = date('Y-m-d', strtotime($newEdd.' - 280 days'));
          $date1 = new DateTime($lmp);
          $date2 = new DateTime($bookdate);
          $interval = $date2->diff($date1);

          //echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days ";

          // shows the total amount of days (not divided into years, months and days like above)
          $days = $interval->days;
          $weeks = floor($days / 7);

          $splitEdd = explode('-', $edd);
          $newEdd = $splitEdd[2].'-'.$splitEdd[1].'-'.$splitEdd[0];

          //$splitLmp = explode('-',$lmp);

        } else {
          $days = '';
          $weeks = '';
          $newEdd = '';
        }

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
                <nobr><?php echo $lmp; ?> </nobr>
            </td>

            <td style="background-color: <?php echo $color; ?>">
                <nobr><?php echo $redeemdate; ?></nobr>
            </td>
            <td style="background-color: <?php echo $color; ?>">
                <nobr><?php echo $newEdd; ?> </nobr>
            </td>
            <td style="background-color: <?php echo $color; ?>"><?php echo $days ?></td>
            <td style="background-color: <?php echo $color; ?>"><?php echo $weeks; ?></td>

          <?php

          $voucherserial = $row["voucherserial"];
          $approvalSQL
              = "select approval from voucherclaims where voucherserial='$voucherserial'";
          $resultApproval = pg_exec($conn, $approvalSQL);
          $numrowsApproval = pg_numrows($resultApproval);
          if ($numrowsApproval == 0) {
            $redeemed = 'Redeemed';
            $approval = 'Not Claimed';
          } else {
            $redeemed = 'Claimed';
            $approval = pg_fetch_result($resultApproval, 0, 0);
          }
          ?>

            <td style="background-color: <?php echo $color; ?>"><?php echo $rowRedeem["shortname"]; ?> </td>
            <td style="background-color: <?php echo $color; ?>"><?php echo $redeemed; ?> </td>
            <td style="background-color: <?php echo $color; ?>"><?php echo $rowRedeem["facilityname"]; ?> </td>
            <td style="background-color: <?php echo $color; ?>">
                <nobr><?php echo $rowRedeem["redeemdate"]; ?> </nobr>
            </td>
            <td style="background-color: <?php echo $color; ?>"><?php echo $ref; ?></td>
            <td style="background-color: <?php echo $color; ?>"><?php echo $approval; ?> </td>

        </tr>
      <?php
    }
  }
  pg_close($conn);
  ?>
</table>
-----Report Complete-----
</body>
</html>