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
<form action="cboscore.php" method="POST">
    <div align="center"><h3>CBO Score</h3><br/>
        <table style="background-color: #E0F277;">
            <tr>
                <td><font size="4">Period</font></td>
                <td><select name="period">
                    <?php
                    include 'dbconnect.php';
                    $sql = pg_query(
                        $conn,
                        "SELECT monthcode,monthname,yearname FROM period order by yearname desc,monthcode asc"
                    );
                    echo '<option value="">---Select Period---</option>';
                    while ($row = pg_fetch_assoc($sql)) {
                      echo '<option value="'.htmlspecialchars($row['monthcode'])
                          .'">'.htmlspecialchars($row['monthname'])." "
                          .htmlspecialchars($row['yearname']).'</option>';
                    }
                    //pg_close($conn);
                    ?>
                    </select>

                </td>
            </tr>
            <tr>
                <td><font size="4">Distributor Name</font></td>
                <td><select name="distributor" id="distributor">
                    <?php
                    $sql = pg_query(
                        $conn,
                        "SELECT idfacility,facilityname FROM facility"
                    );
                    while ($row = pg_fetch_assoc($sql)) {
                      echo '<option value="'.htmlspecialchars(
                              $row['idfacility']
                          ).'">'.htmlspecialchars($row['facilityname'])
                          .'</option>';
                    }
                    //pg_close($conn);
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><font size="4">Questionnaire Serial Number</font></td>
                <td><input type="text" size="20" name="serialno" required/>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit"
                                                      value="Submit"></td>
            </tr>
        </table>
    </div>
    </div>
</form>
</body>
</html>