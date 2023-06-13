<script type="text/javascript">
var eventoPart=[];
var checados = new Array();
var checadosApagar = [];
var checadosNovos = [];

$(document).ready(function() { 

	$('#TipoPassaporte').hide();
	$('#TipoCPF').show();
	$('#TipoCPF').attr('disabled', 'disabled');

	$('.masktel').mask('(99) 99999-9999');
	//$("#TipoCPF").mask("999.999.999-99",{placeholder:"___.___.___-__"});
    $("#DataNascimento").mask("99/99/9999", {placeholder:"__/__/____"});
    $("#DataNascimento").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'dd/mm/yy', minDate: new Date()-18, maxDate: '0', showButtonPanel: true, yearRange: '1910:<?php echo date("Y")-16; ?>'});

	$('#DataNascimento').datepicker({
		format: "dd/mm/yyyy",
		language: "pt-BR"
	});
	
	carregarCheckEventos('ListaEventos', 13);
	
	preparaForm($("#acao").val());
	
	//carregarComboWorkShop('WorkShop', 30, '', 13);

	//Lista de Países, Estados e Cidades
	carregarComboPais('IdPais', '', 13);
	$('#IdPais').change(function(){
		if($('#IdPais').val() == 76){  //Brasil
			$('#IdEstado').removeAttr('disabled');
			$('#IdCidade').removeAttr('disabled');
		} else{
			$('#IdEstado').attr('disabled', 'disabled');
			$('#IdCidade').attr('disabled', 'disabled');
			$('#IdEstado').val('');
			$('#IdCidade').val('');
		}
	});	
		
	carregarComboEstado('IdEstado', 76, '', 13); 
	$('#IdEstado').change(function(){
		carregarComboCidade('IdCidade', $('#IdEstado').val(), '', 13);
	});
	//*--*//
	
	var str = "18/02/2020";
	var dataLimite = new Date(str.split('/').reverse().join('/'));
	var dataAtual = new Date();
	if(dataAtual > dataLimite) {
			$("#submeterSim").attr('disabled', 'disabled');
			$("#submeterNao").prop('checked', true);
	}
	
    /* JQUERY.FORM ****************************************************************************************************************************** */
    $("#formFicha").ajaxForm({type: 'POST', dataType: 'json', url: 'interacao.php', success: showResponse});
	
});

// post-submit callback 
function showResponse(data)
{  	
	myApp.hidePleaseWait(); 
    if (data.sucesso) { 
        myApp.showAlert('sucesso', data.mensagem);
        window.location.href = data.pagina;
    } else { 
        myApp.showAlert('erro', data.mensagem);
    } 
	window.scrollTo(0, 0);
	window.parent.scrollTo(0, 500);  	
}

function preparaForm(acao){

	if(acao == 'incluir'){
		$("#ViceDiretoria").hide();
		$("#lblEmpresa").hide();
		$("#lblCargo").hide();
		$("#Externo").hide();
		$("#OutraGraduacao").hide();
		$("#OutraPosGraduacao").hide();
		$("#OutroMestrado").hide();
		$("#OutroDoutorado").hide();
		$("#OutroPosDoutorado").hide();
	}else if(acao == 'editar'){ 
		$("#TipoCPF").attr('disabled', 'disabled');
		$("#TipoPassaporte").attr('disabled', 'disabled');
		$("#Senha").attr('disabled', 'disabled');
		$("#Senha2").attr('disabled', 'disabled');	

		var IdUsuario = parseInt($("#IdUsuario").val());
		visualizar(IdUsuario);
	}
}

