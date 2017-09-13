<?php
include 'dbconnect.php';

$key = strtolower(trim($_GET['q']));

if (strlen(trim($key)) > 0) {
  $strSQL = "select * from household where lower(firstname) like '%".$key
      ."%' or lower(surname) like '%".$key."%' or lower(nationalid) like '%"
      .$key."%'";
} else {
  $strSQL = "select * from household";
}
$result = pg_exec($conn, $strSQL);
$numrows = pg_numrows($result);
?>

<h3 style="text-align: center">List Of House Holds</h3>
<table>
    <tr style="background-image: url(images/green_bg.png);">
        <th>First Name</th>
        <th>Last Name</th>
        <th>National ID</th>
        <th>Ward Name</th>
        <th>Phone #</th>
        <th>Address</th>
    </tr>

  <?php

  // Loop on rows in the result set.

  for ($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    ?>
      <tr>
          <td><?php echo $row["firstname"]; ?> </td>
          <td><?php echo $row["surname"]; ?> </td>
          <td><?php echo $row["nationalid"]; ?> </td>
          <td><?php echo $row["wardname"]; ?> </td>
          <td><?php echo $row["phone"]; ?> </td>
          <td><?php echo $row["address"]; ?> </td>
      </tr>
    <?php
  }
  pg_close($conn);
  ?>
</table>