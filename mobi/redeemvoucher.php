<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<?php
session_start();
if(strcmp($_SESSION['login'], 'false')==0){
    header('Location: index.php');
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Beneficiary Voucher Repository System</title>
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen">
</head>
<body>
    
    <form action="redeemvoucher_confirm.php" method="POST">
    <div align="left"><h3>Redeem Vouchers</h3>
        <font size="4">National ID Number:</font><br />
            <input type="text" size="20" maxlength="20" name="nationalid"> <br /><br />
        <font size="4">Voucher Type:</font><br />
           <input type="text" size="20" maxlength="20" name="vouchertype"> <br />
    <input type="submit" value="Redeem" />
    </div>
</form>
   <br />
<?php include "footer.php"; ?>
</body>
</html>