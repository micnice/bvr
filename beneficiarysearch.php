<?php
include 'dbconnect.php';

if (isset($_GET['q']) && ! empty($_GET['q'])) {
  $key = strtolower(trim($_GET['q']));
} else {
  $key = "";
}

if (strlen(trim($key)) > 0) {
  $strSQL = "select * from beneficiarymaster where lower(firstname) like '%"
      .$key."%' or lower(surname) like '%".$key
      ."%' or lower(nationalid) like '%".$key."%' "
      ."limit 100";
} else {
  $strSQL = "select * from beneficiarymaster limit 100";
}
//echo $strSQL;
$result = pg_exec($conn, $strSQL);
$numrows = pg_numrows($result);
?>

<h3 style="text-align: center">List Of Beneficiaries</h3>
<table>
    <tr style="background-image: url(images/green_bg.png);">
        <th>First Name</th>
        <th>Last Name</th>
        <th>National ID</th>
        <th>Phone #</th>
        <th>Address</th>
        <th></th>
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
          <td><?php echo $row["phone"]; ?> </td>
          <td><?php echo $row["location"]; ?> </td>
          <td><a href="main.php?page=beneficiaryedit&nationalid=<?php echo trim(
                $row["nationalid"]
            ); ?>">Edit</a></td>
      </tr>
    <?php
  }
  pg_close($conn);
  ?>
</table>