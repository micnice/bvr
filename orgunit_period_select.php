<table  style="margin:auto auto;background-color: #E0F277;width: 400px; text-align: left">
        <tr>
            <td style="width: 200px"><font size="4">Period</font></td>
            <td style="width: 200px"> <select name="period" id="period">
                <?php
                include 'dbconnect.php';
                $sql = pg_query($conn,"SELECT monthcode,monthname,yearname FROM period order by yearname desc,monthcode asc");
                echo '<option value="000">---Select Period---</option>';
                while ($row = pg_fetch_assoc($sql)) {
                echo '<option value="'.htmlspecialchars($row['monthcode']).'">'.htmlspecialchars($row['monthname'])." ".htmlspecialchars($row['yearname']).'</option>';}
                //pg_close($conn);
                ?>
                </select> 
                <input type="hidden" name="yearname" value="<?php echo $row['yearname']; ?>" />
            </td>
      </tr>  
        <tr>
            <td><font size="4">Distributor Name</font></td>
            <td> <select name="distributor" id="distributor">
                    <option value="">---Select Facility---</option>
                <?php
                include 'dbconnect.php';
                $sql = pg_query($conn,"SELECT idfacility,facilityname FROM facility order by facilityname asc");
                while ($row = pg_fetch_assoc($sql)) {
                echo '<option value="'.htmlspecialchars($row['idfacility']).'">'.htmlspecialchars($row['facilityname']).'</option>';}
                //pg_close($conn);
                ?>
                </select> 
            </td>
      </tr>
 <tr><td colspan="2" align="center"><input type="submit" value="Submit"></td></tr>
</table>
</div>