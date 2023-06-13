<script type="text/javascript">
var postoSelecionado;
var dataCorrente;
/* JS JQUERY ************************************************************************************************************************************ */
jQuery(document).ready(function() 
{	
    $('[data-toggle=popover]').popover({placement : 'bottom', trigger : 'hover', delay: {'show': 50, 'hide': 200}}).click(function(e){
        if($(this).is('a') || $(this).is('button') || ($(this).attr('data-type')=='data')) $(this).popover('hide');
    });
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
	
    $("#dataDistribuicao").mask("99/99/9999", {placeholder:"__/__/____"});
    $("#dataDistribuicao").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'dd/mm/yy', minDate: new Date()-18, maxDate: '0', showButtonPanel: true, yearRange: '1910:<?php echo date("Y")-16; ?>'});

	$('#dataDistribuicao').datepicker({
		format: "dd/mm/yyyy",
		language: "pt-BR"
	});	
	
	
	/* JQUERY.FORM ****************************************************************************************************************************** */
    $("#formCadastro").ajaxForm({type: 'POST', dataType: 'json', url: 'interacao.php', beforeSubmit: validaForm, success: showResponse});
	/*
	jQuery('#codigo').keypress(function(event){

		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			visualizar($('#codigo').val());
		}

	});	
	*/	
    inicializar();
});

/* JS NORMAIS ************************************************************************************************************************************ */

function inicializar() {
	carregarLista(13);
    
	// PERMISSÕES DO USUARIO
	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}

	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}
	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}
}

