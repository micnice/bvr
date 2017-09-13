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
<br/>
<h3 style="text-align: center">Available Redeemed Vouchers</h3>
<?php
$nationalid = $_POST['nationalid'];
$idredeemedvoucher = $_POST['idredeemedvoucher'];
$shortname = $_POST['shortname'];
$vouchertype = $_POST['vouchertype'];
$voucherserial = $_POST['redeemserial'];
$name = $_POST['name'];
?>
<br/>
<table style="margin:auto;">
    <tr>
        <td colspan="2"><h3>Confirm??</h3>Are you sure you want to revoke the
            voucher with the following details:
        </td>
    </tr>
    <tr>
        <td>National ID:</td>
        <td><?php echo $nationalid; ?></td>
    </tr>
    <tr>
        <td>Voucher Description:</td>
        <td><?php echo $shortname; ?></td>
    </tr>
    <tr>
        <td>Beneficiary:</td>
        <td><?php echo $name; ?></td>
    </tr>
    <tr>
        <td colspan="2">
            <form action="main.php?page=revokevoucher_process" method="POST">
                <input type="hidden" name="idredeemedvoucher"
                       value="<?php echo $idredeemedvoucher; ?>">
                <input type="hidden" name="nationalid"
                       value="<?php echo $nationalid; ?>">
                <input type="hidden" name="vouchertype"
                       value="<?php echo $vouchertype; ?>">
                <input type="hidden" name="voucherserial"
                       value="<?php echo $voucherserial; ?>">
                <input type="submit" value="Revoke Voucher">
            </form>
        </td>
    </tr>
</table>
</body>
</html>