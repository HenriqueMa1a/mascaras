/**
* @description Classe de negócio agenda. 
* @author Kellen Nery
* @date 26/05/2020
* @version 1.0
* @package MDS
* @copyright 
*/ 

function IsDate(dateStr) {

    var datePat = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
    var matchArray = dateStr.match(datePat); // is the format ok?

    if (matchArray == null) {
    alert("Favor inserir a data corretamente Ex.: dd/mm/yyyy ou dd-mm-yyyy.");
    return false;
    }


    day = matchArray[1];
    month = matchArray[3]; // p@rse date into variables
    year = matchArray[5];

    if (month < 1 || month > 12) { // check month range
    alert("O mÃªs deve ser entre 1 e 12.");
    return false;
    }

    if (day < 1 || day > 31) {
    alert("O dia deve ser entre 1 e 31.");
    return false;
    }

    if ((month==4 || month==6 || month==9 || month==11) && day==31) {
    alert("O MÃªs "+month+" nÃ£o possui 31 dias!");
    return false;
    }

    if (month == 2) { // check for february 29th
    var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
    if (day > 29 || (day==29 && !isleap)) {
    alert("Fevereiro de " + year + " nÃ£o possui " + day + " dias!");
    return false;
    }
    }
    return true; // date is valid
}

	
function getDataAtual(){
	var data = new Date();
	
	return LPad(data.getDate(),2 ,"0") + "/" + LPad((data.getMonth()+1),2 ,"0") + "/" + data.getFullYear(); 
	
} 

function getDataHoraAtual(){
	var data = new Date();
	
	return LPad(data.getDate(),2 ,"0") + "/" + LPad((data.getMonth()+1),2 ,"0") + "/" + data.getFullYear() + " " + data.getHours() + ":" + data.getMinutes() + ":" + data.getSeconds() ; 
	
}

function LPad(str, len, pad) {
	return Pad(Trim(str), len, pad, 1);
}

function RPad(str, len, pad) {
	return Pad(Trim(str), len, pad, 3);
}

function Pad(str, len, pad, dir) {

	var STR_PAD_LEFT = 1;
	var STR_PAD_RIGHT = 2;
	var STR_PAD_BOTH = 3;
 
	if (typeof(len) == "undefined") { len = 0; }
	if (typeof(pad) == "undefined") { pad = ' '; }
	if (typeof(dir) == "undefined") { dir = STR_PAD_RIGHT; }
 
	if (len + 1 >= str.length) {
 
		switch (dir){
 
			case STR_PAD_LEFT:
				str = Array(len + 1 - str.length).join(pad) + str;
			break;
 
			case STR_PAD_BOTH:
				var right = Math.ceil((padlen = len - str.length) / 2);
				var left = padlen - right;
				str = Array(left+1).join(pad) + str + Array(right+1).join(pad);
			break;
 
			default:
				str = str + Array(len + 1 - str.length).join(pad);
			break;
 
		} // switch
 
	}
 
	return str;
 
}

function exibir_objeto(id, display)
{
    var objTemp = document.getElementById(id);
    if (objTemp)
        objTemp.style.display = display;
} 

function setValor(id, valor)
{
    var objTemp = document.getElementById(id);
    if (objTemp)
        objTemp.value = valor;
} 

function getValor(id)
{
	var valor = "";
    var objTemp = document.getElementById(id);
    if (objTemp)
        valor = objTemp.value;
    return valor;
} 


function getValorNumerico(objNome){
	var valor = 0;

	obj = document.getElementById(objNome);                
	if (obj){ 
		var texto = obj.value;
		texto = texto.replace(".","");
		texto = texto.replace(".","");
		texto = texto.replace(".","");
		texto = texto.replace(".","");
		texto = texto.replace(",",".");
		if(parseFloat(texto)>0)
			valor = parseFloat(texto);
		else
			valor = 0;
	} 
	return valor;
}


function formatarValorTexto(valor){

	var texto = valor.toFixed(2);
	texto = texto.replace(",","");      
	texto = texto.replace(",","");      
	texto = texto.replace(",","");      
	texto = texto.replace(",","");      
	texto = texto.replace(",","");      
	texto = texto.replace(",","");      
	texto = texto.replace(".",",");
	return texto;

}    

function formatarMoeda(num) {

	x = 0;
	if(num<0) {
		num = Math.abs(num);
		x = 1;
	}
	if(isNaN(num))
		num = "0";

	cents = Math.floor((num*100+0.5)%100);

	num = Math.floor((num*100+0.5)/100).toString();

	if(cents < 10)
		cents = "0" + cents;

	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
		num = num.substring(0,num.length-(4*i+3))+'.'+num.substring(num.length-(4*i+3)); ret = num + ',' + cents; if (x == 1) ret = ' - ' + ret;

	return ret;

}



function Maximo(ta, limit) 
{
	if (ta.value.length >= limit) {
		ta.value = ta.value.substring(0, limit-1);
	}
}

