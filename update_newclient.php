<?php 
include 'dbconnect.php';
  

  $strSQL = "select nationalid,min(idredeemedvouchers) idredeemedvouchers from redeemedvouchers group by nationalid";
  echo $strSQL;
  $result = pg_exec($conn, $strSQL);
  $numrows = pg_numrows($result);
?>
 
<h3 style="text-align: center">List Of House Holds</h3>

<?php

   // Loop on rows in the result set.

   for($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    $idredeemed = $row["idredeemedvouchers"];
    $update_new="update redeemedvouchers set newclient=1 where idredeemedvouchers='$idredeemed'"; 
                
                try{
                    $result2 = pg_query($update_new);
                    echo ".";
                }
                
                catch (Exception $e){
                    echo $e."<br />";
                    //$stringData = "$registrationdate,$serialno,$surname,$firstname,$nationalid,$dob,$idhousehold,$hhfirstname,$hhsurname,$address,$suburb,$phone\n";
                    //fwrite($fh, $stringData); 
                }
    
   }
   pg_close($conn);
  ?>