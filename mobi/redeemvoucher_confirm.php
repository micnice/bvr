<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN"
        "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<?php
session_start();
if (strcmp(trim($_SESSION['login']), 'false') == 0) {
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
include "../dbconnect.php";

$nationalid = trim($_POST['nationalid']);
$nationalid = str_replace(' ', '', str_replace('-', '', $nationalid));
$vouchertype = $_POST['vouchertype'];
$period = $_POST['period'];
$distributor = $_POST['distributor'];

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
$dob = '';
while ($row = pg_fetch_row($sql)) {
  $count = $count + 1;
  $firstname = $row[1];
  $surname = $row[2];
  $dob = $row[6];
}

if ($count == 0) {
  die(
      "<div align='center'><br /><br />Beneficiary with National ID <em>"
      .$nationalid."</em> does not exist!</div>"
  );
} else {
}

$sql = pg_query(
    $conn,
    "SELECT voucherserial From vouchersales where nationalid='$nationalid'"
);

$count = 0;
$redeemserial = 0;
while ($row = pg_fetch_row($sql)) {
  $count = $count + 1;
  $redeemserial = $row[0];
}

$userrole = trim($_SESSION['userrole']);
//echo $userrole;

if (strcmp($userrole, 'clinic') == 0) {
  $salerecordurl = "vouchersales.php?page=vouchersales&nationalid=$nationalid";
} elseif (strcmp($userrole, 'admin') == 0 || strcmp($userrole, 'NPA') == 0) {
  $salerecordurl = "../main.php?page=vouchersales&nationalid=$nationalid";
}

if ($count == 0) {
  echo "<div align='center'><br /><br />No Voucher was sold to beneficiary with National ID <em>"
      .$nationalid."</em>!";
  ?>
    <br/>
<?php
if (strcmp($userrole, 'admin') == 0 || strcmp($userrole, 'NPA') == 0){
?>
    <a href="JavaScript:void(0);"
       onclick="openInParent('<?php echo $salerecordurl; ?>');">
        Enter Voucher Sale
    </a>

    <script>
        function openInParent(url) {
            window.opener.location.href = url;
            window.close();
        }
    </script>

<?php
}else{
?>
    <a href="<?php echo $salerecordurl; ?>">
        Enter Voucher Sale
    </a>
<?php
}
?>
    </div>
  <?php
  exit();
} else {
}

?>
<div align="left"><font color="red">Please Confirm Voucher Type</font>
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
            <td><font style="color:#537313">Facility:</font></td>
            <td><?php echo $facilityname; ?></td>
        </tr>
        <tr>
            <td><font style="color:#537313">Period:</font></td>
            <td><?php echo $periodname; ?></td>
        </tr>

    </table>
  <?php
  $sql = pg_query(
      $conn,
      "SELECT shortname From vouchertype where usage=$vouchertype"
  );

  $count = 0;
  $amount = 0;
  $shortname = "";

  while ($row = pg_fetch_row($sql)) {
    $count = $count + 1;
    $shortname = $row[0];
  }
  if ($count == 0) {
    die("<div align='center'><br />... $vouchertype ...<br /> <em>No Vouchers exist for this person</div>");
  } else {
  }
  $label = 'Ref';
  if ($vouchertype == 1 || $vouchertype == 2 || $vouchertype == 3
      || $vouchertype == 4
  ) {
    $label = 'ANC Register';
  }
  if ($vouchertype == 5 || $vouchertype == 6 || $vouchertype == 7
      || $vouchertype == 9
  ) {
    $label = 'Delivery Register';
  }
  if ($vouchertype == 8) {
    $label = 'Call';
  }
  if ($vouchertype == 10 || $vouchertype == 11) {
    $label = 'PNC Register';
  }
  if ($vouchertype == 12 || $vouchertype == 13) {
    $redeemserial = '';
  }
  ?>
    <br/>Redeem <font color="red"><?php echo $shortname; ?> ?</font><br/>

    <table style="margin:auto 0; border:0; margin:0; padding:0">
        <tr>
            <td style="margin:0 auto">
                <form action="redeemvoucher_process.php" method="POST">
                    <table>
                        <tr>
                            <td>Voucher/Token Serial:</td>
                            <td><input type="text" name='redeemserial'
                                       value="<?php echo $redeemserial ?>" <?php if ($vouchertype
                                  == 12
                                  || $vouchertype == 13
                              ) {
                                echo "";
                              } else {
                                echo "readonly";
                              } ?>></td>
                        </tr>

                        <tr>
                            <td><?php echo $label; ?> No. :</td>
                            <td><input type="text" size="11" maxlength="11"
                                       name="ref" value="<?php echo $ref; ?>"
                                       required></td>
                        </tr>
                    </table>
                    <input type="hidden" name="vouchertype"
                           value="<?php echo $vouchertype; ?>">
                    <input type="hidden" name="nationalid"
                           value="<?php echo $nationalid; ?>" required>
                    <input type="hidden" name="period"
                           value="<?php echo $period; ?>">
                    <input type="hidden" name="label"
                           value="<?php echo $label; ?>">
                    <input type="hidden" name="distributor"
                           value="<?php echo $distributor; ?>">
                    <input type="submit" value="Confirm" style="margin:0 auto">
                </form>
                <form action="verifyvoucher_process.php" method="POST">
                    <input type="hidden" name="nationalid"
                           value="<?php echo $nationalid; ?>">
                    <input type="hidden" name="period"
                           value="<?php echo $period; ?>">
                    <input type="hidden" name="distributor"
                           value="<?php echo $distributor; ?>">
                    <input type="submit" value="Cancel" style="margin:0 auto">
                </form>
            </td>
        </tr>
    </table>
    <br/>
  <?php include "footer.php"; ?>
</body>
</html>