function carregarLista(tecla){	

    if(tecla==13){
        var urlAjax = "interacao.php?controle="+ oModulo.Controle +"&acao=listar";
        myApp.showPleaseWait();
        
		if (typeof oTable == 'undefined') {
            oTable = $('#tabListagem').dataTable({
                "oLanguage": {"sUrl": "assets/js/jquery.dataTables.pt-br.txt"},
                "aaSorting": [[1, 'asc']],
                "aoColumnDefs": [
                    {"aTargets": [0], "bSearchable": false, "bVisible": false, "bSortable": false, "sWidth": "2%"},
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

function showResponse(data) {
	myApp.hidePleaseWait(); 

	if (data.sucesso) {
		myApp.showAlert('sucesso', data.mensagem);
		carregarComboPosto('postoEntrega', postoSelecionado, 13);
		preparaForm('incluir');
		//carregarLista(13);
	} else {                
		myApp.showAlert('erro', data.mensagem);
	} 
	myApp.hidePleaseWait();
	window.scrollTo(0, 0);
	window.parent.scrollTo(0, 500);  
} 


function validaForm(formData, jqForm, options) {
 	myApp.hideAlert();
	
	if (($("#qtde").val() == '')){
		myApp.showAlert('erro', 'O Campo <b>Quantidade de Máscaras</b> é obrigatório.');
		return false; 
	} else if (($("#idPosto").val() == '')){
		myApp.showAlert('erro', 'O Campo <b>Posto de Entrega</b> é obrigatório.');
		return false;
	}
		
    myApp.showPleaseWait(); 
}

function preparaForm(acao){  
    
    console.log("preparaForm('"+ acao +"');");
    
    var formCadastro = $("#formCadastro");
    
	if (acao == 'limpar'){				// LIMPAR todos os Campos
        document.getElementById('formCadastro').reset();

		//$('#bt_gravar').attr("disabled", "disabled");
        $("#acao").val('');

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
       // $('#bt_cancelar').removeAttr('disabled');
		
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
		verificaPosto();
		dataCorrente = dataFormatada(new Date());
		$('#dataDistribuicao').val(dataCorrente);
		
		//$("input:text:eq(2):visible").focus();
		$('#codigo').focus();
		
		lerCodigo();

		// PERMISSÕES DO USUARIO
		if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_gravar').removeAttr('disabled');}}
		
	} else if (acao == 'editar'){
/*		preparaForm('habilitar');	

		// Inicializar Campos
        $("#acao").val(acao);
        
		// PERMISSÕES DO USUARIO
		$('#bt_editar').attr("disabled", "disabled");
		$('#bt_excluir').attr("disabled", "disabled");
		if(typeof oModulo.Operacoes.editar!=='undefined'){if(oModulo.Operacoes.editar){$('#bt_gravar').removeAttr('disabled');}}
*/	
	} else if (acao == 'visualizar'){
/*		// Inicializar Campos
        $("#acao").val('incluir');
		$("#boxToolbar").hide();
		$("#boxFormulario").show();
		$("#boxListagem").hide();
		$("#nome").css('color', 'blue');
		//verificaPosto();
		dataCorrente = dataFormatada(new Date());
		$('#dataHora').val(dataCorrente);			
		//$('#bt_gravar').removeAttr("disabled");		
*/		
	} else if (acao == 'excluir'){
/*        // Inicializar Campos
        $('#controle').val('Distribuicao');
        $("#acao").val(acao);
*/
	}

	$('#controle').val(oModulo.Controle);
}

function lerCodigo(){
	
	jQuery('#codigo').keypress(function(event){

		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			
			Id = $('#codigo').val();

			$.getJSON('interacao.php', {controle: 'Funcionario', acao: "retornarCodigoCartao", Id: Id},
			function(data){ 
				if (data.sucesso){ 
					// Carregar Dados;
					$('#nome').val(data.nome);
					$("#nome").css('color', 'blue');					
					$('#idFuncionario').val(data.idFunc);	
					qtdMascaras = data.qtdMascaras;
					$('#qtde').val(qtdMascaras);

					$('#idPosto').val( postoSelecionado );
					$('#dataDistribuicao').val(dataCorrente);
					
					if((data.tipoColaboradorAtivo == 1) || (data.alocacaoAtivo == 1)){
						confirmaEntrega(data.nome, qtdMascaras);
					}else{
						myApp.showAlert('alerta', 'Máscara não disponível para esse colaborador. <br>Favor entrar em contato com o administrador!');
					}

				} else {                
					myApp.showAlert('erro', 'CÓDIGO DE CARTÃO INVÁLIDO');
				}
				myApp.hidePleaseWait();
				myApp.goTop();
			});		
		}
	});		
}

function confirmaEntrega(nome, qtd) {
	
	$('#dialog-entrega').html( "<b>Confirma a entrega de <span class='blue'>(" + qtd + ")</span> máscaras para o(a) funcionário(a) abaixo? <br><br> <span class='blue'>" + nome + "</span></b>");
	  $( function() {
		$( "#dialog-entrega" ).dialog({
		  resizable: false,
		  height: "auto",
		  width: 400,
		  modal: true,
		  buttons: {
			"Confirmar": function() {
				$( this ).dialog( "close" );		
				gravar();	  
			},
			"Cancelar": function() {			
				$( this ).dialog( "close" );
				cancelar();
			}
		  }
		});
	  } );
}

function gravar() {
	myApp.hideAlert();
    $('#formCadastro').submit();
	
	//apenas para teste, depois deve ser executado o submit acima e verificar se vai ficar na mesma tela para novo cadastro
	//preparaForm('incluir'); 
}

function novo() {
	myApp.showPleaseWait();
	myApp.hideAlert();
	verificaPosto();
	preparaForm('incluir');
	myApp.hidePleaseWait();
}

function sair() {
 	var url = "controller.php?gm=dashboard&mod=abertura"; 
	$(location).attr('href',url);
}

function verificaPosto(){
	var posto;
	Id = oUsuario.Id;
	
	$.getJSON('interacao.php', {controle: 'Usuario', acao: "retornar", Id: Id},
	function(data){ 
		if (data.sucesso){ 
			//Verificar se é recepcionista do posto
			posto = data.IdPosto;
			
			if (posto){
				carregarComboPosto('postoEntrega', posto, 13);
				$('#postoEntrega').attr("disabled", "disabled");
				
			}else{
				carregarComboPosto('postoEntrega', '', 13);
				$('#postoEntrega').removeAttr('disabled');
			}			
			
		} else {                
			myApp.showAlert('erro', data.mensagem);
		}
		myApp.hidePleaseWait();
		myApp.goTop();
	});
}

function selecionaPosto(){
	postoSelecionado = $("#postoEntrega option:selected").val();
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
						if(data.rows[i].activated){
							addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
						}
					}
					if (posto) {
						setItemCombo(cboNome, posto);
						postoSelecionado = $("#postoEntrega option:selected").val();;
					}
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


//////****** Funções abaixo não estão sendo utilizadas **********////////

/*
function showRequest(formData, jqForm, options)
{
    var queryString = $.param(formData); 
    return true; 
} 
*/

function voltar() 
{ 
	myApp.hideAlert();
    preparaForm('listar');
	$("#boxToolbar").show();
	$("#boxFormulario").hide();
	myApp.hidePleaseWait();
	myApp.goTop();
	carregarLista(13);
	
}

function cancelar() 
{ 
	myApp.hideAlert();
	myApp.hidePleaseWait();
	myApp.goTop();
	preparaForm('incluir');
	
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
	//preparaForm('limpar');
	
	$.getJSON('interacao.php', {controle: 'Funcionario', acao: "retornarCodigoCartao", Id: Id},
	function(data){ 
		if (data.sucesso){ 
			// Carregar Dados;
		    //$('#Id').val(data.idDistribuicao);
			$('#nome').val(data.nome);	
			$('#idFuncionario').val(data.numSeq);	
			escala = data.escala;
			if(escala = '12x36') {
				$('#qtde').val(3);
				qtd = 3;
			}else{
				$('#qtde').val(2);
				qtd = 2;
			}
			$('#idPosto').val( postoSelecionado );
			
		    preparaForm('visualizar');
			confirmaEntrega(data.nome, qtd);

			} else {                
			myApp.showAlert('erro', 'CÓDIGO DE CARTÃO INVÁLIDO');
		}
		myApp.hidePleaseWait();
		myApp.goTop();
	});
	
}

function concluir_exclusao() 
{ 
	myApp.hideAlert();
	preparaForm('excluir');
    $('#formCadastro').submit();
}








</script>