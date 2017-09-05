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
    $monthcode=$_POST['period'];
    $orgunitid=$_POST['distributor'];
    $serialno=$_POST['serialno'];
    
    if(strcmp($periodid,'000')==0){
        pg_close();
        header("Location: cboscore_form.php");     
    }
    $result = pg_query($conn, "SELECT * FROM FACILITY WHERE idfacility=$orgunitid");
    $result2 = pg_query($conn, "SELECT * FROM PERIOD WHERE monthcode=$monthcode");

    $orgunit = pg_fetch_result($result, 0, 'facilityname');
    $monthname = pg_fetch_result($result2, 0, 'monthname');
    $yearname = pg_fetch_result($result2, 0, 'yearname');
    $period = $monthname.' '.$yearname;
    
    $cbo = pg_query($conn, "SELECT * FROM CBOSCORE WHERE periodid=$monthcode AND facilityid=$orgunitid AND serialno='$serialno'");
            $q1 = 0;
            $q2 = 0;
            $q3 = 0;
            $q4 = 0;
            $q5 = 0;
            $q6 = 0;
            $hours = 0;
            $minutes = 0;
            $comment = '';
            
            $update = 'no';
            
    while ($row = pg_fetch_row($cbo)) {
            $q1 = $row['0'];
            $q2 = $row['1'];
            $q3 = $row['2'];
            $q4 = $row['3'];
            $q5 = $row['4'];
            $q6 = $row['5'];
            $hours = $row['10'];
            $minutes = $row['11'];
            $comment = $row['12'];
            $update = 'yes';
        }
        //echo '<br />'.$hours.' '.$minutes.' '.$comment.'<br />';
        
        if($q1==10){
            $q1a='selected'; $q1b=''; $q1c='';
        }
        if($q1==5){
            $q1a=''; $q1b='selected'; $q1c='';
        }
        if($q1==0){
            $q1a=''; $q1b=''; $q1c='selected';
        }
        
        
        if($q2==5){
            $q2a='selected'; $q2b='';
        }
        if($q2==0){
            $q2a=''; $q2b='selected';
        }
        
        
        if($q3==10){
            $q3a='selected'; $q3b=''; $q3c='';
        }
        if($q3==5){
            $q3a=''; $q3b='selected'; $q3c='';
        }
        if($q3==0){
            $q3a=''; $q3b=''; $q3c='selected';
        }
        
        if($q4==5){
            $q4a='selected'; $q4b='';
        }
        if($q4==0){
            $q4a=''; $q4b='selected';
        }
        
        if($q5==5){
            $q5a='selected'; $q5b='';
        }
        if($q5==0){
            $q5a=''; $q5b='selected';
        }
        
        if($q6==10){
            $q6a='selected'; $q6b=''; $q6c='';
        }
        if($q6==5){
            $q6a=''; $q6b='selected'; $q6c='';
        }
        if($q6==0){
            $q6a=''; $q6b=''; $q6c='selected';
        }
    ?>
    <div align="center"><h3>Health Centre CBO Score</h3>
  
        <form action="cboscore_process.php" method="POST">
