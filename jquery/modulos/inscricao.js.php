<script type="text/javascript">

var mod_classe = '<?php echo $MOD_CLASSE; ?>';
var id_usuario = '<?php echo ($USO_ID + 0); ?>';

jQuery(document).ready(function(){
	
	/* JQUERY.TABS ******************************************************************************************************************************** */
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

	$("#Cpf").mask("999.999.999-99",{placeholder:" "});
    //$("#CEP").mask("99999-999",{placeholder:" "});
    //$("#Telefone").mask("(99) 9999-9999",{placeholder:" "});
	$("#DataNascimento").datepicker({
        /*changeMonth: true,
        changeYear: true,
		 yearRange: "-100:+0",
		 defaultDate: 0,*/
		 changeYear: true,
		 yearRange : '1900:2014',
		showOn: "button",
		buttonImage: "images/i_calendario.png",
		buttonImageOnly: true		
    });  
		
	/* JQUERY.AJAXFORM ****************************************************************************************************************************** */
    var optionsForm = { 
        type: 'POST',
		url: 'modulos/' + mod_classe + '.action.php',
		target:        '#resultado',   // target element(s) to be updated with server response 
        beforeSubmit:  validaForm, // pre-submit callback 
		dataType: 'json',
        success:       showResponse  // post-submit callback 
		
    }; 

    $("#formCadastro").ajaxForm(optionsForm);

	/* JQUERY.DIALOG ****************************************************************************************************************************** */

	$("#dialog:ui-dialog" ).dialog( "destroy" );

	$("#popup_confirmacao" ).dialog({
				resizable: false,
				height:140,
				modal: true,
				autoOpen: false,
				buttons: {
					" Confirmar ": function() {
						$( this ).dialog( "close" );
						concluir_exclusao();
					},
					" Cancelar ": function() {
						$( this ).dialog( "close" );
					}
				}
	});
	

});

/* JS NORMAIS ************************************************************************************************************************************ */

 
function showLoading(){
	$.blockUI({ theme: true, title: 'Bio-Manguinhos', message: '<p>Por favor aguarde . . . </p>'}); 
}

function hideLoading(){
	$.unblockUI();
}

// pre-submit callback 
function showRequest(formData, jqForm, options) { 
    var queryString = $.param(formData); 
 
    return true; 
} 
 
