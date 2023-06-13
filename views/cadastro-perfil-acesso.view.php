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
							
                            <div class="row clearfix" id="boxFormulario" style="display: none;" >
							
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 column">
										
									<div class="panel-body">
																
										<form id="formCadastro" name="formCadastro" action="action.php" method="post" onsubmit="return false;" >
											<input type="hidden" id="controle" name="controle" value="" />
											<input type="hidden" id="acao" name="acao" value="" />
											<input type="hidden" id="Id" name="Id" value="" />
											<input type="hidden" id="IdUsuario" name="IdUsuario" value="" />
											<input type="hidden" id="IdUsuarioAcao" name="IdUsuarioAcao" value="" />
											<input type="hidden" id="Ativo" name="Ativo" value="" />

											<!-- **INÍCIO** DADOS DO PERFIL //-->
											<div class="row clearfix">
												<div class="form-group-sm col-xs-6 col-sm-6 col-md-2 col-lg-2" >
													<input class="form-check-input" type="checkbox" name="ativo" id="ativo" value=""  disabled required>
													<label class="form-check-label" for="ativo">Ativo</label>
												</div>
											</div>
											<div class="row clearfix">
												<div class="form-group-sm required col-xs-2 col-sm-2 col-md-2 col-lg-2" >
													<label class="control-label label-sm">Id: </label>
													<input class="form-control input-sm text-right" type="text" value="" id="idPerfil" name="idPerfil" readonly="readonly" disabled />
												</div>
												<div class="form-group-sm required col-xs-3 col-sm-3 col-md-3 col-lg-3" >
													<label class="control-label label-sm" for="sigla">Sigla:</label>
													<input class="form-control input-sm" type="text" maxlength="20" value="" id="sigla" name="sigla"  placeholder="Digite uma sigla para o perfil"  data-toggle="popover" data-html="true" data-placement="right" data-title="Sigla" data-content="Favor informar a sigla com no máximo 10 caracteres." disabled />
												</div>
												<div class="form-group-sm col-xs-4 required col-sm-4 col-md-4 col-lg-4" >
													<label class="control-label label-sm" for="descricao">Descrição:</label>
													<input class="form-control input-sm" type="text" maxlength="50" value="" id="descricao" name="descricao"  placeholder="Digite uma descrição para o perfil"  data-toggle="popover" data-html="true" data-placement="right" data-title="Descrição" data-content="Favor informar a descricao com no máximo 50 caracteres." disabled />
												</div>											
											</div>
											<!-- **FIM** DADOS DO PERFIL //-->
											<br>
											
											<div class="separacao_campos"><span>Funcionalidades</span></div>
											<button type="button" class="btn btn-link" id="bt_funcoes" onclick="habilitarFuncionalidades();" >
												<span class="fa fa-pencil-square-o blue"></span>
												Editar Funcionalidades
											</button>
											<div class="row clearfix">
												<!-- **INÍCIO** LISTA DE FUNCIONALIDADES //-->
												<div class="col-sm-12 col-md-4 col-lg-4 column"><!-- Início do Módulo Controle de Acesso //-->
													<div class="panel panel-default">
														<div class="panel-heading">
															<h3 class="panel-title"><span class="fa fa-users blue"></span> Módulo Controle de Acesso</h3>
														</div>
														<div class="panel-body">
															<div class="mb-14">
																<table id="tabListagemControleAcesso" class="table table-striped table-bordered table-hover table-condensed">
																	<thead>
																		<tr class="">
																			<th><b>Funcionalidade</b></th>
																			<th style="text-align: center;"><b>Sim</b></th>
																			<th style="text-align: center;"><b>Não</b></th>
																		</tr>
																	</thead>
																	<tbody>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
												</div>	<!-- Fim do Módulo Controle de Acesso //-->		

												<div class="col-sm-12 col-md-4 col-lg-4 column"><!-- Início do Módulo Cadastros //-->
													<div class="space-10 visible-sm"></div>
													<div class="panel panel-default">
														<div class="panel-heading">
															<h3 class="panel-title"><span class="fa fa-users blue"></span> Módulo Cadastros</h3>
														</div>
														<div class="panel-body">
															<div class="mb-14">
																<table id="tabListagemCadastros" class="table table-striped table-bordered table-hover table-condensed">
																	<thead>
																		<tr class="">
																			<th><b>Funcionalidade</b></th>
																			<th style="text-align: center;"><b>Sim</b></th>
																			<th style="text-align: center;"><b>Não</b></th>
																		</tr>
																	</thead>
																	<tbody>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
												</div>	<!-- Fim do Módulo Cadastros //-->

												<div class="col-sm-12 col-md-4 col-lg-4 column"><!-- Início do Módulo Distribuição //-->
													<div class="space-10 visible-sm"></div>
													<div class="panel panel-default">
														<div class="panel-heading">
															<h3 class="panel-title"><span class="fa fa-users blue"></span> Módulo Distribuição</h3>
														</div>
														<div class="panel-body">
															<div class="mb-14">
																<table id="tabListagemDistribuicao" class="table table-striped table-bordered table-hover table-condensed">
																	<thead>
																		<tr class="">
																			<th><b>Funcionalidade</b></th>
																			<th style="text-align: center;"><b>Sim</b></th>
																			<th style="text-align: center;"><b>Não</b></th>
																		</tr>
																	</thead>
																	<tbody>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
												</div>	<!-- Fim do Módulo Distribuição //-->	
												<!-- **FIM** LISTA DE FUNCIONALIDADES //-->
											</div>
											
											
											<div class="separacao_linha-sm"><span></span></div>
											<div class="row clearfix">
												<div class="form-group-sm col-xs-12 col-sm-3 col-md-3 col-lg-3  ">
													<label class="control-label label-sm" for="revisao">Revisão:</label>
													<input class="form-control input-sm" type="text" maxlength="50" value="" id="revisao" name="revisao" readonly="readonly" />
												</div>											
												<div class="form-group-sm col-xs-12 col-sm-3 col-md-3 col-lg-3  ">
													<label class="control-label label-sm" for="DataAcao">Última Atualização:</label>
													<input class="form-control input-sm" type="text" maxlength="50" value="" id="DataAcao" name="DataAcao" readonly="readonly" />
												</div>
												<div class="form-group-sm col-xs-12 col-sm-5 col-md-5 col-lg-4  ">
													<label class="control-label label-sm" for="NomeUsuarioAcao">Usuário:</label>
													<input class="form-control input-sm" type="text" maxlength="50" value="" id="NomeUsuarioAcao" name="NomeUsuarioAcao" readonly="readonly" />
												</div>
											</div>											
											
											
											<div class="separacao_linha"></div>
											<div class="row clearfix mb-14">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" id="boxToolbarEdicao">
													<button type="button" id="bt_cancelar" class="btn btn-default btn-espace" title="Cancelar Operação" onclick="cancelar();"><span class="glyphicon glyphicon-stop"></span> Cancelar</button>
													<button type="button" id="bt_editar"   class="btn btn-warning btn-espace" title="Editar Registro"   onclick="editar();"  disabled="disabled" ><span class="glyphicon glyphicon-pencil"></span> Editar</button>
													<button type="button" id="bt_excluir"  class="btn btn-danger btn-espace"  title="Excluir Registro"  onclick="excluir();" disabled="disabled" ><span class="glyphicon glyphicon-remove" ></span> Excluir</button>
													<button type="button" id="bt_gravar"   class="btn btn-success btn-espace" title="Gravar Registro"   onclick="gravar();"  disabled="disabled" ><span class="glyphicon glyphicon-floppy-disk"></span> Gravar</button>
												</div>
											</div>		

										</form>								
									</div>
								</div>
							</div>
							
                            <div class="row clearfix" id="boxListagem" >
                                <div class="col-md-12 column">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Listagem de Perfis</h3>
                                        </div>
                                        <div class="panel-body">						
                                        <!-- Listagem - INICIO -->
                                            <div class="row clearfix">
                                                <div class="col-lg-12 column">
                                                    <table id="tabListagem" class="table table-striped table-bordered table-hover table-condensed" >
                                                        <thead>
                                                            <tr class="">
                                                                <th><b>&nbsp;</b></th>
                                                                <th><b>Nº </b></th>
                                                                <th><b>Sigla </b></th>
                                                                <th><b>Descrição</b></th>
                                                                <th><b>Ativo</b></th>
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

                        </div>
                    </div>
                </div>
				
            </div><!-- MODULO CONTEUDO - FINAL ******************************************************************************************************************** //-->