<?php
include 'dbconnect.php';
$period = trim($_POST['period']);
$year = trim($_POST['yearname']);
$orgunitid = trim($_POST['distributor']);

if (strcmp($periodid, '000') == 0) {
  pg_close();
  header("Location: main.php?page=qualitychecklist_form");
}
$result = pg_query($conn, "SELECT * FROM FACILITY WHERE idfacility=$orgunitid");
$result2 = pg_query($conn, "SELECT * FROM PERIOD WHERE monthcode=$period");

$orgunit = pg_fetch_result($result, 0, 'facilityname');
$monthname = pg_fetch_result($result2, 0, 'monthname');
$yearname = pg_fetch_result($result2, 0, 'yearname');
$periodname = $monthname.' '.$yearname;

$checklist = pg_query(
    $conn,
    "SELECT * FROM QUALITYCHECKLIST WHERE periodid=$period AND facilityid=$orgunitid"
);
$q1 = '';
$q2 = '';
$q3 = '';
$q4 = '';
$q5 = '';
$q6 = '';
$q7 = '';
$q8 = '';
$q9 = '';
$q10 = '';
$q11 = '';
$q12 = '';
$q13 = '';
$q14 = '';
$q15 = '';
$q16 = '';
$q17 = '';
$q18 = '';
$update = 'no';

