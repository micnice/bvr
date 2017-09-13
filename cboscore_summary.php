<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN"
        "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<?php
session_start();
if (strcmp($_SESSION['login'], 'false') == 0) {
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
$distributor = $_POST['distributor'];
$period = $_POST['period'];

$strSQL
    = "select facilityname,monthname,yearname,a.periodid,count(*) qnumber,sum(q1+q2+q3+q4+q5+q6) score, min(serialno) minserial, max(serialno) maxserial from cboscore a,period b,facility c "
    ." where facilityid=$distributor and facilityid=idfacility and a.periodid=b.monthcode group by facilityname,monthname,yearname,a.periodid";

$result = pg_exec($conn, $strSQL);
$numrows = pg_numrows($result);

//echo $strSQL;
?>

<h3 style="text-align: center">Summary of Questionnaires By Facility</h3>


<table>
    <tr style="background-image: url(images/green_bg.png);">
        <th>Facility Name</th>
        <th>Period</th>
        <th>No. of Questionnaires</th>
        <th>Serial Numbers</th>
        <th>Total Score</th>
        <th>Total Possible Score</th>
        <th>Percentage</th>
        <th>Action</th>
    </tr>

  <?php

  // Loop on rows in the result set.

  for ($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    ?>
      <tr>
          <td><?php echo $row["facilityname"]; ?> </td>
          <td><?php echo $row["monthname"].' '.$row["yearname"]; ?> </td>
          <td><?php echo $row["qnumber"]; ?> </td>
          <td><?php echo $row["minserial"].' - '.$row["maxserial"]; ?> </td>
          <td><?php echo $row["score"]; ?> </td>
          <td><?php echo $row["qnumber"] * 45; ?> </td>
          <td><?php echo number_format(
                ($row["score"] / ($row["qnumber"] * 45)) * 100,
                2,
                '.',
                ''
            ); ?> %
          </td>
          <td>
              <form action="viewcboquestionnaires.php" method="POST">
                  <div align="center">
                      <input type="hidden" name="distributor"
                             value="<?php echo $distributor; ?>">
                      <input type="hidden" name="period"
                             value="<?php echo $row["periodid"]; ?>">
                      <input type="submit" value="Audit"/>
                  </div>
              </form>
          </td>
      </tr>
    <?php
  }
  pg_close($conn);
  ?>
</table>
<br/>

<hr/>
<form action="cboscore_summary.php" method="POST">
    <div align="center"><h3>View Another Summary of CBO Scores</h3>
      <?php include 'orgunit_select.php'; ?>
    </div>
</form>
</body>
</html>
