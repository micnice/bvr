<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
        <?php
        session_start();
        include '../dbconnect.php';
        
        if(strcmp($_SESSION['login'], 'false')==0){
            $username=$_POST['username'];
            $password=$_POST['password'];
            $query = "SELECT * FROM users WHERE username = '$username' AND password = md5('$password') and userrole in ('clinic','CBO','admin');";
            $result = pg_query($conn, $query);
            $row = pg_fetch_array($result, 0);
            if(pg_num_rows($result) != 1) {
                header("Location: index.php?login=fail");
                die();
            } else {
                $_SESSION["login"] = "true";
                $_SESSION["userrole"] = $row[6];
                $_SESSION["username"] = $row[0];
                $_SESSION["facility"] = $row[11];
            }
        }
        ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to the Beneficiary Voucher Repository System</title>
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen">
</head>
<body>
<h1>BVR Main Menu</h1>
<h2>
    <?php
    $acl=array("NPA","admin","clinic");
    if(in_array($_SESSION['userrole'],$acl)){ 
    ?>
            <a href="verifyvoucher.php">Verify / Redeem Voucher</a><br /><br />
            <hr />
            <a href="vouchersales_form.php">Voucher Sales</a><br /><br />
            <a href="vouchersalessummary.php">Voucher Sales Summary</a><br /><br />


    <?php 
    }
    
    $acl=array("NPA","admin","CBO");
    if(in_array($_SESSION['userrole'],$acl)){ 
    ?>
            <a href="cboscore_form.php">Verify / Redeem Voucher</a><br /><br />
            <hr />
            <a href="viewcboquestionnaires_form.php">Voucher Sales</a><br /><br />
            <a href="cboscore_summary_form.php">Voucher Sales Summary</a><br /><br />
            <a href="cbosamples_form.php">Voucher Sales Summary</a><br /><br />


    <?php 
    }
    include "footer.php"; ?></h2>
</body>
</html>    