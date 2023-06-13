foco="";
guia="";

//Função que cria a Classe! Com suas propriedades.
function Campo(pForm, ctx, nome, mask, min, tab)
{
	// alert("Form (" + pform + ") or field (" + ctx + ")");
	if (pForm == null)
	{
		alert("O Form (" + pform + ") ou o campo (" + ctx + ") não existe(m)! ");
		//alert("Form (" + pform + ") or field (" + ctx + ") does not exist! ");
		return;
	}
	this.controle = ctx;
	this.nome = nome;
	this.mascara = mask;
	this.minimo = min;
	this.guia = tab;
	this.required = (this.minimo>0);
	
	if (pForm['RequiredFields'] == null) {
		pForm.RequiredFields = new Array();}
	pForm.RequiredFields[pForm.RequiredFields.length] = this;
}

// alert('passei ValidaFormJS');
// Função de validação! Pega cada objeto e valida de acordo com suas propriedades.
function ValidaFormJS(pForm)
{
	var alertMsg = "";

	if (pForm['RequiredFields'] == null){
		alert("Erro: pForm['RequiredFields'] == null");
		return false;
	}
	// alert("Alerta: pForm.RequiredFields.length=" + pForm.RequiredFields.length);

	for (i = 0; i < pForm.RequiredFields.length; ++i)
	{
		var oCampo = pForm.RequiredFields[i];
		element = pForm.elements[oCampo.controle];
		if (element == null) {
			//alert("Campo nulo: " + i );
			continue;
		}
		// Se o campo for RADIO ou CHECKBOX e required = TRUE, Valida se pelo menos um foi marcado!!!
		if (element.type == null) 
		{
			var checked = false;
			for (j = 0; j < element.length; ++j)
			{
				if (element[j].checked) { checked = true; }
			}
			if (oCampo.required && !checked){
				// alertMsg += (" - O campo " + oCampo.nome + " é obrigatório.\n");
				alertMsg += (" - Field " + oCampo.nome + " is obligator.\n");
			}
		}
		else
		{
			// alert(oCampo.nome + "[" +  element.value +  "]");
			if (element.value == "") // Se o campo for required = TRUE, Valida se foi preenchido!!!
			{
				if (oCampo.required){
					 alertMsg += (" - O campo " + oCampo.nome + " é obrigatório.\n");
					// alertMsg += (" - Field " + oCampo.nome + " is obligator.\n");
				}
			}
			else // Verifica a válidade dos dados prenchidos no campo
			{
				if (oCampo.minimo > 0 && element.value.length < oCampo.minimo){
					alertMsg+=(" - O campo " + oCampo.nome + " deve conter pelo menos " + oCampo.minimo +" caracteres.\n");
					//alertMsg+=(" - Field " + oCampo.nome + " must contain at least " + oCampo.minimo +" characters.\n");
				}
				else {
					if (oCampo.mascara != null)
					{
						var erroBoolean = false;
						switch (oCampo.mascara) 
						{
							case "CPF" :
								if (!ValidaCPF(element.value)) {
									alertMsg+=(" - O campo " + oCampo.nome + " comtém um valor inválido.\n");
									//alertMsg+=(" - Field " + oCampo.nome + " contains an invalid value.\n");
								}
								break;

							case "CNPJ" :
								if (!ValidaCNPJ(element.value)) {
									alertMsg+=(" - O campo " + oCampo.nome + " comtém um valor inválido.\n");
									///alertMsg+=(" - Field " + oCampo.nome + " contains an invalid value.\n");
								}
								break;

							default :
								if (element.value.search(oCampo.mascara) == -1)
									alertMsg+=(" - O campo " + oCampo.nome + " comtém um valor inválido.\n");
									//alertMsg+=(" - Field " + oCampo.nome + " contains an invalid value.\n");
						}//switch
					}//if								
				}//else
			}//else
		}//else
		if (alertMsg.length > 0){
			if (foco.length == 0)
				foco = oCampo.controle;
			if (guia.length == 0)
				guia = oCampo.guia;
		}
		
	}//for
	if (alertMsg.length > 0)
	{	
		alert ("Por favor, verifique o preenchimento dos campos abaixo:\n\n" + alertMsg);
		//alert ("Please, verfique the fulfilling of the fields below:\n\n" + alertMsg);
		return false;
	}
	else
		return true;
}


