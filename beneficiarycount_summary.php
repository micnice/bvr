    
<?php 
include 'dbconnect.php';

$strSQL1 = "select 'Nkulumane District' district,monthname,yearname,monthcode,count(distinct nationalid) beneficiaries from redeemedvouchers a,period b "
        . " where a.periodid=b.monthcode and distributorno in (select idfacility from facility where iddistrict=1)"
        . " group by district,monthname,yearname,monthcode order by monthcode";

  $result1 = pg_exec($conn, $strSQL1);
  $numrows1 = pg_numrows($result1);
  
$strSQL2 = "select 'Harare South District' district,monthname,yearname,monthcode,count(distinct nationalid) beneficiaries from redeemedvouchers a,period b "
        . " where a.periodid=b.monthcode and distributorno in (select idfacility from facility where iddistrict=2)"
        . " group by district,monthname,yearname,monthcode order by monthcode";

  $result2 = pg_exec($conn, $strSQL2);
  $numrows2 = pg_numrows($result2);
  
  //echo $strSQL2;
  //echo '<br />'.$strSQL.'<br />';
?>

<h3 style="text-align: center">Beneficiary Count</h3>


<table>
<tr style="background-image: url(images/green_bg.png);">  
   <th>District</th>
   <th>Period</th>
   <th>No. of Beneficiaries</th>
</tr>
<tr>
   <td rowspan="<?php echo $numrows2+1; ?>">Harare South District </td>
</tr>
<?php

   // Loop on rows in the result set.

   for($i = 0; $i < $numrows2; $i++) {
    $row = pg_fetch_array($result2, $i);
    ?>
        <tr>
           <td><?php echo $row["monthname"].' '.$row["yearname"]; ?> </td>
           <td><?php echo $row["beneficiaries"]; ?> </td>
        </tr>
<?php
  }
?>
<tr>
   <td rowspan="<?php echo $numrows1+1; ?>">Nkulumane District </td>
</tr>        
<?php
  
     for($i = 0; $i < $numrows1; $i++) {
    $row = pg_fetch_array($result1, $i);
    ?>
        <tr>
           <td><?php echo $row["monthname"].' '.$row["yearname"]; ?> </td>
           <td><?php echo $row["beneficiaries"]; ?> </td>
        </tr>
<?php
  }
   pg_close($conn);
  ?>
</table>
<br />

<hr />

</form>