function visualizar(Id){
    if ((Id == '') || (Id == '0')) {
        mostrarMensagem('error', 'The <b>Id</b> field was not passed by parameter.');
        return false; 
    } else { 
	
        $.getJSON('interacao.php', {controle:'PessoaIngles',  acao: 'retornar', Id: Id},
            function(data){  
                if (data.sucesso){	
					// Dados Pessoais
					if(data.Cpf){
						$('#TipoPassaporte').hide();
						$('#TipoCPF').show();						
						$("#TipoCPF").val(data.Cpf);
					}else{
						$('#TipoPassaporte').show();
						$('#TipoCPF').hide();
						$("#TipoPassaporte").val(data.Passaporte);
					}
			
					$('#NomeCompleto').val(data.NomeCompleto);
					$('#Email').val(data.Email);
					$('#Email2').val(data.Email);
					$('#Senha').val(data.Senha);
					$('#Senha2').val(data.Senha);
					$('#NomeCracha').val(data.NomeCracha);	
					$('#DataNascimento').val(data.DataNascimento);
					$('#Telefone').val(data.Telefone);
					carregarComboPais('IdPais', data.IdPais, 13);
					if(data.IdPais != 76){
						$('#IdEstado').attr('disabled', 'disabled');
						$('#IdCidade').attr('disabled', 'disabled');
					}
			
					carregarComboEstado('IdEstado', data.IdPais, data.IdEstado, 13);
					carregarComboCidade('IdCidade', data.IdEstado, data.IdCidade, 13);
	
					// Dados Profissionais
					//graduação
					var temCurso = false;
					$('#Graduacao option').each(function(){
						 if($(this).text() == data.Graduacao){
							 temCurso = true;
						 }						
					});					
					if(temCurso){
						setItemCombo('Graduacao', data.Graduacao);
						$("#OutraGraduacao").hide();
					} else{
						$("#OutraGraduacao").show(500);
						$("#OutraGraduacao").val(data.Graduacao);
						setItemCombo('Graduacao', "Other (Specify)");
					}
					//pos-graduação
					var temCurso = false;
					$('#PosGraduacao option').each(function(){
						 if($(this).text() == data.PosGraduacao){
							 temCurso = true;
						 }						
					});					
					if(temCurso){
						$("#ClickPosGraduacao").prop('checked', true);
						$('#PosGraduacao').removeAttr('disabled');
						setItemCombo('PosGraduacao', data.PosGraduacao);
						$("#OutraPosGraduacao").hide();
					} else{
						if(data.PosGraduacao != ""){
							$("#ClickPosGraduacao").prop('checked', true);
							$('#PosGraduacao').removeAttr('disabled');
							$("#OutraPosGraduacao").show(500);
							$("#OutraPosGraduacao").val(data.PosGraduacao);
							setItemCombo('PosGraduacao', "Other (Specify)");	
						} else{
							$("#ClickPosGraduacao").prop('checked', false);
							$("#OutraPosGraduacao").hide();
						}
					}					
					//mestrado					
					var temCurso = false;
					$('#Mestrado option').each(function(){
						 if($(this).text() == data.Mestrado){
							 temCurso = true;
						 }						
					});					
					if(temCurso){
						$("#ClickMestrado").prop('checked', true);
						$('#Mestrado').removeAttr('disabled');
						setItemCombo('Mestrado', data.Mestrado);
						$("#OutroMestrado").hide();
					} else{
						if(data.Mestrado != ""){
							$("#ClickMestrado").prop('checked', true);
							$('#Mestrado').removeAttr('disabled');
							$("#OutroMestrado").show(500);
							$("#OutroMestrado").val(data.Mestrado);
							setItemCombo('Mestrado', "Other (Specify)");	
						} else{
							$("#ClickMestrado").prop('checked', false);
							$("#OutroMestrado").hide();
						}
					}	
					//Doutorado					
					var temCurso = false;
					$('#Doutorado option').each(function(){
						 if($(this).text() == data.Doutorado){
							 temCurso = true;
						 }						
					});					
					if(temCurso){
						$("#ClickDoutorado").prop('checked', true);
						$('#Doutorado').removeAttr('disabled');
						setItemCombo('Doutorado', data.Doutorado);
						$("#OutroDoutorado").hide();
					} else{
						if(data.Doutorado != ""){
							$("#ClickDoutorado").prop('checked', true);
							$('#Doutorado').removeAttr('disabled');
							$("#OutroDoutorado").show(500);
							$("#OutroDoutorado").val(data.Doutorado);
							setItemCombo('Doutorado', "Other (Specify)");	
						} else{
							$("#ClickDoutorado").prop('checked', false);
							$("#OutroDoutorado").hide();
						}
					}	
					//Pos-Doutorado					
					var temCurso = false;
					$('#Doutorado option').each(function(){
						 if($(this).text() == data.Doutorado){
							 temCurso = true;
						 }						
					});					
					if(temCurso){
						$("#ClickPosDoutorado").prop('checked', true);
						$('#PosDoutorado').removeAttr('disabled');
						setItemCombo('PosDoutorado', data.PosDoutorado);
						$("#OutroPosDoutorado").hide();
					} else{
						if(data.PosDoutorado != ""){
							$("#ClickPosDoutorado").prop('checked', true);
							$('#PosDoutorado').removeAttr('disabled');
							$("#OutroPosDoutorado").show(500);
							$("#OutroPosDoutorado").val(data.PosDoutorado);
							setItemCombo('PosDoutorado', "Other (Specify)");	
						} else{
							$("#ClickPosDoutorado").prop('checked', false);
							$("#OutroPosDoutorado").hide();
						}
					}	
					////////////////
					
					if(data.Colaborador == "S"){ 
						$('#ColaboradorSim').prop('checked', true);
						$('#Diretoria').val(data.ViceDiretoria);
						$("#lblEmpresa").hide();
						$("#lblCargo").hide();
						$("#Externo").hide();
					} else{
						$('#ColaboradorNao').prop('checked', true);
						$('#Empresa').val(data.Empresa);
						$('#Cargo').val(data.Cargo);	
						$("#ViceDiretoria").hide();
					}

					if(data.Resumo == "S"){ 
						$("#submeterSim").prop('checked', true);
					} else{
						$("#submeterNao").prop('checked', true);

					}
				}
			}
		);
		
		//retornando os eventos selecionados 
		$.getJSON('../admin/interacao.php', {controle: "EventoParticipante", acao: "listar", IdParticipante: Id },
			function(data){ 
				if (data.sucesso){ 
					if (data.aaData.length > 0) { 
						for(i=0;i<data.aaData.length;i++){
							
							/*Bloco de instruções para mais de um evento*/
							$(".evento").each(function(){
								if(($(this).val() == data.aaData[i][2])&&(data.aaData[i][5] == Id)){									
									$(this).prop('checked', true);
									verificar();
								}									
							});	
							/*---*/
							
							//if((data.aaData[i][11] == 30)&&(data.aaData[i][5] == Id)){ //data.aaData[i][30] - Eventos do tipo Workshop
							//	$('#WorkShop').val(data.aaData[i][2]);
							//}
							
							if ((data.aaData[i][2] != 1) && (data.aaData[i][2] != 2)){ //não armazenar evento dos anos anteriores
								eventoPart[i] = data.aaData[i][1];
								//$("#EditarNovaInscricao").val("1"); //para saber se está editando a inscrição já realizada do evento atual
							}

						}
					}
				}
			}			
		);
		
	}
}

