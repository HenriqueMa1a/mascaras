/************************************
* Retorna uma msg e volta uma pagina
************************************/

function getDataAtual(){
	var data = new Date();
	
	return LPad(data.getDate(),2 ,"0") + "/" + LPad((data.getMonth()+1),2 ,"0") + "/" + data.getFullYear(); 
	
} 

function getDataHoraAtual(){
	var data = new Date();
	
	return LPad(data.getDate(),2 ,"0") + "/" + LPad((data.getMonth()+1),2 ,"0") + "/" + data.getFullYear() + " " + data.getHours() + ":" + data.getMinutes() + ":" + data.getSeconds() ; 
	
}

function LTrim(str){
	var whitespace = new String(" \t\n\r ");
	var s = new String(str);
	if (whitespace.indexOf(s.charAt(0)) != -1) {
	    var j=0, i = s.length;
	    while (j < i && whitespace.indexOf(s.charAt(j)) != -1)
		j++;
	    s = s.substring(j, i);
	}
	return s;
}

function RTrim(str){
	var whitespace = new String(" \t\n\r ");
	var s = new String(str);
	if (whitespace.indexOf(s.charAt(s.length-1)) != -1) {
	    var i = s.length - 1;       // Get length of string
	    while (i >= 0 && whitespace.indexOf(s.charAt(i)) != -1)
		i--;
	    s = s.substring(0, i+1);
	}
	return s;
}

function Trim(str){
	return RTrim(LTrim(str));
}

function Left(str, n){
	if (n <= 0)
	    return "";
	else if (n > String(str).length)
	    return str;
	else
	    return String(str).substring(0,n);
}

function Right(str, n){
    if (n <= 0)
       return "";
    else if (n > String(str).length)
       return str;
    else {
       var iLen = String(str).length;
       return String(str).substring(iLen, iLen - n);
    }
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
 
	if (typeof(len) == "undefined") { var len = 0; }
	if (typeof(pad) == "undefined") { var pad = ' '; }
	if (typeof(dir) == "undefined") { var dir = STR_PAD_RIGHT; }
 
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

function MM_findObj(n, d)
{
  var p,i,x;

  if(!d)
	d=document;
  if((p=n.indexOf("?"))>0&&parent.frames.length)
	{
	d=parent.frames[n.substring(p+1)].document;
	n=n.substring(0,p);
	}
  if(!(x=d[n])&&d.all)
	 x=d.all[n];
  for (i=0;!x&&i<d.forms.length;i++)
	  x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++)
	  x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById)
	 x=d.getElementById(n);
	 return x;
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


function clearCombo(cboNome){
    // while (obj.options.length)
    //    obj.remove(0);
    var objCombo = MM_findObj(cboNome);
    if (objCombo){
		objCombo.options.length = 0;
	}
}

function addItemCombo(cboNome, valor, descricao){
    var newElem;
    var where = (navigator.appName == "Microsoft Internet Explorer") ? -1 : null;

    var objCombo = MM_findObj(cboNome);
    if (objCombo){
		newElem = document.createElement("option");
		newElem.value = valor;
		newElem.text = descricao;
		objCombo.add(newElem, where);
	}
}


