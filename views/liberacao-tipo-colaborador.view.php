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
                                <!--    <button type="button" id="bt_incluir" class="btn btn-primary btn-espace" title="Adicionar um novo registro" onclick="novo();" ><span class="glyphicon glyphicon-plus"></span> Adicionar</button>   -->
                                </div>
                            </div>
                          
                            <div class="row clearfix" id="boxFormulario" style="display: none;">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 column">
										
                                        <div class="panel-body">
                                        
											<form id="formCadastro" name="formCadastro" action="action.php" method="post" onsubmit="return false;" >
												<input type="hidden" id="controle" name="controle" value="" />
												<input type="hidden" id="acao" name="acao" value="" />
												<input type="hidden" id="Id" name="Id" value="" />
												<input type="hidden" id="Descricao" name="Descricao" value="" />
												<input type="hidden" id="IdUsuario" name="IdUsuario" value="" />
												<input type="hidden" id="IdUsuarioAcao" name="IdUsuarioAcao" value="" />
												<input type="hidden" id="Ativo" name="Ativo" value="" />
 <!-- 
												<div>
												
													<div class="row clearfix">
														<div class="form-group-sm col-xs-6 col-sm-6 col-md-2 col-lg-2" >
															<input class="form-check-input" type="checkbox" name="ativo" id="ativo" value=""  disabled required>
															<label class="form-check-label" for="ativo">Ativo</label>
																
														</div>
													</div>
												
													<div class="row clearfix">
														<div class="form-group-sm required col-xs-2 col-sm-2 col-md-2 col-lg-2" >
															<label class="control-label label-sm">Id: </label>
															<input class="form-control input-sm text-right" type="text" value="" id="idPosto" name="idPosto" readonly="readonly" disabled />
															<br>
														</div>

														<div class="form-group-sm required col-xs-6 col-sm-6 col-md-4 col-lg-6" >
															<label class="control-label label-sm" for="descricao">Descricao:</label>
															<input class="form-control input-sm" type="text" maxlength="100" value="" id="descricao" name="descricao"  placeholder="Informe a descrição do posto de entrega"  data-toggle="popover" data-html="true" data-placement="right" data-title="Descrição" data-content="Favor informar a descricao com no máximo 100 caracteres." disabled />
															<br>
															
														</div>
													
														<div class= "form-group-sm col-xs-4 col-sm-4 col-md-4 col-lg-4" >
															<label class="control-label label-sm" for="responsavel">Responsavel:</label>
															<input class="form-control input-sm" type="text" maxlength="50" value="" id="responsavel" name="responsavel"  placeholder="Informe o responsável pelo posto"  data-toggle="popover" data-html="true" data-placement="right" data-title="Responsável" data-content="Favor informar o responsavel com no máximo 50 caracteres." disabled />
														</div>
													</div>
													
													<div class="separacao_linha-sm"><span></span></div>
													<div class="row clearfix">
														<div class="form-group-sm col-xs-6 col-sm-6 col-md-3 col-lg-3  ">
															<label class="control-label label-sm" for="dataCadastro">Data Cadastro:</label>
															<input class="form-control input-sm" type="text" maxlength="50" value="" id="dataCadastro" name="dataCadastro" readonly="readonly" />
														</div>
														<div class="form-group-sm col-xs-6 col-sm-6 col-md-3 col-lg-3  ">
															<label class="control-label label-sm" for="dataAcao">Última Atualização:</label>
															<input class="form-control input-sm" type="text" maxlength="50" value="" id="dataAcao" name="dataAcao" readonly="readonly" />
														</div>
														<div class="form-group-sm col-xs-6 col-sm-6 col-md-3 col-lg-3  ">
															<label class="control-label label-sm" for="nomeUsuarioAcao">Usuário da Atualização:</label>
															<input class="form-control input-sm" type="text" maxlength="50" value="" id="nomeUsuarioAcao" name="nomeUsuarioAcao" readonly="readonly" />
														</div>
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
												-->
											</form>	
										
                                        </div>
                                </div>
                            </div>

                            <div class="row clearfix" id="boxListagem">
                                <div class="col-md-12 column">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Listagem de Tipos de Colaboradores</h3>
                                        </div>
                                        <div class="panel-body">						
                                        <!-- Listagem - INICIO -->
                                        <!--
											<form id="formPesquisa" name="formPesquisa" action="action.php" onSubmit="return false;" class="form-horizontal" >
                                                <input type="hidden" id="acao0" name="acao" value="filtrar" />
                                                <input type="hidden" id="Ativo" name="Ativo" value="1" />
												
                                                <div class="row clearfix">
                                                    <div class="col-md-12 column">
                                                        <div class="form-group-sm col-xs-6 col-sm-6 col-md-6 col-lg-6" >
                                                            <label class="control-label label-sm" for="filtroDescricao">Descrição:</label>
															<input class="form-control input-sm" type="text" maxlength="50" value="" id="filtroDescricao" name="filtroDescricao"  />
                                                        </div>
                                                    </div>
                                                </div>												
												
                                            </form>
                                          -->  
                                            <div class="separacao_linha-sm"><span></span></div>
                                            <div class="row clearfix">
                                                <div class="col-lg-12 column">
                                                    <table id="tabListagem" class="table table-striped table-bordered table-hover table-condensed" >
                                                        <thead>
                                                            <tr class="">
                                                                <th><b>Código </b></th>
                                                                <th><b>Tipo de Colaborador </b></th>
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