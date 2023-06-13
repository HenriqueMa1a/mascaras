<script type="text/javascript">

/* JS JQUERY ************************************************************************************************************************************ */
jQuery(document).ready(function() 
{	
	
    $('[data-toggle=popover]').popover({placement : 'bottom', trigger : 'hover', delay: {'show': 50, 'hide': 200}}).click(function(e){
        if($(this).is('a') || $(this).is('button') || ($(this).attr('data-type')=='data')) $(this).popover('hide');
    });
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
	
    $("#dataDistribuicao").mask("99/99/9999", {placeholder:"__/__/____"});
    $("#dataDistribuicao").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'dd/mm/yy', minDate: new Date()-18, maxDate: '0', showButtonPanel: true, yearRange: '2020:<?php echo date("Y")-16; ?>'});

	$('#dataDistribuicao').datepicker({
		format: "dd/mm/yyyy",
		language: "pt-BR"
	});	
	
    $("#dataInicial").mask("99:99", {placeholder:"__/__/____"});
    $("#dataInicial").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'dd/mm/yy', minDate: '-3M', maxDate: '0', showButtonPanel: true, yearRange: '<?php echo (date("Y")-1).':'.(date("Y")+5); ?>'
			,onSelect: function(dateText) {
                    calcularDataFinal();
            }
    });
	
    $("#dataFinal").mask("99/99/9999", {placeholder:"__/__/____"});
    $("#dataFinal").datepicker(     { changeMonth: true, changeYear: true, dateFormat: 'dd/mm/yy', minDate: '-3M', maxDate: '+5Y', showButtonPanel: true, yearRange: '<?php echo date("Y").':'.(date("Y")+5); ?>'});
	
	
	
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

function calcularDataFinal(){
    var dtInicial = $('#DataInicial').val();
    var dtFinal = '';
    var Anos = 0;
    var AnosRegistro = 1;
    console.log('calcularDataFinal (' + dtInicial + ', ' + AnosRegistro + ')');
    
        if($('#dataFinal').val()==''){
            $('#dataFinal').val($('#dataInicial').val());
        }

}


