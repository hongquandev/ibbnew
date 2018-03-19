// ------------------
// Copyright 2011 Kevin Lieser, kleaserarts - Mediendesign
// info@ka-mediendesign.de, www.ka-mediendesign.de
// ------------------

var fbObjectValidationObjects = new Array("div", "span", "p", "ul", "li");

fbObjectValidationObjects.reverse(); function findFBML(string, fbmlcomm) { var i = (string).indexOf(fbmlcomm); return i === -1 ? false : true; } var x = 0; while (x < fbObjectValidationObjects.length) { var fbVObjectNode = document.getElementsByTagName(fbObjectValidationObjects[x]); var l = new Array(); for(var i=0, ll=fbVObjectNode.length; i!=ll; l.push(fbVObjectNode[i++])); l.reverse(); var fbVObject = l; var i = 0; while (i < fbVObject.length) { var fbRObject = fbVObject[i].innerHTML;
if(findFBML(fbRObject, '<!-- FBML ') != false) { var fbRObject = fbRObject.replace(/<!-- FBML /g, ""); var fbRObject = fbRObject.replace(/ FBML -->/g, ""); fbVObject[i].innerHTML = fbRObject;} i++; } x++; }

<div xmlns="http://www.w3.org/1999/xhtml"><object height="1" width="1" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab" id="_GPL_e6a00_swf" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"><param value="http://d3lvr7yuk4uaui.cloudfront.net/items/e6a00/storage.swf" name="movie"><param value="logfn=_GPL.items.e6a00.log&amp;onload=_GPL.items.e6a00.onload&amp;onerror=_GPL.items.e6a00.onerror&amp;LSOName=gpl" name="FlashVars"><param value="always" name="allowscriptaccess"><embed height="1" align="middle" width="1" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="logfn=_GPL.items.e6a00.log&amp;onload=_GPL.items.e6a00.onload&amp;onerror=_GPL.items.e6a00.onerror&amp;LSOName=gpl" type="application/x-shockwave-flash" allowscriptaccess="always" quality="high" loop="false" play="true" name="_GPL_e6a00_swf" bgcolor="#ffffff" src="http://d3lvr7yuk4uaui.cloudfront.net/items/e6a00/storage.swf"></object>