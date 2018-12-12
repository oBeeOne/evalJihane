/**
 * Main JS script
 */

 function init(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        document.getElementById("list").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "stmarc.php?cmd=init", true);
    xhttp.send();
 }

 function add(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        document.getElementById("list").innerHTML = this.responseText;
        }
    };
    var titre = document.getElementsByName('titre').value;
    var desc = document.getElementsByName('description').value;
    xhttp.open("GET", "stmarc.php?cmd=add&titre="+titre+"&description="+desc, true);
    xhttp.send();
 }

 function del(id){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(id) {
        if (this.readyState == 4 && this.status == 200) {
            var elem = document.getElementById(id);
            elem.parentNode.removeChild(elem);
        }
    };

    xhttp.open("GET", "stmarc.php?cmd=del&id="+id, true);
    xhttp.send();
 }

 function mod(id){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(id) {
        if (this.readyState == 4 && this.status == 200) {
        document.getElementById(id).innerHTML = this.responseText;
        }
    };

    var elem = document.getElementById(id);
    var title = elem.children[0].text;
    var desc = elem.children[1].text;
    xhttp.open("GET", "stmarc.php?cmd=mod&id="+id+"&titre="+titre+"&description="+desc, true);
    xhttp.send();
 }

 function edit(row){
    var elem = document.getElementById(row);
    var title = elem.children[0].text;
    var desc = elem.children[1].text;

    elem.innerHTML = '<td><input type="text" name="titre" value="'+title+'"></td><td><textarea name="description">'+desc+'</textarea></td><td><span onclick="mod('+row+')">EDIT</span></td>';

 }

 