function setItemCombo(cboNome, valor){
    
    //var objCombo = document.getElementById(cboNome);
    var objCombo = MM_findObj(cboNome);
    if (objCombo){
        for (i=0; i<objCombo.options.length; i++){
            if (objCombo.options[i].value == valor){
                objCombo.options[i].selected = true;
                break;
            }
        }
    } else {
    	alert ('Não foi possível encontrar o objeto: '+cboNome);
    }
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
function returnmsg(msg)
{
   alert(msg);
   history.back();
}
  function trimAll(sString)
{
while (sString.substring(0,1) == ' ')
{
sString = sString.substring(1, sString.length);
}
while (sString.substring(sString.length-1, sString.length) == ' ')
{
sString = sString.substring(0,sString.length-1);
}
return sString;
}
 
   function startFocus() {

      var form = document.forms[0];
      form.elements[0].focus();

   }
   function setfocus(id) {

	document.getElementById(id).focus();
	
   }   
  function startFocus2(numero_campo) {

      var form = document.forms[0];
      if(numero_campo == "") {
         form.elements[0].focus();
      } else {
         form.elements[0].focus();
      }
	alert(form.elements[6].name);
   }

/************************************
* Lista de exames
************************************/
/* substituido
function mexame(op)
{
   if (img == "mais") {
      document.getElementById(op).style.display="block";
      document.images.imgoutros.src="img/menos.gif";
      img = re"menos";
   } else {
      document.getElementById(op).style.display="none";
      document.images.imgoutros.src="img/mais.gif";
      img = "mais";
   }
} */
function mexame(cmd)
{
   if (cmd == "mais") {
      document.getElementById("ep_" + (divmais - 1)).style.display="none";
      document.getElementById("ep_" + divmais).style.display="block";
      divmais = divmais + 1;
      divmenos = divmenos + 1;
   } else {
      document.getElementById("ep_" + divmenos).style.display="none";
      document.getElementById("ep_" + (divmenos - 1)).style.display="block";
      divmenos = divmenos - 1;
      divmais = divmais - 1;
   }
}

function ocultaexames(total)
{
   var i;
   for (i = 2; i <= total; i++) {
      document.getElementById("ep_" + i).style.display="none";
   }
}
/************************************
* Avanca campo qndo cheio
************************************/
/*function avancacmp(campo,value)
{
if (value.length==campo.maxLength)
	{
	next=campo.tabIndex
	if (next<document.forms[0].elements.length)
		{
		document.forms[0].elements[next].focus()
		}
	}
}*/
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

   function setfocus(campo) {
      var x=campo.focus()
      document.forms[0].x;
      return;
   }
	
	function kpress(digito) {
		alert(digito);
		}

    function envia(){
       alert("Dados Armazenados com sucesso");
       parent.main.location.href='cad_contato.php';
       }

         function checkOBS(campo,value) {
            var cnt = value.length;
            var cntobs = 250 - cnt;
            if(cnt > 249) {
               value = value.substring(0,249);
               campo.value = value;
               cntobs = 0;
            }
            document.getElementById("cntobs").innerHTML = cntobs;
         }
         
         function checkOBS2(campo,value) {
            var cnt = value.length;
            var cntobs = 600 - cnt;
            if(cnt > 599) {
               value = value.substring(0,599);
               campo.value = value;
               cntobs = 0;
            }
            document.getElementById("cntobs").innerHTML = cntobs;
         }
                  function textLineBreak(sString, sReplaceThis, sWithThis) {
if (sReplaceThis != "" && sReplaceThis != sWithThis) {
var counter = 0;
var start = 0;
var before = "";
var after = "";
while (counter<sString.length) {
start = sString.indexOf(sReplaceThis, counter);
if (start == -1) {
break;
} else {
before = sString.substr(0, start);
after = sString.substr(start + sReplaceThis.length, sString.length);
sString = before + sWithThis + after;
counter = before.length + sWithThis.length;
}
}
}
return sString;
}

         function checkOBS3(campo,value) {
            var cnt = value.length;
            var cntobs = 4000 - cnt;
            if(cnt > 3999) {
               value = value.substring(0,3999);
               campo.value = value;
               cntobs = 0;
            }
            document.getElementById("cntobs3").innerHTML = cntobs;
         }         

    function addtel(){
       var tel1 = document.cadastro.ddd.value;
       var tel2 = document.cadastro.telefone.value;
       document.cadastro.tels.value += tel1;
       document.cadastro.tels.value += " ";
       document.cadastro.tels.value += tel2;
       document.cadastro.tels.value += " \n";
    }

   function focusselect(campo)
   {
      var x=campo.select()
      var y=campo.focus()
      document.forms[0].x;
      document.forms[0].y;
   }

   function Selecione_paciente(cod_pac, nome, data, sexo, contato, ddd, tel)
   {
      alert("entrei");
      document.recepcao.cod_paciente.value = cod_pac;
      document.recepcao.paciente.value = nome;
      document.recepcao.nome.value = nome;
      document.recepcao.data_nasc.value = data;
      document.recepcao.data.value = data;
      document.recepcao.sexo.value = sexo;
      document.recepcao.contato.value = contato;
      document.recepcao.ddd.value = ddd;
      document.recepcao.tel.value = tel;
   }

// Atualizacao assincrona
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
           case("gerar_planos"):
              req.onreadystatechange = gerar_planos;
           break;           
           case("tipos_grupos"):
              req.onreadystatechange = tipos_grupos;
           break;           
           
           case("grupos_planos"):
              req.onreadystatechange = grupos_planos;
           break;           
           case("planos_gerados"):
              req.onreadystatechange = planos_gerados;
           break;           
           case("cad_geral1"):
              req.onreadystatechange = cad_geral1;
           break;
           case("cadastrar_guia"):
              req.onreadystatechange = cadastrar_guia;
           break;              
           case("lista_de_conferencia"):
              req.onreadystatechange = lista_de_conferencia;
           break;           
           case("reemissao_especial"):
              req.onreadystatechange = reemissao_especial;
           break;
           case("cad_geral2"):
              req.onreadystatechange = cad_geral2;
           break;
           case("digitar_resultados"):
              req.onreadystatechange = digitar_resultados;
           break;               
           case("listar_exames"):
              req.onreadystatechange = listar_exames;
           break;                      
           case("cad_geral3"):
              req.onreadystatechange = cad_geral3;
           break;
           case("reload_lista_conferencia"):
              req.onreadystatechange = reload_lista_conferencia;
           break;
           case("retorno"):
              req.onreadystatechange = retorno;
           break;
           case("operadora"):
              req.onreadystatechange = operadora;
           break;           
           case("CheckType"):
              req.onreadystatechange = CheckType;
           break;
           case("Add_Exame"):
              req.onreadystatechange = Add_Exame;
           break;
            case ("calcular_data"):
                 req.onreadystatechange = calcular_data;
           break;
            case ("plano_convenio"):
           	  req.onreadystatechange = plano_convenio;
           break;
           case("Add"):
              req.onreadystatechange = Add;
           break;
           case("load_gerais"):
              req.onreadystatechange = load_gerais;
           break;
                      case("Retorno_grafico_exames_dia"):
              req.onreadystatechange = Retorno_grafico_exames_dia;
           break;
                      case("procura_local"):
              req.onreadystatechange = cad_geral;
           break;
                      case("estatisticas_gerais_s1"):
              req.onreadystatechange = estatisticas_gerais_s1;
           break;
                      case("estatisticas_gerais_s2"):
              req.onreadystatechange = estatisticas_gerais_s2;
           break;
                      case("geragridmes"):
              req.onreadystatechange = geragridmes;
           break;
           case("geragridano"):
              req.onreadystatechange = geragridano;
           break;
           case("retorno_cad_paciente"):
              req.onreadystatechange = retorno_cad_paciente;
           break;
           case("lista_exame"):
              req.onreadystatechange = lista_exame;
           break;
           case("gravar_orcamento"):
              req.onreadystatechange = gravar_orcamento;
           break; 
           case("grid_pagamento"):
              req.onreadystatechange = grid_pagamento;
           break;           
           case("lista_de_exames"):
              req.onreadystatechange = lista_de_exames;
           break; 
           case("lista_exames_orc"):
              req.onreadystatechange = lista_exames_orc;
           break; 
           case("orcamentos"):
              req.onreadystatechange = orcamentos;
           break; 
           case("listar_pacientes"):
              req.onreadystatechange = listar_pacientes;
           break; 
           case("gera_lista_faturamento"):
              req.onreadystatechange = gera_lista_faturamento;
           break;
           case("planos_pendentes"):
              req.onreadystatechange = planos_pendentes;
           break;
           case("lista_exame_conf"):
              req.onreadystatechange = lista_exame_conf;
           break;
           case("closex"):
              req.onreadystatechange = closex;
           break;
           case("update_terceirizados"):
              req.onreadystatechange = update_terceirizados;
           break;
           case("areas"):
              req.onreadystatechange = areas;
           break;
           case("colpocitologia_check_fim"):
              req.onreadystatechange = colpocitologia_check_fim;
           break;
           case("colpocitologia_check_fim_retorno"):
              req.onreadystatechange = colpocitologia_check_fim_retorno;
           break;
           case("load_pacientes"):
              req.onreadystatechange = load_pacientes;
           break;
           case("load_atendimentos"):
              req.onreadystatechange = load_atendimentos;
           break;
           case("load_atend_exames"):
              req.onreadystatechange = load_atend_exames;
           break;
           case("search_recepcao"):
              req.onreadystatechange = search_recepcao;
           break;
           case("retorno_impressao"):
              req.onreadystatechange = retorno_impressao;
           break;
           case("refresh_ateriores"):
              req.onreadystatechange = refresh_ateriores;
           break;           
           case("retorno_delete"):
              req.onreadystatechange = retorno_delete;
           break;
           case("exames_conf"):
              req.onreadystatechange = exames_conf;
           break;
           case("alert_plano"):
              req.onreadystatechange = alert_plano;
           break;
           case("alertliberadonaopago"):
              req.onreadystatechange = alertliberadonaopago;
           break;
           case("campos_exames"):
              req.onreadystatechange = campos_exames;
           break;
           case("gravar_fat2"):
              req.onreadystatechange = gravar_fat2;
           break;
           case("lista_pendentes"):
              req.onreadystatechange = lista_pendentes;
           break;
           case("lista_pendentes2"):
              req.onreadystatechange = lista_pendentes2;
           break;
           case("lista_exames"):
              req.onreadystatechange = lista_exames;
           break;          
           case("lista_examez"):
              req.onreadystatechange = lista_examez;
           break;
           case("obs_exame"):
              req.onreadystatechange = obs_exame;
           break;
           case("busca_exms_ok"):
              req.onreadystatechange = busca_exms_ok;
           break;
           case("busca_exms_ok2"):
              req.onreadystatechange = busca_exms_ok2;
           break;
           case("gera_plan"):
              req.onreadystatechange = gera_plan;
           break;
           case("retorno_atend"):
              req.onreadystatechange = retorno_atend;
           break;
           case("retorno_agend"):
              req.onreadystatechange = retorno_agend;
           break;
           case("opcoes"):
              req.onreadystatechange = opcoes;
           break;           
           case("opcoes_grupo"):
              req.onreadystatechange = opcoes_grupo;
           break;      
           case("retorno_observacao"):
              req.onreadystatechange = retorno_observacao;
           break;         
           case("finaliza_digitacao"):
              req.onreadystatechange = finaliza_digitacao;
           break;        
           case("resultado_atual"):
              req.onreadystatechange = resultado_atual;
           break;
           case("resultado_anterior"):
              req.onreadystatechange = resultado_anterior;
           break;
           case("check_conf"):
              req.onreadystatechange = check_conf;
           break;
           case("result_antibiograma"):
              req.onreadystatechange = result_antibiograma;
           break;
           case("checks_paciente"):
              req.onreadystatechange = checks_paciente;
           break;
           case("checks_paciente_agendamento"):
              req.onreadystatechange = checks_paciente_agendamento;
           break;
           case("result_bacteria"):
              req.onreadystatechange = result_bacteria;
           break;
           case("result_bacteria2"):
              req.onreadystatechange = result_bacteria2;
           break;           
           case("result_antibiotico"):
              req.onreadystatechange = result_antibiotico;
           break;                            
           case("resultado_campo"):
              req.onreadystatechange = resultado_campo;
           break;
           case("lista_marcados"):
              req.onreadystatechange = lista_marcados;
           break;
           case("lista_marcados_agendamento"):
              req.onreadystatechange = lista_marcados_agendamento;
           break;
           case("lista_marcadosx"):
              req.onreadystatechange = lista_marcadosx;
           break;
           case("lista_inputs"):
              req.onreadystatechange = lista_inputs;
           break;           
           case("cad_exame_p1"):
              req.onreadystatechange = cad_exame_p1;
           break;
           case("cad_exame_gravar"):
              req.onreadystatechange = cad_exame_gravar;
           break;
           case("cad_exame_p1_2"):
              req.onreadystatechange = cad_exame_p1_2;
           break;        
           case("cad_exame_fn"):
              req.onreadystatechange = cad_exame_fn;
           break;
           case("cad_exame_vn"):
              req.onreadystatechange = cad_exame_vn;
           break;
           case("cmp_masc_in1"):
              req.onreadystatechange = cmp_masc_in1;
           break;
           case("data_paciente"):
              req.onreadystatechange = data_paciente;
           break;
           case("data_paciente_agendamento"):
              req.onreadystatechange = data_paciente_agendamento;
           break;
           case("data_medico"):
              req.onreadystatechange = data_medico;
           break;
           case("data_origem"):
              req.onreadystatechange = data_origem;
           break;           
           case("data_plano"):
              req.onreadystatechange = data_plano;
           break;                      
           case("pega_subgrupo"):
              req.onreadystatechange = pega_subgrupo;
           break;
           case("exames_read"):
              req.onreadystatechange = cad_geral;
           break;
           case("entrega2_temp"):
              req.onreadystatechange = cad_geral;
           break;
           case("entrega"):
              req.onreadystatechange = entrega;
           break;
           case("fatura2"):
              req.onreadystatechange = fatura2;
           break;
           case("fatura"):
              req.onreadystatechange = fatura;
           break;
           case("procura_local"):
              req.onreadystatechange = cad_geral;
           break;
           case("lista_selecionados"):
              req.onreadystatechange = lista_selecionados;
           break;
           case("lista_cmp_exa"):
              req.onreadystatechange = lista_cmp_exa;
           break;
           case("atendimentos"):
              req.onreadystatechange = atendimentos;
           break;
           case("agendamentos"):
              req.onreadystatechange = agendamentos;
           break;
           case("checkar_bac"):
              req.onreadystatechange = checkar_bac;
           break;
           case("checkar_bac2"):
              req.onreadystatechange = checkar_bac2;
           break;
           case("confirm_fim"):
              req.onreadystatechange = confirm_fim;
           break;
           case("novo_mp"):
              req.onreadystatechange = novo_mp;
           break;
           case("gcombox"):
              req.onreadystatechange = gcombox;
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

function processReqChange()
{
   if (req.readyState == 4) {
      if (req.status == 200) {
         return true
      } else {
         return false
      }
   }
}

function cad_geral() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         //alert(req.responseText);
         document.getElementById('resultado').innerHTML = req.responseText;
      }
   }
}
function entrega_domicilio() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         //alert(req.responseText);
        if(checkdate(document.forms[0].data.value,"Data 'Data'") == "") {
            buscardados('relatorio_domicilio_temp.php?acao=load&data='+document.forms[0].data.value,'cad_geral');    
        }            
      }
   }
}
function gerar_planos() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         var response = req.responseText.split("[o]");         
         document.getElementById('resultado').innerHTML = response[2];
         buscardados('gerar_plano_temp.php?acao=planos_gerados&grupo='+response[0]+'&cod_local='+response[1],'planos_gerados');
      }
   }
}

function tipos_grupos() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         document.getElementById('resultado3').innerHTML = req.responseText;
      }
   }
}



function grupos_planos() {
   if (req.readyState == 4) {
      if (req.status == 200) {
      //alert(req.responseText);
         var response = req.responseText.split("[o]");
         document.getElementById('resultado2').innerHTML = response[3]; 
         //gerar(response[0],response[1],response[2]);
         //buscardados('gerar_plano_temp.php?acao=planos_gerados&grupo='+response[0]+'&cod_local='+response[1],'planos_gerados');         
      }
   }
}

function planos_gerados() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         //alert(req.responseText);
         //document.getElementById('planos_gerados').innerHTML = req.responseText;
      }
   }
}

function listar_exames() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         //alert(req.responseText);
         document.getElementById('lista_exame').innerHTML = req.responseText;
      }
   }
}

