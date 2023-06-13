<script type="text/javascript">
var oTable1;

/* JS JQUERY ************************************************************************************************************************************ */
jQuery(document).ready(function(){
    
    $('[data-toggle=popover]').popover({ trigger : 'hover', delay: {'show': 50, 'hide': 200}}).click(function(e){
        if($(this).is('a') || $(this).is('button') || ($(this).attr('data-type')==='data')) $(this).popover('hide');
    });
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
	
    $("#DataInicial").mask("99:99", {placeholder:"__/__/____"});
    $("#DataInicial").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'dd/mm/yy', minDate: '-1M', maxDate: '+5Y', showButtonPanel: true, yearRange: '<?php echo (date("Y")-1).':'.(date("Y")+5); ?>'
            ,onSelect: function(dateText) {
                    calcularDataFinal();
            }
    });
    
    $("#DataFinal").mask("99/99/9999", {placeholder:"__/__/____"});
    $("#DataFinal").datepicker(     { changeMonth: true, changeYear: true, dateFormat: 'dd/mm/yy', minDate: '0', maxDate: '+5Y', showButtonPanel: true, yearRange: '<?php echo date("Y").':'.(date("Y")+5); ?>'});

    $("#Capacidade").priceFormat({ prefix: '', centsSeparator: '', thousandsSeparator: '.', limit: 12, centsLimit: 0}); 
    
	/* JQUERY.FORM ****************************************************************************************************************************** */
    $("#formCadastro").ajaxForm({type: 'POST', dataType: 'json', url: 'interacao.php', beforeSubmit: validaForm, success: showResponse});
    $("#formTransacao").ajaxForm({type: 'POST', dataType: 'json', url: 'interacao.php', beforeSubmit: validaFormTrans, success: showResponseTrans});
    
    inicializar();
});

function calcularDataFinal(){
    var IdStatus = $('#IdStatus').val();
    var dtInicial = $('#DataInicial').val();
    var dtFinal = '';
    var Anos = 0;
    var AnosRegistro = 1;
    console.log('calcularDataFinal (' + dtInicial + ', ' + AnosRegistro + ')');
    
    if ((IdStatus == '0') || (IdStatus == '1') || (IdStatus == '')){ // Registro, Renovação e Recadastramento
        if($('#DataFinal').val()==''){
            $('#DataFinal').val($('#DataInicial').val());
        }
    }
}

/* JS NORMAIS ************************************************************************************************************************************ */
function carregarLista(tecla){
    
    if(tecla==13){    
        var urlAjax = "interacao.php?controle="+ oModulo.Controle +"&acao=listar";
        urlAjax += "&IdTipoEvento=" + $("#filtroIdTipoEvento").val();
        urlAjax += "&Nome=" + $("#filtroNome").val();
        
        myApp.showPleaseWait();
        if (typeof oTable == 'undefined') {	
            oTable = $('#tabListagem').dataTable({
                "oLanguage": {"sUrl": "assets/js/jquery.dataTables.pt-br.txt"},
                "aaSorting": [[1, 'desc']],
                "aoColumnDefs": [
                    {"aTargets": [0], "bSearchable": false, "bVisible": true, "bSortable" : false, "sWidth": "5%"},
                    {"aTargets": [1], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "10%", "sClass": "text-right" },
                    {"aTargets": [2], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "15%"},
                    {"aTargets": [3], "bSearchable": true,  "bVisible": true, "bSortable" : true  },
                    {"aTargets": [4], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "15%"},
                    {"aTargets": [5], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "10%", "sClass": "text-right" },
                    {"aTargets": [6], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "10%", "sClass": "text-right" },
                    {"aTargets": [7], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "7%"}
                ],
                "bDestroy": true,	        
                "sAjaxSource": urlAjax,
                "bProcessing": false,
                "bServerSide": false,
                "bPaginate": true,
                "bFilter": false,
                "bInfo": true,
                "bSort" : true,
                //"sDom": 'lfrtip',
                //"sDom": 'T<"clear">lfrtip',
                "iDisplayLength": 10
            });
        } else {
            oTable.fnClearTable(0);
            var oSettings = oTable.fnSettings();
            oSettings.sAjaxSource = urlAjax;
            oTable.fnReloadAjax();
        } 
        myApp.hidePleaseWait();
    }
} 

function carregarListaParticipantes(IdEvento, tecla){
    
    if(tecla==13){
        if (!(IdEvento > 0)){
            IdEvento = -1;
        }
        var urlAjax = "interacao.php?controle=EventoParticipante&acao=listar";
        urlAjax += "&IdEvento=" + IdEvento;
            
        myApp.showPleaseWait();
        if (typeof oTable1 == 'undefined') {	
            oTable1 = $('#tabListagemParticipantes').dataTable({
                "oLanguage": {"sUrl": "assets/js/jquery.dataTables.pt-br.txt"},
                "aaSorting": [[1, 'desc']],
                "aoColumnDefs": [
                    {"aTargets": [0], "bSearchable": false, "bVisible": true, "bSortable" : false, "sWidth": "5%"},
                    {"aTargets": [1], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "10%", "sClass": "text-right" },
                    {"aTargets": [2], "bSearchable": true,  "bVisible": true, "bSortable" : true  },
                    {"aTargets": [3], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "20%"}
                ],
                "bDestroy": true,	        
                "sAjaxSource": urlAjax,
                "bProcessing": false,
                "bServerSide": false,
                "bPaginate": true,
                "bFilter": false,
                "bInfo": true,
                "bSort" : true,
                //"sDom": 'lfrtip',
                //"sDom": 'T<"clear">lfrtip',
                "iDisplayLength": 10
            });
        } else {
            oTable1.fnClearTable(0);
            var oSettings = oTable1.fnSettings();
            oSettings.sAjaxSource = urlAjax;
            oTable1.fnReloadAjax();
        } 
        myApp.hidePleaseWait();
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
		}
		
	} else { // acao = incluir e atualizar
        if (($("#IdTipoEvento").val() == '') || ($("#IdTipoEvento").val() == '0')){
			myApp.showAlert('erro', 'O Campo <b>País</b> é de preenchimento obrigatório.');
			return false; 
		} else if (($("#Sigla").val() == '') || ($("#Sigla").val() == '0')){
			myApp.showAlert('erro', 'O Campo <b>Sigla</b> é de preenchimento obrigatório.');
			return false; 
		} else if (($("#Nome").val() == '')){
			myApp.showAlert('erro', 'O Campo <b>Nome</b> é de preenchimento obrigatório.');
			return false; 
		} 	
	}
    myApp.showPleaseWait(); 
}

