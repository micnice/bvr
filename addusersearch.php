<?php 
include 'dbconnect.php';

    if(isset($_GET['q']) && !empty($_GET['q'])){
        $key=  strtolower(trim($_GET['q']));
    }else{
        $key="";
    }
    
  if (strlen(trim($key))> 0){
      $strSQL = "select username,firstname,surname,userrole,facilityname from users,facility where facility=idfacility and lower(username) like '%".$key."%' limit 100";
  }else{
      $strSQL = "select username,firstname,surname,userrole,facilityname from users,facility where facility=idfacility limit 100";
  }
  //echo $strSQL;
  $result = pg_exec($conn, $strSQL);
  $numrows = pg_numrows($result);
?>
 
<h3 style="text-align: center">List Of Users</h3>
<table>
<tr style="background-image: url(images/green_bg.png);">  
   <th>Username</th>
   <th>First Name</th>
   <th>Last Name</th>
   <th>Facility</th>
   <th>User role</th>
   <th></th>
</tr>

<?php

   // Loop on rows in the result set.

   for($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    ?>
        <tr>
           <td><?php echo $row["username"]; ?> </td>
           <td><?php echo $row["firstname"]; ?> </td>
           <td><?php echo $row["surname"]; ?> </td>
           <td><?php echo $row["facilityname"]; ?> </td>
           <td><?php echo $row["userrole"]; ?> </td>
           <td> <a href="main.php?page=adduseredit&username=<?php echo trim($row["username"]);?>">Edit</a> </td>
        </tr>
<?php
  }
   pg_close($conn);
  ?>
</table>