function retorno_observacao() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         document.getElementById('ObsExame').value = textLineBreak(req.responseText, "<br />", "\n");
      }
   }
}
function finaliza_digitacao() {
   if (req.readyState == 4) {
      if (req.status == 200) {      
//alert(req.responseText);
 		 opener.jQuery('#pesquisa').trigger('reloadGrid');		
         var response = req.responseText.split("[o]");
         var cod_atend = response[0];
         var cod_paciente = response[1];
         var cod_grupo = response[2];         
         var plano_trabalho = response[3];
         var paciente_fim = response[4];
         var cod_atend_new = response[5];               
         var cod_paciente_new = response[6];
         var paciente = response[7];
         var data_nasc = response[8];
         var sexo = response[9];
         var fim = response[10];
         var senha = response[11];
         var cod_atend_exame = response[12];
         var nregs = response[13];
         var digitar_resultados = response[14];
         var digitar_ficha = response[15];
         var ficha_trabalho = response[16];
         var recusados = response[17];
         if(plano_trabalho > 0) {
             var tem_plano_trabalho = 1;
         } else {
             var tem_plano_trabalho = 0;
         }         
         if(ficha_trabalho > 0) {
             plano_trabalho = ficha_trabalho;
         } else {
             var tem_ficha_trabalho = 0;
         }         
         	if(fim == 0 && paciente_fim == 1) {
                if(digitar_resultados!=1){
         		    window.location.href='resultado.php?cod_paciente='+cod_paciente_new+'&paciente='+paciente+'&cod_atend='+cod_atend_new+'&cod_grupo='+cod_grupo+'&data_nasc='+data_nasc+'&sexo='+sexo+'&cod_plan='+plano_trabalho+'&tem_plano_trabalho='+tem_plano_trabalho+'&digitar_resultados='+digitar_resultados+'&digitar_ficha='+digitar_ficha;
                }else{
                    window.location.href='resultado.php?cod_atend='+cod_atend+'&cod_paciente='+cod_paciente+'&cod_grupo='+cod_grupo+'&sexo='+sexo+'&ae_status='+status+'&data_nasc='+data_nasc+'&paciente='+paciente+'&recepcao=1'+'&cod_atend_exame='+cod_atend_exame+'&limparresultados=1&digitar_resultados='+digitar_resultados+'&digitar_ficha='+digitar_ficha;
                }
         	} else if(fim == 0 && paciente_fim == 0) {
                if(digitar_resultados!=1){
         		    buscardados('resultado_temp.php?acao=resultado_atual&cod_paciente='+cod_paciente+'&cod_atend='+cod_atend+'&cod_grupo='+cod_grupo+'&cod_plan='+plano_trabalho+'&tem_plano_trabalho='+tem_plano_trabalho+'&digitar_resultados='+digitar_resultados+'&digitar_ficha='+digitar_ficha,'resultado_atual');
                }else{
                    plano_trabalho = 0;
                    buscardados('resultado_temp.php?acao=resultado_atual&cod_paciente='+cod_paciente+'&cod_atend='+cod_atend+'&cod_grupo='+cod_grupo+'&cod_plan='+plano_trabalho+'&tem_plano_trabalho='+tem_plano_trabalho+'&digitar_resultados='+digitar_resultados+'&digitar_ficha='+digitar_ficha,'resultado_atual');                
                }
             } else if(fim == 1 && digitar_ficha==1) {
                var directto="ficha_trabalho.php";
                window.location.href=directto;                             
         	} else if(fim == 1 && digitar_resultados==0) {
         		if(recusados==1){
         			var directto="plano_trabalho_recusados.php";
         		}else{
         			var directto="plano_trabalho.php";
         		}	            
                window.location.href=directto;         	
         	}else{
				setTimeout("window.close()",1000);
            }   
       }
   }
}
function reemissao_especial() {
   if (req.readyState == 4) {
      if (req.status == 200) { 
           var response = req.responseText.split("[o]");
         document.getElementById('atendimento').value = response[0];
         document.getElementById('resultado1').innerHTML = response[1];
      }
   }
}  
function cad_geral1() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         //alert(req.responseText);
         document.getElementById('resultado1').innerHTML = req.responseText;
      }
   }
}
function cad_geral2() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         //alert(req.responseText);
         document.getElementById('resultado2').innerHTML = req.responseText;
      }
   }
}
function cad_geral3() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         //alert(req.responseText);
         document.getElementById('resultado3').innerHTML = req.responseText;
      }
   }
}
function reload_lista_conferencia() {
   if (req.readyState == 4) {
      if (req.status == 200) {         
         if(req.responseText != "") {
         	document.getElementById('resultado2').innerHTML = "";
		    document.getElementById('resultado3').innerHTML = "";
            cod_local = document.forms[0].local.value;
         	buscardados('cad_conferencia_temp.php?acao=load_atendimentos&cod_local='+cod_local,'cad_geral1');
         }
      }
   }
}
function pega_exames() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         //alert(req.responseText);
         document.getElementById('pega_exames').innerHTML = req.responseText;
      }
   }
}

function retorno() {
   if (req.readyState == 4) {
      if (req.status == 200) {
      
         document.getElementById('retorno').innerHTML = req.responseText;
      }
   }
}
function CheckType() {
   if (req.readyState == 4) {
      if (req.status == 200) {
      	var response = req.responseText;
        if(response == "t") {
        	document.forms[1].Codigo.disabled=false;
        } else {
        	document.forms[1].Codigo.disabled=true;	
        }
      }
   }
}
function load_gerais() {
   if (req.readyState == 4) {
      if (req.status == 200) {
      	 var response = req.responseText.split("||");
         document.getElementById('diario').innerHTML = response[0];
         document.getElementById('mensal').innerHTML = response[1];
      }
   }
}
function retorno_cad_paciente() {
   if (req.readyState == 4) {
      if (req.status == 200) {
      	 var response = req.responseText.split("|");
      	 alert(response[0]);
      	 if(document.forms[1].da_recepcao.value != "") {
      	 
      	 	var tipo_volta = document.cad_paciente.tipo_volta.value;
      	 	if(response[5] == 0) {  
      	 		if(tipo_volta == "agendamento") {
				    if(response[4]){
	                    opener.document.getElementById("convenio").options[response[4]].selected=true;
	                }                   
      	 			opener.document.agendamento.dddx.value = response[1];
      	 			opener.document.agendamento.telefone.value = response[2];      	 	
      	 			opener.verifica_tipo_fat_unimed();
      	 		} else {
	                if(response[4]){
	                    opener.document.getElementById("convenio").options[response[4]].selected=true;
	                }      	 		
      	 			opener.document.recepcao.dddx.value = response[1];
      	 			opener.document.recepcao.telefone.value = response[2];      	 	
      	 			opener.verifica_tipo_fat_unimed();
      	 		}
      	 		close();
			}
      	 } else {      	 	
      	 	//procurar(document.cad_paciente.nome.value);
      	 }
      	 if(response[5] == 0) {
      	 	location.href='cad_paciente.php';
      	 	//parent.location.href='cad_paciente.php';
      	 }
      	 
         //parent.location.href='cad_paciente.php';
      	 //if(response[3] == "a") {
      	 
      	 //} 
         //document.getElementById('diario').innerHTML = response[0];
         //document.getElementById('mensal').innerHTML = response[1];
      }
   }
}
function gera_lista_faturamento() {
   if (req.readyState == 4) {
      if (req.status == 200) {  
      	 var response = req.responseText.split("|");
         document.getElementById('resultado').innerHTML = response[0];
         if(response[1]!=""){
            document.forms[0].total.value = response[1];
         }else{
            document.forms[0].total.value = "";
         }
      }
   }
}
function estatisticas_gerais_s1() {
   if (req.readyState == 4) {
      if (req.status == 200) {

         document.getElementById('diario').innerHTML = req.responseText;

      }
   }
}
function estatisticas_gerais_s2() {
   if (req.readyState == 4) {
      if (req.status == 200) {

         document.getElementById('mensal').innerHTML = req.responseText;
      }
   }
}
function geragridano() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         document.getElementById('grid').innerHTML = req.responseText;
      }
   }
}
function geragridmes() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         document.getElementById('grid').innerHTML = req.responseText;
      }
   }
}
function Retorno_grafico_exames_dia() {
   if (req.readyState == 4) {
      if (req.status == 200) {
      document.getElementById('grafico').innerHTML = "";
         document.getElementById('grafico').innerHTML = req.responseText;
      }
   }
}

function load_pacientes() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         document.getElementById('pacientes').innerHTML = req.responseText;
      }
   }
}
function load_atendimentos() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         var response = req.responseText.split("[x]");
         document.getElementById('atendimentos').innerHTML = response[0];
         var sexo = response[1];
         var idade = response[2];
         var cod_atend = response[3];
         var cod_paciente = response[5];          
         document.forms[0].sexo.value=sexo;
         document.forms[0].idade.value=idade;
         document.forms[0].cod_atend.value=cod_atend;
         document.forms[0].cod_paciente.value=cod_paciente;
      }
   }
}
function load_atend_exames() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         var response = req.responseText.split("[x]");
         document.getElementById('atend_exames').innerHTML = response[0];
         document.forms[0].exames.value = response[1];
      }
   }
}
function planos_pendentes() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         document.getElementById('planos_pendentes').innerHTML = req.responseText;
      }
   }
}

function search_recepcao() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         document.getElementById('resultado').innerHTML = req.responseText;
         //buscardados("recepcao_temp.php?acao='atendimentos'&cod_paciente=","atendimentos");
      }
   }
}
function areas() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         document.getElementById('areas').innerHTML = req.responseText;
      }
   }
}

function gera_plan() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         var response = req.responseText.split("|");
         document.getElementById('resultado').innerHTML = response[0];
         document.forms[0].cod_grupo.value = response[1];
      }
   }
}

