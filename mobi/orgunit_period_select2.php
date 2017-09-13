<table style="margin:auto 0;background-color: #E0F277;width: 300px">
    <tr>
        <td style="width: 100px"><font size="4">Period</font></td>
        <td><?php
          include 'dbconnect.php';
          $userrole = trim($_SESSION["userrole"]);
          //echo $userrole."/".$_SESSION['userrole'];
          ?>

            <select name="period" id="period" required>

              <?php
              $sql = pg_query(
                  $conn,
                  "SELECT monthcode,monthname,yearname FROM period"
              );
              while ($row = pg_fetch_assoc($sql)) {
                echo '<option value="'.htmlspecialchars($row['monthcode']).'">'
                    .htmlspecialchars($row['monthname'])." ".htmlspecialchars(
                        $row['yearname']
                    ).'</option>';
              }
              //pg_close($conn);
              ?>
            </select>

        </td>
    </tr>
    <tr>
        <td><font size="4">Facility</font></td>
        <td><select name="distributor" id="distributor" required>
            <?php
            include 'dbconnect.php';
            if (strcmp($userrole, "admin") == 0) {
              $sql = pg_query(
                  $conn,
                  "SELECT idfacility,facilityname FROM facility"
              );
            } else {
              $sql = pg_query(
                  $conn,
                  "SELECT idfacility,facilityname FROM facility where idfacility="
                  .$_SESSION['facility'].""
              );
            }
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