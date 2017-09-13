<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Beneficiary Voucher Repository System</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>

<form method="POST" action="main.php?page=adduser_process">
    <div align="center"><h3>Add New User</h3><br/>
        <table style="background-color: #E0F277;">
            <tr>
                <td><font size="4">Username:</font></td>
                <td><input type="text" size="20" maxlength="20" name="username">
                </td>
            </tr>
            <tr>
                <td><font size="4">Password:</font></td>
                <td><input type="password" size="30" maxlength="50"
                           name="password"></td>
            </tr>
            <tr>
                <td><font size="4">First name:</font></td>
                <td><input type="text" size="30" maxlength="50"
                           name="firstname"></td>
            </tr>
            <tr>
                <td><font size="4">Surname:</font></td>
                <td><input type="text" size="30" maxlength="50" name="surname">
                </td>
            </tr>
            <tr>
                <td><font size="4">User Role:</font></td>
                <td><select name="userrole" id="userrole" required>
                        <option value="">---Select User role---</option>
                    <?php
                    include 'dbconnect.php';
                    $sql = pg_query(
                        $conn,
                        "SELECT distinct userrole FROM users order by userrole asc"
                    );
                    while ($row = pg_fetch_assoc($sql)) {
                      echo '<option value="'.htmlspecialchars($row['userrole'])
                          .'">'.htmlspecialchars($row['userrole']).'</option>';
                    }
                    //pg_close($conn);
                    ?>
                    </select></td>
            </tr>
            <tr>
                <td><font size="4">Organisation:</font></td>
                <td><select name="organisation" id="organisation" required>
                        <option value="">---Select Organisation---</option>
                    <?php
                    include 'dbconnect.php';
                    $sql = pg_query(
                        $conn,
                        "SELECT distinct organisation FROM users order by organisation asc"
                    );
                    while ($row = pg_fetch_assoc($sql)) {
                      echo '<option value="'.htmlspecialchars(
                              $row['organisation']
                          ).'">'.htmlspecialchars($row['organisation'])
                          .'</option>';
                    }
                    //pg_close($conn);
                    ?>
                    </select></td>
            </tr>
            <tr>
                <td><font size="4">Facility:</font></td>
                <td><select name="facility" id="facility" required>
                        <option value="">---Select Facility---</option>
                        <option value="0">--All Facilities--</option>
                    <?php
                    include 'dbconnect.php';
                    $sql = pg_query(
                        $conn,
                        "SELECT idfacility,facilityname FROM facility order by facilityname asc"
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
        </table>
    </div>
    <p align="center">
        <input type="hidden" name="adduser" value="new"/>
        <input type="submit" value="Submit"/></p> </p>
    <p>&nbsp;</p>
</form>

</body>
</html>