function Positivos(tecla,campo)
{
	if((tecla==9) || (tecla==13)){
		// Teclas especiais. (Tab, Enter)	
	} else if ((tecla>=48) && (tecla<=57)){
		// Numero;
	} else if ((tecla>=96) && (tecla<=105)){
		// Numero;
	} else {
		//alert(tecla);
		campo.value = "";
	}
	/* 
	if((tecla<96 || tecla>105) && (tecla<48 || tecla>57)){
		campo.value = "";
	}	
	*/
}

function NumerosPositivos(campo, evt)
{
	if ((window.event) || (evt)){
		//  Pegando o Evento
		if (evt){
			// FireFox, Mozila, ect.
			objEvento = evt;
			lngCaracter = objEvento.which;
		} else {
			// Internet Explorer.
			objEvento = window.event;
	        lngCaracter = objEvento.keyCode;
		}

		if((lngCaracter==9) || (lngCaracter==13)){
			// Teclas especiais. (Tab, Enter)	
		} else if ((lngCaracter>=48) && (lngCaracter<=57)){
			// Numero;
		} else if ((lngCaracter>=96) && (lngCaracter<=105)){
			// Numero;
		} else {
			//alert(tecla);
			campo.value = "";
		}

	}
}

function codifica(sStr) {
	return encodeURIComponent(sStr);
}
         function checkdate(data, campo) {
            var hoje = new Date();
            var anoAtual = hoje.getFullYear();
            var mesAtua = hoje.getMonth();
            var mesAtual = mesAtua+1;
//            var diaAtual = hoje.getDay();
            var barras = data.split("/");
            var error = "";
           if (barras.length == 3) {
               dia = barras[0];
               mes = barras[1];
               ano = barras[2];
               if((!isNaN(dia) && (dia > 0) && (dia < 32)) && (!isNaN(mes) && (mes > 0) && (mes < 13)) && (!isNaN(ano) && (ano.length == 4) && (ano >= 1900))) {
               		var ok = 1;
               } else {
               		var ok = "";
               }
               if (ok == "") {
                  error = "Formato de data invalido para => "+campo+"\n";
               }
            } else {
               error = "Formato de data invalido para => "+campo+"\n";
            }
            return error;
         }

function returnmsg(msg){
   alert(msg);
   history.back();
}
 
function trimAll(sString){
	while (sString.substring(0,1) == ' '){
		sString = sString.substring(1, sString.length);
	}
	while (sString.substring(sString.length-1, sString.length) == ' '){
		sString = sString.substring(0,sString.length-1);
	}
	return sString;
}
 
function startFocus() {
    var form = document.forms[0];
    form.elements[0].focus();
}

function setfocus(id) {
	if (document.getElementById(id))
		document.getElementById(id).focus();
}   

function startFocus2(numero_campo) {
    var form = document.forms[0];
    if(numero_campo == "") {
         form.elements[0].focus();
    } else {
         form.elements[0].focus();
    }
	//alert(form.elements[6].name);
}

/************************************
* Formata campo
************************************/
function formatar(campo, mask, key)
{
      var n = campo.value.length;
      var saida = mask.substring(0,1);
      var texto = mask.substring(n);
      if ((texto.substring(0,1) != saida) && key != 8)  {
         campo.value += texto.substring(0,1);
      }
}

/*
   function setfocus(campo) {
      var x=campo.focus()
      document.forms[0].x;
      return;
   } 
*/
	
function kpress(digito) {
	alert(digito);
}


// Atualizacao assincrona
/*
var req;

function loadXMLDoc(url,local)
{
var xmlhttp=false;

 try {
  xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
 } catch (e) {
  try {
   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  } catch (E) {
   xmlhttp = false;
  }
 }

if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
	try {
		xmlhttp = new XMLHttpRequest();
	} catch (e) {
		xmlhttp=false;
	}
}
if (!xmlhttp && window.createRequest) {
	try {
		xmlhttp = window.createRequest();
	} catch (e) {
		xmlhttp=false;
	}
}
    // Procura por um objeto nativo (Mozilla/Safari)
    if (xmlhttp) {
        req = xmlhttp;
        
        switch(local) {
           case("cad_geral"):
              req.onreadystatechange = cad_geral;
           break;
           case("entrega_domicilio"):
              req.onreadystatechange = entrega_domicilio;
           break;
           case("pega_exames"):
              req.onreadystatechange = pega_exames;
           break;
           
           default:
              req.onreadystatechange = noValue;           
           break;
        }        
        
        req.open("GET", url, true);
        req.send(null);
    // Procura por uma versao ActiveX (IE)
    } else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
        if (req) {
            req.onreadystatechange = processReqChange;
            req.open("GET", url, true);
            req.send();
        }
    }
}
*/
function processReqChange(){
	if (req.readyState == 4) {
		if (req.status == 200) {
			return true;
		} else {
			return false;
		}
	} else return false;
}

function lista_inputs() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         //alert(req.responseText);
         document.getElementById('lista_inputs').innerHTML = document.getElementById('lista_inputs').innerHTML+req.responseText;
      }
   }
}