<table style="background-color:#E0F277;">
                <tr>
                    <td colspan="4" style="text-align: center; background-color: rgb(255, 255, 102);">
                        <?php echo 'Organisation Unit: <strong>'.$orgunit.'</strong> Period: <strong>'.$period.'</strong>'; ?><br /><br />
                        CBO Questionnaire Serial Number: <strong><?php echo $serialno; ?></strong>
                    </td>
		</tr>
                <tr>
                    <td colspan="4" style="background-image: url(images/green_bg.png);"><strong>CUSTOMER SATISFACTION INDICATORS</strong></td>
		<tr>
			<td></td>
			<td><strong>CBO Component</strong></td>
			<td style="text-align: center;"><strong>Available Points</strong></td>
			<td style="text-align: center;"><strong>Actual Score</strong></td>
		</tr>
		<tr>
			<td>1</td>
			<td>How were you received by the staff at the health facility?</td>
			<td style="text-align: center;">10</td>
			<td>
                            <select name="q1">
                                <option value="" >  </option>
                                <option value="10" <?php echo $q1a; ?>>10 - Friendly</option>
                                <option value="5" <?php echo $q1b; ?>>5 - Normal</option>
                                <option value="0" <?php echo $q1c; ?>>0 - Rude</option>
                            </select></td>
		</tr>
                <tr>
			<td>2</td>
			<td>How long was your waiting time before being helped?</td>
			<td style="text-align: center;"></td>
			<td>
                <nobr>
                    <input type="text" name="hours" size="4" value="<?php echo $hours; ?>" /> Hrs
                    <input type="text" name="minutes" size="4" value="<?php echo $minutes; ?>" /> Mins
                </nobr>
                        </td>
		</tr>
		<tr>
			<td>a</td>
			<td>How do you judge the time that you waited before being helped?</td>
			<td style="text-align: center;">5</td>
			<td>
                            <select name="q2">
                                <option value="" >  </option>
                                <option value="5" <?php echo $q2a; ?>>5 - Reasonable</option>
                                <option value="0" <?php echo $q2b; ?>>0 - Too Long</option>
                            </select>                        
                        </td>
		</tr>
                
		<tr>
			<td>3</td>
			<td>Were the medicines prescribed for you available at the health facility?</td>
			<td style="text-align: center;">10</td>
			<td>
                            <select name="q3">
                                <option value="" >  </option>
                                <option value="10" <?php echo $q3a; ?>>10 - Yes</option>
                                <option value="5" <?php echo $q3b; ?>>5 - Partly</option>
                                <option value="0" <?php echo $q3c; ?>>0 - No</option>
                            </select>                    </td>
		</tr>
		<tr>
			<td>4</td>
			<td>Did you have to pay anything?</td>
			<td style="text-align: center;">5</td>
			<td>
                            <select name="q4">
                                <option value="" >  </option>
                                <option value="0" <?php echo $q4a; ?>>0 - Yes</option>
                                <option value="5" <?php echo $q4b; ?>>5 - No</option>
                            </select></td>
		</tr>
		<tr>
			<td>5</td>
			<td>What do you think about this payment?</td>
			<td style="text-align: center;">5</td>
			<td>
                            <select name="q5">
                                <option value="" >  </option>
                                <option value="5" <?php echo $q5a; ?>>5 - Reasonable</option>
                                <option value="0" <?php echo $q5b; ?>>0 - Unaffordable</option>
                            </select></td>
		</tr>
		<tr>
			<td>6</td>
			<td>Were you satisfied with the services that you were offered?</td>
			<td style="text-align: center;">10</td>
			<td>
                            <select name="q6">
                                <option value="" >  </option>
                                <option value="10" <?php echo $q6a; ?>>10 - Very Satisfied</option>
                                <option value="5" <?php echo $q6b; ?>>5 - Satisfied</option>
                                <option value="0" <?php echo $q6c; ?>>0 - Dissatisfied</option>
                            </select></td>
		</tr>
                <tr>
			<td style="vertical-align:top">7</td>
                        <td style="vertical-align:top">Do you have any comments or suggestions for the improvement of the services?</td>
			<td style="text-align: center;"></td>
			<td>
                            <textarea rows="5" cols="20" name="comment"><?php echo $comment; ?></textarea>
                        </td>
		</tr>
		<tr>
			<td colspan="2" rowspan="1" style="text-align: left;">TOTAL</td>
			<td style="text-align: center; background-color: rgb(204, 204, 204);">45(100%)</td>
			<td style="text-align: center; background-color: rgb(204, 204, 204);">%</td>
		</tr>
                <tr>
                    <td colspan="4" style="text-align: center;">
                        <input type="hidden" name="period" value="<?php echo $monthcode; ?>" />
                        <input type="hidden" name="orgunitid" value="<?php echo $orgunitid; ?>" />
                        <input type="hidden" name="serialno" value="<?php echo $serialno; ?>" />
                        <input type="hidden" name="update" value="<?php echo $update; ?>" />
                        <input type="submit" value="Submit" /></td>
		</tr>
</table>
            
        </form>

        </body>
        </html>