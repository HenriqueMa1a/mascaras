            <div class="row clearfix">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard - ***EM CONSTRUÇÃO*** <small> <span class="glyphicon glyphicon-chevron-right"></span> <?php if (isset($sisUsuario->Contexto)){ echo $sisUsuario->Contexto;}  ; ?></small></h1>
                </div>
            </div>
			
			
            <div class="row clearfix">		
				<div class="col-lg-12">
					<figure class="highcharts-figure">
					  <div id="grafico2"></div>
					</figure>
				</div>
			</div>		

			<div class="separacao_linha-sm"><span></span></div>

            <div class="row clearfix">		
				<div class="col-lg-6">
					<figure class="highcharts-figure">
						<div id="grafico1"></div>
					</figure>
				</div>
				
				<div class="col-lg-6">
					<figure class="highcharts-figure">
					  <div id="grafico3"></div>
					</figure>
				</div>				
			</div>			
			
			
			
			
            <!-- ATALHOS - INICIO -->
            <div class="row clearfix">
                <div class="col-sm-12 col-md-8 col-lg-8 column">
                    <?php //require_once 'bloco_contratos.php'; ?>
                    <?php //require_once 'bloco_resultado.php'; ?>
                    <?php //require_once 'bloco_mapa.php'; ?>
                    <?php //require_once 'bloco_atalhos.php'; ?>
                </div>
				<!--
                <div class="col-sm-12 col-md-4 col-lg-4 column">
                    <?php //require_once 'bloco_alertas.php'; ?>
                    <div class="space-10 visible-sm"></div>
                    <div class="well"> 
                        <h3><span class="glyphicon glyphicon-info-sign"></span> Dica</h3>
                        <p>Mantenha seus dados atualizados para facilitar a comunicação do sistema.</p>
                    </div>
                </div> -->
            </div><!-- ATALHOS - FINAL -->
