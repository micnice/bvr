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
include_once 'dbconnect.php';

$nationalid = $_GET['nationalid'];
$sql = pg_query(
    $conn,
    "SELECT nationalid,firstname,surname,dob,sex,lmp,edd,guardian,maritalstatus,parity,location,village,postaladdress,serialno,phone,city"
    ." FROM beneficiarymaster where nationalid='$nationalid'"
);

$count = 0;
$beneficiary = 'new';

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
  $location = $row[10];
  $village = $row[11];
  $postaladdress = $row[12];
  $serialno = $row[13];
  $phone = $row[14];
  $city = trim($row[15]);
  $beneficiary = 'update';
}
?>

<form method="POST" action="beneficiaryedit_process.php">
    <input type="hidden" name="beneficiary" id="nationalid"
           value="<?php echo $beneficiary; ?>">
    <div align="center"><br/>
        <table style="background-color: #E0F277;">
            <tr>
                <td colspan="4"><h3>Beneficiary Details</h3></td>
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