function retorno_impressao() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         var response = req.responseText.split("**");
	 var cod_paciente = response[0];
	 var paciente = response[1];
	 var medico = response[2];
	 var desc_convenio = response[3];
	 var hoje = response[4];
	 var data_entrega = response[5];
	 var ficha_unica = response[6];
	 var tipo_convenio = response[7];
	 var ch = response[8];
	 var cod_atendimento = response[9];
	 if(ficha_unica == 0 || ficha_unica == "0") {
	    alert("Segunda via realizada com sucesso !\\nRetire os cupons da impressora.");
	 } else {
	    //var nw=window.open('imprimir/ficha_unica.php?cod_paciente='+cod_paciente+'&paciente='+paciente+'&medico='+medico+'&desc_convenio='+desc_convenio+'&hoje='+hoje+'&data_entrega='+data_entrega+'&tipo_convenio='+tipo_convenio+'&ch='+ch+'&cod_atendimento='+cod_atendimento, 'NWX', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,fullscreen=no,resizable=yes','')
	    //document.getElementById("spyframe").src = "imprimir/ficha_unica.php?cod_paciente="+cod_paciente+"&paciente="+paciente+"&medico="+medico+"&desc_convenio="+desc_convenio+"&hoje="+hoje+"&funcionario="+funcionario+"&data_entrega="+data_entrega+"&tipo_convenio="+tipo_convenio+"&ch="+ch+"&cod_atendimento="+cod_atendimento;
         }
         //document.getElementById("spyframe").src = "imprimir/ficha_unica.php?cod_paciente='+cod_paciente+"&paciente="+paciente+"&medico="+medico+"&desc_convenio="+desc_convenio+"&hoje="+hoje+"&funcionario="+funcionario+"&data_entrega="+data_entrega+"&lista_desc_exames="+lista_desc_exames+"&lista_ficha_conf="+lista_ficha_conf+"&lista_cod="+lista_cod;   
      }
   }
}

function checks_paciente_agendamento() {
   if (req.readyState == 4) {
      if (req.status == 200) {
	    var response = req.responseText.split("|");
		var count = response.length;
		f = document.forms[0];
    	f.agendamento.value = 1;
		var nome = f.paciente.value;
		var cod_paciente = response[0];
		if(count < 3) {
	   		//novoa();	
            var parsed = parseInt(document.getElementById("autocomplete_paciente").value);
            if(parsed == document.getElementById("autocomplete_paciente").value) {
            	alert("Paciente nao cadastrado.");
			}	   		
	   		f.cod_AC_paciente.value = cod_paciente;
	   		nome = response[1]; 
       		f.data_nasc.value = "";
	   		f.identidade.value = "";
	   		document.getElementById('autocomplete_origem').value = "";
	   		f.telefone.value = "";
	   		document.getElementById('autocomplete_origem').value = "";
	   		f.dddx.value = "21";
	   		f.pedido.value = "";
	   		f.matricula.value = "";
	   		f.data_coleta.value = "";
	   		f.hora_coleta.value = "";
	   		f.endereco_coleta.value = "";
	   		f.referencia_coleta.value = "";
	   		f.observacoes.value = "";
	   		f.medicamentos.value = "";
	   		f.cod_guia.value = "";
	   		f.AC_medico.value = "";
	   		f.cod_AC_medico.value = "";
       		f.data_entrega.value = "";	   
	   		f.banco.value = "";
	   		f.agencia.value = "";
	   		f.conta.value = "";
	   		f.numero.value = "";
	   		f.nome_cheque.value = "";
	   		f.vencimento.value = "";
	   		f.usuario_pagamento.value = "";
	   		f.data_pagamento.value = "";
	   		f.tipo_pagamento.value = "";
	   		document.getElementById("sexo").options[0].selected=true;
       		document.getElementById("convenio").options[0].selected=true;       		
	   		document.getElementById("diabetico").options[0].selected=true;
       		f.data_nasc.focus();
       		document.getElementById('resultado').innerHTML = "";           
       		document.getElementById('lista_marcados').innerHTML = "<table width='100%' cellpading='0' cellspacing='0' border='0'><tr>"+
            						"<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'></td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Código</td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Mat</td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Coleta</td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Previsao</td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-bottom:1px solid #000000;'>Valor</td>"+
                                "</tr>";
            verifica_tipo_fat_unimed();
	} else { 	
			buscardados("agendamento_temp.php?acao=agendamentos&cod_pac="+response[0],"agendamentos");	
	   		f.cod_pacx.value=response[0];
	   		f.cod_AC_paciente.value = cod_paciente;
	   		f.AC_paciente.value = response[1];
	   		f.matricula.value = response[9];
	   		document.getElementById('autocomplete_origem').value = "";
	   		f.cod_guia.value = "";
	   		f.dddx.value = response[3];
	   		document.getElementById('autocomplete_origem').value = "";
	   		f.pedido.value = "";       
	   		f.data_nasc.value = response[2];
	   		f.telefone.value = response[4];
	   		if(response[5]) {	   
	       		document.getElementById("sexo").options[response[5]].selected=true;
       		} else {
           		document.getElementById("sexo").options[0].selected=true;
       		}
	   		document.getElementById("convenio").options[response[6]].selected=true;       	   		
       		document.getElementById("diabetico").options[response[8]].selected=true;
       		f.matricula.value = response[9];
       		f.identidade.value = response[14];
       		//f.cod_AC_medico.value = response[10];
       		//f.AC_medico.value = response[11];
       		//f.entrada_particular.value = "";
       		//document.getElementById("tipo_entrada").options[0].selected=true;
       		//document.getElementById("forma_pagamento").options[0].selected=true;
	   		//document.getElementById("pago").value = "Nao";
	   		//document.getElementById("liberadoimp").options[0].selected=true;
       		f.cod_AC_medico.value = "";
       		f.AC_medico.value = "";
       		f.endereco.focus();
       		f.endereco.value = response[12];
       		document.getElementById('agendamentos').innerHTML = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr height='15'><td align='center' colspan='2'  style='background-color: #000000;color:#FFF;border: 1px solid #000000;'>AGENDAMENTOS</td></tr></table>";
       		document.getElementById('resultado').innerHTML = "";
       		document.getElementById('lista_marcados').innerHTML = "<table width='100%' cellpading='0' cellspacing='0' border='0'><tr>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'></td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Código</td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Mat</td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Coleta</td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Previsao</td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-bottom:1px solid #000000;'>Valor</td>"+
                                "</tr>";
			verifica_tipo_fat_unimed();                                
	   		}
    }
   }
}

function checks_paciente() {
   if (req.readyState == 4) {
      if (req.status == 200) {
	  	var response = req.responseText.split("|");
		var count = response.length;		
		f = document.forms[0];
		var nome = f.paciente.value;
		var cod_paciente = response[0];
		document.getElementById("ficha_de_trabalho").disabled=true;    
		if(count < 3) {
	   		//novoa();	
            var parsed = parseInt(document.getElementById("autocomplete_paciente").value);
            if(parsed == document.getElementById("autocomplete_paciente").value) {
            	alert("Paciente nao cadastrado.");
			}	   		
	   		f.cod_AC_paciente.value = cod_paciente;
	   		nome = response[1]; 
       		f.data_nasc.value = "";
	   		f.identidade.value = "";
	   		f.telefone.value = "";
	   		f.dddx.value = "21";
	   		f.pedido.value = "";
	   		f.matricula.value = "";
	   		f.data_coleta.value = "";
	   		f.hora_coleta.value = "";
	   		f.endereco_coleta.value = "";
	   		f.referencia_coleta.value = "";
	   		f.observacao.value = "";
	   		f.cod_guia.value = "";
	   		f.AC_medico.value = "";
	   		f.cod_AC_medico.value = "";
       		f.data_entrega.value = "";	   
	   		f.banco.value = "";
	   		f.agencia.value = "";
	   		f.conta.value = "";
	   		f.numero.value = "";
	   		f.nome_cheque.value = "";
	   		f.vencimento.value = "";
	   		f.usuario_pagamento.value = "";
	   		f.data_pagamento.value = "";
	   		f.tipo_pagamento.value = "";
	   		//f.entrada_particular.value = "0.00";
       		//document.getElementById("tipo_entrada").options[0].selected=true;
       		//document.getElementById("forma_pagamento").options[0].selected=true;
	   		document.getElementById("pago").value = "Nao";
	   		document.getElementById("liberadoimp").options[0].selected=true;
	   		document.getElementById("sexo").options[0].selected=true;
       		document.getElementById("convenio").options[0].selected=true;       		
	   		document.getElementById("diabetico").options[0].selected=true;
	   		document.getElementById('autocomplete_origem').value = "";
       		f.data_nasc.focus();
	   		//f.identidade.focus();
       		//document.getElementById('atendimentos').innerHTML = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr height='15'><td align='center' colspan='2'  style='background-color: #000000;color:#FFF;border: 1px solid #000000;'>ATENDIMENTOS</td></tr></table>";
       		document.getElementById('resultado').innerHTML = "";           
       		document.getElementById('lista_marcados').innerHTML = "<table width='100%' cellpading='0' cellspacing='0' border='0'><tr>"+
            						"<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'></td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Código</td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Mat</td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Coleta</td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Previsao</td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-bottom:1px solid #000000;'>Valor</td>"+
                                "</tr>";
                       /*document.getElementById('lista_marcados').innerHTML = "<caption class='caption'>Exames Marcados</caption><tr><td align='center' width='4%' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'></td><td align='center' width='24%' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Código</td>"+
                        "<td align='center' width='10%' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Mat</td>"+
                        "<td align='center' width='20%' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Coleta</td>"+
                        "<td align='center' width='20%' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Previsao</td>"+
                        "<td align='center' width='25%' bgcolor='#F9F9F9' style='border-bottom:1px solid #000000;'>Valor</td>"+
                     "</tr>"+                     
                  "</table>";*/
           	document.getElementById('lista_pen').innerHTML = "";	
           	document.getElementById("pago").value = "Nao";
           	verifica_tipo_fat_unimed();
	} else { 	
	   		f.data_coleta.value = "";
	   		f.hora_coleta.value = "";
	   		f.endereco_coleta.value = "";
	   		f.referencia_coleta.value = "";
	   		f.observacao.value = "";
	   		f.pedido.value = "";
	   		//f.banco.value = "";
	   		//f.agencia.value = "";
	   		//f.conta.value = "";
	   		//f.numero.value = "";
	   		//f.nome_cheque.value = "";
	   		//f.vencimento.value = "";
	   		f.usuario_pagamento.value = "";
	   		//f.data_pagamento.value = "";
	   		//f.tipo_pagamento.value = "";
	   		f.data_entrega.value = "";
           	//f.entrada_particular.value = "0.00";
           	//document.getElementById("tipo_entrada").options[0].selected=true;
           	//document.getElementById("forma_pagamento").options[0].selected=true;
	   		document.getElementById("pago").value = "Nao";
	   		document.getElementById("liberadoimp").options[0].selected=true;	   
	   		document.getElementById('autocomplete_origem').value = "";
	   		f.cod_pacx.value=response[0];
	   		f.cod_AC_paciente.value = cod_paciente;
	   		f.AC_paciente.value = response[1];
       		f.identidade.value = response[14];       
	   		f.matricula.value = response[9];
	   		f.dddx.value = response[3];
	   		f.cpf.value = response[13];
	   		f.data_nasc.value = response[2];
	   		f.telefone.value = response[4];
	   		if(response[5].length>0) {	   
	       		document.getElementById("sexo").options[response[5]].selected=true;
       		} else {
				document.getElementById("sexo").options[0].selected=true;
       		}       		
       		if(response[6]){
       			document.getElementById("convenio").options[response[6]].selected=true;       
       		}else{
       			document.getElementById("convenio").options[0].selected=true;       
       		}       		
        	if(response[8]=="t"){
            	document.getElementById("diabetico").options[1].selected=true;    
        	}else if(response[8]="f"){
				document.getElementById("diabetico").options[2].selected=true;    
        	}else{
				document.getElementById("diabetico").options[0].selected=true;    
        	}
           	f.matricula.value = response[9];
           	//f.cod_AC_medico.value = response[10];
           	//f.AC_medico.value = response[11];           	   
	        f.cod_guia.value = "";
           	//f.cod_AC_medico.value = "";
           	//f.AC_medico.value = "";
           	//f.AC_medico.focus();
           	f.endereco.value = response[12];
           	//document.getElementById('atendimentos').innerHTML = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr height='15'><td align='center' colspan='2'  style='background-color: #000000;color:#FFF;border: 1px solid #000000;'>ATENDIMENTOS</td></tr></table>";
           	buscardados("recepcao_temp.php?acao=atendimentos&cod_pac="+response[0],"atendimentos");           
           	document.getElementById('resultado').innerHTML = "";
           	document.getElementById('lista_marcados').innerHTML = "<table width='100%' cellpading='0' cellspacing='0' border='0'><tr>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'></td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Código</td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Mat</td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Coleta</td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Previsao</td>"+
                                    "<td align='center' bgcolor='#F9F9F9' style='border-bottom:1px solid #000000;'>Valor</td>"+
                                "</tr>";
                       /*document.getElementById('lista_marcados').innerHTML = "<caption class='caption'>Exames Marcados</caption><tr><td align='center' width='4%' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'></td><td align='center' width='24%' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Código</td>"+
                        "<td align='center' width='10%' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Mat</td>"+
                        "<td align='center' width='20%' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Coleta</td>"+
                        "<td align='center' width='20%' bgcolor='#F9F9F9' style='border-right: 1px solid #000000;border-bottom:1px solid #000000;'>Previsao</td>"+
                        "<td align='center' width='25%' bgcolor='#F9F9F9' style='border-bottom:1px solid #000000;'>Valor</td>"+
                     "</tr>"+                     
                  "</table>";*/
           	document.getElementById('lista_pen').innerHTML = "";	
           	document.getElementById("pago").value = "Nao";
           	//f.sexo.focus();
           	f.endereco.focus();
           	verifica_tipo_fat_unimed();
	    }
      }
   }
}
function calcular_data() {
   if (req.readyState == 4) {
      if (req.status == 200) {
      	//alert(req.responseText);
      	document.getElementById('data_entrega').value = maior_data_entrega(req.responseText);
		//document.getElementById('data_entrega').value = req.responseText;	  
      }
   }
}
function result_antibiotico() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         document.getElementById('result_antibiotico').innerHTML = req.responseText;
      }
   }
}

