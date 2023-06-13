<script type="text/javascript" language="JavaScript">
var mod_classe = '<?php echo $MOD_CLASSE; ?>';

jQuery(document).ready(function(){
	
	/* JQUERY.TABS ******************************************************************************************************************************** */
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

	/* JQUERY.AJAXFORM ******************************************************************************************************************************** */
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

	//alert(data); 
    hideLoading();
	
	if (data.sucesso) {
		mostrarMensagem('sucesso', data.mensagem);
	} else {                
		mostrarMensagem('erro', data.mensagem);
	} 
    
} 

function validaForm(formData, jqForm, options) { 

    var objEmail  = document.getElementById('Email');
	
 	ocultarMensagem();

	if ((objEmail.value == '') || (objEmail.value == '0')) {
		mostrarMensagem('erro', 'O Campo <b>Email</b> é de preenchimento obrigatório.');
		return false; 
    } 	
	
    showLoading(); 
}

function preparaForm(acao) {

    var obj = MM_findObj("acao");
    if (obj){
        obj.value = acao;
    } else {
        alert("O campo 'acao' não encontrado.");
    }
	
	document.getElementById('Email').value = "";
	
}

function enviar() { 

	ocultarMensagem();
    $('#formCadastro').submit();

}

</script>