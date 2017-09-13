<?php
$tablewidth = "800px";
if (isset($_POST['print'])){
if (strcmp($_POST['print'], 'print') == 0){
$tablewidth = "1000px";
?>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">
    <title>Beneficiary Voucher Repository (BVR)</title>

    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">

    <style type="text/css">
        table {
            border: 1px solid black;
            border-collapse: collapse;
        }

        td, th {
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

if (strcmp($period, '15q1') == 0) {
  $quarter = '1,2,3';
  $periodname = 'Q1 2015';
  $qualitymonth = 3;
}
if (strcmp($period, '15q2') == 0) {
  $quarter = '4,5,6';
  $periodname = 'Q2 2015';
  $qualitymonth = 6;
}
if (strcmp($period, '15q3') == 0) {
  $quarter = '7,8,9';
  $periodname = 'Q3 2015';
  $qualitymonth = 9;
}
if (strcmp($period, '15q4') == 0) {
  $quarter = '10,11,12';
  $periodname = 'Q4 2015';
  $qualitymonth = 12;
}

if (strcmp($period, '16q1') == 0) {
  $quarter = '13,14,15';
  $periodname = 'Q1 2016';
  $qualitymonth = 15;
}
if (strcmp($period, '16q2') == 0) {
  $quarter = '16,17,18';
  $periodname = 'Q2 2016';
  $qualitymonth = 18;
}
if (strcmp($period, '16q3') == 0) {
  $quarter = '19,20,21';
  $periodname = 'Q3 2016';
  $qualitymonth = 21;
}
if (strcmp($period, '16q4') == 0) {
  $quarter = '22,23,24';
  $periodname = 'Q4 2016';
  $qualitymonth = 24;
}

if (strcmp($period, '17q1') == 0) {
  $quarter = '37,38,39';
  $periodname = 'Q1 2017';
  $qualitymonth = 39;
}

if (strcmp($period, '17q2') == 0) {
  $quarter = '40,41,42';
  $periodname = 'Q2 2017';
  $qualitymonth = 42;
}

if (strcmp($period, '17q3') == 0) {
  $quarter = '43,44,45';
  $periodname = 'Q3 2017';
  $qualitymonth = 45;
}

if (strcmp($period, '17q4') == 0) {
  $quarter = '46,47,48';
  $periodname = 'Q4 2017';
  $qualitymonth = 48;
}


$result = pg_query(
    $conn,
    "SELECT * FROM FACILITY WHERE idfacility=$distributor"
);
$orgunit = pg_fetch_result($result, 0, 'facilityname');
$category = pg_fetch_result($result, 0, 'category');


$strSQL
    = "SELECT usage,shortname,price,sum(amount) as totalamount,count(*) as claims"
    ." From voucherclaims,facility, vouchertype  where approval='yes' and distributorno=idfacility and usage=vouchertype"
    ." and idfacility=$distributor and periodid in ($quarter) group by usage,shortname,price order by usage asc";

$result = pg_exec($conn, $strSQL);
$numrows = pg_numrows($result);
//echo $strSQL;
?>

<br/><br/>
<table width="<?php echo $tablewidth; ?>">

    <tr>
        <td colspan="4">

            <h1>Zimbabwe e-Voucher for Health Programme</h1>
            <h2>Health Centre Voucher Claim Invoice</h2>
            <h3>Period: <u><?php echo $periodname; ?></u></h3>
            <h3>Facility: <u><?php echo $orgunit; ?></u></h3>

        </td>
    </tr>

    <tr style="background-image: url(images/green_bg.png);">
        <td><strong>Voucher Description</strong></td>
        <td width="150" align="right"><strong>Number of Claims</strong></td>
        <td width="100" align="right"><strong>Price</strong></td>
        <td width="100" align="right"><strong>Total Claim</strong></td>
    </tr>

  <?php

  // Loop on rows in the result set.
  $totalamount = 0;
  for ($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    $totalamount = $totalamount + $row["totalamount"];
    ?>
      <tr>
          <td><?php echo $row["shortname"]; ?> </td>
          <td align="right"><?php echo $row["claims"]; ?> </td>
          <td align="right"><?php echo $row["price"]; ?> </td>
          <td align="right"><?php echo number_format(
                $row["totalamount"],
                2,
                '.',
                ','
            ); ?> </td>
      </tr>
    <?php
  }


  $qualitySQL = "SELECT totalscore FROM QUALITYCHECKLIST "
      ."WHERE facilityid=$distributor AND periodid=$qualitymonth";

  $result = pg_query($conn, $qualitySQL);

  $cboSQL
      = "select count(*) qnumber,sum(q1+q2+q3+q4+q5+q6) cboscore from cboscore "
      ." where facilityid=$distributor and periodid in ($quarter)";

  $result2 = pg_query($conn, $cboSQL);

  if (pg_num_rows($result) == 0) {
    $totalquality = 0;
  } else {
    $totalquality = pg_fetch_result($result, 0, 'totalscore');
  }

  if (pg_num_rows($result2) == 0) {
    $totalCBOScore = 0;
    $totalQuestionnaires = 0;
  } else {
    $totalCBOScore = pg_fetch_result($result2, 0, 'cboscore');
    $totalQuestionnaires = pg_fetch_result($result2, 0, 'qnumber');
  }


  $cbototal = ($totalCBOScore / ($totalQuestionnaires * 45)) * 100;

  $overallquality = ($totalquality * 0.8) + ($cbototal * 0.2);

  if ($category == 1) {
    if ($overallquality < 30) {
      $qualitypayment = 0;
    }
    if ($overallquality > 30 && $overallquality < 50) {
      $qualitypayment = 2000;
    }
    if ($overallquality > 50 && $overallquality < 70) {
      $qualitypayment = 3500;
    }
    if ($overallquality > 70 && $overallquality < 90) {
      $qualitypayment = 3700;
    }
    if ($overallquality > 90) {
      $qualitypayment = 4000;
    }
  }

  if ($category == 2) {
    if ($overallquality < 30) {
      $qualitypayment = 0;
    }
    if ($overallquality > 30 && $overallquality < 50) {
      $qualitypayment = 2500;
    }
    if ($overallquality > 50 && $overallquality < 70) {
      $qualitypayment = 4300;
    }
    if ($overallquality > 70 && $overallquality < 90) {
      $qualitypayment = 4600;
    }
    if ($overallquality > 90) {
      $qualitypayment = 5000;
    }
  }
  ?>
    <tr>
        <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total
            Payments Due to Quantity (Claims)
        </td>
        <td align="right"><?php echo number_format(
              $totalamount,
              2,
              '.',
              ','
          ); ?> </td>
    </tr>
    <tr style="background-color: #e5e5e5">
        <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quality
            Score
        </td>
        <td align="right"><?php echo number_format(
              $totalquality,
              2,
              '.',
              ','
          ); ?>%
        </td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Client
            Satisfaction Score
        </td>
        <td align="right"><?php echo number_format($cbototal, 2, '.', ','); ?>
            %
        </td>
    </tr>
    <tr style="background-color: #e5e5e5">
        <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Overal
            Quality Score
        </td>
        <td align="right"><?php echo number_format(
              $overallquality,
              2,
              '.',
              ','
          ); ?>%
        </td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quality
            Payment
        </td>
        <td align="right"><?php echo number_format(
              $qualitypayment,
              2,
              '.',
              ','
          ); ?> </td>
    </tr>
    <tr style="background-color: #e5e5e5">
        <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Grand
            Total Payment
        </td>
        <td align="right"><?php echo number_format(
              $totalamount + $qualitypayment,
              2,
              '.',
              ','
          ); ?> </td>
    </tr>
  <?php
  pg_close($conn);
  ?>
</table>

<br/>
<?php
if (isset($_POST['print'])){
if (strcmp($_POST['print'], 'print') == 0){
?>
<br/><br/>
<table width="1000px" style="border:0px">
    <tr>
        <td width="100px">Compiled By:</td>
        <td width="200px"></td>
        <td width="50px" rowspan="3"
            style="border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;"></td>
        <td width="100px">Checked By:</td>
        <td width="200px"></td>
        <td width="50px" rowspan="3"
            style="border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;"></td>
        <td width="100px">Passed for <br/>Payment By:</td>
        <td width="200px"></td>
    </tr>
    <tr>
        <td width="100px">Signature:<br/></td>
        <td width="200px"></td>
        <td width="100px">Signature:<br/></td>
        <td width="200px"></td>
        <td width="100px">Signature:<br/></td>
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
</table>
<br/><br/>
<div align="center">
    <em>Printed On: <?php echo date('l jS \of F Y h:i:s A'); ?></em>
</div>
</body>
</html>
<?php
}
} else {
  ?>
    <div align="center">
        <form action="invoice.php" method="POST" target="Print">
            <input type="hidden" value="<?php echo $distributor; ?>"
                   name="distributor">
            <input type="hidden" value="<?php echo $period; ?>" name="period">
            <input type="hidden" value="print" name="print">
            <input type="submit" value="Print Invoice">
        </form>
    </div>
    <br/><br/>
  <?php
}
?>