//bloco de funções necessárias quando selecionado vários Eventos
function checar(){
	
	$("#todosEventos").removeAttr('oninvalid');		
	$("#todosEventos").prop('required',false);	
	
	$('.evento').click(function(e) { 
		if($(this).is(':checked') == false){
			$('#todosEventos').prop('checked', false);
		} 

		if (verificarCheck()) { 
			$("#todosEventos").removeAttr('oninvalid');		
			$("#todosEventos").prop('required',false);		
		}else{
			$("#todosEventos").attr('oninvalid',"setCustomValidity('Select at least 1 event')");			
			$("#todosEventos").prop('required',true);
		}	   	   
	}); 
}

function verificarCheck(){	
		var checado=false;
		$("#ListaEventos").find("input[class='evento']").each(function(){
			if($(this).prop("checked"))   
				checado=true;
		});		
		return checado;
}

function verificar(){
	$("input[type=checkbox][name='evento[]']:checked").each(function(){
		$("#todosEventos").removeAttr('oninvalid');		
		$("#todosEventos").prop('required',false);	
	});
}
/**/

$(document).ready(function(e) {    

    $('#todosEventos').click(function(e) {
        if(this.checked) {
            $('.evento').each(function() {
                this.checked = true;
				$("#todosEventos").removeAttr('oninvalid');	
				$("#todosEventos").prop('required',false);				
            });
        }else{
            $('.evento').each(function() {
                this.checked = false; 
				$("#todosEventos").attr('oninvalid',"setCustomValidity('Select at least 1 event')");			
				$("#todosEventos").prop('required',true);				
            });         
        }
    });
		
	$("#ClickPosGraduacao").click(function(e) {     
		if($(this).is(':checked')){ //Retornar true ou false   
			$('#PosGraduacao').removeAttr('disabled');
			$("#PosGraduacao").prop('required',true);
		}else {
			$("#PosGraduacao").prop('selectedIndex', 0);
			$('#PosGraduacao').attr('disabled', 'disabled'); 
			$("#OutraPosGraduacao").hide();
			$("#OutraPosGraduacao").val("");
			$("#OutraPosGraduacao").prop('required',false);
			$("#PosGraduacao").prop('required',false);
		}
	}); 			

	$("#ClickMestrado").click(function(e) {     
		if($(this).is(':checked')){ //Retornar true ou false   
			$('#Mestrado').removeAttr('disabled');
			$("#Mestrado").prop('required',true);
		}else {
			$("#Mestrado").prop('selectedIndex', 0);
			$('#Mestrado').attr('disabled', 'disabled'); 
			$("#OutroMestrado").hide();
			$("#OutroMestrado").val("");
			$("#OutroMestrado").prop('required',false);
			$("#Mestrado").prop('required',false);
		}
	}); 		

	$("#ClickDoutorado").click(function(e) {     
		if($(this).is(':checked')){ //Retornar true ou false   
			$('#Doutorado').removeAttr('disabled');
			$("#Doutorado").prop('required',true);
		}else {
			$("#Doutorado").prop('selectedIndex', 0);
			$('#Doutorado').attr('disabled', 'disabled'); 
			$("#OutroDoutorado").hide();
			$("#OutroDoutorado").val("");
			$("#Doutorado").prop('required',false);
		}
	});			

	$("#ClickPosDoutorado").click(function(e) {     
		if($(this).is(':checked')){ //Retornar true ou false   
			$('#PosDoutorado').removeAttr('disabled');
			$("#PosDoutorado").prop('required',true);
		}else {
			$("#PosDoutorado").prop('selectedIndex', 0);
			$('#PosDoutorado').attr('disabled', 'disabled'); 
			$("#OutroPosDoutorado").hide();
			$("#OutroPosDoutorado").val("");
			$("#OutroPosDoutorado").prop('required',false);
			$("#PosDoutorado").prop('required',false);
		}
	}); 
		
});	 

