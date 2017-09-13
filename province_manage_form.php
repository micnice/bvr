<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Beneficiary Voucher Repository System</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>
<?php
$idprovince = $_GET['id'];
$provincename = $_GET['name'];
$action = $_GET['action'];

if (strcmp($action, 'new') == 0) {
  $idprovince = '';
  $provincename = '';
}
?>
<form action="province_manage.php" method="POST">
    <div align="center"><h3>Manage Provinces</h3><br/>
        <table style="background-color: #E0F277;">
            <tr>
                <td><font size="4">Province</font></td>
                <td><input type="text" size="50" maxlength="50" id="province"
                           name="province" value="<?php echo $provincename; ?>"
                           required>
                </td>
            </tr>
        </table>
    </div>
    <p align="center">
        <input type="hidden" name="idprovince"
               value="<?php echo $idprovince; ?>"/>
        <input type="submit" value="Submit"/></p> </p>
    <p>&nbsp;</p>
</form>
</body>
</html>