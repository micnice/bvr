<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
        <?php
        session_start();
        include '../dbconnect.php';
        
        if(strcmp($_SESSION['login'], 'false')==0){
            $username=$_POST['username'];
            $password=$_POST['password'];
            $query = "SELECT * FROM users WHERE username = '$username' AND password = md5('$password') and userrole in ('clinic','CBO','admin','hospital','ambulance');";
            //echo $query;
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
    <body style="text-align: center;">
<h1>BVR Main Menu</h1>
<h2>
    <?php
    $role = trim($_SESSION['userrole']);
    $acl=array("NPA","admin","clinic");
    $menudisplay=0;
    if(in_array($role,$acl)){ 
    ?>
            <a href="verifyvoucher.php">Verify / Redeem Voucher</a><br /><br />
            
            <a href="vouchersales_form.php">Voucher Sales</a><br /><br />
            <a href="vouchersalessummary.php">Voucher Sales Summary</a><br /><br />

<hr />
    <?php 
    $menudisplay=1;
    }
    
    $acl=array("NPA","admin","hospital","ambulance");
    if(in_array($role,$acl)){ 
    ?>
            <a href="verifyvoucher.php">Verify / Redeem Voucher</a><br /><br />

    <hr />
    <?php 
    $menudisplay=1;
    }
    
    $acl=array("NPA","admin","CBO");
    if(in_array($role,$acl)){ 
    ?>
            <a href="cboscore_form.php">CBO Score</a><br /><br />
            <a href="viewcboquestionnaires_form.php">Audit CBO Scores</a><br /><br />
            <a href="cboscore_summary_form.php">CBO Score Summary</a><br /><br />
            <a href="cbosamples_form.php">CBO Samples</a><br /><br />


    <?php 
    $menudisplay=1;
    }
    
    if($menudisplay==1){
        include "footer.php"; 
    }else{
        echo "Problem with login session. <a href='index.php'>Try again</a>";
    }
    
    ?></h2>
</body>
</html>    