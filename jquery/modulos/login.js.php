<script type="text/javascript">

var mod_classe = '<?php echo $MOD_CLASSE; ?>';

jQuery(document).ready(function(){
	
	/* JQUERY.TABS ******************************************************************************************************************************** */
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
	/* JQUERY.AJAXFORM ****************************************************************************************************************************** */
    var optionsForm = { 
        type: 'POST',
		url: 'modulos/' + mod_classe + '.action.php',
        target:        '#resultado',   // target element(s) to be updated with server response 
        beforeSubmit:  validaForm, // pre-submit callback 
		dataType: 'json',
        success: showResponse  // post-submit callback 
    }; 

    $("#formAcesso").ajaxForm(optionsForm);

	/* JQUERY.DIALOG ****************************************************************************************************************************** */

	$("#dialog:ui-dialog" ).dialog( "destroy" );

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
    
	//alert(data); 
    hideLoading();

	if (data.sucesso) {
		mostrarMensagem('sucesso', data.mensagem);
		
			var URL = 'controller.php?modulo=inscricao&acao=editar';
			window.location.href = URL;
			exibir_objeto('bt_enviar', 'none');
	} else {                
		mostrarMensagem('erro', data.mensagem);
	} 

} 

function validaForm(formData, jqForm, options) { 

	
	var objEmail  = document.getElementById('Email');
	var objSenha = document.getElementById('Senha');

	ocultarMensagem();
 
	if ((objEmail.value == '') || (objEmail.value == '0')) {
		mostrarMensagem('erro', 'O Campo <b>Email</b> é de preenchimento obrigatório.');
		return false; 
	} else if ((objSenha.value.length < 5) || (objSenha.value.length > 20)) {
		mostrarMensagem('erro', 'O Campo <b>Senha</b> tem que ter no mínimo de 5 e no máximo de 20 caractereso.');
		return false; 
    } 	
	showLoading();

		
}

function preparaForm(acao) {

	var objEmail  = document.getElementById('Email');
	var objSenha = document.getElementById('Senha');

    var obj = MM_findObj("acao");
    if (obj){
        obj.value = acao;
    } else {
        alert("O campo 'acao' não encontrado.");
    }

	if (acao == 'desabilita'){
		if (objEmail){
			objEmail.disabled=true;
			objEmail.style.backgroundColor="#DDDDDD";
		}
		if (objSenha){
			objSenha.disabled=true;
			objSenha.style.backgroundColor="#DDDDDD";
		}
	}
}

function enviar() { 

	ocultarMensagem();
    $('#formAcesso').submit();

}

function inicializar() {
	/*
	selecionar_estado('', '', '13', 'true');
	selecionar_pais('31', '13', 'true');
	*/
}

</script>