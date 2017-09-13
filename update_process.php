<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'dbconnect.php';

$strSQL
    = "select idredeemedvouchers,redeemdate from redeemedvouchers where length(trim(redeemdate))<10 and length(trim(redeemdate))>4";
//echo $strSQL;
$result = pg_exec($conn, $strSQL);
$numrows = pg_numrows($result);

for ($i = 0; $i < $numrows; $i++) {
  $row = pg_fetch_array($result, $i);
  $redeemdate = $row["redeemdate"];
  $idRedeem = $row["idredeemedvouchers"];
  $splitRedeemdate = explode('-', trim($redeemdate));
  $day = str_pad($splitRedeemdate[0], 2, '0', STR_PAD_LEFT);
  $month = str_pad($splitRedeemdate[1], 2, '0', STR_PAD_LEFT);
  $year = str_pad($splitRedeemdate[2], 4, '20', STR_PAD_LEFT);

  $period = intval($month) + 24;
  $newRedeemdate = $day.'-'.$month.'-'.$year;

  $query
      = "UPDATE redeemedvouchers set periodid=$period,redeemdate='$newRedeemdate' where idredeemedvouchers=$idRedeem";

  echo '<br />'.$query.';<br />';
  /*
   $result = pg_query($query);
   if (!$result) {
       $errormessage = pg_last_error();
       echo "Error with query: " . $errormessage;
       exit();
   }*/

  //echo "<br />Update Successful<br />";
}
echo "<br />Update Successful<br />";
?>
