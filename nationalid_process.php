<?php
    $newnationalid = $_POST['newnationalid'];
    $oldnationalid = $_POST['oldnationalid'];
    $success=0;
    $mobi=$_POST['mobi'];
    
    $query = "UPDATE BENEFICIARYMASTER SET nationalid='$newnationalid' where nationalid='$oldnationalid' or nationalid=lower('$oldnationalid')";  
    
    echo "<br />Updated Beneficiary Master<br />";
    //echo '<br />'.$query.'<br />';
    $result = pg_query($query);
            if (!$result) {
                $errormessage = pg_last_error();
                echo "Error with query: " . $errormessage;
                
                exit();
            }
    
    $query = "UPDATE vouchersales SET nationalid='$newnationalid' where nationalid='$oldnationalid' or nationalid=lower('$oldnationalid')";  
    
    echo "<br />Updated Voucher Sales<br />";
    //echo '<br />'.$query.'<br />';
    $result = pg_query($query);
            if (!$result) {
                $errormessage = pg_last_error();
                echo "Error with query: " . $errormessage;
                exit();
            }
            
    $query = "UPDATE voucherclaims SET patientid='$newnationalid' where patientid='$oldnationalid' or patientid=lower('$oldnationalid')";  
    
    echo "<br />Updated Voucher Claims<br />";
    //echo '<br />'.$query.'<br />';
    $result = pg_query($query);
            if (!$result) {
                $errormessage = pg_last_error();
                echo "Error with query: " . $errormessage;
                exit();
            }  
    $query = "UPDATE redeemedvouchers SET nationalid='$newnationalid' where nationalid='$oldnationalid' or nationalid=lower('$oldnationalid')";  
    
    echo "<br />Updated Redeemed Vouchers<br />";
    //echo '<br />'.$query.'<br />';
    $result = pg_query($query);
            if (!$result) {
                $errormessage = pg_last_error();
                echo "Error with query: " . $errormessage;
                exit();
            }        
    echo "<br /><br > <h2 style='color: green'>Record Updated successfully</h2>";
    
    if($mobi==1){
        echo "<h3><a href='mobi/verifyvoucher.php'>Home</a></h3>";
    }
?>    