function gcombox() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         //alert(req.responseText);
         if( req.responseText ) {
            document.getElementById('dcomboy').innerHTML = req.responseText;
         } else {
            document.getElementById('dcomboy').innerHTML = "<select id='dcombo' style='width:155px;'><option></option></select>";
         }
      }
   }
}

function result_bacteria() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         document.getElementById('result_bacteria').innerHTML = req.responseText;
         //procurar('pegaantibiotico','','result_antibiotico');
      }
   }
}

/*function result_bacteria() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         document.getElementById('result_bacteria').innerHTML = req.responseText;
         procurar('pegaantibiotico','','result_antibiotico');
      }
   }
}*/

function result_bacteria2() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         document.getElementById('result_bacteria').innerHTML = req.responseText;
      }
   }
}

function result_antibiograma() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         document.getElementById('result_antibiograma').innerHTML = req.responseText;
         //procurar('pegabacteria','','result_bacteria');
      }
   }
}
function alertliberadonaopago() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         if(req.responseText) {
            alert(req.responseText);
            window.opener.callback2();	
         } else {
         
         }	
      }
   }
}
function alert_plano() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         if(req.responseText) {
            alert(req.responseText);	
         } else {
         
         }	
      }
   }
}

function noValue() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         return false
      }
   }
}

function lista_pendentes() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         //document.getElementById('lista_pen').innerHTML = "";
         document.getElementById('lista_pen').innerHTML = document.getElementById('lista_pen').innerHTML+req.responseText;
      }
   }
}

function busca_exms_ok() {
   if (req.readyState == 4) {
      if (req.status == 200) {
      	 
         document.getElementById('normais').innerHTML = req.responseText;
         
         
      }
   }
}
function busca_exms_ok2() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         document.getElementById('urgente').innerHTML = req.responseText;
         buscardados('impressao_temp.php?acao=busca','busca_exms_ok');
      }
   }
}
function lista_pendentes2() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         document.getElementById('lista_pen').innerHTML = "";
         document.getElementById('lista_pen').innerHTML = document.getElementById('lista_pen').innerHTML+req.responseText;
      }
   }
}


function pega_subgrupo() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         document.getElementById('x_subgrupo').innerHTML = req.responseText;
      }
   }
}

function retorno_atend() {
   if (req.readyState == 4) {
      if (req.status == 200) {                            
      var f=document.forms[0];
      f.cod_exames_campos_dinamicos.value='';
      
	 var response = req.responseText.split("**");	 	 
	 var count = response.length;
     var cod_paciente = response[0];
     var msg = response[1];
     var error = response[2];       	   
	 var paciente = response[3];
	 var medico = response[4];
	 var desc_convenio = response[5];
	 var hoje = response[6];	 
	 //var data_entrega = response[7];
	 var data_entrega = maior_data_entrega(response[7]);
	 var ficha_unica = response[8];
	 var tipo_convenio = response[9];
	 var ch = response[10];
     var cod_atendimento = response[11];
	 var pagamento = response[12];

	 var subtotal = f.total.value;
     var dvalor = f.dvalor.value;
     var dpercentual = f.dpercentual.value;
     
     if(dpercentual>0){
        var tp_desconto = '$$';
        var desconto = dpercentual;
     }else if(dvalor>0){
        var tp_desconto = '$';
        var desconto = dvalor;
     }else{
        var tp_desconto = '';
        var desconto = 0;
     }
     
	   f.pedido.value = cod_atendimento;
	   f.pago.disabled=false;
       
	   if(error == "") {
        if(pagamento != 1)
	       alert(response[1]); 
	  // if(ficha_unica == 0 || ficha_unica == "0") {	   
	      
	   //} else {
       
        protocolo=0;
        if(document.forms[0].verif_medico.value != medico || document.forms[0].verif_data_entrega.value !=data_entrega || document.forms[0].verif_convenio.value != desc_convenio){
            protocolo=1;
        }
       if(pagamento==1){
           document.forms[0].verif_medico.value = medico;
           document.forms[0].verif_data_entrega.value = data_entrega;
           document.forms[0].verif_convenio.value = desc_convenio;       
           var nw=window.open('pagamento.php?imprimir=1&coleta=1&desc_convenio='+desc_convenio+'&cod_atendimento='+cod_atendimento+'&cod_paciente='+cod_paciente+'&valor_subtotal='+subtotal+'&desconto='+desconto+'&tp_desconto='+tp_desconto, 'Pagamento', 'width=850,height=350,menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,fullscreen=no,resizable=no','')       
       }else if(protocolo==1){
            document.forms[0].verif_medico.value = medico;
            document.forms[0].verif_data_entrega.value = data_entrega;
            document.forms[0].verif_convenio.value = desc_convenio;
            //var nx=window.open('imprimir/ficha_unica.php?coleta=1&cod_paciente='+cod_paciente+'&paciente='+paciente+'&medico='+medico+'&desc_convenio='+desc_convenio+'&hoje='+hoje+'&data_entrega='+data_entrega+'&tipo_convenio='+tipo_convenio+'&ch='+ch+'&cod_atendimento='+cod_atendimento, 'Ficha Unica', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,fullscreen=no,resizable=yes','')	      
            document.getElementById("spyframe").src ='imprimir/ficha_unica.php?cod_paciente='+cod_paciente+'&paciente='+paciente+'&medico='+medico+'&desc_convenio='+desc_convenio+'&hoje='+hoje+'&data_entrega='+data_entrega+'&tipo_convenio='+tipo_convenio+'&ch='+ch+'&cod_atendimento='+cod_atendimento;
       }
            
	   //var nw=window.open('imprimir/ficha_unica.php?cod_paciente='+cod_paciente+'&paciente='+paciente+'&medico='+medico+'&desc_convenio='+desc_convenio+'&hoje='+hoje+'&data_entrega='+data_entrega+'&tipo_convenio='+tipo_convenio+'&ch='+ch+'&cod_atendimento='+cod_atendimento, 'NWX', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,fullscreen=no,resizable=yes','')	      
	     // var nw=window.open('imprimir/ficha_unica.php?cod_paciente='+cod_paciente+'&paciente='+paciente+'&medico='+medico+'&desc_convenio='+desc_convenio+'&hoje='+hoje+'&data_entrega='+data_entrega+'&tipo_convenio='+tipo_convenio+'&ch='+ch+'&cod_atendimento='+cod_atendimento, 'NWX', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,fullscreen=no,resizable=yes','')	      
	    //  document.getElementById("spyframe").src = "imprimir/ficha_unica.php?cod_paciente="+cod_paciente+"&paciente="+paciente+"&medico="+medico+"&desc_convenio="+desc_convenio+"&hoje="+hoje+"&funcionario="+funcionario+"&data_entrega="+data_entrega+"&tipo_convenio="+tipo_convenio+"&ch="+ch;
          //}
           	//alert("Atendimento realizado com sucesso!");
              document.getElementById("ficha_de_trabalho").disabled=false;
           buscardados('recepcao_temp.php?acao=atendimentos&cod_pac='+cod_paciente,'atendimentos');      
           
           
      	  } else {
      	  	var f=document.forms[0];
      	  	f.status_atend.value = 0;
      	  	alert(error);
      	  
      	  }
      }
   }
}