function outraGraduacao(valor){
	if(valor == "Other (Specify)"){
		$("#OutraGraduacao").prop('required',true);
		$("#OutraGraduacao").show(500);  
	}else{
		$("#OutraGraduacao").prop('required',false);
		$("#OutraGraduacao").hide();		
	}
}

function outraPosGraduacao(valor){
	if(valor == "Other (Specify)"){
		$("#OutraPosGraduacao").prop('required',true);
		$("#OutraPosGraduacao").show(500);  
	}else{
		$("#OutraPosGraduacao").prop('required',false);
		$("#OutraPosGraduacao").hide();		
	}
}

function outroMestrado(valor){
	if(valor == "Other (Specify)"){
		$("#OutroMestrado").prop('required',true);
		$("#OutroMestrado").show(500);  
	}else{
		$("#OutroMestrado").prop('required',false);
		$("#OutroMestrado").hide();		
	}
}

function outroDoutorado(valor){
	if(valor == "Other (Specify)"){
		$("#OutroDoutorado").prop('required',true);
		$("#OutroDoutorado").show(500);  
	}else{
		$("#OutroDoutorado").prop('required',false);
		$("#OutroDoutorado").hide();		
	}
}

function outroPosDoutorado(valor){
	if(valor == "Other (Specify)"){
		$("#OutroPosDoutorado").prop('required',true);
		$("#OutroPosDoutorado").show(500);  
	}else{
		$("#OutroPosDoutorado").prop('required',false);
		$("#OutroPosDoutorado").hide();		
	}
}

function mostra(valor){
	if (valor == "N"){ 
		$("#Diretoria").prop('required',false);		
		$("#Empresa").prop('required',true);		
		$("#Cargo").prop('required',true);	
		$("#ViceDiretoria").hide("slow");	
		$("#Externo").show(500);
		$("#lblEmpresa").show(500);	
		$("#lblCargo").show(500);
		$("#Diretoria").val("");		
	}else { 
		$("#Diretoria").prop('required',true);			
		$("#Empresa").prop('required',false);		
		$("#Cargo").prop('required',false);	
		$("#ViceDiretoria").show(500);
		$("#Externo").hide("slow");			
		$("#lblEmpresa").hide("slow");	
		$("#lblCargo").hide("slow");
		$("#Empresa").val("");
		$("#Cargo").val("");		
	}
} 

