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
<div align="left">
  <?php
  include "../dbconnect.php";

  $nationalid = $_POST['nationalid'];
  $period = $_POST['period'];
  $distributor = $_POST['distributor'];
  $userrole = trim($_SESSION['userrole']);

  $refnumber = $_POST['refnumber'];
  $refVerify = 0;

  if ($refnumber > 0) {
    $sqlRef = pg_query(
        $conn,
        "SELECT referralnumber From referrals where nationalid='$nationalid'"
    );

    $rowRef = pg_fetch_row($sqlRef);
    $refVerify = pg_num_rows($sqlRef);
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


  $sql = pg_query(
      $conn,
      "SELECT * From beneficiarymaster where nationalid='$nationalid'"
  );

  $count = 0;
  $amount = 0;
  while ($row = pg_fetch_row($sql)) {
    $count = $count + 1;
    $firstname = $row[1];
    $surname = $row[2];
    $dob = $row[6];
    $address = $row[14].', <br />'.$row[16].', <br />'.$row[19];
  }

  if ($refVerify == 0 && strcmp(trim($_SESSION['userrole']), 'hospital') == 0) {
    echo "The Beneficiary did not follow Referral Procedure. <font color='red'>Only Clients referred by the Clinic will be reimbursed. </font>Please confirm with referring Clinic<br /><br /><a href='verifyvoucher.php'>Verify / Redeem Voucher</a>";
    die();
  }

  if ($count == 0) {
    die(
        "<div align='center'><br /><br />Beneficiary with National ID <em>"
        .$nationalid
        ."</em> does not exist!<br /><a href='verifyvoucher.php'>Try Again</a></div>"
    );
  } else {
  }
  ?>
    <div align="left">
        <table style="margin:auto 0;">
            <tr>
                <td><font style="color:#537313">ID No/BVR No:</font></td>
                <td><?php echo $nationalid; ?></td>
            </tr>
            <tr>
                <td><font style="color:#537313"><?php echo str_pad(
                        'First Name:',
                        100
                    ); ?></font></td>
                <td> <?php echo $firstname; ?></td>
            </tr>
            <tr>
                <td><font style="color:#537313">Surname:</font></td>
                <td><?php echo $surname; ?></td>
            </tr>
            <tr>
                <td><font style="color:#537313">Date of Birth:</font></td>
                <td><?php echo $dob; ?></td>
            </tr>
            <tr>
                <td><font style="color:#537313">Address:</font></td>
                <td><?php echo $address; ?></td>
            </tr>
            <tr>
                <td><font style="color:#537313">Facility:</font></td>
                <td><?php echo $facilityname; ?></td>
            </tr>
            <tr>
                <td><font style="color:#537313">Period:</font></td>
                <td><?php echo $periodname; ?></td>
            </tr>

        </table>
        <br/><em>Available Vouchers:</em>
        <table style="margin:auto 0;">
          <?php
          $sqlStr
              = "SELECT vouchertype From redeemedvouchers where nationalid='$nationalid' and vouchertype=9";
          $sqlCS = pg_query($conn, $sqlStr);
          $rowCS = pg_fetch_row($sqlCS);
          $voucherCS = $rowCS[0];
          //echo $voucherCS;
          //echo $sqlStr;

          $sqlStr
              = "SELECT vouchertype From redeemedvouchers where nationalid='$nationalid' and vouchertype in (5,6,7,9)";
          $sqlDelivery = pg_query($conn, $sqlStr);
          $rowDelivery = pg_fetch_row($sqlDelivery);
          $voucherDelivery = $rowDelivery[0];


          if (strcmp($userrole, 'hospital') == 0) {
            $sqlStr1
                = "SELECT * From vouchertype where usage not in (SELECT vouchertype from REDEEMEDVOUCHERS where nationalid='$nationalid') and usage in (7,9,14,15,16) order by usage asc";
          } elseif (strcmp($userrole, 'clinic') == 0) {
            $sqlStr1
                = "SELECT * From vouchertype where usage not in (SELECT vouchertype from REDEEMEDVOUCHERS where nationalid='$nationalid') and usage in (1,2,3,4,5,6,10,11) order by usage asc";
          } elseif (strcmp($userrole, 'matron') == 0 && $voucherDelivery == 7) {
            $sqlStr1
                = "SELECT * From vouchertype where usage not in (SELECT vouchertype from REDEEMEDVOUCHERS where nationalid='$nationalid') and usage in (12) order by usage asc";
          } elseif (strcmp($userrole, 'matron') == 0 && $voucherDelivery == 9) {
            $sqlStr1
                = "SELECT * From vouchertype where usage not in (SELECT vouchertype from REDEEMEDVOUCHERS where nationalid='$nationalid') and usage in (13) order by usage asc";
          } elseif (strcmp($userrole, 'sic') == 0
              && ($voucherDelivery == 5
                  || $voucherDelivery == 6)
          ) {
            $sqlStr1
                = "SELECT * From vouchertype where usage not in (SELECT vouchertype from REDEEMEDVOUCHERS where nationalid='$nationalid') and usage in (12) order by usage asc";
          } elseif (strcmp($userrole, 'ambulance') == 0) {
            $sqlStr1
                = "SELECT * From vouchertype where usage not in (SELECT vouchertype from REDEEMEDVOUCHERS where nationalid='$nationalid') and usage in (8) order by usage asc";
          } elseif (strcmp($userrole, 'admin') == 0) {
            $sqlStr1
                = "SELECT * From vouchertype where usage not in (SELECT vouchertype from REDEEMEDVOUCHERS where nationalid='$nationalid') order by usage asc";
          }
          //echo $sqlStr1.';';
          $sql = pg_query($conn, $sqlStr1);

          $count = 0;
          $amount = 0;
          while ($row = pg_fetch_row($sql)) {
            $count = $count + 1;
            $shortname = $row[0];
            $usage = $row[6];
            ?>
              <tr>
                  <td><?php echo $usage; ?></td>
                  <td><?php echo $shortname; ?></td>
                  <td>
                      <form action="redeemvoucher_confirm.php" method="POST">
                          <input type="hidden" name="vouchertype"
                                 value="<?php echo $usage; ?>">
                          <input type="hidden" name="period"
                                 value="<?php echo $period; ?>">
                          <input type="hidden" name="dob"
                                 value="<?php echo $dob; ?>">
                          <input type="hidden" name="distributor"
                                 value="<?php echo $distributor; ?>">
                          <input type="hidden" name="nationalid"
                                 value="<?php echo $nationalid; ?>">
                          <input type="submit" value="Redeem">
                      </form>
                  </td>
              </tr>


            <?php
          }
          ?>
        </table>
      <?php
      if ($count == 0) {
        die("<div align='center'><br /><br /> <em>Voucher for this service already redeemed for Patient with ID: <font color='red'>$nationalid</font></div>");
      } else {
      }
      ?>

        <br/><br/> <?php include "footer.php"; ?>
    </div>
</body>
</html>