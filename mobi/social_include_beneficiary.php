<tr class="lime">
    <td><font size="4">Patient National ID:</font></td>
    <td colspan="3">

      <?php
      if (strcmp($beneficiary, 'new') == 0) {
        ?>

          <input type="text" name="nationalid" id="nationalid" value="">

        <?php
      } else {
        ?>

          <input type="hidden" name="nationalid" id="nationalid"
                 value="<?php echo trim($nationalid); ?>"><?php echo trim(
            $nationalid
        ); ?>
        <?php
      }
      ?>
        <a href="main.php?page=nationalid_edit&nationalid=<?php echo trim(
            $nationalid
        ); ?>">Edit</a></td>

</tr>
<tr class="lime">
    <td><font size="4">Surname</font></td>
    <td><input type="text" size="30" maxlength="50" name="surname"
               value="<?php echo trim($surname); ?>" required></td>
    <td><font size="4">Other Names</font></td>
    <td><input type="text" size="40" maxlength="40" name="firstname"
               value="<?php echo trim($firstname); ?>" required></td>
</tr>
<tr class="lime">
    <td><font size="4">DOB:</font><input type="text" size="11" maxlength="11"
                                         name="dob" id="dob"
                                         value="<?php echo trim($dob); ?>"
                                         pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}"
                                         placeholder="dd/mm/yyyy"
                                         onblur="getAge()">,
        Age:<input type="text" id="age" value="" size="6"
                   onblur="getDob()"><input id="checkage" type="checkbox"
                                            onclick="enableAge()"></td>
    <td><font size="4">Sex:</font>
        <select name="period">
            <option value="F">Female</option>
        </select>
    </td>
    <td><font size="4">LMP:</font><input type="text" size="11" maxlength="11"
                                         name="lmp"
                                         value="<?php echo trim($lmp); ?>"
                                         id="lmp"
                                         pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}"
                                         placeholder="dd/mm/yyyy"
                                         onblur="getEdd()" required></td>
    <td><font size="4">EDD:</font> <input type="hidden" size="11" maxlength="11"
                                          value="" name="edd" id='edd'
                                          pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}"
                                          placeholder="dd/mm/yyyy"><span
                id="displayedd"><?php echo trim($edd); ?></span></td>
</tr>
<tr class="lime">
    <td><font size="4">Guardian's Name for Minor Patients:</font></td>
    <td><input type="text" size="30" maxlength="50"
               value="<?php echo trim($guardian); ?>" name="guardian"></td>
    <td><font size="4">Marital Status:</font></td>
    <td><input type="text" size="40" maxlength="40"
               value="<?php echo trim($maritalstatus); ?>" name="maritalstatus">
    </td>
</tr>
<tr class="lime">
    <td><font size="4">Parity:</font></td>
    <td colspan="3"><input type="text" size="30" maxlength="50"
                           value="<?php echo trim($parity); ?>" name="parity">
    </td>
</tr>
<tr class="lime">
    <td><font size="4">Location:</font></td>
    <td><input type="text" size="30" maxlength="50"
               value="<?php echo trim($location); ?>" name="location"></td>
    <td><font size="4">Village:</font></td>
    <td><input type="text" size="40" maxlength="40"
               value="<?php echo trim($village); ?>" name="village"></td>
</tr>
<tr class="lime">
    <td><font size="4">Certificate of Eligibility:</font></td>
    <td><input type="text" size="30" maxlength="50"
               value="<?php echo trim($serialno); ?>" name="serialno"></td>
    <td><font size="4">Phone:</font></td>
    <td><input type="text" size="40" maxlength="40"
               value="<?php echo trim($phone); ?>" name="phone"></td>
</tr>
<tr class="lime">
    <td><font size="4">Postal Address:</font></td>
    <td colspan="3"><input type="text" size="50" maxlength="50"
                           value="<?php echo trim($postaladdress); ?>"
                           name="postaladdress"></td>

</tr>
<tr class="lime">
    <td><font size="4">City:</font></td>
    <td><select name="city" id="city" required>
            <option value="">---Select City---</option>
            <option value="Harare" <?php if (strcmp($city, 'Harare') == 0) {
              echo 'selected';
            } ?>>Harare
            </option>
            <option value="Bulawayo" <?php if (strcmp($city, 'Bulawayo') == 0) {
              echo 'selected';
            } ?>>Bulawayo
            </option>
        </select>
    </td>
    <td></td>
    <td></td>
</tr>

<script type="text/javascript">
    $(document).ready(function () {
        $('#saleate').datepicker();
        $('#dob').datepicker();
        $('#lmp').datepicker();
        $('#edd').datepicker();
    });

    function getEdd() {
        var tt = document.getElementById('lmp').value;
        if (tt.length === 10) {
            var parts = tt.split("/");

            var date = new Date(parts[2], parts[1], parts[0]);
            var newdate = new Date(date);

            newdate.setDate(newdate.getDate() + 280);

            var cuttoff = new Date("December 31, 2018 00:00:00");

            document.getElementById('submitbutton').disabled = true;

            if (newdate > cuttoff) {
                document.getElementById('displayedd').innerHTML = '<font color=red>Cut-Off Exceeded!<br /> Beneficiary can not be enrolled!</font>';
                document.getElementById('submitbutton').disabled = true;
            } else {
                document.getElementById('submitbutton').disabled = false;
                var dd = ("0" + newdate.getDate()).slice(-2);
                var mm = ("0" + (newdate.getMonth() + 1)).slice(-2);
                var y = newdate.getFullYear();

                var someFormattedDate = dd + '/' + mm + '/' + y;
                document.getElementById('edd').value = someFormattedDate;
                document.getElementById('displayedd').innerHTML = someFormattedDate;
            }
        }
    }

    function getDob() {
        var age = document.getElementById('age').value;

        if (age > 12 && age < 55) {
            age = age * 365;
            var date = new Date('<?php echo date('Y-m-d'); ?>');
            var newdate = new Date(date);

            newdate.setDate(newdate.getDate() - age);

            var dd = ("0" + newdate.getDate()).slice(-2);
            var mm = ("0" + (newdate.getMonth() + 1)).slice(-2);
            var y = newdate.getFullYear();

            var someFormattedDate = dd + '/' + mm + '/' + y;
            document.getElementById('dob').value = someFormattedDate;
        }
    }


    function getAge() {
        var dob = document.getElementById('dob').value;
        if (dob.length === 10) {
            var date = new Date('<?php echo date('Y-m-d'); ?>');
            var newdate = new Date(date);

            var parts = dob.split("/");

            var date2 = new Date(parts[2], parts[1], parts[0]);
            var newdate2 = new Date(date2);

            var age = (date - date2) / (60 * 60 * 24 * 1000 * 365);

            //document.writeln(age);
            document.getElementById('age').value = Math.floor(age);
            document.getElementById('age').disabled = true;
        }
    }

    function enableAge() {
        document.getElementById('age').disabled = false;
        document.getElementById('age').value = "";
    }
</script>