// post-submit callback 
function showResponse(data)  { 
	var FlagResumo = getValueRadio("FlagResumo");
	
	//alert(data); 
    hideLoading();

	if (data.sucesso) {
		mostrarMensagemTopo('sucesso', data.mensagem);
		preparaForm('desabilita');
		
		exibir_objeto('bt_enviar', 'none');
		//exibir_objeto('barra_usuario', '');
		if (FlagResumo == 1) {
			URL = 'controller.php?modulo=minha-area&acao=add-resumo';
		} else {
			URL = 'controller.php?modulo=minha-inscricao';
		}
		window.location.href = URL;		
		
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

function validaForm(formData, jqForm, options) { 
 	
	var Tipo  = getValueRadio("IdTipoUsuario");
	var FlagColaborador = getValueRadio("FlagColaborador");
	var FlagResumo = getValueRadio("FlagResumo");
	
	
	var objNome  = document.getElementById('Nome');
	var objEmail  = document.getElementById('Email');
	var objSenha = document.getElementById('Senha');
	var objConfirmacaoSenha = document.getElementById('ConfirmacaoSenha');
	
	var palavrasNome = 0;
	var temp = objNome.value.split(' ');
	palavrasNome = temp.length;
	var dataNasc =  document.getElementById('DataNascimento');
	var FlagResumo = getValueRadio('FlagResumo');

	//alert('palavras='+palavras);
	var AutorizadoPor = document.getElementById("autorizadoPor");
	var p_AutorizadoPor = AutorizadoPor.options[AutorizadoPor.selectedIndex].value;

	var NomeChefiaImediata = document.getElementById('chefiaImediata').value;
	var NomeGerenteDepartamento = document.getElementById('gerenteDep').value;
	var NomeViceDiretor = document.getElementById('viceDir').value;
	
 	ocultarMensagem();
	console.log('validaForm();');
	 
	if ((Tipo == '') || (Tipo == '0')) {
		mostrarMensagemTopo('erro', 'É necessário preencher o Campo <b>Você é?</b>.');
		return false; 
	} else if ((objNome.value == '') || (objNome.value == '0')) {
		mostrarMensagemTopo('erro', 'O Campo <b>Nome</b> é de preenchimento obrigatório.');
		return false; 
	} else if (palavrasNome< '2') {
		mostrarMensagemTopo('erro', 'O Campo <b>Nome</b> tem que ter no mínimo um sobrenome.');
		return false; 
	}else if ((dataNasc.value == '') || (dataNasc.value == '0')) {
		mostrarMensagemTopo('erro', 'O Campo <b>Data Nascimento</b> é de preenchimento obrigatório.');
		return false; 
	}
	else if ((objEmail.value == '') || (objEmail.value == '0')) {
		mostrarMensagemTopo('erro', 'O Campo <b>Email</b> é de preenchimento obrigatório.');
		return false; 
	} else if ((objSenha.value == '') || (objSenha.value == '0')) {
		mostrarMensagemTopo('erro', 'O Campo <b>Senha</b> é de preenchimento obrigatório.');
		return false; 
	} else if ((objSenha.value.length < 5) || (objSenha.value.length > 10)) {
		mostrarMensagemTopo('erro', 'O Campo <b>Senha</b> tem que ter no mínimo de 5 e no máximo de 10 caractereso.');
		return false; 
	} else if ((objConfirmacaoSenha.value == '') || (objConfirmacaoSenha.value == '0')) {
		mostrarMensagemTopo('erro', 'O Campo <b>Confirmção da senha</b> é de preenchimento obrigatório.');
		return false; 
	}

	else if ((objSenha.value != objConfirmacaoSenha.value)) {
		mostrarMensagemTopo('erro', 'O Campo <b>Confirmação de Senha</b> está diferente do campo <b>Senha</b>.');
		return false; 
    } 	

	if (FlagColaborador == '') {
		mostrarMensagemTopo('erro', 'O Campo <b>Você é um colaborador de Bio-Manguinhos</b> é de preenchimento obrigatório.');
		return false; 
	}
	

	if (FlagColaborador == 1) {
		var ViceDiretoria  = document.getElementById('ViceDiretoria').value;
		var Departamento  = document.getElementById('Departamento').value;
		var Divisao  = document.getElementById('Divisao').value;
		var Secao  = document.getElementById('Secao').value;
		
		if ((ViceDiretoria == '') || (ViceDiretoria == '0')) {
			mostrarMensagemTopo('erro', 'O Campo <b>Vice Diretoria</b> é de preenchimento obrigatório.');
			return false; 
		/* } else if ((Departamento == '') || (Departamento == '0')) {
			mostrarMensagemTopo('erro', 'O Campo <b>Departamento</b> é de preenchimento obrigatório.');
			return false; 
		} else if ((Divisao == '') || (Divisao == '0')) {
			mostrarMensagemTopo('erro', 'O Campo <b>Divisao</b> é de preenchimento obrigatório.');
			return false; 
		} else if ((Secao == '') || (Secao == '0')) {
			mostrarMensagemTopo('erro', 'O Campo <b>Seção</b> é de preenchimento obrigatório.');
			return false;  */
		}
		if((p_AutorizadoPor == '')){
				mostrarMensagemTopo('erro', 'O Campo <b>Autorizado Por</b> é de preenchimento obrigatório.');
				return false; 
		}

		if((p_AutorizadoPor == '1')){
			if(NomeChefiaImediata == ''){mostrarMensagemTopo('erro', 'O Campo <b>Nome (Chefia imediata)</b> é de preenchimento obrigatório.');
			return false;

			} 
		}
		if((p_AutorizadoPor == '2')){
			if(NomeGerenteDepartamento == ''){
				mostrarMensagemTopo('erro', 'O Campo <b>Nome (Gerente de departamento)</b> é de preenchimento obrigatório.');
			return false;

			} 
		}
		if((p_AutorizadoPor == '3')){
			if(NomeViceDiretor == ''){
				mostrarMensagemTopo('erro', 'O Campo <b>Nome (Vice- Diretoria)</b> é de preenchimento obrigatório.');
			return false;

			} 
		}
	}
	
	if(FlagResumo == '' || FlagResumo.value == 0 ){
		mostrarMensagemTopo('erro', 'O Campo <b>Deseja submeter um resumo</b> é de preenchimento obrigatório.');
		return false; 
		} 
	
	if (FlagResumo == 1) {
		//var TipoResumo  = getValueRadio("TipoResumo");
		var DataNascimento = getValueRadio("DataNascimento").value;
		//var TituloResumo  = document.getElementById('TituloResumo').value;
		//var ConteudoResumo  = document.getElementById('ConteudoResumo').value;
		//var palavrasTitulo = ContarPalavras(document.getElementById('TituloResumo'));
		//var palavrasResumo = ContarPalavras(document.getElementById('ConteudoResumo'));
		if ((DataNascimento == '') || (DataNascimento == '  /  /    ')) {
			mostrarMensagemTopo('erro', 'O Campo <b>Data Nascimento</b> é de preenchimento obrigatório.');
			return false; 
		/* } else if (!IsDate(DataNascimento)) {
			mostrarMensagemTopo('erro', 'O Campo <b>Data Nascimento</b> é de preenchimento obrigatório.');
			return false; */
		}
		
	}

	console.log('validaForm(); returue;');
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

	var objTipo  = document.getElementById('IdTipoUsuario');
	var objNome  = document.getElementById('Nome');
	var objEmail  = document.getElementById('Email');
	var objSenha = document.getElementById('Senha');
	var objConfirmacaoSenha = document.getElementById('ConfirmacaoSenha');
	
    var obj = MM_findObj("acao");
    if (obj){
        obj.value = acao;
    } else {
        alert("O campo 'acao' não encontrado.");
    }

	if (acao == 'desabilita'){

		dasabilitarFormulario();

	}
}

function enviar() {
	ocultarMensagem();
    $('#formCadastro').submit();

}

/*
function selecionar_estado(IdEstado, IdPais, tecla, disabled) 
{ 
    if(tecla==13){

        $.get('admin/modulo/estado/estado.action.php', { acao: "combo_estado", IdEstado: IdEstado, IdPais: IdPais},
            function(data){
                jQuery('#combo_estado').html(data);          
            }
        );

    }
}
selecionar_estado('', '', '13', 'true');

function selecionar_pais(IdPais, tecla, disabled) 
{ 
    if(tecla==13){

        $.get('admin/modulo/pais/pais.action.php', { acao: "combo_pais", IdPais: IdPais},
            function(data){
                jQuery('#combo_pais').html(data);          
            }
        );

    }
}
selecionar_pais('31', '13', 'true');
*/

function show(obj) {
	//alert(obj);
	exibir_objeto(obj, '');
}
function hide(obj) {
	//alert(obj);
	exibir_objeto(obj, 'none');
}

function ContarPalavras(obj){     
	obj.value = obj.value.replace('  ', ' ');
	var palavra = obj.value.split(' ');
	return palavra.length;
}

function retornar(IdInscricao, IdUsuario) 
{ 
    if ((IdInscricao>0) || (IdUsuario>0)){
		$('#btn_login').hide();
		$('#bt_enviar').hide();
		
		
		
        $.getJSON('admin/modulo/usuario/usuario.action.php', { acao: "retornar", IdUsuario: IdUsuario},
            function(data){
           
            	if (data.sucesso == 1) {
            		$('#acao').val('alterar');
            		$('#IdUsuario').val(data.Id);       

            		if(data.IdTipoUsuario == 1) {
                		
            			$("#IdTipoUsuario1").attr("checked", true);
            		}
            		else if (data.IdTipoUsuario == 2) {
            			$("#IdTipoUsuario2").attr("checked", true);
            		}
            		else if (data.IdTipoUsuario == 3) {
            			$("#IdTipoUsuario3").attr("checked", true);
            		}
            		else if (data.IdTipoUsuario == 4) {
            			$("#IdTipoUsuario4").attr("checked", true);
            		}
            		else if (data.IdTipoUsuario == 5) {
                    	$("#IdTipoUsuario5").attr("checked", true);
            		}
            		else {
                		
            		}
		
            		$('#Nome').val(data.Nome);
            		$('#DataNascimento').val(data.DataNascimento);
            		//$('#AreaAtuacao').val(data.AreaAtuacao);
            		$('#Email').val(data.Email);
            		$('#Senha').val(data.Senha);
            		$('#ConfirmacaoSenha').val(data.Senha);

            		if(data.FlagAscom == 1) {

            			$("#FlagAscom").attr("checked", true);
            		}
            		
            		if(data.FlagIndicacao == 1) {

            			$("#FlagIndicacao").attr("checked", true);
            		}
            		
            		if(data.FlagBioMural == 1) {

            			$("#FlagBioMural").attr("checked", true);
            		}
            		
            		if(data.FlagBioDigital == 1) {

            			$("#FlagBioDigital").attr("checked", true);
            		}
            		
            		if(data.FlagWebTV == 1) {

            			$("#FlagWebTV").attr("checked", true);
            		}

            		if(data.FlagCartazes == 1) {

            			$("#FlagCartazes").attr("checked", true);
            		}

            		if(data.FlagOutros == 1) {

            			$("#FlagOutros").attr("checked", true);
            		}

            		$('#Telefone').val(data.Telefone);

            		$('#AreaAtuacao').val(data.AreaAtuacao);
            		
            		
            		if (data.FlagColaborador == 1){
            			$('#FlagColaborador1').attr('checked',true);
            			$('#FlagColaborador0').attr('checked', false);
            			TipoColaborador();
            			
            			setItemCombo('autorizadoPor', data.Autorizado);
            			exibeInputResponsavel(data.Autorizado);
            			$('#chefiaImediata').val(data.NomeChefiaImediata);
            			
            			$('#ViceDiretoria').val(data.ViceDiretoria);
            			$('#Departamento').val(data.Departamento);
            			$('#Divisao').val(data.Divisao);
            			$('#Secao').val(data.Secao);
            			
            		} else {
                		
            			$('#FlagColaborador1').attr('checked', false);
            			$('#FlagColaborador0').attr('checked', true);
            			TipoColaborador();
            			
            			$('#UnidadeExterna').val(data.UnidadeExterna);
            			$('#FormacaoAcademica').val(data.FormacaoAcademica);
            			            			
            		}
            			
                   if(data.FlagResumo == 1)
                   {
                	   $('#FlagResumo1').attr('checked', true);
           			   $('#FlagResumo0').attr('checked', false);
                   }
                   else {
                       
                	   $('#FlagResumo1').attr('checked', false);
           			   $('#FlagResumo0').attr('checked', true);
                   }
            		
            		$('#bt_alterar').show();
            		$('#bt_cancelar').show();
            	} else {
            		mostrarMensagemTopo('erro', data.mensagem);
            	}
            }
        );

    }
}

function inicializar() {
	/*
	selecionar_estado('', '', '13', 'true');
	selecionar_pais('31', '13', 'true');
	*/
	if (id_usuario > 0){
		retornar(0, id_usuario);
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
	
	this.location = "#PAG_TOPO";
}

function TipoColaborador(Tipo) {
	
	var FlagColaborador = getValueRadio("FlagColaborador");
	if (FlagColaborador == 1) {
		show('DivColaboradorBio');
		hide('DivColaboradorExterno');
	} else {
		hide('DivColaboradorBio');
		show('DivColaboradorExterno');
	}

}

function exibeInputResponsavel(valor){

	//document.getElementById("divTotal").style.display = '';
	 if(valor == 1){
		// document.getElementById("divTotal").innerHTML = "<br/><br/><label class='form_label' for='total'>Nome (Chefia imediata):</label><span class='label_obrigatorio'>*</span><br/><input type='text' id='chefiaImediata' name='chefiaImediata' maxlength='100' class='form_input' style='width:170px;'/>";
			document.getElementById('DivchefiaImediata').style.display = '';
			document.getElementById('DivgerenteDep').style.display = 'none';
			document.getElementById('DivviceDir').style.display = 'none';
	 }
	 if(valor == 2){
		 //document.getElementById("divTotal").innerHTML = "<br/><br/><label class='form_label' for='total'>Nome (Gerente de departamento):</label><span class='label_obrigatorio'>*</span><br/><input type='text' id='gerenteDep' name='gerenteDep' maxlength='100' class='form_input' style='width:170px;'/>";
		 document.getElementById('DivchefiaImediata').style.display = 'none';
			document.getElementById('DivgerenteDep').style.display = '';
			document.getElementById('DivviceDir').style.display = 'none'; 
	 }
	 if(valor == 3){
		 //document.getElementById("divTotal").innerHTML = "<br/><br/><label class='form_label' for='total'>Nome (Vice- Diretoria):</label><span class='label_obrigatorio'>*</span><br/><input type='text' id='viceDir' name='viceDir' maxlength='100' class='form_input' style='width:170px;'/>";
		 document.getElementById('DivchefiaImediata').style.display = 'none';
		document.getElementById('DivgerenteDep').style.display = 'none';
		document.getElementById('DivviceDir').style.display = '';  
	 }
	 if(valor == '' || valor == 0){
		 //document.getElementById('divTotal').style.display = 'none';
		 document.getElementById('DivchefiaImediata').style.display = 'none';
			document.getElementById('DivgerenteDep').style.display = 'none';
			document.getElementById('DivviceDir').style.display = 'none';
	 }
}

</script>