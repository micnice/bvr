<table  style="background-color: #E0F277;">
        <tr>
            <td><font size="4">Period</font></td>
            <td> <select name="period" id="period" required>
                <option value="">---Select Period---</option>
		<option value="17q1">Q1 2017</option>
		<option value="17q2">Q2 2017</option>
		<option value="17q3">Q3 2017</option>
		<option value="17q4">Q4 2017</option>
                <option value="16q1">Q1 2016</option>
                <option value="16q2">Q2 2016</option>
                <option value="16q3">Q3 2016</option>
                <option value="16q4">Q4 2016</option>
                <option value="15q1">Q1 2015</option>
                <option value="15q2">Q2 2015</option>
                <option value="15q3">Q3 2015</option>
                <option value="15q4">Q4 2015</option>
                </select> 
                
            </td>
      </tr>  
        <tr>
            <td><font size="4">Distributor Name</font></td>
            <td> <select name="distributor" id="distributor" required>
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
