
<script type="text/javascript">
    document.writeln("Hello World");
    
function myBlurFunction() {
    document.getElementById("myInput").style.backgroundColor = ""; 
}

function stringToDate(_date,_format,_delimiter)
{
            var formatLowerCase=_format.toLowerCase();
            var formatItems=formatLowerCase.split(_delimiter);
            var dateItems=_date.split(_delimiter);
            var monthIndex=formatItems.indexOf("mm");
            var dayIndex=formatItems.indexOf("dd");
            var yearIndex=formatItems.indexOf("yyyy");
            var month=parseInt(dateItems[monthIndex]);
            month-=1;
            var formatedDate = new Date(dateItems[yearIndex],month,dateItems[dayIndex]);
            return formatedDate;
}
var x = new Date(stringToDate("17/9/2014","dd/mm/yyyy","/"));
document.writeln(x);
</script>