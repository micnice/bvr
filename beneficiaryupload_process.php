<?php

include "dbconnect.php"; //Connect to Database
//
//Upload File
$filename = str_replace(' ', '_', $_FILES['beneficiary']['name']);

if (is_uploaded_file($_FILES['beneficiary']['tmp_name'])) {
  echo "<h1>"."File ".$_FILES['beneficiary']['name']." uploaded successfully."
      ."</h1>";
}

$uploadfilename = $_FILES['beneficiary']['name'];
//Import uploaded file to Database
$handle = fopen($_FILES['beneficiary']['tmp_name'], "r");

//File Import format: Reg Date, Certificate No.,Surname ,Other names,National ID,DOB,Household Head ID Number,HH Firstname, HH Surname, Address,Suburb,Area,Phone Number,City


while (($data = fgetcsv($handle, 1000, ",")) !== false) {
  $bvrnumber = 0;
  $registrationdate = $data[0];
  if ($registrationdate == '') {
    $registrationdate = 'null';
  }

  $serialno = $data[1];
  if ($serialno == '') {
    $serialno = 'null';
  }

  $surname = $data[2];
  if ($surname == '') {
    $surname = 'null';
  }

  $firstname = $data[3];
  if ($firstname == '') {
    $firstname = 'null';
  }

  $nationalid = str_replace(' ', '', str_replace('-', '', $data[4]));

  $dob = $data[5];
  if ($dob == '') {
    $dob = 'null';
  }
  $dob = str_replace(' ', '', str_replace('-', '/', $data[5]));

  $idhousehold = str_replace(' ', '', str_replace('-', '', $data[6]));
  if ($idhousehold == '') {
    $idhousehold = 'null';
  }

  $hhfirstname = $data[7];
  if ($hhfirstname == '') {
    $hhfirstname = 'null';
  }

  $hhsurname = $data[8];
  if ($hhsurname == '') {
    $hhsurname = 'null';
  }

  $location = $data[9];
  if ($location == '') {
    $location = 'null';
  }

  $suburb = $data[10];
  if ($suburb == '') {
    $suburb = 'null';
  }

  $area = $data[11];
  if ($area == '') {
    $area = 'null';
  }

  $phone = $data[12];
  if ($phone == '') {
    $phone = 'null';
  }

  $city = $data[13];
  if ($city == '') {
    $city = 'null';
  }

  $lmp = $data[14];
  if ($lmp == '') {
      $lmp = null;
  }

  $parity = $data[15];
  if ($parity == '') {
      $parity = null;
  }

  $maritalStatus = $data[16];
  if ($maritalStatus == '') {
      $maritalStatus = null;
  }

  if (is_numeric($phone)) {
  } else {
    $phone = 0;
  }
  //echo $nationalid." -> ".strlen($nationalid)."<br />";
  include 'generate_nationalid.php';

  $username = $_SESSION['username'];

  date_default_timezone_set('Africa/Harare');
  $uploadtime = date('d/m/Y h:i');
  $delrec = "DELETE from beneficiarymaster where nationalid='$nationalid'";
  $import
      = "INSERT into beneficiarymaster (serialno,surname,firstname,dob,nationalid,idhousehold,location,village,area,city,phone,bvrnumber,reg_date,uploadtime,uploadfilename,addedby, lmp, parity, maritalstatus)"
      ." values($serialno,'$surname','$firstname','$dob','$nationalid','$idhousehold','$location','$suburb','$area','$city',$phone,$bvrnumber,'$registrationdate','$uploadtime','$uploadfilename','$username','$lmp','$parity','$maritalStatus')";

  try {
    $result1 = pg_query($delrec);
    $result2 = pg_query($import);

    //echo "<br />".$import;
    echo ".";
    //echo $nationalid." -> ".$bvrnumber."<br />";
    //exit();
  } catch (Exception $e) {
    echo $e."<br />";
    //$stringData = "$registrationdate,$serialno,$surname,$firstname,$nationalid,$dob,$idhousehold,$hhfirstname,$hhsurname,$address,$suburb,$phone\n";
    //fwrite($fh, $stringData);
  }
}

pg_close();
fclose($fh);

print "Import done";

//view upload form

?>