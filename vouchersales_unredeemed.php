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
$distributor = trim($_POST['distributor']);
$period = trim($_POST['period']);
$vserial = 0;



   $sql1 = pg_query($conn,"SELECT facilityname From facility where idfacility='$distributor'");

   $row2 = pg_fetch_row($sql1);
   $facilityname = $row2[0];

   $sql2 = pg_query($conn,"SELECT monthname,yearname From period where monthcode=$period");

   $row3 = pg_fetch_row($sql2);
   $periodname = $row3[0].' '.$row3[1];

    $strSQL = "select a.voucherserial,a.nationalid,a.saledate,a.distributorno,b.firstname,b.surname, b.lmp,b.location,b.village,b.phone "
          . " from beneficiarymaster b, vouchersales a where a.nationalid=b.nationalid and a.distributorno=$distributor "
              . " and substring(a.saledate,4,2)::int=$period and substring(a.saledate,7,4)::int=$row3[1]"
            . " and a.voucherserial not in (select redeemserial from redeemedvouchers) order by voucherserial asc";
    //echo $strSQL;
  $result = pg_exec($conn, $strSQL);
  $numrows = pg_numrows($result);
  
?>

<h3 style="text-align: center">List of Vouchers not yet Redeemed<br /><br />
<?php 
    echo "$facilityname, $periodname"; 
?> 
    </h3>

<table>
<tr style="background-image: url(images/green_bg.png);">  
   <th>Sale Date</th>
   <th>Voucher Serial</th>
   <th>Facility Name</th>
   <th>Patient ID</th>
   <th>First Name</th>
   <th>Surname</th>
   <th>Address</th>
   <th>Tel. No.</th>
   <th>LMP</th>
   <th>EDD</th>
</tr>

<?php

   // Loop on rows in the result set.

   for($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    
        $sql2 = pg_query($conn,"SELECT shortname From vouchertype where usage='".$row["vouchertype"]."'");

        $row3 = pg_fetch_row($sql2);
        $vouchertype = $row3[0];
        $period=$row["periodid"];
        $distributor=$row["distributorno"];
        
        $sql1 = pg_query($conn,"SELECT facilityname From facility where idfacility=$distributor");

        $row2 = pg_fetch_row($sql1);
        $facilityname = $row2[0];
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
    ?>
        <tr>
           <td><?php echo $row["saledate"]; ?> </td>
           <td><?php echo $row["voucherserial"]; ?> </td>
           <td><?php echo $facilityname; ?> </td>
           <td><?php echo $row["nationalid"]; ?> </td>
           <td><?php echo $row["firstname"]; ?> </td>
           <td><?php echo $row["surname"]; ?> </td>
           <td><?php echo $row["location"].', '.$row["village"]; ?> </td>
           <td><nobr><?php echo $row["phone"]; ?> </nobr></td>
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