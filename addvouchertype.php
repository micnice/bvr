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
    <div align="center"><h3>Add Voucher Type</h3><br /><table  style="background-color: #E0F277;">
        <tr>
            <td><font size="4">Short Name</font></td>
            <td><input type="text" size="30" maxlength="50" name="shortname"> </td>
        </tr>
        <tr>
            <td><font size="4">Description</font></td>
            <td><input type="text" size="30" maxlength="50" name="description"> </td>
        </tr>
        <tr>
            <td><font size="4">Enabled</font></td>
            <td><input type="text" size="20" maxlength="20" name="enabled"> </td>
        </tr>
        <tr>
            <td><font size="4">Price</font></td>
            <td><input type="text" size="20" maxlength="20" name="price"> </td>
        </tr>
    </table>
    </div><p align="center">
    <input type="submit" value="Submit" /></p> </p>
    <p>&nbsp;</p>
</form>
    
    
<c:if test="${pageContext.request.method=='POST'}">
    <c:catch var="exception">
        <fmt:parseNumber var="price" type="number" value="${param.price}" />
        <sql:update dataSource="${bvr}" var="updatedTable">
        insert into vouchertype (shortname,description,enabled,price) 
        values(?,?,?,?);
            <sql:param value="${param.shortname}" />
            <sql:param value="${param.description}" />
            <sql:param value="${param.enabled}" />
            <sql:param value="${price}" />
        </sql:update>
        <c:if test="${updatedTable>=1}">
            <c:redirect url="vouchertypes.jsp"/>
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