function imprimir_ficha_trabalho(){
    var f = document.forms[0];
    var cod_atendimento = f.cod_atendimento.value;
    var cod_paciente = f.cod_paciente.value;
    if(cod_paciente && cod_atendimento)
        var nx=window.open('imprimir/ficha_unica.php?cod_paciente='+cod_paciente+'&cod_atendimento='+cod_atendimento, 'Ficha Unica', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,fullscreen=no,resizable=yes','')	      
}
function retorno_agend() {
   if (req.readyState == 4) {
      if (req.status == 200) {
	   var response = req.responseText.split("**");	 	 
	   var count = response.length;
       var cod_paciente = response[0];
       var msg = response[1];
       var error = response[2];       	   
	   var paciente = response[3];
	   var medico = response[4];
	   var desc_convenio = response[5];
	   var hoje = response[6];
	   var data_entrega = maior_data_entrega(response[7]);
	   //var data_entrega = response[7];
	   var ficha_unica = response[8];
	   var tipo_convenio = response[9];
	   var ch = response[10];
	   var cod_agendamento = response[11];
	   if(error == "") {
	   //if(ficha_unica == 0 || ficha_unica == "0") {	   
	   //   alert(response[1]);
	   //} else {	 
	      //var nw=window.open('imprimir/agendamento.php?cod_paciente='+cod_paciente+'&paciente='+paciente+'&medico='+medico+'&desc_convenio='+desc_convenio+'&hoje='+hoje+'&data_entrega='+data_entrega+'&tipo_convenio='+tipo_convenio+'&ch='+ch+'&cod_agendamento='+cod_agendamento, 'NWX', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,fullscreen=no,resizable=yes','')	      
	      //var nw=window.open('imprimir/agendamento.php?cod_paciente='+cod_paciente+'&paciente='+paciente+'&medico='+medico+'&desc_convenio='+desc_convenio+'&hoje='+hoje+'&data_entrega='+data_entrega+'&tipo_convenio='+tipo_convenio+'&ch='+ch+'&cod_agendamento='+cod_agendamento, 'NWX', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,fullscreen=no,resizable=yes','')	      
	      //document.getElementById("spyframe").src = "imprimir/ficha_unica.php?cod_paciente="+cod_paciente+"&paciente="+paciente+"&medico="+medico+"&desc_convenio="+desc_convenio+"&hoje="+hoje+"&funcionario="+funcionario+"&data_entrega="+data_entrega+"&tipo_convenio="+tipo_convenio+"&ch="+ch;
           //}
           document.getElementById("spyframe").src ='imprimir/ficha_unica_agendamento.php?cod_paciente='+cod_paciente+'&paciente='+paciente+'&medico='+medico+'&desc_convenio='+desc_convenio+'&hoje='+hoje+'&data_entrega='+data_entrega+'&tipo_convenio='+tipo_convenio+'&ch='+ch+'&cod_agendamento='+cod_agendamento;
           alert("Agendamento realizado com sucesso!");
           document.forms[0].pedido.value=cod_agendamento;
           buscardados('agendamento_temp.php?acao=agendamentos&cod_pac='+cod_paciente,'agendamentos');
      	  } else {
      	  	      	  	var f=document.forms[0];
      	  	f.status_atend.value = 0;
      	  	alert(error);
      	  
      	  }
      }
   }
}
function retorno_delete() {
   if (req.readyState == 4) {
      if (req.status == 200) {

	 alert(req.responseText);   
	 novoa();
      }
   }
}

function update_terceirizados() {
   if (req.readyState == 4) {
      if (req.status == 200) {
        document.getElementById("lista_marcados").innerHTML = "";
        var cod_atend = req.responseText;
	var value = parseInt(document.forms[0].convenio.value);
	var string = 1;
	buscardados('recepcao_temp.php?acao=lista_marcadosx&cod_atend='+cod_atend+'&convenio='+codifica(value)+'&string='+string,'lista_marcadosx');
	
      }
   }
}

function check_conf() {
   if (req.readyState == 4) {
      if (req.status == 200) {
	if(req.responseText != "") {
         	var response = req.responseText.split("|");         	
         	var count = response.length;
         	if(count > 0) {  	               	
         		var cod_atend = response[0];         	
         		var cod_paciente = response[1];
         		var cod_exame = response[2];
         		var cod_grupo = response[3];
         		var form = document.conferencia;          
         		var idade = form.idade.value;
         		var sexo = form.sexo.value;
         		var nw=window.open('laudos/laudo_temp.php?cod_atend='+cod_atend+"&cod_paciente="+cod_paciente+"&cod_exame="+cod_exame+"&idade="+idade+"&sexo="+sexo, 'NWX', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,fullscreen=no,resizable=yes','')
         		//document.getElementById("spyframe").src = "laudos/laudo_temp.php?cod_atend="+cod_atend+"&cod_paciente="+cod_paciente+"&cod_exame="+cod_exame+"&idade="+idade+"&sexo="+sexo;                  
         	}	
         } 
      }
   }
}

function cad_exame_gravar() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         //document.getElementById('js_result').innerHTML = req.responseText;
         var response = req.responseText.split("|");
         var count = response.length;
         f = document.forms[1];
         //alert(req.responseText);
         //alert(count);
         acao = f.acao.value;
         //alert(acao);
         if( acao == "alterar" ) {
            alert(response[1]);
            //buscardados('cad_exame_temp.php?acao=cmp_masc_in1&cod='+response[0],'cmp_masc_in1');
            //AbreDiv('cmp_masc',response[0]);            
            //if(response[3] == "gravar") {
            	procurar(response[2],13);
            //} 	 	
         } else {
            //AbreDiv('cmp_masc',response[0]);
            document.cad_exame_geral.cod.value=response[0];
            document.cad_exame_geral.acao.value="alterar";
            //procurar('');
            alert(response[1]);
         }
      }
   }
}

function cad_exame_p1() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         //document.getElementById('js_result').innerHTML = req.responseText;
         var response = req.responseText.split("|");
         var count = response.length;
         f = document.forms[1];
         //alert(req.responseText);
         //alert(count);
         acao = f.acao.value;
         //alert(acao);
         if( acao == "alterar" ) {
            alert(response[1]);
            buscardados('cad_exame_temp.php?acao=cmp_masc_in1&cod='+response[0],'cmp_masc_in1');
            //AbreDiv('cmp_masc',response[0]);            
            if(response[3] == "gravar") {
            	procurar(response[2],13);
            } 	 	
         } else {
            //AbreDiv('cmp_masc',response[0]);
            document.cad_exame_geral.cod.value=response[0];
            document.cad_exame_geral.acao.value="alterar";
            //procurar('');
            alert(response[1]);
         }
      }
   }
}

function cad_exame_p1_2() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         //alert(req.responseText);
         var response = req.responseText.split("|");
         if( response[1] ) {         	
            alert(response[1]);
            buscardados('cad_exame_temp.php?acao=cmp_masc_in1&cod='+document.cad_exame_geral.cod.value,'cmp_masc_in1');		    	
            if(response[1] == "Campo cadastrado com sucesso !") {
            	limpacampo();
            }
         }
         if(response[0] == "val_normal") {
         	var cod_faixa = document.forms[2].cod_faixa.value;
         	var cod_exame = document.forms[1].cod.value;	
         	buscardados('cad_exame_temp.php?acao=val_normal_in1&cod='+cod_exame,'cad_exame_fn');         
         	document.getElementById("val_normal_in2").innerHTML = "";
         	//buscardados('cad_exame_temp.php?acao=val_normal_in2&cod_faixa='+cod_faixa+'&cod_exame='+cod_exame,'cad_exame_vn');
         }
         //
         //alert(cod);
         //alert(cod_faixa);
         //
       
      }
   }
}
/*function closewindow() 
{
	mywindow=window.open('entrega_detalhes2.php','Nome','status=no,scrollbars=yes,resizable=no,width=550,height=450,left=150,top=100')
	mywindow.close()
} */
function entrega() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         if(req.responseText) {
         	alert(req.responseText);
      	 }
      }
   }
}

function fatura2() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         if(req.responseText) {
         	document.getElementById("fat_atual").innerHTML = req.responseText;
         	
      	 } 
      }
   }
}

function gravar_fat2() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         if(req.responseText) {
         	var response = req.responseText.split("|");
         	alert(response[0]);
         	
         	buscardados('faturar_2_temp.php?acao=fat_atua&cod_convenio='+response[1],'fatura2');
         	document.forms[0].nome.value = "";
         	document.forms[0].matricula = "";
         	document.forms[0].procura = "";
		document.getElementById("lista_marcados").innerHTML = "";
		document.getElementById("resultado").innerHTML = "";
		document.forms[0].nome.focus();
         	
      	 }
      }
   }
}

function fatura() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         if(req.responseText) {
         var response = req.responseText.split("|");
         	document.pesquisa.total.value = req.responseText;
         	//alert(document.pesquisa.dados_atendimentos.value);
      	 }	
      }
   }
}

function lista_marcadosx() {
   if (req.readyState == 4) {
      if (req.status == 200) {   
     
         var response = req.responseText.split("[o]");
         var count = response.length;
         document.getElementById("lista_marcados").innerHTML = "";
         document.getElementById("lista_marcados").innerHTML = response[0];
         document.forms[0].codigos.value = "";
         document.forms[0].codigos.value = response[1];
         var numero_exames = response[3];
         document.forms[0].total_ex.value = numero_exames;
         document.forms[0].total_ex_par.value = numero_exames;   
         if(document.getElementById('agendamento').value!=1){
            buscardados('recepcao_temp.php?acao=retorno_pendentes&cod_atend='+response[2],'lista_pendentes2');
         }
         
      }
   }
}
function Add_Exame() {
   if (req.readyState == 4) {
      if (req.status == 200) {   
    
         var response = req.responseText.split("[o]");
         if(trimAll(response[3]) == "inicio") {
         	lista = document.getElementById('lista_exames').innerHTML;
         	if(lista.search("<!--INICIO:"+response[2]+"-->") != -1) {
                 	alert("Este exame já está na lista !");
         	} else {               
         		document.getElementById("lista_exames").innerHTML = document.getElementById("lista_exames").innerHTML+response[0];
	 		document.forms[1].dados_exames.value = document.forms[1].dados_exames.value+response[1];
      	 	}
      	 } else {
      	 	document.getElementById("lista_exames").innerHTML = response[0];
      	 	document.cad_convenio.dados_exames.value = response[1];        	 
      	 }	
      }
   }
 }