function lista_exames() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         //alert(req.responseText);
         document.getElementById('lista_exame').innerHTML = req.responseText;
      }
   }
}



function lista_de_exames() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         document.getElementById('lista_de_exames').innerHTML = req.responseText;
      }
   }
}


/***************************************************************************************************************************************************
* Funções de Controle de Tela
***************************************************************************************************************************************************/
function habilitaForm(val) {
	if (document.forms[0]){
		if(document.forms[0].name!="pesquisa"){
			var inicio = 0;
		}else{
			var inicio = 1;
		}
		for(y=inicio;y<document.forms.length;y++) {
			var form = document.forms[y].length;
			for (var x=0; x<form; x++) {
				element = document.forms[y].elements[x];
				if(element.type == "hidden") {
					element.disabled=false;
				} else {
					if(!element.getAttribute("desabilitado")){
						if(val == "true") {
							element.disabled=true;
							element.style.backgroundColor="#DDDDDD";
						} else {
							element.disabled=false;
							element.style.backgroundColor="#FFFFFF";
						}
					}
				}
			}

		}   
	}
}

function habilitaCampo(objNome, val) {
	var obj = document.getElementById(objNome);                
	if (obj){ 
		if(val == "true") {
			obj.disabled=false;
			obj.style.backgroundColor="#FFFFFF";
		} else {
			obj.disabled=true;
			obj.style.backgroundColor="#DDDDDD";
		}
	}
}

function limpaForm() {
   for(y=0;y<document.forms.length;y++) {
      var form = document.forms[y];
      form.reset();
      for (var x=0; x<form.length; x++) {
         element = form.elements[x];
         if(element.name!="pesquisa"){
	         if(!element.getAttribute("orcamento") && element.type!="radio") {
	            if(element.type != "button") {
	               element.value="";
	            }
	         }         
         }
      }
   }
}

function GettheDate() {
   hoje = new Date()      // Definir Nova Data
   dia = hoje.getDate()   // Pegando a Data
   dias = hoje.getDay()   // Pegando o Dia da Data
   mes = hoje.getMonth()  // Pegando o Mes da Data
   ano = hoje.getFullYear()   // Pegado o Ano da Data
   
   if (dia < 10)
      dia = "0" + dia
      if (ano < 2000)
         ano = "19" + ano
         //Criando Vetores Com os Dias e os Meses
         NomeDia = new Array("Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado")
         NomeMes = new Array("janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro")
         //Funcao Para escrever a Data -->	
         strdata =  (""+NomeDia[dias]+" , "+dia+" de "+NomeMes[mes]+" de "+ano+"");
         return strdata;
}


function replace( texto, procurar, novo ){
    len = procurar.length;
    pos = texto.indexOf(procurar);
    while (pos > -1){
        parte1 = texto.substring(0, pos);
        parte2 = texto.substring(pos + len , texto.length);
        texto = parte1 + novo + parte2;
        pos = texto.indexOf(procurar);
    }
    return texto;
}

function maior_data_entrega(nova){
	if(nova && document.getElementById('data_entrega').value){
		var temp = nova.split("/");
    	if(temp[0].substr(0,1)=="0"){
    		temp[0] = temp[0].substr(1,2);
		}				
    	if(temp[1].substr(0,1)=="0"){
    		temp[1] = temp[1].substr(1,2);
		}		
   		datInicio = new Date(temp[2],temp[1],temp[0]);
    	datInicio.setMonth(datInicio.getMonth() - 1);
    	var temp = document.getElementById('data_entrega').value.split("/");
    	if(temp[0].substr(0,1)=="0"){
    		temp[0] = temp[0].substr(1,2);
		}		    	
    	if(temp[1].substr(0,1)=="0"){
    		temp[1] = temp[1].substr(1,2);
		}
    	datFim = new Date(temp[2],temp[1],temp[0]);
    	datFim.setMonth(datFim.getMonth() - 1); 		
    	if(datInicio>=datFim){
    		document.getElementById('data_entrega').value = nova;
    		return nova;
    	}else{
    		return document.getElementById('data_entrega').value;
    	}
	}else if(nova){
		return nova;
	} else 
		return '';
}

function addFavorito(url, title){

	if(window.sidebar){
		window.sidebar.addPanel(title, url, "");
	} else if(document.all){
		window.external.AddFavorite(url, title);
	} else if(window.opera && window.print){
		alert('Pressione Ctrl+D para adicionar aos favoritos.\nLogo após clicar em Ok');
	} else if(window.chrome){
		alert('Pressione Ctrl+D para adicionar aos favoritos.\nLogo após clicar em Ok');
	}

	/*
    if (window.sidebar) window.sidebar.addPanel(title, url,"");
    else if(window.opera && window.print){
        var mbm = document.createElement('a');
        mbm.setAttribute('rel','sidebar');
        mbm.setAttribute('href',url);
        mbm.setAttribute('title',title);
        mbm.click();
    }
    else if(document.all){window.external.AddFavorite(url, title);}
	*/
}
