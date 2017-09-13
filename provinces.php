<html>
<head>
    <title>SELECT Operation</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>

<?php
include 'dbconnect.php';
$strSQL = "SELECT idprovince,provincename from province";

$result = pg_exec($conn, $strSQL);
$numrows = pg_numrows($result);
?>

<h3 style="text-align: center">Manage Provinces</h3>
<table>
    <tr style="background-image: url(images/green_bg.png);">
        <th>Province</th>
        <th></th>
    </tr>

  <?php

  // Loop on rows in the result set.

  for ($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    ?>
      <tr>
          <td><?php echo $row["provincename"]; ?> </td>
          <td>
              <a href="province_manage_form.php?id=<?php echo $row["idprovince"]; ?>&action=edit&name=<?php echo $row["provincename"]; ?>">Edit</a>
          </td>
      </tr>
    <?php
  }
  pg_close($conn);
  ?>
    <tr>
        <td></td>
        <td><a href="province_manage_form.php?action=new&name=new&id=new">Add
                New</a></td>
    </tr>
</table>

</body>
</html>
