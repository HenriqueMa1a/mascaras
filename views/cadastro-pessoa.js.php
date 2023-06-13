<script type="text/javascript">
/**
 * JS de controle de eventos da View
 * 
 * @package MCC.View.js
 * @category View
 * @version 1.0
 * @since   2020-06-21
 * @version 1.6
 * @author  Kellen Nery
 * 
 * 
 * @edit    2020-05-22<br />
 *          Kellen Nery <kellen.nery@bio.fiocruz.br>
 *          Implementação da Documentação
 */

var oTable;
var aDocs;
var dataDocs;
var tipoDocs;
var sTransacoes='0,99';


//* Passo-a-Passo  *************************************************************************************
    var passoAtual = 1;
    function goToStep(passo){
        console.log("goToStep("+passo+");");
        if (passo > passoAtual) {
            for (i=passoAtual;i<passo;i++){
                $('#step-'+i).removeClass("active");
                $('#step-'+i).removeClass("disabled");
                $('#step-'+i).addClass("complete");
            }
            $('#step-'+passo).removeClass("disabled");
            $('#step-'+passo).addClass("active");
            
        } else if (passo < passoAtual) {
            $('#step-'+passoAtual).removeClass("complete");
            $('#step-'+passoAtual).removeClass("active");
            $('#step-'+passoAtual).addClass("disabled");
            for (i=passoAtual;i>passo;i--){
                console.log("goToStep("+passo+"); i="+i);
                $('#step-'+i).removeClass("complete");
                $('#step-'+i).addClass("disabled");
            }
            $('#step-'+passo).removeClass("complete");
            $('#step-'+passo).addClass("active");
        }
        passoAtual = passo;
    }
//* Passo-a-Passo  *************************************************************************************
    
function dateDiff(tmpInicial, tmpFinal, interval) { 
    /*
     * DateFormat month/day/year hh:mm:ss
     * ex.
     * datediff('01/01/2011 12:00:00','01/01/2011 13:30:00','seconds');
     */
    var second=1000, minute=second*60, hour=minute*60, day=hour*24, week=day*7;
    
    if ((tmpInicial.length == 10) && (tmpFinal.length == 10)){
        var aData = tmpInicial.split("/");
        var dtInicial = new Date(aData[2], (aData[1]-1), aData[0]);

        var aData = tmpFinal.split("/");
        var dtFinal = new Date(aData[2], (aData[1]-1), aData[0]);

        //dtInicial = new Date(dtInicial); 
        //dtFinal = new Date(dtFinal); 
        var timediff = dtFinal - dtInicial; 
        if (isNaN(timediff)) return NaN; 
        switch (interval) { 
            case "years": return dtFinal.getFullYear() - dtInicial.getFullYear(); 
            case "months": return ( 
                ( dtFinal.getFullYear() * 12 + dtFinal.getMonth() ) 
                - 
                ( dtInicial.getFullYear() * 12 + dtInicial.getMonth() ) 
            ); 
            case "weeks"  : return Math.floor(timediff / week); 
            case "days"   : return Math.floor(timediff / day);  
            case "hours"  : return Math.floor(timediff / hour);  
            case "minutes": return Math.floor(timediff / minute); 
            case "seconds": return Math.floor(timediff / second); 
            default: return undefined; 
        } 
    } 
}


function verificarTarifa(){
    var dtInicial = $('#DataInicial').val();
    var dtFinal = $('#DataFinal').val();
    var anos = 0;
    
    if ((dtInicial.length == 10) && (dtFinal.length == 10)){
        //AnosRegistro = dateDiff(dtInicial, dtFinal, 'years');
        //console.log("dateDiff (" + dtInicial + "," + dtFinal + ",' years'); return " + AnosRegistro + ";");
        anos = calcularIdade(dtInicial, dtFinal);
        console.log("calcularIdade(" + dtInicial + ", " + dtFinal + "); return " + anos + ";");
        
        anos = anos + 1;
        var vlTaxa = getValorNumerico($('#ValorTaxa').val());
        var vlAno = getValorNumerico($('#ValorAno').val());
        var vlTarifa = (vlTaxa + (vlAno * anos));
        
        console.log("verificarTarifa(); return " + vlTarifa + ";");
        
        $('#ValorTarifa').val(number_format(vlTarifa, 2, ',', '.'));

    }
}


function  calcularDataFinal()
{
    var IdTransacao = '1';
    var dtInicial = $('#DataInicial').val();
    var dtFinal = '';
    var AnosRegistro = parseFloat($('#AnosRegistro').val());
    console.log('calcularDataFinal (' + dtInicial + ', ' + AnosRegistro + ')');
    
    if ((IdTransacao == '1') || (IdTransacao == '34') || (IdTransacao == '37')){ // Registro e Recadastramento
        if (dtInicial.length == 10){
            var aData = dtInicial.split("/");
            var data = new Date(aData[2], (aData[1]-1), aData[0]);
        
            if (AnosRegistro > 0) {
                data.setFullYear(parseFloat(data.getFullYear()) + parseFloat(AnosRegistro));
                
                if (data.getDate() < 10)
                    dia = '0'+data.getDate();
                else dia = data.getDate();
                mes = parseFloat(data.getMonth())+1;
                if (mes < 10) 
                    mes = '0'+mes;
                else mes = mes;
                
                dtFinal = dia + '/' + mes + '/' + data.getFullYear();
            } else {
                dtFinal = '31/12/'+aData[2];
            }
            console.log('calcularDataFinal (' + dtInicial + ', ' + AnosRegistro + ') return ' + dtFinal);
            $('#DataFinal').val(dtFinal);
            $('#EntDataFinal').val(dtFinal);
        }
    }
}

/* JS JQUERY ************************************************************************************************************************************ */
jQuery(document).ready(function()
{
    $('[data-toggle=popover]').popover({placement : 'bottom', trigger : 'hover', delay: {'show': 50, 'hide': 200}}).click(function(e){
        if($(this).is('a') || $(this).is('button') || ($(this).attr('data-type')=='data')) $(this).popover('hide');
    });
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
    
    $("#filtroDataNascimento").mask("99/99/9999", {placeholder:"__/__/____"});
    $("#filtroDataNascimento").datepicker({dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true, minDate: '-90Y', maxDate: '0', showButtonPanel: true, yearRange: '1920:<?php echo date("Y"); ?>'});
    $("#DataNascimento").mask("99/99/9999", {placeholder:"__/__/____"});
    $("#DataNascimento").datepicker({dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true, minDate: '-90Y', maxDate: '0', showButtonPanel: true, yearRange: '1920:<?php echo date("Y"); ?>'});
    $("#RGData").mask("99/99/9999", {placeholder:"__/__/____"});    
    $("#RGData").datepicker(        {dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true, minDate: '-90Y', maxDate: '0', showButtonPanel: true, yearRange: '1920:<?php echo date("Y"); ?>'});
    $("#PassValidade").mask("99/99/9999", {placeholder:"__/__/____"});    
    $("#PassValidade").datepicker(    {dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true, minDate: '-5Y', maxDate: '+10Y', showButtonPanel: true, yearRange: '<?php echo date("Y")-5; ?>:<?php echo date("Y")+10; ?>'});
    $("#CRData").mask("99/99/9999", {placeholder:"__/__/____"});    
    $("#CRData").datepicker(        {dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true, minDate: '-90Y', maxDate: '0',  showButtonPanel: true, yearRange: '1920:<?php echo date("Y"); ?>'});
    
    $("#filtroCPF").mask("999.999.999-99",{placeholder:"___.___.___-__"});
    $("#filtroMatricula").mask("000000",{placeholder:"______"});
    $("#CPF").mask("999.999.999-99",{placeholder:"___.___.___-__"});
    $("#CEP1").mask("99999-999",{placeholder:"_____-___"});
    $("#CEP2").mask("99999-999",{placeholder:"_____-___"});
    $("#BancoNumero").mask("999",{placeholder:"___"});
    
    
    $("#DataInicial").mask("99/99/9999", {placeholder:"__/__/____"});
    $("#DataInicial").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'dd/mm/yy', minDate: '-1M', maxDate: '+5Y', showButtonPanel: true, yearRange: '<?php echo (date("Y")-1).':'.(date("Y")+5); ?>'});
    $("#DataFinal").mask("99/99/9999", {placeholder:"__/__/____"});
    $("#DataFinal").datepicker(     { changeMonth: true, changeYear: true, dateFormat: 'dd/mm/yy', minDate: '0', maxDate: '+5Y', showButtonPanel: true, yearRange: '<?php echo date("Y").':'.(date("Y")+5); ?>'});
    $("#DataCurso").mask("99/99/9999", {placeholder:"__/__/____"});
    $("#DataCurso").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'dd/mm/yy', minDate: '-60Y', maxDate: '0', showButtonPanel: true, yearRange: '1950:<?php echo date("Y"); ?>'});

    $("#Peso").mask("099",{placeholder:""});
    $("#Altura").mask("099",{placeholder:""});
    //$("#Calcado").mask("99",{placeholder:""});
    
    $("#Peso3").mask("099",{placeholder:""});
    $("#Altura3").mask("099",{placeholder:""});
    //$("#Calcado3").mask("99",{placeholder:""});
    
    /* JQUERY.FORM ****************************************************************************************************************************** */
    $("#formCadastro").ajaxForm({type: 'POST', dataType: 'json', url: 'interacao.php', beforeSubmit:  validaForm, success: showResponse});
    $("#formDocumento").ajaxForm({type: 'POST', dataType: 'json', url: 'interacao.php', beforeSubmit: validaFormDoc, success: showResponseDoc});
    $("#formRegistro").ajaxForm({type: 'POST', dataType: 'json', url: 'interacao.php', beforeSubmit: validaFormReg, success: showResponseReg});
    
     $('#dialogPadrao').on('hidden.bs.modal', function (e) {
        console.log('#dialogPadrao->hidden');
        $("#dialogControle").val('');
        $("#dialogAcao").val('');
        $("#dialogId").val('');
        $("#dialogObservacao").val('');
    });
    
    /* JQUERY.FORM ****************************************************************************************************************************** */
    $("#dialogButtonConfirmar").click(function(){
        myApp.hideMensagem('#boxDialogMensagem');
        var acao = $('#dialogAcao').val();
        console.log('#dialogButtonConfirmar->'+acao);
        
        myApp.hideAlert();
        $('#acao1').val(acao);
        if (acao=='aprovar'){
            
        } else if (acao=='reprovar'){
            $('#Observacao1').val($('#dialogObservacao').val());
        }
        if ($('#boxDialogObservacao').is(":visible")){
            if ($('#dialogObservacao').val() == ''){
                myApp.showMensagem('#boxDialogMensagem', 'erro', 'O Campo <b>Observação</b> é de preenchimento obrigatório.');
                return false;
            }
        }
        $("#dialogPadrao").modal('hide');
        $('#formTransacao').submit();
            
    });
    
    inicializar();
});

