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
<form action="referral_confirm.php" method="POST" id='searchform'>

    <div align="center">
        <h3>Create an e-Referral Note</h3>
        <table style="margin:auto 0;background-color: #E0F277;width: 300px;">
            <tr>
                <td style="width: 100px;">National ID:</td>
                <td><input type='text' id='nationalid' name='nationalid'></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit"
                                                      value="Search"></td>
            </tr>
        </table>
    </div>
</form>

<?php include "footer.php"; ?>

</body>
</html>