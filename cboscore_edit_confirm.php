<?php
include_once 'dbconnect.php';

$serialno=trim($_POST['serialno']);

$query = "select facilityname,monthname,yearname,sum(q1+q2+q3+q4+q5+q6) score from cboscore a,period b,facility c "
    . " where serialno='$serialno' and facilityid=idfacility and a.periodid=b.monthcode group by facilityname,monthname,yearname";

            $result = pg_query($conn, $query);
            //echo $query;
            if(pg_num_rows($result) != 1) {
                header("Location: index.php?login=fail");
                echo "<h2 style='text-align: center;'>The Questionnaire with serial <em style='color:red'>$serialno</em> does not exist</h2>";
                die();
            } else {
                $facilityname=pg_fetch_result($result, 0, 0);
                $monthname=pg_fetch_result($result, 0, 1);
                $yearname=pg_fetch_result($result, 0, 2);
                $score=pg_fetch_result($result, 0, 3);
            }
?>
<br /><br />
<table style="border: 1px;">
    <tr>
        <td colspan="2"><h2>Confirm Questionnaire Deletion</h2></td>
    </tr>
    <tr>
        <td>Serial No.</td><td><em style='color:red'><?php echo $serialno; ?></em></td>
    </tr>
    <tr>
        <td>Facility</td><td><?php echo $facilityname; ?></td>
    </tr>
    <tr>
        <td>Period</td><td><?php echo $monthname.' '.$yearname; ?></td>
    </tr>
    <tr>
        <td>Score</td><td><?php echo $score.' / 45'; ?></td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: center">
            <form action="main.php?page=cboscore_edit_process" method="POST">
                <input type="hidden" name="serialno" value="<?php echo $serialno; ?>" />
                <input type="submit" value="Delete Questionnaire" />
            </form>
        </td>
    </tr>
</table>
<?php
pg_close(); 
?>

