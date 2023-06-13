<script type="text/javascript">

var mod_classe = '<?php echo $MOD_CLASSE; ?>';
var id_conta = 0;

$(function () {
    var chart;
    $(document).ready(function() {
	
		
		/* JQUERY.TABS ******************************************************************************************************************************** */
		$.datepicker.setDefaults($.datepicker.regional['pt-BR']);
	
		/* JQUERY.FORM ****************************************************************************************************************************** */
			
	/* JQUERY.AJAXFORM ****************************************************************************************************************************** */
		var optionsForm = { 
			type: 'POST',
			url: 'modulos/' + mod_classe + '.action.php',
			target:        '#resultado',   // target element(s) to be updated with server response 
			beforeSubmit:  validaForm, // pre-submit callback 
			dataType: 'json',
			success:       showResponse  // post-submit callback 
		}; 
		$("#formCadastro").ajaxForm(optionsForm);
		
    });
    
	
});

/* JS NORMAIS ************************************************************************************************************************************ */

function showLoading(){
	$.blockUI({ theme: true, title: '<?php echo isset($EMP_NOME) ? $EMP_NOME : ''; ?>', message: '<p>Por favor aguarde . . . </p>'}); 
}

function hideLoading(){
	$.unblockUI();
}

function ir_para_titulo(){
	this.location = "#a_titulo";
}


// pre-submit callback 
function showRequest(formData, jqForm, options) { 
    var queryString = $.param(formData); 
 
    return true; 
} 
 
// post-submit callback 
function showResponse(data)  { 
    
	//alert(data); 
    hideLoading();

	if (data.sucesso) {
		mostrarMensagemTopo('sucesso', data.mensagem);
		
		preparaForm('limpar');
		preparaForm('desabilita');
		
		exibir_objeto('DivFormResumo', 'none');
		mostratListaResumo();
		
	} else {                
		mostrarMensagemTopo('erro', data.mensagem);
	} 

} 

function getValueRadio(objeto) {
    var radios = document.getElementsByName(objeto);

    for (var i = 0; i < radios.length; i++) {       
        if (radios[i].checked) {
            return radios[i].value;
            break;
        }
    }
	return '';
}

function limparValueRadio(objeto) {
    var radios = document.getElementsByName(objeto);
    for (var i = 0; i < radios.length; i++) {       
        radios[i].checked = false;
    }
}

function ContarPalavras(obj){     
	obj.value = obj.value.replace('  ', ' ');
	var Texto = Trim(obj.value);
	var palavra = Texto.split(' ');
	return palavra.length;
}

function validaForm(formData, jqForm, options) { 
 
	var TipoResumo  = getValueRadio("TipoResumo");
	var FlagPolitica  = (document.getElementById('FlagPolitica').checked);
	var Arquivo  = document.getElementById('Arquivo').value;

	if ((TipoResumo == '') || (TipoResumo == '0')) {
		mostrarMensagemTopo('erro', 'O Campo <b>Tipo de Resumo</b> é de preenchimento obrigatório.');
		return false; 
	} else if (!Arquivo) {
		mostrarMensagemTopo('erro', 'O Campo <b>Arquivo do Resumo</b> é de preenchimento obrigatório.');
		return false; 
	} else if (!FlagPolitica) {
		mostrarMensagemTopo('erro', 'Você deve concordar que este trabalho é inédito para poder submeter um Resumo.');
		return false; 
	}
    showLoading(); 
}

function dasabilitarFormulario() {

	var formData = document.getElementById('formCadastro');

    for (var i=0; i < formData.length; i++) { 
		switch(formData[i].type) {
			case ('radio'):
				formData[i].disabled=true;
			break;
			case ('checkbox'):
				formData[i].disabled=true;
			break;
			default:
				formData[i].disabled=true;
				formData[i].style.backgroundColor="#DDDDDD";
			break;
		}
	}
}

function preparaForm(acao) {

    var obj = MM_findObj("acao");
    if (obj){
        obj.value = acao;
    } else {
        alert("O campo 'acao' não encontrado.");
    }

	if (acao == 'limpar'){
		document.getElementById('IdConteudo').value = '';
		limparValueRadio("TipoResumo");
		document.getElementById('FlagPolitica').checked = false;
		document.getElementById('NomeArquivo').value = '';
		
	} else if (acao == 'desabilita'){

		dasabilitarFormulario();

	}
}

function mostrarMensagemTopo(tipo, mensagem){
    var obj =null ;
    
    obj = MM_findObj('msg_quadro');
    if (obj != null){
        obj.style.display = 'block';
        
        obj = MM_findObj('msg_icone');
        if (obj != null){
			obj.src = 'images/i_'+tipo+'.png';
        }
        var obj = MM_findObj('msg_texto');
        if (obj != null){
            obj.innerHTML = mensagem;
        }
    }
	
	this.location = "#PAG_TOPO";
}

function enviar() { 
	ocultarMensagem();
    $('#formCadastro').submit();

}

