function controlaTeclado(evt) {
  	var lngCaracter = 0;
	var blnRetorno = true;
	var objEvento = null;
	var objAtual = null;
	var objProximo = null;
	var objPrimeiro = null;
	
	//alert("evt=" + evt);
	//alert("window.event=" + window.event);
	
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
/*			for (property in objEvento) {
				alert(property + ":" + objEvento[property]);
			}	// */
		// alert('[Object].type=' + objAtual.type + '\n[Caracter]=' + lngCaracter);
		
		// Recuperando o Elemento Atual.
		objAtual = getTarget(objEvento);
		
	    // Recuperando o keyCode da tecla.
		lngCaracter = getKeyCode(objEvento);

		
	    // Valor booleano que indica se as teclas Shift e/ou Control estão pressionadas.
	    blnTeclaControl = objEvento.ctrlKey;
	    blnTeclaAlt = objEvento.altKey;
	    blnTeclaShift   = objEvento.shiftKey;

	    // Desabilitar as outras teclas de funções (F1|F2|F3|F4|F5|F6|F7|F8|F9|F10|F11|F12).
	    var objExpressaoRegular = /^(112|113|114|115|116|117|118|119|120|121|122|123|124)$/;
	    if(objExpressaoRegular.test(lngCaracter)){
	        blnRetorno = false;
	    }
		
		// Usou de CTRL ?
	    if (blnTeclaControl) {
		    // SOMENTE Permitir o uso de CTRL com as teclas C, V, X e A.
		    strCaracter = String.fromCharCode(lngCaracter).toUpperCase();
			var objExpressaoRegular = /^[CVXA]$/;
			if (objExpressaoRegular.test(strCaracter))	
				blnRetorno = false; //blnRetorno = true;
			else
				blnRetorno = false;
	    }

		// Usou de ALT ?
		// Permissão para aceitar a tecla ALT
		// Alterado em 24/11/2008 - Wallace Reis
		/*
	    if (blnTeclaAlt) {
			alert('Por motivos de seguran\xE7a esta tecla foi bloqueada.')
			blnRetorno = false;
	    }*/
		
		// Usou de Shift ?
	    if (blnTeclaShift) {
			 /*	Bloquear estas teclas.
				8=Backspace;  9=TAB; 35=End; 36=Home; 37=Seta Esquerda; 38=Seta Cima; 39=Seta Direita; 40=Seta Baixo; 45=Insert; 46=Delete
			    */	
		    var objExpressaoRegular = /^(8|9|35|36|38|40|45|46)$/;
		    if(objExpressaoRegular.test(lngCaracter)){
		        blnRetorno = false;
		    }
		}

		// Backspace ?
		if (lngCaracter == 8) {
		    var objNaoPode = /^(undefined|radio|checkbox|select-one|select-multiple|button|submit|reset|image)$/;
		    var objPode = /^(text|textarea|password)$/;
			
			// Se tiver algum elemento ativo
		    if (objAtual) {
				// Se tiver algum elemento ativo
			    if (objAtual.type){
					// alert(objAtual.type);
					// O elemento aceita digitação
					if(objPode.test(objAtual.type)){	
					
				    } else if(objNaoPode.test(objAtual.type)){	
						blnRetorno = false;
					} else if (typeof (objAtual.type) == "undefined"){
						blnRetorno = false;
					} else if (objAtual.type == ""){
						blnRetorno = false;
					} else {
						alert('Entre em contato com o Apoio SEDES.\nProvidenciar o tratamento do object.type=' + objAtual.type);
					}
				} else 
				blnRetorno = false;
			} else 
			blnRetorno = false;
		}

		// Enter ?
		if (lngCaracter == 13) {
		    var objNaoPode = /^(text|password|radio|checkbox|select-one|select-multiple|image)$/;
		    var objPode = /^(textarea|button|submit|reset)$/;
			// Se tiver algum elemento ativo
		    if (objAtual) {
				//alert('type='+objAtual.type);
				// Se tiver algum elemento ativo
			    //if (objAtual.type){
					if(objPode.test(objAtual.type)){	
						//alert('type='+objAtual.type);
				    } else { //if(objNaoPode.test(objAtual.type)){	
						lngCaracter = 0;
					    // Mudar a tecla ENTER para TAB.
						if (evt){
							// FireFox, Mozila, ect.
						} else {
							// Internet Explorer.
							window.event.keyCode = lngCaracter;
						}
						blnRetorno = false;
						/*
						if (objAtual.tabIndex == 0)
							objProximo = getNextElementByName(objAtual);
						else
							objProximo = getNextElementByTabIndex(objAtual);

						if(objProximo){
							objProximo.focus();
						} else{
							objPrimeiro = getFirstElementByName();
							if(objPrimeiro){
								objPrimeiro.focus();
							}
						} 
						*/
						confirmar_resposta();
							
					}
				//}
		    } 
		}
		
		// Controle da Questão ?
		/* *************************************************************************** */
	    if(blnRetorno){
			 /*	Bloquear estas teclas.
				37=Seta Esquerda; 39=Seta Direita; 65=A; 66=B; 67=C; 68=D; 69=E
			    */	
		    var objExpressaoRegular = /^(37|38|39|65|66|67|68|69)$/;
		    if(objExpressaoRegular.test(lngCaracter)){
			
				var objNaoPode = /^(button|submit|reset|password|radio|checkbox|select-one|select-multiple|image)$/;
				var objPode = /^(text|password|textarea)$/;
				// Se tiver algum elemento ativo
				if (objAtual) {
					if(objPode.test(objAtual.type)){	
						//alert('type='+objAtual.type);
					} else { //if(objNaoPode.test(objAtual.type)){	
					
						if (lngCaracter == 37) { // 37=Seta Esquerda;
							questao_anterior();
						} else if (lngCaracter == 39) {  // 39=Seta Direita;
							questao_proxima();
						} else if (lngCaracter == 65) {  // 65=A;
							mostrar_resposta(1);
						} else if (lngCaracter == 66) {  // 66=B;
							mostrar_resposta(2);
						} else if (lngCaracter == 67) {  // 67=C;
							mostrar_resposta(3);
						} else if (lngCaracter == 68) {  // 68=D;
							mostrar_resposta(4);
						} else if (lngCaracter == 69) {  // 69=E;
							mostrar_resposta(5);
						}
						blnRetorno = false;
					}
				}
		    }
		}
		/* *************************************************************************** */
		
	    // Caso a tecla ou combinação de teclas seja permitida, sai da função.
	    if(blnRetorno){
	        return blnRetorno
	    }

	    try {
			cancelaPost(objEvento);
	        if(document.all){
	            objEvento.keyCode = 0;
	        }
			
	    } catch(err){
			//alert(err);
	    }
	    return blnRetorno;
		
	}

}
document.onkeydown = controlaTeclado;

