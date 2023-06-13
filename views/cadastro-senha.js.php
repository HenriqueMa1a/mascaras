<script type="text/javascript">

/* JS JQUERY ************************************************************************************************************************************ */
jQuery(document).ready(function(){
	
	$('[data-rel=tooltip]').tooltip();
	var $validation = false;
	
	$(".alert").find(".close").on("click", function (e) {
		e.stopPropagation();
		e.preventDefault();
		$(this).closest(".alert").slideUp(400);
	});
	
	jQuery.validator.setDefaults({
		errorPlacement: function(error, element) {
			error.appendTo(element.prev());
		}
	});
	
	$('#formCadastro').validate({
		errorElement: 'div',
		//errorClass: 'help-inline',
		focusInvalid: true, 
		rules: {
			SenhaAtual: { 
				required: true, 
				minlength: 5
			},
			SenhaNova: { 
				required: true, 
				minlength: 5
			},
			SenhaNova2: { 
				required: true, 
				minlength: 5
			}
		},
		messages: {
			SenhaAtual: {
				required: "Favor informa sua senha Atual.",
				minlength: "Favor informa sua senha Atual com no mínimo 5 caracteres."
			},
			SenhaNova: {
				required: "Favor informa sua Nova senha.",
				minlength: "Favor informa sua Nova senha com no mínimo 5 caracteres."
			},
			SenhaNova2: {
				required: "Favor confirmar sua Nova senha.",
				minlength: "Favor confirmar sua Nova senha com no mínimo 5 caracteres."
			}
		},
		errorLabelContainer: $("#panel_alert"),
		submitHandler: function (form) {
			$('#controle').val('Usuario');
			$('#acao').val('editarSenha');
			myApp.showPleaseWait();
			$.ajax({
				type: 'POST',
				dataType: "json",
				async: false,
				url: 'interacao.php',
				data: $(form).serialize(),
				success: function(response) {
					if (response.sucesso == 1) {
						$('#bt_gravar').attr("disabled", "disabled");
						//$('#bt_gravar').hide();
						myApp.showAlert('sucesso', response.mensagem);
						document.getElementById('formCadastro').reset();
					} else {
						myApp.showAlert('erro', response.mensagem);
					}
					myApp.hidePleaseWait();
				}            
			});
		},
		invalidHandler: function (form) {
			myApp.hidePleaseWait();
			$("#panel_alert").show();
		}
	});
});

/* JS NORMAIS ************************************************************************************************************************************ */

function cancelar() 
{ 
 	var url = "controller.php?mod=abertura"; 
	$(location).attr('href',url);
}

function gravar() 
{ 
    myApp.hideAlert();
    $('#formCadastro').submit();

}

function inicializar()
{
	// 1. Verificar Permissões do usuário
	if(typeof oModulo.Operacoes.incluir !== 'undefined'){
		if(oModulo.Operacoes.incluir){
			$('#bt_gravar').removeAttr('disabled');
			$('#bt_gravar').show();
		}
	}
	
}
</script>