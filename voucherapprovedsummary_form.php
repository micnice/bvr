<form action="voucherapprovedsummary.php" method="POST">
    <div align="center"><h3>Select Period to View Approved Summary</h3><br/>
        <table style="background-color: #E0F277;">
            <tr>
                <td><font size="4">Period</font></td>
                <td><select name="period" id="period" required>
                    <?php
                    include 'dbconnect.php';
                    $sql = pg_query(
                        $conn,
                        "SELECT monthcode,monthname,yearname FROM period order by monthcode asc"
                    );
                    echo '<option value="">---Select Period---</option>';
                    while ($row = pg_fetch_assoc($sql)) {
                      echo '<option value="'.htmlspecialchars($row['monthcode'])
                          .'">'.htmlspecialchars($row['monthname'])." "
                          .htmlspecialchars($row['yearname']).'</option>';
                    }
                    //pg_close($conn);
                    $periodname = htmlspecialchars($row['monthname'])." "
                        .htmlspecialchars($row['yearname']);
                    echo '<option value="0">---Up to Date---</option>';
                    ?>
                    </select>

                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="Submit"></td>
            </tr>
        </table>
    </div>