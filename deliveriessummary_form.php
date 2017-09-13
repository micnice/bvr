<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN"
        "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<?php
session_start();
if (strcmp($_SESSION['login'], 'false') == 0) {
  header('Location: index.php');
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Welcome to the Beneficiary Voucher Repository System</title>
    <link rel="stylesheet" href="../css/style.css" type="text/css"
          media="screen">
</head>
<body>
<form action="deliveriessummary.php" method="POST">
    <div align="center"><h3>Select Period Range to View Deliveries Summary</h3>
        <br/>
        <table style="background-color: #E0F277;">
            <tr>
                <td><font size="4">From: </font></td>
                <td><select name="period" id="period" required>
                    <?php
                    include 'dbconnect.php';
                    $sql = pg_query(
                        $conn,
                        "SELECT monthcode,monthname,yearname FROM period order by yearname desc, monthcode asc"
                    );
                    echo '<option value="">---Select Period---</option>';
                    while ($row = pg_fetch_assoc($sql)) {
                      echo '<option value="'.htmlspecialchars($row['monthcode'])
                          .'">'.htmlspecialchars($row['monthname']).' '
                          .htmlspecialchars($row['yearname']).'</option>';
                    }
                    echo '<option value="0">---Up to Date---</option>';
                    ?>
                    </select>

                </td>
            </tr>
            <tr>
                <td><font size="4">To: </font></td>
                <td><select name="period2" id="period2" required>
                    <?php
                    include 'dbconnect.php';
                    $sql = pg_query(
                        $conn,
                        "SELECT monthcode,monthname,yearname FROM period order by yearname desc, monthcode asc"
                    );
                    echo '<option value="">---Select Period---</option>';
                    while ($row = pg_fetch_assoc($sql)) {
                      echo '<option value="'.htmlspecialchars($row['monthcode'])
                          .'">'.htmlspecialchars($row['monthname']).' '
                          .htmlspecialchars($row['yearname']).'</option>';
                    }
                    ?>
                    </select>

                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="Submit"></td>
            </tr>
        </table>
    </div>
</body>
</html>