while ($row = pg_fetch_row($checklist)) {
  $q1 = $row['0'];
  $q2 = $row['1'];
  $q3 = $row['2'];
  $q4 = $row['3'];
  $q5 = $row['4'];
  $q6 = $row['5'];
  $q7 = $row['6'];
  $q8 = $row['7'];
  $q9 = $row['8'];
  $q10 = $row['9'];
  $q11 = $row['11'];
  $q13 = $row['12'];
  $q14 = $row['13'];
  $q15 = $row['14'];
  $q16 = $row['15'];
  $q17 = $row['16'];
  $q18 = $row['17'];
  $update = 'yes';
}
?>
<div align="center"><h3>Health Centre Quality Checklist</h3>

    <form name="qualityChecklist"
          action="main.php?page=qualitychecklist_process" method="POST">
        <table style="background-color:#E0F277;">
            <tr>
                <td colspan="5"
                    style="text-align: center; background-color: rgb(255, 255, 102);"><?php echo 'Organisation Unit: <strong>'
                      .$orgunit.'</strong> Period: <strong>'.$periodname
                      .'</strong>'; ?></td>
            </tr>
            <tr>
                <td colspan="5"
                    style="background-image: url(images/green_bg.png);"><strong>STRUCTURAL
                        INDICATORS</strong></td>
            <tr>
                <td></td>
                <td><strong>Health Service Components</strong></td>
                <td style="text-align: center;"><strong>Available Point</strong>
                </td>
                <td style="text-align: center;"><strong>Actual Score</strong>
                </td>
                <td style="text-align: center;"><strong>Applicable</strong></td>
            </tr>
            <tr>
                <td>1</td>
                <td>General appearance</td>
                <td style="text-align: center;">8</td>
                <td style="text-align: center;"><input max="8" min="0"
                                                       type="number"
                                                       title="General Appearance"
                                                       value="<?php echo $q1; ?>"
                                                       size="4" name="q1"
                                                       id="q1"
                                                       onblur="totalQuality()"/>
                </td>
                <td style="text-align: center;"></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Administration and planning</td>
                <td style="text-align: center;">20</td>
                <td style="text-align: center;">
                    <input max="20" min="0" type="number"
                           title="Administration and Planning"
                           value="<?php echo $q2; ?>" size="4" name="q2" id="q2"
                           onblur="totalQuality()"/>
                </td>
                <td style="text-align: center;"></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Health information systems management</td>
                <td style="text-align: center;">21</td>
                <td style="text-align: center;"><input max="21" min="0"
                                                       type="number"
                                                       title="Health Information Systems management"
                                                       value="<?php echo $q3; ?>"
                                                       size="4" name="q3"
                                                       id="q3"
                                                       onblur="totalQuality()"/>
                </td>
                <td style="text-align: center;"></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Infection control and waste management</td>
                <td style="text-align: center;">16</td>
                <td style="text-align: center;"><input max="16" min="0"
                                                       type="number"
                                                       title="Infection control and waste management"
                                                       value="<?php echo $q4; ?>"
                                                       size="4" name="q4"
                                                       id="q4"
                                                       onblur="totalQuality()"/>
                </td>
                <td style="text-align: center;"></td>
            </tr>
            <tr>
                <td>5</td>
                <td>Out Patient Department/consultation area<br/>
                    (Childhood pneumonia, TB referral criteria, PEP)
                </td>
                <td style="text-align: center;">22</td>
                <td style="text-align: center;"><input max="22" min="0"
                                                       type="number"
                                                       title="Out Patient Department/Consultation area"
                                                       value="<?php echo $q5; ?>"
                                                       size="4" name="q5"
                                                       id="q5"
                                                       onblur="totalQuality()"/>
                </td>
                <td style="text-align: center;"></td>
            </tr>
            <tr>
                <td>6</td>
                <td>Family and Child Health (ANC, PNC, FP,<br/>
                    Immunizations)
                </td>
                <td style="text-align: center;">4</td>
                <td style="text-align: center;"><input max="4" min="0"
                                                       type="number"
                                                       title="Family and Child Health"
                                                       value="<?php echo $q6; ?>"
                                                       size="4" name="q6"
                                                       id="q6"
                                                       onblur="totalQuality()"/>
                </td>
                <td style="text-align: center;"></td>
            </tr>

            <tr>
                <td>7</td>
                <td>Maternity Service (routine maternal newborn<br/>
                    best practices, PPH, sepsis)
                </td>
                <td style="text-align: center;">14</td>
                <td style="text-align: center;"><input max="14" min="0"
                                                       type="number"
                                                       title="Maternity Service"
                                                       value="<?php echo $q7; ?>"
                                                       size="4" name="q7"
                                                       id="q7"
                                                       onblur="totalQuality()"
                                                       onblur="totalQuality()"/>
                </td>
                <td style="text-align: center;"><input name="q7applicable"
                                                       value="yes"
                                                       type="checkbox"
                                                       onclick="enable_q7(this.checked)">
                </td>
            </tr>
            <tr>
                <td>8</td>
                <td>Observation/inpatient services</td>
                <td style="text-align: center;">8</td>
                <td style="text-align: center;"><input max="8" min="0"
                                                       type="number"
                                                       title="Observation/inpatient services"
                                                       value="<?php echo $q8; ?>"
                                                       size="4" name="q8"
                                                       id="q8"
                                                       onblur="totalQuality()"/>
                </td>
                <td style="text-align: center;"><input name="q8applicable"
                                                       value="yes"
                                                       type="checkbox"
                                                       onclick="enable_q8(this.checked)">
                </td>
            </tr>
            <tr>
                <td>9</td>
                <td>Referral services</td>
                <td style="text-align: center;">8</td>
                <td style="text-align: center;"><input max="8" min="0"
                                                       type="number"
                                                       title="Referral services"
                                                       value="<?php echo $q9; ?>"
                                                       size="4" name="q9"
                                                       id="q9"
                                                       onblur="totalQuality()"/>
                </td>
                <td style="text-align: center;"></td>
            </tr>
            <tr>
                <td>10</td>
                <td>Community services</td>
                <td style="text-align: center;">12</td>
                <td style="text-align: center;"><input max="12" min="0"
                                                       type="number"
                                                       title="Community services"
                                                       value="<?php echo $q10; ?>"
                                                       size="4" name="q10"
                                                       id="q10"
                                                       onblur="totalQuality()"/>
                </td>
                <td style="text-align: center;"></td>
            </tr>
            <tr>
                <td>11</td>
                <td>Environmental health services</td>
                <td style="text-align: center;">8</td>
                <td style="text-align: center;"><input max="8" min="0"
                                                       type="number"
                                                       title="Environmental health services"
                                                       value="<?php echo $q11; ?>"
                                                       size="4" name="q11"
                                                       id="q11"
                                                       onblur="totalQuality()"/>
                </td>
                <td style="text-align: center;"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right">TOTAL</td>
                <td style="text-align: center;" id="totalPossibleStructural">
                    145
                </td>
                <td style="text-align: center;" id="totalStructural"></td>
                <td style="text-align: center;"></td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td colspan="5"
                    style="background-image: url(images/green_bg.png);"><strong>CLINICAL
                        INDICATORS</strong></td>
            </tr>
            <tr>
                <td></td>
                <td><strong>Health Service Components</strong></td>
                <td style="text-align: center;"><strong>Available Point</strong>
                </td>
                <td style="text-align: center;"><strong>Actual Score</strong>
                </td>
                <td style="text-align: center;"><strong>Applicable</strong></td>
            </tr>
            <tr>
                <td>12</td>
                <td>Out Patient Department/consultation area<br/>
                    (Childhood pneumonia, TB referral criteria,<br/>
                    PEP)
                </td>
                <td style="text-align: center;">22</td>
                <td style="text-align: center;"><input max="22" min="0"
                                                       type="number"
                                                       title="Out Patient Department"
                                                       value="<?php echo $q13; ?>"
                                                       size="4" name="q13"
                                                       id="q13"
                                                       onblur="totalQuality()"/>
                </td>
                <td style="text-align: center;"></td>
            </tr>
            <tr>
                <td>13</td>
                <td>Family and Child Health (ANC, PNC, FP)</td>
                <td style="text-align: center;">62</td>
                <td style="text-align: center;"><input max="62" min="0"
                                                       type="number"
                                                       title="Family and Child Health"
                                                       value="<?php echo $q14; ?>"
                                                       size="4" name="q14"
                                                       id="q14"
                                                       onblur="totalQuality()"/>
                </td>
                <td style="text-align: center;"></td>
            </tr>
            <tr>
                <td>14</td>
                <td>Maternity Service (routine maternal newborn<br/>
                    best practices, PPH, sepsis)
                </td>
                <td style="text-align: center;">96</td>
                <td style="text-align: center;"><input max="96" min="0"
                                                       type="number"
                                                       title="Maternity Service"
                                                       value="<?php echo $q15; ?>"
                                                       size="4" name="q15"
                                                       id="q15"
                                                       onblur="totalQuality()"/>
                </td>
                <td style="text-align: center;"><input name="q15applicable"
                                                       value="yes"
                                                       type="checkbox"
                                                       onclick="enable_q15(this.checked)">
                </td>
            </tr>
            <tr>
                <td>15</td>
                <td>EPI</td>
                <td style="text-align: center;">26</td>
                <td style="text-align: center;"><input max="26" min="0"
                                                       type="number" title="EPI"
                                                       value="<?php echo $q16; ?>"
                                                       size="4" name="q16"
                                                       id="q16"
                                                       onblur="totalQuality()"/>
                </td>
                <td style="text-align: center;"></td>
            </tr>
            <tr>
                <td>16</td>
                <td>Health information systems management</td>
                <td style="text-align: center;">15</td>
                <td style="text-align: center;"><input max="15" min="0"
                                                       type="number"
                                                       title="HMIS"
                                                       value="<?php echo $q17; ?>"
                                                       size="4" name="q17"
                                                       id="q17"
                                                       onblur="totalQuality()"/>
                </td>
                <td style="text-align: center;"></td>
            </tr>
            <tr>
                <td>17</td>
                <td>Medicines and sundries stock management</td>
                <td style="text-align: center;">28</td>
                <td style="text-align: center;"><input max="28" min="0"
                                                       type="number"
                                                       title="Medicines and sundries"
                                                       value="<?php echo $q18; ?>"
                                                       size="4" name="q18"
                                                       id="q18"
                                                       onblur="totalQuality()"/>
                </td>
                <td style="text-align: center;"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right;">TOTAL</td>
                <td style="text-align: center;" id="totalPossibleClinical"></td>
                <td style="text-align: center;" id="totalClinical"></td>
                <td style="text-align: center;"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right;">Total Quality Score
                </td>
                <td colspan="2" style="text-align: center;"
                    id="grandTotal"></td>
                <td style="text-align: center;"></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center;">
                    <input type="hidden" name="period"
                           value="<?php echo $period; ?>"/>
                    <input type="hidden" name="totalscore" value=""
                           id="totalscore"/>
                    <input type="hidden" name="orgunitid"
                           value="<?php echo $orgunitid; ?>"/>
                    <input type="hidden" name="update"
                           value="<?php echo $update; ?>"/>
                    <input type="submit" value="Submit"/></td>
            </tr>
        </table>

    </form>

    <script>
        document.qualityChecklist.q7.disabled = true;
        document.qualityChecklist.q8.disabled = true;
        document.qualityChecklist.q15.disabled = true;
        document.qualityChecklist.q17.disabled = true;

        function enable_q7(status) {
            status = !status;
            document.qualityChecklist.q7.disabled = status;
            totalQuality();
        }

        function enable_q8(status) {
            status = !status;
            document.qualityChecklist.q8.disabled = status;
            totalQuality();
        }

        function enable_q15(status) {
            status = !status;
            document.qualityChecklist.q15.disabled = status;
            document.qualityChecklist.q17.disabled = status;
            totalQuality();
        }

        totalQuality();

        function totalQuality() {
            var q1 = document.getElementById("q1").value;
            var q2 = document.getElementById("q2").value;
            var q3 = document.getElementById("q3").value;
            var q4 = document.getElementById("q4").value;
            var q5 = document.getElementById("q5").value;
            var q6 = document.getElementById("q6").value;

            if (document.qualityChecklist.q7.disabled) {
                var q7 = 0;
                var qt7 = 14;
            } else {
                var q7 = document.getElementById("q7").value;
                var qt7 = 0;
            }

            if (document.qualityChecklist.q8.disabled) {
                var q8 = 0;
                var qt8 = 8;
            } else {
                var q8 = document.getElementById("q8").value;
                var qt8 = 0;
            }

            var q9 = document.getElementById("q9").value;
            var q10 = document.getElementById("q10").value;
            var q11 = document.getElementById("q11").value;
            var q13 = document.getElementById("q13").value;
            var q14 = document.getElementById("q14").value;

            if (document.qualityChecklist.q15.disabled) {
                var q15 = 0;
                var qt15 = 96;
                var q17 = 0;
                var qt17 = 15;
            } else {
                var q15 = document.getElementById("q15").value;
                var q17 = document.getElementById("q17").value;
                var qt15 = 0;
                var qt17 = 0;
            }

            var q16 = document.getElementById("q16").value;
            var q18 = document.getElementById("q18").value;

            var structuralScore = +q1 + +q2 + +q3 + +q4 + +q5 + +q6 + +q7 + +q8 + +q9 + +q10 + +q11;

            document.getElementById("totalStructural").innerHTML = structuralScore;

            var qtStructural = 145 - +qt7 - +qt8;
            document.getElementById("totalPossibleStructural").innerHTML = qtStructural;

            var clinicalScore = +q13 + +q14 + +q15 + +q16 + +q17 + +q18;
            document.getElementById("totalClinical").innerHTML = clinicalScore;

            var qtClinical = 249 - +qt15 - +qt17;
            document.getElementById("totalPossibleClinical").innerHTML = qtClinical;

            //Calculate Percentage contributions
            var structuralPercentage = ((+structuralScore / +qtStructural) * 100) * 0.35;
            var clinicalPercentage = ((+clinicalScore / +qtClinical) * 100) * 0.65;

            var totalScore = +structuralPercentage + +clinicalPercentage;
            document.getElementById("grandTotal").innerHTML = totalScore.toPrecision(2) + '%';
            document.getElementById("totalscore").value = totalScore.toPrecision(2);
        }
    </script>