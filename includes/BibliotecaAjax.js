//variáveis
var controleBox = 0;

function inicializaXmlHttp(){
	var xmlhttp;
  	try {
   		xmlhttp = new XMLHttpRequest();
  	} 
  	catch(ee){
   		try{
    		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
   		} 
   		catch(e){
    		try{
     			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			} 
    		catch(E){
     			xmlhttp = false;
			}
   		}
  }
  return xmlhttp;
}

var resultados;
function iniciaAjax(linksql, vars, div, acaoPosterior){
	var args = iniciaAjax.arguments.length;
	var xmlhttp=inicializaXmlHttp();
	xmlhttp.open("POST", linksql, true);
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState==4){
			t = xmlhttp.responseText
			resultados=t;		
			if (args >= 3){
				if(div)
					document.getElementById(div).innerHTML=unescape(resultados);	
				if(controleBox==1)
					setBox();
			}
			if(acaoPosterior)
				setTimeout(acaoPosterior,1);	
			
		}
		else{
			if(div)
				document.getElementById(div).innerHTML = strCarregando;//peq
		}
	}
	xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp.send(vars);
}

function iniciaAjax2(linksql, vars, div, acaoPosterior){
	var args = iniciaAjax2.arguments.length;
	var xmlhttp=inicializaXmlHttp();
	xmlhttp.open("POST", linksql, true);
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState==4){
			t = xmlhttp.responseText
			resultados=t;		
			if (args >= 3){
				if(div)
					document.getElementById(div).innerHTML=unescape(resultados);	
				if(controleBox==1)
					setBox();
			}
			if(acaoPosterior)
				setTimeout(acaoPosterior,1);
		}
		else{
			document.getElementById(div).innerHTML = '<img src="../images/carregando_pequeno.gif">';//peq
		}
	}
	xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp.send(vars);
}

function  alerta(texto, titulo, naomostrarefeito){
	if(!naomostrarefeito)
		exibeEfeito();
	if(!titulo)
		titulo="";
	iniciaAjax('../adm/ajx_boxAlerta.aspx','mensagem='+escape(texto)+'&titulo='+escape(titulo), 'divResultado');
}

function iniciaPost(linksql,div,form,acaoPosterior)
{	
	try
	{				
		var vars="";
		for(var i = 0; i < form.elements.length; i++) 
		{
			vars=vars + form.elements[i].name + "=" + escape(form.elements[i].value) + "&"
			if (form.elements[i].type == "text") {
				form.elements[i].value = "";
			}
		}
		while(vars.indexOf(" ")>=0)
		{
			vars=vars.replace(" ","%20");
		}			
		var xmlhttp=inicializaXmlHttp();
		xmlhttp.open("POST", linksql, true);		
		xmlhttp.onreadystatechange = function()
		{
			if (xmlhttp.readyState==4)		
			{
				var t = xmlhttp.responseText;
				t = unescape(t);
				document.getElementById(div).innerHTML=t;
				if(controleBox==1)
					setBox();
				if(acaoPosterior)
					setTimeout(acaoPosterior,1);
			}
		}
		xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xmlhttp.send(vars);		
		document.getElementById(div).innerHTML = strCarregando;
	}
	catch(e)
	{
	}
}

function toogle(objt){
	if(objt.style.display=='')	
		objt.style.display='none';
	else
		objt.style.display='';
}

var divResultado;
var strCarregando='<table border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF" class="texto_preto" style="border:0px #666666 solid;border-bottom:0px #333333 solid;border-right:0px #333333 solid;"><tr><td align="center"><span class="txtInterna"><img src="../images/carregando.gif" /></span></td></tr></table>';

function exibeEfeito(config){
	var div, div2;	
	var objSelect = document.getElementsByTagName("select");
	for (i=0;i<objSelect.length;i++){
		objSelect[i].style.visibility = "hidden";
	}	
	var tudo=document.getElementsByTagName("body")[0];
	tudo.scrollTop = 0;
	
	div2=document.createElement("div");
 	div2.id=("divJanela");
	var y,z;
	if (window.innerHeight) {// Firefox
		y = window.innerHeight + window.scrollMaxY;
		z = window.innerWidth + window.scrollMaxX;
	}else if (document.body.scrollHeight > document.body.offsetHeight){// all but Explorer Mac
		y = document.body.scrollHeight;
		z = document.body.scrollWidth;
	}else {// Explorer Mac;
		y = document.body.offsetHeight;
		z = document.body.offsetWidth;
	}
	
	div2.style.width = "100%";
	div2.style.height = y+"px";
	
	
	if(config)
		adicionaEvento(div2, "click", apagaEfeito);
	
	tudo.appendChild(div2);	
	div=document.createElement("div");
 	div.id=("divResultado");
	
	tudo.appendChild(div);
	
	document.onkeydown=function(event){tecla(event)};
	divResultado=document.getElementById("divResultado");
	document.getElementById("divResultado").focus();	
	
	controleBox=1;
	
}
 
function setBox(){
	var box = document.getElementById("divResultado");
	var x,y, xp, yp;
	if (box.scrollHeight > box.offsetHeight){// all but Explorer Mac
		x = box.scrollWidth;
		y = box.scrollHeight;
		xp = document.body.scrollWidth;
		yp = document.body.scrollHeight;
		box.style.top = eval(yp)+"px";//eval(yp)/2-eval(y)/2+"px";
	}
	else{// Explorer Mac;
		x = box.offsetWidth;
		y = box.offsetHeight;
		xp = document.body.offsetWidth;
		yp = document.body.offsetHeight;
		box.style.top = "20%";//eval(yp)/2-eval(y)/2+"px";
	}
	box.style.left = eval(xp)/2-eval(x)/2+"px";
	
}