function preparaForm(acao)
{
    var formCadastro = $("#formCadastro");
    var formTransacao = $("#formTransacao");
    
	if (acao == 'limpar'){				// LIMPAR todos os Campos
        document.getElementById('formCadastro').reset();
        formCadastro.find(':checked').each(function() { // Desmarcar todas as CHECKED
            $(this).attr('checked', false);
        });
		$('#labelId').val('0');
		$('#bt_gravar').attr("disabled", "disabled");
		$("#arqEmpresa").hide();
	
	} else if (acao == 'habilitar'){	// HABILITAR todos os Campos
		formCadastro.find(':disabled').each(function() {
			$(this).removeAttr('disabled');
		});
	
	} else if (acao == 'desabilitar'){ 	// DESABILITAR todos os Campos
		formCadastro.find(':enabled').each(function() {
			$(this).attr("disabled", "disabled");
		});
        // CAMPOS OCULTOS
        $('#controle').removeAttr('disabled');
        $('#acao').removeAttr('disabled');
        $('#Id').removeAttr('disabled');
        $('#DataInicial').val(''); 
        setItemCombo('HoraInicial', 0);
        $('#DataFinal').val(''); 
        setItemCombo('HoraFinal', 0);
        
        // PERMISSÕES DO USUARIO
        $('#bt_cancelar').removeAttr('disabled');
        $('#bt_pesquisar').removeAttr('disabled');
        $('#bt_atualizar').removeAttr('disabled');
        
	} else if (acao == 'listar'){
		preparaForm('limpar');
		$("#boxToolbar").show();
		$("#boxFormulario").hide();
		$("#boxListagem").show();

        // Inicializar Campos
        $("#acao").val(acao);
        
	} else if (acao == 'incluir'){
		preparaForm('limpar');	
		$("#boxToolbar").hide();
		$("#boxFormulario").show();
		$("#boxListagem").hide();
		
		// Inicializar Campos
        $("#acao").val(acao);
		$('#Id').val('0');
		$('#Ativo').val(1);
        $('#IdEmpresa').val(oUsuario.IdEmpresa);
        $('#NomeEmpresa').val(oUsuario.NomeEmpresa);
        $('#IdUsuarioAcao').val(oUsuario.Id);
		
        selecionarParente('IdParente', oUsuario.IdEmpresa, '', 13);
        carregarListaParticipantes(99999999999999999, 13);

    
		// PERMISSÕES DO USUARIO
		preparaForm('habilitar');
		$('#bt_editar').attr("disabled", "disabled");
		$('#bt_excluir').attr("disabled", "disabled");
		if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_gravar').removeAttr('disabled');}}
        $('#bt_add_transacao').attr("disabled", "disabled");
        
	} else if (acao == 'editar'){
		preparaForm('habilitar');

		// Inicializar Campos
        $("#acao").val(acao);
        
		// PERMISSÕES DO USUARIO
		$('#bt_editar').attr("disabled", "disabled");
		$('#bt_excluir').attr("disabled", "disabled");
		if(typeof oModulo.Operacoes.editar!=='undefined'){if(oModulo.Operacoes.editar){$('#bt_gravar').removeAttr('disabled');}}
    
	} else if (acao == 'visualizar'){
		// Inicializar Campos
        $("#acao").val(acao);
        
		$("#boxToolbar").hide();
		$("#boxFormulario").show();
		$("#boxListagem").hide();

		// PERMISSÕES DO USUARIO
		if(typeof oModulo.Operacoes.editar!=='undefined'){if(oModulo.Operacoes.editar){$('#bt_editar').removeAttr('disabled');}}
		if(typeof oModulo.Operacoes.excluir!=='undefined'){if(oModulo.Operacoes.excluir){$('#bt_excluir').removeAttr('disabled');}}
		$('#bt_gravar').attr("disabled", "disabled");
        
        // PERMISSÕES DO USUARIO APRA TRANSACÕES
        if (($("#IdStatus").val()==1) || ($("#IdStatus").val()==2) || ($("#IdStatus").val()==5) || ($("#IdStatus").val()==6)) { // array(0=>'Não definida', 1=>'Cadastrado', 2=>'Confirmado', 3=>'Descontinuado', 4=>'Cancelado', 5=>'Publicado', 6=>'Em Andamento', 7=>'', 8=>'Encerrado', 9=>'Arquivado');
            // Habilitar o Incluir
            if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_add_transacao').removeAttr('disabled');}}
        } 
        if(typeof oModulo.Operacoes.editar!=='undefined'){if(oModulo.Operacoes.editar){$('#bt_relatorio_transacao').removeAttr('disabled');}}
		
	} else if (acao == 'excluir'){
        // Inicializar Campos
        $('#controle').val('Pessoa');
        $("#acao").val(acao);

    } else if (acao == 'limpar-transacao'){

        $("#formTransacao").trigger("reset");
        setTransacao(0);
        
        // Desabilitar
        $('#Observacao1').show();
        $('#Observacao1').attr("disabled", "disabled");
        formTransacao.find(':enabled').each(function() {
            //console.log('Id:'+$(this).attr('Id'));
            $(this).attr("disabled", "disabled");
        });
        //console.log('ok');
        $('#controle1').removeAttr('disabled');
        $('#acao1').removeAttr('disabled');
        //$('#Observacao1').attr("disabled", "disabled");
        
        // Somente leitura
        //$('#IdTransacao').attr('readonly', 'readonly');
        $('#IdTransacao').hide();
        $('#NomeTransacao').hide();
        
        $('#controle1').val('Historico');
        $('#acao1').val('');
        $('#Id1').val(0);
        $('#IdEventoParticipacao1').val(0);
        $('#IdEvento1').val($('#Id').val());
        $('#IdParticipante1').val();
        $('#IdStatus1').val(0);
        $('#boxToolbarTransacao').show();
        $('#boxFormularioTransacao').hide();
        
        // PERMISSÕES DO USUARIO APRA TRANSACÕES
        if (($("#IdStatus").val()==1) || ($("#IdStatus").val()==2) || ($("#IdStatus").val()==5) || ($("#IdStatus").val()==6)) { // array(0=>'Não definida', 1=>'Cadastrado', 2=>'Confirmado', 3=>'Descontinuado', 4=>'Cancelado', 5=>'Publicado', 6=>'Em Andamento', 7=>'', 8=>'Encerrado', 9=>'Arquivado');
            // Habilitar o Incluir
            //if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_add_transacao').removeAttr('disabled');}}
        } 

        $('#bt_fechar_transacao').removeAttr('disabled');
        $('#bt_editar_transacao').attr("disabled", "disabled");
        $('#bt_editar_transacao').hide();
        $('#bt_excluir_transacao').attr("disabled", "disabled");
        $('#bt_excluir_transacao').hide();
        $('#bt_gravar_transacao').attr("disabled", "disabled");
        $('#bt_gravar_transacao').hide();
        $('#bt_autorizar_transacao').attr("disabled", "disabled");
        $('#bt_autorizar_transacao').hide();
        $('#bt_aprovar_transacao').attr("disabled", "disabled");
        $('#bt_aprovar_transacao').hide();
        
    } else if (acao == 'adicionar-transacao'){
        $('#controle1').val('Historico');
        $('#acao1').val('incluir');
        
        // Habilitar
        formTransacao.find(':disabled').each(function() {
            $(this).removeAttr("disabled");
        });
        $('#IdTransacao').show();
        
        $('#boxToolbarTransacao').hide();
        $('#boxFormularioTransacao').show();
        $('#IdTransacao').focus();

        // Todas as Transações
        
        // PERMISSÕES DO USUARIO
        if(typeof mod_operacoes.incluir!=='undefined'){
            if(mod_operacoes.incluir){
                $('#bt_gravar_transacao').removeAttr('disabled');
                $('#bt_gravar_transacao').show();
            }
        } else if(typeof mod_operacoes.editar!=='undefined'){
            if(mod_operacoes.editar){
                $('#bt_gravar_transacao').removeAttr('disabled');
                $('#bt_gravar_transacao').show();
            }
        }

    } else if (acao == 'visualizar-transacao'){
        $('#controle1').val('Historico');
        $('#acao1').val('retornar');

        $('#NomeTransacao').show();
        $('#NomeFederacao1').show();
        $('#NomeEntidade1').show();
        $('#NomeProfissaoNivel1').show();
        
        $('#boxToolbarTransacao').hide();
        $('#boxFormularioTransacao').show();
        
        // PERMISSÕES DO USUARIO
        if(typeof mod_operacoes.editar!=='undefined'){
            if(mod_operacoes.editar){
                if ($('#IdStatus1').val()=='10'){ // Status do Transação ?
                    if ( (oUsuario.IdTipo==1) &&  (oUsuario.IdPerfil==1) ) { // 1:CBV && Perfil=Administrador
                        $('#bt_editar_transacao').removeAttr('disabled');
                        $('#bt_editar_transacao').show();
                    }
                } else {
                    if (oUsuario.IdTipo==1) { // CBV
                        $('#bt_editar_transacao').removeAttr('disabled');
                        $('#bt_editar_transacao').show();
                    } else if (oUsuario.IdTipo==3) { // Federaçoes/Associações
                        if ($('#IdFederacao :selected').val() == oUsuario.IdEmpresa){
                            //$('#bt_editar_transacao').removeAttr('disabled');
                            //$('#bt_editar_transacao').show();
                        }
                    }
                    if ($('#IdStatus').val() == '10'){ // Status da Registro ?
                        if (oUsuario.IdTipo==1) { // CBV
                            $('#bt_excluir_transacao').removeAttr('disabled');
                            $('#bt_excluir_transacao').show();
                        } else if (oUsuario.IdTipo==3) { // Federaçoes/Associações
                            if ($('#IdFederacao :selected').val() == oUsuario.IdEmpresa){
                                //$('#bt_excluir_transacao').removeAttr('disabled');
                                //$('#bt_excluir_transacao').show();
                            }
                        }
                    }                    
                }
            }
        }
        
        if ($('#IdStatus1').val()=='1'){ // 3:Autorização da Federação
            preparaForm('autorizar-transacao');
            
        } else if ($('#IdStatus1').val()=='4'){ // 4:Autorização da COBRAV
            preparaForm('autorizar-transacao');
            
        } else if ($('#IdStatus1').val()=='5'){ // 4:Pendente de Aprovação
            preparaForm('aprovar-transacao');
            
        } else {

        }
        
    } else if (acao == 'editar-transacao'){
        $('#controle1').val('Historico');
        $('#acao1').val('editar');
        
        // Habilitar
        formTransacao.find(':disabled').each(function() {
            $(this).removeAttr("disabled");
        });
        
        $('#IdTransacao').show();
        $('#NomeTransacao').hide();
        $('#IdFederacao1').show();
        $('#NomeFederacao1').hide();
        $('#IdEntidade1').show();
        $('#NomeEntidade1').hide();
        $('#NomeProfissaoNivel1').hide();
        $('#IdProfissaoNivel1').show();
        
        $('#DataTransacao').removeAttr('readonly');
        $('#ValorTarifa').removeAttr('readonly');
        //$('#box-Detalhe1').show();
        
        $('#boxToolbarTransacao').hide();
        $('#boxFormularioTransacao').show();
        
        // PERMISSÕES DO USUARIO
        $('#bt_editar_transacao').attr("disabled", "disabled");
        if(typeof mod_operacoes.editar!=='undefined'){
            if(mod_operacoes.editar){
                $('#bt_gravar_transacao').removeAttr('disabled');
                $('#bt_gravar_transacao').show();
            }
        }
        $('#bt_excluir_transacao').hide();

    } else if (acao == 'excluir-transacao'){
        $('#controle1').val('Historico');
        $('#acao1').val('excluir');

    } else if (acao == 'autorizar-transacao'){
        $('#controle1').val('Historico');
        $('#acao1').val('autorizar');
        
        // Habilitar
        formTransacao.find(':disabled').each(function() {
            $(this).removeAttr("disabled");
        });
        $('#NomeTransacao').show();
        $('#NomeFederacao1').show();
        $('#NomeEntidade1').show();
        $('#NomeProfissaoNivel1').show();
        
        $('#DataInicial').attr("disabled", "disabled");
        $('#DataFinal').attr("disabled", "disabled");
        $('#IdFederacaoCurso1').attr("disabled", "disabled");
        $('#DataCurso1').attr("disabled", "disabled");
        $('#ValorTarifa').attr("disabled", "disabled");
        
        $('#boxToolbarTransacao').hide();
        $('#boxFormularioTransacao').show();
        
        console.log('[IdStatus='+$('#IdStatus1').val()+'] [IdFederacao='+$('#IdFederacao2 :selected').val()+'] ');
        
        // PERMISSÕES DO USUARIO
        if ($('#IdStatus1').val() == '1'){ // Status da Transação = 3:Autorização da Federação
            if(typeof mod_operacoes.editar!=='undefined'){
                if(mod_operacoes.editar){
                    if (oUsuario.IdTipo==1) { // CBV
                        $('#bt_autorizar_transacao').removeAttr('disabled');
                        $('#bt_autorizar_transacao').show();
                        if ($('#IdStatus').val() == '10'){
                            $('#bt_excluir_transacao').removeAttr('disabled');
                            $('#bt_excluir_transacao').show();
                        }
                    } else if (oUsuario.IdTipo==3) { // Federaçoes/Associações
                        if ($('#IdFederacao2 :selected').val() == oUsuario.IdEmpresa) {
                            $('#bt_autorizar_transacao').removeAttr('disabled');
                            $('#bt_autorizar_transacao').show();
                            if ($('#IdStatus').val() == '10'){
                                $('#bt_excluir_transacao').removeAttr('disabled');
                                $('#bt_excluir_transacao').show();
                            }
                        }
                    }
                }
            }
        } else if ($('#IdStatus1').val() == '4'){ // Status da Transação = 4:Autorização da COBRAV
            if(typeof mod_operacoes.autorizar!=='undefined'){
                if(mod_operacoes.autorizar){
                    if (oUsuario.IdTipo==1) { // CBV
                        $('#bt_autorizar_transacao').removeAttr('disabled');
                        $('#bt_autorizar_transacao').show();
                        if ($('#IdStatus').val() == '10'){
                            $('#bt_excluir_transacao').removeAttr('disabled');
                            $('#bt_excluir_transacao').show();
                        }
                    } else if (oUsuario.IdTipo == 2) { // COBRAV
                        $('#bt_autorizar_transacao').removeAttr('disabled');
                        $('#bt_autorizar_transacao').show();
                        if ($('#IdStatus').val() == '10'){
                            $('#bt_excluir_transacao').removeAttr('disabled');
                            $('#bt_excluir_transacao').show();
                        }
                    }
                }
            }
        }
        
    } else if (acao == 'aprovar-transacao'){
        $('#controle1').val('Historico');
        $('#acao1').val('aprovar');
        
        // Habilitar
        formTransacao.find(':disabled').each(function() {
            $(this).removeAttr('disabled');
        });
        $('#NomeTransacao').show();
        $('#NomeFederacao1').show();
        $('#NomeEntidade1').show();
        $('#NomeProfissaoNivel1').show();
        
        $('#DataInicial').attr("disabled", "disabled");
        $('#DataFinal').attr("disabled", "disabled");
        $('#IdFederacaoCurso1').attr("disabled", "disabled");
        $('#DataCurso1').attr("disabled", "disabled");
        $('#ValorTarifa').removeAttr('readonly');
        $('#Detalhe1').attr("disabled", "disabled");
        //$('#Observacao1').attr("disabled", "disabled");
        
        $('#boxToolbarTransacao').hide();
        $('#boxFormularioTransacao').show();
        
        // PERMISSÕES DO USUARIO
        if(typeof mod_operacoes.aprovar!=='undefined'){
            if(mod_operacoes.aprovar){
                if (oUsuario.IdTipo==1) { // CBV
                    $('#bt_aprovar_transacao').removeAttr('disabled');
                    $('#bt_aprovar_transacao').show();
                    if ($('#IdStatus').val() == '10'){
                        $('#bt_excluir_transacao').removeAttr('disabled');
                        $('#bt_excluir_transacao').show();
                    }
                } else if (oUsuario.IdTipo == 2) { // COBRAV
                    $('#bt_aprovar_transacao').removeAttr('disabled');
                    $('#bt_aprovar_transacao').show();
                    if ($('#IdStatus').val() == '10'){
                        $('#bt_excluir_transacao').removeAttr('disabled');
                        $('#bt_excluir_transacao').show();
                    }
                }
            }    
        }
        
    }
    $('#controle').val(oModulo.Controle);
	$("#acao").val(acao);

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
	
	$.getJSON('interacao.php', {controle: oModulo.Controle, acao: "retornar", Id: Id},
	function(data){ 
		if (data.sucesso){
			// Carregar Dados;
			$('#Id').val(data.Id);
		    $('#labelId').val(data.Id);
            //setItemCombo('IdParente', data.IdParente);
            selecionarParente('IdParente', oUsuario.IdEmpresa, data.IdParente, 13);
            setItemCombo('IdTipoEvento', data.IdTipoEvento);
            $('#Capacidade').val(data.IdTipoEvento);
            selecionarLocalizacao('IdLocalizacao', data.IdEmpresa, data.IdLocalizacao, 13);
			$('#Sigla').val(data.Sigla);
			$('#Nome').val(data.Nome);
			$('#Capacidade').val(data.Capacidade);
			$('#DataInicial').val(data.DataInicial);
            setItemCombo('HoraInicial', data.HoraInicial);
            $('#DataFinal').val(data.DataFinal);
            setItemCombo('HoraFinal', data.HoraFinal);
            $('#Observacao').val(data.Observacao);
			
            $('#IdStatus').val(data.IdStatus);
            $('#NomeStatus').val(data.NomeStatus);
			$('#Ativo').val(data.Ativo);
            $('#Revisao').val(data.Revisao);
			$('#IdUsuarioAcao').val(data.IdUsuarioAcao);
			$('#DataAcao').val(data.DataAcao);
			$('#NomeUsuarioAcao').val(data.NomeUsuarioAcao);
			
            carregarListaParticipantes(data.Id, 13);
            
		    preparaForm('visualizar');
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
			message: "Tem certeza que deseja excluir o Registro '" + $('#Nome').val() + "' ?" ,
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
 	var url = "controller.php?gm=dashboard&mod=abertura"; 
	$(location).attr('href',url);
}

function visualizarImpressao()
{
	if ($("#IdLista").val() > 0){
		var url = 'empresa.pdf.php?id=' + $("#Id").val();
		var windowName = "_blank";
		var windowSettings = ''; //'top=50,left=50,width=935,height=550,toolbar=no,location=no,directories=no,scrollbars=yes,status=no,menubar=no,copyhistory=no'; 
		window.open(url, windowName, windowSettings, true);
	}
}

function popularTipoEvento(Ids, tecla){
    var cboNome = 'filtroIdTipoEvento'; 
    var cboNome2 = 'IdTipoEvento'; 
    
    if(tecla==13){
        clearCombo(cboNome);
        addItemCombo(cboNome, '', 'Carregando . . .');
        clearCombo(cboNome2);
        addItemCombo(cboNome2, '', 'Carregando . . .');
        
        $.getJSON('interacao.php', {controle: 'TipoEvento', acao: 'listarCombo'},
            function(data){
                clearCombo(cboNome);
                clearCombo(cboNome2);
                if (data.records > 0){
                    addItemCombo(cboNome, '', '[Todos]');
                    addItemCombo(cboNome2, '', '[Selecione]');
                    for(i=0;i<data.rows.length;i++){
                        addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
                        addItemCombo(cboNome2, data.rows[i].value, data.rows[i].text);
                    }
                    if (Ids){
                        setItemCombo(cboNome, Ids);
                        setItemCombo(cboNome2, Ids);
                    }
                } else {
                    addItemCombo(cboNome, '', '[Não encontrado]');
                    addItemCombo(cboNome2, '', '[Não encontrado]');
                }
            }
        );
    }
}

function IdTipoEvento_onchange(valor, tecla){
    console.log("IdTipoEvento_onchange('" + valor + "', '" + tecla + "');"); 
    if(tecla===13){
           
    }
}

function selecionarParente(cboNome, IdEmpresa, Ids, tecla){ 
    console.log("selecionarParente('" + cboNome + "', '" + IdEmpresa + "', '" + Ids + "', '" + tecla + "');"); 
    if(tecla==13){
        if (IdEmpresa) {
            clearCombo(cboNome);
            addItemCombo(cboNome, '', 'Carregando . . .');
            $.getJSON('interacao.php', {controle: 'Evento', acao: 'listarCombo', IdEmpresa: IdEmpresa, IdStatus: '1,2,4'},
                function(data){
                    clearCombo(cboNome);
                    if (data.records > 0){
                        addItemCombo(cboNome, '', '[Selecione]');
                        for(i=0;i<data.rows.length;i++){
                            addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
                        }
                        if (Ids){ setItemCombo(cboNome, Ids); }
                    } else {
                        addItemCombo(cboNome, '', '[Não encontrado]');
                    }
                }
            );
        } else {
            clearCombo(cboNome);
            addItemCombo(cboNome, '', '[Selecione]');
        }
    }
}


function selecionarLocalizacao(cboNome, IdEmpresa, Ids, tecla){ 
    console.log("selecionarLocalizacao('" + cboNome + "', '" + IdEmpresa + "', '" + Ids + "', '" + tecla + "');"); 
    if(tecla==13){
        if (IdEmpresa) {
            clearCombo(cboNome);
            addItemCombo(cboNome, '', 'Carregando . . .');
            $.getJSON('interacao.php', {controle: 'Localizacao', acao: 'listarCombo', IdEmpresa: IdEmpresa},
                function(data){
                    clearCombo(cboNome);
                    if (data.records > 0){
                        addItemCombo(cboNome, '', '[Selecione]');
                        for(i=0;i<data.rows.length;i++){
                            addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
                        }
                        if (Ids){ setItemCombo(cboNome, Ids); }
                    } else {
                        addItemCombo(cboNome, '', '[Não encontrado]');
                    }
                }
            );
        } else {
            clearCombo(cboNome);
            addItemCombo(cboNome, '', '[Selecione]');
        }
    }
}

function abrirFormTransacao()
{
    if ($('#acao').val() == 'visualizar') {
        myApp.hideMensagem('#boxMensagem');
        preparaForm('limpar-transacao');
        preparaForm('adicionar-transacao');
    }else{
        myApp.showAlert('erro', "Para adicionar uma movimentação você deve estar visualizando um registro.");
    }
}

function visualizarTransacao(IdEventoParticipante) 
{ 
    console.log("visualizarTransacao('" + IdEventoParticipante + "');"); 
    myApp.showPleaseWait();
        
        $.getJSON('interacao.php', {controle: 'EventoParticipante', acao: 'retornar', Id: IdEventoParticipante },
            function(data){ 
                if (data.sucesso){
                    myApp.hideMensagem('#boxMensagem');
                    preparaForm('limpar-transacao');
                    
                    // Carregar Dados;
                    $('#Id1').val(IdEventoParticipante);
                    $('#IdEvento1').val(data.IdEvento);
                    $('#IdParticipante').val(ata.IdParticipante);
                    $('#IdStatus1').val(data.IdStatus);
                    $('#Observacao1').val(data.Observacao);
                    
                    if ((data.IdStatus==1)){
                        
                    } else if ((data.IdTransacao==2)) {
                    
                    } else if ((data.IdTransacao==3)) {
                        
                    } else if ((data.IdTransacao==4)){
                        
                    } else {
                        
                    }
                    setTransacao(data.IdTransacao);
                    
                    console.log("{IdEventoParticipante:"+IdEventoParticipante+", IdEvento="+data.IdParticipante+", IdEvento="+data.IdParticipante+", IdStatus="+data.IdStatus+"}"); 
                    preparaForm('visualizar-transacao');
                    
                } else {
                    myApp.showAlert('erro', data.mensagem);
                }
                myApp.hidePleaseWait();
            }
        );
        
}

function validaFormTrans(formData, jqForm, options) { 
    var acao = $('#acao1').val();
    var IdEvento = $('#IdEvento').val();
    var IdParticipante = $('#IdParticipante').val();
    var IdStatus = parseFloat($('#IdStatus1').val());
    var IdTransacao = parseFloat($('#IdTransacao1').val());

    console.log("validaFormTrans(); [IdEvento="+IdEvento+"][IdParticipante="+IdParticipante+"][IdStatus="+IdStatus+"][IdTransacao="+IdTransacao+"]"); 
    
    myApp.hideMensagem('#boxMensagem');
    
    if (acao == 'excluir-transacao') {
        if ((IdStatus==1)) { // 1:"Socilitação"
            if (!($("#IdParticipante").val() > 0)){
                myApp.showMensagem('#boxMensagem', 'erro', 'Selecione primeiro um registro para poder Excluir.');
                return false; 
            } else if (($('#Observacao1').val() == '') || ($('#Observacao1').val() == '0')){
                myApp.showMensagem('#boxMensagem', 'erro', 'O Campo <b>Observação</b> tem que ser prenenchido com uma Justificativa.');
                return false; 
            }
        } else {
            myApp.showMensagem('#boxMensagem', 'erro', 'Não é possível excluir uma solicitação com status <b>'+IdStatus+'</b>.');
            return false; 
        }
        
    } else if (acao == 'reprovar-transacao') {
        if ((IdStatus==1)) { // 1:"Socilitação"
            if (!($("#IdParticipante").val() > 0)){
                myApp.showMensagem('#boxMensagem', 'erro', 'Selecione primeiro um registro para poder Excluir.');
                return false; 
            } else if (($('#Observacao1').val() == '') || ($('#Observacao1').val() == '0')){
                myApp.showMensagem('#boxMensagem', 'erro', 'O Campo <b>Observação</b> tem que ser prenenchido com uma Justificativa.');
                return false; 
            }
        } else {
            myApp.showMensagem('#boxMensagem', 'erro', 'Não é possível reprovar uma solicitação com status <b>'+IdStatus+'</b>.');
            return false; 
        }
        
    } else if (acao == 'aprovar-transacao') {
        if ((IdStatus==1)) { // 1:"Socilitação"
            if (!($("#IdParticipante").val() > 0)){
                myApp.showMensagem('#boxMensagem', 'erro', 'Selecione primeiro um registro para poder Excluir.');
                return false; 
            }
        } else {
            myApp.showMensagem('#boxMensagem', 'erro', 'Não é possível aprovar uma solicitação com status <b>'+IdStatus+'</b>.');
            return false; 
        }
    } else { // acao = criar e editar
        if ((IdParticipante == '') || (IdParticipante == '0')){
            myApp.showMensagem('#boxMensagem', 'erro', 'O Campo <b>Participante</b> é de preenchimento obrigatório.');
            return false; 
        } else if ((IdEvento == '') || (IdEvento == '0')){
            myApp.showMensagem('#boxMensagem', 'erro', 'É necessário selecionar uma <b>Evento</b> antes de confirmar.');
            return false; 
        }
        
    }
    
    myApp.showPleaseWait(); 
    
}

// post-submit callback 
function showResponseTrans(data) { 

    if (data.sucesso) {
        myApp.showMensagem('#boxMensagem', 'sucesso', data.mensagem);
        
        if ((data.acao == 'autorizar') || (data.acao == 'autorizar-transacao') || (data.acao == 'aprovar') || (data.acao == 'aprovar-transacao')) {
            visualizar($('#Id').val());
        }
        myApp.showMensagem('#boxMensagem', 'sucesso', data.mensagem);
        preparaForm('limpar-transacao');
        mostrarParticipante();
        myApp.hidePleaseWait();
    } else {                
        myApp.hidePleaseWait();
        myApp.showMensagem('#boxMensagem', 'erro', data.mensagem);
    } 
} 

function visualizarTransacao(){

    myApp.hideMensagem('#boxMensagem');
    
    // Preparar Edição do Histórico
    var IdEvento = parseFloat($('#IdEvento :selected').val());
    var IdStatus = parseFloat($('#IdStatus').val());
    
    var IdTransacao = parseFloat($('#IdTransacao').val());
    var IdStatus3 = parseFloat($('#IdStatus1').val());
    
    if(isNaN(IdStatus)){IdStatus='';}
    if(isNaN(IdStatus3)){IdStatus3='';}
    
    console.log("editarTransacao(); [IdIdTransacao="+IdTransacao+"][IdStatus3="+IdStatus3+"][IdTransacao="+IdTransacao+"]"); 

    
    if (oUsuario.IdTipo==1) { // CBV
    
    }
    
    preparaForm('visualizar-transacao');
}

function gravarTransacao(){
    $('#formTransacao').submit();
}

function fecharFormTransacao(){
    preparaForm('limpar-transacao');
}


function excluirTransacao() 
{ 
    if ($('#bt_excluir_transacao').attr('disabled') != 'disabled'){
        myApp.hideMensagem('#boxMensagem');
        bootbox.dialog({
            title: "Confirmação de exclusão de Transação",
            message: "Tem certeza que deseja <span class='red'><b>excluir</b></span> a transação: '" + $("#IdTransacao :selected").text() + "' ?" ,
            buttons: {
                danger: {
                    label: "Confirmar",
                    className: "btn-danger",
                    callback: function() {
                        concluirExclusaoTransacao();
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
        myApp.showMensagem('#boxMensagem', 'erro', 'Você <b>NÃO</b> tem permissão para executar esta operação.');
    }
}

function concluirExclusaoTransacao() 
{ 
    myApp.hideMensagem('#boxMensagem');
    preparaForm('excluir-transacao');
    $('#formTransacao').submit();
}


function autorizarTransacao() 
{ 
    if ($('#bt_autorizar_transacao').attr('disabled') != 'disabled'){
        myApp.hideMensagem('#boxMensagem');
        bootbox.dialog({
            title: "Confirmação de Autorização da Transação",
            message: "Tem certeza que deseja <span class='green'><b>autorizar</b></span> a transação: '" + $("#IdTransacao :selected").text() + "' ?" ,
            buttons: {
                danger: {
                    label: "Confirmar",
                    className: "btn-success",
                    callback: function() {
                        concluirAutorizacaoTransacao();
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
        myApp.showMensagem('#boxMensagem', 'erro', 'Você <b>NÃO</b> tem permissão para executar esta operação.');
    }
}

function concluirAutorizacaoTransacao() 
{ 
    myApp.hideAlert();
    preparaForm('autorizar-transacao');
    $('#formTransacao').submit();
}

function aprovarTransacao() 
{ 
    if ($('#bt_aprovar_transacao').attr('disabled') != 'disabled'){
        myApp.hideMensagem('#boxMensagem');
        bootbox.dialog({
            title: "Confirmação de aprovação da Transação",
            message: "Tem certeza que deseja <span class='green'><b>aprovar</b></span> a transação: '" + $("#IdTransacao :selected").text() + "' ?" ,
            buttons: {
                danger: {
                    label: "Confirmar",
                    className: "btn-success",
                    callback: function() {
                        concluirAprovacaoTransacao();
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
        myApp.showMensagem('#boxMensagem', 'erro', 'Você <b>NÃO</b> tem permissão para executar esta operação.');
    }
}

function concluirAprovacaoTransacao() 
{ 
    myApp.hideAlert();
    $('#formTransacao').submit();
}



function atualizarParticipantes(tecla){ 
    if (tecla==13){
        myApp.showPleaseWait();
        $.getJSON('interacao.php', {controle: 'Evento', acao: 'atualizarParticipantes', IdEmpresa: oUsuario.IdEmpresa, Id: 0},
            function(data){
                if (data.sucesso){
                    myApp.showAlert('sucesso', data.mensagem);
                    preparaForm('listar');
                    carregarLista(13);
                    myApp.hidePleaseWait();
                } else {                
                    myApp.showAlert('erro', data.mensagem);
                    myApp.hidePleaseWait();
                }
            }
        );
    }
}


function setTransacao(IdTransacao){
    IdTransacao = parseFloat(IdTransacao);
    var IdEvento = parseFloat($('#IdEvento').val());
    var IdStatus = parseFloat($('#IdStatus').val());
    var IdParticipante1 = parseFloat($('#IdParticipante1').val());
    var IdStatus1 = parseFloat($('#IdStatus1').val());
    console.log('[setTransacao('+IdTransacao+')[IdEvento='+IdEvento+'][IdStatus='+IdStatus+'][IdParticipante1='+IdParticipante1+'][IdStatus1='+IdStatus1+']');

    // array(0=>'Não definida', 1=>'Pre-Inscrito', 2=>'Confirmada', 3=>'Recusado', 4=>'Cancelada', 5=>'Presente', 6=>'', 7=>'', 8=>'', 9=>'');
    
    //$('#lblDataTransacao').html('Data da Transação:');
    //$('#DataTransacao').attr('readonly', 'readonly');
    //$('#NomeTransacao').val($("#IdTransacao :selected").text());
    
    //myApp.showPleaseWait();
    $('#box-Documento').hide();
    $('#lblDocumento').html('Nº Transação:');
    $('#box-Observacao1').hide();

    if (IdTransacao==1){ // Solicitação
        $('#box-Documento').show();
        $('#lblDocumento').html('Nº da Transferencia:');
        if ((IdStatus==1) || (IdStatus==2) || (IdStatus==5) || (IdStatus==6)) { // array(0=>'Não definida', 1=>'Cadastrado', 2=>'Confirmado', 3=>'Descontinuado', 4=>'Cancelado', 5=>'Publicado', 6=>'Em Andamento', 7=>'', 8=>'Encerrado', 9=>'Arquivado');
            
        } 
        
    } else if (IdTransacao==2){ // Autorizar 
        $('#box-IdFederacao2').show();
        $('#box-DataInicial').show();
        $('#box-DataFinal').show();
        $('#box-Observacao2').show();
        if ((IdProfissao==256) || (IdProfissao==512)) {  $('#box-Curso2').show(); } // Arbitro ou Apontador
        
    } else if (IdTransacao==2){ // Renovação
        $('#box-IdFederacao2').show();
        if (IdProfissao==1) { $('#box-IdEntidade2').show(); }
        $('#box-DataInicial').show();
        $('#box-DataFinal').show();
        $('#box-Observacao2').show();
        if (IdStatus3==10){
            $('#box-NotaOficial').show(); 
        } else if ((IdStatus3==5) && (oUsuario.IdTipo==1)){
            $('#box-NotaOficial').show(); 
        }
    
    } else if (IdTransacao==3){ // Inscrição
        $('#box-IdFederacao2').show();
        $('#box-DataInicial').show();
        $('#box-DataFinal').show();
        $('#box-Observacao2').show();
        if (IdProfissao==1) { $('#box-IdEntidade2').show(); }
        //$('#box-ValorTransacao').show();
        if (IdStatus3==10){
            $('#box-NotaOficial').show(); 
        } else if ((IdStatus3==5) && (oUsuario.IdTipo==1)){
            $('#box-NotaOficial').show(); 
        }
        
    } else if ((IdTransacao==4) || (IdTransacao==5) || (IdTransacao==6)  || (IdTransacao==7)){ // Transferencia ou Cessão Nacional
        
        $('#box-IdFederacao2').show();
        $('#lblIdFederacao2').html('Federação/Associação de Destino:');
        if (IdProfissao==1) { $('#box-IdEntidade2').show(); }
        $('#lblIdEntidade2').html('Entidade de Destino:');
        $('#box-DataInicial').show();
        $('#box-DataFinal').show();
        $('#box-Documento').show();
        $('#lblDocumento').html('Nº da Transferencia:');
        $('#box-Observacao2').show();
        $('#box-ValorTransacao').show();
        if (IdStatus3==10){
            $('#box-NotaOficial').show(); 
        } else if ((IdStatus3==5) && (oUsuario.IdTipo==1)){
            $('#box-NotaOficial').show(); 
        }
        
    } else if ((IdTransacao==9) || (IdTransacao==10) || (IdTransacao==14)){ // Transferencia ou Cessão Internacional
        $('#box-IdFederacao2').show();
        $('#lblIdFederacao2').html('Federação/Associação de Destino:');
        if (IdProfissao==1) { $('#box-IdEntidade2').show(); }
        $('#lblIdEntidade2').html('Entidade de Destino:');
        $('#box-DataInicial').show();
        $('#box-DataFinal').show();
        $('#box-Documento').show();
        $('#lblDocumento').html('Nº da Transferencia:');
        $('#box-Observacao2').show();
        $('#box-ValorTransacao').show();
        if (IdStatus3==10){
            $('#box-NotaOficial').show(); 
        } else if ((IdStatus3==5) && (oUsuario.IdTipo==1)){
            $('#box-NotaOficial').show(); 
        }
                
    } else if ((IdTransacao==18)){ // Transferencia (Treinador Medico)
        $('#box-IdFederacao2').show();
        $('#lblIdFederacao2').html('Federação/Associação de Destino:');
        //$('#box-IdEntidade2').show();
        $('#box-DataInicial').show();
        $('#box-DataFinal').show();
        $('#box-Observacao2').show();
        if (IdProfissao==2){
            $('#box-ValorTransacao').show();
        }
        if (IdStatus3==10){
            $('#box-NotaOficial').show(); 
        } else if ((IdStatus3==5) && (oUsuario.IdTipo==1)){
            $('#box-NotaOficial').show(); 
        }
    
    } else if ((IdTransacao==32) ){ // 32: Penalidade
        $('#lblDataTransacao').html('Data da Penalidade:');
        $('#DataTransacao').removeAttr('readonly');
        $('#box-Detalhe2').show();
        $('#box-Observacao2').show();
        if (IdStatus3==10){
            $('#box-NotaOficial').show(); 
        } else if ((IdStatus3==5) && (oUsuario.IdTipo==1)){
            $('#box-NotaOficial').show(); 
        }
    
    } else if ((IdTransacao==34) || (IdTransacao==35) || (IdTransacao==36) || (IdTransacao==37)){ // 34:Recadastramento, Transferencia de Arbitro e //  Recadastramento de Arb. / Apont.
        if ((IdTransacao==34) || (IdTransacao==35) || (IdTransacao==37)){
            $('#box-IdFederacao2').show();
            $('#lblIdFederacao2').html('Federação/Associação de Destino:');
        }
        //$('#box-IdEntidade2').show();
        $('#box-DataInicial').show();
        $('#box-DataFinal').show();
        $('#box-Observacao2').show();
        if (IdStatus3==10){
            $('#box-NotaOficial').show(); 
        } else if ((IdStatus3==5) && (oUsuario.IdTipo==1)){
            $('#box-NotaOficial').show(); 
        }
        
        if ((IdTransacao==34) || (IdTransacao==36) || (IdTransacao==37)){ // 34: Recada. de Técnico; 36:Promoção de Arb./Apont; 37:Recadastramento de Arb. / Apont;
            $('#box-IdProfissaoNivel2').show(); 
            if ((IdProfissao==256) || (IdProfissao==512)) { // Arbitro e Apontador
                $('#box-Curso2').show(); 
            } 
        } 
    
    } else if ((IdTransacao==38) || (IdTransacao==40)){ // Cancelamento
        $('#box-DataFinal').show();
        $('#box-Observacao2').show();
        if (IdStatus3==10){
            $('#box-NotaOficial').show(); 
        } else if ((IdStatus3==5) && (oUsuario.IdTipo==1)){
            $('#box-NotaOficial').show(); 
        }
    
    } else {
        if (IdTransacao){
            // 31:Resultado de Competicao, e outros...
            $('#box-Detalhe2').show();
            $('#box-Observacao2').show();
        }
    }
    if (IdTransacao){
        $('#box-Valor').show();
    }
    
}

function inicializar()
{
    popularTipoEvento('', 13);
    
    selecionarParente('IdParente', oUsuario.IdEmpresa, '', 13);
    selecionarLocalizacao('IdLocalizacao', oUsuario.IdEmpresa, '', 13);
    
	carregarLista(13);
    
	// PERMISSÕES DO USUARIO
	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}
    $('#bt_pesquisar').removeAttr('disabled');
    $('#bt_atualizar').removeAttr('disabled');
	
}

</script>