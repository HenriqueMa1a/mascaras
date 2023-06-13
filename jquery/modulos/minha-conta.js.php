<script type="text/javascript">

var mod_classe = '<?php echo $MOD_CLASSE; ?>';
var id_conta = 0;

$(function () {
    var chart;
    $(document).ready(function() {
	
		
		/* JQUERY.TABS ******************************************************************************************************************************** */
		$.datepicker.setDefaults($.datepicker.regional['pt-BR']);
	
		/* JQUERY.FORM ****************************************************************************************************************************** */
			
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


function ocultar_quadros(){

	// Ocultar Quadros;
	exibir_objeto('div_creditos', 'none');
	exibir_objeto('div_desempenho', 'none');
	exibir_objeto('div_desempenho_disciplina_filtro', 'none');
	exibir_objeto('div_desempenho_disciplina', 'none');
	exibir_objeto('div_historico', 'none');
	exibir_objeto('div_filtro_questao', 'none');	
	exibir_objeto('div_questoes_tempo', 'none');

	exibir_objeto('div_desempenho2', 'none');
	exibir_objeto('div_desempenho_disciplina_filtro2', 'none');
	exibir_objeto('div_desempenho_disciplina2', 'none');
	
}

function inicializar() {

}

</script>