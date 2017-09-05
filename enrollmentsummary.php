<?php 
include 'dbconnect.php';

$startdate = $_POST['startdate'];
$enddate = $_POST['enddate'];


    $strSQL = "select city,count(*) from beneficiarymaster where"
            . " reg_date>=to_date('$startdate','dd/mm/yyyy') "
                . " and reg_date<=to_date('$enddate','dd/mm/yyyy')"
            . " group by city"
            . " order by city";

 //echo $strSQL.'<br />';
  
  $result = pg_exec($conn, $strSQL);
  $numrows = pg_numrows($result);
?>
 
<h3 style="text-align: center">Summary of Enrollment</h3>

<table>
    <tr>
        <td colspan="2">
            <h2>Period: </h2><h3><?php echo $startdate; ?> - <?php echo $enddate; ?></h3>
        </td>
    </tr>
    <tr style="background-image: url(images/green_bg.png);">  
       <th>District Name</th>
       <th>Beneficiaries Enrolled</th>
    </tr>

<?php

    // Loop on rows in the result set.
    //
    //$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
    //

   for($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    ?>
        <tr>
           <td><?php echo $row[0]; ?> </td>
           <td><?php echo $row[1]; ?> </td>
        </tr>
<?php
  }
   pg_close($conn);
  ?>
</table>
<br /><br />
<?php
?>