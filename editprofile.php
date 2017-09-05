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
 
<sql:query dataSource="${bvr}" var="result">
SELECT * From users where username=?;
    <sql:param value="${sessionScope.username}" />
</sql:query> 

<form method="POST">
    
    <div align="center"><h3>Change Password</h3><br />
        <c:forEach var="row" items="${result.rows}">
        <table  style="background-color: #E0F277;">
        <tr>
            <td><font size="4">Username:</font></td>
            <td><c:out value="${row.username}" /> </td>
        </tr>
        <tr>
            <td><font size="4">Password:</font></td>
            <td><input type="password" size="30" maxlength="50" name="password"> </td>
        </tr>
        <tr>
            <td><font size="4">First name:</font></td>
            <td><c:out value="${row.firstname}" /> </td>
        </tr>        
        <tr>
            <td><font size="4">Surname:</font></td>
            <td><c:out value="${row.username}" /> </td>
        </tr>
        <tr>
            <td><font size="4">User Role:</font></td>
            <td><c:out value="${row.userrole}" /> </td>
        </tr>
        <tr>
            <td><font size="4">Organisation:</font></td>
            <td><c:out value="${row.organisation}" /> </td>
        </tr>
    </table>
        </c:forEach>
    </div><p align="center">
    <input type="submit" value="Submit" /></p> </p>
    <p>&nbsp;</p>
</form>
    

<c:if test="${pageContext.request.method=='POST'}">
    <c:catch var="exception">
        <sql:update dataSource="${bvr}" var="updatedTable">
        update users set password=?;   
            <sql:param value="${param.password}" />
        </sql:update>
        <c:if test="${updatedTable>=1}">
            <font id="successAlert">
                Password Successfully changed!
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