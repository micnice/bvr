<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<?php
session_start();
if(strcmp($_SESSION['login'], 'false')==0){
    header('Location: index.php');
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Welcome to the Beneficiary Voucher Repository System</title>
        <link rel="stylesheet" href="../css/style.css" type="text/css" media="screen">
    </head>
    <body style="text-align: center;">
<?php
include "dbconnect.php";

    $firstname=strtolower(trim($_POST['firstname']));
    $surname=strtolower(trim($_POST['surname']));
    $nationalid=strtolower(trim($_POST['nationalid']));

    if(strlen($nationalid)==0){
        $strSQL = "SELECT * From beneficiarymaster where lower(trim(nationalid)) not in (select lower(trim(nationalid)) from vouchersales) and ((lower(firstname) like '%$firstname%' and lower(surname) like '%$surname%') or (lower(firstname) like '%$surname%' and lower(surname) like '%$firstname%')) limit 100";
    }else{
        $strSQL = "SELECT * From beneficiarymaster where (lower(trim(nationalid)) not in (select lower(trim(nationalid)) from vouchersales) or pregnancy=2) and lower(trim(nationalid)) like '%$nationalid%' limit 100";
    }

    //echo $strSQL;

    $result = pg_exec($conn, $strSQL);
    $numrows = pg_numrows($result);

    $strBeneficiary = "SELECT * From beneficiarymaster where lower(trim(nationalid)) like '%$nationalid%' and length(trim(nationalid))>=10 limit 100";
    $resultBeneficiary = pg_exec($conn, $strBeneficiary);
    $numRowsBeneficiary = pg_numrows($resultBeneficiary);
?>

<h3 style="text-align: center">Search Results</h3>

<table style="margin:auto auto; text-align: left;">
<tr style="background-image: url(images/green_bg.png);">
   <th>First Name</th>
   <th>Last Name</th>
   <th>National ID</th>
   <th>Address</th>
   <th>2nd Pregnancy</th>
   <th></th>
</tr>

<?php

   // Loop on rows in the result set.

   for($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);

    if($row['pregnancy']==2){
      $secondPregnancy = "Yes";
    }else{
      $secondPregnancy = "";
    }

    ?>
        <tr>
           <td><?php echo $row["firstname"]; ?> </td>
           <td><?php echo $row["surname"]; ?> </td>
           <td><?php echo $row["nationalid"]; ?> </td>
           <td><?php echo $row["location"].', '.$row["village"].', '. $row["area"]; ?> </td>
           <td><?php echo $secondPregnancy; ?> </td>
           <td>
               <form action="vouchersales.php" method="POST">
                <input type="hidden" name="nationalid" value="<?php echo $row["nationalid"]; ?>">
                <?php
                if($row['pregnancy']==2){
                ?>
                <input type="hidden" name="pregnancy" value="2">
                <?php
                  }
                 ?>
                <input type="submit" value="Enter Sale">
                </form>
               </td>
        </tr>
<?php
  }
   pg_close($conn);
  ?>
</table>
  </div>

  <?php
    if($numrows==0){
      if($numRowsBeneficiary==0){
        ?>
          <font color='red'><h2>Beneficiary Does not Exist</h2></font>
        <?php
      }else{
        $row = pg_fetch_array($resultBeneficiary, 0);
        echo '<h3>'.$row["firstname"].' '.$row["surname"].', ID Number: '.$row["nationalid"].'</h2>';
        ?>
          <font color='red'><h3>Beneficiary Exists But has already bought a Voucher!</h3></font>
          <form action="vouchersales_pregnancy.php" method="POST">
           <input type="hidden" name="nationalid" value="<?php echo $row["nationalid"]; ?>">
           <input type="hidden" name="firstname" value="<?php echo $row["firstname"]; ?>">
           <input type="hidden" name="surname" value="<?php echo $row["surname"]; ?>">
           <input type="hidden" name="pregnancy" value="2">
           <input type="submit" value="Activate Second Pregnancy">
           </form>
      <?php
      }
    }

  include "nextsale.php";

  ?>

  </body>
</html>
