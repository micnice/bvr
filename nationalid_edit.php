<?php
$nationalid = $_GET['nationalid'];

$source = $_GET['source'] ?: 'site';
$mobi = 0;

if (strcasecmp($source, 'mobi') == 0) {
  $actionurl = 'nationalid_confirm.php';
  $mobi = 1;
} else {
  $actionurl = 'main.php?page=nationalid_confirm';
  $mobi = 0;
}
?><br/><br>
<div style="margin: auto">
    <form action="<?php echo $actionurl; ?>" method="POST">
        <input type="hidden" name="mobi" value="<?php echo $mobi; ?>">
        <h3>Update National ID of Beneficiary</h3>

        <table>
            <tr>
                <td>Old National ID</td>
                <td><input type="hidden" name="oldnationalid"
                           value="<?php echo $nationalid; ?>"><?php echo $nationalid; ?>
                </td>
            </tr>
            <tr>
                <td>New National ID</td>
                <td><input type="text" name="newnationalid" value=""></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Submit"></td>
            </tr>
        </table>
    </form>
  <?php
  //echo $mobi;
  if ($mobi == 1) {
    echo "<h3><a href='mobi/verifyvoucher.php'>Home</a></h3>";
  }
  ?>
</div>
