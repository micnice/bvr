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
    <body>
    <?php 
include 'dbconnect.php';

$vserial=0;

if(isset($_POST['voucherserial']) || !empty($_POST['voucherserial'])){
    $voucherserial = $_POST['voucherserial'];
    $vserial=1;
}

if($vserial==1){
    $strRedeem = "SELECT redeemserial,nationalid,facilityname,shortname,claimed,claimserial,periodid,distributorno,usage,idredeemedvouchers,finalredeem"
          . " From redeemedvouchers,facility, vouchertype  where distributorno=idfacility and usage=vouchertype"
        . " and redeemserial='$voucherserial'";
}
  
  $resultRedeem = pg_exec($conn, $strRedeem);
  
  $numrowsRedeem = pg_numrows($resultRedeem);
  
 //echo $strRedeem;
?>

<h3 style="text-align: center">Track Vouchers</h3>

<div align="center">
    <form action="trackvouchers.php" method="POST">
        Search by Voucher Serial: <input type="text" name="voucherserial" size="15">
        <input type="hidden" name="period" value="<?php echo $period; ?>">
        <input type="hidden" name="distributor" value="<?php echo $distributor; ?>">
        <input type="submit" value="Search">
    </form>
</div>
<table>
<tr style="background-image: url(images/green_bg.png);">  
   <th>Voucher Serial</th>
   <th>Voucher Type</th>
   <th>Period</th>
   <th>Ref Number</th>
   <th>Facility</th>
   <th>National ID</th>
   <th>First name</th>
   <th>Surname</th>
   <th>Redeemed</th>
   <th>Claimed</th>
   <th>Approval</th>
</tr>

<?php
   // Loop on rows in the result set.
