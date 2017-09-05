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
include_once 'dbconnect.php';

$nationalid=trim($_POST['nationalid']);
$redeemserial=trim($_POST['redeemserial']);
$claimserial=$_POST['claimserial'];
$vouchertype=$_POST['vouchertype'];
$distributor=$_POST['distributor'];
$period=trim($_POST['period']);

$vouchershortname="";
$voucherprice="";

$sql = pg_query($conn,"SELECT nationalid,firstname,surname,dob,sex,lmp,edd,guardian,maritalstatus,parity,location,village,postaladdress FROM beneficiarymaster where nationalid='$nationalid'");

$count = 0;
$amount = 0;
while ($row = pg_fetch_row($sql)) {
    $count = $count + 1;
    $firstname = $row[1];
    $surname = $row[2];
    $dob = $row[3];
    $sex = $row[4];
    $lmp = $row[5];
    $edd = $row[6];
    $guardian = $row[7];
    $maritalstatus = $row[8];
    $parity = $row[9];
    $location = $row[10];
    $village = $row[11];
    $postaladdress = $row[12];
}

if($count==0){
    die("<div align='center'><br /><br />Beneficiary with National ID <em>" . $nationalid . "</em> does not exist! <br /><br /><a href='claimadd_form.php'>Try again!</a></div>");
}else{
?>
    
    <form method="POST" action="claimadd_process.php" name="claimAdd">
    <div align="center"><h3>Enter Claims</h3><br /><table  style="background-color: #E0F277;">
        <tr>
            <td><font size="4">Patient National ID:</font></td>
            <td colspan="3"><?php echo "<font color='red'>$nationalid</font> <em>($firstname $surname)</em>"; ?><input type="hidden" name="nationalid" id="nationalid" value="<?php echo $nationalid; ?>">
            <a href="main.php?page=nationalid_edit&nationalid=<?php echo trim($nationalid); ?>">Edit</a></td>
        </tr>
        <tr>
            <td><font size="4">Voucher Type / Price</font></td>
            <td>
                <select name="vouchertype" id="vouchertype" required>
                <?php
                $sql = pg_query($conn,"SELECT usage,shortname,price FROM vouchertype where usage=$vouchertype");
                $count2=0;
                while ($row = pg_fetch_assoc($sql)) {
                    $vouchershortname=$row['shortname'];
                    $voucherprice=$row['price'];
                echo '<option value="'.htmlspecialchars($row['usage']).'">'.htmlspecialchars($row['shortname']).' ..... ( $'.htmlspecialchars($row['price']).' )</option>';
                $count2 = $count2 + 1;
                }
                ?>
                </select>   
                <?php
                    if($count2==0){
                        echo "<font color='red'>No voucher was redeemed for this patient!</font>";
                    }
                ?>
            </td>
            <td><font size="4">Reasons:</font></td>
            <td id="reasons"><?php 
                $voucherReasons = array(6,7,8,9);
                
                if(in_array($vouchertype,$voucherReasons))
                { ?>
                <select name="reason" id="reason" required>
                    <option value="">---Select Reason---</option>
                <?php
                $sql = pg_query($conn,"SELECT idreason,shortname FROM reasons order by shortname");
                while ($row = pg_fetch_assoc($sql)) {
                echo '<option value="'.htmlspecialchars($row['idreason']).'">'.htmlspecialchars($row['shortname']).'</option>';}
                ?>  
                </select> 
                <input name="other" value="yes" type="checkbox" onclick="enable_other(this.checked)">
            <?php } ?>
            </td>
        </tr>
            <tr>
            <td><font size="4">Distributor Name</font></td>
            <td><select name="distributor" id="distributor">
                <?php
                $sql = pg_query($conn,"SELECT idfacility,facilityname FROM facility where idfacility=$distributor");
                
                while ($row = pg_fetch_assoc($sql)) {
                echo '<option value="'.htmlspecialchars($row['idfacility']).'">'.htmlspecialchars($row['facilityname']).'</option>';}
                //pg_close($conn);
                ?>
                </select> 
            </td>
            <td>Voucher Serial:<br /><input type="number" size="6" maxlength="10" name="voucherserial" value="<?php echo $redeemserial; ?>" required></td>
            <td>Claim Form Serial:<br /><input type="number" size="6" maxlength="10" name="claimserial" value="<?php echo $claimserial; ?>"></td>        
        </tr>
        <tr>
            <td><font size="4">Period</font></td>
            <td><select name="periodid">
                <?php
                include 'dbconnect.php';
                $sql = pg_query($conn,"SELECT monthcode,monthname,yearname FROM period where monthcode='$period'");
                while ($row = pg_fetch_assoc($sql)) {
                echo '<option value="'.htmlspecialchars($row['monthcode']).'">'.htmlspecialchars($row['monthname'])." ".htmlspecialchars($row['yearname']).'</option>';}
                //pg_close($conn);
                ?>
                </select>  </td>
            <td><font size="4">Claim Date</font></td>
            <td><input type="text" name="claimdate" value="<?php echo date('d/m/Y'); ?>" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" placeholder="d/m/Y" required> </td>
        </tr>
        <tr class="lime">
            <td><font size="4">Surname</font></td>
            <td><input type="text" size="30" maxlength="50" name="surname" value="<?php echo trim($surname); ?>" required></td>
            <td><font size="4">Other Names</font></td>
            <td><input type="text" size="40" maxlength="40" name="firstname" value="<?php echo trim($firstname); ?>" required> </td>
        </tr>
        <tr class="lime">
            <td><font size="4">DOB:</font><input type="text" size="11" maxlength="11" name="dob" id="dob" value="<?php echo trim($dob); ?>" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" placeholder="dd/mm/yyyy" onblur="getAge()">, 
                Age:<input type="text" id="age" value="" size="6" onblur="getDob()"><input id="checkage" type="checkbox" onclick="enableAge()"></td>
            <td><font size="4">Sex:</font> 
            <select name="period">
                    <option value="F">Female</option>
                </select>
            </td>
            <td><font size="4">LMP:</font><input type="text" size="11" maxlength="11" name="lmp" value="<?php echo trim($lmp); ?>" id="lmp" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" placeholder="dd/mm/yyyy" onblur="getEdd()"></td>
            <td><font size="4">EDD:</font> <input type="hidden" size="11" maxlength="11" value="" name="edd" id='edd' pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" placeholder="dd/mm/yyyy"><span id="displayedd"><?php echo trim($edd); ?></span></td>
        </tr>
        <tr class="lime">
            <td><font size="4">Guardian's Name for Minor Patients:</font></td>
            <td><input type="text" size="30" maxlength="50" value="<?php echo $guardian; ?>" name="guardian"></td>
            <td><font size="4">Marital Status:</font></td>
            <td><input type="text" size="40" maxlength="40" value="<?php echo $maritalstatus; ?>" name="maritalstatus"> </td>
        </tr>
        <tr class="lime">
            <td><font size="4">Parity:</font></td>
            <td colspan="3"><input type="text" size="30" maxlength="50" value="<?php echo $parity; ?>" name="parity"></td>
        </tr>
        <tr class="lime">
            <td><font size="4">Location:</font></td>
            <td><input type="text" size="30" maxlength="50" value="<?php echo $location; ?>" name="location"></td>
            <td><font size="4">Village:</font></td>
            <td><input type="text" size="40" maxlength="40" value="<?php echo $village; ?>" name="village"> </td>
        </tr>
        <tr class="lime">
            <td><font size="4">Postal Address:</font></td>
            <td colspan="3"><input type="text" size="50" maxlength="50" value="<?php echo $postaladdress; ?>" name="postaladdress"></td>
            
        </tr>
        <tr>
            <td><font size="4">Attendant's Name:</font></td>
            <td><input type="text" size="30" maxlength="50" value="" name="attendant"></td>
            <td><font size="4">Profession:</font></td>
            <td><input type="text" size="40" maxlength="40" value="" name="profession"> </td>
        </tr>
        <tr>
            <td><font size="4">Service Offered</font></td>
            <td> <textarea rows="3" cols="30" value="<?php echo $vouchershortname; ?>" name="serviceoffered"><?php echo $vouchershortname; ?></textarea>
            </td>
            <td><font size="4">Required Follow Up</font></td>
            <td> <textarea rows="3" cols="30" value="" name="requiredfollowup"></textarea> 
            </td>
        </tr>
        <tr>
            <td><font size="4">Service Charged</font></td>
            <td> <textarea rows="3" cols="30" value="<?php echo $voucherprice; ?>" name="servicecharged"><?php echo $voucherprice; ?></textarea> 
            </td>
            <td><font size="4">Comments</font></td>
            <td> <textarea rows="3" cols="30" value="" name="comments"></textarea> 
            </td>
        </tr>        
    </table>
    </div><p align="center">
    <input type="submit" value="Submit Claim" /></p> </p>
    <p>&nbsp;</p>
</form>

<?php
}
pg_close($conn);
?>
<script id="OtherBlock" language="text">
    <input type="text" name="reason">
