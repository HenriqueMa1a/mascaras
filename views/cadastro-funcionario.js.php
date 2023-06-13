<script type="text/javascript">

/* JS JQUERY ************************************************************************************************************************************ */
jQuery(document).ready(function() 
{	
	
    $('[data-toggle=popover]').popover({placement : 'bottom', trigger : 'hover', delay: {'show': 50, 'hide': 200}}).click(function(e){
        if($(this).is('a') || $(this).is('button') || ($(this).attr('data-type')=='data')) $(this).popover('hide');
    });
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
	
	$("#cpf").mask("999.999.999-99",{placeholder:"___.___.___-__"});
	
	/* JQUERY.FORM ****************************************************************************************************************************** */
    $("#formCadastro").ajaxForm({type: 'POST', dataType: 'json', url: 'interacao.php', beforeSubmit: validaForm, success: showResponse});
    
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
        if ((acao=='aprovar') || (acao=='aprovarTrasacao') || (acao=='aprovarTodos')){
            
        } else if ((acao=='reprovar') || (acao=='reprovarTrasacao') || (acao=='reprovarTodos') || (acao=='cancelar-transacao') || (acao=='cancelar')){
            $('#Observacao1').val($('#dialogObservacao').val());
        }
        if ($('#boxDialogObservacao').is(":visible")){
            if ($('#dialogObservacao').val() == ''){
                myApp.showMensagem('#boxDialogMensagem', 'erro', 'O Campo <b>Observação</b> é de preenchimento obrigatório.');
                return false;
            }
        }
        $("#dialogPadrao").modal('hide');
            
    });
	
    inicializar();
});


