<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN"
        "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<?php
session_start();
if (strcmp(trim($_SESSION['login']), 'false') == 0) {
  header('Location: index.php');
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Beneficiary Voucher Repository System</title>
    <link rel="stylesheet" href="../css/style.css" type="text/css"
          media="screen">
</head>
<body>

<form>
    Search : <input type="text" size="30" onkeyup="showResult(this.value)">
    (..by Firstname, Surname, or National ID)
    <div id="livesearch"><?php include 'beneficiarysearch.php'; ?></div>
</form>

<script>
    function showResult(str) {
        if (str.length === 0) {
            document.getElementById("livesearch").innerHTML = "";
            document.getElementById("livesearch").style.border = "0px";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {  // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                document.getElementById("livesearch").innerHTML = xmlhttp.responseText;
                document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
            }
        };
        xmlhttp.open("GET", "beneficiarysearch.php?q=" + str, true);
        xmlhttp.send();
    }
</script>


<?php include "footer.php"; ?>

</body>
</html>