/*
function carregarComboWorkShop(cboNome, IdTipoEvento, WorkShop, tecla){ 
    if(tecla==13){
        clearCombo(cboNome);
        if (IdTipoEvento) {
            addItemCombo(cboNome, '', 'Carregando . . .');
            $.getJSON('interacao.php', {controle: 'Evento', acao: 'listarCombo', IdTipoEvento: IdTipoEvento},
                function(data){
                    clearCombo(cboNome);
                    if (data.records > 0){ 
                        addItemCombo(cboNome, '', '[Selecione]');
                        for(i=0;i<data.rows.length;i++){
                            addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
                        }
                        if (WorkShop) setItemCombo(cboNome, WorkShop);
                    } else {
                        addItemCombo(cboNome, '', '[Não encontrado]');
                    }
                }
            );
        } else {
            addItemCombo(cboNome, '', '[Nenhum]');
        }
    }
}
*/

function carregarCheckEventos(divNome, tecla){ 
    if(tecla==13){ 
		$.getJSON('interacao.php', {controle: 'Evento', acao: 'listarEventosSeminario'}, 
			function(data){	
				if (data.records > 0){ 
					for(i=0;i<data.rows.length;i++){ 
						addCheck(divNome, 'evento', 'evento[]', 'evento'+i, data.rows[i].value, data.rows[i].text);
					}
				} else {
					addCheck(divNome, 'evento', 'evento[]', 'evento'+i, '', '[Not found]');
				}
			}
		);
    }
}

function carregarComboPais(cboNome, Pais, tecla){ 
    if(tecla==13){
        clearCombo(cboNome);
		addItemCombo(cboNome, '', 'Loading . . .');
		$.getJSON('interacao.php', {controle: 'Pais', acao: 'listarCombo'},
			function(data){
				clearCombo(cboNome);
				if (data.records > 0){ 
					addItemCombo(cboNome, '', '[Choose]');
					for(i=0;i<data.rows.length;i++){
						addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
					}
					if (Pais) setItemCombo(cboNome, Pais);
				} else {
					addItemCombo(cboNome, '', '[Not found]');
				}
			}
		);
    }
}

function carregarComboEstado(cboNome, IdPais, UF, tecla){ 
    if(tecla==13){
        clearCombo(cboNome);
        if (IdPais) {
            addItemCombo(cboNome, '', 'Loading . . .');
            $.getJSON('interacao.php', {controle: 'Estado', acao: 'listarCombo', IdPais: IdPais},
                function(data){
                    clearCombo(cboNome);
                    if (data.records > 0){ 
                        addItemCombo(cboNome, '', '[Choose]');
                        for(i=0;i<data.rows.length;i++){
                            addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
                        }
                        if (UF) setItemCombo(cboNome, UF);
                    } else {
                        addItemCombo(cboNome, '', '[Not found]');
                    }
                }
            );
        } else {
            addItemCombo(cboNome, '', '[None]');
        }
    }
}

function carregarComboCidade(cboNome, IdEstado, Cidade, tecla){ 
    if(tecla==13){
        clearCombo(cboNome);
        if (IdEstado) {
            addItemCombo(cboNome, '', 'Loading . . .');
            $.getJSON('interacao.php', {controle: 'Cidade', acao: 'listarCombo', IdEstado: IdEstado},
                function(data){
                    clearCombo(cboNome);
                    if (data.records > 0){
                        addItemCombo(cboNome, '', '[Choose]');
                        for(i=0;i<data.rows.length;i++){
                            addItemCombo(cboNome, data.rows[i].value, data.rows[i].text);
                        }
                        if (Cidade) setItemCombo(cboNome, Cidade);
                    } else {
                        addItemCombo(cboNome, '', '[Not found]');
                    }
                }
            );
        } else {
            addItemCombo(cboNome, '', '[None]');
        }
    }
}

function cancelar(){
	var windowName = "_top";
    var windowSettings = ''; //'top=50,left=50,width=935,height=550,toolbar=no,location=no,directories=no,scrollbars=yes,status=no,menubar=no,copyhistory=no'; 
    window.open('../index.php/my-subscription', windowName, windowSettings, true);
}

function alteraTipoDocumento(tipo){
	$('button#Tipo').html(tipo + " <span class='fa fa-caret-down'></span>");
	if (tipo =='CPF'){
		$('#TipoPassaporte').hide();
		$('#TipoCPF').show();
		$('#TipoCPF').removeAttr('disabled');
		$("#TipoCPF").mask("999.999.999-99",{placeholder:"___.___.___-__"});
		$("#TipoCPF").val("");
	}else{
		$('#TipoCPF').hide();
		$('#TipoPassaporte').show();
		$("#TipoPassaporte").val("");
	}
}

</script>