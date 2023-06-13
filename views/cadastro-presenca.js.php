<script type="text/javascript">
//var oTable1;

/* JS JQUERY ************************************************************************************************************************************ */
jQuery(document).ready(function(){ 
    
	/* JQUERY.FORM ****************************************************************************************************************************** */
    $("#formPesquisa").ajaxForm({type: 'POST', dataType: 'json', url: 'interacao.php', success: showResponse});   
	$("#formTransacao").ajaxForm({type: 'POST', dataType: 'json', url: 'interacao.php', success: showResponseTrans});	

    $('#boxDialogObservacao').hide();
    
    $('#dialogPadrao').on('hidden.bs.modal', function (e) {
        console.log('#dialogPadrao->hidden');
        $("#dialogControle").val('');
        $("#dialogAcao").val('');
        $("#dialogId").val('');
        $("#dialogObservacao").val('');
    });
    
    $("#dialogButtonConfirmar").click(function(){
        myApp.hideMensagem('#boxDialogMensagem');
        var acao = $('#dialogAcao').val();
        console.log('#dialogButtonConfirmar->'+acao);
        
        myApp.hideAlert();
        $('#acao1').val(acao);
        $("#dialogPadrao").modal('hide');
        $('#formTransacao').submit();
            
    });
	
    $("#dialogButtonCancelar").click(function(){
		window.location.reload();       
    });	
	
   
    inicializar();
});

/* JS NORMAIS ************************************************************************************************************************************ */

function showResponseTrans(data) { 

    if (data.sucesso) {
        //myApp.showMensagem('#boxMensagem', 'sucesso', data.mensagem);      
        myApp.hidePleaseWait();
    } else {                
        myApp.hidePleaseWait();
        myApp.showMensagem('#boxMensagem', 'erro', data.mensagem);
    } 
} 

function inicializar()
{  
	//Apresentar somente o evento atual para marcar presença
	//popularEvento('filtroIdEventoPrincipal', oUsuario.IdEmpresa, 3, 13); //passar o evento
  
	carregarLista(13);
    
	// PERMISSÕES DO USUARIO
	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}
    $('#bt_pesquisar').removeAttr('disabled');
    $('#bt_atualizar').removeAttr('disabled');
	$('#bt_listaPresenca').removeAttr('disabled');
    
}

