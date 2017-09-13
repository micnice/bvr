<form action="main.php?page=vouchersaleslist_search" method="POST">
    <div><h3>View Voucher Sales</h3><br/>
        Facility: <select name="distributor" id="distributor">
            <option value="">---Select Facility---</option>
        <?php
        include 'dbconnect.php';
        $sql = pg_query(
            $conn,
            "SELECT idfacility,facilityname FROM facility order by facilityname asc"
        );
        while ($row = pg_fetch_assoc($sql)) {
          echo '<option value="'.htmlspecialchars($row['idfacility']).'">'
              .htmlspecialchars($row['facilityname']).'</option>';
        }
        //pg_close($conn);
        ?>
        </select> <input type="submit" value="View Voucher Sales">
    </div>

</form>