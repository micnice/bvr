<?php
include_once 'dbconnect.php';

$approve = $_POST['approve'];
$id = $_POST['id'];
$dest = $_POST['dest'];
$rejectreason = $_POST['reason'];
$distributor = $_POST['distributor'];
$period = $_POST['period'];

$query
    = "update voucherclaims set approval='$approve',rejectreason='$rejectreason' where idvoucherclaims=$id";


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

