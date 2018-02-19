<!DOCTYPE html>
<?php
session_start();
include 'dbconnect.php';
if (strcmp($_SESSION['login'], 'false') == 0) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query
        = "SELECT * FROM users WHERE username = '$username' AND password = md5('$password') and userrole in ('admin','NPA', 'verifier','accounts');";
    $result = pg_query($conn, $query);
    $row = pg_fetch_array($result, 0);
    //echo $query;
    if (pg_num_rows($result) != 1) {
        header("Location: index.php?login=fail");
        die();
    } else {
        $_SESSION['login'] = 'true';
        $_SESSION['role'] = $row[6];
        $_SESSION["userrole"] = $row[6];
        $_SESSION["username"] = $row[0];
        $_SESSION["facility"] = $row[11];
    }

    if (strcmp($_SESSION['login'], 'true') != 0 || !isset($_SESSION['login'])) {
        header("Location: index.php?login=fail");
        die();
    }
}
?>

<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">
    <title>Beneficiary Voucher Repository (BVR)</title>


    <script type="text/javascript" src="scripts/jquery.min.1_4_2.js"></script>

    <script type="text/javascript" src="scripts/ddaccordion.js">

        /***********************************************
         * Accordion Content script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
         * Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
         * This notice must stay intact for legal use
         ***********************************************/

    </script>


    <script type="text/javascript">


        ddaccordion.init({
            headerclass: "silverheader", //Shared CSS class name of headers group
            contentclass: "submenu", //Shared CSS class name of contents group
            revealtype: "mouseover", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
            mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
            collapseprev: true, //Collapse previous content (so only one open at any time)? true/false
            defaultexpanded: [0], //index of content(s) open by default [index1, index2, etc] [] denotes no content
            onemustopen: true, //Specify whether at least one header should be open always (so never all headers closed)
            animatedefault: false, //Should contents open by default be animated into view?
            persiststate: true, //persist state of opened contents within browser session?
            toggleclass: ["", "selected"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
            togglehtml: ["", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
            animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
            oninit: function (headers, expandedindices) { //custom code to run when headers have initalized
                //do nothing
            },
            onopenclose: function (header, index, state, isuseractivated) { //custom code to run whenever a header is opened or closed
                //do nothing
            }
        })


    </script>

    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">

    <style type="text/css">


        .applemenu {
            margin: 0px 0;
            padding: 0;
            width: 230px; /*width of menu*/
            border: 1px solid #98bf21;
        }

        .applemenu div.silverheader a {
            background: #E0F277 url(images/green_bg.jpg) repeat-x center left;
            font: normal 14px Tahoma, "Lucida Grande", "Trebuchet MS", Helvetica, sans-serif;
            color: white;
            display: block;
            position: relative; /*To help in the anchoring of the ".statusicon" icon image*/
            width: auto;
            padding: 5px 0;
            padding-left: 3px;
            text-decoration: none;
            font-weight: bold;
            height: 35px;
        }

        .applemenu div.silverheader a:visited, .applemenu div.silverheader a:active {
            color: white;
        }

        .applemenu div.selected a, .applemenu div.silverheader a:hover {
            background-image: url(images/green_bg.jpg);
            color: white;
        }

        .applemenu div.submenu { /*DIV that contains each sub menu*/
            background: #E0F277;
            padding: 5px;
            height: 300px; /*Height that applies to all sub menu DIVs. A good idea when headers are toggled via "mouseover" instead of "click"*/
        }

        td, th {
            border: 1px solid #98bf21;
        }

    </style>
    <meta name="robots" content="noindex,follow">

</head>
<body>
<?php
$role = trim($_SESSION['role']);

if (strlen($role) == 0) {
    die("Session Expired! Please login again! <a href='index.php'>Login Again</a>");
}
?>
<div id="header"
     style="border: 2px solid; border-radius: 25px; border-color: #537313; padding-left: 15px;padding-top: 5px;">
    <div style="float: left;font-size: 25px; color: white;"><a href="login.php"><img
                    src="images/zimflag.jpeg" alt="" border="0"/></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Beneficiary
        Voucher Repository
    </div>
    <div style="float: right;font-size: 15px; color: yellow;">BVR Version
        1.0<br/><img src="images/redcross.png"/>&nbsp;&nbsp;&nbsp;<img
                src="images/redcross.png"/>&nbsp;&nbsp;&nbsp;<img
                src="images/redcross.png"/>&nbsp;&nbsp;&nbsp;
    </div>
</div>
<div id="header2">
    <div style="float: right;"><em>Logged in Role
            ....<b><?php echo $role; ?></b>
            <a href="index.php">Log Out</a></em></div>
</div>

<div id="container"
     style="border: 2px solid; border-radius: 25px; border-color: #537313;">
    <div id="sidebar">
        <div class="applemenu">
            <?php
            $acl = array("NPA", "admin");
            if (in_array($role, $acl)) {
                ?>
                <div class="silverheader" id="MainRegister"><a class="active" href="#one">Beneficiary
                        Register</a></div>
                <div class="submenu">
                    <ul>
                        <li id="listhh"><a href="main.php?page=beneficiaryupload">Upload
                                Beneficiaries</a></li>
                        <hr/>
                        <li id="listb"><a href="main.php?page=beneficiarylist">List
                                Beneficiary</a></li>
                    </ul>
                </div>


                <?php
            }

            $acl = array("NPA", "admin",);
            if (in_array($role, $acl)) {
                ?>
                <div class="silverheader" id="Claims"><a class="" href="#three">Invoicing
                        &AMP; Claims Processing</a></div>
                <div class="submenu">
                    <ul>
                        <li id="AddClaim"><a href="mobi/verifyvoucher.php"
                                             onclick="return !window.open(this.href, 'Google', 'width=500,height=500')"
                                             target="_blank">Redeem Vouchers</a>
                        </li>
                        <li id="Summary"><a href="trackvouchers_form.php"
                                            onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                            target="_blank">Track Vouchers</a>
                        </li>

                        <li id="Summary"><a href="claimadd_form.php"
                                            onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                            target="_blank">View Redeemed
                                Vouchers</a></li>
                        <li id="Summary"><a href="revokevoucher_form.php"
                                            onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                            target="_blank">Vouchers Redeemed by
                                ID</a></li>
                        <li id="ApproveClaims"><a
                                    href="main.php?page=claimsapprove_form">Approve
                                Claims</a></li>
                        <li id="PrintInvoice"><a
                                    href="main.php?page=invoice_form">Print Health
                                Facility Invoice</a></li>
                        <li id="PrintInvoice"><a
                                    href="main.php?page=cboinvoice_form">Print CBO
                                Invoice</a></li>
                    </ul>
                </div>
                <?php
            }
            $acl = array("CBO", "NPA", "admin");
            if (in_array($role, $acl)) {

                ?>

                <div class="silverheader" id="QualityChecklist"><a class=""
                                                                   href="#three">Quality Component</a></div>
                <div class="submenu">
                    <ul>
                        <li id="QualityChecklist"><a
                                    href="main.php?page=qualitychecklist_form">Quality
                                Checklist</a></li>
                        <li id="CBOScore"><a href="mobi/cboscore_form.php"
                                             onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                             target="_blank">CBO Score</a></li>
                        <li id="CBOScore"><a href="viewcboquestionnaires_form.php"
                                             onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                             target="_blank">Audit CBO Scores</a>
                        </li>
                        <li id="CBOScore"><a href="cboscore_summary_form.php"
                                             onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                             target="_blank">CBO Score Summary</a>
                        </li>

                        <li id="CBOScore"><a
                                    href="main.php?page=quality_summary_form">Quality
                                Score Summary</a></li>
                        <li id="Summary"><a href="mobi/cbosamples_form.php"
                                            onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                            target="_blank">CBO samples</a></li>
                        <li id="CBOScore"><a
                                    href="main.php?page=cboscore_edit_form">Delete Questionnaire</a></li>

                    </ul>
                </div>
                <?php
            }
            $acl = array("verifier", "accounts");
            if (in_array($role, $acl)) {
                ?>
                <div class="silverheader" id="MainRegister"><a class="active" href="#one">Beneficiary
                        Register</a></div>
                <div class="submenu">
                    <ul>
                        <li id="listb"><a href="main.php?page=beneficiarylist">List
                                Beneficiary</a></li>
                    </ul>
                </div>
                <?php
            }

            $acl = array("accounts");
            if (in_array($role, $acl)) {
                ?>
                <div class="silverheader" id="Claims"><a class="" href="#three">Invoicing
                        &AMP; Claims Processing</a></div>
                <div class="submenu">
                    <ul>
                        <li id="PrintInvoice"><a
                                    href="main.php?page=invoice_form">Print Health
                                Facility Invoice</a></li>
                        <li id="PrintInvoice"><a
                                    href="main.php?page=cboinvoice_form">Print CBO
                                Invoice</a></li>
                    </ul>
                </div>
                <?php
            }
            $acl = array("accounts");
            if (in_array($role, $acl)) {

                ?>
                <div class="silverheader" id="SystemSetup"><a class=""
                                                              href="#three">Reports</a>
                </div>
                <div class="submenu">
                    <ul>

                        <li id="DisburseVouchers"><a
                                    href="main.php?page=partially_redeemed_form">Partially
                                Redeemed Vouchers</a></li>
                        <li id="Summary"><a href="voucherapprovedsummary_form.php"
                                            onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                            target="_blank">Vouchers Approved</a>
                        </li>
                        <li id="ListClaims"><a href="claimsapproved_form.php"
                                               onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                               target="_blank">Approved Claims</a></li>
                    </ul>
                </div>

                <?php
            }

            $acl = array("verifier");
            if (in_array($role, $acl)) {
                ?>
                <div class="silverheader" id="Claims"><a class="" href="#three">Invoicing
                        &AMP; Claims Processing</a></div>
                <div class="submenu">
                    <ul>
                        <li id="Summary"><a href="trackvouchers_form.php"
                                            onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                            target="_blank">Track Vouchers</a>
                        </li>
                        <li id="Summary"><a href="revokevoucher_form.php"
                                            onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                            target="_blank">Vouchers Redeemed by
                                ID</a></li>
                    </ul>
                </div>
                <?php
            }
            $acl = array("verifier");
            if (in_array($role, $acl)) {

                ?>
                <div class="silverheader" id="SystemSetup"><a class=""
                                                              href="#three">Reports</a>
                </div>
                <div class="submenu">
                    <ul>

                        <li id="DisburseVouchers"><a
                                    href="main.php?page=partially_redeemed_form">Partially
                                Redeemed Vouchers</a></li>
                        <li id="ListClaims"><a href="claimsapproved_form.php"
                                               onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                               target="_blank">Approved Claims</a></li>
                    </ul>
                </div>
                <?php
            }
            $acl = array("NPA", "admin");
            if (in_array($role, $acl)) {
                ?>
                <div class="silverheader" id="ManageVoucher"><a class=""
                                                                href="#three">Voucher
                        Management</a></div>
                <div class="submenu">
                    <ul>
                        <li id="DisburseVouchers"><a
                                    href="main.php?page=vouchersales_form">Voucher
                                Sales</a></li>
                        <li id="DisburseVouchers"><a
                                    href="main.php?page=vouchersalessummary_form">Voucher
                                Sales Summary</a></li>
                        <li id="DisburseVouchers"><a
                                    href="main.php?page=vouchersalessummaryall_form">Voucher
                                Sales Summary (All)</a></li>

                        <li id="Summary"><a href="vouchertracker_form_beta.php"
                                            onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                            target="_blank">Voucher Tracker
                                Beta</a></li>
                        <li id="Summary"><a href="vouchertracker_form.php"
                                            onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                            target="_blank">Voucher Tracker</a>
                        </li>
                        <li id="Summary"><a
                                    href="vouchertracker_unredeemed_form.php"
                                    onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                    target="_blank">Voucher Tracker -
                                Unredeemed</a></li>
                        <li id="Summary"><a href="deliverytracker_form.php"
                                            onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                            target="_blank">Delivery Tracker</a>
                        </li>

                    </ul>
                </div>
                <?php
            }
            $acl = array("admin");
            if (in_array($role, $acl)) {
                ?>
                <div class="silverheader" id="SystemSetup"><a class=""
                                                              href="#three">Reports</a>
                </div>
                <div class="submenu">
                    <ul>
                        <li id="DisburseVouchers"><a
                                    href="main.php?page=beneficiarycount_summary">Beneficiary
                                Count</a></li>
                        <li id="DisburseVouchers"><a
                                    href="vouchersales_unredeemed_form.php"
                                    onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                    target="_blank">Unredeemed Vouchers</a></li>
                        <li id="DisburseVouchers"><a
                                    href="main.php?page=partially_redeemed_form">Partially
                                Redeemed Vouchers</a></li>
                        <li id="DisburseVouchers"><a
                                    href="main.php?page=enrollmentsummary_form">Enrollment
                                Summary</a></li>
                        <li id="Summary"><a href="voucherredeemedsummary_form.php"
                                            onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                            target="_blank">Vouchers Redeemed</a>
                        </li>
                        <li id="Summary"><a href="voucherapprovedsummary_form.php"
                                            onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                            target="_blank">Vouchers Approved</a>
                        </li>
                        <li id="Summary"><a
                                    href="vouchers_waiting_approvalsummary.php"
                                    onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                    target="_blank">Vouchers Awaiting Approval</a>
                        </li>
                        <li id="Summary"><a href="voucherrejectedsummary.php"
                                            onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                            target="_blank">Vouchers Rejected</a>
                        </li>
                        <li id="ListClaims"><a href="claimsapproved_form.php"
                                               onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                               target="_blank">Approved Claims</a>
                        </li>
                        <li id="RejectedClaims"><a
                                    href="main.php?page=claimsrejected_form">Rejected
                                Claims</a></li>
                        <li id="DisburseVouchers"><a
                                    href="beneficiaries_nosales_form.php"
                                    onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                    target="_blank">Beneficiaries with no
                                sales</a></li>
                        <li id="DisburseVouchers"><a
                                    href="assessment_scores_form.php"
                                    onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                    target="_blank">Assessment Scores</a></li>
                        <li id="Summary"><a href="deliveriessummary_form.php"
                                            onclick="return !window.open(this.href, 'Google', 'width=1200,height=700')"
                                            target="_blank">Deliveries Summary</a>
                        </li>

                    </ul>
                </div>

                <?php
            }
            $acl = array("admin");
            if (in_array($role, $acl)) {
                ?>
                <div class="silverheader" id="SystemSetup"><a class=""
                                                              href="#three">System
                        Setup</a></div>
                <div class="submenu">
                    <ul>

                        <li id="AddUser"><a href="main.php?page=adduser">Add New
                                User</a></li>
                        <li id="AddUser"><a href="main.php?page=adduserlist">List
                                Existing Users</a></li>

                    </ul>
                </div>

                <?php
            }
            $acl = array("admin");
            if (in_array($role, $acl)) {
                ?>
                <div class="silverheader" id="ProfileSettings"><a class=""
                                                                  href="#three">Profile
                        Settings</a></div>
                <div class="submenu">
                    <ul>

                        <li>Change Password</li>
                        <li><a href="index.php">Log Out</a></li>

                    </ul>
                </div>
                <?php
            }
            ?>

        </div>
    </div>

    <div id="content">
        <?php
        if (isset($_GET['page']) || !empty($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 'welcome';
        }
        include $page . '.php';
        ?>
    </div>
</div>
</body>
</html>
