<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Beneficiary Voucher Repository System</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>

<form method="POST">
    <div align="center"><h3>Add House Hold</h3><br/>
        <table style="background-color: #E0F277;">
            <tr>
                <td><font size="4">Numerator Number</font></td>
                <td><input type="number" size="30" maxlength="60"
                           name="numerator" required></td>
            </tr>
            <tr>
                <td><font size="4">Ward Number</font></td>
                <td><input type="number" size="10" maxlength="10" name="ward"
                           required></td>
            </tr>
            <tr>
                <td><font size="4">First name</font></td>
                <td><input type="text" size="30" maxlength="50" name="firstname"
                           required></td>
            </tr>
            <tr>
                <td><font size="4">Surname</font></td>
                <td><input type="text" size="30" maxlength="50" name="surname"
                           required></td>
            </tr>
            <tr>
                <td><font size="4">Household Head ID Number</font></td>
                <td><input type="text" size="20" name="nationalid"
                           pattern="[0-9]{2}-[0-9]{6,7}[A-Z][0-9]{2}"
                           placeholder="XX-000000X00" required></td>
            </tr>
            <tr>
                <td><font size="4">Phone Number:</font></td>
                <td><input type="number" size="20" maxlength="20" name="phone">
                </td>
            </tr>
            <tr>
                <td><font size="4">Physical Address:</font></td>
                <td><input type="text" size="50" maxlength="100" name="address"
                           required></td>
            </tr>

            <tr>
                <td><font size="4">District:</font></td>
                <td><input type="number" size="30" maxlength="50"
                           name="district" required></td>
            </tr>
        </table>
    </div>
    <p align="center">
        <input type="submit" value="Submit"/></p> </p>
    <p>&nbsp;</p>
</form>
</body>
</html>