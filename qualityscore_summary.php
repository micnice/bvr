<?php
include 'dbconnect.php';
$district = $_POST['district'];

if (strcmp($district, 'Harare') == 0) {
  $districtid = 2;
}
if (strcmp($district, 'Nkulumane') == 0) {
  $districtid = 1;
}
$strSQL
    = "select facilityname,monthname,yearname,totalscore from qualitychecklist a,period b,facility c "
    ." where iddistrict = $districtid and facilityid=idfacility and a.periodid=b.monthcode";

$result = pg_exec($conn, $strSQL);
$numrows = pg_numrows($result);

//echo $strSQL;
//echo '<br />'.$strSQL.'<br />';
?>

<h3 style="text-align: center">Summary of Quality Checklist</h3>


<table>
    <tr style="background-image: url(images/green_bg.png);">
        <th>Facility Name</th>
        <th>Period</th>
        <th>Total Score</th>
    </tr>

  <?php

  // Loop on rows in the result set.

  for ($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    ?>
      <tr>
          <td><?php echo $row["facilityname"]; ?> </td>
          <td><?php echo $row["monthname"].' '.$row["yearname"]; ?> </td>
          <td><?php echo $row["totalscore"]; ?> </td>
      </tr>
    <?php
  }
  pg_close($conn);
  ?>
</table>
<br/>

<hr/>

</form>

