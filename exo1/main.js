/**
 * Main JS file
 */

 function colorChange(color){
     var elem = document.getElementById(color);
     elem.style.backgroundColor = color;
 }

 function fontChange(font){
    var elem = document.getElementById(font);
    elem.style.fontFamily = elem.innerText;
 }

 function fsizeChange(fsize){
    var elem = document.getElementById(fsize);
    elem.style.fontSize = elem.innerText;
 }