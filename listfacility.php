<%@include file="jstl.jsp" %>
 
<html>
<head>
<title>SELECT Operation</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>
 
<%@include file="dbconnect.jsp" %>
 
<sql:query dataSource="${bvr}" var="result">
SELECT * From facility;
</sql:query> 
 
<h3 style="text-align: center">List Of Facilities</h3>
<table>
<tr style="background-image: url(images/green_bg.png);">  
   <th>Facility Name</th>
   <th>Address</th>
   <th>Phone Number</th>
   <th>Contact Person</th>
</tr>
<c:forEach var="row" items="${result.rows}">
<tr>
   <td><c:out value="${row.facilityname}"/> </td>
   <td><c:out value="${row.address}"/> </td>
   <td><c:out value="${row.phone}"/> </td>
   <td><c:out value="${row.contactperson}"/> </td>
</tr>
</c:forEach>
</table>
 
</body>
</html>