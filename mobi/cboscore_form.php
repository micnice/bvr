<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<?php
session_start();
if(strcmp($_SESSION['login'], 'false')==0){
    header('Location: index.php');
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Beneficiary Voucher Repository System</title>
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen">
</head>
<body>
                <script type="text/javascript">

                    function UnknownCheck() {
                        if (document.getElementById('Unknown').checked) {
                            document.getElementById('UnknownCheck').style.display = 'block';
                            document.getElementById('KnownCheck').style.display = 'none';
                            document.getElementById('knownSerial').disabled = true;
                        }
                        else {
                                document.getElementById('KnownCheck').style.display = 'block';
                                document.getElementById('UnknownCheck').style.display = 'none';
                                document.getElementById('unknownSerial').disabled = true;
                        }

                    }

                    </script>

    <form action="cboscore.php" method="POST">
        <div align="center"><h3>CBO Score</h3><br />
           <table  style="background-color: #E0F277;">
                <tr>
                    <td><font size="4">Period</font></td>
                    <td> <select name="period" required>
                        <?php
                        include 'dbconnect.php';
                        $sql = pg_query($conn,"SELECT monthcode,monthname,yearname FROM period");
                        echo '<option value="">---Select Period---</option>';
                        while ($row = pg_fetch_assoc($sql)) {
                        echo '<option value="'.htmlspecialchars($row['monthcode']).'">'.htmlspecialchars($row['monthname'])." ".htmlspecialchars($row['yearname']).'</option>';}
                        //pg_close($conn);
                        ?>
                        </select> 

                    </td>
              </tr>  
                <tr>
                    <td><font size="4">Distributor Name</font></td>
                    <td> <select name="distributor" id="distributor">
                        <?php
                        $userrole = trim($_SESSION['userrole']);
                        $cbo=trim($_SESSION[username]);
                        if(strcmp($userrole, 'admin')==0){
                            $sql = pg_query($conn,"SELECT idfacility,facilityname FROM facility");
                        }else{
                            $sql = pg_query($conn,"SELECT idfacility,facilityname FROM facility where cbo='$cbo'");
                        }
                        
                        while ($row = pg_fetch_assoc($sql)) {
                        echo '<option value="'.htmlspecialchars($row['idfacility']).'">'.htmlspecialchars($row['facilityname']).'</option>';}
                        //pg_close($conn);
                        ?>
                        </select> 
                    </td>
              </tr>
              <tr>
                  <td><font size="4">Questionnaire Serial Number</font><br /><font size="2">
                      UnKnown: <input type="radio" onclick="javascript:UnknownCheck();" id="Unknown" value="Unknown" name="testUnknown">, 
                        Available: <input type="radio" onclick="javascript:UnknownCheck();" id="Known" value="Known" name="testUnknown">
                        </font>
                    </td>
                    <td>  
                        
                        
                        <div id="UnknownCheck" style="display:none">
                            <input type="hidden" size="20" name="serialno" id="unknownSerial" value="0" />
                            <em>To be auto-generated!</em>
                        </div>
                        <div id="KnownCheck" style="display:block">
                            <input type="text" size="20" name="serialno" id="knownSerial" required />
                        </div>   
                    </td>
              </tr>
         <tr><td colspan="2" align="center"><input type="submit" value="Submit"></td></tr>
        </table>
        </div>
</div>
</form>
    <?php include "footer.php"; ?>
</body>
</html>