/* JS NORMAIS ************************************************************************************************************************************ */
function carregarLista(tecla){	

    if(tecla==13){
        var urlAjax = "interacao.php?controle="+ oModulo.Controle +"&acao=listar";
		urlAjax += "&nome=" + $("#filtroNome").val();
       // urlAjax += "&dirVd=" + $("#filtroDirVd").val();
        urlAjax += "&alocacao=" + $("#filtroUoAlocacao").val();
		urlAjax += "&vinculo=" + $("#filtroVinculo").val();
        urlAjax += "&modalidade=" + $("#filtroModalidade").val();
        urlAjax += "&jornada=" + $("#filtroJornada").val();
		urlAjax += "&tipoColaborador=" + $("#filtroTipoColaborador").val();
		
        myApp.showPleaseWait();
        
		if (typeof oTable == 'undefined') { 
            oTable = $('#tabListagem').dataTable({
                "oLanguage": {"sUrl": "assets/js/jquery.dataTables.pt-br.txt"},
                "aaSorting": [[1, 'asc']],
                "aoColumnDefs": [
                    {"aTargets": [0], "bSearchable": false, "bVisible": true, "bSortable": false, "sWidth": "5%"}, //view
                    {"aTargets": [1], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "6%"},   //cpf
                    {"aTargets": [2], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "10%"},  //nome com cartao
                    {"aTargets": [3], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "8%"},   //uo com vice
                    {"aTargets": [4], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "5%"},  //vinculo
                    {"aTargets": [5], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "5%"},   //modalidade
                    {"aTargets": [6], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "5%"},  //jornada
                    {"aTargets": [7], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "3%"}    //tipo

				],
                "bDestroy": true,	        
                "sAjaxSource": urlAjax,
                "bProcessing": true,
                "bServerSide": false,
                "bPaginate": true,
                "bFilter": false,
                "bInfo": true,
                "bSort" : true,
                "sDom": 'lfrtip',
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

            $('#tabListagem').on('draw.dt', function () {
                myApp.hidePleaseWait();
            });
            
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
	window.scrollTo(0, 0);
	window.parent.scrollTo(0, 500);  
} 


function validaForm(formData, jqForm, options)
{ 
 	myApp.hideAlert();
	
	if (($("#nome").val() == '')){
		myApp.showAlert('erro', 'O Campo <b>Nome</b> é de preenchimento obrigatório.');
		return false; 
	} else if (($("#jornada").val() == '')){
		myApp.showAlert('erro', 'O Campo <b>Jornada de Trabalho</b> é de preenchimento obrigatório.');
		return false; 
	} else if (($("#cartao").val() == '')){
		myApp.showAlert('erro', 'O Campo <b>Código do Cartão</b> é de preenchimento obrigatório.');
		return false; 
	} 
    myApp.showPleaseWait(); 
}

function preparaForm(acao){
    
    console.log("preparaForm('"+ acao +"');");
    
    var formCadastro = $("#formCadastro");
    
	if (acao == 'limpar'){				// LIMPAR todos os Campos
        document.getElementById('formCadastro').reset();

		//$('#idFunc').val('0');
		$('#bt_gravar').attr("disabled", "disabled");
        
        $("#acao1").val('');

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
        
        // PERMISSÕES DO USUARIO
        $('#bt_cancelar').removeAttr('disabled');
        $('#bt_excluir').removeAttr('disabled');
		$('#bt_editar').removeAttr('disabled');
		
	} else if (acao == 'listar'){
		preparaForm('limpar');
		$("#boxToolbar").show();
		$("#boxFormulario").hide();
		$("#boxListagem").show();

        myApp.hideMensagem('#boxMensagem2');
        myApp.hideMensagem('#boxMensagem3');
        
        // Inicializar Campos
        $("#acao").val(acao);
        
	} else if (acao == 'incluir'){
		preparaForm('limpar');	
		$("#boxToolbar").hide();
		$("#boxFormulario").show();
		$("#boxListagem").hide();

		// Inicializar Campos
		carregarComboUo('alocacao','', 13);	
		carregarComboJornada('jornada','', 13);	
		carregarComboTipoColaborador('tipoColaborador','', 13);	
		$("#acao").val(acao);
		dataCorrente = dataFormatada(new Date());
		$('#dataCadastro').val(dataCorrente);
        $('#IdUsuarioAcao').val(oUsuario.Id);
		$('#nomeUsuarioAcao').val(oUsuario.Nome);

		// PERMISSÕES DO USUARIO
		preparaForm('habilitar');
		$('#bt_editar').attr("disabled", "disabled");
		$('#bt_excluir').attr("disabled", "disabled");
		if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_gravar').removeAttr('disabled');}}
		
	} else if (acao == 'editar'){
		preparaForm('habilitar');	

		// Inicializar Campos
        $("#acao").val(acao);
        $('#IdUsuarioAcao').val(oUsuario.Id);
		
		// PERMISSÕES DO USUARIO
		$('#bt_editar').attr("disabled", "disabled");
		$('#bt_excluir').attr("disabled", "disabled");
		if(typeof oModulo.Operacoes.editar!=='undefined'){if(oModulo.Operacoes.editar){$('#bt_gravar').removeAttr('disabled');}}
	
	} else if (acao == 'visualizar'){
		$("#boxToolbar").hide();
		$("#boxFormulario").show();
		$("#boxListagem").hide();
		
		// Inicializar Campos
		$("#acao").val(acao);
		
		// PERMISSÕES DO USUARIO
		if(typeof oModulo.Operacoes.editar!=='undefined'){if(oModulo.Operacoes.editar){$('#bt_editar').removeAttr('disabled');}}
		if(typeof oModulo.Operacoes.excluir!=='undefined'){if(oModulo.Operacoes.excluir){$('#bt_excluir').removeAttr('disabled');}}
		$('#bt_gravar').attr("disabled", "disabled");		
		
	} else if (acao == 'excluir'){
        // Inicializar Campos
        $('#controle').val('Funcionario');
        $("#acao").val(acao);
	}
	$('#controle').val(oModulo.Controle);
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
			$('#Id').val(data.idFunc);
		    $('#idFunc').val(data.idFunc);
			$('#cpf').val(data.cpf);
			$('#cartao').val(data.cartao);
			$('#nome').val(data.nome);
			$('#vinculo').val(data.vinculo);
			$('#modalidade').val(data.modalidade);
			$('#origemUO').val(data.origemUO);
			carregarComboUo('alocacao', data.alocacao, 13);
			carregarComboJornada('jornada', data.jornada, 13);
			carregarComboTipoColaborador('tipoColaborador', data.tipoColaborador, 13);
			$('#horario').val(data.horario);
			$('#obs').val(data.obs);
			$('#dataCadastro').val(data.dataCadastro);
			$('#acao').val(data.acao);
			$('#dataAcao').val(data.dataAcao);
			$('#idUsuarioAcao').val(data.idUsuarioAcao);
			$('#nomeUsuarioAcao').val(data.nomeUsuarioAcao);

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
			message: "Tem certeza que deseja excluir o Registro '" + $('#nome').val() + "' ?" ,
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

function inicializar()
{
	carregarComboUo('filtroUoAlocacao', '', 13);
	carregarComboJornada('filtroJornada', '', 13);
	carregarComboTipoColaborador('filtroTipoColaborador', '', 13);
	carregarLista(13);
    
	// PERMISSÕES DO USUARIO
    //$("#bt_incluir").hide();
	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}

	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}
	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}
	
    $('#bt_pesquisar').removeAttr('disabled');
	//$('#bt_incluir').attr('disabled','disabled');
}

function carregarComboUo(cboNome, Uo, tecla){ 
    if(tecla==13){
        clearCombo(cboNome);
		addItemCombo(cboNome, '', 'Carregando . . .');
		
		$.getJSON('interacao.php', {controle: 'Uo', acao: 'listarCombo'},
			function(data){ 
				clearCombo(cboNome);
				if (data.records > 0){ 
					addItemCombo(cboNome, '', 'Selecione');
					for(i=0;i<data.rows.length;i++){
						addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
					}
					if (Uo) setItemCombo(cboNome, Uo);
				} else {
					addItemCombo(cboNome, '', '[Não encontrado]');
				}
			}
		);
    }
}

function carregarComboJornada(cboNome, Jornada, tecla){ 
    if(tecla==13){
        clearCombo(cboNome);
		addItemCombo(cboNome, '', 'Carregando . . .');
		
		$.getJSON('interacao.php', {controle: 'JornadaTrabalho', acao: 'listarCombo'},
			function(data){ 
				clearCombo(cboNome);
				if (data.records > 0){ 
					addItemCombo(cboNome, '', 'Selecione');
					for(i=0;i<data.rows.length;i++){
						addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
					}
					if (Jornada) setItemCombo(cboNome, Jornada);
				} else {
					addItemCombo(cboNome, '', '[Não encontrado]');
				}
			}
		);
    }
}

function carregarComboTipoColaborador(cboNome, TipoColaborador, tecla){ 
    if(tecla==13){
        clearCombo(cboNome);
		addItemCombo(cboNome, '', 'Carregando . . .');
		
		$.getJSON('interacao.php', {controle: 'TipoColaborador', acao: 'listarCombo'},
			function(data){ 
				clearCombo(cboNome);
				if (data.records > 0){ 
					addItemCombo(cboNome, '', 'Selecione');
					for(i=0;i<data.rows.length;i++){
						addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
					}
					if (TipoColaborador) setItemCombo(cboNome, TipoColaborador);
				} else {
					addItemCombo(cboNome, '', '[Não encontrado]');
				}
			}
		);
    }
}

function dataFormatada(pData) {
	var data = pData;
        var dia  = data.getDate().toString();
        var diaF = (dia.length == 1) ? '0' + dia : dia;
        var mes  = (data.getMonth()+1).toString(); //+1 pois no getMonth() Janeiro começa com zero.
        var mesF = (mes.length == 1) ? '0' + mes : mes;
        var anoF = data.getFullYear();
		var hora = data.getHours(); 
		if ((hora>=0) && (hora<=9)) {horaF = '0' + hora} else {horaF = hora};
        var minuto = data.getMinutes();
		if ((minuto>=0) && (minuto<=9)) {minutoF = '0' + minuto} else {minutoF = minuto};
        var segundos = data.getSeconds();
		if ((segundos>=0) && (segundos<=9)) {segundosF = '0' + segundos} else {segundosF = segundos};
	return diaF + "/" + mesF + "/" + anoF + " " + horaF + ":" + minutoF + ":" + segundosF;
}


</script>