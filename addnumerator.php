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
    <div align="center"><h3>Add Numerator</h3><br /><table  style="background-color: #E0F277;">
        <tr>
            <td><font size="4">First name:</font></td>
            <td><input type="text" size="30" maxlength="50" name="firstname"> </td>
        </tr>        
        <tr>
            <td><font size="4">Surname:</font></td>
            <td><input type="text" size="30" maxlength="50" name="surname"> </td>
        </tr>
        <tr>
            <td><font size="4">Address:</font></td>
            <td><input type="text" size="20" maxlength="20" name="address"> </td>
        </tr>
        <tr>
            <td><font size="4">National ID:</font></td>
            <td><input type="text" size="30" maxlength="30" name="nationalid"> </td>
        </tr>
        <tr>
            <td><font size="4">Email:</font></td>
            <td><input type="text" size="30" maxlength="30" name="email"> </td>
        </tr>
         <tr>
            <td><font size="4">Phone Number:</font></td>
            <td><input type="text" size="20" maxlength="20" name="phone"> </td>
        </tr>
    </table>
    </div><p align="center">
    <input type="submit" value="Submit" /></p> </p>
    <p>&nbsp;</p>
</form>
    
<c:if test="${pageContext.request.method=='POST'}">
    <c:catch var="exception">
        <sql:update dataSource="${bvr}" var="updatedTable">
        insert into Numerators (firstname,surname,address,nationalid,email,phone) 
        values(?,?,?,?,?,?);   
            <sql:param value="${param.firstname}" />
            <sql:param value="${param.surname}" />
            <sql:param value="${param.address}" />
            <sql:param value="${param.nationalid}" />
            <sql:param value="${param.email}" />
            <sql:param value="${param.phone}" />
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