/* JS NORMAIS ************************************************************************************************************************************ */
function carregarLista(tecla){	

    if(tecla==13){
        var urlAjax = "interacao.php?controle="+ oModulo.Controle +"&acao=listar";
		urlAjax += "&nome=" + $("#filtroNome").val();
        urlAjax += "&posto=" + $("#filtroPosto").val();
        urlAjax += "&dataInicial=" + $("#dataInicial").val();
		urlAjax += "&dataFinal=" + $("#dataFinal").val();
		
        myApp.showPleaseWait();
        
		if (typeof oTable == 'undefined') { 
            oTable = $('#tabListagem').dataTable({
                "oLanguage": {"sUrl": "assets/js/jquery.dataTables.pt-br.txt"},
                "aaSorting": [[1, 'asc']],
                "aoColumnDefs": [
                    {"aTargets": [0], "bSearchable": false, "bVisible": true, "bSortable": false, "sWidth": "2%"},
                    {"aTargets": [1], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "5%"},
                    {"aTargets": [2], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "10%"},
                    {"aTargets": [3], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "15%"},
                    {"aTargets": [4], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "15%"},
                    {"aTargets": [5], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "5%"}
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
	
    if (($("#idFuncionario").val() == '')){
		myApp.showAlert('erro', 'O Campo <b>Nome</b> é de preenchimento obrigatório.');
		return false; 
	}else if (($("#idPosto").val() == '')){
			myApp.showAlert('erro', 'O Campo <b>Posto de Entrega</b> é de preenchimento obrigatório.');
			return false; 
	}else if (($("#qtde").val() == '')){
			myApp.showAlert('erro', 'O Campo <b>Quantidade</b> é de preenchimento obrigatório.');
			return false; 
	}  
    myApp.showPleaseWait(); 
}

function preparaForm(acao){
    
    console.log("preparaForm('"+ acao +"');");
    
    var formCadastro = $("#formCadastro");
    var formTransacao = $("#formTransacao");
    
	if (acao == 'limpar'){				// LIMPAR todos os Campos
        document.getElementById('formCadastro').reset();

		//$('#idDistribuidao').val('0');
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
		
		//habilita os campos para edição
		preparaForm('habilitar');		
		$("#boxListagem").hide();
		
		// Inicializar Campos
        $("#acao").val(acao);
		carregarComboNome('idFuncionario', '', 13);
		carregarComboPosto('idPosto', '', 13);
		$('#IdUsuarioAcao').val(oUsuario.Id);
		$('#nomeUsuarioAcao').val(oUsuario.Nome);		
		
		// PERMISSÕES DO USUARIO
		$('#bt_editar').attr("disabled", "disabled");
		$('#bt_excluir').attr("disabled", "disabled");
		if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_gravar').removeAttr('disabled');}}
		
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
		$('#bt_gravar').attr("disabled", "disabled");
		
	} else if (acao == 'excluir'){
        // Inicializar Campos
        $('#controle').val('Distribuicao');
        $("#acao").val(acao);
	}
    $('#controle').val(oModulo.Controle);
}

function cancelar() 
{ 
	myApp.hideAlert();
    preparaForm('listar');
	$("#boxToolbar").show();
	$("#boxFormulario").hide();
	myApp.hidePleaseWait();
	myApp.goTop();
	carregarLista(13);
	
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
			$('#Id').val(data.idDistribuicao);
		    $('#idDistribuidao').val(data.idDistribuicao);
			carregarComboNome('idFuncionario', data.idFuncionario, 13);
			carregarComboPosto('idPosto', data.idPosto, 13);
			$('#qtde').val(data.qtde);
			
			dataDistribuicao = new Date(data.data);
			dataDistribuicao = dataFormatada(dataDistribuicao);
			$('#dataDistribuicao').val(dataDistribuicao);
			
			dataAcao = new Date(data.dataAcao);
			dataAcao = dataFormatada(dataAcao);
			$('#dataAcao').val(dataAcao);

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
			message: "Tem certeza que deseja excluir o Registro '" + $('#idDistribuidao').val() + "' ?" ,
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
	carregarComboPosto('filtroPosto', '', 13);
	carregarLista(13);
    
	// PERMISSÕES DO USUARIO
    //$("#bt_incluir").hide();
	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}

	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}
	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}
	
    $('#bt_pesquisar').removeAttr('disabled');
    $('#bt_relatorio_excel').removeAttr('disabled');
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

function carregarComboNome(cboNome, funcionario, tecla){ 
    if(tecla==13){
        clearCombo(cboNome);
		addItemCombo(cboNome, '', 'Carregando . . .');
		
		$.getJSON('interacao.php', {controle: 'Funcionario', acao: 'listarCombo'},
			function(data){ 
				clearCombo(cboNome);
				if (data.records > 0){ 
					addItemCombo(cboNome, '', 'Selecione');
					for(i=0;i<data.rows.length;i++){
						addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
					}
					if (funcionario) setItemCombo(cboNome, funcionario);
				} else {
					addItemCombo(cboNome, '', '[Não encontrado]');
				}
			}
		);
    }
}

function carregarComboPosto(cboNome, posto, tecla){ 
    if(tecla==13){
        clearCombo(cboNome);
		addItemCombo(cboNome, '', 'Carregando . . .');
		
		$.getJSON('interacao.php', {controle: 'Posto', acao: 'listarCombo'},
			function(data){ 
				clearCombo(cboNome);
				if (data.records > 0){ 
					addItemCombo(cboNome, '', 'Selecione');
					for(i=0;i<data.rows.length;i++){
						addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
					}
					if (posto) setItemCombo(cboNome, posto);
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


function carregarRelatorio(formato, tecla){    

    if (tecla=13){
        myApp.hideAlert();
        
        var oTable = $('#tabListagem').DataTable();
        var order = oTable.order();
            
        var urlReport = 'interacao.php';
        var sidx = order[0][0];
        var sord = order[0][1];

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
            urlReport += "&funcionario=" + $('#filtroNome').val();
            urlReport += "&posto=" + $("#filtroPosto").val();
            urlReport += "&dataInicial=" + $("#dataInicial").val();
			urlReport += "&dataFinal=" + $("#dataFinal").val();
            
            var windowName = "_blank";
            var windowSettings = ''; //'top=50,left=50,width=935,height=550,toolbar=no,location=no,directories=no,scrollbars=yes,status=no,menubar=no,copyhistory=no'; 
            window.open(urlReport, windowName, windowSettings, true);
            
            myApp.showAlert('alerta', 'Exportação realizada com sucesso.');
            myApp.hidePleaseWait();

        } else {
            myApp.showAlert('erro', 'Tipo de relatório não definido.');
            myApp.hidePleaseWait();
            return false;
        }
    
    }
} 

</script>