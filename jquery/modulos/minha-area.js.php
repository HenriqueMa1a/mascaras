<script type="text/javascript"
	src="admin/jquery/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
  
var oModulo = {Id: <?php echo isset($MOD_ID)? $MOD_ID: 0; ?>, Chave: '<?php echo isset($MOD_CLASSE)? $MOD_CLASSE: ''; ?>', Classe: '<?php echo isset($MOD_CLASSE)? $MOD_CLASSE: ''; ?>'};
var oUsuario = {Id: '<?php echo isset($USO_ID)? $USO_ID: 0; ?>', Nome: '<?php echo isset($USO_NOME)? $USO_NOME: ''; ?>', Email: '<?php echo isset($USO_EMAIL)? $USO_EMAIL: ''; ?>'} ;


valorTR = 2;
var validaFomulario = 0;

$(function () {
	    var chart;
	    $(document).ready(function() {
		    
	    /* JQUERY.TABS ******************************************************************************************************************************** */
			//$.datepicker.setDefaults($.datepicker.regional['pt-BR']);
		
			/* JQUERY.FORM ****************************************************************************************************************************** */
				
		/* JQUERY.AJAXFORM ****************************************************************************************************************************** */
			var optionsForm = {
				type: 'POST',
				url: 'actions/' + oModulo.Classe + '.action.php',
				target:        '#resultado',   // target element(s) to be updated with server response 
				beforeSubmit:  validaForm, // pre-submit callback 
				dataType: 'json',
				success:       showResponse  // post-submit callback 
			}; 
			
			$("#formCadastro").ajaxForm(optionsForm);
				
	    });
	    
    
		/* TinyMCE ****************************************************************************************************************************** */
		var optionsTinyMCE = {
			// Location of TinyMCE script
			script_url : 'admin/jquery/tiny_mce/tiny_mce.js',
			language : "pt",

			// General options
			theme : "advanced",
			plugins : "autoresize,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
	
			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,|,sub,sup,|,bullist,numlist,|,pastetext,pasteword,|,code",
			theme_advanced_toolbar_location : "bottom",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "none",
			theme_advanced_fonts : "Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n",
			theme_advanced_resizing : true,
			forced_root_block : false,
		   	force_br_newlines : true,
		   	force_p_newlines : false,

			// Replace values for the template plugin
			template_replace_values : {
					username : "Some User",
					staffid : "991234"
			}
		};
		$('textarea.tinymce').tinymce(optionsTinyMCE);	

		var optionsTinyMCE = {
				// Location of TinyMCE script
				script_url : 'admin/jquery/tiny_mce/tiny_mce.js',
				language : "pt",

				// General options
				theme : "advanced",
				plugins : "autoresize,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
		
				// Theme options
				theme_advanced_buttons1 : "bold,italic,underline,|,sub,sup,|,pastetext,pasteword,|,code",
				theme_advanced_toolbar_location : "bottom",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "none",
				theme_advanced_fonts : "Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n",
				theme_advanced_resizing : true,
				forced_root_block : false,
			   	force_br_newlines : true,
			   	force_p_newlines : false,

				// Replace values for the template plugin
				template_replace_values : {
						username : "Some User",
						staffid : "991234"
				}
			};
			$('textarea.tinymce2').tinymce(optionsTinyMCE);	

			inicializar();	
	});

	/* JS NORMAIS ************************************************************************************************************************************ */
	
	function showLoading(){
		$.blockUI({ theme: true, title: '<?php echo isset($EMP_NOME) ? $EMP_NOME : ''; ?>', message: '<p>Por favor aguarde . . . </p>'}); 
	}

	function hideLoading(){
		$.unblockUI();
	}

	function ir_para_titulo(){
		this.location = "#a_titulo";
	}

	//Função para adicionar campos de Autores. Inicio
	 
	$(function() {
		
		$('#addScnt').live('click', function() {
			if(valorTR <=10){
                document.getElementById("tr_"+valorTR).style.display = '';
                if(valorTR ==8 || valorTR ==9 || valorTR ==10){
                	 document.getElementById("tr_"+valorTR+"_").style.display = '';
                }
			}
            valorTR++;
            if(valorTR == 11){
				valorTR = 2;
            }        
            return false;
        });
	});
	
	// pre-submit callback 
	function showRequest(formData, jqForm, options) { 
	    var queryString = $.param(formData); 
	 
	    return true; 
	} 
 
	// post-submit callback 
	function showResponse(data)  { 
	
		hideLoading();
		if (data.sucesso==1) {
			mostrarMensagemTopo('sucesso', data.mensagem);
			//preparaForm('limpar');
			preparaForm('criar-resumo');
			preparaForm('desabilita');
			
			exibir_objeto('DivFormResumo', 'none');
			mostratListaResumo();
			
		} else {
			mostrarMensagemTopo('erro', data.mensagem);
		} 
	} 

	function getValueRadio(objeto) {
	    var radios = document.getElementsByName(objeto);
	
	    for (var i = 0; i < radios.length; i++) {       
	        if (radios[i].checked) {
	            return radios[i].value;
	            break;
	        }
	    }
		return '';
	}

	function limparValueRadio(objeto) {
	    var radios = document.getElementsByName(objeto);
	    for (var i = 0; i < radios.length; i++) {       
	        radios[i].checked = false;
	    }
	}
	
	function displayunicode(e){
		var unicode=e.keyCode? e.keyCode : e.charCode;
		alert(unicode);
	}

	/*
	 function ContarPalavrasTitulo(obj){     
	obj.value = obj.value.replace('  ', ' ');
	var Texto = Trim(obj.value);
	var palavra = Texto.split(' ');
	return palavra.length;
	}
	*/

	function contarPalavras(txt){
		txt = txt.replace(/\n/g, ' ');
		txt = txt.replace(/&nbsp;/g, ' ');
		txt = txt.replace('<br />', ' ');
		txt = txt.replace('<br/>', ' ');
		txt = txt.replace('<br>', ' ');
		txt = txt.replace(/\s{2,}/g, ' ');
		txt = txt.replace(/^\s+|\s+$/gm,''); //trim txt = txt.trim();
		var palavra = txt.split(' ');
		//console.log('[text: ' + txt + '] [palavras: ' + palavra + '] [palavra.length: ' + palavra.length + ']');
	    return palavra.length;
	}

	function validaForm(formData, jqForm, options) { 
		validaFomulario = 0;
	 
		var TipoResumo = ''; //getValueRadio("TipoResumo");
		//var OutroResumo = getValueRadio("OutroResumo");
		//var Gest_Resumo = getValueRadio("Gest_Resumo");
		//var Est_Qualitativo = getValueRadio("Est_Qualitativo");
		//var OutrosTemas = document.getElementById('OutrosTemas').value;
		//var TituloResumo  = document.getElementById('TituloResumo').value;
		//var Arquivo  = document.getElementById('Arquivo').value;
		var FlagPolitica  = (document.getElementById('FlagPolitica').checked);
		var FlagPolitica1  = (document.getElementById('FlagPolitica1').checked);
		var FlagPolitica2  = (document.getElementById('FlagPolitica2').checked);
		//var FlagPolitica3  = (document.getElementById('FlagPolitica3').checked);
		//var palavrasTitulo = contarPalavras(document.getElementById('TituloResumo').value);
		
		document.getElementById('PalavrasTitulo').innerHTML = $('#TituloResumo').text();
		//console.log('text: ' + document.getElementById('PalavrasTitulo').textContent);
		//console.log('palavrasTitulo: ' + contarPalavras($('#TituloResumo').text()));
		
		var palavrasTitulo = contarPalavras($('#TituloResumo').text());
		var palavrasintroducao = contarPalavras($('#Textointroducao').text());
		var palavrasObjetivo = contarPalavras($('#TextoObjetivo').text());
		var palavrasMetodologia = contarPalavras($('#TextoMetodologia').text());
		var palavrasResumo = contarPalavras($('#TextoResumo').text());
		var palavrasConclusao = contarPalavras($('#TextoConclusao').text());
		var palavrasPalavrasChaves = contarPalavras(document.getElementById('TextoPalavraChave').value);
		var palavrasAutor1 =  document.getElementById('autor1').value;
		var palavrasInstituica1 =  document.getElementById('instituicao1').value;
		
		//Soma o total de Palavras, (sem contar título, autores e instituição).
		var toalPalavrasResumo = (palavrasintroducao + palavrasObjetivo + palavrasMetodologia + palavrasResumo + palavrasConclusao);

		document.getElementById('PalavrasTitulo').innerHTML = palavrasTitulo;
		document.getElementById('Palavrasintroducao').innerHTML = palavrasintroducao;
		document.getElementById('PalavrasObjetivo').innerHTML = palavrasObjetivo;
		document.getElementById('PalavrasMetodologia').innerHTML = palavrasMetodologia;
		document.getElementById('PalavrasResumo').innerHTML = palavrasResumo;
		document.getElementById('PalavrasConclusao').innerHTML = palavrasConclusao;
		document.getElementById('PalavrasPalavrasChaves').innerHTML = palavrasPalavrasChaves;

		//if ((TipoResumo == '') || (TipoResumo == '0')) {
		if ((document.getElementById('TipoResumo1').checked == false) && (document.getElementById('TipoResumo2').checked == false) && (document.getElementById('TipoResumo3').checked == false) && (document.getElementById('TipoResumo4').checked == false)  && (document.getElementById('TipoResumo5').checked == false) ) {
			mostrarMensagemTopo('erro', 'O Campo <b>Classifique seu resumo</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";			
			return false; 
		} /*
		else if ((TipoResumo == '4') && OutroResumo == '' || OutroResumo == '0') {
			mostrarMensagemTopo('erro', 'Marque uma opção para: <b>OTR (Outros temas relacionados)</b>');
			document.getElementById('DivFormResumo').style.display="block";			
			return false; 
		}else if((TipoResumo == '4') &&(OutroResumo == '1') && (Gest_Resumo == '' || Gest_Resumo == '0')){
			mostrarMensagemTopo('erro', 'Marque uma opção para: <b>Gestão</b>');
			document.getElementById('DivFormResumo').style.display="block";			
			return false; 
		}else if((TipoResumo == '4') &&(OutroResumo == '2') && (Est_Qualitativo == '' || Est_Qualitativo == '0')){
			mostrarMensagemTopo('erro', 'Marque uma opção para: <b>Estudos Qualitativos</b>');
			document.getElementById('DivFormResumo').style.display="block";			
			return false; 
		}else if((TipoResumo == '4') && (OutroResumo == '3') && (OutrosTemas == '')){
			mostrarMensagemTopo('erro', 'Informe o Tema para <b>Outros</b>');
			document.getElementById('DivFormResumo').style.display="block";			
			return false; 
		} // */
		if ((palavrasTitulo == '') || (palavrasTitulo == '0')) {
			//alert(palavrasTitulo);
			mostrarMensagemTopo('erro', 'O Campo <b>Titulo</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false; 
	    } else if (palavrasTitulo < 2) {
			mostrarMensagemTopo('erro', 'O Campo <b>Titulo</b> deve ter no mínimo 2 palavras.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;
		} else if (palavrasTitulo > 20) {
			mostrarMensagemTopo('erro', 'O Campo <b>Titulo</b> deve ter no máximo 20 palavras. Total de Palavras: <strong>' + palavrasTitulo + '</strong>');
			document.getElementById('DivFormResumo').style.display="block";
			return false;
		}else if (palavrasAutor1 == '' || palavrasInstituica1 == '') {
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (1º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  

		} else if( (document.getElementById("apresentador1").checked== "") && (document.getElementById("apresentador2").checked== "") && (document.getElementById("apresentador3").checked== "") && (document.getElementById("apresentador4").checked== "") && (document.getElementById("apresentador5").checked== "") && (document.getElementById("apresentador6").checked== "") && (document.getElementById("apresentador7").checked== "") && (document.getElementById("apresentador8").checked== "") && (document.getElementById("apresentador9").checked== "") && (document.getElementById("apresentador10").checked== "") ) {
			mostrarMensagemTopo('erro', 'Favor informar o <b>Apresentador</b>.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		} else if(document.getElementById("apresentador1").checked != "" && document.getElementById("email1").value == ''){
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (1º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		}else if(document.getElementById("apresentador2").checked != ""  && document.getElementById("email2").value == ''){
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (2º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		}
		else if(document.getElementById("apresentador3").checked != ""  && document.getElementById("email3").value == ''){
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (3º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		}
		else if(document.getElementById("apresentador4").checked != ""  && document.getElementById("email4").value == ''){
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (4º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		}
		else if(document.getElementById("apresentador5").checked != ""  && document.getElementById("email5").value == ''){
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (5º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		}
		else if(document.getElementById("apresentador6").checked != ""  && document.getElementById("email6").value == ''){
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (6º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		}
		else if(document.getElementById("apresentador7").checked != ""  && document.getElementById("email7").value == ''){
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (7º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		}
		else if(document.getElementById("apresentador8").checked != ""  && document.getElementById("email8").value == ''){
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (8º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		}
		else if(document.getElementById("apresentador9").checked != ""  && document.getElementById("email9").value == ''){
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (9º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		}else if(document.getElementById("apresentador10").checked != ""  && document.getElementById("email10").value == ''){
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (10º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;
		}else if((document.getElementById("apresentador1").checked != "")  && (document.getElementById("email1").value.indexOf("@")==-1 || document.getElementById("email1").value.indexOf(".")==-1)){
			mostrarMensagemTopo('erro', 'Preencha campo <b>Autores / Instituições : E-mail (1º Linha)</b> corretamente! ');
			document.getElementById('DivFormResumo').style.display="block";
			return false;
		}else if((document.getElementById("apresentador2").checked != "")  && (document.getElementById("email2").value.indexOf("@")==-1 || document.getElementById("email2").value.indexOf(".")==-1)){
			mostrarMensagemTopo('erro', 'Preencha campo <b>Autores / Instituições : E-mail (2º Linha)</b> corretamente! ');
			document.getElementById('DivFormResumo').style.display="block";
			return false;
		}else if((document.getElementById("apresentador3").checked != "")  && (document.getElementById("email3").value.indexOf("@")==-1 || document.getElementById("email3").value.indexOf(".")==-1)){
			mostrarMensagemTopo('erro', 'Preencha campo <b>Autores / Instituições : E-mail (3º Linha)</b> corretamente! ');
			document.getElementById('DivFormResumo').style.display="block";
			return false;
		}else if((document.getElementById("apresentador4").checked != "")  && (document.getElementById("email4").value.indexOf("@")==-1 || document.getElementById("email4").value.indexOf(".")==-1)){
			mostrarMensagemTopo('erro', 'Preencha campo <b>Autores / Instituições : E-mail (4º Linha)</b> corretamente! ');
			document.getElementById('DivFormResumo').style.display="block";
			return false;
		}else if((document.getElementById("apresentador5").checked != "")  && (document.getElementById("email5").value.indexOf("@")==-1 || document.getElementById("email5").value.indexOf(".")==-1)){
			mostrarMensagemTopo('erro', 'Preencha campo <b>Autores / Instituições : E-mail (5º Linha)</b> corretamente! ');
			document.getElementById('DivFormResumo').style.display="block";
			return false;
		}else if((document.getElementById("apresentador6").checked != "")  && (document.getElementById("email6").value.indexOf("@")==-1 || document.getElementById("email6").value.indexOf(".")==-1)){
			mostrarMensagemTopo('erro', 'Preencha campo <b>Autores / Instituições : E-mail (6º Linha)</b> corretamente! ');
			document.getElementById('DivFormResumo').style.display="block";
			return false;
		}else if((document.getElementById("apresentador7").checked != "")  && (document.getElementById("email7").value.indexOf("@")==-1 || document.getElementById("email7").value.indexOf(".")==-1)){
			mostrarMensagemTopo('erro', 'Preencha campo <b>Autores / Instituições : E-mail (7º Linha)</b> corretamente! ');
			document.getElementById('DivFormResumo').style.display="block";
			return false;
		}else if((document.getElementById("apresentador8").checked != "")  && (document.getElementById("email8").value.indexOf("@")==-1 || document.getElementById("email8").value.indexOf(".")==-1)){
			mostrarMensagemTopo('erro', 'Preencha campo <b>Autores / Instituições : E-mail (8º Linha)</b> corretamente! ');
			document.getElementById('DivFormResumo').style.display="block";
			return false;
		}else if((document.getElementById("apresentador9").checked != "")  && (document.getElementById("email9").value.indexOf("@")==-1 || document.getElementById("email9").value.indexOf(".")==-1)){
			mostrarMensagemTopo('erro', 'Preencha campo <b>Autores / Instituições : E-mail (9º Linha)</b> corretamente! ');
			document.getElementById('DivFormResumo').style.display="block";
			return false;
		}else if((document.getElementById("apresentador10").checked != "")  && (document.getElementById("email10").value.indexOf("@")==-1 || document.getElementById("email10").value.indexOf(".")==-1)){
			mostrarMensagemTopo('erro', 'Preencha campo <b>Autores / Instituições : E-mail (10º Linha)</b> corretamente! ');
			document.getElementById('DivFormResumo').style.display="block";
			return false;
		}else if((document.getElementById("tr_2").style.display == "")  && (document.getElementById("autor2").value == '' || document.getElementById("instituicao2").value == '')){
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (2º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		}else if((document.getElementById("tr_3").style.display == "")  && (document.getElementById("autor3").value == '' || document.getElementById("instituicao3").value == '')){
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (3º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		}else if((document.getElementById("tr_4").style.display == "")  && (document.getElementById("autor4").value == '' || document.getElementById("instituicao4").value == '')){
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (4º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		}else if((document.getElementById("tr_5").style.display == "")  && (document.getElementById("autor5").value == '' || document.getElementById("instituicao5").value == '')){
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (5º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		}else if((document.getElementById("tr_6").style.display == "")  && (document.getElementById("autor6").value == '' || document.getElementById("instituicao6").value == '')){
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (6º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		}
		else if((document.getElementById("tr_7").style.display == "")  && (document.getElementById("autor7").value == '' || document.getElementById("instituicao7").value == '')){
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (7º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		}else if((document.getElementById("tr_8").style.display == "")  && (document.getElementById("autor8").value == '' || document.getElementById("instituicao8").value == '' || document.getElementById("justificativa8").value == '')){
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (8º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		}
		else if((document.getElementById("tr_9").style.display == "")  && (document.getElementById("autor9").value == '' || document.getElementById("instituicao9").value == '' || document.getElementById("justificativa9").value == '')){
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (9º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		}
		else if((document.getElementById("tr_10").style.display == "")  && (document.getElementById("autor10").value == '' || document.getElementById("instituicao10").value == '' || document.getElementById("justificativa10").value == '')){
			mostrarMensagemTopo('erro', 'O Campo <b>Autores / Instituições (10º Linha)</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		}
		else if ((palavrasintroducao == '') || (palavrasintroducao == '0')) {
			mostrarMensagemTopo('erro', 'O Campo <b>Introducao</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		} else if (palavrasintroducao < 2) {
	    	mostrarMensagemTopo('erro', 'O Campo <b>Introducao</b> deve ter no mínimo 2 palavras.');
			document.getElementById('DivFormResumo').style.display="block";
			return false; 
		} else if ((palavrasObjetivo == '') || (palavrasObjetivo == '0')) {
			mostrarMensagemTopo('erro', 'O Campo <b>Objetivo</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false; 
		} else if (palavrasObjetivo < 2) {
			mostrarMensagemTopo('erro', 'O Campo <b>Objetivo</b> deve ter no mínimo 2 palavras.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;
		} else if ((palavrasMetodologia == '') || (palavrasMetodologia == '0')) {
			mostrarMensagemTopo('erro', 'O Campo <b>Metodologia</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false; 
		} else if (palavrasMetodologia < 2) {
			mostrarMensagemTopo('erro', 'O Campo <b>Metodologia</b> deve ter no mínimo 2 palavras.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;  
		} else if ((palavrasResumo == '') || (palavrasResumo == '0')) {
			mostrarMensagemTopo('erro', 'O Campo <b>Resultado</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false; 
		} else if (palavrasResumo < 2) {
			mostrarMensagemTopo('erro', 'O Campo <b>Resultado</b> deve ter no mínimo 2 palavras.');
			document.getElementById('DivFormResumo').style.display="block";
			return false; 
		} else if ((palavrasConclusao == '') || (palavrasConclusao == '0')) {
			mostrarMensagemTopo('erro', 'O Campo <b>Conclusão</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false; 
		} else if (palavrasConclusao < 2) {
			mostrarMensagemTopo('erro', 'O Campo <b>Conclusão</b> deve ter no mínimo 2 palavras.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;
		} else if ((document.getElementById('TextoPalavraChave').value == '') || (palavrasPalavrasChaves == '0')) {
			mostrarMensagemTopo('erro', 'O Campo <b>Palavras-chave</b> é de preenchimento obrigatório.');
			document.getElementById('DivFormResumo').style.display="block";
			return false; 
		}else if (palavrasPalavrasChaves < 3) {
			mostrarMensagemTopo('erro', 'O Campo <b>Palavras-Chaves</b> deve ter no mínimo 3 palavras.');
			document.getElementById('DivFormResumo').style.display="block";
			return false; 
		//}else if (palavrasPalavrasChaves > '5') {
		//	mostrarMensagemTopo('erro', 'O Campo <b>Palavras-chave</b> deve ter no máximo 5 palavras.');
		//	document.getElementById('DivFormResumo').style.display="block";
		//	return false;
		}else if (toalPalavrasResumo > 450) {
			mostrarMensagemTopo('erro', 'O <b>Resumo</b> deve ter no máximo 450 palavras.<br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total de palavras digitadas: <strong>' + toalPalavrasResumo + '</strong>');
			document.getElementById('DivFormResumo').style.display="block";
			return false;
		} else if (!FlagPolitica) {
			mostrarMensagemTopo('erro', 'Você deve concordar com as declarações para poder submeter um Resumo.');
			document.getElementById('DivFormResumo').style.display="block";
			return false; 
		}else if (!FlagPolitica1) {
			mostrarMensagemTopo('erro', 'Você deve concordar com as declarações para poder submeter um Resumo.');
			document.getElementById('DivFormResumo').style.display="block";
			return false; 
		}
		/*else if (!FlagPolitica2) {
			mostrarMensagemTopo('erro', 'Você deve concordar com as declarações para poder submeter um Resumo.');
			document.getElementById('DivFormResumo').style.display="block";
			return false;
		}*//*foi acordado que este campo não é mais obrigatório*/
		/*
		else if (!FlagPolitica3) {
				mostrarMensagemTopo('erro', 'Você deve concordar com as declarações para poder submeter um Resumo.');
				document.getElementById('DivFormResumo').style.display="block";
				return false;  
		}*//*foi acordado que este campo não é mais obrigatório*/
		//else{
			//location.reload(); 
		//}
	    showLoading();
	    
	}

	function dasabilitarFormulario() {
	
		var formData = document.getElementById('formCadastro');
	
	    for (var i=0; i < formData.length; i++) { 
			switch(formData[i].type) {
				case ('radio'):
					formData[i].disabled=true;
				break;
				case ('checkbox'):
					formData[i].disabled=true;
				break;
				default:
					formData[i].disabled=true;
					formData[i].style.backgroundColor="#DDDDDD";
				break;
			}
		}
	}

	function preparaForm(acao) {
		var obj = MM_findObj("acao");
	    if (obj){
	        obj.value = acao;
	    } else {
	        alert("O campo 'acao' não encontrado.");
	    }
	
		if (acao == 'limpar'){
			$('#IdResumo').val('');
			$('#IdUsuario').val(oUsuario.Id);
			//document.getElementById('OutroResumo').checked = false;
			//document.getElementById('Gest_Resumo').checked = false;
			//document.getElementById('Est_Qualitativo').checked = false;
			//document.getElementById('OutrosTemas').value = '';
			
			limparValueRadio("TipoResumo");
			var arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
				for(var i=0;i<arr.length;i++){
					document.getElementById('apresentador'+arr[i]).style.display = '';
				}
			valorTR = 2;
			//document.getElementById('d_Outros').style.display = 'none';
			//document.getElementById('gest').style.display = 'none';
			//document.getElementById('es_qual').style.display = 'none';
			//document.getElementById('outr').style.display = 'none';
			document.getElementById('tr_2').style.display = 'none';
			document.getElementById('tr_3').style.display = 'none';
			document.getElementById('tr_4').style.display = 'none';
			document.getElementById('tr_5').style.display = 'none';
			document.getElementById('tr_6').style.display = 'none';
			document.getElementById('tr_7').style.display = 'none';
			document.getElementById('tr_8').style.display = 'none';
			document.getElementById('tr_8_').style.display = 'none';
			document.getElementById('tr_8__').style.display = 'none';
			document.getElementById('tr_9').style.display = 'none';
			document.getElementById('tr_9_').style.display = 'none';
			document.getElementById('tr_9__').style.display = 'none';
			document.getElementById('tr_10').style.display = 'none';
			document.getElementById('tr_10_').style.display = 'none';
			$('#TituloResumo').val('');
			$('#Textointroducao').val('');
			$('#TextoObjetivo').val('');
			$('#TextoMetodologia').val('');
			$('#TextoResumo').val('');
			$('#TextoConclusao').val('');
			document.getElementById('TextoPalavraChave').value = '';
			tinyMCE.get('TituloResumo').setContent('');
			tinyMCE.get('Textointroducao').setContent('');
			tinyMCE.get('TextoObjetivo').setContent('');
			tinyMCE.get('TextoMetodologia').setContent('');
			tinyMCE.get('TextoResumo').setContent('');
			tinyMCE.get('TextoConclusao').setContent('');
			document.getElementById('autor1').value = '';
			document.getElementById('autor2').value = '';
			document.getElementById('autor3').value = '';
			document.getElementById('autor4').value = '';
			document.getElementById('autor5').value = '';
			document.getElementById('autor6').value = '';
			document.getElementById('autor7').value = '';
			document.getElementById('autor8').value = '';
			document.getElementById('autor9').value = '';
			document.getElementById('autor10').value = '';
			document.getElementById('instituicao1').value = '';
			document.getElementById('instituicao2').value = '';
			document.getElementById('instituicao3').value = '';
			document.getElementById('instituicao4').value = '';
			document.getElementById('instituicao5').value = '';
			document.getElementById('instituicao6').value = '';
			document.getElementById('instituicao7').value = '';
			document.getElementById('instituicao8').value = '';
			document.getElementById('instituicao9').value = '';
			document.getElementById('instituicao10').value = '';
			document.getElementById('email1').value = '';
			document.getElementById('email2').value = '';
			document.getElementById('email3').value = '';
			document.getElementById('email4').value = '';
			document.getElementById('email5').value = '';
			document.getElementById('email6').value = '';
			document.getElementById('email7').value = '';
			document.getElementById('email8').value = '';
			document.getElementById('email9').value = '';
			document.getElementById('email10').value = '';
			document.getElementById('email1').style.display = 'none';
			document.getElementById('email2').style.display = 'none';
			document.getElementById('email3').style.display = 'none';
			document.getElementById('email4').style.display = 'none';
			document.getElementById('email5').style.display = 'none';
			document.getElementById('email6').style.display = 'none';
			document.getElementById('email7').style.display = 'none';
			document.getElementById('email8').style.display = 'none';
			document.getElementById('email9').style.display = 'none';
			document.getElementById('email10').style.display = 'none';
			document.getElementById('apresentador1').value = 0;
			document.getElementById("apresentador1").checked ='';
			document.getElementById('apresentador2').value = 0;
			document.getElementById("apresentador2").checked ='';
			document.getElementById('apresentador3').value = 0;
			document.getElementById("apresentador3").checked ='';
			document.getElementById('apresentador4').value = 0;
			document.getElementById("apresentador4").checked ='';
			document.getElementById('apresentador5').value = 0;
			document.getElementById("apresentador5").checked ='';
			document.getElementById('apresentador6').value = 0;
			document.getElementById("apresentador6").checked ='';
			document.getElementById('apresentador7').value = 0;
			document.getElementById("apresentador7").checked ='';
			document.getElementById('apresentador8').value = 0;
			document.getElementById("apresentador8").checked ='';
			document.getElementById('apresentador9').value = 0;
			document.getElementById("apresentador9").checked ='';
			document.getElementById('apresentador10').value = 0;
			document.getElementById("apresentador10").checked ='';
			document.getElementById('justificativa8').value = '';
			document.getElementById('justificativa9').value = '';
			document.getElementById('justificativa10').value = '';
			document.getElementById('FlagPolitica').checked = false;
			document.getElementById('FlagPolitica1').checked = false;
			document.getElementById('FlagPolitica2').checked = false;
			//document.getElementById('FlagPolitica3').checked = false;
			//document.getElementById('NomeArquivo').value = '';
			$('#acao').val('criar-resumo');
		} else if (acao == 'desabilita'){
			dasabilitarFormulario();
			
		} else if (acao == 'criar-resumo'){
			if (acao == 'limpar'){
				$('#IdResumo').val('');
				$('#IdUsuario').val(oUsuario.Id);
			}
			$('#acao').val('criar-resumo');
		}
	}

	function mostrarMensagemTopo(tipo, mensagem){
	    var obj =null ;
	    
	    obj = MM_findObj('msg_quadro');
	    if (obj != null){
	        obj.style.display = 'block';
	        
	        obj = MM_findObj('msg_icone');
	        if (obj != null){
				obj.src = 'images/i_'+tipo+'.png';
	        }
	        var obj = MM_findObj('msg_texto');
	        if (obj != null){
	            obj.innerHTML = mensagem;
	        }
	    }
		//this.location = "#PAG_TOPO";
		window.scrollTo(0, 10);
	}

	function enviar() { 
		ocultarMensagem();
		$('#formCadastro').submit();
	}

	function cancelar(){
		//preparaForm('limpar');
		ocultarMensagem();
		exibir_objeto('DivFormResumo', 'none');
		preparaForm('desabilita');
		parent.document.getElementById('inneriframe').style.height = "350px";
		ir_para_titulo();
		
	}

	function ocultar_quadros(){
	
		// Ocultar Quadros;
		exibir_objeto('DivFormResumo', 'none');
		
	}

	function pesquisar_meu_poster(){
		
	}

	function mostrarDadosFormulario(IdUsuario) { 
		
		exibir_objeto('DivFormResumo', 'none');
		
		if ((IdUsuario == '') || (IdUsuario == '0')) {
			mostrarMensagem('erro', 'O Campo <b>Id</b> não foi passado por parametro.');
			return false; 
		} else {	
			showLoading();
			$.getJSON('actions/usuario.action.php', { acao: 'retornar', IdUsuario: IdUsuario},
				function(dados){
					if (dados.sucesso){
					
						habilitaForm('true');
						limpaForm();
						document.getElementById("acao").value = '';
						document.getElementById("IdUsuario").value = dados.IdUsuario;
						document.getElementById("label_TipoUsuario").innerHTML = dados.DescricaoTipoUsuario;
						document.getElementById("label_Nome").innerHTML = dados.Nome;
						document.getElementById("label_Email").innerHTML = dados.Email;
						document.getElementById("label_Telefone").innerHTML = dados.Telefone;
						document.getElementById("label_DataNascimento").innerHTML = dados.DataNascimento;
						document.getElementById("label_AreaAtuacao").innerHTML = dados.AreaAtuacao;
						//document.getElementById("label_Colaborador").innerHTML = (dados.FlagColaborador)? 'Sim': 'Não';
	
						if (dados.FlagColaborador) {
							exibir_objeto('TR_COLABORADOR', '');
							exibir_objeto('TR_EXTERNO', 'none');
							document.getElementById("label_ViceDiretoria").innerHTML = dados.ViceDiretoria;
							document.getElementById("label_Departamento").innerHTML = dados.Departamento;
							document.getElementById("label_Divisao").innerHTML = dados.Divisao;
							document.getElementById("label_Secao").innerHTML = dados.Secao;
						} else {
							exibir_objeto('TR_COLABORADOR', 'none');
							exibir_objeto('TR_EXTERNO', '');
							document.getElementById("label_UnidadeExterna").innerHTML = dados.UnidadeExterna;
							document.getElementById("label_FormacaoAcademica").innerHTML = dados.FormacaoAcademica;
						}
						if (dados.IdStatusUsuario == 1){
							document.getElementById('img_Status').src = 'images/i_status_1.png';
						} else if (dados.IdStatusUsuario == 2) {
							document.getElementById('img_Status').src = 'images/i_status_2.png';
						} else if (dados.IdStatusUsuario == 3) {
							document.getElementById('img_Status').src = 'images/i_status_3.png';
                            
                        } else if (dados.IdStatusUsuario == 8) {    // Parcial 
                            $('#bt-AlterarFicha').hide();
                        } else if (dados.IdStatusUsuario == 10) {   // Concluído
                            $('#bt-AlterarFicha').hide();
						} else {
							document.getElementById('img_Status').src = 'images/i_status_1.png';
						}
						document.getElementById("label_StatusUsuario").innerHTML = dados.DescricaoStatus;
						//document.getElementById("label_DataAcesso").innerHTML = dados.DataAcesso;
						document.getElementById("label_DataInclusao").innerHTML = dados.DataInclusao;
						
						mostrarFlags(dados.CanalComunicacao);
						
						document.getElementById("label_FlagResumo").innerHTML = (dados.FlagResumo)? 'Sim': 'Não';
						//document.getElementById("label_FlagPolitica").innerHTML = (dados.FlagPolitica)? 'Sim': 'Não';
						
						if (dados.FlagResumo) {
							// Carregar os Conteudo do Banco
							mostratListaResumo();
							exibir_objeto('bloco_resumo', '');
						} else {
							exibir_objeto('bloco_resumo', 'none');
						}
						
						// pesquisar_resumo(IdUsuario);
						hideLoading();					
						//mostrarMensagem('sucesso', 'Usuário carregado com Sucesso!');
						ocultarMensagem();
					} else {
						mostrarMensagem('alerta', dados.mensagem);
					}
				}
			);
			hideLoading();
		}
	}

	function mostratListaResumo(){
		limparTabela('tab_resumo');
		var IdUsuario = $("#IdUsuario").val();
		
			$.getJSON('actions/resumo.action.php', { acao: 'listar', IdUsuario: IdUsuario}, function(data){ 
					if (data.sucesso){
						mostrarTabelaResumo(data);
						//ocultarMensagem();
					} else {
						//mostrarMensagem('alerta', data.mensagem);
					}
				}
			
			);
			
	}

	function mostrarTabelaResumo(data) {
		var table=document.getElementById('tab_resumo');  
		var tblBody = table.tBodies[0];  
		var total = 0; 
		
		if (data.rows.length > 0 ) {
		
			// Preencher a Table
			for(i=0;i<data.rows.length;i++){
				//document.write(data.aluno[i].nome);
				var newRow = tblBody.insertRow(-1);  
				if (i % 2)	newRow.style.backgroundColor = '#e8edf1';

	
				var newCell1 = newRow.insertCell(0);  
				newCell1.innerHTML = ' ' + data.rows[i].cell[2];  
				/**/
				//newCell1.innerHTML ="OTR010101";
				
				newCell1.className = "td_dados";
				newCell1.align = 'left';

				var newCell2 = newRow.insertCell(1);  
				newCell2.innerHTML = ' ' + data.rows[i].cell[4];  
				/**/
				newCell2.innerHTML ="<a href='admin/modulo/resumo/resumo.mpdf.php?acao=visualizar&IdResumo=" + data.rows[i].cell[0] +"' titel='Visualizar Impressão' target='_blank' style='color:#595959;text-decoration:none;'> <img src='images/i_pdf.png' alt='Visualizar Impressão' class='img_icone' />&nbsp;&nbsp;&nbsp;&nbsp;"+ data.rows[i].cell[5] +"</a>";
				
				newCell2.className = "td_dados";
				newCell2.align = 'left';
					 
				var newCell3 = newRow.insertCell(2);  
				newCell3.innerHTML = '&nbsp;' + data.rows[i].cell[4];  
				newCell3.className = "td_dados";
				newCell3.align = 'left';
	
				var newCell4 = newRow.insertCell(3);  
					//newCell3.innerHTML =" <a href='arquivos/" + data.rows[i].cell[6] +"' titel='Visualizar Impressão' target='_blank'><img src='images/i_download.png' alt='Visualizar Impressão' class='img_icone' />"+ data.rows[i].cell[6] +"</a><br/>";
					newCell4.innerHTML = '<img class="img_icone" src="images/i_status_doc_'+data.rows[i].cell[13]+'.png" />'+data.rows[i].cell[14]+'&nbsp;'; 
					newCell4.className = "td_dados";
					newCell4.align = 'left';

					//var newCell4 = newRow.insertCell(3);  
					//newCell4.innerHTML = ' <img class="img_icone" src="images/i_status_doc_'+data.rows[i].cell[8]+'.png" />'+data.rows[i].cell[9]+'&nbsp;';  
					//newCell4.innerHTML = ' <img class="img_icone" src="images/i_status_doc_1.png" />'+data.rows[i].cell[9]+'&nbsp;';
					//newCell4.innerHTML = '<a href="#" onclick="abrirFormResumo();" style="color:#000000; text-decoration:none;"> Editar</a>';
					//newCell4.innerHTML = '<a href="#" style="color:#000000;text-decoration:none;"> Editar Resumo</a>';
					//newCell4.innerHTML ='&nbsp;'; 
					//newCell4.className = "td_dados";
					//newCell4.align = 'left';
	
				var newCell5 = newRow.insertCell(4);  
				//if (data.rows[i].cell[9] == '1'){
					//newCell5.innerHTML = ' <img class="img_icone botao_cadastro" src="images/i_abrir.gif" onclick="revisar_resumo('+data.rows[i].cell[0]+');"  />'+'&nbsp;';
					newCell5.innerHTML = data.rows[i].cell[16];  
				//} else {
				//	newCell5.innerHTML = '&nbsp;';  
					
				//}
				newCell5.className = "td_dados";
				newCell5.align = 'left';

				var newCell6 = newRow.insertCell(5);  
				//if (data.rows[i].cell[9] == '1'){
					//newCell5.innerHTML = ' <img class="img_icone botao_cadastro" src="images/i_abrir.gif" onclick="revisar_resumo('+data.rows[i].cell[0]+');"  />'+'&nbsp;';
                    if ((data.rows[i].cell[13]==1) || (data.rows[i].cell[13]==3)){ // {1: Enviado, 3: Com Pendencia}
                        newCell6.innerHTML = '<a href="#" onclick="editarFormResumoPorID('+data.rows[i].cell[0]+');" style="color:#000000; text-decoration:none;"><img class="img_icone botao_cadastro" src="images/pencil-icon.png"/>Editar</a>';
                    } else {
                        newCell6.innerHTML = '';
                    } 
				//} else {
				//	newCell5.innerHTML = '&nbsp;';  
					
				//}
				newCell6.className = "td_dados";
				newCell6.align = 'left';
				
				//total = total + parseFloat(data.rows[i].cell[3]);
			}
			//document.getElementById("bt-_enviar-resumo").style.display="none";
			//document.getElementById('label_total').innerHTML = total;
		}
	}  

	function mostrarFlags(Canal){
	
		if ((Canal & 1)==1){
			exibir_objeto('label_FlagAscom', '');
			document.getElementById('FlagAscom').src = 'images/checkbox_1.gif';
		} else exibir_objeto('label_FlagAscom', 'none');
		if ((Canal & 2)==2){
			exibir_objeto('label_FlagIndicacao', '');
			document.getElementById('FlagIndicacao').src = 'images/checkbox_1.gif';
		} else exibir_objeto('label_FlagIndicacao', 'none');
		if ((Canal & 4)==4){
			exibir_objeto('label_FlagBioMural', '');
			document.getElementById('FlagBioMural').src = 'images/checkbox_1.gif';
		} else exibir_objeto('label_FlagBioMural', 'none');
		if ((Canal & 8)==8){
			exibir_objeto('label_FlagBioDigital', '');
			document.getElementById('FlagBioDigital').src = 'images/checkbox_1.gif';
		} else exibir_objeto('label_FlagBioDigital', 'none');
		if ((Canal & 16)==16){
			exibir_objeto('label_FlagWebTV', '');
			document.getElementById('FlagWebTV').src = 'images/checkbox_1.gif';
		} else exibir_objeto('label_FlagWebTV', 'none');
		if ((Canal & 32)==32){
			exibir_objeto('label_FlagCartazes', '');
			document.getElementById('FlagCartazes').src = 'images/checkbox_1.gif';
		} else exibir_objeto('label_FlagCartazes', 'none');
		if ((Canal & 64)==64){
			exibir_objeto('label_FlagOutros', '');
			document.getElementById('FlagOutros').src = 'images/checkbox_1.gif';
		} else exibir_objeto('label_FlagOutros', 'none');
	
	}

	function abrirFormResumo(){
		exibir_objeto('DivFormResumo', '');
	
		habilitaForm('false');
		document.getElementById('tr_2').style.display = 'none';
		document.getElementById('tr_3').style.display = 'none';
		document.getElementById('tr_4').style.display = 'none';
		document.getElementById('tr_5').style.display = 'none';
		document.getElementById('tr_6').style.display = 'none';
		document.getElementById('tr_7').style.display = 'none';
		document.getElementById('tr_8').style.display = 'none';
		document.getElementById('tr_8_').style.display = 'none';
		document.getElementById('tr_8__').style.display = 'none';
		document.getElementById('tr_9').style.display = 'none';
		document.getElementById('tr_9_').style.display = 'none';
		document.getElementById('tr_9__').style.display = 'none';
		document.getElementById('tr_10').style.display = 'none';
		document.getElementById('tr_10_').style.display = 'none';
		preparaForm('limpar');
		preparaForm('criar-resumo');
		this.location = '#a_box_resumo';
		parent.document.getElementById('inneriframe').style.height = "2000px";
	}

	function editarFormResumoPorID(IdResumo) { 
		preparaForm('limpar');
		
		
		if ((IdResumo == '') || (IdResumo == '0')) {
			mostrarMensagem('erro', 'O Campo <b>Id</b> não foi passado por parametro.');
			return false; 
		} else {	
			showLoading();
			$.getJSON('actions/' + oModulo.Classe + '.action.php', { acao: 'retornarPorID', IdResumo: IdResumo, IdUsuario: oUsuario.Id},
				function(dados){
					if (dados.sucesso){
						habilitaForm('false');
						exibir_objeto('DivFormResumo', '');
						document.getElementById("acao").value = 'alterar-resumo';
						document.getElementById("IdResumo").value =dados.idResumo;
						var form = document.forms['formCadastro'];
						var valorTipoResumo = dados.TipoResumo - 1;
						document.getElementById("TipoResumo"+dados.TipoResumo).checked = true;
						//form.elements['TipoResumo'][valorTipoResumo].checked = true;
						/*
						var valorOutroResumo = dados.OutroResumo -1;
						var valorGest_Resumo = dados.Gest_Resumo -1;
						var valorEst_Qualitativo = dados.Est_Qualitativo -1;
						if(dados.TipoResumo == 4){
							document.getElementById('d_Outros').style.display = '';
							form.elements['OutroResumo'][valorOutroResumo].checked = true;

							if(dados.OutroResumo == 1){
								document.getElementById('gest').style.display = '';
								form.elements['Gest_Resumo'][valorGest_Resumo].checked = true;
							}
							
							if(dados.OutroResumo == 2){
								document.getElementById('es_qual').style.display = '';
								form.elements['Est_Qualitativo'][valorEst_Qualitativo].checked = true;
							}
							
							if(dados.OutroResumo == 3){
								document.getElementById('outr').style.display = '';
								document.getElementById("OutrosTemas").value =dados.OutrosTemas;
							}
							else
								document.getElementById("OutrosTemas").value ='';
						}else{
							document.getElementById('d_Outros').style.display = 'none';
							document.getElementById('gest').style.display = 'none';
							document.getElementById('es_qual').style.display = 'none';
							document.getElementById('outr').style.display = 'none';
						}
						*/

						//document.getElementById("TipoResumo").value =dados.TipoResumo;

						tinyMCE.get('TituloResumo').setContent(dados.TituloResumo);

						if(dados.autor2 != ''){document.getElementById('tr_2').style.display = '';}
						if(dados.autor3 != ''){document.getElementById('tr_3').style.display = '';}
						if(dados.autor4 != ''){document.getElementById('tr_4').style.display = '';}
						if(dados.autor5 != ''){document.getElementById('tr_5').style.display = '';}
						if(dados.autor6 != ''){document.getElementById('tr_6').style.display = '';}
						if(dados.autor7 != ''){document.getElementById('tr_7').style.display = '';}
						if(dados.autor8 != ''){
							document.getElementById('tr_8').style.display = '';
							document.getElementById('tr_8_').style.display = '';
							document.getElementById('tr_8__').style.display = '';
						}
						if(dados.autor9 != ''){
							document.getElementById('tr_9').style.display = '';
							document.getElementById('tr_9_').style.display = '';
							document.getElementById('tr_9__').style.display = '';
						}
						if(dados.autor10 != ''){document.getElementById('tr_10').style.display = '';document.getElementById('tr_10_').style.display = '';}	

						$('#apresentador1').val(dados.apresentador1);
						if(dados.apresentador1 == 1){document.getElementById("apresentador1").checked = "checked";
							document.getElementById("email1").style.display = '';}
						$('#apresentador2').val(dados.apresentador2);
						if(dados.apresentador2 == 1){document.getElementById("apresentador2").checked = "checked";
							document.getElementById("email2").style.display = '';}
						$('#apresentador3').val(dados.apresentador3);
						if(dados.apresentador3 == 1){document.getElementById("apresentador3").checked = "checked";
							document.getElementById("email3").style.display = '';}
						$('#apresentador4').val(dados.apresentador4);
						if(dados.apresentador4 == 1){document.getElementById("apresentador4").checked = "checked";
							document.getElementById("email4").style.display = '';}
						$('#apresentador5').val(dados.apresentador5);
						if(dados.apresentador5 == 1){document.getElementById("apresentador5").checked = "checked";
							document.getElementById("email5").style.display = '';}
						$('#apresentador6').val(dados.apresentador6);
						if(dados.apresentador6 == 1){document.getElementById("apresentador6").checked = "checked";
							document.getElementById("email6").style.display = '';}
						$('#apresentador7').val(dados.apresentador7);
						if(dados.apresentador7 == 1){document.getElementById("apresentador7").checked = "checked";
							document.getElementById("email7").style.display = '';}
						$('#apresentador8').val(dados.apresentador8);
						if(dados.apresentador8 == 1){document.getElementById("apresentador8").checked = "checked";
							document.getElementById("email8").style.display = '';}
						if(dados.apresentador9 == 1){document.getElementById("apresentador9").checked = "checked";
							document.getElementById("email9").style.display = '';}
						if(dados.apresentador10 == 1){document.getElementById("apresentador10").checked = "checked";
							document.getElementById("email10").style.display = '';}

						document.getElementById("autor1").value = dados.autor1;
						document.getElementById("autor2").value =dados.autor2;
						document.getElementById("autor3").value =dados.autor3;
						document.getElementById("autor4").value =dados.autor4;
						document.getElementById("autor5").value =dados.autor5;
						document.getElementById("autor6").value =dados.autor6;
						document.getElementById("autor7").value =dados.autor7;
						document.getElementById("autor8").value =dados.autor8;
						document.getElementById("autor9").value =dados.autor9;
						document.getElementById("autor10").value =dados.autor10;
						document.getElementById("instituicao1").value = dados.instituicao1;
						document.getElementById("instituicao2").value =dados.instituicao2;
						document.getElementById("instituicao3").value =dados.instituicao3;
						document.getElementById("instituicao4").value =dados.instituicao4;
						document.getElementById("instituicao5").value =dados.instituicao5;
						document.getElementById("instituicao6").value =dados.instituicao6;
						document.getElementById("instituicao7").value =dados.instituicao7;
						document.getElementById("instituicao8").value =dados.instituicao8;
						document.getElementById("instituicao9").value =dados.instituicao9;
						document.getElementById("instituicao10").value =dados.instituicao10;
						document.getElementById("email1").value =dados.email1;
						document.getElementById("email2").value =dados.email2;
						document.getElementById("email3").value =dados.email3;
						document.getElementById("email4").value =dados.email4;
						document.getElementById("email5").value =dados.email5;
						document.getElementById("email6").value =dados.email6;
						document.getElementById("email7").value =dados.email7;
						document.getElementById("email8").value =dados.email8;
						document.getElementById("email9").value =dados.email9;
						document.getElementById("email10").value =dados.email10;
						/*document.getElementById("apresentador1").value =dados.apresentador1;
						document.getElementById("apresentador2").value =dados.apresentador2;
						document.getElementById("apresentador3").value =dados.apresentador3;
						document.getElementById("apresentador4").value =dados.apresentador4;
						document.getElementById("apresentador5").value =dados.apresentador5;
						document.getElementById("apresentador6").value =dados.apresentador6;
						document.getElementById("apresentador7").value =dados.apresentador7;
						document.getElementById("apresentador8").value =dados.apresentador8;
						document.getElementById("apresentador9").value =dados.apresentador9;
						document.getElementById("apresentador10").value =dados.apresentador10;*/
						document.getElementById("justificativa8").value =dados.justificativa8;
						document.getElementById("justificativa9").value =dados.justificativa9;
						document.getElementById("justificativa10").value =dados.justificativa10;
						tinyMCE.get('Textointroducao').setContent(dados.Textointroducao);
						tinyMCE.get('TextoObjetivo').setContent(dados.TextoObjetivo);
						tinyMCE.get('TextoMetodologia').setContent(dados.TextoMetodologia);
						tinyMCE.get('TextoResumo').setContent(dados.TextoResumo);
						tinyMCE.get('TextoConclusao').setContent(dados.TextoConclusao);
						document.getElementById('TextoPalavraChave').value = dados.TextoPalavraChave;
						//document.getElementById("FlagPolitica").cheched = dados.FlagPolitica;
						//document.getElementById("FlagPolitica1").cheched = dados.FlagPolitica1;
						//document.getElementById("FlagPolitica2").checked = dados.FlagPolitica2;
						//document.getElementById("FlagPolitica3").checked = dados.FlagPolitica3;
						hideLoading();					
						mostrarMensagem('sucesso', 'Resumo carregado com Sucesso!');
						
						
					} else {
						mostrarMensagem('alerta', data.mensagem);
					}
				}
			);
			hideLoading();
		}
	}
	
	function editarFormResumo(IdUsuario) { 
			if ((IdUsuario == '') || (IdUsuario == '0')) {
				mostrarMensagem('erro', 'O Campo <b>Id</b> não foi passado por parametro.');
				return false; 
			} else {	
				showLoading();
				$.getJSON('actions/' + oModulo.Classe + '.action.php', { acao: 'retornar', IdUsuario: IdUsuario},
					function(dados){ 
						if (dados.sucesso){
							habilitaForm('false');
							exibir_objeto('DivFormResumo', '');
							document.getElementById("acao").value = 'alterar-resumo';
							document.getElementById("IdResumo").value =dados.idResumo;
							//document.getElementById("TipoResumo").value =dados.TipoResumo;
							document.getElementById("TipoResumo"+dados.TipoResumo).checked = true;
							tinyMCE.get('TituloResumo').setContent(dados.TituloResumo);
							document.getElementById("autor1").value =dados.autor1;
							document.getElementById("autor2").value =dados.autor2;
							document.getElementById("autor3").value =dados.autor3;
							document.getElementById("autor4").value =dados.autor4;
							document.getElementById("autor5").value =dados.autor5;
							document.getElementById("autor6").value =dados.autor6;
							document.getElementById("autor7").value =dados.autor7;
							document.getElementById("autor8").value =dados.autor8;
							document.getElementById("autor9").value =dados.autor9;
							document.getElementById("autor10").value =dados.autor10;
							document.getElementById("instituicao1").value =dados.instituicao1;
							document.getElementById("instituicao2").value =dados.instituicao2;
							document.getElementById("instituicao3").value =dados.instituicao3;
							document.getElementById("instituicao4").value =dados.instituicao4;
							document.getElementById("instituicao5").value =dados.instituicao5;
							document.getElementById("instituicao6").value =dados.instituicao6;
							document.getElementById("instituicao7").value =dados.instituicao7;
							document.getElementById("instituicao8").value =dados.instituicao8;
							document.getElementById("instituicao9").value =dados.instituicao9;
							document.getElementById("instituicao10").value =dados.instituicao10;
							document.getElementById("email1").value =dados.email1;
							document.getElementById("email2").value =dados.email2;
							document.getElementById("email3").value =dados.email3;
							document.getElementById("email4").value =dados.email4;
							document.getElementById("email5").value =dados.email5;
							document.getElementById("email6").value =dados.email6;
							document.getElementById("email7").value =dados.email7;
							document.getElementById("email8").value =dados.email8;
							document.getElementById("email9").value =dados.email9;
							document.getElementById("email10").value =dados.email10;
							document.getElementById("apresentador1").value =dados.apresentador1;
							document.getElementById("apresentador2").value =dados.apresentador2;
							document.getElementById("apresentador3").value =dados.apresentador3;
							document.getElementById("apresentador4").value =dados.apresentador4;
							document.getElementById("apresentador5").value =dados.apresentador5;
							document.getElementById("apresentador6").value =dados.apresentador6;
							document.getElementById("apresentador7").value =dados.apresentador7;
							document.getElementById("apresentador8").value =dados.apresentador8;
							document.getElementById("apresentador9").value =dados.apresentador9;
							document.getElementById("apresentador10").value =dados.apresentador10;
							document.getElementById("justificativa8").value =dados.justificativa8;
							document.getElementById("justificativa9").value =dados.justificativa9;
							document.getElementById("justificativa10").value =dados.justificativa10;
							tinyMCE.get('Textointroducao').setContent(dados.Textointroducao);
							tinyMCE.get('TextoObjetivo').setContent(dados.TextoObjetivo);
							tinyMCE.get('TextoMetodologia').setContent(dados.TextoMetodologia);
							tinyMCE.get('TextoResumo').setContent(dados.TextoResumo);
							tinyMCE.get('TextoConclusao').setContent(dados.TextoConclusao);
							document.getElementById('TextoPalavraChave').value =dados.TextoPalavraChave;
							//document.getElementById("FlagPolitica").checked = dados.FlagPolitica;
							//document.getElementById("FlagPolitica1").checked = dados.FlagPolitica1;
							//document.getElementById("FlagPolitica2").checked = dados.FlagPolitica2; 
							//document.getElementById("FlagPolitica3").checked = dados.FlagPolitica3; 
							hideLoading();					
							mostrarMensagem('sucesso', 'Resumo carregado com Sucesso!');
							
						} else {
							mostrarMensagem('alerta', data.mensagem);
						}
					}
				);
				hideLoading();
			}
		}

	function pesquisar_resumo(IdUsuario){
		if ((IdUsuario == '') || (IdUsuario == '0')) {
			mostrarMensagem('erro', 'O Campo <b>IdUsuario</b> não foi carregado.');
			return false; 
		} else {
		
			ocultarMensagem();
	
			showLoading();
			hideLoading();
			
			exibir_objeto('DivFormResumo', '');
		}
	}

	function limparTabela(nomeTabela) {
		// Linpar a Tabela
		var table=document.getElementById(nomeTabela);
		var rowCount = table.rows.length;
		for(var i=1; i<rowCount; i++) {
			//var row = table.rows[i];
			table.deleteRow(i);
			rowCount--;
			i--;
		}
	
	}

	function revisar_resumo(id_revisao){
		alert('Em construção!');
	}

	function inicializar() {
        var hoje = <?php echo intval(date('Ymd')); ?>;
            
        console.log('{IdUsuario:'+oUsuario.Id+', Hoje:'+hoje+'}');
        
		$('#IdUsuario').val(oUsuario.Id);
		if (oUsuario.Id > 0){

            if ((hoje >= 20160401) && (hoje <= 20160430)){ // Já esta no perído de apenas enviar resumo ?
                window.open('../index.php/enviar-resumo', '_top', '', true);
            } else if ((hoje > 20160518) && (hoje <= 20160630)){ // Já esta no perído de imprimir certificados ?
                window.open('../index.php/minha-inscricao', '_top', '', true);
            } else {
                // Vamos exibir a pagina atual
                mostrarDadosFormulario(oUsuario.Id);
            }
		}
	}

	function DesabilitaChcBox(valor){
		
		var arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
		//var resultado = arr.indexOf(valor);
		//resultado = resultado + 1;
		if(document.getElementById("apresentador"+valor).checked){
		
			document.getElementById('email'+valor).style.display = '';
			document.getElementById('apresentador'+valor).value = 1;
			for(var i=0;i<arr.length;i++){
				//alert(arr[i]);
				if(arr[i] != valor){
					document.getElementById('apresentador'+arr[i]).style.display = 'none';
				}

			}

		}else{
			
			document.getElementById('email'+valor).style.display = 'none';
			document.getElementById('apresentador'+valor).value = 0;
			for(var i=0;i<arr.length;i++){
				//alert(arr[i]);
				if(arr[i] != valor){
					document.getElementById('apresentador'+arr[i]).style.display = '';
				}
				

			}
			
		}
	}
	
	function limparAutor(Numero)
	{
		for(var i=Numero;i<=10;i++){
			$('#tr_'+i).hide();
			$('#autor'+i).val('');
			$('#instituicao'+i).val('');
			$('#email'+i).val('');
			$('#apresentador'+i).val('');
			$('#apresentador'+i).val('');
			if (document.getElementById('apresentador'+i).checked) {
				DesabilitaChcBox(i);
			}
			if (i>=8){
				$('#tr_'+i+'_').hide();
				$('#tr_'+i+'__').hide();
				$('#justificativa'+i).val('');
			}
		}
		valorTR = Numero;
	}
	

</script>