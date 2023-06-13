<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

define('_JEXEC', 1 );
define('JPATH_BASE', "/var/www/html/isi" );
define( 'DS','/' );

require_once(JPATH_BASE.DS. 'includes'.DS.'defines.php' );
require_once(JPATH_BASE.DS.'includes'.DS.'framework.php' );
require_once(JPATH_BASE.DS.'libraries/joomla/database/factory.php');

$mainframe = JFactory::getApplication('site');
$mainframe->initialise();
$appJoomla = JFactory::getApplication();
$userJoomla = JFactory::getUser();
$status = $userJoomla->guest;
$id = $userJoomla->id;
?>

<!-- Guia Dados Pessoais -->
<form id="formFicha" name="formFicha" action="action.php" method="post">
	<input type="hidden" id="controle" name="controle" value="Pessoa" />
	<input type="hidden" name="IdEvento" id="IdEvento" value="" />
	<input type="hidden" name="IdParente" id="IdParente" value="" />
	<input type="hidden" name="EditarNovaInscricao" id="EditarNovaInscricao" value="" />
	<?php
	if($status == 1){//usuário não logado?>
		<input type="hidden" id="acao" name="acao" value="incluir"/>
		<input type="hidden" id="IdUsuario" name="IdUsuario" value="" />
	<?php
	} else { //usuário logado?>
		<input type="hidden" id="acao" name="acao" value="editar"/>
		<input type="hidden" id="IdUsuario" name="IdUsuario" value="<?php echo $id; ?>" />
	<?php
	} ?>

	<div class="panel panel-primary" style="display: block; border-color: #3b83db;">
		<div class="panel-heading" style="background-image: -webkit-linear-gradient(top,#3b83db 0,#3b83db 100%);">Dados Pessoais</div>
			<div class="panel-body">
				<div class="row" >
					<div class="col-md-6" style="margin-bottom: 20;" > 			
					  <label for="Tipo">* Tipo de Documento</label>
					  <div class="input-group">
						<div class="input-group-btn">
						  <button id="Tipo" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" style="line-height: 400px;">Tipo
							<span class="fa fa-caret-down"></span></button>
						  <ul class="dropdown-menu">
							<li><a href="#" onclick="alteraTipoDocumento('CPF');">CPF</a></li>
							<li><a href="#" onclick="alteraTipoDocumento('Passaporte');">Passaporte</a></li>
						  </ul> 
						</div>
						<!-- /btn-group -->
						<input type="text" class="form-control maskCPF" style="margin-top: 5px; width: 50%" id="TipoCPF" name="TipoCPF" >
						<input type="text" class="form-control" style="margin-top: 5px; width: 50%" id="TipoPassaporte" name="TipoPassaporte" >
					  </div>					
					</div>
				</div>
			
			
				<div class="row">
					<div class="col-md-6"> 	
						<div class="form-group">
							<label for="NomeCompleto">* Nome Completo: (Como será apresentado no Certificado)</label>
							<input type="text" class="form-control" name="NomeCompleto" id="NomeCompleto" placeholder="Insira o nome" required></input>
						</div>						
						
					<!--
						<div class="form-group">
							<label for="Cpf">* Login (Seu CPF):</label>
							<input type="text" class="form-control maskCPF" style="width: 40%" name="Cpf" id="Cpf" required></input>
						</div>	-->								
					</div> 

					<div class="col-md-6"> 
						<label for="NomeCracha">* Nome para o crachá:</label>			
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
							<input type="text" class="form-control" style="width: 40%" name="NomeCracha" id="NomeCracha" required>
						</div>									
					</div>					
				</div>	
				<!--xxxx-->
				<div class="row">
					<div class="col-md-6"> 						
						<label for="Email">* E-mail:</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i></span>
							<input type="email" class="form-control" style="width: 40%" name="Email" id="Email" required></input>
						</div>					
					</div>

					<div class="col-md-6"> 
						<label for="Email2">* Confirmação de e-mail:</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i></span>
							<input type="text" class="form-control" style="width: 40%" name="Email2" id="Email2" required></input>
						</div>						   				
					</div>					
				</div>	
				<!--xxxx-->	
				<div class="row">
					<div class="col-md-6">
						<br>
						<label for="Senha">* Senha:</label>
						<div class="input-group">  
							<span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
							<input type="password" class="form-control" style="width: 40%" name="Senha" id="Senha" required></input>
						</div>
					</div>

					<div class="col-md-6">  
						<br>
						<label for="Senha2">* Confirmação de Senha:</label> 
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
							<input type="password" class="form-control" style="width: 40%" name="Senha2" id="Senha2" required></input>
						</div>				
					</div>					
				</div>
				<!--xxxx-->
				<div class="row">
					<div class="col-md-6">
						<br>
						<label for="Telefone">* Telefone:</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-phone fa-fw" aria-hidden="true"></i></span>
							<input type="text" class="form-control masktel" style="width: 40%" name="Telefone" id="Telefone" required></input>
						</div>
					</div>

					<div class="col-md-6"> 
						<br>
						<label for="DataNascimento">* Data de Nascimento:</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>			
							<input type="text" class="form-control" style="width: 40%" name="DataNascimento" id="DataNascimento" required></input>
						</div>			
					</div>															
				</div>
				<!--xxxx-->										
				<div class="row">
				
					<div class="col-md-4"> 	
						<div class="form-group">
							<br>
							<label class="control-label" for="IdPais">* Pais:</label>
							<select class="form-control" style="width: 80%" name="IdPais" id="IdPais" required>
								<option value="">[Selecione]</option>
							</select>
						</div>					
					</div>				
				
					<div class="col-md-4"> 	
						<div class="form-group">
							<br>
							<label class="control-label" for="IdEstado">* Estado:</label>
							<select class="form-control" style="width: 80%" name="IdEstado" id="IdEstado" required>
								<option value="">[Selecione]</option>
							</select>
						</div>					
					</div>

					<div class="col-md-4"> 
						<div class="form-group">
							<br>
							<label>* Cidade:</label>
							<select class="form-control" style="width: 80%" name="IdCidade" id="IdCidade" required>
								<option value="">[Selecione]</option>
							</select>
						</div>					
					</div>					
				</div>

			</div>
	</div>

	 <!-- Guia Dados Profissionais -->
	<div class="panel panel-primary" style="display: block; border-color: #3b83db;">
		<div class="panel-heading" style="background-image: -webkit-linear-gradient(top,#3b83db 0,#3b83db 100%);">Formação</div>
			<div class="panel-body">

				<label for="Graduacao">* Graduação (Atenção! Ao escolher a área, assumo que a informação se trata de curso concluído e que possuo diploma ou certificado de conclusão):</label>	
				<div class="form-inline">						
					<select class="form-control" style="width: 30%" name="Graduacao" id="Graduacao" onchange="outraGraduacao(this.value)" required>
								<option value="">Escolha uma Graduação</option>
								<option>Administração</option>
								<option>Arquitetura e Urbanismo</option>
								<option>Biofísica</option>
								<option>Biologia Geral</option>
								<option>Bioquímica</option>
								<option>Ciência da computação</option>
								<option>Ciência da Informação</option>
								<option>Comunicação</option>
								<option>Desenho Industrial</option>
								<option>Direito</option>
								<option>Economia</option>
								<option>Enfermagem</option>
								<option>Engenharia Biomédica</option>
								<option>Engenharia Civil</option>
								<option>Engenharia de Produção</option>
								<option>Engenharia Elétrica</option>
								<option>Engenharia Mecânica</option>
								<option>Engenharia Nuclear</option>
								<option>Engenharia Química</option>
								<option>Engenharia Sanitária</option>
								<option>Farmácia</option>
								<option>Farmacologia</option>
								<option>Física</option>
								<option>Fisiologia</option>
								<option>Genética</option>
								<option>Imunologia</option>
								<option>Matemática</option>
								<option>Medicina Veterinária</option>
								<option>Medicina</option>
								<option>Microbiologia</option>
								<option>Morfologia</option>
								<option>Nutrição</option>
								<option>Odontologia</option>
								<option>Parasitologia</option>
								<option>Probabilidade e Estatística</option>
								<option>Química</option>
								<option>Saúde Coletiva (Epidemiologia / Saúde Pública / Medicina Preventiva)</option>
								<option>Outras (Especificar)</option>

					</select>

					<input class="form-control" type="text" style="width: 60%" name="OutraGraduacao" id="OutraGraduacao" placeholder="Especificar outra graduação"></input>
				</div>	
				
				<br>
				<label>Titulação Máxima:</label>
				<div class="row"> 
					<div class="col-md-3"> 
						<div class="checkbox">
							<label>
							  <input type="checkbox" name="posGraduacao" id="ClickPosGraduacao"/>
							  Pós-Graduação
							</label>
						</div>
						<div class="form-group">
						   <select class="form-control" name="PosGraduacao" id="PosGraduacao" onchange="outraPosGraduacao(this.value)" disabled>
								<option value="">Escolha uma Pós-Graduação</option>
								<option>Administração</option>
								<option>Arquitetura e Urbanismo</option>
								<option>Biofísica</option>
								<option>Biologia Geral</option>
								<option>Bioquímica</option>
								<option>Ciência da computação</option>
								<option>Ciência da Informação</option>
								<option>Comunicação</option>
								<option>Desenho Industrial</option>
								<option>Direito</option>
								<option>Economia</option>
								<option>Enfermagem</option>
								<option>Engenharia Biomédica</option>
								<option>Engenharia Civil</option>
								<option>Engenharia de Produção</option>
								<option>Engenharia Elétrica</option>
								<option>Engenharia Mecânica</option>
								<option>Engenharia Nuclear</option>
								<option>Engenharia Química</option>
								<option>Engenharia Sanitária</option>
								<option>Farmácia</option>
								<option>Farmacologia</option>
								<option>Física</option>
								<option>Fisiologia</option>
								<option>Genética</option>
								<option>Imunologia</option>
								<option>Matemática</option>
								<option>Medicina Veterinária</option>
								<option>Medicina</option>
								<option>Microbiologia</option>
								<option>Morfologia</option>
								<option>Nutrição</option>
								<option>Odontologia</option>
								<option>Parasitologia</option>
								<option>Probabilidade e Estatística</option>
								<option>Química</option>
								<option>Saúde Coletiva (Epidemiologia / Saúde Pública / Medicina Preventiva)</option>
								<option>Outras (Especificar)</option>
						   </select>
						</div>	
						<input class="form-control" type="text" name="OutraPosGraduacao" id="OutraPosGraduacao" placeholder="Especificar..."></input>
						
					</div>
					
					<div class="col-md-3">
						<div class="checkbox">
							<label>
							  <input type="checkbox" name="mestrado" id="ClickMestrado"/>
							  Mestrado
							</label>
						  </div>
						<div class="form-group">
						   <select class="form-control" name="Mestrado" id="Mestrado" onchange="outroMestrado(this.value)" disabled>
								<option value="">Escolha um Mestrado</option>
								<option>Administração</option>
								<option>Arquitetura e Urbanismo</option>
								<option>Biofísica</option>
								<option>Biologia Geral</option>
								<option>Bioquímica</option>
								<option>Ciência da computação</option>
								<option>Ciência da Informação</option>
								<option>Comunicação</option>
								<option>Desenho Industrial</option>
								<option>Direito</option>
								<option>Economia</option>
								<option>Enfermagem</option>
								<option>Engenharia Biomédica</option>
								<option>Engenharia Civil</option>
								<option>Engenharia de Produção</option>
								<option>Engenharia Elétrica</option>
								<option>Engenharia Mecânica</option>
								<option>Engenharia Nuclear</option>
								<option>Engenharia Química</option>
								<option>Engenharia Sanitária</option>
								<option>Farmácia</option>
								<option>Farmacologia</option>
								<option>Física</option>
								<option>Fisiologia</option>
								<option>Genética</option>
								<option>Imunologia</option>
								<option>Matemática</option>
								<option>Medicina Veterinária</option>
								<option>Medicina</option>
								<option>Microbiologia</option>
								<option>Morfologia</option>
								<option>Nutrição</option>
								<option>Odontologia</option>
								<option>Parasitologia</option>
								<option>Probabilidade e Estatística</option>
								<option>Química</option>
								<option>Saúde Coletiva (Epidemiologia / Saúde Pública / Medicina Preventiva)</option>
								<option>Outras (Especificar)</option>
						   </select>
						</div>	
						<input class="form-control" type="text" name="OutroMestrado" id="OutroMestrado" placeholder="Especificar..."></input>
					</div>
					
					<div class="col-md-3"> 
						<div class="checkbox">
							<label>
							  <input type="checkbox" name="doutorado" id="ClickDoutorado"/>
							  Doutorado
							</label>
						</div>	
						<div class="form-group">
						   <select class="form-control" name="Doutorado" id="Doutorado" onchange="outroDoutorado(this.value)" disabled>
								<option value="">Escolha um Doutorado</option>
								<option>Administração</option>
								<option>Arquitetura e Urbanismo</option>
								<option>Biofísica</option>
								<option>Biologia Geral</option>
								<option>Bioquímica</option>
								<option>Ciência da computação</option>
								<option>Ciência da Informação</option>
								<option>Comunicação</option>
								<option>Desenho Industrial</option>
								<option>Direito</option>
								<option>Economia</option>
								<option>Enfermagem</option>
								<option>Engenharia Biomédica</option>
								<option>Engenharia Civil</option>
								<option>Engenharia de Produção</option>
								<option>Engenharia Elétrica</option>
								<option>Engenharia Mecânica</option>
								<option>Engenharia Nuclear</option>
								<option>Engenharia Química</option>
								<option>Engenharia Sanitária</option>
								<option>Farmácia</option>
								<option>Farmacologia</option>
								<option>Física</option>
								<option>Fisiologia</option>
								<option>Genética</option>
								<option>Imunologia</option>
								<option>Matemática</option>
								<option>Medicina Veterinária</option>
								<option>Medicina</option>
								<option>Microbiologia</option>
								<option>Morfologia</option>
								<option>Nutrição</option>
								<option>Odontologia</option>
								<option>Parasitologia</option>
								<option>Probabilidade e Estatística</option>
								<option>Química</option>
								<option>Saúde Coletiva (Epidemiologia / Saúde Pública / Medicina Preventiva)</option>
								<option>Outras (Especificar)</option>
						   </select>
						</div>
						<input class="form-control" type="text" name="OutroDoutorado" id="OutroDoutorado" placeholder="Especificar..."></input>					
					</div>
					
					<div class="col-md-3">
						<div class="checkbox">
							<label>
							  <input type="checkbox" name="posDoutor" id="ClickPosDoutorado"/>
							  Pós-Doutorado
							</label>
						</div>	
						<div class="form-group">
						   <select class="form-control" name="PosDoutorado" id="PosDoutorado" onchange="outroPosDoutorado(this.value)" disabled>
								<option value="">Escolha um Pós-Doutorado</option>
								<option>Administração</option>
								<option>Arquitetura e Urbanismo</option>
								<option>Biofísica</option>
								<option>Biologia Geral</option>
								<option>Bioquímica</option>
								<option>Ciência da computação</option>
								<option>Ciência da Informação</option>
								<option>Comunicação</option>
								<option>Desenho Industrial</option>
								<option>Direito</option>
								<option>Economia</option>
								<option>Enfermagem</option>
								<option>Engenharia Biomédica</option>
								<option>Engenharia Civil</option>
								<option>Engenharia de Produção</option>
								<option>Engenharia Elétrica</option>
								<option>Engenharia Mecânica</option>
								<option>Engenharia Nuclear</option>
								<option>Engenharia Química</option>
								<option>Engenharia Sanitária</option>
								<option>Farmácia</option>
								<option>Farmacologia</option>
								<option>Física</option>
								<option>Fisiologia</option>
								<option>Genética</option>
								<option>Imunologia</option>
								<option>Matemática</option>
								<option>Medicina Veterinária</option>
								<option>Medicina</option>
								<option>Microbiologia</option>
								<option>Morfologia</option>
								<option>Nutrição</option>
								<option>Odontologia</option>
								<option>Parasitologia</option>
								<option>Probabilidade e Estatística</option>
								<option>Química</option>
								<option>Saúde Coletiva (Epidemiologia / Saúde Pública / Medicina Preventiva)</option>
								<option>Outras (Especificar)</option>
						   </select>
						</div>
						<input class="form-control" type="text" name="OutroPosDoutorado" id="OutroPosDoutorado" placeholder="Especificar..."></input>										
					</div>
				</div>				
				
				<br/>	
			
				<div class="form-group">
					<label>* Colaborador de Bio-Manguinhos?</label><br>
					<label class="radio-inline"><input type="radio" required name="Colaborador" id="ColaboradorNao" value="N" onclick="mostra(this.value)">Não</label>
					<label class="radio-inline"><input type="radio" required name="Colaborador" id="ColaboradorSim" value="S" onclick="mostra(this.value)">Sim</label>				
				</div>	

				<div class="form-group" id="ViceDiretoria">
				   <label>* Vice-Diretoria:</label>
				   <select class="form-control" style="width: 25%" name="Diretoria" id="Diretoria">
						<option value="">Selecione uma Vice-Diretoria</option>
						<option value="DIBIO">DIBIO</option>
						<option value="VGEST">VGEST</option>
						<option value="VQUAL">VQUAL</option>
						<option value="VDTEC">VDTEC</option>
						<option value="VPROD">VPROD</option>
				   </select>
				</div>	
				
				<div class="row" id="Externo" name="Externo"> 
					<div class="col-md-6"> 	
						<label for="empr" id="lblEmpresa">* Empresa/Instituição:</label>
						<div class="input-group" id="empr">		
							<span class="input-group-addon"><i class="fa fa-institution"></i></span>
							<input type="text" class="form-control" name="Empresa" id="Empresa" >
						</div>	
					</div>
					<div class="col-md-6"> 					
						<label for="carg" id="lblCargo">* Cargo/Função:</label>	
						<div class="input-group" id="carg">
							<span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
							<input type="text" class="form-control" name="Cargo" id="Cargo" >
						</div>
					</div>
				</div>		

			</div>
	</div>			

	<!-- Guia Informações do Evento -->
	<div class="panel panel-primary" name="InformacoesEvento" id="InformacoesEvento" style="display: block; border-color: #3b83db;">
		<div class="panel-heading" style="background-image: -webkit-linear-gradient(top,#3b83db 0,#3b83db 100%);">Eventos</div>
			<div class="panel-body">
				
				<!--Bloco de workshop e eventos retirados e substituídos por um campo oculto, pois não serão utilizados para o ano de 2017
				<div class="form-group">
				   <label>Deseja participar do workshop pré-evento (vagas limitadas):</label>
				   <select class="form-control" style="width: 40%" name="WorkShop" id="WorkShop">
						<option value="0">Escolha um evento</option>
				   </select>
				</div>	
				<br> -->
				<!--
				<label>* Deseja participar do simpósio nos dias (vagas limitadas):</label>
				<div class="form-group" id='ListaEventos'>
					<input type="checkbox" class="evento" name="todosEventos" id="todosEventos" value="todosEventos" oninvalid="setCustomValidity('Selecione pelo menos 1 evento')" required/>Todos os Dias <br>
				</div>	
				-->
				<div class="form-group">
					<label>* Deseja submeter um resumo? (até o dia 17/02/2020)</label><br>
					<label class="radio-inline"><input required="required" type="radio" name="Submeter" id="submeterSim" value="S">Sim</label>
					<label class="radio-inline"><input required="required" type="radio" name="Submeter" id="submeterNao" value="N">Não</label>				
				</div>	
		
			</div>
	</div>

	<div class="separacao_linha"></div>
	<div class="row clearfix mt-10 mb-14">
		<div class="col-xs-12 col-sm-2 col-md-3 col-lg-3">
			<div id="boxCritica" class="clearfix alert-sm"></div><!-- MENSAGEM PEQUENA //-->
		</div>
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-9 text-right" id="boxToolbarEdicao">
			<button type="button" id="bt_cancelar" class="btn btn-default btn-espace" title="Cancelar Operação" onclick="cancelar();"><span class="glyphicon glyphicon-stop"></span> Cancelar</button>
			<button type="submit"  id="bt_gravar"  class="btn btn-success btn-espace" title="Gravar Registro"><span class="glyphicon glyphicon-floppy-disk"></span> Gravar</button>
		</div>
	</div>

</form>
						
