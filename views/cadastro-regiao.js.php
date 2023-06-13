<script type="text/javascript">

/* JS JQUERY ************************************************************************************************************************************ */
jQuery(document).ready(function()
{
    $('[data-toggle=popover]').popover({placement : 'bottom', trigger : 'hover', delay: {'show': 50, 'hide': 200}}).click(function(e){
        if($(this).is('a') || $(this).is('button') || ($(this).attr('data-type')=='data')) $(this).popover('hide');
    });
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
	
	/* JQUERY.FORM ****************************************************************************************************************************** */
    $("#formCadastro").ajaxForm({type: 'POST', dataType: 'json', url: 'interacao.php', beforeSubmit: validaForm, success: showResponse});
    
    inicializar();
});

/* JS NORMAIS ************************************************************************************************************************************ */
function carregarLista(){	
	var urlAjax = "interacao.php?controle="+ oModulo.Controle +"&acao=listar";
	urlAjax += "&IdPais=" + $("#filtroIdPais").val();
    urlAjax += "&Nome=" + $("#filtroNome").val();
	
	myApp.showPleaseWait();
	if (typeof oTable == 'undefined') {	
		oTable = $('#tabListagem').dataTable({
			"oLanguage": {"sUrl": "assets/js/jquery.dataTables.pt-br.txt"},
	        "aaSorting": [[2, 'asc'], [3, 'asc']],
			"aoColumnDefs": [
	            {"aTargets": [0], "bSearchable": false, "bVisible": true, "bSortable" : false, "sWidth": "5%"},
	            {"aTargets": [1], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "10%", "sClass": "text-right" },
	            {"aTargets": [2], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "25%"},
                {"aTargets": [3], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "15%"},
				{"aTargets": [4], "bSearchable": true,  "bVisible": true, "bSortable" : true  },
	            {"aTargets": [5], "bSearchable": true,  "bVisible": true, "bSortable" : true, "sWidth": "15%"}
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
		carregarLista();
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
        if (($("#IdPais").val() == '') || ($("#IdPais").val() == '0')){
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
        
        // PERMISSÕES DO USUARIO
        $('#bt_cancelar').removeAttr('disabled');
		
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
		
		// PERMISSÕES DO USUARIO
		preparaForm('habilitar');
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

		// PERMISSÕES DO USUARIO
		if(typeof oModulo.Operacoes.editar!=='undefined'){if(oModulo.Operacoes.editar){$('#bt_editar').removeAttr('disabled');}}
		if(typeof oModulo.Operacoes.excluir!=='undefined'){if(oModulo.Operacoes.excluir){$('#bt_excluir').removeAttr('disabled');}}
		$('#bt_gravar').attr("disabled", "disabled");
		
	} else if (acao == 'excluir'){
        // Inicializar Campos
        $('#controle').val('Pessoa');
        $("#acao").val(acao);

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
            $('#IdPais').val(data.IdPais);
            $('#Codigo').val(data.Codigo);
		    $('#labelCodigo').val(data.Codigo);
			$('#Sigla').val(data.Sigla);
			$('#Nome').val(data.Nome);
			
			$('#Ativo').val(data.Ativo);
            $('#Revisao').val(data.Revisao);
			$('#IdUsuarioAcao').val(data.IdUsuarioAcao);
			$('#DataAcao').val(data.DataAcao);
			$('#NomeUsuarioAcao').val(data.NomeUsuarioAcao);
			
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

function popularPais(Ids, tecla){
    var cboNome = 'filtroIdPais'; 
    var cboNome2 = 'IdPais'; 
    
    if(tecla==13){
        clearCombo(cboNome);
        addItemCombo(cboNome, '', 'Carregando . . .');
        clearCombo(cboNome2);
        addItemCombo(cboNome2, '', 'Carregando . . .');
        
        $.getJSON('interacao.php', {controle: 'Pais', acao: 'listarCombo'},
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

function IdPais_onchange(valor, tecla)
{
    console.log("IdPais_onchange('" + valor + "', '" + tecla + "');"); 
    if(tecla===13){
        selecionarRegiao('IdRegiao', valor, '', tecla);
    }
}

function selecionarRegiao(cboNome, IdPais, Ids, tecla){ 
    
    if(tecla==13){
        if (IdPais) {
            clearCombo(cboNome);
            addItemCombo(cboNome, '', 'Carregando . . .');
            $.getJSON('interacao.php', {controle: 'Regiao', acao: 'listarCombo', IdPais: IdPais},
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

function inicializar()
{
    popularPais('', 13);
    
	carregarLista();
    
	// PERMISSÕES DO USUARIO
	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}
	
}

</script>