/*********************************************************************************************************************/
/************************************** Tipos de validações já definidas na QX3 **************************************/
	
	// Numeros c/ 1dig. ou +
	function ONLYNUMBER() { return /^\d+$/; }
	
	// Letras Maiusculas e Minusculas c/ 1dig. ou +
	function CHARACTER(){ return /^[a-zA-Z]+$/; }
	
	// az09 .+_ az09 @ az09 . az09
	function EMAIL() { 
		return /^([a-zA-Z0-9_\-])+(\.([a-zA-Z0-9_\-])+)*@((\[(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5])))\.(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5])))\.(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5])))\.(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5]))\]))|((([a-zA-Z0-9])+(([\-])+([a-zA-Z0-9])+)*\.)+([a-zA-Z])+(([\-])+([a-zA-Z0-9])+)*))$/;
		//return /^[0-9a-z]+([.+_]{1}[0-9a-z]+)*[@]{1}[0-9a-z]+([.]{1}[a-z0-9]+)+$/; 
	}
	
	// Valor financeiro com 2 casas decimais 'Padrão Brasileiro'
	function VALOR() { return /^\d{1,3}(\.\d{3})*\,\d{2}$/; }
	
	// Numeros c/ mínimo 3 dig. e no máximo 4 dig., -(hifen, sendo opcional), numeros c/ 4 dig.
	function TELEFONE() { return /^\d{3,4}[-]?\d{4}$/; } 
	
	// Herdadas do antigo ValidaModulo.
	function CPF()  { return 'CPF';  } 
	function CNPJ() { return 'CNPJ'; } 
	
	// Valida hora de 00 à 24 e minuto de 00 à 59
	function HORA() { return /^[01][0-9]|2[0-4][:][0-5][0-9]$/; }
	
	// Valida Dias de 01 à 31, sendo nos mêses 1, 3, 5, 7, 8, 10 e 12; de 01 à 30 no resto e mês 2 de 01 à 29. Valida mês e ano conforme abaixo.
	function DIAMES() { return /^((0[1-9]|[12]\d)\/(0[1-9]|1[0-2])|30\/(0[13-9]|1[0-2])|31\/(0[13578]|1[02]))$/; } 
	
	// Valida mes de 01 a 12 e valida ano conforme abaixo.
	function MESANO() { return /^(0[1-9]|1[0-2])\/(19|20)\d{2}$/; }
	
	// Valida numeros de 1900 à 2099.
	function ANO() { return /^(19|20)\d{2}$/; }
	
	// Valida Data completa.
	function DATACOMPLETA() { return /^((0[1-9]|[12]\d)\/(0[1-9]|1[0-2])|30\/(0[13-9]|1[0-2])|31\/(0[13578]|1[02]))\/(19|20)\d{2}$/; }
	
	/* OBS: Esta validação aceita expressões regulares customizadas que não estejam pré definidas acima. */

function ValidaCPF(strCpf)
{
	strCpf = strCpf.replace(new RegExp("[.-]","g"),"");

	var varFirstChr = strCpf.charAt(0);	
	var vaCharCPF = false;
	for(var i=0;i<=10;i++){
		var c = strCpf.charAt(i);             
		if(!(c>='0')&&(c<='9')){
			return false;
	    }              
	    if(c!=varFirstChr)
			vaCharCPF = true;
	}
	if(!vaCharCPF){
		return false;
	}
	soma=0;	
	for(i=0;i<9; i++){ 
		soma += (10-i) * ( eval(strCpf.charAt(i)) );
	}
	digito_verificador = 11-(soma % 11);
	if((soma % 11) < 2)
		digito_verificador = 0;	
		if (eval(strCpf.charAt(9)) != digito_verificador){
			return false;
		}
		soma=0;	
		for(i=0;i<9; i++){
			soma += (11-i)*(eval(strCpf.charAt(i)));
		}
		soma += 2*(eval(strCpf.charAt(9)));
		digito_verificador = 11-(soma % 11);
		if((soma % 11)<2) 
			digito_verificador = 0;
		if(eval(strCpf.charAt(10)) != digito_verificador){ 
			return false;
		}
	return true;
}

