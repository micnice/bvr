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
include 'dbconnect.php';
//$period=$_POST['period'];

    $strSQL = "select idfacility,facilityname, "
            . "(select count(*) from voucherclaims where vouchertype=1 and distributorno=idfacility and approval='no'), "
            . "(select count(*) from voucherclaims where vouchertype=2 and distributorno=idfacility and approval='no'), "
            . "(select count(*) from voucherclaims where vouchertype=3 and distributorno=idfacility and approval='no'), "
            . "(select count(*) from voucherclaims where vouchertype=4 and distributorno=idfacility and approval='no'), "
            . "(select count(*) from voucherclaims where vouchertype=5 and distributorno=idfacility and approval='no'), "
            . "(select count(*) from voucherclaims where vouchertype=6 and distributorno=idfacility and approval='no'), "
            . "(select count(*) from voucherclaims where vouchertype=7 and distributorno=idfacility and approval='no'), "
            . "(select count(*) from voucherclaims where vouchertype=8 and distributorno=idfacility and approval='no'), "
            . "(select count(*) from voucherclaims where vouchertype=9 and distributorno=idfacility and approval='no'), "
            . "(select count(*) from voucherclaims where vouchertype=10 and distributorno=idfacility and approval='no'), "
            . "(select count(*) from voucherclaims where vouchertype=11 and distributorno=idfacility and approval='no'), "
            . "(select count(*) from voucherclaims where vouchertype=12 and distributorno=idfacility and approval='no') "
            . "from facility where idfacility in (select distributorno from voucherclaims) order by facilityname";

  //echo $strSQL.'<br />';
  
  $result = pg_exec($conn, $strSQL);
  $numrows = pg_numrows($result);
  //echo $numrows;
?>
 
<h3 style="text-align: center">Summary of Rejected Vouchers</h3>

<table>
    <tr style="background-color: #C0C0C0">  
   <td>Facility Name</td>
   <td>1st ANC</td>
   <td>2nd ANC</td>
   <td>3rd ANC</td>
   <td>4th ANC</td>
   <td>Normal Clinic</td>
   <td>Complicated Clinic</td>
   <td>Complicated Hospital</td>
   <td>Ambulance</td>
   <td>Casearean</td>
   <td>PNC  2+ visits</td>
   <td>$10 Token</td>
   <td>$20 Token</td>
</tr>  

<?php
   for($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    ?>
        <tr>
           <td><a href="voucherrejected.php?distributor=<?php echo $row[0]; ?>&facilityname=<?php echo urlencode(trim($row[1])); ?>"><?php echo $row[1]; ?> </a></td>
           <td><?php echo $row[2]; ?> </td>
           <td><?php echo $row[3]; ?> </td>
           <td><?php echo $row[4]; ?> </td>
           <td><?php echo $row[5]; ?> </td>
           <td><?php echo $row[6]; ?> </td>
           <td><?php echo $row[7]; ?> </td>
           <td><?php echo $row[8]; ?> </td>
           <td><?php echo $row[9]; ?> </td>
           <td><?php echo $row[10]; ?> </td>
           <td><?php echo $row[11]; ?> </td>
           <td><?php echo $row[12]; ?> </td>
           <td><?php echo $row[13]; ?> </td>
        </tr>
<?php
  }
   pg_close($conn);
  ?>
</table>
</body>
</html>