//A princípio não será necessária, só no caso de mais de um evento principal 
function popularEventoPrincipal(Ids, tecla){
    var cboNome = 'filtroIdEventoPrincipal'; 
    var cboNome2 = 'IdEvento'; 
    
    if(tecla==13){
        clearCombo(cboNome);
        addItemCombo(cboNome, '', 'Carregando . . .');
        clearCombo(cboNome2);
        addItemCombo(cboNome2, '', 'Carregando . . .');
        
        $.getJSON('interacao.php', {controle: 'Evento', acao: 'listarCombo'},
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

//A princípio não será necessária, só no caso separar os eventos em dias de apresentação 
function popularEvento(Ids, tecla){
    var cboNome = 'filtroIdEvento'; 
    var cboNome2 = 'IdEvento'; 
    
    if(tecla==13){
        clearCombo(cboNome);
        addItemCombo(cboNome, '', 'Carregando . . .');
        clearCombo(cboNome2);
        addItemCombo(cboNome2, '', 'Carregando . . .');
        
        $.getJSON('interacao.php', {controle: 'Evento', acao: 'listarCombo'},
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

function carregarLista(tecla){ 
    
    if(tecla==13){    
		var urlAjax = "interacao.php?controle=EventoParticipante&acao=listarPresenca";
        //urlAjax += "&IdTipoEvento=" + $("#filtroIdTipoEvento").val();
		urlAjax += "&IdEvento=" + $("#filtroIdEventoPrincipal").val();
        urlAjax += "&Nome=" + $("#filtroParticipante").val();
		urlAjax += "&IdStatus=" + $("#filtroIdStatus").val();
		urlAjax += "&visao=" + oModulo.Visao;
        
        myApp.showPleaseWait();
        if (typeof oTable == 'undefined') {	
            oTable = $('#tabListagem').dataTable({
                "oLanguage": {"sUrl": "assets/js/jquery.dataTables.pt-br.txt"},
                "aaSorting": [[1, 'asc']],
                "aoColumnDefs": [
					//{"aTargets": [0], "bSearchable": false, "bVisible": false, "bSortable" : false, "sWidth": "3%", "sClass": "text-center"},
                    {"aTargets": [0], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "3%", "sClass": "text-right"},
                    {"aTargets": [1], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "10%"},
                    {"aTargets": [2], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "25%"},
                    {"aTargets": [3], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "10%"},
					{"aTargets": [4], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "5%"},
                    {"aTargets": [5], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "5%"},
                    {"aTargets": [6], "bSearchable": true,  "bVisible": true, "bSortable" : false, "sWidth": "3%", "sClass": "text-center"}
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

function atualizarParticipantes(tecla){ 
	window.location.reload();
}

//mandar executar o controle do evento-presenca e utilizar neste controle a DAO EventoPresenca para incluir ou atualizar uma presença
function marcarPresenca(IdParticipante, IdEvento)
{  
	$.getJSON('interacao.php', {controle: 'EventoPresenca', acao: "retornar", IdParticipante: IdParticipante, IdEvento: IdEvento}, function(data){ 
		if (data.sucesso){ // existe um registro de presença
			IdEventoPresenca = data.Id;
			NomeParticipante = data.NomeParticipante;
			Presenca = data.Deletado;
			if (Presenca == 0){ //está marcado, deve ser desmarcado
				Presenca = 1;	//deletado, faltou
			}else{
				Presenca = 0;   //presente
			}	
			editarPresenca(IdEventoPresenca, Presenca, IdParticipante, NomeParticipante);
		} else {  
			$.getJSON('interacao.php', {controle: 'EventoParticipante', acao: "retornarParaPresenca", IdParticipante: IdParticipante, IdEvento: IdEvento}, function(data){
			if (data.sucesso){
				NomeParticipante = data.NomeParticipante;	
				incluirPresenca(IdParticipante, IdEvento, NomeParticipante);
			}
			});
		}
		myApp.hidePleaseWait();
		myApp.goTop();
	});	
}

function editarPresenca(IdEventoPresenca, Presenca, IdParticipante, NomeParticipante){

	$("#controle1").val('EventoPresenca');
	$("#acao1").val('editar');
	$("#Id1").val(IdEventoPresenca);
	$("#Situacao1").val(Presenca);	
	myApp.hideMensagem('#boxMensagem');
	$('#dialogAcao').val('editar');

	if ($('#opcaoPresenca_'+IdParticipante).is(':checked')){
        $('#dialogSubtitulo').html("Participante: <b>" + IdParticipante + " - "+NomeParticipante+"</b><br>Tem certeza que deseja <span class='green'><b>MARCAR</b></span> essa presença ?");
    }else{
		$('#dialogSubtitulo').html("Participante: <b>" + IdParticipante + " - "+NomeParticipante+"</b><br>Tem certeza que deseja <span class='red'><b>DESMARCAR</b></span> essa presença ?");
	}
	
    $('#dialogPadrao').modal('show');		

}

function incluirPresenca(IdParticipante, IdEvento, NomeParticipante){

	$("#controle1").val('EventoPresenca');
	$("#acao1").val('incluir');
	$("#IdEvento1").val(IdEvento);    
	$("#IdParticipante1").val(IdParticipante); 
	myApp.hideMensagem('#boxMensagem');
	$('#dialogAcao').val('incluir');
	
	if ($('#opcaoPresenca_'+IdParticipante).is(':checked')){
        $('#dialogSubtitulo').html("Participante: <b>" + IdParticipante + " - "+NomeParticipante+"</b><br>Tem certeza que deseja <span class='green'><b>MARCAR</b></span> essa presença ?");
    }else{
		$('#dialogSubtitulo').html("Participante: <b>" + IdParticipante + " - "+NomeParticipante+"</b><br>Tem certeza que deseja <span class='red'><b>DESMARCAR</b></span> essa presença ?");
	}		

	$('#dialogPadrao').modal('show');		

}

function emitirCredencial(Id){   //não será utilizado para o ano de 2017

	var urlReport = "interacao.php?controle="+oModulo.Controle;
		urlReport += "&acao=emitirCredencial";
		urlReport += "&Id=" + Id;

	var windowName = "_blank";
    var windowSettings = ''; //'top=50,left=50,width=935,height=550,toolbar=no,location=no,directories=no,scrollbars=yes,status=no,menubar=no,copyhistory=no'; 
    window.open(urlReport, windowName, windowSettings, true);

}

function carregarRelatorioTransacao(formato, tecla){     

    if (tecla=13){ 
        myApp.hideAlert();
        //$('#boxGrafico').hide();    
        
        var oTable1 = $('#tabListagem').DataTable();
        var order = oTable1.order();
            
        var urlReport = 'interacao.php';
        var sidx = order[0][0];
        var sord = order[0][1];

        console.log("carregarRelatorioTransacao('"+formato+"', '"+tecla+"'); {controle: 'EventoParticipante', acao:'relatorio', IdEmpresa:'"+oUsuario.IdEmpresa+"', IdEvento:'"+$("#IdEvento1").val()+"', IdStatus:'"+$("#filtroIdStatus").val()+"', Nome:'"+$("#filtroParticipante").val()+"'}");
        myApp.showPleaseWait();
        
        if (formato == 'grafico'){
            myApp.showAlert('erro', 'Tipo de relatório não definido.');
            myApp.hidePleaseWait();
            return false;
            
        } else if ((formato == 'excel') || (formato == 'pdf')) {
        
            var urlReport = "interacao.php?controle=EventoParticipante";
            urlReport += "&acao=relatorio";
            urlReport += "&formato=" + formato;
            urlReport += "&sidx=" + sidx;
            urlReport += "&sord=" + sord;
            urlReport += "&IdEmpresa=" + oUsuario.IdEmpresa;
            urlReport += "&IdEvento=" + $("#filtroIdEventoPrincipal").val();
            urlReport += "&IdStatus=" + $("#filtroIdStatus").val();
            urlReport += "&Nome=" + $('#filtroParticipante').val();
            
            var windowName = "_blank";
            var windowSettings = ''; //'top=50,left=50,width=935,height=550,toolbar=no,location=no,directories=no,scrollbars=yes,status=no,menubar=no,copyhistory=no'; 
            window.open(urlReport, windowName, windowSettings, true);
            
            myApp.showAlert('alerta', 'Relatório aberto em outra janela.');
            myApp.hidePleaseWait();

        } else {
            myApp.showAlert('erro', 'Tipo de relatório não definido.');
            myApp.hidePleaseWait();
            return false;
        }
    
    }
} 











/*  As funções abaixo deverão ser avaliadas
    verificando a real necessidade, pois foram
	aproveitadas do cadastro-evento.js.php
	
	Kellen Nery
	23/03/2017
*/
function carregarListaParticipantes(tecla){
    
    if(tecla==13){ 
        
        var IdEvento = parseFloat($('#Id').val());
        if (!(IdEvento > 0)){
            IdEvento = -1;
        }
        
        var urlAjax = "interacao.php?controle=EventoParticipante&acao=listar";
        urlAjax += "&IdEvento=" + IdEvento;
        urlAjax += "&IdStatus=" + $("#filtroIdStatus2").val();
        urlAjax += "&Nome=" + $("#filtroNome2").val();
        
        myApp.showPleaseWait();
        if (typeof oTable1 == 'undefined') {	
            oTable1 = $('#tabListagemParticipantes').dataTable({
                "oLanguage": {"sUrl": "assets/js/jquery.dataTables.pt-br.txt"},
                "aaSorting": [[4, 'asc']],
                "aoColumnDefs": [
                    {"aTargets": [0], "bSearchable": false, "bVisible": true, "bSortable" : false, "sWidth": "3%"},
                    {"aTargets": [1], "bSearchable": true,  "bVisible": false, "bSortable" : true},
                    {"aTargets": [2], "bSearchable": true,  "bVisible": false, "bSortable" : true},
                    {"aTargets": [3], "bSearchable": true,  "bVisible": false, "bSortable" : true},
                    {"aTargets": [4], "bSearchable": true,  "bVisible": false, "bSortable" : true},
                    {"aTargets": [5], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "10%", "sClass": "text-right" },
                    {"aTargets": [6], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "25%"},
                    {"aTargets": [7], "bSearchable": true,  "bVisible": false, "bSortable" : true},
                    {"aTargets": [8], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "15%"},
					{"aTargets": [9], "bSearchable": false,  "bVisible": false, "bSortable" : false},
					{"aTargets": [10], "bSearchable": false,  "bVisible": false, "bSortable" : false},
					{"aTargets": [11], "bSearchable": false,  "bVisible": false, "bSortable" : false},
					{"aTargets": [12], "bSearchable": false,  "bVisible": true, "bSortable" : false, "sWidth": "5%"}
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


function carregarRelatorio(formato, tecla){    

    if (tecla=13){
        myApp.hideAlert();
        //$('#boxGrafico').hide();    
        
        var oTable = $('#tabListagem').DataTable();
        var order = oTable.order();
            
        var urlReport = 'interacao.php';
        var sidx = order[0][0];
        var sord = order[0][1];

        console.log("carregarRelatorio('"+formato+"', '"+tecla+"'); {acao:'relatorio', IdEmpresa:'"+oUsuario.IdEmpresa+"', IdTipoEvento:'"+$("#filtroIdTipoEvento").val()+"', Nome:'"+$("#filtroNome").val()+"'}");
        myApp.showPleaseWait();
        
        if (formato == 'grafico'){
            myApp.showAlert('erro', 'Tipo de relatório não definido.');
            myApp.hidePleaseWait();
            return false;
            
        } else if ((formato == 'excel') || (formato == 'pdf')) {
        
            var urlReport = "interacao.php?controle="+oModulo.Controle;
            urlReport += "&acao=relatorio";
            urlReport += "&formato=" + formato;
            urlReport += "&sidx=" + sidx;
            urlReport += "&sord=" + sord;
            urlReport += "&IdEmpresa=" + oUsuario.IdEmpresa;
            urlReport += "&IdTipoEvento=" + $("#filtroIdTipoEvento").val();
            urlReport += "&Nome=" + $('#filtroNome').val();
            
            var windowName = "_blank";
            var windowSettings = ''; //'top=50,left=50,width=935,height=550,toolbar=no,location=no,directories=no,scrollbars=yes,status=no,menubar=no,copyhistory=no'; 
            window.open(urlReport, windowName, windowSettings, true);
            
            myApp.showAlert('alerta', 'Relatório aberto em outra janela.');
            myApp.hidePleaseWait();

        } else {
            myApp.showAlert('erro', 'Tipo de relatório não definido.');
            myApp.hidePleaseWait();
            return false;
        }
    
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

function validaFormDialog(formData, jqForm, options)
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


function preparaForm(acao){ 

    console.log("preparaForm('"+ acao +"');");

    var formCadastro = $("#formCadastro");
    var formTransacao = $("#formTransacao");
    
	if (acao == 'limpar'){			// LIMPAR todos os Campos
        document.getElementById('formCadastro').reset();
        formCadastro.find(':checked').each(function() { // Desmarcar todas as CHECKED
            $(this).attr('checked', false);
        });
		$('#labelId').val('0');
		$('#bt_gravar').attr("disabled", "disabled");
		$("#arqEmpresa").hide();
        
        // Limpar Dialog
        $("#dialogControle").val('');
        $("#dialogAcao").val('');
        $("#dialogId").val('');
        $("#boxDialogObservacao").val('');
        
        fecharFormTransacao();
	
	} else if (acao == 'habilitar'){	// HABILITAR todos os Campos
		formCadastro.find(':disabled').each(function() {
			$(this).removeAttr('disabled');
		});
	
	} else if (acao == 'desabilitar'){ // DESABILITAR todos os Campos
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
        carregarListaParticipantes(13);

    
		// PERMISSÕES DO USUARIO
		preparaForm('habilitar');
		$('#bt_editar').attr("disabled", "disabled");
		$('#bt_excluir').attr("disabled", "disabled");
		if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_gravar').removeAttr('disabled');}}
        $('#bt_add_transacao').attr("disabled", "disabled");
        $('#bt_add_transacao').hide();
        
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
            //if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_add_transacao').removeAttr('disabled');}}
        } 
        if(typeof oModulo.Operacoes.editar!=='undefined'){if(oModulo.Operacoes.editar){
            $('#bt_pesquisar2').removeAttr('disabled');
            $('#bt_relatorio_transacao').removeAttr('disabled');
        }}
		
	} else if (acao == 'excluir'){
        // Inicializar Campos
        $('#controle').val('Pessoa');
        $("#acao").val(acao);

    } else if (acao == 'limpar-transacao'){ 

        $("#formTransacao").trigger("reset");
        setTransacao(0);
        
        // Desabilitar
        formTransacao.find(':enabled').each(function() {
            $(this).attr("disabled", "disabled");
        });
        $('#controle1').removeAttr('disabled');
        $('#acao1').removeAttr('disabled');
        $('#Observacao1').removeAttr('disabled');
        $('#Id1').removeAttr('disabled');
        $('#IdEvento1').removeAttr('disabled');
        $('#IdParticipante1').removeAttr('disabled');
        $('#IdStatus1').removeAttr('disabled');
        
        // Somente leitura
        //$('#IdTransacao').attr('readonly', 'readonly');
        
        $('#controle1').val('EventoParticipante');
        $('#acao1').val('');
        $('#Id1').val(0);
        $('#IdTransacao').hide();
        $('#NomeTransacao').hide();
        $('#IdEventoParticipacao1').val(0);
        $('#IdEvento1').val($('#Id').val());
        $('#boxDocumento1').hide();
        $('#boxDetalhe1').hide();
        $('#boxObservacao1').hide();
        $('#boxAprovacao1').hide();
        
        // Limpar Dialog
        $("#dialogControle").val('');
        $("#dialogAcao").val('');
        $("#dialogId").val('');
        $("#boxDialogObservacao").val('');
        
        $('#boxToolbarTransacao').show();
        $('#boxFormularioTransacao').hide();
        
        // PERMISSÕES DO USUARIO APRA TRANSACÕES
        $('#bt_add_transacao').attr("disabled", "disabled");
        $('#bt_add_transacao').hide();
        $('#bt_fechar_transacao').removeAttr('disabled');
        $('#bt_editar_transacao').attr("disabled", "disabled");
        $('#bt_editar_transacao').hide();
        $('#bt_excluir_transacao').attr("disabled", "disabled");
        $('#bt_excluir_transacao').hide();
        $('#bt_gravar_transacao').attr("disabled", "disabled");
        $('#bt_gravar_transacao').hide();
        $('#bt_autorizar_transacao').attr("disabled", "disabled");
        $('#bt_autorizar_transacao').hide();
        $('#bt_reprovar_transacao').attr("disabled", "disabled");
        $('#bt_reprovar_transacao').hide();
        $('#bt_aprovar_transacao').attr("disabled", "disabled");
        $('#bt_aprovar_transacao').hide();
        $('#bt_comunicar_transacao').attr("disabled", "disabled");
        $('#bt_comunicar_transacao').hide();
        $('#bt_confirmar_transacao').attr("disabled", "disabled");
        $('#bt_confirmar_transacao').hide();
        
    } else if (acao == 'adicionar-transacao'){
        $('#controle1').val('EventoParticipante');
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
        if(typeof oModulo.Operacoes.incluir!=='undefined'){
            if(oModulo.Operacoes.incluir){
                $('#bt_gravar_transacao').removeAttr('disabled');
                $('#bt_gravar_transacao').show();
            }
        } else if(typeof oModulo.Operacoes.editar!=='undefined'){
            if(oModulo.Operacoes.editar){
                $('#bt_gravar_transacao').removeAttr('disabled');
                $('#bt_gravar_transacao').show();
            }
        }

    } else if (acao == 'visualizar-transacao'){
        $('#controle1').val('EventoParticipante');
        $('#acao1').val('retornar');

        $('#NomeTransacao').show();
        $('#NomeFederacao1').show();
        $('#NomeEntidade1').show();
        $('#NomeProfissaoNivel1').show();
        
        $('#boxToolbarTransacao').hide();
        $('#boxFormularioTransacao').show();
        
        // PERMISSÕES DO USUARIO
        if(typeof oModulo.Operacoes.editar!=='undefined'){
            if(oModulo.Operacoes.editar){
                if (($("#IdStatus").val()==1) || ($("#IdStatus").val()==2) || ($("#IdStatus").val()==5) || ($("#IdStatus").val()==6)) { // Evento.IdStatus = array(0=>'Não definida', 1=>'Cadastrado', 2=>'Confirmado', 3=>'Descontinuado', 4=>'Cancelado', 5=>'Publicado', 6=>'Em Andamento', 7=>'', 8=>'Encerrado', 9=>'Arquivado');
                    if (($("#IdStatus1").val()==1)) { // 1:Pre-Inscrito 
                        //preparaForm('editar-transacao');
                        preparaForm('aprovar-transacao');
                    } else {
                        
                    }
                }
                if (($("#IdStatus1").val()==6) || ($("#IdStatus1").val()==8)) { // Evento.IdStatus = array(0=>'Não definida', 1=>'Cadastrado', 2=>'Confirmado', 3=>'Descontinuado', 4=>'Cancelado', 5=>'Publicado', 6=>'Em Andamento', 7=>'', 8=>'Encerrado', 9=>'Arquivado');
                    if (($("#IdStatus1").val()==2)) { // 2: Confirmada
                        preparaForm('confirmar-transacao');
                    } else {
                        
                    }
                }
                
            }
        }
        if(typeof oModulo.Operacoes.aprovar!=='undefined'){
            if(oModulo.Operacoes.aprovar){
                if (($("#IdStatus").val()==5) || ($("#IdStatus").val()==6)) {
                    if ($('#IdStatus1').val()=='1'){ // 1:Pre-Inscrito 
                        preparaForm('aprovar-transacao');
                    }
                }
            }
        }
        
    } else if (acao == 'editar-transacao'){
        $('#controle1').val('EventoParticipante');
        $('#acao1').val('editar');
        
        // Habilitar
        formTransacao.find(':disabled').each(function() {
            $(this).removeAttr("disabled");
        });
        
        $('#IdTransacao').show();
        $('#NomeTransacao').hide();
        $('#DataTransacao').removeAttr('readonly');
        $('#ValorTarifa').removeAttr('readonly');
        //$('#box-Detalhe1').show();
        
        $('#boxToolbarTransacao').hide();
        $('#boxFormularioTransacao').show();
        
        // PERMISSÕES DO USUARIO
        $('#bt_editar_transacao').attr("disabled", "disabled");
        if(typeof oModulo.Operacoes.editar!=='undefined'){
            if(oModulo.Operacoes.editar){
                $('#bt_gravar_transacao').removeAttr('disabled');
                $('#bt_gravar_transacao').show();
            }
        }
        $('#bt_excluir_transacao').hide();

    } else if (acao == 'excluir-transacao'){
        $('#controle1').val('EventoParticipante');
        $('#acao1').val('excluir');

    } else if (acao == 'autorizar-transacao'){
        $('#controle1').val('EventoParticipante');
        $('#acao1').val('autorizar');
        
        // Habilitar
        formTransacao.find(':disabled').each(function() {
            $(this).removeAttr("disabled");
        });
        $('#NomeTransacao').show();
        
        $('#boxToolbarTransacao').hide();
        $('#boxFormularioTransacao').show();
        
        console.log('[IdStatus='+$('#IdStatus1').val()+'] [IdFederacao='+$('#IdFederacao2 :selected').val()+'] ');
        
        // PERMISSÕES DO USUARIO
        
    } else if (acao == 'aprovar-transacao'){
        $('#controle1').val('EventoParticipante');
        $('#acao1').val('aprovar');
        
        // Habilitar
        $('#NomeTransacao').show();
        
        $('#boxToolbarTransacao').hide();
        $('#boxFormularioTransacao').show();
        
        // PERMISSÕES DO USUARIO
        if(typeof oModulo.Operacoes.aprovar!=='undefined'){
            if(oModulo.Operacoes.aprovar){
                if ($('#Capacidade').val() > $('#Aprovados').val()){
                    $('#bt_aprovar_transacao').removeAttr('disabled');
                } else {
                    myApp.showMensagem('#boxMensagem', 'alerta', 'Evento com a capacidade esgotada.');
                }
                $('#bt_aprovar_transacao').show();
                $('#bt_reprovar_transacao').removeAttr('disabled');
                $('#bt_reprovar_transacao').show();
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
            selecionarLocalizacao('IdLocalizacao', data.IdEmpresa, data.IdLocalizacao, 13);
			$('#Sigla').val(data.Sigla);
			$('#Nome').val(data.Nome);
			$('#Capacidade').val(data.Capacidade);
			$('#CargaHoraria').val(data.CargaHoraria);
			$('#DataInicial').val(data.DataInicial);
            setItemCombo('HoraInicial', data.HoraInicial);
            $('#DataFinal').val(data.DataFinal);
            setItemCombo('HoraFinal', data.HoraFinal);
            $('#TextoCertificado').val(data.TextoCertificado);
            $('#Observacao').val(data.Observacao);
			
            $('#Solicitacoes').val(data.Solicitacoes);
            $('#Aprovados').val(data.Aprovados);
            $('#Reprovados').val(data.Reprovados);
            $('#Presentes').val(data.Presentes);
            
            $('#IdStatus').val(data.IdStatus);
            $('#NomeStatus').val(data.NomeStatus);
			$('#Ativo').val(data.Ativo);
            $('#Revisao').val(data.Revisao);
			$('#IdUsuarioAcao').val(data.IdUsuarioAcao);
			$('#DataAcao').val(data.DataAcao);
			$('#NomeUsuarioAcao').val(data.NomeUsuarioAcao);
			
            carregarListaParticipantes(13);
            
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



function IdTipoEvento_onchange(valor, tecla){
    console.log("IdTipoEvento_onchange('" + valor + "', '" + tecla + "');"); 
    if(tecla===13){
           
    }
}

function popularEvento(cboNome, IdEmpresa, Ids, tecla){ 
    console.log("selecionarParente('" + cboNome + "', '" + IdEmpresa + "', '" + Ids + "', '" + tecla + "');"); 
    if(tecla==13){
        if (IdEmpresa) {
            clearCombo(cboNome);
            addItemCombo(cboNome, '', 'Carregando . . .');
            $.getJSON('interacao.php', {controle: 'Evento', acao: 'listarCombo', IdEmpresa: IdEmpresa, IdStatus: '1,2,5'},
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

function visualizarTransacao(IdEventoParticipante){ 
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
                    $('#IdParticipante1').val(data.IdParticipante);
                    $('#lblDetalhe1').html('Nome:');
                    $('#Detalhe1').val(data.NomeParticipante);
                    
                    $('#DataAcao1').val(data.DataAcao);
                    $('#IdStatus1').val(data.IdStatus);
                    $('#NomeStatus1').val(data.NomeStatus);
                    $('#Observacao1').val(data.Observacao);
                    
                    $('#Documento1').val(data.IdParticipante);
                    $('#DataTransacao1').val(data.DataCadastro);
                    
                    $('#DataAprovacao1').val(data.DataAprovacao);
                    $('#IdUsuarioAprovacao1').val(data.IdUsuarioAprovacao);
                    $('#NomeUsuarioAprovacao1').val(data.NomeUsuarioAprovacao);
                    
                    setTransacao(data.IdStatus);
                    
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

function gravarTransacao(){
    $('#formTransacao').submit();
}

function fecharFormTransacao(){
    preparaForm('limpar-transacao');
}


function excluirTransacao(){ 
    if ($('#bt_excluir_transacao').attr('disabled') != 'disabled'){
        myApp.hideMensagem('#boxMensagem');
        $('#dialogAcao').val('excluir');
        $('#dialogSubtitulo').html("Tem certeza que deseja <span class='green'><b>AUTORIZAR</b></span> a inscrição: <em><b>" + $("#Documento1").val() + " - " + $("#Detalhe1").val() + "</b></em> ?");
        $('#boxDialogObservacao').show();
        $('#dialogPadrao').modal('show');
        
    } else {
        myApp.showMensagem('#boxMensagem', 'erro', 'Você <b>NÃO</b> tem permissão para executar esta operação.');
    }
}

function autorizarTransacao(){ 
    if ($('#bt_autorizar_transacao').attr('disabled') != 'disabled'){
        myApp.hideMensagem('#boxMensagem');
        $('#dialogAcao').val('autorizar');
        $('#dialogSubtitulo').html("Tem certeza que deseja <span class='green'><b>AUTORIZAR</b></span> a inscrição: <em><b>" + $("#Documento1").val() + " - " + $("#Detalhe1").val() + "</b></em> ?");
        $('#boxDialogObservacao').hide();
        $('#dialogPadrao').modal('show');
        
    } else {
        myApp.showMensagem('#boxMensagem', 'erro', 'Você <b>NÃO</b> tem permissão para executar esta operação.');
    }
}

function aprovarTransacao(){ 
    if ($('#bt_aprovar_transacao').attr('disabled') != 'disabled'){
        myApp.hideMensagem('#boxMensagem');
        $('#dialogAcao').val('aprovar');
        $('#dialogSubtitulo').html("Tem certeza que deseja <span class='green'><b>APROVAR</b></span> a inscrição: <em><b>" + $("#Documento1").val() + " - " + $("#Detalhe1").val() + "</b></em> ?");
        $('#boxDialogObservacao').hide();
        $('#dialogPadrao').modal('show');

    } else {
        myApp.showMensagem('#boxMensagem', 'erro', 'Você <b>NÃO</b> tem permissão para executar esta operação.');
    }
}

function reprovarTransacao(){ 
    if ($('#bt_reprovar_transacao').attr('disabled') != 'disabled'){
        myApp.hideMensagem('#boxMensagem');
        $('#dialogAcao').val('reprovar');
        $('#dialogSubtitulo').html("Tem certeza que deseja <span class='red'><b>REPROVAR</b></span> a inscrição: <em><b>" + $("#Documento1").val() + " - " + $("#Detalhe1").val() + "</b></em> ?");
        $('#boxDialogObservacao').show();
        $('#dialogPadrao').modal('show');

    } else {
        myApp.showMensagem('#boxMensagem', 'erro', 'Você <b>NÃO</b> tem permissão para executar esta operação.');
    }
}

function setTransacao(IdTransacao){
    IdTransacao = parseFloat(IdTransacao);
    var IdEvento = parseFloat($('#IdEvento').val());
    var IdStatus = parseFloat($('#IdStatus').val());
    var IdParticipante1 = parseFloat($('#IdParticipante1').val());
    var IdStatus1 = parseFloat($('#IdStatus1').val());
    console.log('[setTransacao('+IdTransacao+')[IdEvento='+IdEvento+'][IdStatus='+IdStatus+'][IdParticipante1='+IdParticipante1+'][IdStatus1='+IdStatus1+']');

    // array(0=>'Não definida', 1=>'Pre-Inscrito', 2=>'Confirmada', 3=>'Recusado', 4=>'Cancelada', 5=>'Confirmado', 6=>'Presente', 7=>'', 8=>'', 9=>'');
    
    myApp.hideMensagem('#boxMensagem');
    $('#boxDocumento1').show();
    $('#lblDocumento1').html('Inscrição:');
    $('#boxDataTransacao1').show();
    $('#boxDetalhe1').show();
    $('#boxObservacao1').hide();

    if (IdStatus1==1){ // Pre-Inscrito
        
    } else if ((IdStatus1==2) || (IdStatus1==5) || (IdStatus1==6)){ // 1: Confirmar Inscrição, 5=>'Confirmado', 6=>'Presente'
        $('#Detalhe1').attr("disabled", "disabled");
        $('#boxDetalhe1').show();
        $('#boxAprovacao1').show();
        
    } else if ((IdStatus1==3) || (IdStatus1==4)){ // 3:Recusado, 4:Cancelado
        $('#Detalhe1').attr("disabled", "disabled");
        $('#boxDetalhe1').show();
        $('#Observacao1').attr("disabled", "disabled");
        $('#boxObservacao1').show();
        $('#boxAprovacao1').show();
    
    } else {
        
    }
    
}



</script>