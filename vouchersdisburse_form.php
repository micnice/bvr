<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Beneficiary Voucher Repository System</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>

<form action="vouchersdisburse_process.php" method="POST">
    <div align="center"><h3>Disburse Vouchers</h3><br/>
        <table style="background-color: #E0F277;">
            <tr>
                <td><font size="4">Facility Name:</font></td>
                <td><select name="distributor" id="distributor">
                    <?php
                    include 'dbconnect.php';
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
                    </select></td>
            </tr>
            <tr>
                <td><font size="4">Start Serial No. :</font></td>
                <td><input type="text" size="30" maxlength="50"
                           name="startserial"></td>
            </tr>
            <tr>
                <td><font size="4">End Serial No. :</font></td>
                <td><input type="text" size="20" maxlength="20"
                           name="endserial"></td>
            </tr>
            <tr>
                <td><font size="4">Collected By. :</font></td>
                <td><input type="text" size="20" maxlength="20"
                           name="collectedby"></td>
            </tr>
            <tr>
                <td><font size="4">Date Collected. :</font></td>
                <td><input type="text" size="20" maxlength="20"
                           name="datecollected"></td>
            </tr>
        </table>
    </div>
    <p align="center">
        <input type="submit" value="Submit"/></p> </p>
    <p>&nbsp;</p>
</form>

</body>
</html>