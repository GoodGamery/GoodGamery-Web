
function scanlinks() {
 var links = document.getElementsByTagName("a");
 for (var i = 0; i < links.length; i++) {
  if (links[i].className == "postlink") {
   links[i].setAttribute("target", "_blank");
  }
 }
}