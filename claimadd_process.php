<?php
include_once 'dbconnect.php';

$vouchertype=$_POST['vouchertype'];
$distributor=$_POST['distributor'];
$periodid=$_POST['periodid'];
$voucherserial=trim($_POST['voucherserial']);
$claimserial=$_POST['claimserial'];
$nationalid=$_POST['nationalid'];
$dob=$_POST['dob'];
$lmp=$_POST['lmp'];
$sex="F";
$guardian=$_POST['guardian'];
$maritalstatus=$_POST['maritalstatus'];
$parity=$_POST['parity'];
$location=$_POST['location'];
$village=$_POST['village'];
$postaladdress=$_POST['postaladdress'];
$attendant=$_POST['attendant'];
$profession=$_POST['profession'];
$serviceoffered=$_POST['serviceoffered'];
$requiredfollowup=$_POST['requiredfollowup'];
$servicecharged=$_POST['servicecharged'];
$comments=$_POST['comments'];
$claimdate=$_POST['claimdate'];

$strSQL = "SELECT * from redeemedvouchers where redeemserial='$voucherserial' and vouchertype=$vouchertype";
//echo $strSQL.'<br />';

if(strlen($claimserial)==0){
    $claimserial='0';
}
$result = pg_exec($conn, $strSQL);
$numrows = pg_numrows($result);

if($numrows==1){
        //$action=$_POST['action'];
        $result = pg_query($conn, "select price from vouchertype where usage=$vouchertype");
        $amount = pg_fetch_result($result, 0, 0);

        $query = "UPDATE BENEFICIARYMASTER SET dob='$dob', lmp='$lmp', guardian='$guardian',maritalstatus='$maritalstatus',parity='$parity',location='$location',village='$village',postaladdress='$postaladdress'"
                . " where nationalid='$nationalid'";  
        //echo "<br />" . $query . "<br />";

        $result = pg_query($query);
                if (!$result) {
                    $errormessage = pg_last_error();
                    echo "Error with query: " . $errormessage;
                    exit();
                }
                
        $username = $_SESSION['username'];
        $query = "INSERT INTO voucherclaims(vouchertype,voucherserial,claimserial,distributorno,patientid,serviceoffered,requiredfollowup,servicecharged,amount,remarks,claimdate,approval,attendant,profession,periodid,paymentdate,addedby)" 
                . "VALUES ($vouchertype,'$voucherserial',$claimserial,$distributor,'$nationalid','$serviceoffered','$requiredfollowup','$servicecharged',$amount,'$comments','$claimdate','yes','$attendant','$profession',$periodid,'','$username')";  
        //echo "<br />" . $query . "<br />";

        $result = pg_query($query);
                if (!$result) {
                    $errormessage = pg_last_error();
                    echo "Error with query: " . $errormessage;
                    exit();
                }

                $query = "UPDATE redeemedvouchers set claimed='Y' where redeemserial='$voucherserial' and vouchertype=$vouchertype and nationalid='$nationalid'";  

                $result = pg_query($query);
                        if (!$result) {
                            $errormessage = pg_last_error();
                            echo "Error with query: " . $errormessage;
                            exit();
                        }
                pg_close(); 
                echo "<h3>Claim added successfully</h3>";
                
                ?>
            <script>
                window.location = "vouchers_redeemed.php?period=<?php echo $periodid; ?>&distributor=<?php echo $distributor; ?>";
            </script>
                
<?php   
}else{
    ?>
    <h4>Voucher can not be claimed because of Error with Redeeming.<br /><a href="vouchers_redeemed.php?period=<?php echo $periodid; ?>&distributor=<?php echo $distributor; ?>"> Return to List</a><br /> <a href="trackvouchers_form.php">Track another Voucher</a></h4>
<?php
    }
pg_close(); 
?>

