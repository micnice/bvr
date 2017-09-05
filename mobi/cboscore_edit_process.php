<?php
include_once 'dbconnect.php';

$serialno=trim($_POST['serialno']);
            
    $query = "delete from cboscore where serialno='$serialno'";  
    
    //echo '<br />'.$query.'<br />';
    $result = pg_query($query);
            if (!$result) {
                $errormessage = pg_last_error();
                echo "Error with query: " . $errormessage;
                exit();
            }

echo "<h3><font color='green'>Records updated Successfully</font></h3><a href='main.php?page=cboscore_edit_form'>Next Questionnaire</a>";
pg_close(); 
?>

