<?php
        session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Beneficiary Voucher Repository System</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body> 
<form action="claimsrejected.php" method="POST">
<div align="center"><h3>View Rejected Claims</h3><br />
    <?php include 'orgunit_period_select3.php'; ?>
</div>
</form>
    <?php include 'footer.php'; ?>
</body>
</html>