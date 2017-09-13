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
<form action="revokevoucher.php" method="POST">
    <h3 style="text-align: center">Redeemed Vouchers by Beneficiary</h3><br/>
    <table style="background-color: #E0F277;">
        <tr>
            <td style="text-align: center">
                National ID Number: <input type="text" name="nationalid"
                                           size="20"><br/>
                <input type="submit" value="View Redeemed Vouchers"
            </td>
        </tr>
    </table>
</form>
</body>
</html>