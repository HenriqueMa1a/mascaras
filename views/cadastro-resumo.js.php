<script type="text/javascript">

/* JS JQUERY ************************************************************************************************************************************ */
jQuery(document).ready(function()
{
	
	$('#IdStatus').on('change', function() {
		IdStatus_onchange(this.value, this);
	})
	
    $('[data-toggle=popover]').popover({placement : 'bottom', trigger : 'hover', delay: {'show': 50, 'hide': 200}}).click(function(e){
        if($(this).is('a') || $(this).is('button') || ($(this).attr('data-type')=='data')) $(this).popover('hide');
    });
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

    $("#DataApresentacao").mask("99/99/9999", {placeholder:"__/__/____"});
    $("#DataApresentacao").datepicker(     { changeMonth: true, changeYear: true, dateFormat: 'dd/mm/yy', minDate: '0', maxDate: '+1Y', showButtonPanel: true, yearRange: '<?php echo date("Y").':'.(date("Y")+1); ?>'});
	
	/* JQUERY.FORM ****************************************************************************************************************************** */
    $("#formCadastro").ajaxForm({type: 'POST', dataType: 'json', url: 'interacao.php', beforeSubmit: validaForm, success: showResponse});

    inicializar();
    
});

/* JS NORMAIS ************************************************************************************************************************************ */
function carregarLista(tecla){

    if(tecla==13){ 

        var urlAjax = "interacao.php?controle="+ oModulo.Controle +"&acao=listar"; 
        urlAjax += "&EventoPrincipal=" + $("#filtroIdEventoPrincipal").val();
		urlAjax += "&Titulo=" + $("#filtroTitulo").val();
        urlAjax += "&Nome=" + $("#filtroNome").val();
        urlAjax += "&IdTipo=" + $("#filtroIdTipo").val();
        urlAjax += "&IdStatus=" + $("#filtroIdStatus").val();

        myApp.showPleaseWait();
        if (typeof oTable == 'undefined') { 
            oTable = $('#tabListagem').dataTable({ 
                "oLanguage": {"sUrl": "assets/js/jquery.dataTables.pt-br.txt"},
                "aaSorting": [[1, 'desc']],
                "aoColumnDefs": [
                    {"aTargets": [0], "bSearchable": false, "bVisible": true, "bSortable" : false, "sWidth": "5%" },
                    {"aTargets": [1], "bSearchable": true,  "bVisible": true, "sWidth": "5%" },
                    {"aTargets": [2], "bSearchable": true,  "bVisible": false, "sWidth": "1%", "sClass": "text-right"},
                    {"aTargets": [3], "bSearchable": true,  "bVisible": true, "sWidth": "15%", "sClass": "text-left" },
                    {"aTargets": [4], "bSearchable": true,  "bVisible": true, "sWidth": "8%" , "sClass": "text-right" },
                    {"aTargets": [5], "bSearchable": true,  "bVisible": true, "sWidth": "7%" },
                    {"aTargets": [6], "bSearchable": true,  "bVisible": true},
                    {"aTargets": [7], "bSearchable": true, "bVisible": true , "sWidth": "10%" },
                    {"aTargets": [8], "bSearchable": true, "bVisible": true , "sWidth": "10%" },
                    {"aTargets": [9], "bSearchable": true, "bVisible": true , "sWidth": "8%" },
                    {"aTargets": [10], "bSearchable": true, "bVisible": true , "sWidth": "5%", "sClass": "text-right" }
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


function carregarRelatorio(formato, tecla){    

    if ( (tecla=13) && ($("#filtroIdEventoPrincipal").val() != '') ){
        myApp.hideAlert();
        //$('#boxGrafico').hide();    
        
        var oTable = $('#tabListagem').DataTable();
        var order = oTable.order();
            
        var urlReport = 'interacao.php';
        var sidx = order[0][0];
        var sord = order[0][1];

        console.log("carregarRelatorio('"+formato+"', '"+tecla+"'); {acao:'"+acao+"', Titulo:'"+$("#filtroNome").val()+"'}");
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
            urlReport += "&Titulo=" + $("#filtroTitulo").val();
            urlReport += "&Nome=" + $("#filtroNome").val();
            urlReport += "&IdTipo=" + $("#filtroIdTipo").val();
            urlReport += "&IdStatus=" + $("#filtroIdStatus").val();
			urlReport += "&EventoPrincipal=" + $("#filtroIdEventoPrincipal").val();
            
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

function validaForm(formData, jqForm, options)
{ 
 	myApp.hideAlert();
	
	if (($("#acao").val()=='excluir') || ($("#acao").val()=='autorizar') || ($("#acao").val()=='reprovar') || ($("#acao").val()=='aprovar') || ($("#acao").val()=='comunicar')){
		if (!($("#Id").val() > 0)){
			myApp.showAlert('erro', 'Selecione primeiro um registro para poder excluir.');
			return false; 
		}
		
	} else { // acao = incluir e atualizar
		if (($("#Codigo").val()=='') || ($("#Codigo").val()=='0')){
			myApp.showAlert('erro', 'O Campo <b>Codigo</b> é de preenchimento obrigatório.');
			return false; 
		} else if (($("#IdStatus").val()=='')){
			myApp.showAlert('erro', 'O Campo <b>Titulo</b> é de preenchimento obrigatório.');
			return false; 
		} else if (($("#Titulo").val()=='')){
			myApp.showAlert('erro', 'O Campo <b>Titulo</b> é de preenchimento obrigatório.');
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
        $('#DataApresentacao').val(''); 
        setItemCombo('HoraApresentacao', 0);
        
        $("#boxObservacao").hide();
        limparTabela('tabListagemHistorico');
		limparTabela('tabListagemAutorizacao');
        
	} else if (acao == 'habilitar'){	// HABILITAR todos os Campos
		formCadastro.find(':disabled').each(function() {
			$(this).removeAttr('disabled');
		});
	
        $('#IdStatus option[value="1"]').removeClass('red');
        $('#IdStatus option[value="2"]').removeClass('red');
        $('#IdStatus option[value="3"]').removeClass('red');
        $('#IdStatus option[value="4"]').removeClass('red');
        $('#IdStatus option[value="5"]').removeClass('red');
        $('#IdStatus option[value="6"]').removeClass('red');
        $('#IdStatus option[value="7"]').removeClass('red');
		$('#IdStatus option[value="8"]').removeClass('red');
    
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
        $('#bt_pesquisar').removeAttr('disabled');
        $('#bt_relatorio_excel').removeAttr('disabled');
		$('#bt_seleciona').removeAttr('disabled');
		
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
		$("#boxToolbar").hide();
		$("#boxFormulario").show();
		$("#boxListagem").hide();

		// Inicializar Campos
        $("#acao").val(acao);
        
		// PERMISSÕES DO USUARIO
		if(typeof oModulo.Operacoes.editar!=='undefined'){if(oModulo.Operacoes.editar){$('#bt_editar').removeAttr('disabled');}}
		if(typeof oModulo.Operacoes.excluir!=='undefined'){if(oModulo.Operacoes.excluir){$('#bt_excluir').removeAttr('disabled');}}
		$('#bt_gravar').attr("disabled", "disabled");
		$('#bt_comunicar').removeAttr('disabled');
        
        if(typeof oModulo.Operacoes.editar!=='undefined'){if(oModulo.Operacoes.editar){
            if ($('#IdStatus :selected').val()==1){
                $('#bt_editar').removeAttr('disabled');
               // $('#bt_editar').removeAttr('disabled');
            }
        }}
		
		//Permissões para o Usuário do NITBio alterar o status do Resumo
		if ( ( ($("#IdStatus :selected").val() == 8) || ($("#IdStatus :selected").val() == 9) ) && (oUsuario.IdPerfil == 5) ){ 
			$('#bt_editar').removeAttr("disabled");
		}else {
			if ( ($("#IdStatus :selected").val() != 8) && (oUsuario.IdPerfil == 5) ){ 
				$('#bt_editar').attr("disabled", "disabled");
			}else {
				if ( ($("#IdStatus :selected").val() == 8) && (oUsuario.IdPerfil != 5) ) { 
					$('#bt_editar').attr("disabled", "disabled");
				}else { 
					$('#bt_editar').removeAttr("disabled");
				}
			}		
		}	
		//		
        
        if ($("#IdStatus :selected").val()==2){ //Em Analise
            $("#boxObservacao").show();
        } else if ($("#IdStatus :selected").val()==3){ //Com Pendência
            $("#boxObservacao").show();
        } else if ($("#IdStatus :selected").val()==7){  //Recusado
            $("#boxObservacao").show();
        } else if ($("#IdStatus :selected").val()==9){  //Com Pendência do NIT
            $("#boxObservacao").show();
		} else {
            $("#boxObservacao").hide();
        }        
        
	} else if (acao == 'excluir'){
        // Inicializar Campos
        $('#controle').val('Pessoa');
        $("#acao").val(acao);

		
	} else if (acao == 'alterarStatus'){ 
		preparaForm('habilitar');

		// Inicializar Campos
        $("#acao").val(acao);
        
		// PERMISSÕES DO USUARIO
		$('#bt_editar').attr("disabled", "disabled");
		$('#bt_excluir').attr("disabled", "disabled");
		if(typeof oModulo.Operacoes.editar!=='undefined'){if(oModulo.Operacoes.editar){$('#bt_gravar').removeAttr('disabled');}}
        
        console.log("Tratar Status {IdStatus: '" + $("#IdStatus").val() + "'};"); 
        
        if ($("#IdStatus :selected").val()==1){
            $('#IdStatus option[value="1"]').attr("disabled", "disabled");  $('#IdStatus option[value="1"]').addClass('red');
			$('#IdStatus option[value="8"]').attr("disabled", "disabled");  $('#IdStatus option[value="8"]').addClass('red');
			$('#IdStatus option[value="9"]').attr("disabled", "disabled");  $('#IdStatus option[value="9"]').addClass('red');
            
        } else if ($("#IdStatus :selected").val()==2){
            $('#IdStatus option[value="1"]').attr("disabled", "disabled");  $('#IdStatus option[value="1"]').addClass('red');
            $('#IdStatus option[value="8"]').attr("disabled", "disabled");  $('#IdStatus option[value="8"]').addClass('red');
			$('#IdStatus option[value="9"]').attr("disabled", "disabled");  $('#IdStatus option[value="9"]').addClass('red');
			
        } else if ($("#IdStatus :selected").val()==3){
            $('#IdStatus option[value="1"]').attr("disabled", "disabled");  $('#IdStatus option[value="1"]').addClass('red');
            $('#IdStatus option[value="4"]').attr("disabled", "disabled");  $('#IdStatus option[value="4"]').addClass('red');
            $('#IdStatus option[value="5"]').attr("disabled", "disabled");  $('#IdStatus option[value="5"]').addClass('red');
            $('#IdStatus option[value="6"]').attr("disabled", "disabled");  $('#IdStatus option[value="6"]').addClass('red');
			$('#IdStatus option[value="8"]').attr("disabled", "disabled");  $('#IdStatus option[value="8"]').addClass('red');
			$('#IdStatus option[value="9"]').attr("disabled", "disabled");  $('#IdStatus option[value="9"]').addClass('red');
		
        } else if ( ($("#IdStatus :selected").val()==4) || ($("#IdStatus :selected").val()==5) || ($("#IdStatus :selected").val()==6) ){
            $('#IdStatus option[value="1"]').attr("disabled", "disabled");  $('#IdStatus option[value="1"]').addClass('red');
            $('#IdStatus option[value="2"]').attr("disabled", "disabled");  $('#IdStatus option[value="2"]').addClass('red');
            $('#IdStatus option[value="3"]').attr("disabled", "disabled");  $('#IdStatus option[value="3"]').addClass('red');
            $('#IdStatus option[value="7"]').attr("disabled", "disabled");  $('#IdStatus option[value="7"]').addClass('red');
            $('#IdStatus option[value="8"]').attr("disabled", "disabled");  $('#IdStatus option[value="8"]').addClass('red');
			$('#IdStatus option[value="9"]').attr("disabled", "disabled");  $('#IdStatus option[value="9"]').addClass('red');
			
        } else if ($("#IdStatus :selected").val()==7){
            $('#IdStatus option[value="1"]').attr("disabled", "disabled");  $('#IdStatus option[value="1"]').addClass('red');
            $('#IdStatus option[value="3"]').attr("disabled", "disabled");  $('#IdStatus option[value="3"]').addClass('red');
            $('#IdStatus option[value="4"]').attr("disabled", "disabled");  $('#IdStatus option[value="4"]').addClass('red');
            $('#IdStatus option[value="5"]').attr("disabled", "disabled");  $('#IdStatus option[value="5"]').addClass('red');
            $('#IdStatus option[value="6"]').attr("disabled", "disabled");  $('#IdStatus option[value="6"]').addClass('red');
			$('#IdStatus option[value="8"]').attr("disabled", "disabled");  $('#IdStatus option[value="8"]').addClass('red');
			$('#IdStatus option[value="9"]').attr("disabled", "disabled");  $('#IdStatus option[value="9"]').addClass('red');
			
        } else if ($("#IdStatus :selected").val()==8){
            $('#IdStatus option[value="1"]').attr("disabled", "disabled");  $('#IdStatus option[value="1"]').addClass('red');
            $('#IdStatus option[value="3"]').attr("disabled", "disabled");  $('#IdStatus option[value="3"]').addClass('red');
            $('#IdStatus option[value="4"]').attr("disabled", "disabled");  $('#IdStatus option[value="4"]').addClass('red');
            $('#IdStatus option[value="5"]').attr("disabled", "disabled");  $('#IdStatus option[value="5"]').addClass('red');
            $('#IdStatus option[value="6"]').attr("disabled", "disabled");  $('#IdStatus option[value="6"]').addClass('red');
        }
        
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
    preparaForm('alterarStatus');
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
			$('#Id').val(data.Id);
		    $('#labelId').val(data.Id);
            $('#Chave').val(data.Chave);
            $('#Codigo').val(data.Codigo);
            $('#Tipo').val(data.Tipo);
            $('#Classificacao').val(data.Classificacao);
            
			$('#Titulo').val(data.Titulo);
			$('#Introducao').val(data.Introducao);
			$('#Objetivo').val(data.Objetivo);
			$('#Metodologia').val(data.Metodologia);
			$('#Resultado').val(data.Resultado);
			$('#Conclusao').val(data.Conclusao);
			$('#PalavraChave').val(data.PalavraChave);
            
            $('#Observacao').val(data.Observacao);
            $('#Referencia').val(data.Referencia);
			$('#DataApresentacao').val(data.DataApresentacao);
			$('#HoraApresentacao').val(data.HoraApresentacao);
            //setItemCombo('HoraApresentacao', data.HoraApresentacao);
            $('#Bloco').val(data.Bloco);
            $('#Poster').val(data.Poster);
            
			$('#pTitulo').html(data.Titulo);
            $('#pAutores').html(data.Autores);
			$('#pIntroducao').html(data.Introducao);
			$('#pObjetivo').html(data.Objetivo);
			$('#pMetodologia').html(data.Metodologia);
			$('#pResultado').html(data.Resultado);
			$('#pConclusao').html(data.Conclusao);
			$('#pPalavraChave').html(data.PalavraChave);
            
            setItemCombo('IdStatus', data.IdStatus);
			$('#DataCadastro').val(data.DataCadastro);
            $('#NomeUsuarioCadastro').val(data.NomeUsuarioCadastro);
            
            //$('#Ativo').val(data.Ativo);
            $('#Revisao').val(data.Revisao);
			$('#IdUsuarioAcao').val(data.IdUsuarioAcao);
			$('#DataAcao').val(data.DataAcao);
			$('#NomeUsuarioAcao').val(data.NomeUsuarioAcao);
            
            mostrarHistorico();
			mostrarAutorizacao();
            
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

function visualizarImpressao(Id)
{
	if (Id > 0){
		var url = 'views/resumo.mpdf.php?acao=visualizar&IdResumo=' + Id;
		var windowName = "_blank";
		var windowSettings = ''; //'top=50,left=50,width=935,height=550,toolbar=no,location=no,directories=no,scrollbars=yes,status=no,menubar=no,copyhistory=no'; 
		window.open(url, windowName, windowSettings, true);
	}
}

function selecionarFormato(){
	
	$('#dialog-formato').html('<p>Escolha formato do arquivo:</p>' +
	  '<input type="radio" required name="formato" id="formato" value="word" >WORD <br> ' +
	  '<input type="radio" required name="formato" id="formato" value="pdf">PDF <br><br>' +
	  '<p>Com ou sem autores?</p>' +
	  '<input type="radio" required name="exibeAutores" id="exibeAutores" value="S" >SIM <br>' +
	  '<input type="radio" required name="exibeAutores" id="exibeAutores" value="N" >NÃO <br><br>'); 	  

	  $( function() {
		$( "#dialog-formato" ).dialog({
		  resizable: false,
		  height: "auto",
		  width: 400,
		  modal: true,
		  buttons: {
			"Ok": function() {
				
				for (var i = 0; i < formato.length; i++) {
					if (formato[i].checked) {
						f = formato[i].value;	
					}
				}				
				for (var i = 0; i < exibeAutores.length; i++) {
					if (exibeAutores[i].checked) {
						a = exibeAutores[i].value;	
					}
				}				
				
				exportarResumo(f, a);
				
				$( this ).dialog( "close" );		
				  
			},
			"Cancela": function() {			
				$( this ).dialog( "close" );
			}
		  }
		});
	  } );		


}


function exportarResumo(formato, exibeAutor)
{
	var eventoPrincipal = $("#filtroIdEventoPrincipal").val();

	if (eventoPrincipal != '') { 
		if (formato == 'pdf'){
			myApp.hideAlert();
			var url = "views/resumo-lista.mpdf.php?";
			url += "acao=visualizar";
			url += "&Titulo=" + $("#filtroTitulo").val();
			url += "&Nome=" + $("#filtroNome").val();
			url += "&IdTipo=" + $("#filtroIdTipo").val();
			url += "&IdStatus=" + $("#filtroIdStatus").val();
			url += "&EventoPrincipal=" + eventoPrincipal;
			url += "&ExibeAutor=" + exibeAutor;
			var windowName = "_blank";
			var windowSettings = ''; //'top=50,left=50,width=935,height=550,toolbar=no,location=no,directories=no,scrollbars=yes,status=no,menubar=no,copyhistory=no'; 
			window.open(url, windowName, windowSettings, true);	
			myApp.showAlert('alerta', 'Relatório aberto em outra janela.');
			myApp.hidePleaseWait();
			
		}
		if (formato == 'word') {
			myApp.hideAlert();
			//var oTable = $('#tabListagem').DataTable();
			//var order = oTable.order();      
			var urlReport = 'interacao.php';
			//var sidx = order[0][0];
			//var sord = order[0][1];
			myApp.showPleaseWait();
			var urlReport = "interacao.php?controle="+oModulo.Controle;
			urlReport += "&acao=relatorioWord";
			urlReport += "&formato=" + formato;
			//urlReport += "&sidx=" + sidx;
			//urlReport += "&sord=" + sord;
			urlReport += "&Titulo=" + $("#filtroTitulo").val();
			urlReport += "&Nome=" + $("#filtroNome").val();
			urlReport += "&IdTipo=" + $("#filtroIdTipo").val();
			urlReport += "&IdStatus=" + $("#filtroIdStatus").val();
			urlReport += "&EventoPrincipal=" + eventoPrincipal;
			urlReport += "&ExibeAutor=" + exibeAutor;

			var windowName = "_blank";
			var windowSettings = ''; //'top=50,left=50,width=935,height=550,toolbar=no,location=no,directories=no,scrollbars=yes,status=no,menubar=no,copyhistory=no'; 
			window.open(urlReport, windowName, windowSettings, true);
			
			myApp.showAlert('alerta', 'Download dos resumos realizado.');
			myApp.hidePleaseWait();		
		}
	}else {
		myApp.showAlert('alerta', 'Evento Principal não foi selecionado!');
		myApp.hidePleaseWait();			
	}

}


function autorizar() { 
	if ($('#bt_autorizar').attr('disabled') != 'disabled'){
		myApp.hideAlert();
		bootbox.dialog({
			title: "Confirmação de Autorização",
			message: "Tem certeza que deseja autorizar a Resumo: '" + $('#Codigo').val() + "' ?" ,
			buttons: {
				danger: {
					label: "Confirmar",
					className: "btn-info",
					callback: function() {
						concluir_autorizacao();
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


function aprovar() { 
	if ($('#bt_aprovar').attr('disabled') != 'disabled'){
		myApp.hideAlert();
		bootbox.dialog({
			title: "Confirmação de Aprovação",
			message: "Tem certeza que deseja aprovar o Resumo: '" + $('#Codigo').val() + "' ?" ,
			buttons: {
				danger: {
					label: "Confirmar",
					className: "btn-info",
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


function reprovar() { 
	if ($('#bt_reprovar').attr('disabled') != 'disabled'){
		myApp.hideAlert();
		bootbox.dialog({
			title: "Confirmação de Reprovação",
			message: "Tem certeza que deseja reprovar a Resumo: '" + $('#Codigo').val() + "' ?" ,
			buttons: {
				danger: {
					label: "Confirmar",
					className: "btn-danger",
					callback: function() {
						concluir_reprovacao();
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

function concluir_reprovacao() 
{ 
	myApp.hideAlert();
	preparaForm('reprovar');
    $('#formCadastro').submit();
}

function comunicar(){  
    var Id = $('#Id').val(); //Id do Resumo
	
    //oModulo.Controle é igual a Resumo
    $.getJSON('interacao.php', {controle: oModulo.Controle, acao: "comunicar", Id: Id},
        function(data){ 
            if (data.sucesso){
                myApp.showAlert('sucesso', data.mensagem);
            } else {
                myApp.showAlert('alerta', data.mensagem);
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

function mostrarHistorico(){ 
    var Id = $('#Id').val();
    var Chave = $('#Chave').val();
    
    limparTabela('tabListagemHistorico');
    
    if ((Id!='') && (Chave!='')){ 
        console.log("interacao.php {controle: Resumo, acao: '"+oModulo.Controle+"', Id: '" + Id + "', Chave: '" + Chave + "'};"); 
		 
        $.getJSON('interacao.php', {controle: oModulo.Controle, acao: "listarHistorico", Id: Id, Chave: Chave },
            function(data){ 
                if (data.sucesso){
                    mostrarTabelaHistorico(data);
                } else {
                    myApp.showMensagem('#boxMensagemHistorico','alerta', data.mensagem);
                }
            }
        );
    }
}


function mostrarTabelaHistorico(data){
    console.log("mostrarTabelaHistorico('" + data.aaData.length + "');"); 

    limparTabela('tabListagemHistorico');
    
    var cnt = 0;
    var table = document.getElementById('tabListagemHistorico');  
    var tblBody = table.tBodies[0];  
    
    dataDocs = data.rows;
    
    if (data.aaData.length > 0) {
        
        // Preencher a Table
        for(i=0;i<data.aaData.length;i++){
            var newRow = tblBody.insertRow(-1);  
        
                if (i % 2)	newRow.style.backgroundColor = '#e8edf1';
	
				var newCell0 = newRow.insertCell(0);
				newCell0.innerHTML = ' ' + data.aaData[i][0];
                newCell0.className = 'text-center';

				var newCell1 = newRow.insertCell(1);
				newCell1.innerHTML = ' ' + data.aaData[i][1];
                newCell1.className = 'text-right';

				var newCell2 = newRow.insertCell(2);
				newCell2.innerHTML = ' ' + data.aaData[i][2];

				var newCell3 = newRow.insertCell(3);
				newCell3.innerHTML = data.aaData[i][4] + '&nbsp;';
                newCell3.className = 'text-right';

				var newCell4 = newRow.insertCell(4);
				newCell4.innerHTML = '&nbsp;' + data.aaData[i][5];

            cnt = cnt + 1;
        }
        if (cnt > 0){
            //document.getElementById('label_total_alunos').innerHTML = cnt;
        }

    }
}


function mostrarAutorizacao(){ 
    var Id = $('#Id').val();
    var Chave = $('#Chave').val();
    
    limparTabela('tabListagemAutorizacao');
    
    if ((Id!='') && (Chave!='')){   
        console.log("interacao.php {controle: Resumo, acao: '"+oModulo.Controle+"', Id: '" + Id + "', Chave: '" + Chave + "'};"); 
		
        $.getJSON('interacao.php', {controle: oModulo.Controle, acao: "retornar", Id: Id },
            function(data){ 
                if (data.sucesso){ 
                    mostrarTabelaAutorizacao(data);
                } else {
                    //myApp.showMensagem('#boxMensagemAutorizacao','alerta', data.mensagem);
                }
            }
        );
    }
}


function mostrarTabelaAutorizacao(data){   
    //console.log("mostrarTabelaAutorizacao'" + data.aaData.length + "');"); 
    limparTabela('tabListagemAutorizacao');
 
    var table = document.getElementById('tabListagemAutorizacao');  
    var tblBody = table.tBodies[0];  
    
    dataDocs = data.rows; 

	// Preencher a Table
	//for(i=0;i<2;i++){  
	if((data.File1) || (data.File2)){ 
		var newRow = tblBody.insertRow(-1);  
		if (0 % 2)	newRow.style.backgroundColor = '#e8edf1';
		var newCell0 = newRow.insertCell(0);
		newCell0.innerHTML = data.File1;
		newCell0.className = 'text-left';
		var newCell1 = newRow.insertCell(1);
		newCell1.innerHTML = '<a href="../admin/anexos/' + data.File1 + '"' + ' download><span class="fa fa-download green"></span> </a>';
		newCell1.className = 'text-center';
		var newCell1 = newRow.insertCell(2);
		newCell1.innerHTML = '<span class="fa fa-times red"></span> </a>';
		newCell1.className = 'text-center';
		var newCell1 = newRow.insertCell(3);
		newCell1.innerHTML = '<span class="fa fa-upload blue"></span> </a>';
		newCell1.className = 'text-center';
		//
		var newRow = tblBody.insertRow(-1);  
		if (1 % 2)	newRow.style.backgroundColor = '#e8edf1';
		var newCell0 = newRow.insertCell(0);
		newCell0.innerHTML = data.File2;
		newCell0.className = 'text-left';
		var newCell1 = newRow.insertCell(1);
		newCell1.innerHTML = '<a href="../admin/anexos/' + data.File2 + '"' + ' download><span class="fa fa-download green"></span> </a>';
		newCell1.className = 'text-center';
		var newCell1 = newRow.insertCell(2);
		newCell1.innerHTML = '<span class="fa fa-times red"></span> </a>';
		newCell1.className = 'text-center';
		var newCell1 = newRow.insertCell(3);
		newCell1.innerHTML = '<span class="fa fa-upload blue"></span> </a>';
		newCell1.className = 'text-center';
	} else{
		myApp.showMensagem('#boxMensagemAutorizacao','alerta', 'Não existe anexos de autorização para esse registro.');
	}
		

	//}
	
}



function IdStatus_onchange(value){
	if (value==2){ //Em Analise
		$("#boxObservacao").show();
	} else if (value==3){ //Com Pendência
		$("#boxObservacao").show();
	} else if (value==7){  //Recusado
		$("#boxObservacao").show();
	} else if (value==9){  //Com Pendência do NIT
		$("#boxObservacao").show();
	} else {
		$("#boxObservacao").hide();
	} 	
}

function inicializar(){
	
	popularEvento('filtroIdEventoPrincipal', oUsuario.IdEmpresa, '', 13);
	carregarLista(13);
    
	// PERMISSÕES DO USUARIO
	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}
	
    $('#bt_incluir').hide();
    //$('#bt_editar').hide();
    $('#bt_excluir').hide();
    //$('#bt_gravar').hide();

    $('#bt_reprovar').hide();
    $('#bt_aprovar').hide();
    //$('#bt_comunicar').hide();
    
    $('#bt_pesquisar').removeAttr('disabled');
    $('#bt_relatorio_excel').removeAttr('disabled');
	$('#bt_seleciona').removeAttr('disabled');
    
}

function popularEvento(cboNome, IdEmpresa, Ids, tecla){ 
    console.log("selecionarParente('" + cboNome + "', '" + IdEmpresa + "', '" + Ids + "', '" + tecla + "');"); 
    if(tecla==13){
        if (IdEmpresa) {
            clearCombo(cboNome);
            addItemCombo(cboNome, '', 'Carregando . . .');
			//Passando 1 como verdadeiro para IdParente, para buscar no Controle, somente Eventos Principais
            $.getJSON('interacao.php', {controle: 'Evento', acao: 'listarCombo', IdEmpresa: IdEmpresa, IdParente: 1},
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

</script>