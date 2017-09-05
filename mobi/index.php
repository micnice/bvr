<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<?php
session_start();

//if(isset($_GET['logout']) || !empty($_GET['logout'])){
//    if(strcmp($_GET['logout'],'true')==0){
        $_SESSION = Array();
        $_SESSION['login']='false';
        
//    }
//}

if(strcmp($_SESSION['login'],'true')==0){
    header('Location: loginclinic.php');
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to the Beneficiary Voucher Repository System</title>
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen">
</head>
<body>
    <form action="loginclinic.php" method="POST">
    <div align="center"><center><h4>BVR Login Page..</h4><br />
            <?php 
            if(isset($_GET['login']) || !empty($_GET['login'])){
                echo "<br/><font color='red'>Login Failed! Try again!</font>";
            }
            ?>
            <table border="0">
        <tr>
            <td><font size="4">Username:</font></td>
            <td><input type="text" size="15" maxlength="15" name="username"> </td>
        </tr>
        <tr>
            <td><font size="4">Password:</font></td>
            <td><input type="password" size="15" maxlength="15" name="password"> </td>
        </tr>
    </table>
    </center></div><p align="center">
    <input type="submit" value="Login" /></p> </p>
    <p>&nbsp;</p>
</form>
</body>
</html>