function cancelar(){

	preparaForm('limpar');
	preparaForm('desabilita');
	
	exibir_objeto('DivFormResumo', 'none');
	
	ir_para_titulo();
}

function ocultar_quadros(){

	// Ocultar Quadros;
	exibir_objeto('DivFormResumo', 'none');
	
}

function pesquisar_meu_poster(){
	
}


function mostrarDadosFormulario(IdUsuario) { 
	
	exibir_objeto('DivFormResumo', 'none');
	
	if ((IdUsuario == '') || (IdUsuario == '0')) {
		mostrarMensagem('erro', 'O Campo <b>Id</b> não foi passado por parametro.');
		return false; 
	} else {	
		showLoading();
		$.getJSON('admin/modulo/usuario/usuario.action.php', { acao: 'retornar', IdUsuario: IdUsuario},
			function(dados){
				if (dados.sucesso){
				
					habilitaForm('true');
					limpaForm();
				
					document.getElementById("acao").value = '';
					document.getElementById("IdUsuario").value = dados.IdUsuario;
					document.getElementById("label_TipoUsuario").innerHTML = dados.DescricaoTipoUsuario;
					document.getElementById("label_Nome").innerHTML = dados.Nome;
					document.getElementById("label_Email").innerHTML = dados.Email;
					document.getElementById("label_Telefone").innerHTML = dados.Telefone;

					document.getElementById("label_DataNascimento").innerHTML = dados.DataNascimento;
					document.getElementById("label_AreaAtuacao").innerHTML = dados.AreaAtuacao;
					//document.getElementById("label_Colaborador").innerHTML = (dados.FlagColaborador)? 'Sim': 'Não';

					if (dados.FlagColaborador == 1) {
						exibir_objeto('TR_COLABORADOR', '');
						exibir_objeto('TR_EXTERNO', 'none');
						document.getElementById("label_ViceDiretoria").innerHTML = dados.ViceDiretoria;
						document.getElementById("label_Departamento").innerHTML = dados.Departamento;
						document.getElementById("label_Divisao").innerHTML = dados.Divisao;
						document.getElementById("label_Secao").innerHTML = dados.Secao;
					} else {
						exibir_objeto('TR_COLABORADOR', 'none');
						exibir_objeto('TR_EXTERNO', '');
						document.getElementById("label_UnidadeExterna").innerHTML = dados.UnidadeExterna;
						document.getElementById("label_FormacaoAcademica").innerHTML = dados.FormacaoAcademica;
					}
					if (dados.IdStatusUsuario == 1){
						document.getElementById('img_Status').src = 'images/i_status_1.png';
					} else if (dados.IdStatusUsuario == 2) {
						document.getElementById('img_Status').src = 'images/i_status_2.png';
					} else if (dados.IdStatusUsuario == 3) {
						document.getElementById('img_Status').src = 'images/i_status_3.png';
					} else {
						document.getElementById('img_Status').src = 'images/i_status_1.png';
					}
					document.getElementById("label_StatusUsuario").innerHTML = dados.DescricaoStatus;
					//document.getElementById("label_DataAcesso").innerHTML = dados.DataAcesso;
					document.getElementById("label_DataInclusao").innerHTML = dados.DataInclusao;
					
					mostrarFlags(dados.CanalComunicacao)
					
					document.getElementById("label_FlagResumo").innerHTML = (dados.FlagResumo==1)? 'Sim': 'Não';
					//document.getElementById("label_FlagPolitica").innerHTML = (dados.FlagPolitica)? 'Sim': 'Não';
					
					if (dados.FlagResumo) {
						// Carregar os Conteudo do Banco
						//mostratListaResumo();
						exibir_objeto('bloco_resumo', '');
					} else {
						exibir_objeto('bloco_resumo', 'none');
					}
					
					// pesquisar_resumo(IdUsuario);
					hideLoading();					
					//mostrarMensagem('sucesso', 'Usuário carregado com Sucesso!');
					ocultarMensagem();
				} else {
					mostrarMensagem('alerta', dados.mensagem);
				}
			}
		);
		hideLoading();
	}
}

function mostratListaResumo(){
	
	limparTabela('tab_resumo');
	var IdUsuario = document.getElementById("IdUsuario").value;

		$.getJSON('admin/modulo/conteudo/conteudo.action.php', { acao: 'listar', IdUsuario: IdUsuario},
			function(data){ 
				if (data.sucesso){
				
					mostrarTabelaResumo(data);
					
					ocultarMensagem();
				} else {
					//mostrarMensagem('alerta', data.mensagem);
				}
			}
		);

}