/* JS NORMAIS ************************************************************************************************************************************ */
function carregarLista(tecla)
{    
    if (tecla == 13) {
        
        // Validar Filtros
        if ($("#filtroCPF").val()){
            if (! validarCPF($("#filtroCPF").val())){
                myApp.showAlert('erro', "O campo <b>CPF</b> está com valor inválido. (Formato: 999.999.999-99)");
                return false;
            }
        }
        if ($("#filtroDataNascimento").val()){
            if (! validarData($("#filtroDataNascimento").val())){
                myApp.showAlert('erro', "O campo <b>Data de Nascimento</b> está com valor inválido. (Formato: dd/mm/yyyy)");
                return false;
            }
        }
        
        var urlAjax = "interacao.php?controle=Pessoa&acao=listar";
        urlAjax += "&IdEmpresa=" + $("#filtroIdEmpresa :selected").val();
        urlAjax += "&IdContrato=" + $("#filtroIdContrato :selected").val();
        urlAjax += "&IdStatus=" + $("#filtroIdStatus :selected").val();
        urlAjax += "&Id=" + $("#filtroIdPessoa").val();
        urlAjax += "&Nome=" + $("#filtroNome").val();
        urlAjax += "&DataNascimento=" + $("#filtroDataNascimento").val();
        urlAjax += "&CPF=" + $("#filtroCPF").val();
        urlAjax += "&Matricula=" + $("#filtroMatricula").val();
        //urlAjax += "&Ativo=" + $("#filtroAtivo").val();

        myApp.showPleaseWait();
        if (typeof oTable==='undefined') {    
            oTable = $('#tabListagem').dataTable({
                "oLanguage": {"sUrl": "assets/js/jquery.dataTables.pt-br.txt"},
                "aoColumnDefs": [
                    {"aTargets": [0], "bSearchable": false, "bVisible": true, "bSortable" : false, "sWidth": "5%", "sClass": "text-center"},
                    {"aTargets": [1], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "10%", "sClass": "text-right"},
                    {"aTargets": [2], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "18%"},
                    {"aTargets": [3], "bSearchable": true,  "bVisible": true, "bSortable" : true},
                    {"aTargets": [4], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "12%"},
                    {"aTargets": [5], "bSearchable": false, "bVisible": true, "bSortable" : true, "sWidth": "12%"},
                    {"aTargets": [6], "bSearchable": false, "bVisible": true, "bSortable" : true, "sWidth": "14%"},
                    {"aTargets": [7], "bSearchable": false, "bVisible": true, "bSortable" : true, "sWidth": "4%", "sClass": "text-center"}
                ],
                "aaSorting": [[ 6, "desc"]],
                "bDestroy": true,            
                "sAjaxSource": urlAjax,
                "bProcessing": true,
                "bServerSide": false,
                "bPaginate": true,
                "bFilter": false,
                "bInfo": true,
                "bSort" : true,
                //"sDom": 'lfrtip',
                //"sDom": 'T<"clear">lfrtip',
                "iDisplayLength": 10
            });
            
            $('#tabListagem').on('draw.dt', function () {
                myApp.hidePleaseWait();
            });        
            
        } else {
            oTable.fnClearTable(0);
            var oSettings = oTable.fnSettings();
            oSettings.sAjaxSource = urlAjax;
            oTable.fnReloadAjax();
        } 
        //myApp.hidePleaseWait();
    }
} 

function showRequest(formData, jqForm, options)
{
    var queryString = $.param(formData); 
    return true; 
} 

function showResponse(data) 
{ 
    if (data.sucesso) {
        myApp.showAlert('sucesso', data.mensagem);
        if (data.acao=='excluir'){
            
        } else {
            //visualizar(data.Id);
        }
        preparaForm('listar');
        carregarLista(13);
    } else {                
        myApp.showAlert('erro', data.mensagem);
    } 
    myApp.hidePleaseWait();
} 

function validaForm(formData, jqForm, options)
{ 
     myApp.hideAlert();
    
    if ($("#acao").val() == 'excluir') {
        if (!($("#Id").val() > 0)){
            myApp.showAlert('erro', 'Selecione primeiro um registro para poder excluir.');
            return false; 
        } else if (($("#IdStatus").val() != '1') && (oUsuario.IdTipo != 1) ){
            myApp.showAlert('erro', 'O status do cadastro tem que esta como <b>Pendente</b> para poder ser excluído.');
            return false; 
        }
        
    } else if ($("#acao").val() == 'aprovar') {
        if (!($("#Id").val() > 0)){
            myApp.showAlert('erro', 'Selecione primeiro um registro para poder excluir.');
            return false; 
        } else if (($("#IdStatus").val() != '1')){
            myApp.showAlert('erro', 'O status do cadastro tem que esta como <b>Pendente</b> para poder aprovar o cadastro.');
            return false; 
        }
        
    } else { // acao = incluir e atualizar
        if (($("#IdEmpresa").val() == '')){
            myApp.showAlert('erro', 'O Campo <b>Empresa</b> é de preenchimento obrigatório .');
            return false;
        }
        
        if (($("#Nome").val() == '') || ($("#Nome").val() == '0')){
            myApp.showAlert('erro', 'O Campo <b>Nome</b> é de preenchimento obrigatório.');
            $('#myTabs a[href="#tabPessoal"]').tab('show');
            return false; 
        } else if (($("#Sexo").val() == '')){
            myApp.showAlert('erro', 'O Campo <b>Sexo</b> é de preenchimento obrigatório.');
            $('#myTabs a[href="#tabPessoal"]').tab('show');
            return false; 
        } else if (($("#DataNascimento").val() == '')){
            myApp.showAlert('erro', 'O Campo <b>Data de Nascimento</b> é de preenchimento obrigatório.');
            $('#myTabs a[href="#tabPessoal"]').tab('show');
            return false; 
        } else if (($("#IdNacionalidade").val() == '') || ($("#IdNacionalidade").val() == '0')){
            myApp.showAlert('erro', 'O Campo <b>Nacionalidade</b> é de preenchimento obrigatório.');
            $('#myTabs a[href="#tabDoc"]').tab('show');
            return false; 
        } else if (($("#UFNaturalidade").val() == '') || ($("#UFNaturalidade").val() == '0')){
            myApp.showAlert('erro', 'O Campo <b>Naturalidade (UF)</b> é de preenchimento obrigatório.');
            $('#myTabs a[href="#tabDoc"]').tab('show');
            return false; 
        } else if (($("#Naturalidade").val() == '') || ($("#Naturalidade").val() == '0')){
            myApp.showAlert('erro', 'O Campo <b>Naturalidade (Cidade)</b> é de preenchimento obrigatório.');
            $('#myTabs a[href="#tabDoc"]').tab('show');
            return false; 
        } else if (($("#Mae").val() == '') || ($("#Mae").val() == '0')){
            myApp.showAlert('erro', 'O Campo <b>Nome da Mãe</b> é de preenchimento obrigatório.');
            $('#myTabs a[href="#tabPessoal"]').tab('show');
            return false; 
        }
        if ($("#IdNacionalidade").val() == '76'){
            if (($("#CPF").val() == '')){
                myApp.showAlert('erro', 'O Campo <b>CPF</b> é de preenchimento obrigatório para brasileiros .');
                return false;
            }
            if (($("#RGNumero").val() == '')){
                myApp.showAlert('erro', 'O Campo <b>Número do RG</b> é de preenchimento obrigatório para brasileiros .');
                $('#myTabs a[href="#tabDoc"]').tab('show');
                return false;
            }
            if (($("#RGOrgao").val() == '')){
                myApp.showAlert('erro', 'O Campo <b>Orgão do RG</b> é de preenchimento obrigatório para brasileiros .');
                $('#myTabs a[href="#tabDoc"]').tab('show');
                return false;
            }
            
        } else {
            if (($("#PassNumero").val() == '')){
                myApp.showAlert('erro', 'O Campo <b>Passaporte</b> é de preenchimento obrigatório para estrangeiros.');
                $('#myTabs a[href="#tabDoc"]').tab('show');
                return false;
            } 
        }
        
        // Endereço
        if (($("#IdPais1").val() == '') || ($("#IdPais1").val() == '0')){
            myApp.showAlert('erro', 'O Campo <b>Pais</b> do endereço residencial é de preenchimento obrigatório.');
            $('#myTabs a[href="#tabEndRes"]').tab('show');
            return false; 
        } else if ($("#IdPais1").val() == '76'){
            if (($("#Logradouro1").val() == '')){
                myApp.showAlert('erro', 'O Campo <b>Logradouro</b> do endereço residencial é de preenchimento obrigatório.');
                $('#myTabs a[href="#tabEndRes"]').tab('show');
                return false;
            } else if (($("#Numero1").val() == '')){
                myApp.showAlert('erro', 'O Campo <b>Numero</b> do endereço residencial é de preenchimento obrigatório.');
                $('#myTabs a[href="#tabEndRes"]').tab('show');
                return false;
            } else if (($("#Bairro1").val() == '')){
                myApp.showAlert('erro', 'O Campo <b>Bairro</b> do endereço residencial é de preenchimento obrigatório.');
                $('#myTabs a[href="#tabEndRes"]').tab('show');
                return false;
            } else if (($("#CEP1").val() == '')){
                myApp.showAlert('erro', 'O Campo <b>CEP</b> do endereço residencial é de preenchimento obrigatório.');
                $('#myTabs a[href="#tabEndRes"]').tab('show');
                return false;
            } else if (($("#Cidede1").val() == '')){
                myApp.showAlert('erro', 'O Campo <b>Cidede</b> do endereço residencial é de preenchimento obrigatório.');
                $('#myTabs a[href="#tabEndRes"]').tab('show');
                return false;
            } else if (($("#UF1").val() == '') || ($("#UF1").val() == '0')){
                $('#myTabs a[href="#tabEndRes"]').tab('show');
                myApp.showAlert('erro', 'O Campo <b>Estado</b> do endereço residencial é de preenchimento obrigatório.');
                return false; 
            }
        } 
        
    }
    myApp.showPleaseWait(); 
}

