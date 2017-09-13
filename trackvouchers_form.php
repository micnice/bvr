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
<form action="trackvouchers.php" method="POST">
    <div align="center"><h3>Track Vouchers</h3><br/>
        Enter Voucher Number to Track: <input type="text" name="voucherserial"
                                              size="10"
                                              id="voucherserial"/><br/>
        <input type="submit" value="Track Voucher"/>
    </div>
</form>
</body>
</html>