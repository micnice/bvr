<%@include file="jstl.jsp" %>

<html>
<head>
    <title>Manage Voucher Types</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>

<%@include file="dbconnect.jsp" %>

<sql:query dataSource="${bvr}" var="result">
    SELECT * From vouchertype;
</sql:query>

<h3 style="text-align: center">List Of Voucher Types</h3>
<table>
    <tr style="background-image: url(images/green_bg.png);">
        <th>Short Name</th>
        <th>Description</th>
        <th>Enabled</th>
        <th>Price</th>
    </tr>
    <c:forEach var="row" items="${result.rows}">
        <tr>
            <td>
                <c:out value="${row.shortname}"/>
            </td>
            <td>
                <c:out value="${row.description}"/>
            </td>
            <td>
                <c:out value="${row.enabled}"/>
            </td>
            <td>
                <c:out value="${row.price}"/>
            </td>
        </tr>
    </c:forEach>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td><a href="addvouchertype.jsp"> Add Voucher Type</a></td>
    </tr>
</table>

</body>
</html>
