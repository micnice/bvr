<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN"
        "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<?php
session_start();
if (strcmp($_SESSION['login'], 'false') == 0) {
  header('Location: index.php');
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Beneficiary Voucher Repository System</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>
<form action="assessment_scores.php" method="POST">
    <div align="center"><h3>Assessment Scores</h3><br/>
        <select name="city" required>
            <option value="">---Select District---</option>
            <option value="Harare">Harare South</option>
            <option value="Bulawayo">Nkulumane</option>
        </select><br/>
        <input type="Submit" value="Submit"/>
    </div>
</form>
</body>
</html>