<%@include file="jstl.jsp" %>
 
<html>
<head>
<title>SELECT Operation</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
</head>
<body>
 
<%@include file="dbconnect.jsp" %>
 
<sql:query dataSource="${bvr}" var="result">
SELECT facilityname,invoicenumber,invoicedate,amount From facilityinvoice a,facility b where a.idfacility=b.idfacility;
</sql:query> 
 
<h3 style="text-align: center">List Of Submitted Invoices</h3>
<table>
<tr style="background-image: url(images/green_bg.png);">   
   <th>Invoice Number</th>
   <th>Facility Name</th>
   <th>Invoice Date</th>
   <th>Amount</th>
</tr>
<c:forEach var="row" items="${result.rows}">
<tr>
   <td><c:out value="${row.invoicenumber}"/> </td>
   <td><c:out value="${row.facilityname}"/> </td>
   <td><c:out value="${row.invoicedate}"/> </td>
   <td><c:out value="${row.amount}"/> </td>
</tr>
</c:forEach>
</table>
 
</body>
</html>
