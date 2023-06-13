<script type="text/javascript">

/* JS JQUERY ************************************************************************************************************************************ */
jQuery(document).ready(function() 
{	
    $('[data-toggle=popover]').popover({placement : 'bottom', trigger : 'hover', delay: {'show': 50, 'hide': 200}}).click(function(e){
        if($(this).is('a') || $(this).is('button') || ($(this).attr('data-type')=='data')) $(this).popover('hide');
    });
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
	
	$('.masktel1').mask('(99) 9999-9999');
	$('.masktel2').mask('(99) 99999-9999');
	$("#CPF").mask("999.999.999-99",{placeholder:"___.___.___-__"});
    $("#dataNascimento").mask("99/99/9999", {placeholder:"__/__/____"});
    $("#dataNascimento").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'dd/mm/yy', minDate: new Date()-18, maxDate: '0', showButtonPanel: true, yearRange: '1910:<?php echo date("Y")-16; ?>'});

	$('#dataNascimento').datepicker({
		format: "dd/mm/yyyy",
		language: "pt-BR"
	});	
	
	/* JQUERY.FORM ****************************************************************************************************************************** */
    $("#formCadastro").ajaxForm({type: 'POST', dataType: 'json', url: 'interacao.php', beforeSubmit: validaForm, success: showResponse});
	
    inicializar();
});