function preparaForm(acao)
{
    console.log("preparaForm('"+ acao +"'); [Id="+ $('#Id').val() +"; IdFed="+ $('#IdFed').val() +"; IdEmpresa="+ $('#IdEmpresa').val() +"; IdStatus="+ $('#IdStatus').val() +"]");
    
    var formCadastro = $("#formCadastro");
    
    if (acao == 'limpar'){                // LIMPAR todos os Campos
        document.getElementById('formCadastro').reset();
        formCadastro.find(':checked').each(function() { // Desmarcar todas as CHECKED
            $(this).attr('checked', false);
        });
        $('#Matricula').val('0');
        $('#bt_gravar').attr("disabled", "disabled");
        $('#bt_aprovar').attr("disabled", "disabled");
        $('#bt_aprovar').hide();
        $('#bt_add_documento').attr("disabled", "disabled");
        $('#bt_add_registro').attr("disabled", "disabled");
        
        $("#arqFotografia").attr("src", '_files/pessoas/pes-000000000000.jpg?ts='+ new Date().getTime());
        $("#arqFotografia").hide();
        
        setItemCombo('IdEmpresa', 0);
        clearCombo('IdContrato');
        setItemCombo('TipoSanguineo', '');
        
        aDocs = new Array();
        dataDocs = new Array();
        
        $('#myTabs a[href="#tabPessoal"]').tab('show');
        
        // Exibir Passo-a-Passo        
        $("#boxSteps").hide();
        goToStep(1);
        
        // Criticas
        $('#box-Responsavel').hide();
        $('#CPF').removeClass('green');
        $('#CPF').removeClass('red');
        $('#lblCPFError').html('');
        $('#lblCPFError').hide();
        $('#Email').removeClass('green');
        $('#Email').removeClass('red');
        $('#lblEmailError').html('');
        $('#lblEmailError').hide();
        
        myApp.hideMensagem('#boxCritica');
        myApp.hideMensagem('#boxCriticaDoc');
        
        myApp.hideMensagem('#boxMensagemDoc');
        limparTabela('tabListagemDocumento');
        
        myApp.hideMensagem('#boxMensagemReg');
        limparTabela('tabListagemRegistro');
        
    } else if (acao == 'habilitar'){    // HABILITAR todos os Campos
        formCadastro.find(':disabled').each(function() {
            $(this).removeAttr('disabled');
        });
    
    } else if (acao == 'desabilitar'){     // DESABILITAR todos os Campos
        formCadastro.find(':enabled').each(function() {
            $(this).attr('disabled', 'disabled');
        });
        // Campos Ocultos
        $('#controle').removeAttr('disabled');
        $('#acao').removeAttr('disabled');
        $('#Id').removeAttr('disabled');
        $('#IdStatus').removeAttr('disabled');
        $('#IdFed').removeAttr('disabled');
        // PERMISSÕES DO USUARIO
        $('#bt_cancelar').removeAttr('disabled');
        
    } else if (acao == 'listar'){
        preparaForm('limpar');
        $("#acao").val(acao);
        $("#boxToolbar").show();
        $("#boxFormulario").hide();
        $("#boxListagem").show();

    } else if (acao == 'incluir'){
        preparaForm('limpar');
        $("#acao").val(acao);
        $("#boxToolbar").hide();
        $("#boxFormulario").show();
        $("#boxListagem").hide();
        
        // Inicializar Campos
        $('#controle').val('Pessoa');
        $('#Id').val('0');
        $('#Ativo').val(1);
        $('#IdEndereco1').val(0);
        $('#IdEndereco2').val(0);
        
        $('#DataNascimento').removeAttr("readonly"); 
        $('#Sexo').removeAttr("readonly"); 
        $('#Mae').removeAttr("readonly"); 
        $('#Pai').removeAttr("readonly"); 
        $('#CPF').removeAttr("readonly"); 
        
        // Nacionalidade ?
        $('#IdNacionalidade').show(); 
        $('#NomeNacionalidade').hide();
        $('#UFNaturalidade').show();
        $('#NomeNaturalidade').hide();
        
        $("#arqFotografia").attr("src", '_files/pessoas/pes-000000000000.jpg?ts='+ new Date().getTime());
        $("#arqFotografia").show();

        // Exibir Passo-a-Passo
        $("#boxSteps").show();
        goToStep(1);
        
        // PERMISSÕES DO USUARIO
        preparaForm('habilitar');
        $('#bt_editar').attr("disabled", "disabled");
        $('#bt_excluir').attr("disabled", "disabled");
        if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_gravar').removeAttr('disabled');}}
        
    } else if (acao == 'editar'){
        $("#acao").val(acao);
        preparaForm('habilitar');
        
       
        // Nacionalidade ?
        if ($('#IdNacionalidade').val()) {
            $('#NomeNacionalidade').show();
            $('#IdNacionalidade').hide(); 
        } else {
            $('#NomeNacionalidade').hide();
            $('#IdNacionalidade').show(); 
        }
        $('#NomeNaturalidade').hide();
        $('#UFNaturalidade').show();

        // PERMISSÕES DO USUARIO
        $('#bt_editar').attr("disabled", "disabled");
        $('#bt_excluir').attr("disabled", "disabled");
        if(typeof oModulo.Operacoes.editar!=='undefined'){
            if(oModulo.Operacoes.editar){
                $('#bt_gravar').removeAttr('disabled');
                $('#bt_add_documento').removeAttr('disabled');
            }
        }
    
    } else if (acao == 'visualizar'){
        $('#controle').val('Pessoa');
        $("#acao").val(acao);
        $("#boxToolbar").hide();
        $("#boxFormulario").show();
        $("#boxListagem").hide();

        $('#NomeEmpresa').show();
        $('#IdEmpresa').hide(); 
        $('#NomeContrato').show();
        $('#IdContrato').hide(); 
        $('#NomeNacionalidade').show();
        $('#IdNacionalidade').hide(); 
        $('#NomeNaturalidade').show();
        $('#UFNaturalidade').hide();
        
        // PERMISSÕES DO USUARIO
        if (($('#IdStatus').val() == '1') || ($('#IdStatus').val() == '10')){
            if(typeof oModulo.Operacoes.editar!=='undefined'){
                if(oModulo.Operacoes.editar){
                    if (oUsuario.IdTipo==1) { // 1:Matriz
                        $('#bt_editar').removeAttr('disabled');
                    } else if (oUsuario.IdTipo==3) { // 2:Federaçoes/Associações
                        //if ($('#IdFed').val() == oUsuario.IdEmpresa){
                        $('#bt_editar').removeAttr('disabled');
                        //}
                    } else if (oUsuario.IdTipo==4) { // 3:Contratos (Clubes,...)
                        $('#bt_editar').removeAttr('disabled');
                    }
                }
            }
        } else $('#bt_editar').attr("disabled", "disabled");
        if ($('#IdStatus').val() == '1'){
            if(typeof oModulo.Operacoes.excluir!=='undefined'){if(oModulo.Operacoes.excluir){$('#bt_excluir').removeAttr('disabled');}}
            if(typeof oModulo.Operacoes.aprovar!=='undefined'){
                if(oModulo.Operacoes.aprovar){
                    $('#bt_aprovar').show();
                    $('#bt_aprovar').removeAttr('disabled');
                }
            }
        } else {
            if (oUsuario.IdTipo==1) { // 1:Matriz
                if(typeof oModulo.Operacoes.excluir!=='undefined'){if(oModulo.Operacoes.excluir){$('#bt_excluir').removeAttr('disabled');}}
            }
            $('#bt_aprovar').attr("disabled", "disabled");
            $('#bt_aprovar').hide();
        }
        $('#bt_gravar').attr("disabled", "disabled");
        
        // Exibir Passo-a-Passo
        $("#boxSteps").show();
        goToStep(2);
        
        // PERMISSÕES DO USUARIO
        if ((typeof oModulo.Operacoes.incluir!=='undefined') || (typeof oModulo.Operacoes.editar!=='undefined')){
            if((oModulo.Operacoes.incluir)||(oModulo.Operacoes.editar)){
                $('#bt_add_documento').removeAttr('disabled');
                //if ($('#IdStatus').val() == '10'){
                    //if (oUsuario.Id == '1'){
                        $('#bt_add_registro').removeAttr('disabled');
                    //}
                //}
            }
        }
        
        
    } else if (acao == 'excluir'){
        $('#controle').val('Pessoa');
        $("#acao").val(acao);
        $('#controle').removeAttr('disabled');
        $('#acao').removeAttr('disabled');
        $('#Id').removeAttr('disabled');
        
    } else if (acao == 'aprovar'){
        $("#acao").val(acao);
        $('#controle').removeAttr('disabled');
        $('#acao').removeAttr('disabled');
        $('#Id').removeAttr('disabled');
        
    } else if (acao == 'limpar-documento'){
        $('#controle2').val('Documento');
        $('#acao2').val('');
        $('#Id2').val($('#Id').val());
        $('#IdPessoa2').val($('#Id').val());
        setItemCombo('IdTipoDocumento', 0);
        $('#Arquivo').val('');
        $('#boxToolbarDocumento').show();
        $('#boxFormularioDocumento').hide();
        
    } else if (acao == 'adicionar-documento'){
        $('#controle2').val('Documento');
        $('#acao2').val('incluir');
        $('#boxToolbarDocumento').hide();
        $('#boxFormularioDocumento').show();
        
    } else if (acao == 'editar-documento'){
        $('#controle2').val('Documento');
        $('#acao2').val('editar');
        $('#boxToolbarDocumento').hide();
        $('#boxFormularioDocumento').show();

    } else if (acao == 'excluir-documento'){
        $('#controle2').val('Documento');
        $('#acao2').val('excluir');
        
   } else if (acao == 'limpar-registro'){
        $('#controle3').val('Registro');
        $('#acao3').val('');
        $('#Id3').val('0');
        $('#IdPessoa3').val($('#Id').val());
        setItemCombo('IdProfissao', 0);
        setItemCombo('IdProfissaoNivel', 0);
        
        $('#DataInicial').val('');
        $('#DataFinal').val('');
        setItemCombo('IdSetor', 0);
        setItemCombo('IdContrato', 0);
        
        $('#Responsavel3').val('');
        $('#Observacao3').val('');
        
        $('#boxToolbarRegistro').show();
        $('#boxFormularioRegistro').hide();
        
        
    } else if (acao == 'adicionar-registro'){
        $('#controle3').val('Registro');
        $('#acao3').val('incluir');
        $('#boxToolbarRegistro').hide();
        $('#boxFormularioRegistro').show();
        if (passoAtual<3){
            goToStep(3);
        }
        
        // Campos Personalizados
        if ((oUsuario.IdTipo==1) || (oUsuario.IdTipo==2)){ // 1:Matriz ou 2:COBRAV
            $('#IdEmpresa3').show(); 
            $('#NomeEmpresa3').hide();
            $('#IdContrato').show(); 
            $('#NomeContrato').hide();
            
        } else { 
        
            setItemCombo('IdEmpresa3', oUsuario.IdEmpresa);
            $('#NomeEmpresa3').val($('#IdEmpresa3 :selected').text());
            $('#IdEmpresa3').hide();
            $('#NomeEmpresa3').show();

            carregarComboContrato('IdContrato', oUsuario.IdEmpresa, '', 13);
        
        }
        
    } else if (acao == 'editar-registro'){
        $('#controle3').val('Registro');
        $('#acao3').val('editar');
        $('#boxToolbarRegistro').hide();
        $('#boxFormularioRegistro').show();

        
    }
    

}