function apagaEfeito(){
	var objSelect = document.getElementsByTagName("select");
	for (i=0;i<objSelect.length;i++){
		objSelect[i].style.visibility = "visible";
	}
  	var tudo=document.getElementsByTagName("body")[0]
	
  	var div1 = document.getElementById("divResultado");
	var div2 = document.getElementById("divJanela");	
	div1.innerHTML="";
  	tudo.removeChild(div1);
	tudo.removeChild(div2);

	document.getElementsByTagName("html")[0].style.overflow="";
	document.onkeydown='';
	controleBox=0;
}  

function tecla(e){
	if (!e) 
		e = window.event;	
var nomePg = document.location + "";

	if (e.keyCode==27 && nomePg.indexOf("index2.aspx")<0)// || e.keyCode==13
	{
		apagaEfeito();
		document.onkeydown='';
	}
}
	
var controleEdicao = 0;

function editaCelula(e){
	if(controleEdicao==0){
		controleEdicao=1;
		criaEventAndThis(e);
		
		var texto = source.innerHTML;
		source.innerHTML='';
		source.setAttribute("textoAtual", texto)
		
		var campo = document.createElement("textarea");
		campo.value = texto
		campo.id="textoEditar"+source.id;
		campo.className = 'input-branco';
		campo.style.width = '150px';
		campo.rows=8;
		source.appendChild(campo);
	
		var quebra = document.createElement("br");
		source.appendChild(quebra);
	
		var okButton = document.createElement("input");
		okButton.type = "image";
		okButton.className = '';
		okButton.id="btnOk"&+source.id;
		okButton.src="../images/btn_ok.gif";
		source.appendChild(okButton);
		
		var espaco = document.createElement("span");
		espaco.innerHTML = '&nbsp;&nbsp;';      
		source.appendChild(espaco);
			
		var cancelButton = document.createElement("input");
		cancelButton.type = "image";
		cancelButton.id="btnCancel"&+source.id;
		cancelButton.src="../images/btn_cancelar.gif";
		source.appendChild(cancelButton);
		
		removeEvento(source.parentNode, "click", editaCelula);
		adicionaEvento(okButton, "click", alteraCelula);
		adicionaEvento(cancelButton, "click", cancelaCelula);
	}
}

function limpaEventos(){
	try{
		if(source)
			cancelaCelula();
	}
	catch(e){
	}
}
function alteraCelula(e){
	var novoValor = document.getElementById("textoEditar"+source.id).value;
	if(novoValor=='')
		alert('Você deve informar pelo menos uma palavra chave');
	else{
		var xmlhttp=inicializaXmlHttp();
		xmlhttp.open("POST", pagina, true);
		xmlhttp.onreadystatechange = function(){
		/*	if (xmlhttp.readyState==4)
			{
				var t = xmlhttp.responseText
				alert(t)
			}*/
		}
		xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xmlhttp.send("nome="+escape(novoValor)+"&codigo="+source.getAttribute("cod"));
		source.innerHTML =unescape(novoValor.replace(/\+/g," "));
		adicionaEvento(source, "click", editaCelula);
		controleEdicao=0;
	}
	return false;
}
function cancelaCelula(e){
	source.innerHTML=source.getAttribute("textoAtual");
	adicionaEvento(source, "click", editaCelula);
	controleEdicao=0;
}
function adicionaEvento(campo, evento, funcao){
	if (campo.addEventListener)
		campo.addEventListener(evento, funcao, false)
	if (campo.attachEvent)
		campo.attachEvent("on"+evento, funcao)
}
function removeEvento(campo, evento, funcao){
	if (campo.removeEventListener)
		campo.removeEventListener(evento, funcao, false)
	if (campo.detachEvent)
		campo.detachEvent("on"+evento, funcao)
}
function criaEventAndThis(e){
	if(typeof(e)=='undefined')var e=window.event
	source=e.target?e.target:e.srcElement
	if(source.nodeType == 3)source = source.parentNode
}
//onClick em tabela
function criaOnClickTabela(){
	if(document.getElementById("ajxEditar")){
		adicionaEvento(document.getElementById("ajxEditar"), "click", editaCelula);
	}
}
var pagina;
window.onload=function(){
	if(document.getElementById("ajxEditar")){
		pagina = document.getElementById("ajxEditar").getAttribute("pagina");
		criaOnClickTabela();
	}
};
function gel(id){
	return document.getElementById(id);
}

function gels(name){
	return document.getElementsByName(name);
}

function inicializarEditor(tipo, elementos)
{
	if(!elementos)
		elementos="";
	
	tinyMCE.init({
		language: "pt", 
		mode : tipo,
		theme : "advanced",
		plugins : "inserirFigura,safari,pagebreak,style,layer,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
		
		theme_advanced_buttons1: "fontselect,fontsizeselect,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,forecolor,backcolor,|,media,charmap",
		theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,removeformat,|,search,replace,|,undo,redo,|,bullist,numlist,link,unlink,image,cleanup,code,|,preview,|,fullscreen,print",
		theme_advanced_buttons3: "",
		theme_advanced_buttons4: "", 
	
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,		
		elements: elementos
	});
}

function insertHtmlEditor(campo,html) {
	try{
		var content;
    	//tinyMCE.get(campo).execCommand('mceInsertContent', false, '<!-- htmlP -->');
	    //content=tinyMCE.get(campo).getContent();
    	//tinyMCE.get(campo).setContent(content.replace(/<!-- htmlP -->/, html));   
			tinyMCE.get(campo).execCommand('mceInsertRawHTML', false, html);
	}catch(e){
		alert(e);
		}
}