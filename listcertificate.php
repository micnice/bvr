<%@include file="jstl.jsp" %>

<html>
<head>
    <title>SELECT Operation</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>

<%@include file="dbconnect.jsp" %>

<sql:query dataSource="${bvr}" var="result">
    SELECT * From beneficiarymaster;
</sql:query>

<h3 style="text-align: center">List Of Certificates</h3>
<table>
    <tr style="background-image: url(images/green_bg.png);">
        <th>Certificate No.</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>National ID</th>
        <th>Household Head ID Number</th>
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
                <c:out value="${row.idhousehold}"/>
            </td>
            <td>
                <c:out value="${row.phone}"/>
            </td>
        </tr>
    </c:forEach>
</table>

</body>
</html>
