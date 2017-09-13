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
<form action="vouchertracker_beta.php" method="POST">
    <div align="center"><h3>Track Vouchers</h3><br/>
        <table style="margin:auto auto;background-color: #E0F277;width: 400px; text-align: left">
            <tr>
                <td style="width: 200px"><font size="4">Period</font></td>
                <td style="width: 200px"><select name="period" id="period"
                                                 required="true">
                    <?php
                    include 'dbconnect.php';
                    $sql = pg_query(
                        $conn,
                        "SELECT monthcode,monthname,yearname FROM period order by yearname desc,monthcode asc"
                    );
                    echo '<option value="">---Select Period---</option>';
                    while ($row = pg_fetch_assoc($sql)) {
                      $month = $row['monthcode'];
                      if ($month >= 13 and month <= 24) {
                        $month = $month - 12;
                        $monthcode = str_pad($month, 2, 0, STR_PAD_LEFT);
                      } elseif ($month >= 25 and month <= 36) {
                        $month = $month - 24;
                        $monthcode = str_pad($month, 2, 0, STR_PAD_LEFT);
                      } else {
                        $monthcode = str_pad($month, 2, 0, STR_PAD_LEFT);
                      }
                      echo '<option value="'.htmlspecialchars($monthcode).'/'
                          .htmlspecialchars($row['yearname']).'">'
                          .htmlspecialchars($row['monthname'])." "
                          .htmlspecialchars($row['yearname']).'</option>';
                    }
                    //pg_close($conn);
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="width: 200px"><font size="4">District</font></td>
                <td style="width: 200px">
                    <select name="district" id="district" required="true">
                        <option value="">---Select District---</option>
                        <option value="Harare">Harare South</option>
                        <option value="Bulawayo">Nkulumane</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit"
                                                      value="Submit"></td>
            </tr>
        </table>
    </div>
</form>
</body>
</html>