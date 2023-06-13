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
                                    <button type="button" id="bt_incluir" class="btn btn-primary btn-espace" title="Adicionar um novo registro" onclick="novo();" disabled="disabled"><span class="glyphicon glyphicon-plus"></span> Adicionar</button>
                                </div>
                            </div>
                            
                            <div class="row clearfix" id="boxFormulario" style="display: none;">
                                <div class="col-sm-12 col-md-12 col-lg-12 column">
									<div class="panel-body">
										<form id="formCadastro" name="formCadastro" action="action.php" method="post" onsubmit="return false;" >
											<input type="hidden" id="controle" name="controle" value="" />
											<input type="hidden" id="acao" name="acao" value="" />
											<input type="hidden" id="Id" name="Id" value="" />
											<input type="hidden" id="IdStatus" name="IdStatus" value="" />
											<input type="hidden" id="IdUsuarioAcao" name="IdUsuarioAcao" value="" />
											
											<div class="row clearfix">
												<div class="form-group-sm required col-xs-6 col-sm-6 col-md-3 col-lg-3" >
													<label class="control-label label-sm">Id: </label>
													<input class="form-control input-sm text-right" type="text" value="" id="idJornada" name="idJornada" readonly="readonly" />
												</div>
											</div>
											<div class="row clearfix">
												<div class="form-group-sm required col-xs-6 col-sm-6 col-md-6 col-lg-6" >
													<label class="control-label label-sm" for="descricao">Descricao: </label>
													<input class="form-control input-sm" type="text" maxlength="50" value="" id="descricao" name="descricao" placeholder="Digite a descrição da jornada" data-toggle="popover" data-html="true" data-placement="right" data-title="Jornada" data-content="Favor informar a Jornada de Trabalho, ex: 12 x 36."  />
												</div>

												<div class="form-group-sm required col-xs-2 col-sm-2 col-md-2 col-lg-2" >
													<label class="control-label label-sm" for="qtdMascaras">Quantidade:</label>
													<input class="form-control input-sm" type="number" id="qtdMascaras" name="qtdMascaras"  placeholder="Digite a quantidade"  data-toggle="popover" data-html="true" data-placement="right" data-title="Quantidade" data-content="Favor informar a quantidade desejada." disabled />
												</div> 
												
											</div>

											<div class="separacao_linha-sm"><span></span></div>
											<div class="row clearfix">
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
                            <div class="row clearfix" id="boxListagem">
                                <div class="col-md-12 column">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Listagem de Jornada de Trabalho</h3>
                                        </div>
                                        <div class="panel-body">						
                                        <!-- Listagem - INICIO -->
                                            <form id="formPesquisa" name="formPesquisa" action="action.php" onSubmit="return false;" class="form-horizontal" >
                                                <input type="hidden" id="acao0" name="acao" value="filtrar" />
                                                <input type="hidden" id="Ativo" name="Ativo" value="1" />
                                                
                                                <div class="row clearfix">
                                                    <div class="col-md-12 column">
                                                        <div class="form-group-sm col-xs-6 col-sm-6 col-md-6 col-lg-6 ">
                                                            <label for="filtroDescricao" class="control-label label-sm">Descrição da Jornada:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="filtroDescricao" name="filtroDescricao"  />
                                                        </div>
														
														<div class="form-group-sm col-xs-3 col-sm-3 col-md-3 col-lg-3 text-right" >
															<button type="button" class="btn btn-default btn-filtro" id="bt_pesquisar" onclick="carregarLista(13);" disabled="disabled" ><span class="fa fa-search black"></span> Pesquisar</button>
														</div>														
													
                                                    </div>
                                                </div>
                                            </form>										
										
											<div class="separacao_linha"></div>
											<div class="row clearfix">
												<div class="col-lg-12 column">
													<table id="tabListagem" class="table table-striped table-bordered table-hover table-condensed" >
														<thead>
															<tr class="">
																<th><b>&nbsp;</b></th>
																<th><b>Id&nbsp;</b></th>
																<th><b>Descrição</b></th>
																<th><b>Qtd Máscaras</b></th>
															</tr>
														</thead>
														<tbody>
														</tbody>
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