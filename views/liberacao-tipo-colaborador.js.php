<script type="text/javascript">
var id;
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
        myApp.showPleaseWait();		
        
		if (typeof oTable == 'undefined') {
            oTable = $('#tabListagem').dataTable({
                "oLanguage": {"sUrl": "assets/js/jquery.dataTables.pt-br.txt"},
                "aaSorting": [[1, 'asc']],
                "aoColumnDefs": [
                    {"aTargets": [0], "bSearchable": false, "bVisible": false, "bSortable": false},
                    {"aTargets": [1], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "40%"},
                    {"aTargets": [2], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "5%"},
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
	window.parent.scrollTo(0, 0);  
} 

function preparaForm(acao){
    
    console.log("preparaForm('"+ acao +"');");
    
    var formCadastro = $("#formCadastro");

	if (acao == 'limpar'){	// LIMPAR todos os Campos
        document.getElementById('formCadastro').reset();
        formCadastro.find(':checked').each(function() { // Desmarcar todas as CHECKED
            $(this).attr('checked', false);
        });
	} else if (acao == 'habilitar'){	// HABILITAR todos os Campos
		formCadastro.find(':disabled').each(function() {
			$(this).removeAttr('disabled');
		});
	
	} else if (acao == 'desabilitar'){ 	// DESABILITAR todos os Campos
		formCadastro.find(':enabled').each(function() {
			$(this).attr("disabled", "disabled");
		});
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
        $('#IdUsuarioAcao').val(oUsuario.Id);
		$('#NomeUsuarioAcao').val(oUsuario.Nome);
		// PERMISSÕES DO USUARIO
		preparaForm('habilitar');
        
	} else if (acao == 'editar'){
		preparaForm('habilitar');	
		// Inicializar Campos
        $("#acao").val(acao);
		$('#IdUsuarioAcao').val(oUsuario.Id);
        
	} else if (acao == 'visualizar'){
		// Inicializar Campos
        $("#acao").val(acao);
		//$("#boxToolbar").hide();
		//$("#boxFormulario").show();
		//$("#boxListagem").hide();
		
	} else if (acao == 'excluir'){
        // Inicializar Campos
        $('#controle').val('TipoColaborador');
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

function ativarTipo(IdTipoColaborador)
{  
	$('#Id').val(IdTipoColaborador);
	$("#acao").val('editar');
	$('#IdUsuarioAcao').val(oUsuario.Id);
	$('#controle').val(oModulo.Controle);

	if ($('#ativarTipo_'+IdTipoColaborador).is(':checked')){
        $('#Ativo').val(1);
    }else{
		$('#Ativo').val(0);
	}
	
	gravar();
}


</script>