/*function Add() {
   if (req.readyState == 4) {
      if (req.status == 200) {
      
         var response = req.responseText.split("xxx");
         //if(response[3] == "inicio") {
         var dados = document.forms[1].dados.value;
         var check = dados.indexOf(response[1]);
         if(check != "-1") {
      	
         	 alert("Este item já está na lista!");
         
         } else {
         
		 document.getElementById("lista").innerHTML = document.getElementById("lista").innerHTML+response[0];
	 	 document.forms[1].dados.value = document.forms[1].dados.value+response[1];            
         	
         
         }
         	/*lista = document.getElementById('lista').innerHTML;
         	if(lista.search("<!--INICIO:"+response[2]+"-->") != -1) {
                 	alert("Este item já está na lista!");
         	} else {               
         		document.getElementById("lista").innerHTML = document.getElementById("lista").innerHTML+response[0];
	 		document.forms[1].dados.value = document.forms[1].dados.value+response[1];
      	 	}*/
      	 //} else {
      	 //	document.getElementById("lista_exames").innerHTML = response[0];
      	 //	document.cad_convenio.dados_exames.value = response[1];        	 
      	 //}	
      /*}
   }
 }*/
function lista_marcados() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         var response = req.responseText.split("[o]");
        
         if(response[4]) {
         
         	alert(response[4]);
         	
         } else {
 
         var count = response.length;
         var exames_pendentes = "";
         for (var x=0; x < document.forms[0].length; x++) {
         	if(document.forms[0].elements[x].getAttribute("cb_material")) {
         		if(document.forms[0].elements[x].checked == false) {
         			exames_pendentes += document.forms[0].elements[x].id+"[rr]";	
         		}
         	}
         }	
         var conteudo = document.getElementById('lista_marcados').innerHTML;
         if(conteudo.search("</tbody></table>") != -1) {
            conteudo = conteudo.replace("</tbody></table>", "");
         }
         
         document.getElementById('lista_marcados').innerHTML = conteudo+response[0];
         if(exames_pendentes != "") {
         	//exames_pendentes = exames_pendentes.substring(0,exames_pendentes.length-4)   
         	var split_ex_pend = exames_pendentes.split("[rr]");
            	var nex_pend = split_ex_pend.length;
            	for(i=0; i<nex_pend-1; i++) {         
         		document.getElementById(split_ex_pend[i]).checked=false;	
         	}
         }
         //alert(document.getElementById('lista_marcados').innerHTML);
         var f = document.forms[0];
         var total_par = Number(f.total_ex_par.value);            
         f.total_ex_par.value = total_par+1;
         var data_entrega = maior_data_entrega(response[7]);         
         //var data_entrega = response[7];
         if(response[3] == 1) {
            var subtotal = document.forms[0].subtotal.value;            
            var total = document.forms[0].total.value;
            cntSubtotal = parseFloat(subtotal)+parseFloat(response[2]);
            if(f.dpercentual.value != "0" && f.dvalor.value == "0") {
            	cntTotal = cntSubtotal - ((cntSubtotal * f.dpercentual.value) / 100);		
            } else {
                cntTotal = cntSubtotal - f.dvalor.value;
            }
  	//cntTotal = Math.round(cntTotal*100)/100	
            //cntTotal = parseFloat(total)+parseFloat(response[2]);
            document.forms[0].subtotal.value=cntSubtotal.toFixed(2);
            document.forms[0].total.value=cntTotal.toFixed(2);
         }   
         if(response[5]) {
         	alert(response[5]);
         }
         if(response[6] == "t") {
         	obs_exame(response[1]);
         }        
         document.forms[0].data_entrega.value = data_entrega;
         if(document.forms[0].pedido.value != "") {
           
            var cod_atendimento = document.forms[0].pedido.value;
            var cod_exame = response[1];
            var valor_exame = response[2]; 
            var cod_convenio = f.convenio.value;
            var cod_paciente = f.cod_AC_paciente.value;
            f.codigos.value += cod_exame+"-1-0-"+valor_exame+"|";            
            document.getElementById("spyframe").src = "recepcao_temp.php?acao=add_ex&cod_atendimento="+cod_atendimento+"&cod_exame="+cod_exame+"&valor_exame="+valor_exame+"&cod_convenio="+cod_convenio+"&cod_paciente="+cod_paciente;
            setTimeout("refresh_lista_m("+cod_atendimento+","+cod_convenio+")",500);
            
         }

         }
         var a = "";
         
         buscardados('recepcao_temp.php?acao=search&search='+codifica(a),'cad_geral');
         //TERCEIRIZAÇAO 
         //alert(response[8]);     
         if(response[8].length>0){
            abrir_informacoes(response[8]);
         }
         //TERCEIRIZAÇAO          
         //document.getElementById('resultado').innerHTML = "";
         //alert(response[0]);
      }
   }
}
function lista_marcados_agendamento() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         var response = req.responseText.split("[o]");
         if(response[4]) {
         
         	alert(response[4]);
         	
         } else {
         var count = response.length;
         var conteudo = document.getElementById('lista_marcados').innerHTML;
         if(conteudo.search("</tbody></table>") != -1) {
            conteudo = conteudo.replace("</tbody></table>", "");
         }
         
         document.getElementById('lista_marcados').innerHTML = conteudo+response[0];
         
         var f = document.forms[0];
         var total_par = Number(f.total_ex_par.value);            
         f.total_ex_par.value = total_par+1;
         var data_entrega = maior_data_entrega(response[7]);
         //var data_entrega = response[7];
         if(response[3] == 1) {
            var subtotal = document.forms[0].subtotal.value;            
            var total = document.forms[0].total.value;
            cntSubtotal = parseFloat(subtotal)+parseFloat(response[2]);
            if(f.dpercentual.value != "0" && f.dvalor.value == "0") {
            	cntTotal = cntSubtotal - ((cntSubtotal * f.dpercentual.value) / 100);		
            } else {
                cntTotal = cntSubtotal - f.dvalor.value;
            }
  	//cntTotal = Math.round(cntTotal*100)/100	
            //cntTotal = parseFloat(total)+parseFloat(response[2]);
            document.forms[0].subtotal.value=cntSubtotal.toFixed(2);
            document.forms[0].total.value=cntTotal.toFixed(2);
         }
         if(response[5]) {
         	alert(response[5]);
         }
         if(response[6] == "t") {
         	obs_exame(response[1]);
         }          
         document.forms[0].data_entrega.value = data_entrega;   
         if(document.forms[0].pedido.value != "") {
           
            var cod_agendamento = document.forms[0].pedido.value;
            var cod_exame = response[1];
            var valor_exame = response[2]; 
            var cod_convenio = f.convenio.value;
            var cod_paciente = f.cod_AC_paciente.value;
            f.codigos.value += cod_exame+"-1-0-"+valor_exame+"|";
            document.getElementById("spyframe").src = "agendamento_temp.php?acao=add_ex&cod_agendamento="+cod_agendamento+"&cod_exame="+cod_exame+"&valor_exame="+valor_exame+"&cod_convenio="+cod_convenio+"&cod_paciente="+cod_paciente;
            setTimeout("refresh_lista_m_agendamento("+cod_agendamento+","+cod_convenio+")",500);
            
         }

         }
         var a = "";
         buscardados('recepcao_temp.php?acao=search&search='+codifica(a),'cad_geral');
         //document.getElementById('resultado').innerHTML = "";
      }
   }
}
function refresh_lista_m_agendamento(cod_atend,convenio) {
	buscardados('agendamento_temp.php?acao=lista_marcadosx&cod_atend='+cod_atend+'&convenio='+codifica(convenio)+'&string=1','lista_marcadosx');
}
function refresh_lista_m(cod_atend,convenio) {
	buscardados('recepcao_temp.php?acao=lista_marcadosx&cod_atend='+cod_atend+'&convenio='+codifica(convenio)+'&string=1','lista_marcadosx');
}
function lista_selecionados() {
   if (req.readyState == 4) {
      if (req.status == 200) {
//         alert(req.responseText);
         document.getElementById('lista_selecionados').innerHTML = document.getElementById('lista_selecionados').innerHTML+req.responseText;
      }
   }
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

function lista_exame_conf() {
   if (req.readyState == 4) {
      if (req.status == 200) {
      	 var response = req.responseText.split("|");
      	 document.getElementById('exames_conf').innerHTML = "";
         document.getElementById('lista_exame').innerHTML = response[0];
         document.impressao.exames.value = response[1];
         buscardados("impressao_temp.php?acao=busca_conf&cod_atendimento="+response[2]+"&cod_paciente="+response[3],"exames_conf"); 
      }
   }
}

function exames_conf() {
   if (req.readyState == 4) {
      if (req.status == 200) {
      	 
      	var response = req.responseText.split("|");         	
       	var count = response.length;
       	if(count > 0) {  
            document.getElementById('exames_conf').innerHTML = response[0];
            var f = document.conferencia;
            f.exames.value = response[1];
	} else {
	    document.getElementById('exames_conf').innerHTML = req.responseText;
	}
      }
   }
}


function lista_examez() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         //alert(req.responseText);
         var response = req.responseText.split("|");        
         document.getElementById('lista_exame').innerHTML = response[0];
         document.impressao.exames.value = response[1];
 
      }
   }
}


function cad_exame_fn() {
   if (req.readyState == 4) {
      if (req.status == 200) {
//         alert(req.responseText);
         document.getElementById('val_normal_in1').innerHTML = req.responseText;
      }
   }
}