function cancelar() 
{ 
    myApp.hideAlert();
    preparaForm('listar');
}

function novo() 
{ 
    myApp.showPleaseWait();
     myApp.hideAlert();
    preparaForm('incluir');
    myApp.hidePleaseWait();
}

function editar() 
{ 
     myApp.hideAlert();
    preparaForm('editar');
}

function visualizar(Id) 
{ 
    myApp.showPleaseWait();
    myApp.hideAlert();
    preparaForm('limpar');
    preparaForm('desabilitar');
    
    $.getJSON('interacao.php', {controle: 'Pessoa', acao: "retornar", Id: Id},
    function(data){ 
        if (data.sucesso){
            // Carregar Dados;
            $('#Id').val(Id);
            $('#IdFed').val(data.IdEmpresa);
            //$('#NomeEmpresa').val($("#Empresa option:selected").text());
            setItemCombo('IdEmpresa', data.IdEmpresa);
            $('#NomeEmpresa').val(data.NomeEmpresa);
            carregarComboContrato('IdContrato', data.IdEmpresa, data.IdContrato, 13);
            //setItemCombo('IdContrato', data.IdContrato);
            
            $('#Matricula').val(data.Matricula);
            $('#NotaOficial').val(data.NotaOficial);
            $('#Nome').val(data.Nome);
            $('#Apelido').val(data.Apelido);
            $('#DataNascimento').val(data.DataNascimento);
            if (data.Idade < 18) {
                $('#box-Responsavel').show();
            } else {
                $('#box-Responsavel').hide();
            }            
            setItemCombo('Sexo', data.Sexo);
            $('#Mae').val(data.Mae);
            $('#Pai').val(data.Pai);
            
            setItemCombo('IdNacionalidade', data.IdNacionalidade);
            $('#NomeNacionalidade').val(data.NomeNacionalidade);

            setNacionalidade(data.IdNacionalidade);
            carregarComboEstado('UFNaturalidade', data.IdNacionalidade, data.UFNaturalidade, 13); 
            $('#NomeNaturalidade').val(data.NomeNaturalidade);
            $('#Naturalidade').val(data.Naturalidade);

            setItemCombo('IdEstadoCivil', data.IdEstadoCivil);
            $('#Conjuge').val(data.Conjuge);
            
            $("#arqFotografia").attr("src", data.arqFotografia+'?ts='+ new Date().getTime());
            $("#arqFotografia").show();
            
            setItemCombo('TipoSanguineo', data.TipoSanguineo);
            $('#Peso').val(data.Peso);
            $('#Altura').val(data.Altura);
            $('#Calcado').val(data.Calcado);
            
            $('#CPF').val(data.CPF);
            $('#PIS').val(data.PIS);
            $('#RGNumero').val(data.RGNumero);
            $('#RGOrgao').val(data.RGOrgao);
            $('#RGData').val(data.RGData);
            $('#PassNumero').val(data.PassNumero);
            $('#PassValidade').val(data.PassValidade);
            $('#CRNumero').val(data.CRNumero);
            $('#CROrgao').val(data.CROrgao);
            $('#CRData').val(data.CRData);
            $('#BancoNumero').val(data.BancoNumero);
            $('#BancoAgencia').val(data.BancoAgencia);
            $('#BancoConta').val(data.BancoConta);
            
            $('#IdEndereco1').val(data.Endereco1.Id);
            if (data.Endereco1.Id) {
                $('#Logradouro1').val(data.Endereco1.Logradouro);
                $('#Numero1').val(data.Endereco1.Numero);
                $('#Complemento1').val(data.Endereco1.Complemento);
                $('#Cidade1').val(data.Endereco1.Cidade);
                $('#Bairro1').val(data.Endereco1.Bairro);
                $('#CEP1').val(data.Endereco1.CEP);
                setItemCombo('IdPais1', data.Endereco1.IdPais);
                carregarComboEstado('UF1', data.Endereco1.IdPais, data.Endereco1.UF, 13); 
            }
            $('#IdEndereco2').val(data.Endereco2.Id);
            if (data.Endereco2.Id) {
                $('#Logradouro2').val(data.Endereco2.Logradouro);
                $('#Numero2').val(data.Endereco2.Numero);
                $('#Complemento2').val(data.Endereco2.Complemento);
                $('#Cidade2').val(data.Endereco2.Cidade);
                $('#Bairro2').val(data.Endereco2.Bairro);
                $('#CEP2').val(data.Endereco2.CEP);
                setItemCombo('IdPais2', data.Endereco2.IdPais);
                carregarComboEstado('UF2', data.Endereco2.IdPais, data.Endereco2.UF, 13); 
            }
            
            $('#Telefone').val(data.Telefone);
            $('#Celular').val(data.Celular);
            $('#Outro').val(data.Outro);
            $('#Email').val(data.Email);

            $('#BancoNumero').val(data.BancoNumero);
            $('#BancoAgencia').val(data.BancoAgencia);
            $('#BancoConta').val(data.BancoConta);
            setItemCombo('IdEscolaridade', data.IdEscolaridade);
            $('#Instituicao').val(data.Instituicao);
            $('#Idioma').val(data.Idioma);
            $('#Observacao').val(data.Observacao);

            $('#Revisao').val(data.Revisao);
            $('#Ativo').val(data.Ativo);
            $('#IdStatus').val(data.IdStatus);
            $('#NomeStatus').val(data.NomeStatus);
            $('#IdUsuarioCadastro').val(data.IdUsuarioCadastro);
            $('#DataCadastro').val(data.DataCadastro);
            $('#NomeUsuarioCadastro').val(data.NomeUsuarioCadastro);
            $('#IdUsuarioAcao').val(data.IdUsuarioAcao);
            $('#DataAcao').val(data.DataAcao);
            $('#NomeUsuarioAcao').val(data.NomeUsuarioAcao);
            
            $('#Critica').val(data.Critica);
            if (data.Critica > 0){
                myApp.showMensagem('#boxCritica', 'erro', data.NomeCritica);
            }
            mostrarDocumentos();
            mostrarRegistros();
            
            preparaForm('visualizar');
            
            // Iniciar Críticas do registro
            conferirCPF(13);
            conferirEmail(13);
            
        } else {                
            myApp.showAlert('erro', data.mensagem);
        }
        myApp.hidePleaseWait();
        myApp.goTop();
    });
    
}

function gravar() 
{ 
    myApp.hideAlert();
    $('#formCadastro').submit();

}

function excluir() 
{ 
    if ($('#bt_excluir').attr('disabled') != 'disabled'){
        myApp.hideAlert();
        bootbox.dialog({
            title: "Confirmação de exclusão",
            message: "Tem certeza que deseja excluir o cadatros do profissional '" + $('#Nome').val() + "' ?" ,
            buttons: {
                danger: {
                    label: "Confirmar",
                    className: "btn-danger",
                    callback: function() {
                        concluir_exclusao();
                    }
                },
                cancel: {
                    label: "Cancelar",
                    className: "btn-default",
                    callback: function() {
                        //Example.show("Primary button");
                    }
                }
            }
        });
    } else {
        myApp.showAlert('erro', 'Você <b>NÃO</b> tem permissão para executar esta operação.');
    }
}

function concluir_exclusao() 
{ 
    myApp.hideAlert();
    preparaForm('excluir');
    $('#formCadastro').submit();
}

function sair() 
{ 
     var url = "controller.php?mod=abertura"; 
    $(location).attr('href',url);
}

