<script type="text/javascript">

var mod_classe = '<?php echo $MOD_CLASSE; ?>';

jQuery(document).ready(function(){
	
	/* JQUERY.TABS ******************************************************************************************************************************** */
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

		$("#arvore").treeview({
			toggle: function() {
				console.log("%s was toggled.", $(this).find(">span").text());
			}
		});
	
});
/* JS NORMAIS ************************************************************************************************************************************ */

</script>