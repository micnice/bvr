<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
session_start();
$_SESSION = Array();
$_SESSION['login']='false';

/*
$_SESSION['role']='';
if(isset($_GET['logout']) || !empty($_GET['logout'])){
    if(strcmp($_GET['logout'],'true')==0){
        $_SESSION['login']='false';
    }
}
if(isset($_GET['login']) || !empty($_GET['login'])){
    if(strcmp($_SESSION['login'],'true')==0){
        header('Location: main.php');
    }
}
 */

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Welcome to the Beneficiary Voucher Repository System</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>
   <?php include 'header.php'; ?>
    <form method="POST" action="main.php">
    <div align="center"><center><h3>Login Page..</h3><br />
            <?php 
            if(isset($_GET['login']) || !empty($_GET['login'])){
                echo "<br/><font color='red'>Login Failed! Try again!</font>";
            }
            ?>
      <table border="0" width="50%">
        <tr>
            <td width="30%"><font size="4">Username:</font></td>
            <td width="50%"><input type="text" size="20" maxlength="20" name="username"> </td>
        </tr>
        <tr>
            <td width="50%"><font size="4">Password:</font></td>
            <td width="50%"><input type="password" size="20" maxlength="20" name="password"> </td>
        </tr>
    </table>
    </center></div><p align="center">
    <input type="submit" value="Login" /></p> </p>
    <p>&nbsp;</p>
    
    <?php include 'footer.php'; ?>
</form>