for($i = 0; $i < $numrowsRedeem; $i++) {  
    
    $redeemserial=pg_fetch_result($resultRedeem, $i, 0);
    $nationalid=pg_fetch_result($resultRedeem, $i, 1);
    $facilityname=pg_fetch_result($resultRedeem, $i, 2);
    $shortname=pg_fetch_result($resultRedeem, $i, 3);
    $claimed=trim(pg_fetch_result($resultRedeem, $i, 4));
    $claimserial=trim(pg_fetch_result($resultRedeem, $i, 5));
    $period=trim(pg_fetch_result($resultRedeem, $i, 6));
    $distributor=trim(pg_fetch_result($resultRedeem, $i, 7));
    $vouchertype=trim(pg_fetch_result($resultRedeem, $i, 8));
    $idredeemedvouchers=trim(pg_fetch_result($resultRedeem, $i, 9));
    $finalredeem=pg_fetch_result($resultRedeem, $i, 10);
    //echo $finalredeem;
   
    $strSQL = "SELECT approval,ref From voucherclaims where vouchertype=$vouchertype and voucherserial='$redeemserial'";
    //echo $strSQL.'<br />';
    $result = pg_exec($conn, $strSQL);
    $numrows = pg_numrows($result);
    $ref=trim(pg_fetch_result($result,0,1));
    if($numrows>=0){
        $approval=trim(pg_fetch_result($result, 0, 0));
    }else{
        $approval="Pending Claim";
    }
    
    $strBeneficiary = "SELECT firstname,surname"
                    . " From beneficiarymaster where nationalid='$nationalid'";
    
    $resultBeneficiary = pg_exec($conn, $strBeneficiary);
    $firstname1=pg_fetch_result($resultBeneficiary, 0, 0);
    $surname1=pg_fetch_result($resultBeneficiary, 0, 1);
    
    $strPeriod = "SELECT monthname,yearname"
                    . " From period where monthcode=$period";
    //echo $strPeriod.'<br />';
    $resultPeriod = pg_exec($conn, $strPeriod);
    $monthname=pg_fetch_result($resultPeriod, 0, 0);
    $yearname=pg_fetch_result($resultPeriod, 0, 1);
    //echo $firstname1.' '.$surname1.'<br />';
    ?>
        <tr>
            <td><a href="editRedeem.php&redeemserial=<?php echo $redeemserial; ?>&vouchertype=<?php echo $vouchertype; ?>"><?php echo $redeemserial; ?></a> </td>
           <td><?php echo $shortname.' ('.$vouchertype.')'; ?> </td>
           <td><?php echo $monthname.' '.$yearname; ?> </td>
           <td><?php echo $ref; ?> </td>
           <td><?php echo $facilityname; ?> </td>
           <td><?php echo $nationalid; ?> </td>
           <td><?php echo $firstname1; ?> </td>
           <td><?php echo $surname1; ?> </td>
           <td>
               <?php 
                    if($finalredeem==1){
                        echo "Yes";
                    }else{
                        echo "Partially Redeemed";
                    }
               ?> 
           
           </td>
           <td>
               <?php 
                    $checkclaim=0;
                    if(strcmp($claimed, 'Y')==0){
                        echo "Yes";
                        $checkclaim=1;
                    }else{
                        if($finalredeem==1){
                        $checkclaim=0;
                ?>
                    <form action="claimadd.php" method="POST">

                    <input type="hidden" name="nationalid" value="<?php echo $nationalid; ?>">
                    <input type="hidden" name="redeemserial" value="<?php echo $redeemserial; ?>">
                    <input type="hidden" name="claimserial" value="<?php echo $claimserial; ?>">
                    <input type="hidden" name="vouchertype" value="<?php echo $vouchertype; ?>">
                    <input type="hidden" name="period" value="<?php echo $period; ?>">
                    <input type="hidden" name="distributor" value="<?php echo $distributor; ?>">
                    <input type="submit" value="Add Claim">
                    </form>

                   <form action="revokevoucher_confirm.php" method="POST">
                    <input type="hidden" name="idredeemedvoucher" value="<?php echo $idredeemedvouchers; ?>">
                    <input type="hidden" name="shortname" value="<?php echo $shortname; ?>">
                    <input type="hidden" name="nationalid" value="<?php echo $nationalid; ?>">
                    <input type="hidden" name="redeemserial" value="<?php echo $redeemserial; ?>">
                    <input type="hidden" name="vouchertype" value="<?php echo $vouchertype; ?>">
                    <input type="hidden" name="name" value="<?php echo $firstname.' '.$surname; ?>">
                    <input type="submit" value="Revoke">
                    </form> 
               <?php
                     }else{
                        echo "No Yet Claimed<br />";
                     }
                    }
               ?> 
           
           </td>
           <td>
               <?php 
                    //echo $approval;
                    if(strcmp($approval, 'yes')==0){
                        echo "Approved";
                    }elseif(strcmp($approval, 'no')==0){
                        echo "Rejected";
                    }elseif(strcmp($approval, 'rev')==0){
                        echo "Reversed";
                    }elseif($checkclaim==0){
                        echo "";
                    }elseif($checkclaim==1){
                        echo "Pending Approval<br />";
                    ?>
               <form action="claimsapprove.php" method="POST">
                   <input type="hidden" name="voucherserial" value="<?php echo $redeemserial; ?>">
                   <input type="hidden" name="period" value="<?php echo $period; ?>">
                   <input type="hidden" name="distributor" value="<?php echo $distributor; ?>">
                   <input type="submit" value="Approve Now">
               </form>
                    <?php
                    }
               ?> 
           
           </td>
        </tr>
<?php
    }
    if($numrowsRedeem==0){
        echo "<h2>Voucher Serial <em style='color:red'>$voucherserial</em> was not redeemed!";
        
        $strVoucherSales = "SELECT voucherserial,a.nationalid,facilityname,distributorno,firstname,surname"
          . " From vouchersales a,facility b, beneficiarymaster c where a.distributorno=b.idfacility and a.nationalid=c.nationalid"
        . " and voucherserial='$voucherserial'";
        
        //echo $strVoucherSales;
        
        $resultVoucherSales = pg_exec($conn, $strVoucherSales);
  
        $numrowsVoucherSales = pg_numrows($resultVoucherSales);
        
        $salerecord = 0;
        for($i = 0; $i < $numrowsVoucherSales; $i++) {  
            $nationalid=pg_fetch_result($resultVoucherSales, $i, 1);
            $facilityname=pg_fetch_result($resultVoucherSales, $i, 2);
            $firstname=pg_fetch_result($resultVoucherSales, $i, 4);
            $surname=pg_fetch_result($resultVoucherSales, $i, 5);
            
            echo "<br /><br />The Voucher Serial: <em style='color:red'>$voucherserial</em> was sold by: <em style='color:red'>$facilityname</em> to <em style='color:red'>$firstname $surname</em> nationalid: <em style='color:red'>$nationalid</em>";
            $salerecord=1;
        }
        if($salerecord==0){
            echo "<br /><br />No Sale Record Found for Voucher Serial: <em style='color:red'>$voucherserial</em>";
        }
    }
   pg_close($conn);
  ?>
</table>
    </body>
</html>