function visualizarImpressao()
{
    if ($("#Id").val() > 0){
        var url = 'views/cadastro-pessoa.pdf.php?acao=visualizar&id=' + $("#Id").val() + '&chave=' + $("#Chave").val();
        var windowName = "_blank";
        var windowSettings = ''; //'top=50,left=50,width=935,height=550,toolbar=no,location=no,directories=no,scrollbars=yes,status=no,menubar=no,copyhistory=no'; 
        window.open(url, windowName, windowSettings, true);
    }
}


function aprovar() 
{ 
    if ($('#bt_aprovar').attr('disabled') != 'disabled'){
        myApp.hideAlert();
        bootbox.dialog({
            title: "Confirmação de Aprovação do Cadastro",
            message: "Tem certeza que deseja aprovar o cadatros do profissional '" + $('#Nome').val() + "' ?" ,
            buttons: {
                danger: {
                    label: "Aprovar",
                    className: "btn-success",
                    callback: function() {
                        concluir_aprovacao();
                    }
                },
                cancel: {
                    label: "Cancelar",
                    className: "btn-default",
                    callback: function() {
                        //Example.show("Primary button");
                    }
                }
            }
        });
    } else {
        myApp.showAlert('erro', 'Você <b>NÃO</b> tem permissão para executar esta operação.');
    }
}

function concluir_aprovacao() 
{ 
    myApp.hideAlert();
    preparaForm('aprovar');
    $('#formCadastro').submit();
}

function popularPais(Ids, tecla){
    var cboNome = 'IdPais1'; 
    var cboNome2 = 'IdPais2'; 
    var cboNome3 = 'IdNacionalidade';
    
    if(tecla==13){
        clearCombo(cboNome);
        addItemCombo(cboNome, '', 'Carregando . . .');
        clearCombo(cboNome2);
        addItemCombo(cboNome2, '', 'Carregando . . .');
        clearCombo(cboNome3);
        addItemCombo(cboNome3, '', 'Carregando . . .');
        
        $.getJSON('interacao.php', {controle: 'Pais', acao: 'listarCombo'},
            function(data){
                if (data.records > 0){
                    clearCombo(cboNome);
                    addItemCombo(cboNome, '', '[Selecione]');
                    clearCombo(cboNome2);
                    addItemCombo(cboNome2, '', '[Selecione]');
                    clearCombo(cboNome3);
                    addItemCombo(cboNome3, '', '[Selecione]');
                    for(i=0;i<data.rows.length;i++){
                        addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
                        addItemCombo(cboNome2, data.rows[i].value, data.rows[i].text);
                        addItemCombo(cboNome3, data.rows[i].value, data.rows[i].text);
                    }
                } else {
                    addItemCombo(cboNome, '', '[Não encontrado]');
                    addItemCombo(cboNome2, '', '[Não encontrado]');
                    addItemCombo(cboNome3, '', '[Não encontrado]');
                }
            }
        );
    }
}

function Nacionalidade_onchange(IdPais)
{
    setNacionalidade(IdPais);
    carregarComboEstado('UFNaturalidade', IdPais, 0, 13);
}

function setNacionalidade(IdPais)
{
    if ((IdPais == '76') || (IdPais == 'BR') || (IdPais == 'BRA')){
        $("#boxCPF").addClass("required");
        $("#boxRGNumero").addClass("required");
        $("#boxRGOrgao").addClass("required");
        $("#boxLogradouro1").addClass("required");
        $("#boxNumero1").addClass("required");
        //$("#boxComplemento1").addClass("required");
        $("#boxBairro1").addClass("required");
        $("#boxCidade1").addClass("required");
        $("#boxCEP1").addClass("required");
        $("#boxIdPais1").addClass("required");
        $("#IdPais1").addClass("required");
        
        $("#boxPassaporte").removeClass("required");
        
    } else {
        $("#boxCPF").removeClass("required");
        $("#boxRGNumero").removeClass("required");
        $("#boxRGOrgao").removeClass("required");
        $("#boxLogradouro1").removeClass("required");
        $("#boxNumero1").removeClass("required");
        //$("#boxComplemento1").removeClass("required");
        $("#boxBairro1").removeClass("required");
        $("#boxCidade1").removeClass("required");
        $("#boxCEP1").removeClass("required");
        $("#boxIdPais1").removeClass("required");
        $("#IdPais1").removeClass("required");

        $("#boxPassaporte").addClass("required");
        
    } 
}


function carregarComboEstado(cboNome, IdPais, UF, tecla){ 
    if(tecla==13){
        clearCombo(cboNome);
        if (IdPais) {
            addItemCombo(cboNome, '', 'Carregando . . .');
            $.getJSON('interacao.php', {controle: 'Estado', acao: 'listarCombo', IdPais: IdPais},
                function(data){
                    clearCombo(cboNome);
                    if (data.records > 0){
                        addItemCombo(cboNome, '', '[Selecione]');
                        for(i=0;i<data.rows.length;i++){
                            addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
                        }
                        if (UF) setItemCombo(cboNome, UF);
                    } else {
                        addItemCombo(cboNome, '', '[Não encontrado]');
                    }
                }
            );
        } else {
            addItemCombo(cboNome, '', '[Nenhum]');
        }
    }
}

function carregarComboStatus(cboNome, Ids, tecla){ 
    if(tecla==13){
        clearCombo(cboNome);
        addItemCombo(cboNome, '', 'Carregando . . .');
        $.getJSON('interacao.php', {controle: 'Status', acao: 'listarCombo', Id: Ids},
            function(data){
                clearCombo(cboNome);
                if (data.records > 0){
                    addItemCombo(cboNome, '', '[Todos]');
                    for(i=0;i<data.rows.length;i++){
                        addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
                    }
                    if (Ids) setItemCombo(cboNome, Ids);
                } else {
                    addItemCombo(cboNome, '', '[Não encontrado]');
                }
            }
        );
    }
}

function popularProfissao(Ids, tecla){ 
    if(tecla==13){
        var cboNome = 'IdProfissao';
        
        clearCombo(cboNome);
        addItemCombo(cboNome, '', 'Carregando . . .');
        
        $.getJSON('interacao.php', {controle: 'Profissao', acao: 'listarCombo', Id: Ids},
            function(data){
                clearCombo(cboNome);
                addItemCombo(cboNome, '', '[Selecione]');
                if (data.records>1){
                    for(i=0;i<data.rows.length;i++){
                        addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
                    }
                    if (Ids){ 
                        setItemCombo(cboNome, Ids);
                    }
                } else if (data.records==1){
                    addItemCombo(cboNome, data.rows[0].value, data.rows[0].text);
                    setItemCombo(cboNome, data.rows[0].value);
                }
            }
        );
    }
}

function popularEmpresa(IdTipoEmpresa, IdEmpresa, IdPessoa, tecla){ 
    if(tecla==13){
        var cboNome = 'filtroIdEmpresa'; 
        var cboNome2 = 'IdEmpresa';
        var cboNome3 = 'IdEmpresa3';
        
        clearCombo(cboNome);
        addItemCombo(cboNome, '', 'Carregando . . .');
        clearCombo(cboNome2);
        addItemCombo(cboNome2, '', 'Carregando . . .');
        clearCombo(cboNome3);
        addItemCombo(cboNome3, '', 'Carregando . . .');
        
        $.getJSON('interacao.php', {controle: 'Empresa', acao: 'listarCombo', IdTipoEmpresa: IdTipoEmpresa},
            function(data){
                clearCombo(cboNome);
                clearCombo(cboNome2);
                clearCombo(cboNome3);
                if (data.records > 0){
                    addItemCombo(cboNome, '', '[Selecione]');
                    addItemCombo(cboNome2, '', '[Selecione]');
                    addItemCombo(cboNome3, '', '[Selecione]');
                    for(i=0;i<data.rows.length;i++){
                        addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
                        addItemCombo(cboNome2, data.rows[i].value, data.rows[i].text);
                        if (data.rows[i].IdPais == 76) {
                            addItemCombo(cboNome3, data.rows[i].value, data.rows[i].text);
                        }
                    }
                    if (data.records==1){
                        clearCombo(cboNome);
                        addItemCombo(cboNome, data.rows[0].value, data.rows[0].text);
                        setItemCombo(cboNome, data.rows[0].value);
                        
                        clearCombo(cboNome2);
                        addItemCombo(cboNome2, data.rows[0].value, data.rows[0].text);
                        setItemCombo(cboNome2, data.rows[0].value);

                        clearCombo(cboNome3);
                        addItemCombo(cboNome3, data.rows[0].value, data.rows[0].text);
                        setItemCombo(cboNome3, data.rows[0].value);

                    } else if (IdEmpresa){
                        setItemCombo(cboNome, IdEmpresa);
                        //setItemCombo(cboNome2, IdEmpresa);
                        setItemCombo(cboNome3, IdEmpresa);
                    }
                    if (IdPessoa){
                        visualizar(IdPessoa);
                    } else {
                        carregarLista(13);
                    }
                } else {
                    addItemCombo(cboNome, '', '[Não encontrado]');
                    addItemCombo(cboNome2, '', '[Não encontrado]');
                    addItemCombo(cboNome3, '', '[Não encontrado]');
                }
            }
        );
    }
}

function carregarTipoDocs()
{ 
    var cboNome = 'IdTipoDocumento';
    clearCombo(cboNome);
    addItemCombo(cboNome, '', '[Selecione]');

    tipoDocs = new Array();
    
    $.getJSON('interacao.php', {controle: 'TipoDocumento', acao: 'listarCombo', Id: ''},
        function(data){
            if (data.records > 0){
                for(i=0;i<data.rows.length;i++){
                    tipoDocs[data.rows[i].value] = data.rows[i].text;
                    
                    addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
                }
            }
        }
    );
}

