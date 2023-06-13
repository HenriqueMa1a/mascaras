<script type="text/javascript">

var oModulo = {Id: <?php echo isset($MOD_ID)? $MOD_ID: 0; ?>, Chave: '<?php echo isset($MOD_CLASSE)? $MOD_CLASSE: ''; ?>', Classe: '<?php echo isset($MOD_CLASSE)? $MOD_CLASSE: ''; ?>'};
var oUsuario = {Id: '<?php echo isset($USO_ID)? $USO_ID: 0; ?>', Nome: '<?php echo isset($USO_NOME)? $USO_NOME: ''; ?>', Email: '<?php echo isset($USO_EMAIL)? $USO_EMAIL: ''; ?>'} ;

var mod_classe = '<?php echo $MOD_CLASSE; ?>';
var id_conta = 0;

jQuery(document).ready(function()
{
	
		
		/* JQUERY.TABS ******************************************************************************************************************************** */
		$.datepicker.setDefaults($.datepicker.regional['pt-BR']);
	
		/* JQUERY.FORM ****************************************************************************************************************************** */
    
        inicializar();
	
});

/* JS NORMAIS ************************************************************************************************************************************ */

function showLoading(){
	$.blockUI({ theme: true, title: '<?php echo isset($EMP_NOME) ? $EMP_NOME : ''; ?>', message: '<p>Por favor aguarde . . . </p>'}); 
}

function hideLoading(){
	$.unblockUI();
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
		
		// PERMISSÕES DO USUARIO
		
	} else if (acao == 'editar'){
		preparaForm('habilitar');

		// Inicializar Campos
        $("#acao").val(acao);
        
	} else if (acao == 'visualizar'){
		$("#boxToolbar").hide();
		$("#boxFormulario").show();
		$("#boxListagem").hide();

		// Inicializar Campos
        $("#acao").val(acao);
        
		// PERMISSÕES DO USUARIO
		
	} else if (acao == 'excluir'){
        // Inicializar Campos
        $('#controle').val('Usuario');
        $("#acao").val(acao);

    }
    $('#controle').val(oModulo.Controle);

}


