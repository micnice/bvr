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
      = "select DISTINCT a.nationalid,a.firstname,a.surname,a.phone,a.location,a.village,a.lmp,a.edd from beneficiarymaster a, vouchersales b"
      ." where a.nationalid = b.nationalid and substring(b.saledate,4,7) = '$period' and city='$district' and a.nationalid in (select nationalid from redeemedvouchers)";
} else {
  $strSQL
      = "select DISTINCT a.nationalid,a.firstname,a.surname,a.phone,a.location,a.village,a.lmp,a.edd from beneficiarymaster a, vouchersales b"
      ." where a.nationalid = b.nationalid and substring(b.saledate,4,7) = '$period' and city='$district' and "
      ." a.nationalid in (select  from redeemedvouchers) and b.voucherserial=$voucherserial";
}

$result = pg_exec($conn, $strSQL);
$numrows = pg_numrows($result);
?>

<h3 style="text-align: center">Voucher Tracker</h3>
<table>
    <tr>
        <td colspan="19">
            <div align="left">
                <form action="vouchertracker_beta.php" method="POST">
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
        <th>National ID</th>
        <th>First name</th>
        <th>Surname</th>
        <th>Address</th>
        <th>Phone</th>
        <th>LMP</th>
        <th>EDD</th>
        <th>Booking GA</th>
        <th>GA Weeks</th>
        <th>ANC First Visit</th>
        <th>Facility</th>
        <th>Ref</th>
        <th>ANC Second Visit</th>
        <th>Facility</th>
        <th>Ref</th>
        <th>ANC Third Visit</th>
        <th>Facility</th>
        <th>Ref</th>
        <th>ANC Fourth Visit</th>
        <th>Facility</th>
        <th>Ref</th>
        <th>Normal Delivery Clinic</th>
        <th>Facility</th>
        <th>Ref</th>
        <th>Complicated DeliveryClinic</th>
        <th>Facility</th>
        <th>Ref</th>
        <th>Complicated Delivery Hospital</th>
        <th>Facility</th>
        <th>Ref</th>
        <th>Ambulance Service</th>
        <th>Facility</th>
        <th>Ref</th>
        <th>Casearean Section</th>
        <th>Facility</th>
        <th>Ref</th>
        <th>PNC 1st Visit</th>
        <th>Facility</th>
        <th>Ref</th>
        <th>PNC 2nd Visit</th>
        <th>Facility</th>
        <th>Ref</th>
        <th>$10 Gift Token</th>
        <th>Facility</th>
        <th>Ref</th>
        <th>$20 Gift Token</th>
        <th>Facility</th>
        <th>Ref</th>
        <th>Complications during pregnancy</th>
        <th>Facility</th>
        <th>Ref</th>
        <th>Complications during Post natal</th>
        <th>Facility</th>
        <th>Ref</th>
        <th>Normal Delivery Hospital </th>
        <th>Facility</th>
        <th>Ref</th>
    </tr>

  <?php
  // Loop on rows in the result set.

  for ($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    $type1date = ''; $type2date = ''; $type3date = ''; $type4date = ''; $type5date = ''; $type6date = ''; $type7date= ''; $type8date= ''; $type9date= ''; $type10date= ''; $type11date= ''; $type12date= ''; $type13date= ''; $type14date= ''; $type15date= ''; $type16date= '';
    $type1facility= ''; $type2facility= ''; $type3facility= ''; $type4facility= ''; $type5facility= ''; $type6facility= ''; $type7facility= ''; $type8facility= ''; $type9facility= ''; $type10facility= ''; $type11facility= ''; $type12facility= ''; $type13facility= ''; $type14facility= ''; $type15facility= ''; $type16facility= '';
    $type1ref= ''; $type2ref= ''; $type3ref= ''; $type4ref= ''; $type5ref= ''; $type6ref= ''; $type7ref= ''; $type8ref= ''; $type9ref= ''; $type10ref= ''; $type11ref= ''; $type12ref= ''; $type13ref= ''; $type14ref= ''; $type15ref= ''; $type16ref= '';
    $nationalid = $row["nationalid"];

    $redeemSQL
        = "select c.facilityname, a.redeemdate, a.vouchertype, a.ref from redeemedvouchers a, facility c where a.distributorno = c.idfacility and a.nationalid = '$nationalid' order by a.vouchertype asc";
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
      $type = $rowRedeem['vouchertype'];
      if ($type == 1) {
          $type1date = str_replace('/', '-', trim($rowRedeem["redeemdate"]));
          $type1facility = $rowRedeem["facilityname"];
          $type1ref = $rowRedeem["ref"];
      } else if ($type == 2) {
          $type2date = str_replace('/', '-', trim($rowRedeem["redeemdate"]));
          $type2facility = $rowRedeem["facilityname"];
          $type2ref = $rowRedeem["ref"];
      } else if ($type == 3) {
          $type3date = str_replace('/', '-', trim($rowRedeem["redeemdate"]));
          $type3facility = $rowRedeem["facilityname"];
          $type3ref = $rowRedeem["ref"];
      } else if ($type == 4) {
          $type4date = str_replace('/', '-', trim($rowRedeem["redeemdate"]));
          $type4facility = $rowRedeem["facilityname"];
          $type4ref = $rowRedeem["ref"];
      } else if ($type == 5) {
          $type5date = str_replace('/', '-', trim($rowRedeem["redeemdate"]));
          $type5facility = $rowRedeem["facilityname"];
          $type5ref = $rowRedeem["ref"];
      } else if ($type == 6) {
          $type6date = str_replace('/', '-', trim($rowRedeem["redeemdate"]));
          $type6facility = $rowRedeem["facilityname"];
          $type6ref = $rowRedeem["ref"];
      } else if ($type == 7) {
          $type7date = str_replace('/', '-', trim($rowRedeem["redeemdate"]));
          $type7facility = $rowRedeem["facilityname"];
          $type7ref = $rowRedeem["ref"];
      } else if ($type == 8) {
          $type8date = str_replace('/', '-', trim($rowRedeem["redeemdate"]));
          $type8facility = $rowRedeem["facilityname"];
          $type8ref = $rowRedeem["ref"];
      } else if ($type == 9) {
          $type9date = str_replace('/', '-', trim($rowRedeem["redeemdate"]));
          $type9facility = $rowRedeem["facilityname"];
          $type9ref = $rowRedeem["ref"];
      } else if ($type == 10) {
          $type10date = str_replace('/', '-', trim($rowRedeem["redeemdate"]));
          $type10facility = $rowRedeem["facilityname"];
          $type10ref = $rowRedeem["ref"];
      } else if ($type == 11) {
          $type11date = str_replace('/', '-', trim($rowRedeem["redeemdate"]));
          $type11facility = $rowRedeem["facilityname"];
          $type11ref = $rowRedeem["ref"];
      } else if ($type == 12) {
          $type12date = str_replace('/', '-', trim($rowRedeem["redeemdate"]));
          $type12facility = $rowRedeem["facilityname"];
          $type12ref = $rowRedeem["ref"];
      } else if ($type == 13) {
          $type13date = str_replace('/', '-', trim($rowRedeem["redeemdate"]));
          $type13facility = $rowRedeem["facilityname"];
          $type13ref = $rowRedeem["ref"];
      } else if ($type == 14) {
          $type14date = str_replace('/', '-', trim($rowRedeem["redeemdate"]));
          $type14facility = $rowRedeem["facilityname"];
          $type14ref = $rowRedeem["ref"];
      } else if ($type == 15) {
          $type15date = str_replace('/', '-', trim($rowRedeem["redeemdate"]));
          $type15facility = $rowRedeem["facilityname"];
          $type15ref = $rowRedeem["ref"];
      } else if ($type == 16) {
          $type16date = str_replace('/', '-', trim($rowRedeem["redeemdate"]));
          $type16facility = $rowRedeem["facilityname"];
          $type16ref = $rowRedeem["ref"];
      } else {
         //DO NOTHING
      }

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
      <?php
    } ?>
  <tr style="vertical-align:top">
            <td style="background-color: <?php echo $color; ?>"><?php echo $row["nationalid"]; ?> </td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $row["firstname"]; ?> </td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $row["surname"]; ?> </td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $row["location"]
          .', '.$row["village"]; ?> </td>
    <td style="background-color: <?php echo $color; ?>">
        <nobr><?php echo $row["phone"]; ?> </nobr>
    </td>
    <td style="background-color: <?php echo $color; ?>">
        <nobr><?php echo $lmp; ?> </nobr>
    </td>

    <td style="background-color: <?php echo $color; ?>">
        <nobr><?php echo $newEdd; ?> </nobr>
    </td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $days ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $weeks; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type1date; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type1facility; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type1ref; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type2date; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type2facility; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type2ref; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type3date; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type3facility; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type3ref; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type4date; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type4facility; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type4ref; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type5date; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type5facility; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type5ref; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type6date; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type6facility; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type6ref; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type7date; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type7facility; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type7ref; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type8date; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type8facility; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type8ref; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type9date; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type9facility; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type9ref; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type10date; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type10facility; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type10ref; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type11date; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type11facility; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type11ref; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type12date; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type12facility; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type12ref; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type13date; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type13facility; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type13ref; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type14date; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type14facility; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type14ref; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type15date; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type15facility; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type15ref; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type16date; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type16facility; ?></td>
    <td style="background-color: <?php echo $color; ?>"><?php echo $type16ref; ?></td>
    </tr>
    <?php
  }
  pg_close($conn);
  ?>
</table>
-----Report Complete-----
</body>
</html>