/* JS NORMAIS ************************************************************************************************************************************ */
function carregarLista(tecla){	

    if(tecla==13){
        var urlAjax = "interacao.php?controle="+ oModulo.Controle +"&acao=listar";
		urlAjax += "&nome=" + $("#filtroNome").val();
        urlAjax += "&tipo=" + $("#filtroTipo").val();
        urlAjax += "&perfil=" + $("#filtroPerfil").val();
		
        myApp.showPleaseWait();
        
		if (typeof oTable == 'undefined') {
            oTable = $('#tabListagem').dataTable({
                "oLanguage": {"sUrl": "assets/js/jquery.dataTables.pt-br.txt"},
                "aaSorting": [[1, 'asc']],
                "aoColumnDefs": [
                    {"aTargets": [0], "bSearchable": false, "bVisible": true, "bSortable": false, "sWidth": "3%"},
                    {"aTargets": [1], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "3%"},
                    {"aTargets": [2], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "15%"},
                    {"aTargets": [3], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "10%"},
                    {"aTargets": [4], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "10%"},
                    {"aTargets": [5], "bSearchable": true,  "bVisible": true, "bSortable": true, "sWidth": "3%"}
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
	myApp.hidePleaseWait(); 

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
	}else if (($("#email").val() == '')){
			myApp.showAlert('erro', 'O Campo <b>Email</b> é de preenchimento obrigatório.');
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
		previewImagem('');
        $('#email').removeClass('green');
        $('#email').removeClass('red');
        $('#lblEmailError').html('');
        $('#lblEmailError').hide();		

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
		
		// Inicializar Campos
		$('#ativo').prop('checked', true);
		if($('#ativo').is(':checked') == true){ 
			$("#ativo").val(1);
		}else{
			$("#ativo").val(0);
		}
		carregarComboTipo('idTipo', '', 13);
		carregarComboPerfil('idPerfil', '', 13);		
        $("#acao").val(acao);
		dataCorrente = dataFormatada(new Date());
		$('#dataCadastro').val(dataCorrente);
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
		$('#IdUsuarioAcao').val(oUsuario.Id);
        
		// PERMISSÕES DO USUARIO
		$('#bt_editar').attr("disabled", "disabled");
		$('#bt_excluir').attr("disabled", "disabled");
		$('#bt_gravar').removeAttr('disabled');
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
        $('#controle').val('Usuario');
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
			$('#Id').val(data.Id);
		    $('#IdUser').val(data.IdUsuario);
			carregarComboTipo('idTipo', data.IdTipo, 13);
			carregarComboPerfil('idPerfil', data.IdPerfil, 13);
			$('#CPF').val(data.Cpf);				
			$('#nome').val(data.Nome); 
            $('#dataNascimento').val(data.DataNascimento);
			$('#email').val(data.Email);
			$('#conta').val(data.Conta);
			$('#senha').val(data.Senha);
			$('#senha2').val(data.Senha);
			if (data.Ativo){ 
				$('#ativo').prop('checked', true);
            } else {
				$('#ativo').prop('checked', false);
            }	
			$('#telefone').val(data.Telefone);
			$('#celular').val(data.Celular);
			$('#obs').val(data.Observacao);
			
			previewImagem(data.Imagem);

			$('#dataCadastro').val(data.DataCadastro);
			$('#dataAcao').val(data.DataAcao);
			$('#nomeUsuarioAcao').val(data.NomeUsuarioAcao);			

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
	$('#formFotografia').submit();
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
	carregarComboTipo('filtroTipo', '', 13);
	carregarComboPerfil('filtroPerfil', '', 13);
	carregarLista(13);
	$('#myfile').hide();
    
	// PERMISSÕES DO USUARIO
    //$("#bt_incluir").hide();
	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}

	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}
	if(typeof oModulo.Operacoes.incluir!=='undefined'){if(oModulo.Operacoes.incluir){$('#bt_incluir').removeAttr('disabled');}}
	
    $('#bt_pesquisar').removeAttr('disabled');
	//$('#bt_incluir').attr('disabled','disabled');
}

function carregarComboTipo(cboNome, Tipo, tecla){ 
    if(tecla==13){
        clearCombo(cboNome);
		addItemCombo(cboNome, '', 'Carregando . . .');
		
		$.getJSON('interacao.php', {controle: 'TipoUsuario', acao: 'listarCombo'},
			function(data){ 
				clearCombo(cboNome);
				if (data.records > 0){ 
					addItemCombo(cboNome, '', 'Selecione');
					for(i=0;i<data.rows.length;i++){
						if(data.rows[i].activated){
							addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
							$('#'+cboNome+' option[value="'+data.rows[i].value+'"]').removeClass('red');
						}else{
							addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
							$('#'+cboNome+' option[value="'+data.rows[i].value+'"]').addClass('red');
						}
					}
					if (Tipo) setItemCombo(cboNome, Tipo);
				} else {
					addItemCombo(cboNome, '', '[Não encontrado]');
				}
			}
		);
    }
}

function carregarComboPerfil(cboNome, Perfil, tecla){ 
    if(tecla==13){
        clearCombo(cboNome);
		addItemCombo(cboNome, '', 'Carregando . . .');
		
		$.getJSON('interacao.php', {controle: 'PerfilAcesso', acao: 'listarCombo'},
			function(data){ 
				clearCombo(cboNome);
				if (data.records > 0){ 
					addItemCombo(cboNome, '', 'Selecione');
					for(i=0;i<data.rows.length;i++){
						if(data.rows[i].activated){
							addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
							$('#'+cboNome+' option[value="'+data.rows[i].value+'"]').removeClass('red');
						}else{
							addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
							$('#'+cboNome+' option[value="'+data.rows[i].value+'"]').addClass('red');
						}
					}
					if (Perfil) setItemCombo(cboNome, Perfil);
				} else {
					addItemCombo(cboNome, '', '[Não encontrado]');
				}
			}
		);
    }
}

function selecionaFoto(){
	$('#myfile').click();
}


function previewImagem(caminho){ 

	var imagem = document.querySelector('input[id=myfile]').files[0];
	var preview = document.querySelector('img[name=foto]');
	
	var reader = new FileReader();
	
	reader.onloadend = function(){
		preview.src = reader.result;
	}
	
	if (caminho){
		preview.src = caminho;
	}else {
		if(imagem){
			reader.readAsDataURL(imagem);
		}else{
			preview.src = "fotos/foto-vazia.jpg";
		}
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

function conferirEmail(tecla)
{ 
    if(tecla===13){
        if ($('#email').val()!=''){
            $.getJSON('interacao.php', {controle: 'Usuario', acao: 'conferirEmail', Id: $('#Id').val(), Email: $('#email').val()},
                function(data){
                    if (data.sucesso){
                        $('#email').addClass('green');
                        $('#email').removeClass('red');
                        $('#lblEmailError').html('');
                        $('#lblEmailError').hide();
						contaEmail = ($('#email').val()).split('@');
						$('#conta').val(contaEmail[0]);
                        return true;
                    } else {
                        $('#email').removeClass('green');
                        $('#email').addClass('red');
                        $('#lblEmailError').html(data.mensagem);
                        $('#lblEmailError').show();
						$('#conta').val('');
                        return false;
                    }
                }
            );
        } else {
            $('#email').removeClass('green');
            $('#email').removeClass('red');
            $('#lblEmailError').html('');
            $('#lblEmailError').hide();
			$('#conta').val('');
        }
    }
}


</script>