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
    
    <script type="text/javascript">
        function DisplayTotal(){
			var val1 = 0;
			for( i = 0; i < document.form1.price.length; i++ ){
				if( document.form1.price[i].checked == true ){
					val1 = document.form1.price[i].value;
				}
			}

			var val2 = 0;
			for( i = 0; i < document.form2.price2.length; i++ ){
				if( document.form2.price2[i].checked == true ){
					val2 = document.form2.price2[i].value;
				}
			}

			var sum=parseInt(val1) + parseInt(val2);
            document.getElementById('totalSum').value=sum;
        }
    </script>
        
        
    <?php 
    include 'dbconnect.php'; 
    $nationalid=$_POST['nationalid'];

    $assess = pg_query($conn, "SELECT * FROM ASSESSMENT WHERE nationalid='$nationalid'");
            $f112 = 2;
            $f113 = 2;
            $f114 = 2;
            $f115 = 2;
            $f116a = 2;
            $f116b = 2;
            $f117 = 2;
            $f118 = 2;
            $f119 = 2;
            $f120 = 2;
            $f121 = 2;
            
            $f112_0 = '';
            $f113_0 = '';
            $f114_0 = '';
            $f115_0 = '';
            $f116a_0 = '';
            $f116b_0 = '';
            $f117_0 = '';
            $f118_0 = '';
            $f119_0 = '';
            $f120_0 = '';
            $f121_0 = '';
            
            $f112_1 = '';
            $f113_1 = '';
            $f114_1 = '';
            $f115_1 = '';
            $f116a_1 = '';
            $f116b_1 = '';
            $f117_1 = '';
            $f118_1 = '';
            $f119_1 = '';
            $f120_1 = '';
            $f121_1 = '';

            
            $update = 'no';
            
    while ($row = pg_fetch_row($assess)) {
            $f112 = $row['2'];
            $f113 = $row['3'];
            $f114 = $row['4'];
            $f115 = $row['5'];
            $f116a = $row['6'];
            $f116b = $row['7'];
            $f117 = $row['8'];
            $f118 = $row['9'];
            $f119 = $row['10'];
            $f120 = $row['11'];
            $f121 = $row['12'];
            $update = 'yes';
        }
        //echo '<br />'.$hours.' '.$minutes.' '.$comment.'<br />';
        
        if($f112==1){
            $f112_1='checked';
        }
        if($f112==0){
            $f112_0='checked';
        }
        
        if($f113==1){
            $f113_1='checked';
        }
        if($f113==0){
            $f113_0='checked';
        }
        
        if($f114==1){
            $f114_1='checked';
        }
        if($f114==0){
            $f114_0='checked';
        }
        
        if($f115==1){
            $f115_1='checked';
        }
        if($f115==0){
            $f115_0='checked';
        }
        
        if($f116a==1){
            $f116a_1='checked';
        }
        if($f116a==0){
            $f116a_0='checked';
        }
        
        if($f116b==1){
            $f116b_1='checked';
        }
        if($f116b==0){
            $f116b_0='checked';
        }
        if($f117==1){
            $f117_1='checked';
        }
        if($f117==0){
            $f117_0='checked';
        }
        if($f118==1){
            $f118_1='checked';
        }
        if($f118==0){
            $f118_0='checked';
        }
        if($f119==1){
            $f119_1='checked';
        }
        if($f119==0){
            $f119_0='checked';
        }
        if($f120==1){
            $f120_1='checked';
        }
        if($f120==0){
            $f120_0='checked';
        }
        if($f121==1){
            $f121_1='checked';
        }
        if($f121==0){
            $f121_0='checked';
        }
       
    ?>
    <div align="center"><h3>Eligibility Assessment</h3>
  
        <form action="social_assessment_process.php" method="POST">
