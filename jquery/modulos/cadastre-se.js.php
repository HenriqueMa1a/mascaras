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
        success:       showResponse  // post-submit callback 
 
        // other available options: 
        //url:       url         // override for form's 'action' attribute 
        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        //clearForm: true        // clear all form fields after successful submit 
        //resetForm: true        // reset the form after successful submit 
 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    }; 

    $("#formCadastro").ajaxForm(optionsForm);
	/*
    // bind to the form's submit event 
    $('#formCadastro').submit(function() { 
        // inside event callbacks 'this' is the DOM element so we first 
        // wrap it in a jQuery object and then invoke ajaxSubmit 
        $(this).ajaxSubmit(optionsForm); 
 
        // !!! Important !!! 
        // always return false to prevent standard browser submit and page navigation 
        return false; 
    });     // */
    /* 
	function limparForm() {

		$("#formCadastro").clearForm();

	} // */
	
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
    // formData is an array; here we use $.param to convert it to a string to display it 
    // but the form plugin does this for you automatically when it submits the data 
    var queryString = $.param(formData); 
 
    // jqForm is a jQuery object encapsulating the form element.  To access the 
    // DOM element for the form do this: 
    // var formElement = jqForm[0]; 
 
    //alert('About to submit: \n\n' + queryString); 
 
    // here we could return false to prevent the form from being submitted; 
    // returning anything other than false will allow the form submit to continue 
    return true; 
} 
 
// post-submit callback 
function showResponse(data)  { 
    
	//alert(data); 
    hideLoading();

	if (data.sucesso) {
		mostrarMensagem('sucesso', data.mensagem);
		preparaForm('desabilita');
		
		exibir_objeto('bt_enviar', 'none');
		exibir_objeto('barra_usuario', '');
	} else {                
		mostrarMensagem('erro', data.mensagem);
	} 

} 

function validaForm(formData, jqForm, options) { 
    // formData is an array of objects representing the name and value of each field 
    // that will be sent to the server;  it takes the following form: 
    // 
    // [ 
    //     { name:  username, value: valueOfUsernameInput }, 
    //     { name:  password, value: valueOfPasswordInput } 
    // ] 
    // 
    // To validate, we can examine the contents of this array to see if the 
    // username and password fields have values.  If either value evaluates 
    // to false then we return false from this method. 
 
 
	var objTipo  = document.getElementById('IdTipoUsuario');
	var objNome  = document.getElementById('Nome');
	var objEmail  = document.getElementById('Email');
	//var objCidade  = document.getElementById('Cidade');
	var objEstado  = document.getElementById('IdEstado');
	//var objPais  = document.getElementById('IdPais');
	var objSenha = document.getElementById('Senha');
	var objConfirmacaoSenha = document.getElementById('ConfirmacaoSenha');
	
	var palavras = 0;
	var temp = objNome.value.split(' ');
	
	for(i=0;i<temp.length;i++)
		if (temp[i]) palavras++;
	
	//alert('palavras='+palavras);
	
 	ocultarMensagem();
 
	if ((objTipo.value == '') || (objTipo.value == '0')) {
		mostrarMensagem('erro', 'O Campo <b>Nome</b> é de preenchimento obrigatório.');
		return false; 
	} else if ((objNome.value == '') || (objNome.value == '0')) {
		mostrarMensagem('erro', 'O Campo <b>Nome</b> é de preenchimento obrigatório.');
		return false; 
	} else if (palavras< '2') {
		mostrarMensagem('erro', 'O Campo <b>Nome</b> tem que ter no mínimo um sobrenome.');
		return false; 
	} else if ((objEmail.value == '') || (objEmail.value == '0')) {
		mostrarMensagem('erro', 'O Campo <b>Email</b> é de preenchimento obrigatório.');
		return false; 
	//} else if ((objCidade.value == '') || (objCidade.value == '0')) {
	//	mostrarMensagem('erro', 'O Campo <b>Cidade</b> é de preenchimento obrigatório.');
	//	return false; 
	} else if ((objEstado.value == '') || (objEstado.value == '0')) {
		mostrarMensagem('erro', 'O Campo <b>Estado</b> é de preenchimento obrigatório.');
		return false; 
	//} else if ((objPais.value == '') || (objPais.value == '0')) {
	//	mostrarMensagem('erro', 'O Campo <b>Pais</b> é de preenchimento obrigatório.');
	//	return false; 
	} else if ((objSenha.value == '') || (objSenha.value == '0')) {
		mostrarMensagem('erro', 'O Campo <b>Senha</b> é de preenchimento obrigatório.');
		return false; 
	} else if ((objSenha.value.length < 5) || (objSenha.value.length > 10)) {
		mostrarMensagem('erro', 'O Campo <b>Senha</b> tem que ter no mínimo de 5 e no máximo de 10 caractereso.');
		return false; 
	} else if ((objConfirmacaoSenha.value == '') || (objConfirmacaoSenha.value == '0')) {
		mostrarMensagem('erro', 'O Campo <b>Confirmção da senha</b> é de preenchimento obrigatório.');
		return false; 
	} else if ((objSenha.value != objConfirmacaoSenha.value)) {
		mostrarMensagem('erro', 'O Campo <b>Confirmação de Senha</b> está diferente do campo <b>Senha</b>.');
		return false; 
    } 	
	
    showLoading(); 
}

function preparaForm(acao) {

	var objTipo  = document.getElementById('IdTipoUsuario');
	var objNome  = document.getElementById('Nome');
	var objEmail  = document.getElementById('Email');
	//var objCidade  = document.getElementById('Cidade');
	var objEstado  = document.getElementById('IdEstado');
	//var objPais  = document.getElementById('IdPais');
	var objSenha = document.getElementById('Senha');
	var objConfirmacaoSenha = document.getElementById('ConfirmacaoSenha');
	var objNovidade = document.getElementById('Novidade');

    var obj = MM_findObj("acao");
    if (obj){
        obj.value = acao;
    } else {
        alert("O campo 'acao' não encontrado.");
    }

	if (acao == 'desabilita'){
		if (objTipo){
			objTipo.disabled=true;
			objTipo.style.backgroundColor="#DDDDDD";
		}
		if (objNome){
			objNome.disabled=true;
			objNome.style.backgroundColor="#DDDDDD";
		}
		if (objEmail){
			objEmail.disabled=true;
			objEmail.style.backgroundColor="#DDDDDD";
		}
		//if (objCidade){
		//	objCidade.disabled=true;
		//	objCidade.style.backgroundColor="#DDDDDD";
		//}
		if (objEstado){
			objEstado.disabled=true;
			objEstado.style.backgroundColor="#DDDDDD";
		}
		//if (objPais){
		//	objPais.disabled=true;
		//	objPais.style.backgroundColor="#DDDDDD";
		//}
		if (objSenha){
			objSenha.disabled=true;
			objSenha.style.backgroundColor="#DDDDDD";
		}
		if (objConfirmacaoSenha){
			objConfirmacaoSenha.disabled=true;
			objConfirmacaoSenha.style.backgroundColor="#DDDDDD";
		}
		if (objNovidade){
			objNovidade.disabled=true;
			objNovidade.style.backgroundColor="#DDDDDD";
		}
	}
}

function enviar() { 

	ocultarMensagem();
    $('#formCadastro').submit();

}

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
/*
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
</script>