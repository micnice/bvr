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

$strSQL = "select a.nationalid,a.firstname,a.surname, a.lmp,a.location,a.village,a.phone,a.reg_date,a.city,"
            . "coalesce(b.f112,0) as f112,coalesce(b.f113,0) as f113,coalesce(b.f114,0) as f114,coalesce(b.f115,0) as f115,coalesce(b.f116a,0) as f116a,"
            . "coalesce(b.f116b,0) as f116b, coalesce(b.f117,0) as f117, coalesce(b.f118,0) as f118, coalesce(b.f119,0) as f119, coalesce(b.f120,0) as f120, coalesce(b.f121,0) as f121,"
            . "coalesce(b.f112,0)+coalesce(b.f113,0)+coalesce(b.f114,0)+coalesce(b.f115,0)+coalesce(b.f116a,0)+coalesce(b.f116b,0)+"
            . "coalesce(b.f117,0)+coalesce(b.f118,0)+coalesce(b.f119,0)+coalesce(b.f120,0)+coalesce(b.f121,0) as score "
          . " from beneficiarymaster a,assessment b where a.nationalid not in (select nationalid from vouchersales)"
            . " and a.city ='$city' and a.nationalid=b.nationalid order by reg_date asc";
    
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

<h3 style="text-align: center">Assessment Scores<br /><br />
<?php 
    echo "$district"; 
?> 
    </h3>
<style>
th {
    color: white;
    text-align: center;
    text-size:100%;
    vertical-align: text-top;
}
</style>
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
   <th><nobr>F112: Meals<br /> a day</nobr> </th>
   <th><nobr>F113: Livelihood <br />sources</nobr></th>
   <th><nobr>F114: Monthly <br />remittances</nobr></th>
   <th><nobr>F115: % income <br />(rent & rates)</nobr></th>
   <th><nobr>F116a: Water<br /> disconnected</nobr></th>
   <th><nobr>F116b: Electricity <br />disconnected</nobr></th>
   <th><nobr>F117: Sleeping<br /> rooms</nobr></th>
   <th><nobr>F118: Cooking<br /> fuel type</nobr></th>
   <th><nobr>F119: Main material <br />house walls</nobr></th>
   <th><nobr>F120: Tenure <br />stands</nobr></th>
   <th><nobr>F121: HH <br />posessions</nobr></th>
   <th>Score</th>
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
           <td><?php echo $row["f112"]; ?> </td>
	   <td><?php echo $row["f113"]; ?> </td>
	   <td><?php echo $row["f114"]; ?> </td>
	   <td><?php echo $row["f115"]; ?> </td>
	   <td><?php echo $row["f116a"]; ?> </td>
	   <td><?php echo $row["f116b"]; ?> </td>
	   <td><?php echo $row["f117"]; ?> </td>
	   <td><?php echo $row["f118"]; ?> </td>
	   <td><?php echo $row["f119"]; ?> </td>
	   <td><?php echo $row["f120"]; ?> </td>
	   <td><?php echo $row["f121"]; ?> </td>

  	   <td><?php echo $row["score"]; ?> </td>
           
        </tr>
<?php
  }
   pg_close($conn);
  ?>
</table>

</body>
</html>