<table style="background-color:#E0F277;">
                <tr>
                    <td colspan="4" style="text-align: center; background-color: rgb(255, 255, 102);">
                        
                    </td>
		</tr>
                <tr>
                    <td colspan="4" style="background-image: url(images/green_bg.png);"><strong>ASSESSMENT INDICATORS</strong></td>
		<tr>
			<td></td>
			<td><strong>Component</strong></td>
			<td style="text-align: center;"><strong>Available Points</strong></td>
			<td style="text-align: center;"><strong>Actual Score</strong></td>
		</tr>
		<tr>
			<td>F112</td>
			<td>How many regular meals a day (with sadza/rice/potatoes or any other source of starch) the household typically eats?</td>
			<td style="text-align: center;">1</td>
			<td>
                                <input type="radio" name="f112" required value="1" <?php echo $f112_1; ?>>1 - no meal or one meal<br />
                                <input type="radio" name="f112" value="0" <?php echo $f112_0; ?>>0 - two or more meals
                        </td>
		</tr>
                
		<tr>
			<td>F113</td>
			<td>What are the main sources of livelihood of the household?</td>
			<td style="text-align: center;">1</td>
			<td>
                            <input type="radio" name="f113" required value="1" <?php echo $f113_1; ?>>1 - begging or piece work<br />
                            <input type="radio" name="f113" value="0" <?php echo $f113_0; ?>>0 - formal/informal employment
                        </td>
		</tr>
		<tr>
			<td>F114</td>
			<td>What is the average monthly remittances the household received from relatives or others during the last 12 months?</td>
			<td style="text-align: center;">1</td>
			<td>
                            <input type="radio" name="f114" required value="1" <?php echo $f114_1; ?>>1 - less than $50<br />
                            <input type="radio" name="f114" value="0" <?php echo $f114_0; ?>>0 - $50 or more
                        </td>
		</tr>
		<tr>
			<td>F115</td>
			<td>What percentage of your income goes to rent and rates?</td>
			<td style="text-align: center;">1</td>
			<td>
                            <input type="radio" name="f115" required value="1" <?php echo $f115_1; ?>>1 - 75% and above<br />
                            <input type="radio" name="f115" value="0" <?php echo $f115_0; ?>>0 - below 75%
                        </td>
		</tr>
		<tr>
			<td>F116a</td>
			<td>Is your water disconnected?                  </td>
			<td style="text-align: center;">1</td>
			<td>
                            <input type="radio" name="f116a" required value="1" <?php echo $f116a_1; ?>>1 - is disconnected<br />
                            <input type="radio" name="f116a" value="0" <?php echo $f116a_0; ?>>0 - not disconnected
                        </td>
		</tr>
                <tr>
			<td>F116b</td>
			<td>Is your electricity disconnected?                  </td>
			<td style="text-align: center;">1</td>
			<td>
                            <input type="radio" name="f116b" required value="1" <?php echo $f116b_1; ?>>1 - is disconnected<br />
                            <input type="radio" name="f116b" value="0" <?php echo $f116b_0; ?>>0 - not disconnected
                        </td>
		</tr>
                <tr>
			<td>F117</td>
			<td>How many rooms are used for sleeping?</td>
			<td style="text-align: center;">1</td>
			<td>
                            <input type="radio" name="f117" required value="1" <?php echo $f117_1; ?>>1 - two and below<br />
                            <input type="radio" name="f117" value="0" <?php echo $f117_0; ?>>0 - more than two
                        </td>
		</tr>
                <tr>
			<td>F118</td>
			<td>What type of fuel does your household mainly use for cooking?</td>
			<td style="text-align: center;">1</td>
			<td>
                            <input type="radio" name="f118" required value="1" <?php echo $f118_1; ?>>1 - firewood or waste<br />
                            <input type="radio" name="f118" value="0" <?php echo $f118_0; ?>>0 - electricity, coal, gas or paraffin
                        </td>
		</tr>
                <tr>
			<td>F119</td>
			<td>Main  material of the house walls (observe)</td>
			<td style="text-align: center;">1</td>
			<td>
                            <input type="radio" name="f119" required value="1" <?php echo $f119_1; ?>>1 - Natural or rudimentary<br />
                            <input type="radio" name="f119" value="0" <?php echo $f119_0; ?>>0 - Finished wall (brick/ stone with cement/ lime)
                        </td>
		</tr>
                <tr>
			<td>F120</td>
			<td>What is the tenure  status of the household?</td>
			<td style="text-align: center;">1</td>
			<td>
                            <input type="radio" name="f120" required value="1" <?php echo $f120_1; ?>>1 - Rent<br />
                            <input type="radio" name="f120" value="0" <?php echo $f120_0; ?>>0 - Own /tied accommodation/Other
                        </td>
		</tr>
                <tr>
			<td>F121</td>
			<td>Does the household possess any of the following assets: Radio, television, refrigerator, bicycle, motorcycle, car, or truck</td>
			<td style="text-align: center;">1</td>
			<td>
                            <input type="radio" name="f121" required value="1" <?php echo $f121_1; ?>>1 - No<br />
                            <input type="radio" name="f121" value="0" <?php echo $f121_0; ?>>0 - Yes
                        </td>
		</tr>
                
		<tr>
			<td colspan="2" rowspan="1" style="text-align: left;">TOTAL</td>
			<td style="text-align: center; background-color: rgb(204, 204, 204);">11</td>
			<td style="text-align: center; background-color: rgb(204, 204, 204);"></td>
		</tr>
                <tr>
                    <td colspan="4" style="text-align: center;">
                        <input type="hidden" name="nationalid" value="<?php echo $nationalid; ?>" />
                        <input type="hidden" name="update" value="<?php echo $update; ?>" />
                        <input type="submit" value="Submit" /></td>
		</tr>
</table>
            
        </form>
        <?php include "social_nextsale.php"; ?>
 </body>
</html>