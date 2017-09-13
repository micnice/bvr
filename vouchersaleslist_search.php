<?php
include 'dbconnect.php';


$vserial = 0;
$facility = 0;

if (isset($_POST['distributor']) || ! empty($_POST['distributor'])) {
  $distributor = trim($_POST['distributor']);
  $facility = 1;
  if (strlen($_POST['distributor']) < 1) {
    $facility = 0;
  }

}

if (isset($_POST['voucherserial']) || ! empty($_POST['voucherserial'])) {
  $voucherserial = $_POST['voucherserial'];
  $vserial = 1;
  if (strlen($_POST['voucherserial']) < 1) {
    $vserial = 0;
  }
}

if ($vserial == 1) {
  $strSQL
      = "select a.firstname,a.surname,a.nationalid,a.location,b.voucherserial,b.saledate,a.serialno,a.phone,b.distributorno,c.facilityname from beneficiarymaster a, vouchersales b, facility c where "
      ." a.nationalid=b.nationalid and b.distributorno=c.idfacility and b.voucherserial=$voucherserial";
}

if ($facility == 1) {
  $strSQL
      = "select a.firstname,a.surname,a.nationalid,a.location,b.voucherserial,b.saledate,a.serialno,a.phone,b.distributorno,c.facilityname from beneficiarymaster a, vouchersales b, facility c where "
      ."b.distributorno=$distributor and a.nationalid=b.nationalid and b.distributorno=c.idfacility";
}
//echo $strSQL.'<br />';

$result = pg_exec($conn, $strSQL);
$numrows = pg_numrows($result);
$facilityname = "";
?>

<h3 style="text-align: center">List Of Beneficiaries
    <br/><br/><span id="facility"></span>
</h3>
<div align="center">
    <form action="main.php?page=vouchersaleslist_search" method="POST">
        Search by Voucher Serial: <input type="text" name="voucherserial"
                                         size="15">
        <input type="submit" value="Search">
    </form>
</div>
<table>
    <tr style="background-image: url(images/green_bg.png);">
        <th>First Name</th>
        <th>Last Name</th>
        <th>National ID</th>
        <th>Certificate Serial</th>
        <th>Voucher Serial</th>
        <th>Sale Date</th>
        <th>Phone #</th>
        <th>Address</th>
        <th></th>
    </tr>

  <?php

  // Loop on rows in the result set.

  for ($i = 0; $i < $numrows; $i++) {
    $row = pg_fetch_array($result, $i);
    $facilityname = $row['facilityname'];
    ?>
      <tr>
          <td><?php echo $row["firstname"]; ?> </td>
          <td><?php echo $row["surname"]; ?> </td>
          <td><?php echo $row["nationalid"]; ?> </td>
          <td><?php echo $row["serialno"]; ?> </td>
          <td><?php echo $row["voucherserial"]; ?> </td>
          <td><?php echo $row["saledate"]; ?> </td>
          <td><?php echo $row["phone"]; ?> </td>
          <td><?php echo $row["location"]; ?> </td>
          <td>
              <form action="main.php?page=vouchersales" method="POST">
                  <input type="hidden" name="nationalid"
                         value="<?php echo $row["nationalid"]; ?>">
                  <input type="submit" value="Edit Sale">
              </form>
          </td>
      </tr>
    <?php
  }
  ?>
    <script type="text/javascript">
        document.getElementById("facility").innerHTML = "<?php echo $facilityname; ?>";
    </script>
  <?php
  pg_close($conn);
  ?>
</table>