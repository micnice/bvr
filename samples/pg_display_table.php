  <html>

  <head>
   <title>Test</title>
  </head>

  <body bgcolor="white">

  <?php
  include_once 'dbconnect.php';

  $result = pg_exec($conn, "select * from users");
  $numrows = pg_numrows($result);
  echo "<p>link = $conn<br>
  result = $result<br>
  numrows = $numrows</p>
  ";
  ?>

  <table border="1">
  <tr>
   <th>Username</th>
   <th>First name</th>
   <th>Surname</th>
   <th>User role</th>
  </tr>
  <?php

   // Loop on rows in the result set.

   for($ri = 0; $ri < $numrows; $ri++) {
    echo "<tr>\n";
    $row = pg_fetch_array($result, $ri);
    echo " <td>", $row["username"], "</td>
   <td>", $row["firstname"], "</td>
   <td>", $row["surname"], "</td>
   <td>", $row["userrole"], "</td>
  </tr>
  ";
   }
   pg_close($conn);
  ?>
  </table>

  </body>

  </html>