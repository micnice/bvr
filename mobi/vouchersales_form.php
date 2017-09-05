<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<?php
session_start();
if(strcmp($_SESSION['login'], 'false')==0){
    header('Location: index.php');
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Welcome to the Beneficiary Voucher Repository System</title>
        <link rel="stylesheet" href="../css/style.css" type="text/css" media="screen">
    </head>
    <body style="text-align: center;">
<form action="vouchersales_search.php" method="POST" id='searchform'>
<h3>Add / Edit Voucher Sales</h3>
    <div>
        <em>Search using a combination of Firstname and Surname OR with just ID number</em>
        <table  style="margin:auto auto;background-color: #E0F277;width: 300px;">
            <tr>
                    <td style="width: 100px;">National ID: </td><td><input type='text' id='nationalid' name='nationalid'></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">OR </td></td>
            </tr>
            <tr>
                <td style="width: 100px">First name: </td><td><input type='text' id='firstname' name='firstname'></td>
            </tr>
            <tr>
                <td>Surname: </td><td><input type='text' id='surname' name='surname'></td>
            </tr>
            
            <tr><td colspan="2" align="center"><input type="submit" value="Search"></td></tr>
        </table>
    </div>  
</form>

<?php include "footer.php"; ?>

        </body>
</html>