  
//function showResult(str, lang) {
function showResult(str) {
//    var bol = true;
  if (str.length<=2) { 
    document.getElementById("thead").innerHTML="";
    document.getElementById("finds").innerHTML="";
    document.getElementById("finds").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200 && str.length > 2) {
  //mark scetch
        var rx = new RegExp(str, "g");
        var res = this.responseText.replace(rx,"<mark>" + str + "</mark>");
        document.getElementById("thead").innerHTML="<th colspan=\"1\">Engelska</th><th colspan=\"1\">Svenska</th>";

        document.getElementById("finds").innerHTML=res;
        document.getElementById("wiki").innerHTML="&nbsp;";
//      document.getElementById("finds").innerHTML=this.responseText;
//        document.getElementById("finds").style.border="1px solid #A5ACA5";
    }
  }
// language sorting
//  xmlhttp.open("GET","functions.php?q="+str+"&l="+lang,true);
  xmlhttp.open("GET","parser.php?q="+str,true);
  xmlhttp.send();
}