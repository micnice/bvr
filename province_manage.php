<?php
include_once 'dbconnect.php';

$id=$_POST['id'];
$action=$_POST['action'];

//$action=$_POST['action'];

$query = "INSERT INTO beneficiarymaster(nationalid,firstname,surname,phone,idhousehold,dob) VALUES ('$nationalid','$firstname','$surname',$phone,'$hhnationalid','$dob')";  
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