</script>

<div id="targetElement" class="red"></div>
<script>
    
    function enable_other(status)
    {	
    document.getElementById("reasons").innerHTML=document.getElementById("OtherBlock").innerHTML
    }
</script>

<script type="text/javascript">
$(document).ready(function () {
    $('#saleate').datepicker();
    $('#dob').datepicker();
    $('#lmp').datepicker();
    $('#edd').datepicker();
});

function getEdd() {
    var tt = document.getElementById('lmp').value;
    if(tt.length===10){
        var parts = tt.split("/");

        var date = new Date(parts[2],parts[1],parts[0]);
        var newdate = new Date(date);

        newdate.setDate(newdate.getDate() + 280);

        var dd = ("0" + newdate.getDate()).slice(-2);
        var mm = ("0"+ (newdate.getMonth() + 1)).slice(-2);
        var y = newdate.getFullYear();

        var someFormattedDate = dd + '/' + mm + '/' + y;
        document.getElementById('edd').value = someFormattedDate;
        document.getElementById('displayedd').innerHTML = someFormattedDate;
    }
}

function getDob() {
    var age = document.getElementById('age').value;
    
    if(age>12 && age<55){
        age = age*365;
        var date = new Date('<?php echo date('Y-m-d'); ?>');
        var newdate = new Date(date);

        newdate.setDate(newdate.getDate() - age);

        var dd = ("0" + newdate.getDate()).slice(-2);
        var mm = ("0"+ (newdate.getMonth() + 1)).slice(-2);
        var y = newdate.getFullYear();

        var someFormattedDate = dd + '/' + mm + '/' + y;
        document.getElementById('dob').value = someFormattedDate;
    }
}


function getAge() {
    var dob = document.getElementById('dob').value;
    if(dob.length===10){
        var date = new Date('<?php echo date('Y-m-d'); ?>');
        var newdate = new Date(date);

        var parts = dob.split("/");

        var date2 = new Date(parts[2],parts[1],parts[0]);
        var newdate2 = new Date(date2);

        var age = (date-date2)/(60 * 60 * 24 * 1000 * 365);

        //document.writeln(age);
        document.getElementById('age').value = Math.floor(age);
        document.getElementById('age').disabled = true;
    }
}

function enableAge(){
    document.getElementById('age').disabled = false;
    document.getElementById('age').value = "";
}
</script>

</body>
</html>