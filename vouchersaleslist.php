
<form>
Search : <input type="text" size="30" onkeyup="showResult(this.value)"> (..by Firstname, Surname, or National ID)
<div id="livesearch"><?php include 'vouchersaleslist_search.php'; ?></div>
</form>

<script>
function showResult(str) {
  if (str.length===0) {
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState===4 && xmlhttp.status===200) {
      document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
      document.getElementById("livesearch").style.border="1px solid #A5ACB2";
    }
  };
  xmlhttp.open("GET","vouchersaleslist_search.php?q="+str+"&distributor=<?php echo $distributor; ?>",true);
  xmlhttp.send();
}
</script>