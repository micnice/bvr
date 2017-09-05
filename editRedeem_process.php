
<?php 
$nationalid=$_POST['nationalid'];
//$newnationalid=$_POST['newnationalid'];
$ref=$_POST['ref'];
$label=$_POST['label'];
$vouchertype=$_POST['vouchertype'];
$period=$_POST['period'];
$distributor=$_POST['distributor'];
$redeemserial=$_POST['redeemserial'];
$claimserial=$_POST['claimserial'];


    $sql1 = pg_query($conn,"SELECT facilityname From facility where idfacility='$distributor'");

    $row2 = pg_fetch_row($sql1);
    $facilityname = $row2[0];

    $sql2 = pg_query($conn,"SELECT monthname,yearname From period where monthcode=$period");

    $row3 = pg_fetch_row($sql2);
    $periodname = $row3[0].' '.$row3[1];
    
    
$sql = pg_query($conn,"SELECT * From beneficiarymaster where nationalid='$nationalid'");

$count = 0;
$amount = 0;
while ($row = pg_fetch_row($sql)) {
    $count = $count + 1;
    $firstname = $row[1];
    $surname = $row[2];
    //$dob = $row[3];
}

if($count==0){
    die("<div align='center'><br /><br />Beneficiary with National ID <em>" . $nationalid . "</em> does not exist!</div>");
}else{
        }
?>
<div align="left">
<table style="margin:auto 0;">
            <tr>
                <td><font style="color:#537313">ID No/BVR No:</font> </td><td><?php echo $nationalid; ?></td>
            </tr>
            <tr>
                <td><font style="color:#537313"><?php echo str_pad('First Name:',100); ?></font></td><td> <?php echo $firstname; ?></td>
            </tr>
            <tr>
                <td><font style="color:#537313">Surname:</font> </td><td><?php echo $surname; ?></td>
            </tr>
            <tr>
                <td><font style="color:#537313"><?php echo $label; ?> No. :</font></td><td><?php echo $ref; ?></td>
            </tr>
            <tr>
                <td><font style="color:#537313">Facility:</font></td><td><?php echo $facilityname; ?></td>
            </tr>
            <tr>
                <td><font style="color:#537313">Period:</font></td><td><?php echo $periodname; ?></td>
            </tr>
            
        </table>
<?php
    $query = "update redeemedvouchers set periodid=$period,distributorno=$distributor,ref='$ref' where vouchertype=$vouchertype and redeemserial=$redeemserial";
    $result = pg_query($query); 
    //echo $query;
    
    if (!$result) { 
        $errormessage = pg_last_error(); 
        echo "Error with query: " . $errormessage; 
        exit(); 
    } 
    echo "<br />Voucher Redemption Updated Successfully. Voucher Number: <h3 color='red'>$redeemserial</h3> <br /><br />"; 
    ?>
 
    <?php
    pg_close(); 
?>
<br />                                