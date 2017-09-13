<%@include file="jstl.jsp" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Welcome to the Beneficiary Voucher Repository System</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>
<form method="POST">
    <div align="center"><h3>Login Page</h3>
        Serial Number:<input type="text" size="20" maxlength="20"
                             name="serialno"><br/>
        <input type="submit" value="Login"/>
    </div>
</form>

<%@include file="dbconnect.jsp" %>
<div align="center">
    <sql:query dataSource="${bvr}" var="result">
        SELECT * From beneficiarymaster where serialno=?;
        <sql:param value="${param.serialno}"/>
    </sql:query>

    <c:set var="count" value="0" scope="page"/>

    <c:if test="${pageContext.request.method != 'POST'}">
        <c:remove var="userrole"/>
        <c:remove var="username"/>
    </c:if>
    <c:if test="${pageContext.request.method == 'POST'}">
        <c:catch var="exception">
            <c:set var="count" value="0" scope="page"/>
            <c:forEach var="row" items="${result.rows}">
                <c:set var="count" value="${count + 1}" scope="page"/>
                <div align="left">
                    <hr/>
                    <font style="color:#404247">Serial Number:</font>
                    <c:out value="${row.serialno}"/>
                    <br/>
                    <font style="color:#404247"> First Name:</font>
                    <c:out value="${row.firstname}"/>
                    <br/>
                    <font style="color:#404247">Surname:</font>
                    <c:out value="${row.surname}"/>
                    <br/>
                    <font style="color:#404247">National ID:</font>
                    <c:out value="${row.nationalid}"/>
                    <br/>
                    <font style="color:#404247">Date of Birth:</font>
                    <c:out value="${row.dob}"/>
                    <br/>
                    <div>
            </c:forEach>

            <c:if test="${count==0}">

                <font id="failureAlert">
                    Credentials entered do not exist. Please try again!
                </font>
            </c:if>
        </c:catch>
        <c:if test="${exception!=null}">
            <font id="failureAlert">
                Error! Unable to Login! <br/><br/>Error Details:
                <c:out value="${exception}"/>
            </font>
        </c:if>
    </c:if>
</div>
</body>
</html>