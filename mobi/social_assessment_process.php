<?php
include_once 'dbconnect.php';

$f112 = $_POST['f112'];
$f113 = $_POST['f113'];
$f114 = $_POST['f114'];
$f115 = $_POST['f115'];
$f116a = $_POST['f116a'];
$f116b = $_POST['f116b'];
$f117 = $_POST['f117'];
$f118 = $_POST['f118'];
$f119 = $_POST['f119'];
$f120 = $_POST['f120'];
$f121 = $_POST['f121'];
$nationalid = $_POST['nationalid'];
$update = $_POST['update'];

if(trim($f112)==''){$f112='null';}
if(trim($f113)==''){$f113='null';}
if(trim($f114)==''){$f114='null';}
if(trim($f115)==''){$f115='null';}
if(trim($f116a)==''){$f116a='null';}
if(trim($f116b)==''){$f116b='null';}
if(trim($f117)==''){$f117='null';}
if(trim($f118)==''){$f118='null';}
if(trim($f119)==''){$f119='null';}
if(trim($f120)==''){$f120='null';}
if(trim($f121)==''){$f121='null';}

$username = $_SESSION['username'];
$dateadded = date("d/m/Y");

if(strcmp($update,'no')==0){
    $query = "INSERT INTO assessment(f112,f113,f114,f115,f116a,f116b,f117,f118,f119,f120,f121,nationalid,assessor,dateadded) "
            . " VALUES ($f112,$f113,$f114,$f115,$f116a,$f116b,$f117,$f118,$f119,$f120,$f121,'$nationalid','$username','$dateadded')"; 
}else{
    $query = "update assessment set f112=$f112,f113=$f113,f114=$f114,f115=$f115,f116a=$f116a,f116b=$f116b,f117=$f117,f118=$f118,f119=$f119,f120=$f120,f121=$f121"
            ." where nationalid='$nationalid'";
}



$result = pg_query($query);
        if (!$result) {
            $errormessage = pg_last_error();
            echo "Error with query: " . $errormessage;
            exit();
        }
        $msg="success";
        echo "Assessment Saved to Database";
        $assessment_score=$f112+$f113+$f114+$f115+$f116a+$f116b+$f117+$f118+$f119+$f120+$f121;
        
        $location='';
        $assess = pg_query($conn, "SELECT city FROM beneficiarymaster WHERE nationalid='$nationalid'");
        while ($row = pg_fetch_row($assess)) {
           $location=trim($row[0]);
        }
        if($assessment_score>3 || strcmp($city,'Bulawayo')==0){
            $query = "update beneficiarymaster set assessment='Y' where nationalid='$nationalid'";
        }else{
            $query = "update beneficiarymaster set assessment='N' where nationalid='$nationalid'";
        }
        $result = pg_query($query);
        if (!$result) {
            $errormessage = pg_last_error();
            echo "Error with query: " . $errormessage;
            exit();
        }
        pg_close(); 

header("Location: social_vouchersales_search.php?nationalid=$nationalid");     
?>

