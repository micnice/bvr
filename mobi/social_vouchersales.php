<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN"
        "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<?php
session_start();
$_SESSION['social_process'] = "false";
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
include_once 'dbconnect.php';

if (isset($_POST['nationalid'])) {
  $nationalid = strtoupper(trim($_POST['nationalid']));
} else {
  $nationalid = strtoupper(trim($_GET['nationalid']));
}

$sql = pg_query(
    $conn,
    "SELECT b.nationalid, b.firstname, b.surname, b.dob, b.sex, p.lmp, p.edd, b.guardian, b.maritalstatus, p.parity, p.pregnancy, b.location, b.village, b.postaladdress, b.serialno, b.phone, b.city, p.idreg"
    ." FROM beneficiarymaster b, pregnancyregistration p where p.idbeneficiarymaster=b.idbeneficiarymaster and upper(b.nationalid)='$nationalid'"
);

$count = 0;
$amount = 0;
$bvrnumber = 0;
$nationalid = str_replace(' ', '', str_replace('-', '', $nationalid));
while ($row = pg_fetch_row($sql)) {
  $count = $count + 1;
  $firstname = $row[1];
  $surname = $row[2];
  $dob = $row[3];
  $sex = $row[4];
  $lmp = $row[5];
  $edd = $row[6];
  $guardian = $row[7];
  $maritalstatus = $row[8];
  $parity = $row[9];
  $pregnancy = $row[10];
  $location = $row[11];
  $village = $row[12];
  $postaladdress = $row[13];
  $serialno = $row[14];
  $phone = $row[15];
  $city = trim($row[16]);
  $idreg = $row[17];
  $beneficiarytitle = 'Update ';
  $beneficiary = 'update';
}

if ($count == 0) {
  $firstname = '';
  $surname = '';
  $dob = '';
  $sex = '';
  $lmp = '';
  $edd = '';
  $guardian = '';
  $maritalstatus = '';
  $parity = '';
  $pregnancy = '';
  $location = '';
  $village = '';
  $postaladdress = '';
  $serialno = '';
  $phone = '';
  $voucherserial = '';
  $facility = '';
  $saledate = '';
  $city = '';
  $idreg = '';
  $beneficiarytitle = 'Enter New ';
  $vouchertitle = 'Enter New ';
  $beneficiary = 'new';

  include_once 'generate_nationalid.php';
  $nationalid_blank = "XXXXXXXXXXXXXX";
  $sql = pg_query(
      $conn,
      "SELECT voucherserial,nationalid,distributorno,saledate,idreg FROM vouchersales where nationalid='$nationalid_blank'"
  );
} else {
  $sql = pg_query(
      $conn,
      "SELECT voucherserial,nationalid,distributorno,saledate, idreg FROM vouchersales where and idreg = '$idreg' and nationalid='$nationalid'"
  );
}

$count = 0;
while ($row = pg_fetch_row($sql)) {
  $count = $count + 1;
  $voucherserial = $row[0];
  $distributor = $row[2];
  $saledate = $row[3];
  $voucher = 'update';
  $vouchertitle = 'Update ';
}
if ($count == 0) {
  $voucherserial = 0;
  $distributor = 0;
  $saledate = '';
  $voucher = 'new';
  $vouchertitle = 'Enter New ';
}
?>

<form method="POST" action="vouchersales_process.php">
    <input type="hidden" name="voucher" value="<?php echo $voucher; ?>">
    <input type="hidden" name="beneficiary" value="<?php echo $beneficiary; ?>">
    <div align="center"><br/>
        <table style="background-color: #E0F277;">
            <tr>
                <td colspan="4"><font style="color: red">All dates should be in
                        this format: <em>dd/mm/yyyy</em></font>
                    <h3><?php echo $vouchertitle; ?>Voucher Details</h3></td>
            </tr>
            <tr class="lime">
                <td><font size="4">Voucher Serial</font></td>
                <td><input type="text" size="30" maxlength="50"
                           name="voucherserial"
                           value="<?php echo trim($voucherserial); ?>" required>
                </td>
                <td><font size="4">Facility</font></td>
                <td>

                    <select name="distributor"
                            id="distributor" <?php if (strcmp($voucher, 'new')
                        == 0
                    ) {
                      echo "required";
                    } ?>>
                        <option value="">---Select Facility---</option>
                      <?php
                      $sql = pg_query(
                          $conn,
                          "SELECT idfacility,facilityname FROM facility order by facilityname asc"
                      );
                      $selected = '';
                      while ($row = pg_fetch_assoc($sql)) {
                        if ($distributor == $row['idfacility']) {
                          $selected = ' selected';
                        } else {
                          $selected = '';
                        }
                        echo '<option value="'.htmlspecialchars(
                                $row['idfacility']
                            ).'"'.$selected.'>'.htmlspecialchars(
                                $row['facilityname']
                            ).'</option>';
                      }
                      //pg_close($conn);
                      ?>
                    </select>
                </td>
            </tr>
            <tr class="lime">
                <td><font size="4">Sale Date</font></td>
                <td><input type="text" size="11" maxlength="11" name="saledate"
                           id="saledate " pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}"
                           value="<?php echo trim($saledate); ?>"
                           placeholder="dd/mm/yyyy" required></td>
                <td colspan="2"><input type="checkbox" name="salerecord"
                                       value="yes"/><font size="4">No voucher
                        sale record</font></td>
            </tr>
            <tr>
                <td colspan="4"><h3><?php echo $beneficiarytitle; ?>Beneficiary
                        Details</h3></td>
            </tr>
          <?php include_once 'include_beneficiary.php'; ?>
        </table>
    </div>
    <p align="center">
        <input type="submit" value="Submit"/></p> </p>
    <p>&nbsp;</p>
</form>

<?php
pg_close($conn);
?>

<?php include "footer.php"; ?>

</body>
</html>