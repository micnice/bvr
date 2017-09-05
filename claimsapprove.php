    
<?php 
include 'dbconnect.php';
$distributor = $_POST['distributor'];
$period = $_POST['period'];
$vserial=0;

if(isset($_POST['voucherserial']) || !empty($_POST['voucherserial'])){
    $voucherserial = $_POST['voucherserial'];
    $vserial=1;
}

if($vserial==1){
    $strSQL = "SELECT idvoucherclaims,claimdate,voucherserial,patientid,serviceoffered,amount,facilityname,shortname"
          . " From voucherclaims a,facility b, vouchertype c where (a.approval is null or a.approval='rev') and a.distributorno=b.idfacility "
        . "and c.usage=a.vouchertype and a.voucherserial=$voucherserial order by voucherserial asc";
}else{
    $strSQL = "SELECT idvoucherclaims,claimdate,voucherserial,patientid,serviceoffered,amount,facilityname,shortname"
          . " From voucherclaims a,facility b, vouchertype c where (a.approval is null or a.approval='rev') and a.distributorno=b.idfacility "
        . "and c.usage=a.vouchertype and b.idfacility=$distributor and a.periodid=$period order by voucherserial asc";
}


  $result = pg_exec($conn, $strSQL);
  $numrows = pg_numrows($result);
?>

<h3 style="text-align: center">Claims Awaiting Approval</h3>

<div align="center">
    <form action="main.php?page=claimsapprove" method="POST">
        Search by Voucher Serial: <input type="text" name="voucherserial" size="15">
        <input type="hidden" name="period" value="<?php echo $period; ?>">
        <input type="hidden" name="distributor" value="<?php echo $distributor; ?>">
        <input type="submit" value="Search">
    </form>
</div>
<table>
<tr style="background-image: url(images/green_bg.png);">  
   <th>Claim Date</th>
   <th>Voucher Serial</th>
   <th>Voucher Type</th>
   <th>Facility</th>
   <th>Patient ID</th>
   <th>Service Offered</th>
   <th>Amount</th>
   <th>Action</th>
</tr>

<?php

   // Loop on rows in the result set.

   for($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    ?>
        <tr>
           <td><?php echo $row["claimdate"]; ?> </td>
           <td><?php echo $row["voucherserial"]; ?> </td>
           <td><?php echo $row["serviceoffered"]; ?> </td>
           <td><?php echo $row["facilityname"]; ?> </td>
           <td><?php echo $row["patientid"]; ?> </td>
           <td><?php echo $row["serviceoffered"]; ?> </td>
           <td><?php echo $row["amount"]; ?> </td>
           <td><a href="main.php?page=claimsapprove_process&dest=approve&approve=yes&id=<?php echo $row['idvoucherclaims'] ?>&distributor=<?php echo $distributor ?>&period=<?php echo $period ?>">Approve</a> | 
               <a href="main.php?page=claimsapprove_process&dest=approve&approve=no&id=<?php echo $row['idvoucherclaims'] ?>&distributor=<?php echo $distributor ?>&period=<?php echo $period ?>">Reject</a> </td>
        </tr>
<?php
  }
   pg_close($conn);
  ?>
</table>

