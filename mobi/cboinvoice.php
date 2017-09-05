<?php 
    $tablewidth="800px";
    if(isset($_POST['print'])){
        if(strcmp($_POST['print'], 'print')==0){
            $tablewidth="1000px";
      ?>
<html lang="en"><head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">

        <meta charset="utf-8">
        <title>Beneficiary Voucher Repository (BVR)</title>

        <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
        
            <style type="text/css">
                table{
                    border: 1px solid black;border-collapse:collapse;
                }
                td,th{
                    border: 1px solid #98bf21;  
                }
            
            </style>
        <meta name="robots" content="noindex,follow">

    </head>
    <body>
          
<?php           
    } 
  }
include 'dbconnect.php';

$distributor = $_POST['distributor'];
$period = $_POST['period'];

if(strcmp($period, 'q1')==0){
    $quarter = '1,2,3';
    $periodname = 'Q1 2015';
    $qualitymonth=3;
}
if(strcmp($period, 'q2')==0){
    $quarter = '4,5,6';
    $periodname = 'Q2 2015';
    $qualitymonth=6;
}
if(strcmp($period, 'q3')==0){
    $quarter = '7,8,9';
    $periodname = 'Q3 2015';
    $qualitymonth=9;
}
if(strcmp($period, 'q4')==0){
    $quarter = '10,11,12';
    $periodname = 'Q4 2015';
    $qualitymonth=12;
}

    $result = pg_query($conn, "SELECT * FROM FACILITY WHERE idfacility=$distributor");
    $orgunit = pg_fetch_result($result, 0, 'facilityname');
    $cbo = pg_fetch_result($result, 0, 'cboname');
    $category = pg_fetch_result($result, 0, 'category');

    
    $strSQL = "select facilityname,monthname,yearname,a.periodid,count(*) qnumber,sum(q1+q2+q3+q4+q5+q6) score, min(serialno) minserial, max(serialno) maxserial from cboscore a,period b,facility c "
            . " where facilityid=$distributor and facilityid=idfacility and a.periodid=b.monthcode and a.periodid in ($quarter) group by facilityname,monthname,yearname,a.periodid order by a.periodid asc";

    $result2 = pg_exec($conn, $strSQL);
    $numrows = pg_numrows($result2);
    $row1 = pg_fetch_array($result2, 0);
    $row2 = pg_fetch_array($result2, 1);
    $row3 = pg_fetch_array($result2, 2);
    $total1 = 0;
    $total2 = 0;
  //echo $strSQL;

?>

<br /><br />
<table width="<?php echo $tablewidth; ?>">

<tr>  
    <td colspan="8">
        
        <h1>Zimbabwe e-Voucher for Health Programme</h1>
        <h2>CBO Quarterly Invoice</h2>
        <style type="text/css">
            .table {
                display: table;
            }

            .row {
                display: table-row;
            }

            .column {
                display: table-cell;
                vertical-align: top;
            }
        </style>
    
        <div class="table">
            <div class="row">
                <div class="column"><h3>Period:</h3></div><div class="column"><h3><u><?php echo $periodname; ?></u></h3></div>
            </div>
            <div class="row">
                <div class="column"><h3>CBO:</h3></div><div class="column"><h3><u><?php echo $cbo; ?></u></h3></div>
            </div>
            <div class="row">
                <div class="column"><h3>Facility:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3></div><div class="column"><h3><u><?php echo $orgunit; ?></u></h3></div>
            </div>
        </div>
    </td>   
</tr>

<tr style="background-image: url(images/green_bg.png); vertical-align: top;">  
    <th rowspan="2">Indicator</th>
   <th rowspan="2">Price</th>
   <th rowspan="2">Forms<br />Submitted</th>
   <th rowspan="2">Forms<br />Answered</th>
   <th colspan="3">Questionnaire Serial Numbers</th>
   <th rowspan="2">Total Earned</th>
</tr>
<tr style="background-color:#D0D0D0">  
    <td><?php echo $row1["monthname"]; ?></td>
    <td><?php echo $row2["monthname"]; ?></td>
    <td><?php echo $row3["monthname"]; ?></td>
</tr>
<tr>  
    <td>Number of completed<br /> questionnaires</td>
   <td style="text-align:right;">$4.50</td>
   <td style="text-align:right;">75</td>
   <td style="text-align:right;"><?php echo $row1["qnumber"]+$row2["qnumber"]+$row3["qnumber"]; ?></td>
   <td rowspan="2"><?php echo $row1["minserial"].' - '.$row1["maxserial"]; ?></td>
   <td rowspan="2"><?php echo $row2["minserial"].' - '.$row2["maxserial"]; ?></td>
   <td rowspan="2"><?php echo $row3["minserial"].' - '.$row3["maxserial"]; ?></td>
   <td style="text-align:right;">$<?php echo number_format(75*4.5,2,'.',','); $total1 = 75*4.5;?></td>
</tr>
<tr>  
    <td>Number of completed <br />questionnaires submitted<br />timely</td>
   <td style="text-align:right;">$0.50</td>
   <td style="text-align:right;">75</td>
   <td style="text-align:right;"><?php echo $row1["qnumber"]+$row2["qnumber"]+$row3["qnumber"]; ?></td>
   <td style="text-align:right;">$<?php echo number_format(75*0.5,2,'.',','); $total2 = 75*0.5;?></td>
</tr>

<tr style="background-color:#D0D0D0">
      <td style="text-align:right;" colspan="7"><b>Grand Total Earned:</b></td>
      <td style="text-align:right;"><b>$<?php echo number_format($total1+$total2,2,'.',',');?></b></td>
  </tr>
</table>

<br />   
<?php 
    if(isset($_POST['print'])){
        if(strcmp($_POST['print'], 'print')==0){
      ?>
    <br /><br />
    <table width="1000px" style="border:0px">
    <tr>
        <td width="100px">Compiled By:</td>
        <td width="200px"></td>
        <td width="50px" rowspan="3" style="border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;"></td>
        <td width="100px">Checked By:</td>
        <td width="200px"></td>
        <td width="50px" rowspan="3" style="border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;"></td>
        <td width="100px">Passed for <br />Payment By:</td>
        <td width="200px"></td>
    </tr>
    <tr>
        <td width="100px">Signature:<br /></td>
        <td width="200px"></td>
        <td width="100px">Signature:<br /></td>
        <td width="200px"></td>
        <td width="100px">Signature:<br /></td>
        <td width="200px"></td>
    </tr>
    <tr>
        <td width="100px">Date:</td>
        <td width="200px"></td>
        <td width="100px">Date:</td>
        <td width="200px"></td>
        <td width="100px">Date:</td>
        <td width="200px"></td>
    </tr>
</table> <br /><br />
            <div align="center">
                <em>Printed On: <?php echo date('l jS \of F Y h:i:s A'); ?></em>
            </div>
</body>
</html>
     <?php           
        }
    }else{
?>
<div align="center">
    <form action="cboinvoice.php" method="POST" target="Print">
        <input type="hidden" value="<?php echo $distributor; ?>" name="distributor">
        <input type="hidden" value="<?php echo $period; ?>" name="period">
        <input type="hidden" value="print" name="print">
        <input type="submit" value="Print Invoice">
    </form>
</div>
<br /><br />
<?php
   }
?>