function mostrarTabelaResumo(data) {  
	
	var table=document.getElementById('tab_resumo');  
	var tblBody = table.tBodies[0];  
	var total = 0; 
	
	if (data.rows.length > 0 ) {
	
		// Preencher a Table
		for(i=0;i<data.rows.length;i++){
			//document.write(data.aluno[i].nome);
			var newRow = tblBody.insertRow(-1);  
			if (i % 2)	newRow.style.backgroundColor = '#e8edf1';

			var newCell1 = newRow.insertCell(0);  
			//newCell1.innerHTML = data.rows[i].cell[4];  
			/*
			newCell1.innerHTML ="<a href='admin/modulo/conteudo/conteudo.pdf.php?acao=visualizar&IdConteudo=" + data.rows[i].cell[0] +"' titel='Visualizar Impressão' target='_blank'><img src='images/i_pdf.png' alt='Visualizar Impressão' class='img_icone' />"+ data.rows[i].cell[4] +"</a> <br/>";
			*/
			if (data.rows[i].cell[6] != '') {
				newCell1.innerHTML ="<a href='arquivos/" + data.rows[i].cell[6] +"' titel='Visualizar Impressão' target='_blank'><img src='images/i_download.png' alt='Visualizar Impressão' class='img_icone' />"+ data.rows[i].cell[6] +"</a> <br/>";
			} else {
				newCell1.innerHTML = data.rows[i].cell[4];  
			}
			newCell1.className = "td_titulo";
			newCell1.align = 'left';
 
			var newCell2 = newRow.insertCell(1);  
			newCell2.innerHTML = data.rows[i].cell[3]+'&nbsp;';  
			newCell2.className = "td_titulo";
			newCell2.align = 'left';

			var newCell4 = newRow.insertCell(2);  
			newCell4.innerHTML = '<img class="img_icone" src="images/i_status_doc_'+data.rows[i].cell[8]+'.png" />'+data.rows[i].cell[9]+'&nbsp;';  
			newCell4.className = "td_titulo";
			newCell4.align = 'left';

			var newCell5 = newRow.insertCell(3);  
			if (data.rows[i].cell[8] == '2'){
				newCell5.innerHTML = '<img class="img_icone botao_cadastro" src="images/i_abrir.gif" onclick="revisar_resumo('+data.rows[i].cell[0]+');"  />'+'&nbsp;';  
			} else {
				newCell5.innerHTML = '&nbsp;';  
			}
			newCell5.className = "td_titulo";
			newCell5.align = 'center';
			
			//total = total + parseFloat(data.rows[i].cell[3]);
		}
		//document.getElementById('label_total').innerHTML = total;
	}
}  


function mostrarFlags(Canal){

	if ((Canal & 1)==1){
		exibir_objeto('label_FlagAscom', '');
		document.getElementById('FlagAscom').src = 'images/checkbox_1.gif';
	} else exibir_objeto('label_FlagAscom', 'none');
	if ((Canal & 2)==2){
		exibir_objeto('label_FlagIndicacao', '');
		document.getElementById('FlagIndicacao').src = 'images/checkbox_1.gif';
	} else exibir_objeto('label_FlagIndicacao', 'none');
	if ((Canal & 4)==4){
		exibir_objeto('label_FlagBioMural', '');
		document.getElementById('FlagBioMural').src = 'images/checkbox_1.gif';
	} else exibir_objeto('label_FlagBioMural', 'none');
	if ((Canal & 8)==8){
		exibir_objeto('label_FlagBioDigital', '');
		document.getElementById('FlagBioDigital').src = 'images/checkbox_1.gif';
	} else exibir_objeto('label_FlagBioDigital', 'none');
	if ((Canal & 16)==16){
		exibir_objeto('label_FlagWebTV', '');
		document.getElementById('FlagWebTV').src = 'images/checkbox_1.gif';
	} else exibir_objeto('label_FlagWebTV', 'none');
	if ((Canal & 32)==32){
		exibir_objeto('label_FlagCartazes', '');
		document.getElementById('FlagCartazes').src = 'images/checkbox_1.gif';
	} else exibir_objeto('label_FlagCartazes', 'none');
	if ((Canal & 64)==64){
		exibir_objeto('label_FlagOutros', '');
		document.getElementById('FlagOutros').src = 'images/checkbox_1.gif';
	} else exibir_objeto('label_FlagOutros', 'none');

}

function abrirFormResumo(){
	
	exibir_objeto('DivFormResumo', '');

	habilitaForm('false');
	preparaForm('limpar');
	preparaForm('criar-resumo');
	this.location = '#a_box_resumo';
}

function limparTabela(nomeTabela) {
	// Linpar a Tabela
	var table=document.getElementById(nomeTabela);
	var rowCount = table.rows.length;
	for(var i=3; i<rowCount; i++) {
		//var row = table.rows[i];
		table.deleteRow(i);
		rowCount--;
		i--;
	}

}

function revisar_resumo(id_revisao){
	alert('Em construção!');
}

function inicializar() {
	var IdUsuario = '<?php echo isset($USO_ID) ? $USO_ID : ''; ?>';
	if (IdUsuario) {
		mostrarDadosFormulario(IdUsuario);
	}
}

</script>