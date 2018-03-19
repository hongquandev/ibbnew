
function showNode(id) {
	var success = document.getElementById('a'+id);
	
	if (success.style.display == "none") {
		
			document.getElementById('a'+id).style.display = "block";
			document.getElementById('img1'+id).src = "modules/general/templates/images/IBB_2.png";
			
		} else 	{
			document.getElementById('img1'+id).src = "modules/general/templates/images/IBB_1.png";
			document.getElementById('a'+id).style.display = "none";
	
		}
}

function Collapse() {	
}		

function toggle_visibility(id) {
	var e = document.getElementById(id);
if(e.style.display == 'none')
	e.style.display = 'block';
else
	e.style.display = 'none';
}

function mouseOver() {
	
document.getElementById("img1").style.display = "none";

}

startList = function() {
if (document.all&&document.getElementById) {
	navRoot = document.getElementById("nav");
	for (i=0; i<navRoot.childNodes.length; i++) {
		node = navRoot.childNodes[i];
		
		if (node.nodeName=="LI") {
			node.onmouseover=function() {
				this.className+=" over";
		  }
		  
	 	 node.onmouseout=function() {
	 	 		this.className=this.className.replace(" over", "");
	  		 }
	 	  }
	 	}
	 }
}
window.onload=startList;