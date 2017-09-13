<?php
include_once 'dbconnect.php';

$adduser = trim($_POST['adduser']);
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$firstname = trim($_POST['firstname']);
$surname = trim($_POST['surname']);
$organisation = trim($_POST['organisation']);
$userrole = trim($_POST['userrole']);
$facility = trim($_POST['facility']);

if (strcmp($adduser, 'update') == 0) {
  $query
      = "UPDATE users SET username='$username', password=md5('$password'), firstname='$firstname',surname='$surname'"
      .", organisation='$organisation', userrole=$userrole";

  //echo '<br />'.$query.'<br />';
  $result = pg_query($query);
  if ( ! $result) {
    $errormessage = pg_last_error();
    echo "Error with query: ".$errormessage;
    exit();
  }
} else {
  if (strcmp($adduser, 'new') == 0) {
    if (strcmp($facility, '0') == 0) {
      $query
          = "insert into users (username,password,firstname,surname,organisation,userrole) "
          ."values('$username',md5('$password'),'$firstname','$surname','$organisation','$userrole')";
    } else {
      $query
          = "insert into users (username,password,firstname,surname,organisation,userrole,facility) "
          ."values('$username',md5('$password'),'$firstname','$surname','$organisation','$userrole',$facility)";
    }

    //echo '<br />'.$query.'<br />';

    $result = pg_query($query);

    if ( ! $result) {
      $errormessage = pg_last_error();
      echo "Error with query: ".$errormessage;
      exit();
    }
  }
}

echo "<h3><font color='green'>User records updated successfully</font></h3>";
pg_close();
?>
