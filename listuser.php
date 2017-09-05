<%@include file="jstl.jsp" %>
 
<html>
<head>
<title>SELECT Operation</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>
 
<%@include file="dbconnect.jsp" %>
 
<sql:query dataSource="${bvr}" var="result">
SELECT * From household;
</sql:query> 
 
<h3 style="text-align: center">List Of House Holds</h3>
<table>
<tr style="background-image: url(images/green_bg.png);">  
   <th>First Name</th>
   <th>Last Name</th>
   <th>National ID</th>
   <th>Ward Number</th>
   <th>Phone Number</th>
   <th>Address</th>
</tr>
<c:forEach var="row" items="${result.rows}">
<tr>
   <td><c:out value="${row.firstname}"/> </td>
   <td><c:out value="${row.surname}"/> </td>
   <td><c:out value="${row.nationalid}"/> </td>
   <td><c:out value="${row.wardnumber}"/> </td>
   <td><c:out value="${row.phone}"/> </td>
   <td><c:out value="${row.address}"/> </td>
</tr>
</c:forEach>
</table>
 
</body>
</html>