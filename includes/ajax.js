/* AJAX ------------------------------------------------------------------------------------------- */
 function createXMLHTTP() {
	var ajax;
	try {
		ajax = new ActiveXObject("Microsoft.XMLHTTP");
	} catch(e){
		try {
			ajax = new ActiveXObject("Msxml2.XMLHTTP");
			alert(ajax);
		} catch(ex){
			try {
				ajax = new XMLHttpRequest();
			} catch(exc) {
				alert("Esse browser não tem recursos para uso do Ajax");
				ajax = null;
			}
		}
		return ajax;
	}
    var arrSignatures = ["MSXML2.XMLHTTP.5.0", "MSXML2.XMLHTTP.4.0",
           "MSXML2.XMLHTTP.3.0", "MSXML2.XMLHTTP",
           "Microsoft.XMLHTTP"];
    for (var i=0; i < arrSignatures.length; i++){
		try {
			var oRequest = new ActiveXObject(arrSignatures[i]);
			return oRequest;
		} catch (oError){
		}
    }
    throw new Error("MSXML is not installed on your system.");
 }  
  
 function carregarAjax(strDiv, strLista, strParametro) {
    var oHTTPRequest = createXMLHTTP();

	if (document.getElementById("divLista") != null)
		document.getElementById("divLista").style.display = "none";
	if (document.getElementById("divAguarde") != null)
		document.getElementById("divAguarde").style.display = "";
	
    //alert(oHTTPRequest); 
    oHTTPRequest.open("post", strLista, true); //enviamos para a página que faz o select do que foi digitado e traz a lista preenchida.
    oHTTPRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    oHTTPRequest.onreadystatechange=function(){
        if (oHTTPRequest.readyState==4){
			if (document.getElementById(strDiv) != null) {
				document.getElementById(strDiv).innerHTML = oHTTPRequest.responseText;
				if (document.getElementById("divLista") != null)
					document.getElementById("divLista").style.display = "";
				if (document.getElementById("divAguarde") != null)
					document.getElementById("divAguarde").style.display = "none";
			} else {
				alert('Objeto não encontrado. (DIV=' + strDiv + ')');
			}
        }
	}
	if (strParametro != ''){
		oHTTPRequest.send(strParametro);
	} else {
		oHTTPRequest.send();
	}
 }
/*----------------------------------------------------------------------------------------------------------------------------------------*/
