<script type="text/javascript">
var mod_classe = 'autenticacao';

/* JS JQUERY ************************************************************************************************************************************ */
jQuery(document).ready(function(){ 

	//Para acessar pelo Portal
	var end = window.location.href;
	res = end.split('?'); 
	res = res[1].split('&');
	res = res[1].split('=');
	$('#acessoEmail').val(res[1]+'@bio.fiocruz.br');
	$('#acessoSenha').val('123@senha');
	////////////////


	
    $('[data-toggle=popover]').popover({trigger : 'hover', delay: {'show': 50, 'hide': 200}}).click(function(e){
        if($(this).is('a') || $(this).is('button') || ($(this).attr('data-type')==='data')) $(this).popover('hide');
    });

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
	
    $('#formLogin').validate({
        errorElement: 'div',
        //errorClass: 'help-inline',
        focusInvalid: true, 
        rules: {
            acessoEmail: { 
                required: true, 
                email:true
            },
            acessoSenha: { 
                required: true, 
                minlength: 5
            }
        },
        messages: {
            acessoSenha: {
                required: "Favor informa sua senha.",
                minlength: "Favor informa sua senha com no mínimo 5 caracteres."
            },
            acessoEmail: {
                required: "Favor informa seu email.",
                email: "Favor informa um e-mail valido."
            }
        },
        errorLabelContainer: $("#panel_alert"),
        submitHandler: function (form) {
            myApp.showPleaseWait();
            $.ajax({
                type: 'POST',
                dataType: "json",
                async: false,
                url: 'interacao.php',
                data: $(form).serialize(),
                //data: { field1: "hello", field2 : "hello2"},
                //contentType: 'application/json; charset=utf-8',
                success: function(response) {
                    if (response.sucesso == 1) { 
                        $('#bt_enviar').hide();
                        myApp.showAlert('sucesso', response.mensagem);
                        window.location.href = response.pagina;		
                    } else { 
                        myApp.showAlert('erro', response.mensagem);
                        myApp.hidePleaseWait();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown ) {
                    if(errorThrown === 0){ myApp.showAlert('erro', 'Erro: Not connect.\n Verify Network.');
                    }else if (errorThrown == 404){ myApp.showAlert('erro', 'Erro: Requested page not found. [404]');
                    }else if (errorThrown == 500){ myApp.showAlert('erro', 'Erro: Internal Server Error [500].');
                    }else if (textStatus === 'parsererror'){ myApp.showAlert('erro', 'Erro: Requested JSON parse failed.');
                    }else if (textStatus === 'timeout'){ myApp.showAlert('erro', 'Erro: Time out error.');
                    }else if (textStatus === 'abort'){ myApp.showAlert('erro', 'Erro: Ajax request aborted.');
                    }else {
                        myApp.showAlert('erro', 'Erro('+textStatus+'): ' + errorThrown);
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
</script>