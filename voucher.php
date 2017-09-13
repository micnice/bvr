<%@include file="jstl.jsp" %>
<%@include file="dbconnect.jsp" %>
<sql:query dataSource="${bvr}" var="result">
    SELECT firstname,surname,nationalid,serialno From beneficiarymaster where
    serialno=?;
    <sql:param value="${param.serialno}"/>
</sql:query>
<c:set var="count" value="0" scope="page"/>
<c:if test="${pageContext.request.method == 'GET'}">
    <c:catch var="exception">
        <c:set var="count" value="0" scope="page"/>
        <c:forEach var="row" items="${result.rows}">
            <c:set var="count" value="${count + 1}" scope="page"/>
            <beneficiary>
                <vouchernumber>
                    <c:out value="${row.serialno}"/>
                </vouchernumber>
                <nationalid>
                    <c:out value="${row.nationalid}"/>
                </nationalid>
                <beneficiaryname>
                    <c:out value="${row.firstname}"/>
                    <c:out value="${row.surname}"/>
                </beneficiaryname>
                <expirydate>
                    <c:out value="${row.expirydate}"/>
                </expirydate>
            </beneficiary>
        </c:forEach>
        <c:if test="${count==0}">
            <error>Invalid</error>
        </c:if>
    </c:catch>
    <c:if test="${exception!=null}">
        <error>Error Details:
            <c:out value="${exception}"/>
        </error>
    </c:if>
</c:if>