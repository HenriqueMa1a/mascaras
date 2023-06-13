<script type="text/javascript">
/**
 * JS de controle de eventos da View
/* JS JQUERY ************************************************************************************************************************************ */
jQuery(document).ready(function()
{
    $('[data-toggle=popover]').popover({placement : 'bottom', trigger : 'hover', delay: {'show': 50, 'hide': 200}}).click(function(e){
        if($(this).is('a') || $(this).is('button') || ($(this).attr('data-type')=='data')) $(this).popover('hide');
    });
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

    $("#DataNascimento").mask("99/99/9999", {placeholder:"__/__/____"});
    $("#DataNascimento").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'dd/mm/yy', minDate: '-90Y', maxDate: '0', showButtonPanel: true, yearRange: '1920:<?php echo date("Y"); ?>'});
    $("#RGData").mask("99/99/9999", {placeholder:"__/__/____"});    
    $("#RGData").datepicker(        {dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true, minDate: '-90Y', maxDate: '0', showButtonPanel: true, yearRange: '1920:<?php echo date("Y"); ?>'});
    $("#PassValidade").mask("99/99/9999", {placeholder:"__/__/____"});    
    $("#PassValidade").datepicker(    {dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true, minDate: '-5Y', maxDate: '+10Y', showButtonPanel: true, yearRange: '<?php echo date("Y")-5; ?>:<?php echo date("Y")+10; ?>'});
    $("#CRData").mask("99/99/9999", {placeholder:"__/__/____"});    
    $("#CRData").datepicker(        {dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true, minDate: '-90Y', maxDate: '0',  showButtonPanel: true, yearRange: '1920:<?php echo date("Y"); ?>'});

    $("#CPF").mask("999.999.999-99",{placeholder:"___.___.___-__"});
    $("#CEP1").mask("99999-999",{placeholder:"_____-___"});
    $("#CEP2").mask("99999-999",{placeholder:"_____-___"});
    $("#BancoNumero").mask("999",{placeholder:"___"});
        
    /* JQUERY.FORM ****************************************************************************************************************************** */
    $("#formCadastro").ajaxForm({type: 'POST', dataType: 'json', url: 'interacao.php', beforeSubmit:  validaForm, success: showResponse});

    inicializar();
    
});

/* JS NORMAIS ************************************************************************************************************************************ */

function validaForm(formData, jqForm, options)
{ 

    var Nome = $('#Nome').val();
    var palavras = 0;
    var temp = Nome.split(' ');
    for(i=0;i<temp.length;i++)
        if (temp[i]) palavras++;
        
     myApp.hideAlert();
 
    if ((Nome == '') || (Nome == '0')) {
        myApp.showAlert('erro', 'O Campo <b>Nome</b> é de preenchimento obrigatório.');
        return false; 
    } else if (palavras< '2') {
        myApp.showAlert('erro', 'O Campo <b>Nome</b> tem que ter no mínimo um sobrenome.');
        return false;         
    } else if (($('#Email').val() == '') && ($('#Conta').val() == ''))  {
        myApp.showAlert('erro', 'O Campo <b>Email</b> ou <b>Conta</b> tem que ser preenchido obrigatóriamente.');
        return false; 
    }     
    
    myApp.showPleaseWait();
}

// post-submit callback 
function showResponse(data)
{ 
    myApp.hidePleaseWait();

    if (data.sucesso) {
        myApp.showAlert('sucesso', data.mensagem);
        visualizar();
        myApp.showAlert('sucesso', data.mensagem);
        //exibir_objeto('bt_enviar', 'none');
    } else {
        myApp.showAlert('erro', data.mensagem);
    } 

} 

