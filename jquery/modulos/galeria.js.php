<script type="text/javascript">

var mod_classe = '<?php echo $MOD_CLASSE; ?>';

jQuery(document).ready(function(){
	
	/* JQUERY.TABS ******************************************************************************************************************************** */
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

});
 
/* JS NORMAIS ************************************************************************************************************************************ */

function showLoading(){
	$.blockUI({ theme: true, title: 'Bio-Manguinhos', message: '<p>Por favor aguarde . . . </p>'}); 
}

function hideLoading(){
	$.unblockUI();
}

function inicializar(){
	
	Galleria.loadTheme('admin/jquery/themes/classic/galleria.classic.min.js');
	Galleria.run('#galleria');
	
	if (Galleria) { 
		//$("body").text('Galleria works');
		//alert('Galleria works');
	}
	
}
</script>