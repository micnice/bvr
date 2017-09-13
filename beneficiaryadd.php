<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Beneficiary Voucher Repository System</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>
<?php
if (isset($_GET['$msg'])) {
  if ($_GET['$msg'] == 'error') {
    echo 'Error! Record was not saved!';
  } else {
    echo 'Record was saved successfully!';
  }
}
?>
<form action="beneficiaryadd_process.php" method="POST">
    <div align="center"><h3>Add Beneficiary</h3><br/>
        <table style="background-color: #E0F277;">
            <tr>
                <td><font size="4">Household Head ID Number</font></td>
                <td><input type="text" size="20" maxlength="20"
                           id="hhnationalid" name="hhnationalid"
                           pattern="[0-9]{2}-[0-9]{6,7}[A-Z][0-9]{2}"
                           placeholder="XX-000000X00" required>
                    <span id="user-result"></span>
                </td>
            </tr>
            <tr>
                <td><font size="4">Firstname</font></td>
                <td><input type="text" size="30" maxlength="50" name="firstname"
                           required></td>
            </tr>
            <tr>
                <td><font size="4">Surname</font></td>
                <td><input type="text" size="30" maxlength="50" name="surname"
                           required></td>
            </tr>
            <tr>
                <td><font size="4">National ID Number</font></td>
                <td><input type="text" size="20" maxlength="20"
                           name="nationalid"
                           pattern="[0-9]{2}-[0-9]{6,7}[A-Z][0-9]{2}"
                           placeholder="XX-000000X00" required></td>
            </tr>
            <tr>
                <td><font size="4">Date of Birth</font></td>
                <td><input type="date" name="dob"
                           pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}"
                           placeholder="dd-mm-yyyy" required></td>
            </tr>
            <tr>
                <td><font size="4">Phone Number</font></td>
                <td><input type="number" name="phone" required></td>
            </tr>
        </table>
    </div>
    <p align="center">
        <input type="submit" value="Submit"/></p> </p>
    <p>&nbsp;</p>
</form>
</body>
</html>