function controlaMouse(evt) {

	if ((window.event) || (evt)){

		//  Pegando o Evento
		if (evt){
			// FireFox, Mozila, ect.
			evt = evt;
			if (evt.button==2) {
				cancelaPost(evt);
				alert('Por motivos de seguran\xE7a o menu direito do mouse foi bloqueada.');
				return false;
			}
		} else {
			// Internet Explorer.
			if (window.event.button==2){
				alert('Por motivos de seguran\xE7a o menu direito do mouse foi bloqueada.');
				return false;
			}
		}
	}
}
if (navigator.appName!="Netscape") document.onmousedown = controlaMouse; // Internet Explorer;
document.onclick = controlaMouse;  //FireFox;
document.ondblclick = controlaMouse;

// Função para cancelar o envio do form
function cancelaPost(evt)
{
    evt.cancelBubble = true;
    evt.returnValue = false;

    if (evt.preventDefault)
        evt.preventDefault();

    if (evt.stopPropagation)
        evt.stopPropagation();

    return false;
}

// Recupera o elemento que está com o foco
function getTarget(evt)
{
    var target = null;

    if (evt.srcElement)
        target = evt.srcElement;
    else if (evt.target)
        target = evt.target;

    return target;
}

// Recupera o código da tecla que foi pressionado
function getKeyCode(evt)
{
    var code;

    if(typeof(evt.keyCode) == 'number') 
		code = evt.keyCode;
    else if(typeof(evt.which) == 'number')
		code = evt.which;
    else if(typeof(evt.charCode) == 'number')
		code = evt.charCode;
    else 
        return 0;

    return code;
}
// Recupera o elemento deacordo com o TabIndex
function getElementByTabIndex(tabIndex)
{
    var form = document.forms[0];

    for( var i=0; i < form.elements.length; i++ )
    {
        var el = form.elements[i];

        if( el.tabIndex && el.tabIndex == tabIndex )
            return el;
    }

    return null;
}

