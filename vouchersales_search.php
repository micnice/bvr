<?php 
include "dbconnect.php";

    $firstname=strtolower(trim($_POST['firstname']));
    $surname=strtolower(trim($_POST['surname']));
     $nationalid=strtolower(trim($_POST['nationalid']));

    if(strlen($nationalid)==0){ 
        $strSQL = "SELECT * From beneficiarymaster where lower(trim(nationalid)) not in (select lower(trim(nationalid)) from vouchersales) and ((lower(firstname) like '%$firstname%' and lower(surname) like '%$surname%') or (lower(firstname) like '%$surname%' and lower(surname) like '%$firstname%')) limit 100";
    }else{
        $strSQL = "SELECT * From beneficiarymaster where lower(trim(nationalid)) not in (select lower(trim(nationalid)) from vouchersales) and lower(trim(nationalid)) like '%$nationalid%' limit 100";
    }
    
    //echo $strSQL."<br />";
    
    $result = pg_exec($conn, $strSQL);
    $numrows = pg_numrows($result);
    
    $strBeneficiary = "SELECT * From beneficiarymaster where lower(trim(nationalid)) like '%$nationalid%' and length(trim('$nationalid'))>=10 limit 100";
    //echo $strBeneficiary;

    $resultBeneficiary = pg_exec($conn, $strBeneficiary);
    $numRowsBeneficiary = pg_numrows($resultBeneficiary);
?>
 
<h3 style="text-align: center">Search Results</h3>

<table style="margin:auto auto; text-align: left;">
<tr style="background-image: url(images/green_bg.png);">  
   <th>First Name</th>
   <th>Last Name</th>
   <th>National ID</th>
   <th>Address</th>
   <th></th>
</tr>

<?php

   // Loop on rows in the result set.

   for($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    ?>
        <tr>
           <td><?php echo $row["firstname"]; ?> </td>
           <td><?php echo $row["surname"]; ?> </td>
           <td><?php echo $row["nationalid"]; ?> </td>
           <td><?php echo $row["location"].', '.$row["village"].', '. $row["area"]; ?> </td>
           <td> 
               <form action="main.php?page=vouchersales" method="POST">
                <input type="hidden" name="nationalid" value="<?php echo $row["nationalid"]; ?>">
                <input type="submit" value="Enter Sale">
                </form>
               </td>
        </tr>
<?php
  }
   pg_close($conn);
  ?>
</table>
  
  <?php 
    if($numrows==0){
      if($numRowsBeneficiary==0){
          echo "<font color='red'><h2>Beneficiary Does not Exist</h2></font>";
      }else{
          echo "<font color='red'><h2>Beneficiary Exists But has already bought a Voucher!</h2></font>";
      }
    }
  
  ?>

</table>
    <form action="main.php?page=vouchersales" method="POST">
        <input type="hidden" name="nationalid" value="No ID">
        <input type="submit" value="Enter New Beneficiary">
    </form>
  </div>