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
    <div align="center"><h3>Enter Invoices</h3><br /><table  style="background-color: #E0F277;">
        <tr>
            <td><font size="4">Invoice Number</font></td>
            <td><input type="text" size="30" maxlength="60" name="invoiceno" required> </td>
        </tr>
            <tr>
            <td><font size="4">Facility</font></td>
            <td> <select name="facility">
                    <option value="1">Mbare Poly Clinic</option>
                    <option value="2">Hopley Clinic</option>
                    <option value="3">Rutsanana Clinic</option>
                    <option value="4">Waterfalls Clinic</option>
                  </select> 
            </td>
        </tr>
        <tr>
            <td><font size="4">Invoice Date</font></td>
            <td><input type="date" name="invoicedate" pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}" placeholder="dd-mm-yyyy" required> </td>
        </tr>
        <tr>
            <td><font size="4">Amount</font></td>
            <td><input type="number" size="10" maxlength="10" name="amount" required> </td>
        </tr>
    </table>
    </div><p align="center">
    <input type="submit" value="Submit" /></p> </p>
    <p>&nbsp;</p>
</form>
    
<c:if test="${pageContext.request.method=='POST'}">
    <c:catch var="exception">
        <sql:update dataSource="${bvr}" var="updatedTable">
        insert into facilityinvoice (idfacility,invoicedate,invoicenumber,amount) 
        values(CAST(? as int),?,CAST(? as int),CAST(? as int));
            <sql:param value="${param.facility}" />
            <sql:param value="${param.invoicedate}" />
            <sql:param value="${param.invoiceno}" />
            <sql:param value="${param.amount}" />
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