function carregarComboTipoDocumento(cboNome, IdTipoDocumento, tecla)
{ 
    if(tecla==13){
        clearCombo(cboNome);
        addItemCombo(cboNome, '', 'Carregando ...');
        $.getJSON('interacao.php', {controle: 'TipoDocumento', acao: 'listarCombo', IdTipoDocumento: IdTipoDocumento},
            function(data){
                clearCombo(cboNome);
                if (data.records > 1){
                    addItemCombo(cboNome, '', '[Selecione]');
                    for(i=0;i<data.rows.length;i++){
                        addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
                    }
                    if (IdTipoDocumento) setItemCombo(cboNome, IdTipoDocumento);
                } else if (data.records==1){
                    addItemCombo(cboNome, data.rows[0].value, data.rows[0].text);
                } else {
                    addItemCombo(cboNome, '', '[Não encontrado]');
                }
            }
        );
    }
}

function validaFormDoc(formData, jqForm, options) { 
    var acao = $('#acao2').val();
    $('#IdPessoa2').val($('#Id').val());
    var IdPessoa = $('#IdPessoa2').val();
    var IdTipoDocumento = $('#IdTipoDocumento').val();
    var Arquivo = $('#Arquivo').val();

     myApp.hideMensagem('#boxMensagemDoc');
    
    if (acao == 'excluir-documento') {
        if (!($("#IdDocumento").val() > 0)){
            myApp.showMensagem('#boxMensagemDoc', 'erro', 'Selecione primeiro um registro para poder excluir.');
            return false; 
        }
        
    } else { // acao = criar e atualizar
        if ((IdPessoa == '') || (IdPessoa == '0')){
            myApp.showMensagem('#boxMensagemDoc', 'erro', 'O Campo <b>Pessoa</b> é de preenchimento obrigatório.');
            return false; 
        } else if ((IdTipoDocumento == '') || (IdTipoDocumento == '0')){
            myApp.showMensagem('#boxMensagemDoc', 'erro', 'É necessário selecionar um <b>Tipo de Documento</b> antes de confirmar a inclusão do <b>Documento</b>.');
            return false; 
        } else if ((Arquivo == '') || (Arquivo == '0')){
            myApp.showMensagem('#boxMensagemDoc', 'erro', 'É necessário selecionar um <b>Arquivo</b> antes de confirmar a inclusão do <b>Documento</b>.');
            return false; 
        }
    }
    
    myApp.showPleaseWait(); 
    
}

// post-submit callback 
function showResponseDoc(data) { 

    if (data.sucesso) {
        preparaForm('limpar-documento');
        myApp.showMensagem('#boxMensagemDoc', 'sucesso', data.mensagem);

        if (data.IdTipoDocumento==1){
            $("#arqFotografia").attr("src",'_files/pessoas/' + data.Nome + '?dh=' + new Date().getTime());
        }
        mostrarDocumentos();
        myApp.hidePleaseWait();
    } else {                
        myApp.hidePleaseWait();
        myApp.showMensagem('#boxMensagemDoc', 'erro', data.mensagem);
    } 
} 

function abrirFormDocumento()
{
    if (($('#acao').val() == 'visualizar') || ($('#acao').val() == 'editar')) {
        preparaForm('limpar-documento');
        preparaForm('adicionar-documento');
        $('#IdTipoDocumento').focus();
    }else{
        myApp.showMensagem('#boxMensagemDoc', 'erro', "Para adicionar um documento você deve estar visualizando um Profissional.");
    }
}

function gravarDocumento()
{
    $('#formDocumento').submit();
}

function cancelarDocumento()
{
    preparaForm('limpar-documento');
    
}


function removerDocumento(IdDocumento, Nome) 
{ 
    console.log("removerDocumento('" + IdDocumento + "', '" + Nome + "');"); 

    var acao = $('#acao').val();
    $('#Id2').val(IdDocumento);
    $('#IdDocumento').val(IdDocumento);
    
    //if (acao == 'editar') {
        if (($('#IdStatus').val() == '1') || ($('#IdStatus').val() == '2') || ($('#IdStatus').val() == '10')){

            myApp.hideAlert();
            bootbox.dialog({
                title: "Confirmação de exclusão",
                message: "Tem certeza que deseja remover o documento '" + Nome + "' ?" ,
                buttons: {
                    danger: {
                        label: "Confirmar",
                        className: "btn-danger",
                        callback: function() {
                            concluirExclusaoDocumento();
                        }
                    },
                    cancel: {
                        label: "Cancelar",
                        className: "btn-default",
                        callback: function() {
                            //Example.show("Primary button");
                        }
                    }
                }
            });    
        }else{
            myApp.showMensagem('#boxMensagemDoc', 'erro', "Não é permitido excluir Documento/Arquivo de profissionais com status: <b>"+$('#IdStatus').val()+"</b>.");
        }
    //}else{
    //    myApp.showMensagem('#boxMensagemDoc', 'erro', "Para remover um Documento você deve estar editando uma Profissional.");
    //}
}


function mostrarDocumentos()
{
    var IdPessoa = $('#Id').val();
    limparTabela('tabListagemDocumento');
    
    $.getJSON('interacao.php', {controle: "Documento", acao: "listar", IdPessoa: IdPessoa },
        function(data){ 
            if (data.sucesso){
                mostrarTabelaDocumentos(data);
            } else {
                myApp.showMensagem('#boxMensagemDoc','alerta', data.mensagem);
            }
        }
    );
}

function limparTabela(IdObjeto){
    var table=document.getElementById(IdObjeto);
    var rowCount = table.rows.length;
    for(var i=1; i<rowCount; i++) {
        table.deleteRow(i);
        rowCount--;
        i--;
    }
}

function mostrarTabelaDocumentos(data)
{
    console.log("mostrarTabelaDocumentos('" + data.aaData.length + "');"); 

    limparTabela('tabListagemDocumento');
    
    var cnt = 0;
    var table = document.getElementById('tabListagemDocumento');  
    var tblBody = table.tBodies[0];  
    
    dataDocs = data.aaData;
    
    if (data.aaData.length > 0) {
        
        // Preencher a Table
        for(i=0;i<data.aaData.length;i++){
            var newRow = tblBody.insertRow(-1);  
        
            var newCell0 = newRow.insertCell(0);  
            newCell0.innerHTML = '<a class="btn btn-vazio btn-xs" title="Alterar registro selecionado." onclick="visualizarDocumento('+data.aaData[i][0]+');"><span class="glyphicon glyphicon-search blue"></span></a>';
            newCell0.className = 'text-center';
            
            $lnkExcluir = '&nbsp;';
            if(typeof oModulo.Operacoes.excluir!=='undefined'){
                if(oModulo.Operacoes.excluir){
                    $lnkExcluir = '<a class="btn btn-vazio btn-xs" title="Remover registro selecionado." onclick="removerDocumento('+data.aaData[i][0]+", '"+data.aaData[i][5]+"'"+');"><span class="glyphicon glyphicon-trash red"></span></a>';
                }
            }
            
            var newCell1 = newRow.insertCell(1);  
            newCell1.innerHTML = $lnkExcluir;
            newCell1.className = 'text-center';

            var newCell2 = newRow.insertCell(2);  
            newCell2.innerHTML = data.aaData[i][5];  
            
            var newCell3 = newRow.insertCell(3);  
            newCell3.innerHTML = data.aaData[i][7];
            
            cnt = cnt + 1;
        }
        if (cnt > 0){
            //document.getElementById('label_total_alunos').innerHTML = cnt;
        }
        if (passoAtual<3){
            goToStep(3);
        }

    }
}

function concluirExclusaoDocumento() 
{ 
    preparaForm('excluir-documento');
    $('#formDocumento').submit();
}

function visualizarDocumento(Id)
{
    if (Id > 0){
        var url = 'views/documento.view.php?Id='+ Id +'&dh=<?php echo date("YmdHi");?>';
        var windowName = "_blank";
        var windowSettings = 'top=50,left=50,width=500,height=400,toolbar=no,location=no,directories=no,scrollbars=yes,status=no,menubar=no,copyhistory=no'; 
        window.open(url, windowName, windowSettings, true);
    }
}

