  
//function showResult(str, lang) {
function showResult(str) {
//    var bol = true;
  if (str.length==0) { 
    document.getElementById("finds").innerHTML="";
    document.getElementById("finds").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("finds").innerHTML=this.responseText;
//      document.getElementById("finds").str;
      document.getElementById("finds").style.border="1px solid #A5ACB2";
    }
  }
//  xmlhttp.open("GET","functions.php?q="+str+"&l="+lang,true);
  xmlhttp.open("GET","parser.php?q="+str,true);
  xmlhttp.send();
}
