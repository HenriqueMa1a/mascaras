<script type="text/javascript">

/* JS JQUERY ************************************************************************************************************************************ */
jQuery(document).ready(function() 
{	
    $('[data-toggle=popover]').popover({placement : 'bottom', trigger : 'hover', delay: {'show': 50, 'hide': 200}}).click(function(e){
        if($(this).is('a') || $(this).is('button') || ($(this).attr('data-type')=='data')) $(this).popover('hide');
    });
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
	
	/* JQUERY.FORM ****************************************************************************************************************************** */
    $("#formCadastro").ajaxForm({type: 'POST', dataType: 'json', url: 'interacao.php', success: showResponse});
	
    carregarLista(13);
});


/* JS NORMAIS ************************************************************************************************************************************ */
function carregarLista(tecla){	

    if(tecla==13){
		
        var urlAjax = "interacao.php?controle="+ oModulo.Controle +"&acao=listar";
		urlAjax += "&codigo=" + $("#filtroCodigo").val();
        urlAjax += "&sigla=" + $("#filtroSigla").val();
		urlAjax += "&descricao=" + $("#filtroDescricao").val();
        myApp.showPleaseWait();		
        
		if (typeof oTable == 'undefined') {
            oTable = $('#tabListagem').dataTable({
                "oLanguage": {"sUrl": "assets/js/jquery.dataTables.pt-br.txt"},
                "aaSorting": [[1, 'asc']],
                "aoColumnDefs": [
                    {"aTargets": [0], "bSearchable": false, "bVisible": true, "bSortable": false, "sWidth": "10%"},
                    {"aTargets": [1], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "10%"},
                    {"aTargets": [2], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "20%"},
                    {"aTargets": [3], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "5%"}
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
		//myApp.showAlert('sucesso', data.mensagem);
		preparaForm('listar');
		carregarLista(13);
	} else {                
		myApp.showAlert('erro', data.mensagem);
	} 
	myApp.hidePleaseWait();
	window.scrollTo(0, 0);
	window.parent.scrollTo(0, 500);  
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
        $('#controle').val('Uo');
        $("#acao").val(acao);
	}
	$('#controle').val(oModulo.Controle);
}


function editar() 
{ 
 	myApp.hideAlert();
    preparaForm('editar');
}

function gravar() 
{   
	myApp.hideAlert();
    $('#formCadastro').submit();
}

function sair() 
{ 
 	var url = "controller.php?gm=dashboard&mod=abertura"; 
	$(location).attr('href',url);
}

function ativarUO(IdUo)
{  
	$('#Id').val(IdUo);
	$("#acao").val('editar');
	$('#IdUsuarioAcao').val(oUsuario.Id);
	$('#controle').val(oModulo.Controle);

	if ($('#ativarUO_'+IdUo).is(':checked')){
        $('#Ativo').val(1);
    }else{
		$('#Ativo').val(0);
	}
	
	gravar();
}


</script>