/* ----------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

function mostrarRegistros()
{
    var IdPessoa = $('#Id').val();
    limparTabela('tabListagemRegistro');
    
    $.getJSON('interacao.php', {controle: 'Pessoa', acao: 'listarFuncionarios', IdPessoa: IdPessoa },
        function(data){ 
            if (data.sucesso){
                mostrarTabelaRegistros(data);
            } else {
                myApp.showMensagem('#boxMensagemReg','alerta', data.mensagem);
            }
        }
    );
}

function limparTabela(IdObjeto){
    var table=document.getElementById(IdObjeto);
    var rowCount = table.rows.length;
    for(var i=1; i<rowCount; i++) {
        table.deleteRow(i);
        rowCount--;
        i--;
    }
}

function mostrarTabelaRegistros(data)
{
    console.log("mostrarTabelaRegistros('" + data.aaData.length + "');"); 

    limparTabela('tabListagemRegistro');
    
    var cnt = 0;
    var table = document.getElementById('tabListagemRegistro');  
    var tblBody = table.tBodies[0];  
    
    if (data.aaData.length > 0) {
        
        // Preencher a Table
        for(i=0;i<data.aaData.length;i++){
            var newRow = tblBody.insertRow(-1);  
        
            var newCell = newRow.insertCell(0);  
            newCell.innerHTML = data.aaData[i][0];
            newCell.className = 'text-center';
            
            var newCell = newRow.insertCell(1);  
            newCell.innerHTML = data.aaData[i][1];
            newCell.className = 'text-center';

            var newCell = newRow.insertCell(2);  
            newCell.innerHTML = data.aaData[i][2];  
            
            var newCell = newRow.insertCell(3);  
            newCell.innerHTML = data.aaData[i][3];

            var newCell = newRow.insertCell(4);  
            newCell.innerHTML = data.aaData[i][4];
            newCell.className = 'text-center';

            var newCell = newRow.insertCell(5);  
            newCell.innerHTML = data.aaData[i][5];
            newCell.className = 'text-center';

            var newCell = newRow.insertCell(6);  
            newCell.innerHTML = data.aaData[i][6];
            
            cnt = cnt + 1;
        }
        if (cnt > 0){
            //document.getElementById('label_total_alunos').innerHTML = cnt;
        }
    }
}  

function visualizarImpressaoRegistro(IdRegistro)
{
    if (IdRegistro > 0){
        var url = 'views/registro-profissional.pdf.php?acao=visualizar&id=' + IdRegistro;
        var windowName = "_blank";
        var windowSettings = ''; //'top=50,left=50,width=935,height=550,toolbar=no,location=no,directories=no,scrollbars=yes,status=no,menubar=no,copyhistory=no'; 
        window.open(url, windowName, windowSettings, true);
    }
}

function abrirFormRegistro()
{
    if (($('#acao').val() == 'visualizar') || ($('#acao').val() == 'editar')) {
        preparaForm('limpar-registro');
        preparaForm('adicionar-registro');
        $('#IdProfissao').focus();
    }else{
        myApp.showMensagem('#boxMensagemReg', 'erro', "Para adicionar um registro você deve estar visualizando um Profissional.");
    }
}

function adicionarRegistro() 
{ 
    console.log("adicionarRegistro('');"); 

    $('#acao3').val('');
    $('#IdPessoa3').val($('#Id').val());
    
    if ($('#bt_add_registro').attr('disabled') != 'disabled'){
        if ($('#IdStatus').val() == '10'){
            myApp.hideAlert();
            bootbox.dialog({
                title: "Confirmação de Criação de Perfil",
                message: "Tem certeza que deseja criar um novo perfil profissional para o '" + $('#Nome').val() + "' ?" ,
                buttons: {
                    danger: {
                        label: "Confirmar",
                        className: "btn-success",
                        callback: function() {
                            $('#acao3').val('criar-registro');
                            $('#formRegistro').submit();
                        }
                    },
                    cancel: {
                        label: "Cancelar",
                        className: "btn-default",
                        callback: function() {
                            //Example.show("Primary button");
                        }
                    }
                }
            });    
        }else{
            myApp.showMensagem('#boxMensagemReg', 'erro', "Não é permitido criar um novo perfil profissional para pessoa com status: <b>"+$('#IdStatus').val()+"</b>.");
        }
    } else {
        myApp.showMensagem('#boxMensagemReg', 'erro', 'Você <b>NÃO</b> tem permissão para executar esta operação.');
    }
}

function gravarRegistro(){
    $('#formRegistro').submit();
}

function cancelarRegistro(){
    preparaForm('limpar-registro');
}

function validaFormReg(formData, jqForm, options) { 
    var acao = $('#acao3').val();
    $('#IdPessoa3').val($('#Id').val());
    var IdPessoa = $('#IdPessoa3').val();

     myApp.hideMensagem('#boxMensagemReg');
    
    if (acao == 'incluir') {
        if (!($("#IdPessoa3").val() > 0)){
            myApp.showMensagem('#boxMensagemReg', 'erro', 'Selecione primeiro um registro para poder criar um novo perfil.');
            return false; 
        }
        if (($("#IdProfissao").val() == '') || ($("#IdProfissao").val() == '0')){
            myApp.showAlert('erro', 'O Campo <b>Profissão</b> é de preenchimento obrigatório.');
            return false; 
        }
        if ($("#Idade").val() < 18) {
            if (($("#Responsavel3").val() == '') || ($("#Responsavel3").val() == '0')){
                myApp.showAlert('erro', 'O Campo <b>Responsavel</b> é de preenchimento obrigatório.');
                return false; 
            }
        }

        if (($("#IdEmpresa3").val() == '') || ($("#IdEmpresa3").val() == '0')){
            myApp.showAlert('erro', 'O Campo <b>Empresa</b> é de preenchimento obrigatório.');
            return false; 
        }
        if (($("#IdProfissao").val() == '1')){ // 
            /*
            if (($("#IdContrato").val() == '') || ($("#IdContrato").val() == '0')){
                myApp.showAlert('erro', 'O Campo <b>Contrato</b> é de preenchimento obrigatório.');
                return false; 
            }
            */
        }
        
        if (($("#DataInicial").val() == '') || ($("#DataInicial").val() == '__/__/____')){
            myApp.showAlert('erro', 'O Campo <b>Data Inicial</b> é de preenchimento obrigatório.');
            return false; 
        }
        if (($("#DataFinal").val() == '') || ($("#DataFinal").val() == '__/__/____')){
            myApp.showAlert('erro', 'O Campo <b>Data Final</b> é de preenchimento obrigatório.');
            return false; 
        }
        
        
    } else { 
        myApp.showAlert('erro', 'Ação <b>'+acao+'</b> não implementada.');
        return false; 
    }
    
    myApp.showPleaseWait(); 
    
}

function showResponseReg(data)
{ 
    if (data.sucesso) {
        preparaForm('limpar-registro');
        myApp.showMensagem('#boxMensagemReg', 'sucesso', data.mensagem);

        mostrarRegistros();
        myApp.hidePleaseWait();
    } else {                
        myApp.hidePleaseWait();
        myApp.showMensagem('#boxMensagemReg', 'erro', data.mensagem);
    } 
} 

