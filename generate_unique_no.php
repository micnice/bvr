<?php
$checkbvr = substr($nationalid, 0, 3);
if ((strcmp($checkbvr, 'BVR') == 0 && strlen($nationalid) == 10)
    || strlen(
        $nationalid
    ) == 11
    || strlen($nationalid) == 12
) {
} else {
  $strSQL = "select coalesce(max(redeemserial),0) from redeemedvouchers";
  $result = pg_exec($conn, $strSQL);
  $row = pg_fetch_row($result);

  $uniquenumber = $row[0];
  if ($uniquenumber < 100000) {
    $uniquenumber = 100000;
  }
  if ($uniquenumber >= 100000) {
    $uniquenumber = $uniquenumber + 1;
  }
}
?>