function visualizar(Id) { 
		
    if ((Id == '') || (Id == '0')) {
        mostrarMensagem('erro', 'O Campo <b>Id</b> não foi passado por parametro.');
        return false; 
    } else {	
        showLoading();
        $.getJSON('../admin/interacao.php', {controle:'Inscricao',  acao: 'retornarPorUsuario', Id: Id},
            function(data){
                if (data.sucesso){
                    
                    preparaForm('limpar');
                    $("#Id").val(data.Id);
                    $("#Matricula").val(data.Id);

                    $('#IdUsuario').val(data.IdUsuario);
                    $('#Nome').val(data.Nome);
                    $('#Email').val(data.Email);
                    $('#NomeStatus').val(data.NomeStatus);

                    // Dados Pessoais
                    $('#Apelido').val(data.Campos.nomeParaCracha);
                    $('#DataNascimento').val(data.Campos.data_nascimento);
                    
                    // Dados Contato
                    $('#Telefone').val(data.Campos.telefone);
                    $('#Outro').val(data.Campos.oTelefone);
                    
                    // Dados Endereco
                    $('#Logradouro1').val(data.Campos.endereco);
                    $('#Numero1').val(data.Campos.numero);
                    $('#Complemento1').val(data.Campos.complemento);
                    $('#Bairro1').val(data.Campos.bairro);
                    $('#CEP1').val(data.Campos.cep);
                    $('#Cidade1').val(data.Campos.cidade);
                    $('#Estado1').val(data.Campos.estado);
                    $('#Pais1').val(data.Campos.pais);
            
                    if (data.IdStatus == 1){
                        $('#bt_editar').removeAttr('disabled');
                        $('#NomeStatus').val('Pendente');
                        
                    } else if (data.IdStatus == 8) {    // Parcial 
                        $('#bt_editar').attr("disabled", "disabled");
                        $('#NomeStatus').val('Em análise');
                        
                    } else if (data.IdStatus == 10) {   // Concluído
                        $('#bt_editar').attr("disabled", "disabled");
                        $('#NomeStatus').val('Em análise');
                        
                    } else {
                        $('#NomeStatus').val('Não definida');
                    }
                    
                    if ('<?php echo date('Ymd');?>' > '20160430'){ // Data de Edição da inscrição
                        $('#bt_editar').attr("disabled", "disabled");
                        $('#bt_editar').hide();
                        console.log ('Período de edição de inscrição encerrado.');
                    }
                    
                    $("#IdStatus").val(data.IdStatus);
                    $("#DataCadastro").val(data.DataCadastro);
                    $("#DataAcao").val(data.DataAcao);
                    
                    mostrarEventos();
                    
                    // pesquisar_resumo(IdUsuario);
                    hideLoading();
                    //mostrarMensagem('sucesso', 'Usuário carregado com Sucesso!');
                    //ocultarMensagem();
                } else {
                    mostrarMensagem('alerta', data.mensagem);
                }
            }
        );
        hideLoading();
    }
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


function mostrarEventos(){
    var IdUsuario = $('#IdUsuario').val();
    limparTabela('tabListagemEventos');
    
    $.getJSON('../admin/interacao.php', {controle: "EventoParticipante", acao: "listar", IdParticipante: IdUsuario },
        function(data){ 
            if (data.sucesso){
                mostrarTabelaEventos(data);
            } else {
                myApp.showMensagem('#boxMensagem3','alerta', data.mensagem);
            }
        }
    );
}


function mostrarTabelaEventos(data){
   
    console.log("mostrarTabelaEventos('" + data.aaData.length + "');"); 

    limparTabela('tabListagemEventos');
    
    var cnt = 0;
    var table = document.getElementById('tabListagemEventos');  
    var tblBody = table.tBodies[0];  
    
    dataDocs = data.rows;
    
    if (data.aaData.length > 0) {
        
        // Preencher a Table
        for(i=0;i<data.aaData.length;i++){
            var newRow = tblBody.insertRow(-1);  
        
                if (i % 2)	newRow.style.backgroundColor = '#e8edf1';
    
                var newCell0 = newRow.insertCell(0);
                newCell0.innerHTML = ' ' + data.aaData[i][2];
                newCell0.className = 'text-right';

                var newCell1 = newRow.insertCell(1);
                newCell1.innerHTML = ' ' + data.aaData[i][3];
                newCell1.className = 'text-left';

                var newCell2 = newRow.insertCell(2);
                newCell2.innerHTML = ' ' + data.aaData[i][8];
                newCell2.className = 'text-left';

                var newCell3 = newRow.insertCell(3);
                newCell3.innerHTML = ' ' + data.aaData[i][9];
                newCell3.className = 'text-left';

                var newCell4 = newRow.insertCell(4);
                newCell4.innerHTML = ' ' + data.aaData[i][10];
                newCell4.className = 'text-left';
                
            cnt = cnt + 1;
        }
        if (cnt > 0){
            //document.getElementById('label_total_alunos').innerHTML = cnt;
        }

    }
        
       
}

function editarInscricao(){
    showLoading();
    var windowName = "_top";
    var windowSettings = ''; //'top=50,left=50,width=935,height=550,toolbar=no,location=no,directories=no,scrollbars=yes,status=no,menubar=no,copyhistory=no'; 
    window.open('../index.php/2015-10-20-17-09-48/ficha-de-inscricao', windowName, windowSettings, true);
}

function sair(){
    console.log('sair');
    var windowName = "_top";
    var windowSettings = ''; //'top=50,left=50,width=935,height=550,toolbar=no,location=no,directories=no,scrollbars=yes,status=no,menubar=no,copyhistory=no'; 
    window.open('../index.php/login', windowName, windowSettings, true);
}

function visualizarCertificado(Chave){
    console.log('visualizarCertificado('+Chave+');');
    var windowName = "_blank";
    var windowSettings = ''; //'top=50,left=50,width=935,height=550,toolbar=no,location=no,directories=no,scrollbars=yes,status=no,menubar=no,copyhistory=no'; 
    window.open('../admin/views/rel-evento-certificado.pdf.php?acao=visualizar&Chave='+Chave, windowName, windowSettings, true);    
}

function inicializar() {
	var IdUsuario = parseFloat('<?php echo isset($USO_ID) ? $USO_ID : ''; ?>');
	if (IdUsuario > 0) {
		visualizar(IdUsuario);
	} else {
        sair();
    }
}

</script>