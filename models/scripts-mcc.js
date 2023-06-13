/**
* @description Classe de negócio agenda. 
* @author Kellen Nery
* @date 26/05/2013
* @version 1.0
* @package MDS
* @copyright 
*/ 

function isExplorer(){
	return (navigator.appName == "Microsoft Internet Explorer");
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

function desabilitarObjeto(idObjeto) {
	
	var obj = document.getElementById(idObjeto);
	if (obj!=null){
		if ( (obj.type == "input") || (obj.type == "password") || (obj.type == "radio") || (obj.type == "checkbox") || (obj.type == "select-one") || (obj.type == "select-multiple") )
			obj.disabled = true;
	}
	
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

function clearCombo(cboNome){
    try {
		var objCombo = MM_findObj(cboNome);
		if (objCombo){
			objCombo.options.length = 0;
		}
	} catch(err) {
		console.log('clearCombo('+cboNome+') return error['+err.message+'];');
	}
}

function addItemCombo(cboNome, valor, descricao){
    try {
        var newElem;
        var where = (navigator.appName == "Microsoft Internet Explorer") ? -1 : null;

        var objCombo = MM_findObj(cboNome); 
        if (objCombo){
            newElem = document.createElement("option");
            newElem.value = valor;
            newElem.text = descricao;
            objCombo.add(newElem, where);
        }
	} catch(err) {
		console.log('clearCombo('+cboNome+') return error['+err.message+'];');
	}
}

function addCheck(divNome, classe, nome, id, valor, descricao){
    try {
        var newElem;
        var where = (navigator.appName == "Microsoft Internet Explorer") ? -1 : null;

        var objCheck = MM_findObj(divNome);

        if (objCheck){
			newElem = document.createElement("input");
			newElem.setAttribute("type", "checkbox");
			newElem.setAttribute("class", classe);
			newElem.setAttribute("name", nome);
			newElem.setAttribute("id", id);
			newElem.setAttribute("value", valor);
			newElem.setAttribute("onclick", "checar()");
			objCheck.appendChild(newElem);			
			objCheck.appendChild(document.createTextNode(descricao)); 
			objCheck.appendChild(document.createElement("br"));
       }
	} catch(err) {
		console.log('clearCombo('+divNome+') return error['+err.message+'];');
	}
}

function setItemCombo(cboNome, valor){
    try {
        //var objCombo = document.getElementById(cboNome);
        var objCombo = MM_findObj(cboNome);
        if (objCombo){
            if (objCombo.options){
                for (i=0; i<objCombo.options.length; i++){
                    if (objCombo.options[i].value == valor){
                        objCombo.options[i].selected = true;
                        break;
                    }
                }
            }
        } else {
            alert ('Não foi possível encontrar o objeto: '+cboNome);
        }
	} catch(err) {
		console.log('clearCombo('+cboNome+') return error['+err.message+'];');
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
							//element.disabled=true;
							//element.style.backgroundColor="#DDDDDD";
						} else {
							//element.disabled=false;
							//element.style.backgroundColor="#FFFFFF";
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
			//obj.style.backgroundColor="#FFFFFF";
		} else {
			obj.disabled=true;
			//obj.style.backgroundColor="#DDDDDD";
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

function exibir_objeto(id, display)
{
    var objTemp = document.getElementById(id);
    if (objTemp)
        objTemp.style.display = display;
} 

function contarPalavras(txt){     
	txt = txt.replace(/\n/g, ' ');
	Texto = txt.replace('  ', ' ');
	// Texto = Trim(Texto);
	var palavra = Texto.split(' ');
	return palavra.length;
}

var myApp;
myApp = myApp || (function () {
    var pleaseWaitDiv = $('<div id="pleaseWaitDiv" class="modal"><div class="modal-dialog" data-keyboard="false"><div class="modal-content"><div class="modal-header dialog-header-wait"><h4 class="modal-title">Aguarde . . .</h4></div><div class="modal-body"><div class="progress progress-striped active"><div class="progress-bar"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">100%</span></div></div></div></div></div></div>');
    return {
        showPleaseWait: function() {
            pleaseWaitDiv.modal({
                "backdrop"  : "static",
                "keyboard"  : false,
                "show"      : true
              });
        },
        hidePleaseWait: function () {
            pleaseWaitDiv.modal('hide');
        },
        goTop: function () {
            /* window.scrollTo(0, 85); */
        	window.scrollTo(0, 0); 
        },
        goMenu: function () {
        	var url = "controller.php?mod=admin"; 
        	$(location).attr('href',url);
        },
        showAlert: function(tipo, mensagem) {
    		if ((tipo == 'erro') || (tipo == 'err')){
    			$('#alertDiv').html('<div class="alert alert-dismissable alert-danger"><span>'+mensagem+'</span><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    		} else if ((tipo == 'sucesso') || (tipo == 'success')){
    			$('#alertDiv').html('<div class="alert alert-dismissable alert-success"><span>'+mensagem+'</span><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    		} else if ((tipo == 'alerta') || (tipo == 'alert')){
    			$('#alertDiv').html('<div class="alert alert-dismissable alert-warning"><span>'+mensagem+'</span><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    		} else {
    			$('#alertDiv').html('<div class="alert alert-dismissable alert-info"><span>'+mensagem+'</span><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    		}
    		window.scrollTo(0, 85);
        },
        hideAlert: function() {
        	$('#alertDiv').html('');
        },
        showMensagem: function(obj, tipo, mensagem) {
    		if ((tipo == 'erro') || (tipo == 'err')){
    			$(obj).html('<div class="alert alert-dismissable alert-danger"><span>'+mensagem+'</span><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    		} else if ((tipo == 'sucesso') || (tipo == 'success')){
    			$(obj).html('<div class="alert alert-dismissable alert-success"><span>'+mensagem+'</span><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    		} else if ((tipo == 'alerta') || (tipo == 'alert')){
    			$(obj).html('<div class="alert alert-dismissable alert-warning"><span>'+mensagem+'</span><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    		} else {
    			$(obj).html('<div class="alert alert-dismissable alert-info"><span>'+mensagem+'</span><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    		}
    		//window.scrollTo(0, 85);
        },
        hideMensagem: function(obj) {
        	$(obj).html('');
        },        
    };
})();

/***************************************************************************************************************************************************
* Funções de VALIDAÇÃO 
***************************************************************************************************************************************************/
function validarCPF(value)
{
    value = value.replace('.','');
    value = value.replace('.','');
    var cpf = value.replace('-','');
    while(cpf.length < 11) cpf = "0"+ cpf;
    var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
    var a = [];
    var b = new Number;
    var c = 11;
    for (i=0; i<11; i++){
        a[i] = cpf.charAt(i);
        if (i < 9) b += (a[i] * --c);
    }
    if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
    b = 0;
    c = 11;
    for (y=0; y<10; y++) b += (a[y] * c--);
    if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }
    if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) return false;
    return true;
}

function validarCNPJ(value)
{
    var cnpj = value.replace(/[^\d]+/g,'');
    if(cnpj == '') return false;
    if(cnpj.length != 14) return false;
 
    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" || cnpj == "11111111111111" || cnpj == "22222222222222" || cnpj == "33333333333333" || cnpj == "44444444444444" || 
        cnpj == "55555555555555" || cnpj == "66666666666666" || cnpj == "77777777777777" || cnpj == "88888888888888" || cnpj == "99999999999999")
        return false;
         
    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;
         
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
          return false;
           
    return true;
    
}


function validarData(value)
{
	//contando chars
    if(value.length!=10) return false;
    // verificando data
    var data        = value;
    var dia         = data.substr(0,2);
    var barra1      = data.substr(2,1);
    var mes         = data.substr(3,2);
    var barra2      = data.substr(5,1);
    var ano         = data.substr(6,4);
    if(data.length!=10||barra1!="/"||barra2!="/"||isNaN(dia)||isNaN(mes)||isNaN(ano)||dia>31||mes>12)return false;
    if((mes==4||mes==6||mes==9||mes==11)&&dia==31)return false;
    if(mes==2 && (dia>29||(dia==29&&ano%4!=0)))return false;
    if(ano < 1900)return false;
    return true;
}

function validarDataHora(value)
{
	//contando chars
    if(value.length!=16) return false;
     // dividindo data e hora
    if(value.substr(10,1)!=' ') return false; // verificando se há espaço
    var arrOpcoes = value.split(' ');
    if(arrOpcoes.length!=2) return false; // verificando a divisão de data e hora
    // verificando data
    var data        = arrOpcoes[0];
    var dia         = data.substr(0,2);
    var barra1      = data.substr(2,1);
    var mes         = data.substr(3,2);
    var barra2      = data.substr(5,1);
    var ano         = data.substr(6,4);
    if(data.length!=10||barra1!="/"||barra2!="/"||isNaN(dia)||isNaN(mes)||isNaN(ano)||dia>31||mes>12)return false;
    if ((mes==4||mes==6||mes==9||mes==11)&&dia==31)return false;
    if (mes==2 && (dia>29||(dia==29&&ano%4!=0)))return false;
    // verificando hora
    var horario     = arrOpcoes[1];
    var hora        = horario.substr(0,2);
    var doispontos  = horario.substr(2,1);
    var minuto      = horario.substr(3,2);
    if(horario.length!=5||isNaN(hora)||isNaN(minuto)||hora>23||minuto>59||doispontos!=":")return false;
    return true;
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

function getValorNumerico(texto){
    try {
        var valor = 0;
        if (texto){ 
            texto = texto.replace(".","");
            texto = texto.replace(".","");
            texto = texto.replace(".","");
            texto = texto.replace(".","");
            texto = texto.replace(",",".");
            if(parseFloat(texto)>0) {
                valor = parseFloat(texto);
            } else{
                valor = 0;
            }
        } 
        return valor;
    } catch(err) {
        console.log("getValorNumerico(" + texto + "); error:" + err.message);
        return 0;
    }
}


function calcularIdade(tmpInicial, tmpFinal){
    try {
        if ((tmpInicial.length == 10) && (tmpFinal.length == 10)){
            var sDataI = tmpInicial.split("/");

            var nasc_dia = sDataI[0];
            var nasc_mes = sDataI[1]-1;
            var nasc_ano = sDataI[2];

            var sDataF = tmpFinal.split("/");
            var dia = sDataF[0];
            var mes = sDataF[1]-1;
            var ano = sDataF[2];
            var idade = ano - nasc_ano;

            if(dia >= nasc_dia && mes >= nasc_mes){
                return idade;
            }else{
                idade = idade - 1;
                return idade;
            }
        } else {
            return 0;
        }
    } catch(err) {
        console.log("calcularIdade(" + tmpInicial + ", " + tmpFinal + "); error:" + err.message);
        return 0;
    }
}

/***************************************************************************************************************************************************
* Funções de Comuns 
***************************************************************************************************************************************************/
function visualizaMenu(p_modulo, p_visao, p_tecla) { 
    if(p_tecla==13){
		$('#menu_cadastro').html('Carregando...');
        $.get("actions/submenu.action.php", { modulo: p_modulo, visao: p_visao},
            function(data){
                $('#menu_cadastro').html(data);
            }
        );
    }
}
