<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
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
    <div align="center">    
    <?php 
        include "../dbconnect.php";  
        
        $nationalid=$_POST['nationalid'];
        $distributor=$_SESSION['facility'];
        $userrole=trim($_SESSION['userrole']);
        
        
        $sql = pg_query($conn,"SELECT * From referrals where nationalid='$nationalid'");
        
        //echo "SELECT * From referrals where nationalid='$nationalid'";
        $count = 0;
       
        while ($row = pg_fetch_row($sql)) {
            $count = $count + 1;
        }

        if($count != 0){
            echo "<br /><br /><font color='red' size='+2'>e-Referral Note for patient with National ID $nationalid was already generated!<br /><br></font> ";
            include "footer.php";
            exit();
            
        }
        
        
        $sql1 = pg_query($conn,"SELECT facilityname From facility where idfacility='$distributor'");

        $row2 = pg_fetch_row($sql1);
        $facilityname = $row2[0];
    
    
      
        $sql = pg_query($conn,"SELECT * From beneficiarymaster where nationalid='$nationalid'");
        

        $count = 0;
        $amount = 0;
        while ($row = pg_fetch_row($sql)) {
            $count = $count + 1;
            $firstname = $row[1];
            $surname = $row[2];
            $dob = $row[6];
            $address = $row[14].', <br />'.$row[16].', <br />'.$row[19];
        }

        if($count==0){
            echo "<div align='center'><br /><br />Beneficiary with National ID <em>" . $nationalid . "</em> does not exist!<br /><a href='verifyvoucher.php'>Try Again</a></div> <br /><br />";
            include "footer.php";
            exit();
            
        }else{
        }
    ?>
    <div align="center">
        <h3>Confirm e-Referral Note Details</h3>
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
                <td><font style="color:#537313">Date of Birth:</font></td><td><?php echo $dob; ?></td>
            </tr>
            <tr>
                <td><font style="color:#537313">Address:</font></td><td><?php echo $address; ?></td>
            </tr>
            <tr>
                <td><font style="color:#537313">Facility:</font></td><td><?php echo $facilityname; ?></td>
            </tr>
            
        </table><br />
    <?php
        
        $sqlStr = "SELECT * From vouchersales where nationalid='$nationalid'";
       //echo $sqlStr.';';
        $sql = pg_query($conn,$sqlStr);

        $count = 0;
        $amount = 0;
        while ($row = pg_fetch_row($sql)) {
            $count = $count + 1;
            $shortname = $row[0];
            $usage = $row[6];
        }
        if($count==0){
            echo "<div align='center'><br /><br /> <em>No Voucher was sold to this client. Referral Note can not be produced!</div>";
            include "footer.php";
            exit();
        }
       /*
        $sqlStr = "SELECT * From vouchertype where usage not in (SELECT vouchertype from REDEEMEDVOUCHERS where nationalid='$nationalid') and usage in (8) order by usage asc";
       //echo $sqlStr.';';
        $sql = pg_query($conn,$sqlStr);

        $count = 0;
        $amount = 0;
        $periodid = 0;
        $period = "";
        while ($row = pg_fetch_row($sql)) {
            $count = $count + 1;
            $shortname = $row[0];
            $usage = $row[6];
        }
        if($count==0){
            
            $sqlStr=pg_query($conn,"SELECT periodid from REDEEMEDVOUCHERS where nationalid='$nationalid' and vouchertype=8");
            $row = pg_fetch_row($sqlStr);
            $periodid = $row[0];
            //echo $periodid."<br />";
            
            $sqlStr=pg_query($conn,"SELECT monthname,yearname from period where monthcode=$periodid");
            $row = pg_fetch_row($sqlStr);
            $period = $row[0]." ".$row[1];
            //echo $period."<br />";
            
            echo "<div align='center'><br /><br /> <em>Ambulance Voucher already used for this person for Period <font color='red'>$period</font>. Referral Note can not be produced!</div>";
            include "footer.php";
            exit();
        }else{
        
        */
        
            //Harare Clinics - 12,13,20,21,22
            //Harare Central - 14
            //Harare Ambulance - 15
            //Netstar Harare - 16
            //------------------------------------
            //Bulawayo Clinic - 6,7,8,9,10,11
            //Bulawayo Ambulance - 19
            //Netstar Bulawayo - 17
            //Mpilo - 18
     ?>
        <form action="referral_process.php" method="POST">   
            <input type="hidden" name="distributor" value="<?php echo $distributor; ?>">
            <input type="hidden" name="nationalid" value="<?php echo $nationalid; ?>">
                <table border="0">
                    <tr>
                        <td>Referral Reason: </td><td><textarea rows="4" cols="25" name="reason" required></textarea></td>
                    </tr>
                    <tr>
                        <td>Transferring Ambulance: </td>
                        <td>
                            <select name="ambulance" required>
                                <option value="">---Select Ambulance---</option>
                                <?php 
                                if(in_array($distributor, array(12,13,20,21,22))){
                                ?>
                                <option value="15">Harare City Ambulance</option>
                                <option value="16">Netstar Harare</option>
                                <option value="0">Own Transport</option>
                                <?php
                                }
                                if(in_array($distributor, array(6,7,8,9,10,11))){
                                ?>
                                <option value="19">Bulawayo City Ambulance</option>
                                <option value="17">Netstar Bulawayo</option>
                                <option value="0">Own Transport</option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Referring to: </td>
                        <td>
                            <?php 
                                if(in_array($distributor, array(12,13,20,21,22))){
                                   echo "<em>Harare Central Hospital</em>";
                                   $refer_to=14;
                                }
                                if(in_array($distributor, array(6,7,8,9,10,11))){
                                    echo "<em>Mpilo Central Hospital</em>";
                                    $refer_to=18;
                                }
                                ?>
                            <input type="hidden" name="refer_to" value="<?php echo $refer_to; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><div align="center"><input type="submit" value="Generate Referral Note"></div></td>
                    </tr>
                    
                </table>
        </form>  
    <?php
       // }
    ?>

    <br /><br /> <?php include "footer.php"; ?>
  </div>
 </body>
</html>