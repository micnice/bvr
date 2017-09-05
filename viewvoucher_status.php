<br /><h3 style="text-align: center">View Status of Vouchers</h3>
<?php
    $nationalid = trim($_POST['nationalid']);
    $sqlbeneficiary = pg_query($conn,"select firstname, surname from beneficiarymaster where nationalid='$nationalid'");
    $beneficiary = pg_fetch_row($sqlbeneficiary);
?>
    <table style="margin:auto;">
        <tr>
            <td colspan="7"><em><?php echo $beneficiary[0].' '.$beneficiary[1].', ID Number: '.$nationalid; ?></em></td>
        </tr>
        <tr style="background-image: url(images/green_bg.png);">
            <th>Type</th>
            <th>Voucher Description</th>
            <th>Facility</th>
            <th>Voucher Serial</th>
            <th>Period</th>
            <th colspan="2">Action</th>
        </tr>
    <?php
     $sql = pg_query($conn,"SELECT a.vouchertype,c.shortname,b.facilityname,a.redeemserial,a.idredeemedvouchers,a.claimserial,a.distributorno,a.periodid,a.claimed,d.monthname,d.yearname from REDEEMEDVOUCHERS a,FACILITY b, VOUCHERTYPE c, PERIOD d where "
                            ." a.nationalid='$nationalid' and a.periodid=d.monthcode and a.vouchertype=c.usage and a.distributorno=b.idfacility order by a.vouchertype asc");

        $count = 0;
        $amount = 0;
        while ($row = pg_fetch_row($sql)) {
            $count = $count + 1;
            $usage = $row[0];
            $shortname = $row[1];
            $facilityname = $row[2];
            $voucherserial = $row[3];
            $idredeemedvoucher = $row[4];
            $claimserial = $row[5];
            $distributor = $row[6];
            $period = $row[7];   
            $claimed = trim($row[8]);
            $periodname = $row[9]." ".$row[10];
    ?>
        <tr>
            <td><?php echo $usage; ?></td>
            <td><?php echo $shortname; ?></td>
            <td><?php echo $facilityname; ?></td>
            <td><?php echo $voucherserial; ?></td>
            <td><?php echo $periodname; ?></td>
            <td>
                <?php
                    if(strcmp($claimed, 'Y')==0){
                        echo "<em>Claimed</em>";
                    }else{
                ?>
                <form action="main.php?page=claimadd" method="POST">

                <input type="hidden" name="nationalid" value="<?php echo $nationalid; ?>">
                <input type="hidden" name="redeemserial" value="<?php echo $voucherserial; ?>">
                <input type="hidden" name="claimserial" value="<?php echo $claimserial; ?>">
                <input type="hidden" name="vouchertype" value="<?php echo $usage; ?>">
                <input type="hidden" name="period" value="<?php echo $period; ?>">
                <input type="hidden" name="distributor" value="<?php echo $distributor; ?>">
                <input type="submit" value="Add Claim">
                </form>
                <?php
                    }
                ?>
            </td>
            <td>
                <form action="main.php?page=revokevoucher_confirm" method="POST">
                <input type="hidden" name="idredeemedvoucher" value="<?php echo $idredeemedvoucher; ?>">
                <input type="hidden" name="shortname" value="<?php echo $shortname; ?>">
                <input type="hidden" name="nationalid" value="<?php echo $nationalid; ?>">
                <input type="hidden" name="redeemserial" value="<?php echo $voucherserial; ?>">
                <input type="hidden" name="vouchertype" value="<?php echo $usage; ?>">
                <input type="hidden" name="name" value="<?php echo $beneficiary[0].' '.$beneficiary[1]; ?>">
                <input type="submit" value="Revoke">
                </form>  
                
            </td>
        </tr>
    
    
    <?php
        }
    ?>
    </table>
    <?php
        if($count==0){
            die("<div align='center'><br /><br /> <em>This Voucher Serial has not been redeemed!</div>");
        }else{
        }
    ?>

    <br /><br /> <?php include "footer.php"; ?>