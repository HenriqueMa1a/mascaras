<script type="text/javascript">

var $dia = '28';
	//Inicia a biblioteca jQuery
	$(function(){
		$('#thumbImagens a').click(function(){
			var linkAtual = $(this).attr('rel');
			$('.img-grande').find('a').attr('href',linkAtual);
			$('.img-grande').find('img').fadeOut({
				duration: 300, 
				easing: 'jswing',
				complete: function(){
					$('.img-grande').find('img').attr('src',linkAtual);
					$('.img-grande').find('img').load(function() {
						$('.img-grande').find('img').fadeIn(300);
					});
				}
			});
		});

	});

</script>