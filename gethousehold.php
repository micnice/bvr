<%@include file="jstl.jsp" %>
 
<html>
<head>
<title>SELECT Operation</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>
 
<%@include file="dbconnect.jsp" %>
 
<sql:query dataSource="${bvr}" var="result">
SELECT firstname,surname,nationalid From household where nationalid like '%${param.hhnationalid}%';
</sql:query> 
 
<c:forEach var="row" items="${result.rows}">
    <c:set var="json" value="${fn:split('value:${row.firstname} ${row.surname}','label:${row.firstname}')}" />
</c:forEach>
 
</body>
</html>