function cad_exame_vn() {
   if (req.readyState == 4) {
      if (req.status == 200) {
//         alert(req.responseText);
         document.getElementById('val_normal_in2').innerHTML = req.responseText;
         //var cod_faixa = document.valnormal.cod_faixa.value;
         //var cod_exame = document.cad_exame_geral.cod.value;
         //buscardados('cad_exame_temp.php?acao=val_normal_in2&cod_faixa='+cod_faixa+'&cod_exame='+cod_exame,'cad_exame_vn');
      }
   }
}

function lista_exame() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         var response = req.responseText.split("|");
         var count = response.length;
         if( count > 0 ) {
            // Conferencia
            document.getElementById('lista_exame').innerHTML = response[0];
            //alert(response[1]);
            buscardados("conferencia_temp.php?"+response[1],"lista_cmp_exa");
         } else {
            // Plano de Trabalho
            document.getElementById('lista_exame').innerHTML = req.responseText;
         }
      }
   }
}


function campos_exames() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         var response = req.responseText.split("|");
         var count = response.length;
	 document.conferencia.exames.value=response[0];
	 document.conferencia.campos.value=response[1]; 	
      }
   }
}

function listar_pacientes() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         document.getElementById('pacientes').innerHTML = req.responseText;
      }
   }
}

function gravar_orcamento() {
   if (req.readyState == 4) {
      if (req.status == 200) {
      		
		var cod_orcamento = req.responseText;
		
		if(cod_orcamento) {
			var cod_paciente = document.forms[0].cod_paciente.value; 
			alert("Orçamento gravado com sucesso.");
        		document.getElementById("lista_exames_orc").innerHTML = '';	
        		document.getElementById("lista_de_exames").innerHTML = '';        
			document.getElementById("dvalor").value='0';
			document.getElementById("subtotal").value='0.00';		
			document.getElementById("dpercentual").value='0';		
			document.getElementById("total").value='0.00';	
			buscardados('orcamento_temp.php?acao=orcamentos&cod_paciente='+cod_paciente,'orcamentos');		
		}
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

function lista_exames_orc() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         var response = req.responseText.split("[o]");      
         document.getElementById('lista_exames_orc').innerHTML = response[0];
         document.getElementById('subtotal').value = response[1];         
         desconto(1,0);
      }
   }
}



function orcamentos() {
   if (req.readyState == 4) {
      if (req.status == 200) {
      	var response = req.responseText.split("[o]");
      	var count = response.length;
     
      	if(count > 1) {
      		document.getElementById('orcamentos').innerHTML = response[0];
      		document.getElementById("cod_orcamento").value = response[1];
      	} else {
      		document.getElementById('orcamentos').innerHTML = req.responseText;
      	}
         
      }
   }
}


function lista_cmp_exa() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         var response = req.responseText.split("|");
         var count = response.length;
         //alert(req.responseText);
         document.xxx.confimg_click.value = "";
         if( count > 1 ) {
            document.xxx.desc_exame.value = response[2];
            document.xxx.codigo_exame.value = response[1];
            document.getElementById('lista_cmp_exa').innerHTML = response[3];
            //alert(response[4]);
            if( response[4] == 3 ) {
               document.getElementById("confcmp").src = "../imagens/confcmp_over.gif";
               document.xxx.confimg_click.value = "true";
               document.getElementById("conferenciaxx").src = "../imagens/conferido_sim.gif";
            }
         }
      }
   }
}

function ferramentas2(acao) {
   if( acao ) {
//      document.getElementById("ferramentas2").src = "img/ferramentas2_"+acao+".gif";
   }
}

function ferramentas() {
//      document.getElementById("ferramentas").src = "img/ferramentas2.gif";
}

function lista_consulta() {
   if (req.readyState == 4) {
      if (req.status == 200) {
//         alert(req.responseText);
         document.getElementById('lista_consulta').innerHTML = req.responseText;
      }
   }
}

   

function buscardados(obj,local_fonte)
{
//alert(obj);
    loadXMLDoc(obj,local_fonte);
}

// Recarrega a cada 60000 milissegundo (60 segundos)
function cmp_masc_refr(acao,local_fonte) {
   setInterval("buscardados('"+acao+","+local_fonte+"')", 1000);
   
}
/*function novo() {
   document.forms[1].cod.value="";
   document.forms[1].reset();
//   alert(document.forms[1].cod.value);
} */

function disena(val) {
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
				if(!element.getAttribute("desalititado")){
					if(val == "true") {
						element.disabled=true;
					} else {
						element.disabled=false;
					}
				}
			}

		}   
	}
}

function zerar() {
   for(y=0;y<document.forms.length;y++) {
      var form = document.forms[y];
      form.reset();
      for (var x=0; x<form.length; x++) {
         element = form.elements[x];
         if(element.name!="pesquisa_exame"){
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
   function refresh_recepcao(value,string,cod_atend) {

        buscardados('recepcao_temp.php?acao=lista_marcadosx&cod_atend='+cod_atend+'&convenio='+codifica(value)+'&string='+string,'lista_marcadosx');

   }
   function refresh_impressao() {

       buscardados('impressao_temp.php?acao=busca','busca_exms_ok');	

   }

function grid_pagamento() {
   if (req.readyState == 4) {
      if (req.status == 200) {
      var response = req.responseText.split("[o]");
      pago=response[2]-1+1;
      apagar=response[4]-1+1;
      entrada=response[3]-1+1;
      if(pago==1)
           opener.document.getElementById("pago").value = "Sim";
      else
           opener.document.getElementById("pago").value = "Nao";             
           
      opener.document.getElementById("a_pagar").value=apagar.toFixed(2);
      opener.document.getElementById("entrada").value=entrada.toFixed(2);
            
         if(response[1]){
            buscardados('pagamento_temp.php?acao=pegar&cod_atendimento='+response[1],'grid_pagamento')            
         }else
            document.getElementById('grid_pagamento').innerHTML = response[0];
      }
   }
}

function opcoes() {
   if (req.readyState == 4) {
      if (req.status == 200) {
            document.getElementById('opcoes').innerHTML = req.responseText;
      }
   }
}

function opcoes_grupo() {
   if (req.readyState == 4) {
      if (req.status == 200) {
            document.getElementById('opcoes_grupo').innerHTML = req.responseText;
      }
   }
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

function operadora() 
{
   if (req.readyState == 4) {
      if (req.status == 200) {
            document.getElementById('operadora_ans').value = req.responseText;
      }
   }
}

function cadastrar_guia() 
{
   if (req.readyState == 4) {
      if (req.status == 200) {
            alert(req.responseText);
      }
   }
}
function plano_convenio() 
{
   if (req.readyState == 4) {
      if (req.status == 200) {
            var split = req.responseText.split("[o]");
            document.getElementById("planos").innerHTML = split[0];
            document.getElementById("exige_tiss").value = split[1];
      }
   }
}


function maior_data_entrega(nova)
{
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
	}
}
function digitar_resultados() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         var split = req.responseText.split("[o]");
         document.getElementById('resultado1').innerHTML = split[0];
         document.getElementById('cod_atendimento').value = split[1]; 
         document.getElementById('cod_paciente').value = split[2]; 
      }
   }
}

function lista_de_conferencia() {
   if (req.readyState == 4) {
      if (req.status == 200) {
         //alert(req.responseText);                  
         document.getElementById('cod_atendimento').value = "";
         document.getElementById('cod_atendimento').focus();
         document.getElementById('pesquisando').value = 0;         
         document.getElementById('atendimento_sel').innerHTML = "";
         document.getElementById('resultado2').innerHTML = "";
         document.getElementById('resultado1').innerHTML = req.responseText;                  
         navegar_atendimento(10);
      }
   }
}

/************************************
* NOVAS
************************************/

function ocultarMensagem(){
    var obj = MM_findObj('msg_quadro');
    if (obj != null){
        obj.style.display = 'none';
    }
}
function mostrarMensagem(tipo, mensagem){
    var obj =null ;
    
    obj = MM_findObj('msg_quadro');
    if (obj != null){
        obj.style.display = 'block';
        
        obj = MM_findObj('msg_icone');
        if (obj != null){
			obj.src = '../../imagems/i_'+tipo+'.png';
        }
        var obj = MM_findObj('msg_texto');
        if (obj != null){
            obj.innerHTML = mensagem;
        }
    }
	if (MM_findObj('msg_ancora'))
		this.location = "#msg_ancora";
}

function habilitaCampo(objNome, Flag) {
	var obj = document.getElementById(objNome);                
	if (obj){ 
		if(Flag) {
			obj.disabled=false;
			//obj.style.backgroundColor="#FFFFFF";
		} else {
			obj.disabled=true;
			//obj.style.backgroundColor="#DDDDDD";
		}
	}
}


function number_format( number, decimals, dec_point, thousands_sep ) {
    // %        nota 1: Para 1000.55 retorna com precisão 1 no FF/Opera é 1,000.5, mas no IE é 1,000.6
    // *     exemplo 1: number_format(1234.56);
    // *     retorno 1: '1,235'
    // *     exemplo 2: number_format(1234.56, 2, ',', ' ');
    // *     retorno 2: '1 234,56'
    // *     exemplo 3: number_format(1234.5678, 2, '.', '');
    // *     retorno 3: '1234.57'
    // *     exemplo 4: number_format(67, 2, ',', '.');
    // *     retorno 4: '67,00'
    // *     exemplo 5: number_format(1000);
    // *     retorno 5: '1,000'
    // *     exemplo 6: number_format(67.311, 2);
    // *     retorno 6: '67.31'
 
    var n = number, prec = decimals;
    n = !isFinite(+n) ? 0 : +n;
    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
    var sep = (typeof thousands_sep == "undefined") ? ',' : thousands_sep;
    var dec = (typeof dec_point == "undefined") ? '.' : dec_point;
 
    var s = (prec > 0) ? n.toFixed(prec) : Math.round(n).toFixed(prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;
 
    var abs = Math.abs(n).toFixed(prec);
    var _, i;
 
    if (abs >= 1000) {
        _ = abs.split(/\D/);
        i = _[0].length % 3 || 3;
 
        _[0] = s.slice(0,i + (n < 0)) +
              _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
 
        s = _.join(dec);
    } else {
        s = s.replace('.', dec);
    }
 
    return s;
}