function conferirCPF(tecla)
{ 
    if(tecla===13){
        if ($('#CPF').val()!=''){
            $.getJSON('interacao.php', {controle: 'Pessoa', acao: 'conferirCPF', Id: $('#Id').val(), CPF: $('#CPF').val()},
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
        } else {
            $('#CPF').removeClass('green');
            $('#CPF').removeClass('red');
            $('#lblCPFError').html('');
            $('#lblCPFError').hide();
        }
    }
}

function conferirEmail(tecla)
{ 
    if(tecla===13){
        if ($('#Email').val()!=''){
            $.getJSON('interacao.php', {controle: 'Pessoa', acao: 'conferirEmail', Id: $('#Id').val(), Email: $('#Email').val()},
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
        } else {
            $('#Email').removeClass('green');
            $('#Email').removeClass('red');
            $('#lblEmailError').html('');
            $('#lblEmailError').hide();
        }
    }
}


function carregarComboContrato(cboNome, IdMatriz, IdEmpresa, tecla)
{ 
    console.log("carregarComboContrato('" + cboNome + "', '" + IdMatriz + "', '" + IdEmpresa + "', '" + tecla + "');"); 

    if(tecla==13){
        var IdTipoEmpresa = '21,22,23,24';
        clearCombo(cboNome);
        if (IdMatriz) {
            addItemCombo(cboNome, '', 'Carregando . . .');
            $.getJSON('interacao.php', {controle: 'Empresa', acao: 'listarCombo', IdTipoEmpresa: IdTipoEmpresa, IdMatriz: IdMatriz, IdEmpresa: IdEmpresa},
                function(data){
                    clearCombo(cboNome);
                    if (data.records > 0){
                        addItemCombo(cboNome, '', '[Selecione]');
                        for(i=0;i<data.rows.length;i++){
                            addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
                        }
                        if (IdEmpresa) setItemCombo(cboNome, IdEmpresa);
                    } else {
                        addItemCombo(cboNome, '', '[Não encontrado]');
                    }
                }
            );
        } else {
            addItemCombo(cboNome, '', '[Selecione uma Empresa]');
        }
    }
}

function filtroIdEmpresa_onchange(valor, tecla)
{
    console.log("filtroIdEmpresa_onchange('" + valor + "', '" + tecla + "'); [" + $('#filtroIdTipo').val() + "]"); 
    if(tecla===13){
        //if ($('#filtroIdProfissao :selected').val()=='1'){
            carregarComboContrato('filtroIdContrato', valor, '', tecla);
        //}
    }
}

function IdEmpresa_onchange(valor, tecla)
{
    console.log("IdEmpresa_onchange('" + valor + "', '" + tecla + "'); [" + $('#filtroIdTipo').val() + "]"); 
    if(tecla===13){
        carregarComboContrato('IdContrato', valor, '', tecla);
    }
}

function IdEmpresa3_onchange(valor, tecla)
{
    console.log("IdEmpresa3_onchange('" + valor + "', '" + tecla + "'); [" + $('#filtroIdTipo').val() + "]"); 
    if(tecla===13){
        if ($('#IdProfissao :selected').val()=='1'){
            carregarComboContrato('IdContrato', valor, '', tecla);
        }
    }
}


function IdProfissao_onchange(IdProfissao){
    setProfissao(IdProfissao, 0);
}

function setProfissao(IdProfissao, IdProfissaoNivel){
    var IdRegistro = parseFloat($('#Id').val());
    var IdStatus = parseFloat($('#IdStatus').val());
    var IdEmpresa = parseFloat($('#IdEmpresa3 :selected').val());
    var IdContrato = parseFloat($('#IdContrato :selected').val());
    
    IdProfissao = parseFloat(IdProfissao);

    console.log('setProfissao('+IdProfissao+', '+ IdProfissaoNivel +') [IdRegistro='+IdRegistro+'] [IdStatus='+IdStatus+']');
    
    selecionarNivel('IdProfissaoNivel', IdProfissao, IdProfissaoNivel, 13);
   
}


function IdProfissaoNivel_onchange(IdProfissaoNivel)
{
    visualizarNivel(IdProfissaoNivel, 13);
}

function selecionarNivel(cboNome, IdProfissao, IdProfissaoNivel, tecla){ 
    
    if(tecla==13){
        $('#box-'+cboNome).hide();
        if (IdProfissao) {
            clearCombo(cboNome);
            addItemCombo(cboNome, '', 'Carregando . . .');
            $.getJSON('interacao.php', {controle: 'ProfissaoNivel', acao: 'listarCombo', IdProfissao: IdProfissao},
                function(data){
                    clearCombo(cboNome);
                    addItemCombo(cboNome, '', '[Selecione]');
                    if (data.records > 0){
                        for(i=0;i<data.rows.length;i++){
                            addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
                        }
                        $('#box-'+cboNome).show();
                        
                        if (IdProfissaoNivel){ setItemCombo(cboNome, IdProfissaoNivel);}
                    } else {
                        $('#box-'+cboNome).hide();
                        addItemCombo(cboNome, '', '[Não encontrado]');
                        
                        visualizarProfissao(IdProfissao, 13);
                    }
                }
            );
        } else {
            clearCombo(cboNome);
            addItemCombo(cboNome, '', '[Selecione]');
        }
    }
}

function visualizarProfissao(Id, tecla) 
{ 
    var IdStatus = parseFloat($('#IdStatus').val());
    console.log('visualizarProfissao('+Id+', '+tecla+');[IdStatus:'+IdStatus+']');
    
    if (Id){
        //myApp.showPleaseWait();
        //myApp.hideAlert();
        
        $.getJSON('interacao.php', {controle: 'Profissao',  acao: 'retornar', Id: Id},
        function(data){ 
            if (data.sucesso){
                // Carregar Dados;
                $('#AnosRegistro').val(data.AnosRegistro);
                $('#DiasLiberacao').val(data.DiasLiberacao);
                //$('#AnosAtivo').val(data.AnosAtivo);
    
                if (IdStatus == 2){ // {2: "Pendente de Registro"} (Ainda NÃO escolheu a profissão)
                    if ($('#DataFinal').val() == ''){
                        calcularDataFinal();
                    }
                }
    
                // Documentos
                $('#Docs').val(data.Docs);
                $('#DocsObr').val(data.DocsObr);
                aDocs = data.Documentos;
                /*
                // Exibir Documentos
                if (data.Documentos.length > 0 ) {
                    for(i=0;i<data.Documentos.length;i++){
                        var Chave = 'doc-' + data.Documentos[i][0];
                        $('#box-'+Chave).show();
                        $('#lbl-'+Chave).html(data.Documentos[i][1]+': ');
                    }
                }
                
                // Marcar Documentos os Obrigatórios
                if (data.DocumentosObrigatorios.length > 0 ) {
                    for(i=0;i<data.DocumentosObrigatorios.length;i++){
                        var Chave = 'doc-' + data.DocumentosObrigatorios[i][0];
                        $('#box-'+Chave).show();
                        //$('#'+Chave).prop("checked", true);
                    }
                }
                */
                
                // Exibir apenas Documentos da Profissão
                //carregarComboTipoDocumento('IdTipoDocumento', data.Docs, 13);
                
                // Criticar Documentos
                criticarDocumentos();
                
            } else {                
                myApp.showAlert('erro', data.mensagem);
            }
            console.log('visualizarProfissao() -> Final;');
            //myApp.hidePleaseWait();
        });
    }
}

function visualizarNivel(Id, tecla) 
{ 
    console.log('visualizarNivel('+Id+', '+tecla+');');

    if (Id){
        //myApp.showPleaseWait();
        //myApp.hideAlert();
        $.getJSON('interacao.php', {controle: 'ProfissaoNivel', acao: 'retornar', Id: Id},
        function(data){ 
            if (data.sucesso){
                // Carregar Dados;
                $('#AnosRegistro').val(data.AnosRegistro);
                $('#DiasLiberacao').val(data.DiasLiberacao);
                //$('#AnosAtivo').val(data.AnosAtivo);
                
                // Documentos
                $('#Docs').val(data.Docs);
                $('#DocsObr').val(data.DocsObr);
                aDocs = data.Documentos;
                
                /*
                // Exibir Documentos
                if (data.Documentos.length > 0 ) {
                    for(i=0;i<data.Documentos.length;i++){
                        var Chave = 'doc-' + data.Documentos[i][0];
                        $('#box-'+Chave).show();
                        $('#lbl-'+Chave).html(data.Documentos[i][1]+': ');
                    }
                }
                
                // Marcar Documentos os Obrigatórios
                if (data.DocumentosObrigatorios.length > 0 ) {
                    for(i=0;i<data.DocumentosObrigatorios.length;i++){
                        var Chave = 'doc-' + data.DocumentosObrigatorios[i][0];
                        $('#box-'+Chave).show();
                        //$('#'+Chave).prop("checked", true);
                    }
                }
                */
                // Exibir apenas Documentos da Profissão
                //carregarComboTipoDocumento('IdTipoDocumento', data.Docs, 13);
                
                // Criticar Documentos
                criticarDocumentos();
                
            } else {                
                myApp.showAlert('erro', data.mensagem);
            }
            console.log('visualizarNivel() -> Final;');
            //myApp.hidePleaseWait();
        });
    }
}

function criticarDocumentos()
{
    myApp.hideMensagem('#boxCriticaDoc');

    // Criticar Documentos
    var numCritica = 0;
    var strCritica = '';
    var aDocsObr = new Array();
    var DocsObr = $('#DocsObr').val();
    if (DocsObr!=''){
        if (DocsObr.indexOf(',') !== -1){
            aDocsObr = DocsObr.split(",");
        } else {
            aDocsObr = new Array(DocsObr);
        }
    }
    console.log("criticarDocumentos('" + DocsObr + "');"); 
    
    var encontrei = false;
    for (var i = 0; i < aDocsObr.length; i++) { 
        if (aDocsObr[i]!='0'){
            encontrei = false;
            for(j=0;j<dataDocs.length;j++){
                if (aDocsObr[i] == dataDocs[j][4]) { 
                    encontrei = true; 
                    break; 
                }
            }
            if (!encontrei){
                numCritica++;
                if( tipoDocs[aDocsObr[i]] === undefined ) {
                    //strCritica += '<br/>&nbsp;&nbsp;&nbsp;' + numCritica + '. Tipo:' + aDocsObr[i];
                    strCritica += '<li>' + 'Tipo:' + aDocsObr[i] + '</li>';
                } else {
                    //strCritica += '<br/>&nbsp;&nbsp;&nbsp;' + numCritica + '. ' + tipoDocs[aDocsObr[i]];
                    strCritica += '<li>' + tipoDocs[aDocsObr[i]] + '</li>';
                }
            }
        }
    }
    
    if (numCritica>0){
        myApp.showMensagem('#boxCriticaDoc', 'erro', '<b>Documentos Faltando: </b><br/><ol class="alert-list">' + strCritica + '</ol>');
    }
    console.log("criticarDocumentos('" + DocsObr + "'); return " + numCritica); 
    
    return numCritica;
}

function carregarComboSetor(cboNome, IdEmpresa, Ids, tecla){ 
    if(tecla==13){
        clearCombo(cboNome);
        addItemCombo(cboNome, '', 'Carregando ...');
        $.getJSON('interacao.php', {controle: 'CentroCusto', acao: 'listarCombo', IdEmpresa: IdEmpresa, Id: Ids},
            function(data){
                clearCombo(cboNome);
                if (data.records > 1){
                    addItemCombo(cboNome, '', '[Selecione]');
                    for(i=0;i<data.rows.length;i++){
                        addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
                    }
                    if (Ids){ setItemCombo(cboNome, Ids); }
                } else if (data.records==1){
                    addItemCombo(cboNome, data.rows[0].value, data.rows[0].text);
                } else {
                    addItemCombo(cboNome, '', '[Não encontrado]');
                }
            }
        );
    }
}

function carregarComboProfissao(cboNome, IdEmpresa, Ids, tecla){ 
    if(tecla==13){
        var cboNome = 'IdProfissao';
        
        clearCombo(cboNome);
        addItemCombo(cboNome, '', 'Carregando . . .');
        $.getJSON('interacao.php', {controle: 'Profissao', acao: 'listarCombo', IdEmpresa: IdEmpresa, Id: Ids},
            function(data){
                clearCombo(cboNome);
                if (data.records>1){
                    addItemCombo(cboNome, '', '[Selecione]');
                    for(i=0;i<data.rows.length;i++){
                        addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
                    }
                    if (Ids){ setItemCombo(cboNome, Ids); }
                } else if (data.records==1){
                    addItemCombo(cboNome, data.rows[0].value, data.rows[0].text);
                } else {
                    addItemCombo(cboNome, '', '[Não encontrado]');
                }
            }
        );
    }
}
/* ----------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

function inicializar()
{
    myApp.showPleaseWait();

    popularPais('', 13);
    
    //carregarComboTipoDocumento('IdTipoDocumento', 0, 13);
    carregarTipoDocs();

<?php 
    
    // Parametros do GET
    $Acao = filter_input(INPUT_GET, 'acao', FILTER_SANITIZE_STRING); 
    $IdPessoa = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Parametros do Modulo
    if (isset($sisModulo->Parametros)){
        if (isset($sisModulo->Parametros->IdStatus)){
            //echo "carregarComboStatus('filtroIdStatus', '".$sisModulo->Parametros->IdStatus."', 13);\n";
        } else {
            //echo "carregarComboStatus('filtroIdStatus', '1', 13);\n";
        }
    } else {
        //echo "carregarComboStatus('filtroIdStatus', '1', 13);\n";
    }

    // Contexto do Usuário
    if ($sisUsuario->IdTipo == 1) { // 1:Matriz
        echo "popularEmpresa('".$sisModulo->Parametros->IdTipoEmpresa."', '".$sisUsuario->IdEmpresa."', '$IdPessoa', 13);\n";
        
    } else { // 2:Filial
        echo "popularEmpresa('".$sisUsuario->IdTipoEmpresa."', '".$sisUsuario->IdEmpresa."', '$IdPessoa', 13);\n"; // Somente pessoas de sua Empresa
        
    }
    
?>    
    carregarComboProfissao('IdProfissao', oUsuario.IdEmpresa, '', 13);
    carregarComboSetor('IdSetor', oUsuario.IdEmpresa, '', 13);

    // PERMISSÕES DO USUARIO
    $('#bt_add_documento').hide(); 
    if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}
    if(typeof oModulo.Operacoes.listar!=='undefined'){if(oModulo.Operacoes.listar){$('#bt_pesquisar').removeAttr('disabled'); $('#bt_relatorio_pdf').removeAttr('disabled'); $('#bt_relatorio_excel').removeAttr('disabled');}}
    
}
</script>