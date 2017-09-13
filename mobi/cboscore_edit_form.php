<?php
include_once 'dbconnect.php';
?>
<form action="main.php?page=cboscore_edit_confirm" method="POST"><br/><br/>

    <table>
        <tr>
            <td colspan="2" style="text-align: center;"><h2>Delete
                    Questionnaire</h2></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">Questionnaire Serial:
                <input type="text" name="serialno"/></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;"><input type="submit"
                                                               value="Delete Questionnaire"/>
            </td>
        </tr>
    </table>
</form>

