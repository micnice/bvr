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
        <script type="text/javascript">

function SearchCheck() {
    if (document.getElementById('NameCheck').checked) {
        document.getElementById('ifName').style.display = 'block';
        document.getElementById('ifID').style.display = 'none';
        document.getElementById('searchform').action = 'verifyvoucher_search.php';
    }
    else {
            document.getElementById('ifName').style.display = 'none';
            document.getElementById('ifID').style.display = 'block';
            document.getElementById('searchform').action = 'verifyvoucher_process.php';
    }

}

</script>
<form action="verifyvoucher_process.php" method="POST" id='searchform'>
<h3>Verify / Redeem Vouchers</h3>
Search By: <br />
ID No: <input type="radio" onclick="javascript:SearchCheck();" name="searchby" id="IDCheck" value="nationalid">, 
    Name: <input type="radio" onclick="javascript:SearchCheck();" name="searchby" id="NameCheck" value="name"><br>
            <br />
    <div id="ifName" style="display:none">
        <table  style="margin:auto auto;background-color: #E0F277;width: 400px; text-align: left">
            <tr>
                <td style="width: 200px">First name: </td><td style="width: 200px"><input type='text' id='firstname' name='firstname'></td>
            </tr>
            <tr>
                <td>Surname: </td><td><input type='text' id='surname' name='surname'></td>
            </tr>
        </table>
    </div>
    <div id="ifID" style="display:block">
        <table  style="margin:auto auto;background-color: #E0F277;width: 400px; text-align: left">
        <tr>
            <td style="width: 200px;">National ID: </td><td style="width: 200px"><input type='text' id='nationalid' name='nationalid'></td>
        </tr>
        </table>

    </div>   
            
    <?php
    if(strcmp(trim($_SESSION['userrole']), 'hospital')==0){
    ?>
            
    <input type='hidden' id='refnumber' name='refnumber' value="1">
            
    <?php
    //echo $_SESSION['userrole']." 1";
    }else{
    ?>
            <input type='hidden' id='refnumber' name='refnumber' value="0">   
    <?php  
    //echo $_SESSION['userrole']." 2";
    }
    ?>
            
    <?php include 'orgunit_period_select.php'; ?><br />
</form>
    <?php include "footer.php"; ?>
    
    </body>
</html>