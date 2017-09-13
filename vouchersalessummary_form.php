<form action="main.php?page=vouchersalessummary" method="POST">
    <div align="center"><h3>View Voucher Sales Summary</h3><br/>
        <table style="background-color: #E0F277;">
            <tr>
                <td><font size="4">District Name</font></td>
                <td><select name="district" id="district" required>
                        <option value="">---Select District---</option>
                        <option value="Harare">Harare South District</option>
                        <option value="Nkulumane">Nkulumane District</option>

                    </select>
                </td>
            </tr>
            <tr>
                <td><font size="4">Start Date</font></td>
                <td>
                    <input name="startdate" type="text" size="15">
                </td>
            </tr>
            <tr>
                <td><font size="4">End Date</font></td>
                <td>
                    <input name="enddate" type="text" size="15">
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit"
                                                      value="Submit"></td>
            </tr>
        </table>
    </div>
</form>