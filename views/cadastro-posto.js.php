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
function carregarLista(tecla){	

    if(tecla==13){
        var urlAjax = "interacao.php?controle="+ oModulo.Controle +"&acao=listar";
        myApp.showPleaseWait();
        
		if (typeof oTable == 'undefined') {
            oTable = $('#tabListagem').dataTable({
                "oLanguage": {"sUrl": "assets/js/jquery.dataTables.pt-br.txt"},
                "aaSorting": [[1, 'asc']],
                "aoColumnDefs": [
                    {"aTargets": [0], "bSearchable": false, "bVisible": true, "bSortable": false, "sWidth": "5%"},
                    {"aTargets": [1], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "6%"},
                    {"aTargets": [2], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "23%"},
                    {"aTargets": [3], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "15%"},
                    {"aTargets": [4], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "6%"}
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
	
	if (($("#descricao").val() == '')){
			myApp.showAlert('erro', 'O Campo <b>Descrição</b> é de preenchimento obrigatório.');
			return false; 	
	}
    myApp.showPleaseWait(); 
}

function preparaForm(acao){
    
    console.log("preparaForm('"+ acao +"');");
    
    var formCadastro = $("#formCadastro");
    
	if (acao == 'limpar'){				// LIMPAR todos os Campos
        document.getElementById('formCadastro').reset();

		//$('#idPosto').val('0');
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
		$('#bt_editar').removeAttr('disabled');
		$('#bt_excluir').removeAttr('disabled');
		
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
		
		//habilita os campos para edição
		preparaForm('habilitar');
		$("#descricao").removeAttr('readonly');
		$("#responsavel").removeAttr('readonly');
		$("#ativo").removeAttr('readonly');			
		
		// Inicializar Campos
        $("#acao").val(acao);
		$('#ativo').prop('checked', true);
		if($('#ativo').is(':checked') == true){ 
			$("#ativo").val(1);
		}else{
			$("#ativo").val(0);
		}
        $('#IdUsuarioAcao').val(oUsuario.Id);
		dataCorrente = dataFormatada(new Date());
		$('#dataCadastro').val(dataCorrente);
		$('#nomeUsuarioAcao').val(oUsuario.Nome);
		
		// PERMISSÕES DO USUARIO
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
		// Inicializar Campos
        $("#acao").val(acao);
		$("#boxToolbar").hide();
		$("#boxFormulario").show();
		$("#boxListagem").hide();
		$('#bt_gravar').attr("disabled", "disabled");
		
	} else if (acao == 'excluir'){
        // Inicializar Campos
        $('#controle').val('Posto');
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
			$('#Id').val(data.idPosto);
		    $('#idPosto').val(data.idPosto);
			$('#descricao').val(data.descricao);				
			$('#responsavel').val(data.responsavel); 
            $('#dataCadastro').val(data.dataCadastro);
			$('#dataAcao').val(data.dataAcao);
			$('#IdUsuarioAcao').val(data.IdUsuarioAcao);
			$('#nomeUsuarioAcao').val(data.nomeUsuarioAcao);				
			
			if (data.ativo){ 
				$('#ativo').prop('checked', true);
				$('#ativo').val(1);
			} else {
				$('#ativo').prop('checked', false);
				$('#ativo').val(0);
			}		

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
			message: "Tem certeza que deseja excluir o Registro '" + $('#descricao').val() + "' ?" ,
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
	carregarLista(13);
    
	// PERMISSÕES DO USUARIO
    //$("#bt_incluir").hide();
	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}

	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}
	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}
	
	//$('#bt_incluir').attr('disabled','disabled');
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