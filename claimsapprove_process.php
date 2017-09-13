<?php
include_once 'dbconnect.php';

if (isset($_POST['approve'])) {
  $approve = $_POST['approve'];
} else {
  $approve = $_GET['approve'];
}

if (isset($_POST['id'])) {
  $id = $_POST['id'];
} else {
  $id = $_GET['id'];
}

if (isset($_POST['dest'])) {
  $dest = $_POST['dest'];
} else {
  $dest = $_GET['dest'];
}


if (isset($_POST['distributor'])) {
  $distributor = $_POST['distributor'];
} else {
  $distributor = $_GET['distributor'];
}


if (isset($_POST['period'])) {
  $period = $_POST['period'];
} else {
  $period = $_GET['period'];
}


if (strcasecmp($approve, "no") == 0) {
  ?>
    <form action="main.php?page=rejectwithreason" method="POST"><br/><br/>
        <table>
            <tr>
                <td><font size="4">Rejection Reasons:</font></td>
                <td>
                    <select name="reason" id="reason" required>
                        <option value="">---Select Reason---</option>
                      <?php
                      $sql = pg_query(
                          $conn,
                          "SELECT idreason,rejectshortname FROM rejectreasons order by rejectshortname"
                      );
                      while ($row = pg_fetch_assoc($sql)) {
                        echo '<option value="'.htmlspecialchars(
                                $row['idreason']
                            ).'">'.htmlspecialchars($row['rejectshortname'])
                            .'</option>';
                      }
                      ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;"><input type="submit"
                                                                   value="Reject Claim"/>
                </td>
            </tr>
        </table>
        <input type="hidden" name="approve" value="<?php echo $approve; ?>"/>
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        <input type="hidden" name="dest" value="<?php echo $dest; ?>"/>
        <input type="hidden" name="distributor"
               value="<?php echo $distributor; ?>"/>
        <input type="hidden" name="period" value="<?php echo $period; ?>"/>
    </form>
  <?php
  exit();
}
if (strcasecmp($approve, "reapp") == 0) {
  $query
      = "update voucherclaims set approval='yes',periodid=$period where idvoucherclaims=$id";
} elseif (strcasecmp($approve, "yes") == 0) {
  $query
      = "update voucherclaims set approval='$approve' where idvoucherclaims=$id";
} elseif (strcasecmp($approve, "rev") == 0) {
  $query
      = "update voucherclaims set approval='$approve' where idvoucherclaims=$id";
}


//echo '<br />'.$query.'<br />'.$approve;

$result = pg_query($query);
if ( ! $result) {
  $errormessage = pg_last_error();
  echo "Error with query: ".$errormessage;
  exit();
}
$msg = "success";
?>
<h2>Updated Successfully</h2>
<form action="main.php?page=claimsapprove" method="POST">
    <input type="hidden" name="distributor"
           value="<?php echo $distributor; ?>"/>
    <input type="hidden" name="period" value="<?php echo $period; ?>"/>
    <input type="submit" value="Proceed to List"/>
</form>
<?php
pg_close();
?>

