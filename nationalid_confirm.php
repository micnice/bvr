<?php
$newnationalid = $_POST['newnationalid'];
$oldnationalid = $_POST['oldnationalid'];
$mobi = $_POST['mobi'];

if ($mobi == 1) {
  $actionurl = 'nationalid_process.php';
} else {
  $actionurl = 'main.php?page=nationalid_process';
}
?>   <br/><br>
<div style="margin: auto">
    <h3>Please confirm that you want to alter the national ID of this
        patient</h3>
    From: <font style="color: red"><?php echo $oldnationalid; ?></font> To:
    <font style="color: green"><?php echo $newnationalid; ?></font>

    <form action="<?php echo $actionurl; ?>" method="POST">
        <input type="hidden" name="mobi" value="<?php echo $mobi; ?>">
        <input type="hidden" name="oldnationalid"
               value="<?php echo $oldnationalid; ?>">
        <input type="hidden" name="newnationalid"
               value="<?php echo $newnationalid; ?>">
        <input type="submit" value="Confirm Update">
    </form>
  <?php
  if ($mobi == 1) {
    echo "<h3><a href='mobi/verifyvoucher.php'>Home</a></h3>";
  }
  ?>
</div>
