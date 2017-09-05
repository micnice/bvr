<%@include file="jstl.jsp" %>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Beneficiary Voucher Repository System</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
<script src="jquery.js" type="text/javascript">/script>
<script type="text/javascript">
$("#hhnationalid").change(function() { //user types username on inputfiled
   var hhnationalid = $(this).val(); //get the string typed by user
   $.post('check_household_head.jsp', {'hhnationalid':hhnationalid}, function(data) { //make ajax call to check_household_head.php
   $("#user-result").html(data); //dump the data received from PHP page
   });
});
</script>
</head>
<body>
    <%@include file="dbconnect.jsp" %>
    
<form method="POST">
    <div align="center"><h3>Add Beneficiary</h3><br /><table  style="background-color: #E0F277;">
        <tr>
            <td><font size="4">Household Head ID Number</font></td>
            <td><input type="text" size="20" maxlength="20" id="hhnationalid" name="hhnationalid" pattern="[0-9]{2}-[0-9]{6,7}[A-Z][0-9]{2}" placeholder="XX-000000X00" required > 
            <span id="user-result"></span>
            </td>
        </tr>
        <tr>
            <td><font size="4">Certificate of Eligibility No</font></td>
            <td><input type="number" size="20" maxlength="20" name="coe" required> </td>
        </tr>
        <tr>
            <td><font size="4">Firstname</font></td>
            <td><input type="text" size="30" maxlength="50" name="firstname" required> </td>
        </tr>
        <tr>
            <td><font size="4">Surname</font></td>
            <td><input type="text" size="30" maxlength="50" name="surname" required> </td>
        </tr>
        <tr>
            <td><font size="4">National ID Number</font></td>
            <td><input type="text" size="20" maxlength="20" name="nationalid" pattern="[0-9]{2}-[0-9]{6,7}[A-Z][0-9]{2}" placeholder="XX-000000X00" required > </td>
        </tr>
        <tr>
            <td><font size="4">Date of Birth</font></td>
            <td><input type="date" name="dob" pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}" placeholder="dd-mm-yyyy" required> </td>
        </tr>
         <tr>
            <td><font size="4">Phone Number</font></td>
            <td><input type="number" name="phone" required> </td>
        </tr>
    </table>
    </div><p align="center">
    <input type="submit" value="Submit" /></p> </p>
    <p>&nbsp;</p>
</form>
    
    
<c:if test="${pageContext.request.method=='POST'}">
    <c:catch var="exception">
        <sql:update dataSource="${bvr}" var="updatedTable">
        insert into beneficiarymaster (firstname,surname,phone,nationalid,dob,idhousehold) 
        values(?,?,CAST(? as int),?,?,?,CAST(? as int));
            <sql:param value="${param.firstname}" />
            <sql:param value="${param.surname}" />
            <sql:param value="${param.phone}" />
            <sql:param value="${param.nationalid}" />
            <sql:param value="${param.dob}" />
            <sql:param value="${param.hhnationalid}" />
            <sql:param value="${param.coe}" />
        </sql:update>
        <c:if test="${updatedTable>=1}">
            <div id="alert">
            <font id="successAlert">
                Data Successfully Saved to Database!
            </font>
            </div>
        </c:if>
    </c:catch>
    <c:if test="${exception!=null}">
        <div id="alert">
        <font id="failureAlert">
            Error! Unable to Save Data! <br /><br />Error Details: <c:out value="${exception}" />
        </font>
        </div>
    </c:if>
</c:if>
</body>
</html>