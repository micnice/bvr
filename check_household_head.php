<%@include file="jstl.jsp" %>
<%@include file="dbconnect.jsp" %>


<c:if test="${pageContext.request.method=='POST'}">
    <sql:query dataSource="${bvr}" var="result">
        SELECT firstname,surname,address From household where nationalid=?;
        <sql:param value="${param.hhnationalid}"/>
    </sql:query>
    <c:catch var="exception">

        <c:set var="count" value="0" scope="page"/>
        <c:forEach var="row" items="${result.rows}">
            <c:out value="${row.firstname}"/>
            <c:out value="${row.surname}"/>
            of
            <c:out value="${row.address}"/>
            <c:set var="count" value="${count + 1}" scope="page"/>
        </c:forEach>
        <c:if test="${count = 0}">
            <font style="color: red">Household ID done not exist</font>
        </c:if>
    </c:catch>
    <c:if test="${exception!=null}">
        <font id="failureAlert">
            <br/>Error Details:
            <c:out value="${exception}"/>
        </font>
    </c:if>
</c:if>