// Recupera o próximo elemento de acordo com o nome
function getNextElementByTabIndex(elementAtivo)
{
    var targetTabIndex = elementAtivo.tabIndex;
    var nextTabIndex = targetTabIndex+1;
    var nextElement = getElementByTabIndex(nextTabIndex);

    // Margem de erro
    var i=0;

    for(i=0; i < 15; i++) // Tolerância de tabIndex
    {
        if (nextElement!=null && !nextElement.disabled)
            break;

        nextTabIndex = nextTabIndex+1;
        nextElement = getElementByTabIndex(nextTabIndex);
    }

    return nextElement;
}

// É um campo editável
function IsElementEdit(elnx)
{	
        switch (elnx.type)
        {
            case "text":
                 return true; 
            case "button":
                 return true; 
            case "submit":
                 return true; 
            case "reset":
                 return true; 
            case "select-one":
                 return true; 
            case "select-multiple":
                 return true; 
            case "checkbox":
                 return true; 
            case "image":
                 return true; 
            case "password":
                 return true; 
            case "radio":
                 return true; 
            case "textarea":
                if (elnx.disabled) {
                    return false; 
                } else {
                    return true; 
                }
            default:
                 return false; 
            break;
        }
      return false;  
}

// Recupera o primeiro elemento de acordo com o nome
function getFirstElementByName(elementAtivo)
{	
	var el = null;
	if (document.forms){
		if (document.forms[0]){
            var form = document.forms[0];
            for(var i=0; i < form.elements.length; i++)
            {
			    if (IsElementEdit(form.elements[i])){
				    return form.elements[i];
			    }
			} 
		}
	}
	return null;
}
// Recupera o próximo elemento de acordo com o nome
function getNextElementByName(elementAtivo)
{
    var passou=false;

	if (document.forms){
		if (document.forms[0]){

            var form = document.forms[0];

            for(var i=0; i < form.elements.length; i++)
            {
		        var el = form.elements[i];
		        // alert('Ativo=' + elementAtivo.id + '\nId=' + el.id + '\nName=' + el.name + '\nType=' + el.type);
        		
                if( (el) && ((el.id == elementAtivo.id) && (el.name == elementAtivo.name)) || passou)
                {
                    passou=true;
                    // Encontrou o elemento atual
                    var x=i+1;
                    var elnx = form.elements[x];
			        //alert('Id=' + elnx.id + '\nName=' + elnx.name + '\nType=' + elnx.type);
        			
                    if(elnx)
                    {
                        switch (elnx.type)
                        {
                            case "text":
                            case "button":
                            case "submit":
                            case "reset":
                            case "select-one":
                            case "select-multiple":
                            case "checkbox":
                            case "image":
                            case "password":
                            case "radio":
                            case "textarea":
                                if (elnx.disabled)
                                    continue;

                                break;
                            default:
                                continue;
                            break;
                        }

                        return elnx;
                    }
                }
            }
        } 
    }
    return null;
}