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
	<input type="hidden" id="controle" name="controle" value="PessoaIngles" />
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
		<div class="panel-heading" style="background-image: -webkit-linear-gradient(top,#3b83db 0,#3b83db 100%);">Personal Data</div>
			<div class="panel-body">
				<div class="row" >
					<div class="col-md-6" style="margin-bottom: 20;" > 			
					  <label for="Tipo">* Type of document</label>
					  <div class="input-group">
						<div class="input-group-btn">
						  <button id="Tipo" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" style="line-height: 400px;">Type 
							<span class="fa fa-caret-down"></span></button>
						  <ul class="dropdown-menu">
							<li><a href="#" onclick="alteraTipoDocumento('CPF');">CPF</a></li>
							<li><a href="#" onclick="alteraTipoDocumento('Passport Number');">Passport Number</a></li>
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
							<label for="NomeCompleto">* Complete Name (same that will be used for the for the certificate of participation)</label>
							<input type="text" class="form-control" name="NomeCompleto" id="NomeCompleto" placeholder="Enter the name" required></input>
						</div>						
						
					<!--
						<div class="form-group">
							<label for="Cpf">* Login (Seu CPF):</label>
							<input type="text" class="form-control maskCPF" style="width: 40%" name="Cpf" id="Cpf" required></input>
						</div>	-->								
					</div> 

					<div class="col-md-6"> 
						<label for="NomeCracha">* Name for badge:</label>			
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
							<input type="text" class="form-control" style="width: 40%" name="NomeCracha" id="NomeCracha" required>
						</div>									
					</div>					
				</div>	
				<!--xxxx-->
				<div class="row">
					<div class="col-md-6"> 						
						<label for="Email">* Email:</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i></span>
							<input type="email" class="form-control" style="width: 40%" name="Email" id="Email" required></input>
						</div>					
					</div>

					<div class="col-md-6"> 
						<label for="Email2">* Email confirmation:</label>
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
						<label for="Senha">* Password:</label>
						<div class="input-group">  
							<span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
							<input type="password" class="form-control" style="width: 40%" name="Senha" id="Senha" required></input>
						</div>
					</div>

					<div class="col-md-6">  
						<br>
						<label for="Senha2">* Password Confirmation:</label> 
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
						<label for="Telefone">* Phone Number:</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-phone fa-fw" aria-hidden="true"></i></span>
							<input type="text" class="form-control masktel" style="width: 40%" name="Telefone" id="Telefone" required></input>
						</div>
					</div>

					<div class="col-md-6"> 
						<br>
						<label for="DataNascimento">* Birthday:</label>
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
							<label class="control-label" for="IdPais">* Country:</label>
							<select class="form-control" style="width: 80%" name="IdPais" id="IdPais" required>
								<option value="">[Choose]</option>
							</select>
						</div>					
					</div>				
				
					<div class="col-md-4"> 	
						<div class="form-group">
							<br>
							<label class="control-label" for="IdEstado">* State:</label>
							<select class="form-control" style="width: 80%" name="IdEstado" id="IdEstado" required>
								<option value="">[Choose]</option>
							</select>
						</div>					
					</div>

					<div class="col-md-4"> 
						<div class="form-group">
							<br>
							<label>* City:</label>
							<select class="form-control" style="width: 80%" name="IdCidade" id="IdCidade" required>
								<option value="">[Choose]</option>
							</select>
						</div>					
					</div>					
				</div>

			</div>
	</div>

	 <!-- Guia Dados Profissionais -->
	<div class="panel panel-primary" style="display: block; border-color: #3b83db;">
		<div class="panel-heading" style="background-image: -webkit-linear-gradient(top,#3b83db 0,#3b83db 100%);">Education</div>
			<div class="panel-body">

				<label for="Graduacao">* Undergraduate Course:</label>	
				<div class="form-inline">						
					<select class="form-control" style="width: 30%" name="Graduacao" id="Graduacao" onchange="outraGraduacao(this.value)" required>
								<option value="">Choose a Undergraduate Course</option>
								<option>Administration</option>
								<option>Architecture and urbanism</option>
								<option>Biochemistry</option>
								<option>Biomedical engineering</option>
								<option>Biophysics</option>
								<option>Chemical engineering</option>
								<option>Chemistry</option>
								<option>Civil Engineering</option>
								<option>Collective Health (Epidemiology / Public Health / Preventive Medicine)</option>
								<option>Communication</option>
								<option>Computer science</option>
								<option>Dentistry</option>
								<option>Economy</option>
								<option>Electrical engineering</option>
								<option>General Biology</option>
								<option>Genetics</option>
								<option>Immunology</option>
								<option>Industrial draw</option>
								<option>Information Science</option>
								<option>Mathematics</option>
								<option>Mechanical Engineering</option>
								<option>Medicine</option>
								<option>Microbiology</option>
								<option>Morphology</option>
								<option>Nuclear Engineering</option>
								<option>Nursing</option>
								<option>Nutrition</option>
								<option>Parasitology</option>
								<option>Pharmacology</option>
								<option>Pharmacy</option>
								<option>Physics</option>
								<option>Physiology</option>
								<option>Probability and statistics</option>
								<option>Production engineering</option>
								<option>Right</option>
								<option>Sanitary Engineering</option>
								<option>Veterinary Medicine</option>
								<option>Other (Specify)</option>

					</select>

					<input class="form-control" type="text" style="width: 60%" name="OutraGraduacao" id="OutraGraduacao" placeholder="Specify another degree"></input>
				</div>	
				
				<br>
				<label>Maximum Titration:</label>
				<div class="row"> 
					<div class="col-md-3"> 
						<div class="checkbox">
							<label>
							  <input type="checkbox" name="posGraduacao" id="ClickPosGraduacao"/>
							  Postgraduate Course
							</label>
						</div>
						<div class="form-group">
						   <select class="form-control" name="PosGraduacao" id="PosGraduacao" onchange="outraPosGraduacao(this.value)" disabled>
								<option value="">Choose a Postgraduate Course</option>
								<option>Administration</option>
								<option>Architecture and urbanism</option>
								<option>Biochemistry</option>
								<option>Biomedical engineering</option>
								<option>Biophysics</option>
								<option>Chemical engineering</option>
								<option>Chemistry</option>
								<option>Civil Engineering</option>
								<option>Collective Health (Epidemiology / Public Health / Preventive Medicine)</option>
								<option>Communication</option>
								<option>Computer science</option>
								<option>Dentistry</option>
								<option>Economy</option>
								<option>Electrical engineering</option>
								<option>General Biology</option>
								<option>Genetics</option>
								<option>Immunology</option>
								<option>Industrial draw</option>
								<option>Information Science</option>
								<option>Mathematics</option>
								<option>Mechanical Engineering</option>
								<option>Medicine</option>
								<option>Microbiology</option>
								<option>Morphology</option>
								<option>Nuclear Engineering</option>
								<option>Nursing</option>
								<option>Nutrition</option>
								<option>Parasitology</option>
								<option>Pharmacology</option>
								<option>Pharmacy</option>
								<option>Physics</option>
								<option>Physiology</option>
								<option>Probability and statistics</option>
								<option>Production engineering</option>
								<option>Right</option>
								<option>Sanitary Engineering</option>
								<option>Veterinary Medicine</option>
								<option>Other (Specify)</option>
						   </select>
						</div>	
						<input class="form-control" type="text" name="OutraPosGraduacao" id="OutraPosGraduacao" placeholder="Specify another..."></input>
						
					</div>
					
					<div class="col-md-3">
						<div class="checkbox">
							<label>
							  <input type="checkbox" name="mestrado" id="ClickMestrado"/>
							  Master degree
							</label>
						  </div>
						<div class="form-group">
						   <select class="form-control" name="Mestrado" id="Mestrado" onchange="outroMestrado(this.value)" disabled>
								<option value="">Choose a Master degree</option>
								<option>Administration</option>
								<option>Architecture and urbanism</option>
								<option>Biochemistry</option>
								<option>Biomedical engineering</option>
								<option>Biophysics</option>
								<option>Chemical engineering</option>
								<option>Chemistry</option>
								<option>Civil Engineering</option>
								<option>Collective Health (Epidemiology / Public Health / Preventive Medicine)</option>
								<option>Communication</option>
								<option>Computer science</option>
								<option>Dentistry</option>
								<option>Economy</option>
								<option>Electrical engineering</option>
								<option>General Biology</option>
								<option>Genetics</option>
								<option>Immunology</option>
								<option>Industrial draw</option>
								<option>Information Science</option>
								<option>Mathematics</option>
								<option>Mechanical Engineering</option>
								<option>Medicine</option>
								<option>Microbiology</option>
								<option>Morphology</option>
								<option>Nuclear Engineering</option>
								<option>Nursing</option>
								<option>Nutrition</option>
								<option>Parasitology</option>
								<option>Pharmacology</option>
								<option>Pharmacy</option>
								<option>Physics</option>
								<option>Physiology</option>
								<option>Probability and statistics</option>
								<option>Production engineering</option>
								<option>Right</option>
								<option>Sanitary Engineering</option>
								<option>Veterinary Medicine</option>
								<option>Other (Specify)</option>
						   </select>
						</div>	
						<input class="form-control" type="text" name="OutroMestrado" id="OutroMestrado" placeholder="Specify another..."></input>
					</div>
					
					<div class="col-md-3"> 
						<div class="checkbox">
							<label>
							  <input type="checkbox" name="doutorado" id="ClickDoutorado"/>
							  PhD
							</label>
						</div>	
						<div class="form-group">
						   <select class="form-control" name="Doutorado" id="Doutorado" onchange="outroDoutorado(this.value)" disabled>
								<option value="">Choose a PhD</option>
								<option>Administration</option>
								<option>Architecture and urbanism</option>
								<option>Biochemistry</option>
								<option>Biomedical engineering</option>
								<option>Biophysics</option>
								<option>Chemical engineering</option>
								<option>Chemistry</option>
								<option>Civil Engineering</option>
								<option>Collective Health (Epidemiology / Public Health / Preventive Medicine)</option>
								<option>Communication</option>
								<option>Computer science</option>
								<option>Dentistry</option>
								<option>Economy</option>
								<option>Electrical engineering</option>
								<option>General Biology</option>
								<option>Genetics</option>
								<option>Immunology</option>
								<option>Industrial draw</option>
								<option>Information Science</option>
								<option>Mathematics</option>
								<option>Mechanical Engineering</option>
								<option>Medicine</option>
								<option>Microbiology</option>
								<option>Morphology</option>
								<option>Nuclear Engineering</option>
								<option>Nursing</option>
								<option>Nutrition</option>
								<option>Parasitology</option>
								<option>Pharmacology</option>
								<option>Pharmacy</option>
								<option>Physics</option>
								<option>Physiology</option>
								<option>Probability and statistics</option>
								<option>Production engineering</option>
								<option>Right</option>
								<option>Sanitary Engineering</option>
								<option>Veterinary Medicine</option>
								<option>Other (Specify)</option>
						   </select>
						</div>
						<input class="form-control" type="text" name="OutroDoutorado" id="OutroDoutorado" placeholder="Specify another..."></input>					
					</div>
					
					<div class="col-md-3">
						<div class="checkbox">
							<label>
							  <input type="checkbox" name="posDoutor" id="ClickPosDoutorado"/>
							  Post-doctorate
							</label>
						</div>	
						<div class="form-group">
						   <select class="form-control" name="PosDoutorado" id="PosDoutorado" onchange="outroPosDoutorado(this.value)" disabled>
								<option value="">Choose a Post-doctorate</option>
								<option>Administration</option>
								<option>Architecture and urbanism</option>
								<option>Biochemistry</option>
								<option>Biomedical engineering</option>
								<option>Biophysics</option>
								<option>Chemical engineering</option>
								<option>Chemistry</option>
								<option>Civil Engineering</option>
								<option>Collective Health (Epidemiology / Public Health / Preventive Medicine)</option>
								<option>Communication</option>
								<option>Computer science</option>
								<option>Dentistry</option>
								<option>Economy</option>
								<option>Electrical engineering</option>
								<option>General Biology</option>
								<option>Genetics</option>
								<option>Immunology</option>
								<option>Industrial draw</option>
								<option>Information Science</option>
								<option>Mathematics</option>
								<option>Mechanical Engineering</option>
								<option>Medicine</option>
								<option>Microbiology</option>
								<option>Morphology</option>
								<option>Nuclear Engineering</option>
								<option>Nursing</option>
								<option>Nutrition</option>
								<option>Parasitology</option>
								<option>Pharmacology</option>
								<option>Pharmacy</option>
								<option>Physics</option>
								<option>Physiology</option>
								<option>Probability and statistics</option>
								<option>Production engineering</option>
								<option>Right</option>
								<option>Sanitary Engineering</option>
								<option>Veterinary Medicine</option>
								<option>Other (Specify)</option>
						   </select>
						</div>
						<input class="form-control" type="text" name="OutroPosDoutorado" id="OutroPosDoutorado" placeholder="Specify another..."></input>										
					</div>
				</div>				
				
				<br/>	
			
				<div class="form-group">
					<label>* Bio-Manguinhos employee?</label><br>
					<label class="radio-inline"><input type="radio" required name="Colaborador" id="ColaboradorNao" value="N" onclick="mostra(this.value)">No</label>
					<label class="radio-inline"><input type="radio" required name="Colaborador" id="ColaboradorSim" value="S" onclick="mostra(this.value)">Yes</label>				
				</div>	

				<div class="form-group" id="ViceDiretoria">
				   <label>* Vice-Director:</label>
				   <select class="form-control" style="width: 25%" name="Diretoria" id="Diretoria">
						<option value="">Choose a Vice-Director</option>
						<option value="DIBIO">DIBIO</option>
						<option value="VGEST">VGEST</option>
						<option value="VQUAL">VQUAL</option>
						<option value="VDTEC">VDTEC</option>
						<option value="VPROD">VPROD</option>
				   </select>
				</div>	
				
				<div class="row" id="Externo" name="Externo"> 
					<div class="col-md-6"> 	
						<label for="empr" id="lblEmpresa">* Company/Institution:</label>
						<div class="input-group" id="empr">		
							<span class="input-group-addon"><i class="fa fa-institution"></i></span>
							<input type="text" class="form-control" name="Empresa" id="Empresa" >
						</div>	
					</div>
					<div class="col-md-6"> 					
						<label for="carg" id="lblCargo">* Position/Function:</label>	
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
		<div class="panel-heading" style="background-image: -webkit-linear-gradient(top,#3b83db 0,#3b83db 100%);">Events</div>
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
				<label>* Wish to participate at the following days (limited vacancies): </label>
				<div class="form-group" id='ListaEventos'>
					<input type="checkbox" class="evento" name="todosEventos" id="todosEventos" value="todosEventos" oninvalid="setCustomValidity('Select at least 1 event')" required/>All 3 days <br>
				</div>	
				-->			
				<div class="form-group">
					<label>* Intend to submit abstract? (until 17th February 2020)</label><br>
					<label class="radio-inline"><input required="required" type="radio" name="Submeter" id="submeterSim" value="S">Yes</label>
					<label class="radio-inline"><input required="required" type="radio" name="Submeter" id="submeterNao" value="N">No</label>				
				</div>	
		
			</div>
	</div>

	<div class="separacao_linha"></div>
	<div class="row clearfix mt-10 mb-14">
		<div class="col-xs-12 col-sm-2 col-md-3 col-lg-3">
			<div id="boxCritica" class="clearfix alert-sm"></div><!-- MENSAGEM PEQUENA //-->
		</div>
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-9 text-right" id="boxToolbarEdicao">
			<button type="button" id="bt_cancelar" class="btn btn-default btn-espace" title="Cancelar Operação" onclick="cancelar();"><span class="glyphicon glyphicon-stop"></span> Cancel</button>
			<button type="submit"  id="bt_gravar"  class="btn btn-success btn-espace" title="Gravar Registro"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
		</div>
	</div>

</form>
						
