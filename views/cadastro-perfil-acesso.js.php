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
                    {"aTargets": [0], "bSearchable": false, "bVisible": true, "bSortable": false, "sWidth": "2%"},
                    {"aTargets": [1], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "3%"},
					{"aTargets": [2], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "10%"},
					{"aTargets": [3], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "15%"},
					{"aTargets": [4], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "2%"}
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
} 


function validaForm(formData, jqForm, options)
{ 
 	myApp.hideAlert();
	
	if (($("#sigla").val() == '')){
		myApp.showAlert('erro', 'O Campo <b>Sigla</b> é de preenchimento obrigatório.');
		return false; 
	} else if (($("#descricao").val() == '')){
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
		mostrarModuloControleAcesso(0);
		mostrarModuloCadastro(0);
		mostrarModuloDistribuicao(0);	
		
		//habilita os campos para edição
		preparaForm('habilitar');
		$("#boxListagem").hide();

		// Inicializar Campos
        $("#acao").val(acao);
		$('#ativo').prop('checked', true);
		if($('#ativo').is(':checked') == true){ 
			$("#ativo").val(1);
		}else{
			$("#ativo").val(0);
		}	
		
        $('#IdUsuarioAcao').val(oUsuario.Id);
		$('#NomeUsuarioAcao').val(oUsuario.Nome);
		
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
        $('#controle').val('PerfilAcesso');
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
	$('#bt_funcoes').hide();
	carregarLista(13);
	
}

function novo() 
{ 
	myApp.showPleaseWait();
	myApp.hideAlert();
	preparaForm('incluir');
	$('#bt_funcoes').show();
	myApp.hidePleaseWait();
}

function editar() 
{ 
 	myApp.hideAlert();
    preparaForm('editar');
}

function visualizar(IdPerfil) 
{ 
	myApp.showPleaseWait();
	myApp.hideAlert();
	preparaForm('limpar');
	preparaForm('desabilitar');
	$('#bt_funcoes').hide();

	$.getJSON('interacao.php', {controle: oModulo.Controle, acao: "retornar", Id: IdPerfil}, 
	function(data){ 
		if (data.sucesso){ 
			$('#Id').val(data.idPerfil);
			//Dados do perfil
		    $('#idPerfil').val(data.idPerfil);
			$('#sigla').val(data.sigla);				
			$('#descricao').val(data.nome); 
           if (data.ativo){ 
				$('#ativo').prop('checked', true);
            } else {
				$('#ativo').prop('checked', false);
            }				
		
			mostrarModuloControleAcesso(IdPerfil);
			mostrarModuloCadastro(IdPerfil);
			mostrarModuloDistribuicao(IdPerfil);
            
		    preparaForm('visualizar');
			$('#IdUsuarioAcao').val(data.IdUsuarioAcao);
			$('#DataAcao').val(data.DataAcao);
			$('#NomeUsuarioAcao').val(data.NomeUsuarioAcao);
			$('#Acao').val(data.Acao);
			$('#revisao').val(data.Revisao);
            
		} else {                
			myApp.showAlert('erro', data.mensagem);
		}
		myApp.hidePleaseWait();
		myApp.goTop();
	});
}

function mostrarModuloControleAcesso(IdPerfil)
{
    var IdModuloPai = 300;
	$.getJSON('interacao.php', {controle: "Funcionalidade", acao: "listar", IdModuloPai: IdModuloPai, IdPerfil: IdPerfil },
		function(data){ 
			if (data.sucesso){ 
				funcionalidadesControleAcesso(data);
			} else {
				myApp.showMensagem('#tabListagemControleAcesso','alerta', data.mensagem);
			}
		}
	);
	
}


function funcionalidadesControleAcesso(data)
{ 
    limparTabela('tabListagemControleAcesso');
    var cnt = 0;
    var table = document.getElementById('tabListagemControleAcesso');  
	var tblBody = table.tBodies[0];  
    dataDocs = data.rows;
    if (data.aaData.length > 0) { 
        
        // Preencher a Table
        for(i=0;i<data.aaData.length;i++){  
            var newRow = tblBody.insertRow(-1);  
        
                if (i % 2)	newRow.style.backgroundColor = '#e8edf1';

				var newCell0 = newRow.insertCell(0);
				newCell0.innerHTML = ' ' + data.aaData[i][3]; //Descrição da Funcionalidade
                newCell0.className = 'text-left';

				var newCell1 = newRow.insertCell(1);
				newCell1.innerHTML = ' ' + data.aaData[i][4];  //Para marcar SIM
                newCell1.className = 'text-center';

				var newCell2 = newRow.insertCell(2);
				newCell2.innerHTML = ' ' + data.aaData[i][5];  //Para marcar NÃO
				newCell2.className = 'text-center';

			cnt = cnt + 1;
        }
    }
}

function mostrarModuloCadastro(IdPerfil)
{
    var IdModuloPai = 100;
	$.getJSON('interacao.php', {controle: "Funcionalidade", acao: "listar", IdModuloPai: IdModuloPai, IdPerfil: IdPerfil },
		function(data){ 
			if (data.sucesso){
				funcionalidadesModuloCadastro(data);
			} else {
				myApp.showMensagem('#tabListagemCadastros','alerta', data.mensagem);
			}
		}
	);
}

function funcionalidadesModuloCadastro(data)
{
    limparTabela('tabListagemCadastros');
    
    var cnt = 0;
    var table = document.getElementById('tabListagemCadastros');  
    var tblBody = table.tBodies[0];  
    
    dataDocs = data.rows;
    
    if (data.aaData.length > 0) {
        
        // Preencher a Table
        for(i=0;i<data.aaData.length;i++){
            var newRow = tblBody.insertRow(-1);  
        
                if (i % 2)	newRow.style.backgroundColor = '#e8edf1';
	
				var newCell0 = newRow.insertCell(0);
				newCell0.innerHTML = ' ' + data.aaData[i][3]; //Descrição da Funcionalidade
                newCell0.className = 'text-left';

				var newCell1 = newRow.insertCell(1);
				newCell1.innerHTML = ' ' + data.aaData[i][4];  //Para marcar SIM
                newCell1.className = 'text-center';

				var newCell2 = newRow.insertCell(2);
				newCell2.innerHTML = ' ' + data.aaData[i][5];  //Para marcar NÃO
				newCell2.className = 'text-center';

            cnt = cnt + 1;
        }
    }
}


function mostrarModuloDistribuicao(IdPerfil)
{
    var IdModuloPai = 200;
	$.getJSON('interacao.php', {controle: "Funcionalidade", acao: "listar", IdModuloPai: IdModuloPai, IdPerfil: IdPerfil },
		function(data){ 
			if (data.sucesso){
				funcionalidadesModuloDistribuicao(data);
			} else {
				myApp.showMensagem('#tabListagemCadastros','alerta', data.mensagem);
			}
		}
	);
}

function funcionalidadesModuloDistribuicao(data)
{
    limparTabela('tabListagemDistribuicao');
    
    var cnt = 0;
    var table = document.getElementById('tabListagemDistribuicao');  
    var tblBody = table.tBodies[0];  
    
    dataDocs = data.rows;
    
    if (data.aaData.length > 0) {
        
        // Preencher a Table
        for(i=0;i<data.aaData.length;i++){
            var newRow = tblBody.insertRow(-1);  
        
                if (i % 2)	newRow.style.backgroundColor = '#e8edf1';
	
				var newCell0 = newRow.insertCell(0);
				newCell0.innerHTML = ' ' + data.aaData[i][3]; //Descrição da Funcionalidade
                newCell0.className = 'text-left';

				var newCell1 = newRow.insertCell(1);
				newCell1.innerHTML = ' ' + data.aaData[i][4];  //Para marcar SIM
                newCell1.className = 'text-center';

				var newCell2 = newRow.insertCell(2);
				newCell2.innerHTML = ' ' + data.aaData[i][5];  //Para marcar NÃO
				newCell2.className = 'text-center';

            cnt = cnt + 1;
        }
    }
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

function limparTabela(IdObjeto)
{
    var table=document.getElementById(IdObjeto);
    var rowCount = table.rows.length;
    for(var i=1; i<rowCount; i++) {
        table.deleteRow(i);
        rowCount--;
        i--;
    }
}

function inicializar()
{
	carregarLista(13);
    
	// PERMISSÕES DO USUARIO
    //$("#bt_incluir").hide();
	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}

	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}
	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}
	
    $('#bt_pesquisar').removeAttr('disabled');
	//$('#bt_incluir').attr('disabled','disabled');
}

function habilitarFuncionalidades(){
	preparaForm('habilitar');
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

function habilitarSIM(idFuncionalidade){
	$('#simHabilita_'+idFuncionalidade).prop('checked', true);
	$('#naoHabilita_'+idFuncionalidade).prop('checked', false);
	$('#simHabilita_'+idFuncionalidade).val(idFuncionalidade);
	$('#naoHabilita_'+idFuncionalidade).val("");
}
	
function habilitarNAO(idFuncionalidade){
	$('#naoHabilita_'+idFuncionalidade).prop('checked', true);
	$('#simHabilita_'+idFuncionalidade).prop('checked', false);
	//$('#naoHabilita_'+idFuncionalidade).val(idFuncionalidade);
	$('#simHabilita_'+idFuncionalidade).val("");
}	
	
	
	




</script>