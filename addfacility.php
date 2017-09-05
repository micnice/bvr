<%@include file="jstl.jsp" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Beneficiary Voucher Repository System</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>
    <%@include file="dbconnect.jsp" %> 
    
<form method="POST">
    <div align="center"><h3>Add/Edit Facility</h3><br /><table  style="background-color: #E0F277;">
        <tr>
            <td><font size="4">Facility Name:</font></td>
            <td><input type="text" size="60" maxlength="60" name="facilityname"> </td>
        </tr>
        <tr>
            <td><font size="4">Address:</font></td>
            <td><input type="text" size="60" maxlength="60" name="address"> </td>
        </tr>
        <tr>
            <td><font size="4">Phone:</font></td>
            <td><input type="text" size="30" maxlength="50" name="phone"> </td>
        </tr>
        <tr>
            <td><font size="4">Contact Person:</font></td>
            <td><input type="text" size="50" maxlength="50" name="contactperson"> </td>
        </tr>
        <tr>
            <td><font size="4">District</font></td>
            <td><select name="district">
                    <option value="1">Nkulumane District</option>
                    <option value="2">Harare Southern District</option>
                
                  </select> </td>
        </tr>
    </table>
    </div><p align="center">
    <input type="submit" value="Submit" /></p> </p>
    <p>&nbsp;</p>
</form>

<c:if test="${pageContext.request.method=='POST'}">
    <c:catch var="exception">
        <sql:update dataSource="${bvr}" var="updatedTable">
        insert into facility (facilityname,address,phone,contactperson,iddistrict) 
        values(?,?,CAST(? as int),?,CAST(? as int));
            <sql:param value="${param.facilityname}" />
            <sql:param value="${param.address}" />
            <sql:param value="${param.phone}" />
            <sql:param value="${param.contactperson}" />
            <sql:param value="${param.district}" />
        </sql:update>
        <c:if test="${updatedTable>=1}">
            <font id="successAlert">
                Data Successfully Saved to Database!
            </font>
        </c:if>
    </c:catch>
    <c:if test="${exception!=null}">
        <font id="failureAlert">
            Error! Unable to Save Data! <br /><br />Error Details: <c:out value="${exception}" />
        </font>
    </c:if>
</c:if>
</body>
</html>