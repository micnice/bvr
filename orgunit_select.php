<table style="background-color: #E0F277;">
    <tr>
        <td><font size="4">Distributor Name</font></td>
        <td><select name="distributor" id="distributor">
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
            </select>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input type="submit" value="Submit"></td>
    </tr>
</table>
</div>