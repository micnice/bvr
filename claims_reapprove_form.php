<form action="main.php?page=claimsapprove_process" method="POST">
<div align="center"><h3>Select New Period for Re-Approval</h3><br />


<?php    
    $approve = trim($_GET['approve']);
    $id = trim($_GET['id']);
    $dest = trim($_GET['dest']);
    $distributor = trim($_GET['distributor']);
    $facilityname = trim($_GET['facilityname']);
    $vouchername = trim($_GET['vouchername']);
    $nationalid = trim($_GET['nationalid']);
    $voucherserial = trim($_GET['voucherserial']);
?>
    <table>
        <tr>
            <td>Voucher Serial:</td><td><?php echo $voucherserial; ?></td>
        </tr>
        <tr>
            <td>Voucher Type:</td><td><?php echo $vouchername; ?></td>
        </tr>
        <tr>
            <td>National ID:</td><td><?php echo $nationalid; ?></td>
        </tr>
        <tr>
            <td>Facility:</td><td><?php echo $facilityname; ?></td>
        </tr>
    </table>
    <br /><br />
<input type="hidden" name="approve" value="<?php echo $approve ?>">
<input type="hidden" name="id" value="<?php echo $id ?>">
<input type="hidden" name="dest" value="<?php echo $dest ?>">
<input type="hidden" name="distributor" value="<?php echo $distributor ?>">

    <?php include 'period_select.php'; ?>
</div>
</form>