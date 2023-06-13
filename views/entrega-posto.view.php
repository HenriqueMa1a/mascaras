            <div class="row clearfix"><!-- MODULO CONTEUDO - INICIO ******************************************************************************************************************* //-->
                <div class="col-md-12 column">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h2 class="panel-title"><?php echo $sisModulo->Imagem.' '.$sisModulo->Nome ?></h2>
                        </div>
                        <div class="panel-body">
                            <div class="row clearfix" id="boxToolbar">
                                <div id="menu_cadastro" class="col-md-12 col-lg-12 column linha-bottom">
                                    <button type="button" id="bt_sair" class="btn btn-default btn-espace" title="Votar" onclick="sair();"><span class="glyphicon glyphicon-chevron-left"></span> Voltar</button>
                                    <button type="button" id="bt_incluir" class="btn btn-primary btn-espace" title="Adicionar um novo registro" onclick="novo();" ><span class="glyphicon glyphicon-plus"></span> Adicionar</button>
                                </div>
                            </div>
							
                            <div class="row clearfix" id="boxFormulario" style="display: none;">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 column">
                                <!--    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">
                                                Formulário de Cadastro
                                            </h3>
                                        </div>-->
										
                                        <div class="panel-body">
                                        
											<form id="formCadastro" name="formCadastro" action="action.php" method="post" onsubmit="return false;" >
												<input type="hidden" id="controle" name="controle" value="" />
												<input type="hidden" id="acao" name="acao" value="" />
												<input type="hidden" id="Id" name="Id" value="" />
												<input type="hidden" id="IdUsuario" name="IdUsuario" value="" />
												<input type="hidden" id="IdUsuarioAcao" name="IdUsuarioAcao" value="" />
												<input type="hidden" id="idFuncionario" name="idFuncionario" value="" />
												<input type="hidden" id="idPosto" name="idPosto" value="" />
												<input type="hidden" id="Ativo" name="Ativo" value="" />
												
												<div id="dialog-entrega" title="Confirmação de Entrega"> </div>

												<div class="row clearfix">
													<div class="form-group-sm col-xs-6 col-sm-6 col-md-6 col-lg-6" >
														<label class="control-label label-sm">Posto de Entrega: </label>
														<select class="form-control input-sm" style="width: 100%" name="postoEntrega" id="postoEntrega" onchange="selecionaPosto()" disabled >
															<option value="">Selecione</option>
														</select>	
													</div>
													
													<div class="form-group-sm col-xs-3 col-sm-3 col-md-3 col-lg-3" >
													</div>
													
													<div class="form-group-sm col-xs-3 col-sm-3 col-md-3 col-lg-3" >
														<label class="control-label label-sm" id="lblDataHora">Data/Hora da Entrega: </label>
														<input class="form-control input-sm text-right" type="text" value="" id="dataDistribuicao" name="dataDistribuicao" readonly="readonly" />
													</div>													
												</div>	

												<div class="separacao_linha"></div>
												
												<div class="row clearfix">
													<div class="form-group-sm col-xs-12 col-sm-12 col-md-12 col-lg-12" >
														<label class="control-label label-sm" style="font-size: 30px">Código: </label>
														<!--<label class="control-label label-sm">Código Cartão: </label>-->
														<input class="form-control input-sm text-right" type="text" value="" id="codigo" name="codigo" 
															style="height:70px; width:500px; font-size: 40px" />
														<br>
													</div>

												</div>

												<div class="row clearfix">
													<div class="form-group-sm col-xs-12 col-sm-12 col-md-5 col-lg-5" >
														<input type="text" readonly class="form-control-plaintext" id="nome" name="nome"
															style="height:60px; width:1000px; border:solid transparent; 
																font-family: Times New Roman; font-size: 50px;"
															placeholder="Nome do Funcionário" />
														<br><br><br>
													</div>
												</div>
												
												<div class="row clearfix">
													<div class="form-group-sm col-xs-12 col-sm-12 col-md-12 col-lg-12" >
														<label class="control-label label-sm" style="font-size: 30px">Quantidade de Máscaras: </label>
														<input type="text" readonly class="form-control-plaintext" id="qtde" name="qtde" 
															style="height:50px; width:100px; font-size: 30px; border:solid transparent;" placeholder="2 ou 3" />
														<br>														
													</div>
												</div>
												<!--	
												<div class="separacao_linha"></div>
												<div class="row clearfix mb-14">
													<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" id="boxToolbarEdicao">
														<button type="button" id="bt_cancelar" class="btn btn-default btn-espace" title="Cancelar Operação" onclick="cancelar();" ><span class="glyphicon glyphicon-arrow-left"></span> Cancelar</button>
														<button type="button" id="bt_gravar"   class="btn btn-success btn-espace" title="Gravar Registro"   onclick="gravar();" ><span class="glyphicon glyphicon-floppy-disk"></span> Gravar</button>
													</div>
												</div>
												-->
											</form>	
											
											
                                        </div> <!--Final Body -->
                                 <!--    </div>	Final Default -->						
                                </div> <!--Final Column -->												
	                      </div>  <!--Final BoxFormulario -->											
										
											<div class="row clearfix" id="boxListagem">
												<div class="col-md-12 column">
													<div class="panel panel-default">
														<div class="panel-heading">
															<h3 class="panel-title">Listagem de Entregas</h3>
														</div>
														<div class="panel-body">						
															<div class="separacao_linha-sm"><span></span></div>
															<div class="row clearfix">
																<div class="col-lg-12 column">
																	<table id="tabListagem" class="table table-striped table-bordered table-hover table-condensed" >
																		<thead>
																			<tr class="">
																				<th><b>&nbsp;</b></th>
																				<th><b>Id</b></th>
																				<th><b>Data </b></th>
																				<th><b>Posto</b></th>
																				<th><b>Funcionário</b></th>
																				<th><b>Qtde</b></th>
																			</tr>
																		</thead>
																	</table>
																</div>
															</div>
														<!-- Listagem - FINAL -->
														</div>
													</div>
												</div>
											</div>										
										

      
                        </div> <!--Final panel-body -->	 
                    </div>  <!--Final panel-info -->	
                </div>
            </div><!-- MODULO CONTEUDO - FINAL ******************************************************************************************************************** //-->