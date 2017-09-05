<?php
include_once 'dbconnect.php';
$hhnationalid=$_POST['hhnationalid'];
$firstname=$_POST['firstname'];
$surname=$_POST['surname'];
$nationalid=$_POST['nationalid'];
$dob=$_POST['dob'];
$phone=$_POST['phone'];
//$action=$_POST['action'];
$username=$_POST['username'];
$dateadded=date('d/m/Y');

if (strlen($username) == 0){
    die("Session Expired! Please login again! <a href='index.php'>Login Again</a>");
}

$query = "INSERT INTO beneficiarymaster(nationalid,firstname,surname,phone,idhousehold,dob,addedby,reg_date) VALUES ('$nationalid','$firstname','$surname',$phone,'$hhnationalid','$dob','$username','$dateadded')";  
$result = pg_query($query);
        if (!$result) {
            $errormessage = pg_last_error();
            echo "Error with query: " . $errormessage;
            exit();
        }
        $msg="success";
        pg_close(); 

header("Location: beneficiaryadd.php?msg='$msg'");    
pg_close(); 
?>

