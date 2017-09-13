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
    <div align="center"><h3>List of Vouchers by Beneficiary</h3><br/>
        <table style="background-color: #E0F277;">
            <tr>
            <tr>
                <td><font size="4">CoE Serial Number:</font></td>
                <td><input type="text" size="30" maxlength="50"
                           name="vouchertype"></td>
            </tr>
        </table>
    </div>
    <p align="center">
        <input type="submit" value="Submit"/></p> </p>
    <p>&nbsp;</p>
</form>

<c:if test="${pageContext.request.method=='POST'}">
    <sql:query dataSource="${bvr}" var="result">
        SELECT serialno,purpose,firstname,surname,nationalid,dob,phone From
        beneficiarymaster,vouchers where serialno=idcoe and serialno=?;
        <sql:param value="${param.serialno}"/>
    </sql:query>
    <c:catch var="exception">
        <table>
            <tr style="background-image: url(images/green_bg.png);">
                <th>Certificate No.</th>
                <th>Purpose</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>National ID</th>
                <th>D.O.B</th>
                <th>Phone Number</th>
            </tr>
            <c:forEach var="row" items="${result.rows}">
                <tr>
                    <td>
                        <c:out value="${row.serialno}"/>
                    </td>
                    <td>
                        <c:out value="${row.firstname}"/>
                    </td>
                    <td>
                        <c:out value="${row.surname}"/>
                    </td>
                    <td>
                        <c:out value="${row.nationalid}"/>
                    </td>
                    <td>
                        <c:out value="${row.dob}"/>
                    </td>
                    <td>
                        <c:out value="${row.phone}"/>
                    </td>
                </tr>
            </c:forEach>
        </table>
    </c:catch>
    <c:if test="${exception!=null}">
        <font id="failureAlert">
            <br/>Error Details:
            <c:out value="${exception}"/>
        </font>
    </c:if>
</c:if>
</body>
</html>