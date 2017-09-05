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
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>    
<?php 
include 'dbconnect.php';
$city = trim($_POST['city']);

    $strSQL = "select nationalid,firstname,surname, lmp,location,village,phone,reg_date,city "
          . " from beneficiarymaster where nationalid not in (select nationalid from vouchersales)"
            . " and city ='$city' order by reg_date asc";
    //echo $strSQL;
  $result = pg_exec($conn, $strSQL);
  $numrows = pg_numrows($result);
  
  if(strcmp($city, 'Harare')==0){
      $district = 'Harare South';
  }elseif(strcasecmp($city, 'Bulawayo')==0){
      $district = "Nkulumane";
  }else{
      $district = 'Harare South';
  }
  
?>

<h3 style="text-align: center">List of Beneficiaries with no Voucher Sales<br /><br />
<?php 
    echo "$district"; 
?> 
    </h3>

<table>
<tr style="background-image: url(images/green_bg.png);">  
    <th>National ID</th>
   <th>First Name</th>
   <th>Surname</th>
   <th>Address</th>
   <th>Tel. No.</th>
   <th>City</th>
   <th>Enrollment Date</th>
   <th>LMP</th>
   <th>EDD</th>
</tr>

<?php

   // Loop on rows in the result set.

   for($i = 0; $i < $numrows; $i++) {
        $row = pg_fetch_array($result, $i);
        $lmp = trim($row['lmp']);
        
        
        $splitLmp = explode('/',$lmp);
        $newLmp = $splitLmp[2].'-'.$splitLmp[1].'-'.$splitLmp[0];

        $edd = date('Y-m-d', strtotime($newLmp. ' + 280 days'));
        if(strlen($lmp)>8){
            $splitEdd = explode('-',$edd);
            $newEdd = $splitEdd[2].'-'.$splitEdd[1].'-'.$splitEdd[0];
        }else{
            $newEdd='';
        }
        
        $splitRegDate = explode('-',$row["reg_date"]);
        $newRegDate = $splitRegDate[2].'-'.$splitRegDate[1].'-'.$splitRegDate[0];
    ?>
        <tr>
           <td><?php echo $row["nationalid"]; ?> </td>
           <td><?php echo $row["firstname"]; ?> </td>
           <td><?php echo $row["surname"]; ?> </td>
           <td><?php echo $row["location"].', '.$row["village"]; ?> </td>
           <td><nobr><?php echo $row["phone"]; ?> </nobr></td>
            <td><?php echo $district; ?> </td>
            <td><nobr><?php echo $newRegDate; ?> </nobr></td>
           <td><nobr><?php echo $row["lmp"]; ?> </nobr></td>
           <td><nobr><?php echo $newEdd; ?> </nobr></td>
           
        </tr>
<?php
  }
   pg_close($conn);
  ?>
</table>

</body>
</html>