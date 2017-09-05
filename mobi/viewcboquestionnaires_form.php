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
    
<form action="viewcboquestionnaires.php" method="POST">
<div align="center"><h3>View CBO Questionnaires</h3><br />
     <table  style="background-color: #E0F277;">
                <tr>
                    <td><font size="4">Period</font></td>
                    <td> <select name="period">
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
              <tr><td colspan="2" align="center"><input type="submit" value="Submit"></td></tr>
     </table>
</div>
</form>
  <?php include "footer.php"; ?>
</body>
</html>