function ValidaCNPJ(campo) {
 with (Math) {
	 w = 0;
	 Resp1 = "";
	 Resp2 = "";
	 
 	 campo = campo.replace('/','');
 	 campo = campo.replace('-','');
 	 campo = campo.replace('.','');
 	 campo = campo.replace('.','');
	 CGC = campo;
 
	 if (CGC.length != 14) {
	 	return false;
	 }
 
	 if (!ValidaNumero(CGC)) { 
	 	return false;
	 }
 
	 VtCGC = new CriaArray(CGC.length);

	 for (var i=0;i < CGC.length;i++) {
 		if ((CGC.charAt(i) == "0") || (CGC.charAt(i) == "1") || (CGC.charAt(i) == "2") || (CGC.charAt(i) == "3") || (CGC.charAt(i) == "4") || (CGC.charAt(i) == "5") || (CGC.charAt(i) == "6") || (CGC.charAt(i) == "7") || (CGC.charAt(i) == "8") || (CGC.charAt(i) == "9")) {
	 		VtCGC[w]=parseFloat(CGC.charAt(i));	
	 		w++;
		}
 	}


 	Soma1 = (VtCGC[0]*5)+(VtCGC[1]*4)+(VtCGC[2]*3)+(VtCGC[3]*2)+(VtCGC[4]*9)+(VtCGC[5]*8)+(VtCGC[6]*7)+(VtCGC[7]*6)+(VtCGC[8]*5)+(VtCGC[9]*4)+(VtCGC[10]*3)+(VtCGC[11]*2)+0.0001;
 	Divisao1 = Soma1 / 11; 
 	RestoParc1 = (Divisao1 - floor(Divisao1))*11;
 	Resto1 = floor(RestoParc1);
 
 	Soma2 = (VtCGC[0]*6)+(VtCGC[1]*5)+(VtCGC[2]*4)+(VtCGC[3]*3)+(VtCGC[4]*2)+(VtCGC[5]*9)+(VtCGC[6]*8)+(VtCGC[7]*7)+(VtCGC[8]*6)+(VtCGC[9]*5)+(VtCGC[10]*4)+(VtCGC[11]*3)+(VtCGC[12]*2)+0.0001;
 	Divisao2 = Soma2 / 11; 
 	RestoParc2 = (Divisao2 - floor(Divisao2))*11;
 	Resto2 = floor(RestoParc2);


 	if (((Resto1 == 0) || (Resto1 == 1)) && (VtCGC[12] == 0)) {
  		Resp1 = "V";
 	} else {
  		Digito1 = 11 - Resto1;
  		if ((Digito1 == VtCGC[12]) && (Resto1 > 1)) {
			Resp1 = "V";
  		}
 	}
 
 	if (((Resto2 == 0) || (Resto2 == 1)) && (VtCGC[13] == 0)) {
  		Resp2 = "V";
 	} else {
  		Digito2 = 11 - Resto2;
  		if ((Digito2 == VtCGC[13]) && (Resto2 > 1)) {
   			Resp2 = "V";
  		}
 	}
 
 	if ((Resp1 == "V") && (Resp2 == "V")) 
 	{
   		return true;
 	} else {
  		return false;   
 	} 
 }
}

/*         F U N Ç Õ E S   D E   F O R M A T A Ç Ã O          */

function formatarData(campo,teclaPres)
{
	var tecla=teclaPres.keyCode;
	vr = "";

	//if (!IsNumber(tecla)){
	//	return false;
	//}

	for(i=0;i<campo.value.length;i++)
		if(campo.value.charAt(i)!="/")
			vr=vr + campo.value.charAt(i);
	tam = vr.length ;
	if (tecla == 8){ tam = tam - 1 ;}
	if (tecla == 8 || tecla == 88 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 )
	{
		if (tam < 2) { campo.value = vr ;}
		if ((tam >= 2) && (tam <= 4) ) { 
			campo.value = vr.substr(0,2) + '/' + vr.substr(2,tam-2);
		}
		if ((tam > 4)) { 
			campo.value = vr.substr(0,2) + '/' + vr.substr(2,2) + '/' + vr.substr(4,tam-4);
		}
	}
}

function AutoSkip(obj) {
	with(document.forms[0]) {
		if (obj.value.length == obj.maxLength) 		{
			if (arguments.length>1) {
				arguments[1].focus();
			} else {
				idObjeto = 0;
				for (x=0; x<elements.length; x++) {
					try {
						if (elements[x].type == 'text') {
							if (elements[x].name == obj.name)
								idObjeto = x;
							if (idObjeto > 0 && x != idObjeto) 	{
								elements[x].focus();
								break;				
							}
						}
					}
					catch (e) {}
				}
			}
		}
	}
}

/*         F U N Ç Õ E S   D E   C O N T R O  L E   D E   T E C L A   D E   F U N C Ã O          */
function cancelRefresh() {
  	KeyPress=0;
  	if (window.event && window.event.keyCode == 116) {
  		KeyPress=window.event.keyCode;
  		window.event.keyCode = 17;
  }
	if (KeyPress>0){
  		if (window.event && window.event.keyCode == 17) {
			window.event.cancelBubble = true;
			window.event.returnValue = false;
			alert("Atenção! Por favor não tecle no botão F5.");
			return false;
		}
	}
}
document.onkeydown = cancelRefresh; // Chama Script de tratamento de erro.
