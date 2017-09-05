<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<?php
session_start();
if(strcmp($_SESSION['login'], 'false')==0){
    header('Location: index.php');
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Beneficiary Voucher Repository System</title>
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen">
</head>
<body>
<?php 
include "../dbconnect.php";

    $searchby=strtolower(trim($_POST['searchby']));
    $firstname=strtolower(trim($_POST['firstname']));
    $surname=strtolower(trim($_POST['surname']));
    
    $period=$_POST['period'];
    $distributor=$_POST['distributor'];

    $strSQL = "SELECT * From beneficiarymaster where (lower(firstname) like '%$firstname%' and lower(surname) like '%$surname%') or (lower(firstname) like '%$surname%' and lower(surname) like '%$firstname%') limit 100";
    $result = pg_exec($conn, $strSQL);
    $numrows = pg_numrows($result);
?>
 
<h3 style="text-align: left">Search Results</h3>
<table style="margin:auto 0">
<tr style="background-image: url(../images/green_bg.png);">  
   <th>First Name</th>
   <th>Last Name</th>
   <th>National ID</th>
   <th>Action</th>
   <th>Address</th>
   <th></th>
</tr>

<?php

   // Loop on rows in the result set.

   for($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    ?>
        <tr>
           <td><?php echo $row["firstname"]; ?> </td>
           <td><?php echo $row["surname"]; ?> </td>
           <td><?php echo $row["nationalid"]; ?> </td>
           <td><a href="../nationalid_edit.php?source=mobi&nationalid=<?php echo trim($row["nationalid"]); ?>">Edit</a></td>
           <td><?php echo $row["location"].', '.$row["village"].', '. $row["area"]; ?> </td>
           <td> 
               <form action="verifyvoucher_process.php" method="POST">
                <input type="hidden" name="nationalid" value="<?php echo $row["nationalid"]; ?>">
                <input type="hidden" name="period" value="<?php echo $period; ?>">
                <input type="hidden" name="distributor" value="<?php echo $distributor; ?>">
                <input type="submit" value="Redeem">
                </form>
               </td>
        </tr>
<?php
  }
   pg_close($conn);
  ?>
</table>

<br /><br /> <?php include "footer.php"; ?>
  </div>
 </body>
</html>