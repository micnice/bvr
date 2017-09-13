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
<?php
include "dbconnect.php";

$firstname = strtolower(trim($_POST['firstname']));
$surname = strtolower(trim($_POST['surname']));

if (isset($_POST['nationalid'])) {
  $nationalid = strtolower(trim($_POST['nationalid']));
} else {
  $nationalid = strtolower(trim($_GET['nationalid']));
}

// if(strlen($nationalid)==0){
//     $strSQL = "SELECT * From beneficiarymaster where (lower(firstname) like '%$firstname%' and lower(surname) like '%$surname%') or (lower(firstname) like '%$surname%' and lower(surname) like '%$firstname%') limit 100";
// }else{
//     $strSQL = "SELECT * From beneficiarymaster where lower(nationalid) like '%$nationalid%' limit 100";
// }
if (strlen($nationalid) == 0) {
  $strSQL
      = "SELECT * From beneficiarymaster where lower(trim(nationalid)) not in (select lower(trim(nationalid)) from vouchersales) and ((lower(firstname) like '%$firstname%' and lower(surname) like '%$surname%') or (lower(firstname) like '%$surname%' and lower(surname) like '%$firstname%')) limit 100";
} else {
  $strSQL
      = "SELECT * From beneficiarymaster where lower(trim(nationalid)) not in (select lower(trim(nationalid)) from vouchersales) and lower(trim(nationalid)) like '%$nationalid%' limit 100";
}

$result = pg_exec($conn, $strSQL);
$numrows = pg_numrows($result);
?>

<h3 style="text-align: left">Search Results</h3>

<?php
if (strcmp($_SESSION['social_process'], "true") == 0) {
} else {
  ?>
    <form action="social_register_form.php" method="POST">
        <input type="hidden" name="nationalid" value="No ID">
        <input type="submit" value="Enter New Beneficiary">
    </form>
  <?php
}
?>
<table style="margin:auto 0">
    <tr style="background-image: url(images/green_bg.png);">
        <th>First Name</th>
        <th>Last Name</th>
        <th>National ID</th>
        <th>Address</th>
        <th></th>
    </tr>

  <?php

  // Loop on rows in the result set.

  for ($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    ?>
      <tr>
          <td><?php echo $row["firstname"]; ?> </td>
          <td><?php echo $row["surname"]; ?> </td>
          <td><?php echo $row["nationalid"]; ?> </td>
          <td><?php echo $row["location"].', '.$row["village"].', '
                .$row["area"]; ?> </td>
          <td>
            <?php
            if (strcmp($row["assessment"], "N") == 0) {
              echo "<font color=red>Not Eligible</font>";
            } else {
              if (strcmp($row["assessment"], "Y") == 0) {
                ?>
                  <font color=green>Eligible</font><br/>
                  <form action="social_vouchersales.php" method="POST">
                      <input type="hidden" name="nationalid"
                             value="<?php echo $row["nationalid"]; ?>">
                      <input type="submit" value="Enter Sale">
                  </form>
                <?php
              } else {
                ?>
                  <form action="social_assessment_form.php" method="POST">
                      <input type="hidden" name="nationalid"
                             value="<?php echo $row["nationalid"]; ?>">
                      <input type="submit" value="Assessment">
                  </form>
                <?php
              }
            }
            ?>
          </td>
      </tr>
    <?php
  }
  pg_close($conn);
  ?>
</table>

<?php
if (strcmp($_SESSION['social_process'], "true") == 0) {
} else {
  ?>
    <form action="social_register_form.php" method="POST">
        <input type="hidden" name="nationalid" value="No ID">
        <input type="submit" value="Enter New Beneficiary">
    </form>
  <?php
}
?>

</div>

<?php
include "social_nextsale.php";
$_SESSION['social_process'] = "true";
?>

</body>
</html>
