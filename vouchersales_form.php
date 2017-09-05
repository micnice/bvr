
<form action="main.php?page=vouchersales_search" method="POST" id='searchform'>
<h3>Add / Edit Voucher Sales</h3>
    <div>
        <em>Search using a combination of Firstname and Surname OR with just ID number</em>
        <table  style="margin:auto 0;background-color: #E0F277;width: 300px;">
            <tr>
                    <td style="width: 100px;">National ID: </td><td><input type='text' id='nationalid' name='nationalid'></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">OR </td></td>
            </tr>
            <tr>
                <td style="width: 100px">First name: </td><td><input type='text' id='firstname' name='firstname'></td>
            </tr>
            <tr>
                <td>Surname: </td><td><input type='text' id='surname' name='surname'></td>
            </tr>
            
            <tr><td colspan="2" align="center"><input type="submit" value="Search"></td></tr>
        </table>
    </div>  
</form>