function preparaForm(acao)
{
    console.log('preparaForm('+acao+');');
    var formCadastro = $("#formCadastro");
    
    if (acao==='limpar'){// LIMPAR todos os Campos
        $('#acao').val(acao);
        
        $("#formCadastro").trigger("reset");
        $('#controle').val('Usuario');
        formCadastro.find(':checked').each(function() { // Desmarcar todas as CHECKED
            $(this).attr('checked', false);
        });

    } else if (acao==='habilitar'){    // HABILITAR todos os Campos
        $('#acao').val(acao);
        formCadastro.find(':disabled').each(function() {
            $(this).removeAttr('disabled');
        });
        
    } else if (acao==='desabilitar'){     // DESABILITAR todos os Campos
        $('#acao').val(acao);
        formCadastro.find(':enabled').each(function() {
            if (($(this).attr('type')!='hidden') && (!$(this).is('option'))){
                $(this).attr("disabled", "disabled");
            }
        });
        // CAMPOS OCULTOS
        $('#controle').removeAttr('disabled');
        $('#acao').removeAttr('disabled');
        $('#Id').removeAttr('disabled');
        $('#IdStatus').removeAttr('disabled');

        // PERMISSÕES DO USUARIO
        $('#bt_voltar').removeAttr('disabled');
        $('#bt_cancelar').removeAttr('disabled');
        $('#bt_senha').removeAttr('disabled');
        
    } else if (acao==='visualizar'){
        $('#acao').val(acao);
        
        // PERMISSÕES DO USUARIO
        $('#bt_cancelar').attr("disabled", "disabled");
        $('#bt_senha').removeAttr('disabled');
        if(oUsuario.Id == $('#Id').val()){
            $('#bt_editar').removeAttr('disabled');
        }
        $('#bt_gravar').attr("disabled", "disabled");
        
    } else if (acao==='editar'){
        preparaForm('habilitar');
        $('#acao').val(acao);
        $('#controle').val('Usuario');

        if ($('#CPF').val()) {
            $('#CPF').attr('readonly', 'readonly');
        } else {
            $('#CPF').removeAttr('readonly');
        }
        
        // PERMISSÕES DO USUARIO
        $('#bt_cancelar').removeAttr('disabled');
        $('#bt_editar').attr("disabled", "disabled");
        if(typeof oModulo.Operacoes.editar!=='undefined'){if(oModulo.Operacoes.editar){$('#bt_gravar').removeAttr('disabled');$('#bt_gravar').show();}}
        
    }
    
}

function abrir_meus_dados()
{
    myApp.hideAlert();
    visualizar();

}

function visualizar()
{
    myApp.showPleaseWait();
    preparaForm('limpar');
    preparaForm('desabilitar');
    
    $.ajax({type: 'GET', dataType: "json", async: false, url: 'interacao.php', data: {controle: 'Usuario', acao: 'retornar', Id: oUsuario.Id},
    success: function(data) {
        if (data.sucesso){
            // Carregar Dados;
            $('#Id').val(data.IdUsuario);
            $('#IdUsuario').val(data.IdUsuario);
            $('#IdTipo').val(data.IdTipo);
            $('#NomeTipo').val(data.NomeTipo);
            $('#IdPerfil').val(data.IdPerfil);
            $('#NomePerfil').val(data.NomePerfil);
            $('#Conta').val(data.Conta);
            $('#CPF').val(data.CPF);
            $('#Email').val(data.Email);
            $('#Nome').val(data.Nome);
            $('#Telefone').val(data.Telefone);
            $('#Celular').val(data.Celular);
            $('#DataCadastro').val(data.DataCadastro);
            $('#DataAcao').val(data.DataAcao);
            $('#NomeUsuarioAcao').val(data.NomeUsuarioAcao);

             preparaForm('visualizar');
             
        } else {
            myApp.showAlert('erro', data.mensagem);
        }
        myApp.hidePleaseWait();
        myApp.goTop();
    }});

}

function sair(){ 
    var url = "controller.php?gm=dashboard&mod=abertura"; 
    $(location).attr('href',url);
}

function alterarSenha(){
    var url = "controller.php?gm=dashboard&mod=cadastro-senha"; 
    $(location).attr('href',url);
}

function cancelar() { 
    myApp.hideAlert();
    visualizar();
}

function editar(){
    myApp.hideAlert();
    preparaForm('editar');
}

function gravar(){
    myApp.hideAlert();
    $('#formCadastro').submit();
}


function conferirCPF(tecla){ 
    if(tecla===13){
        $.getJSON('interacao.php', {controle: 'Usuario', acao: 'conferirCPF', Id: $('#Id').val(), CPF: $('#CPF').val()},
            function(data){
                if (data.sucesso){
                    $('#CPF').addClass('green');
                    $('#CPF').removeClass('red');
                    $('#lblCPFError').html('');
                    $('#lblCPFError').hide();
                    return true;
                } else {
                    $('#CPF').removeClass('green');
                    $('#CPF').addClass('red');
                    $('#lblCPFError').html(data.mensagem);
                    $('#lblCPFError').show();
                    return false;
                }
            }
        );
    }
}

function conferirEmail(tecla)
{ 
    if(tecla===13){
        $.getJSON('interacao.php', {controle: 'Usuario', acao: 'conferirEmail', Id: $('#Id').val(), Email: $('#Email').val()},
            function(data){
                if (data.sucesso){
                    $('#Email').addClass('green');
                    $('#Email').removeClass('red');
                    $('#lblEmailError').html('');
                    $('#lblEmailError').hide();
                    return true;
                } else {
                    $('#Email').removeClass('green');
                    $('#Email').addClass('red');
                    $('#lblEmailError').html(data.mensagem);
                    $('#lblEmailError').show();
                    return false;
                }
            }
        );
    }
}

function inicializar()
{
    popularPais('', 13); 
    abrir_meus_dados();
}
</script>