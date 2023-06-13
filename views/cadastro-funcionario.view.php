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

									<div class="panel-body">
									
										<form id="formCadastro" name="formCadastro" action="action.php" method="post" onsubmit="return false;" >
											<input type="hidden" id="controle" name="controle" value="" />
											<input type="hidden" id="acao" name="acao" value="" />
											<input type="hidden" id="Id" name="Id" value="" />
											<input type="hidden" id="IdUsuario" name="IdUsuario" value="" />
											<input type="hidden" id="IdUsuarioAcao" name="IdUsuarioAcao" value="" />
											<input type="hidden" id="Ativo" name="Ativo" value="" />

											<div>
												<div class="row clearfix">
													<div class="form-group-sm required col-xs-2 col-sm-2 col-md-2 col-lg-2" >
														<label class="control-label label-sm">Id: </label>
														<input class="form-control input-sm text-right" maxlength="14" type="text" value="" id="idFunc" name="idFunc" readonly="readonly" disabled />
													</div>
													<div class="form-group-sm col-xs-2 col-sm-2 col-md-2 col-lg-2">
														<label class="control-label label-sm">CPF: </label><br>
														<input class="form-control input-sm text-right" type="text" value="" id="cpf" name="cpf" placeholder="___.___.___-__" disabled />
														<span id="lblCPFError" class="label label-danger" style="display: none;"></span>
													</div>												
												</div>	

												<div class="row clearfix">
													<div class="form-group-sm col-xs-3 col-sm-3 col-md-3 col-lg-3" >
														<label class="control-label label-sm" for="tipoColaborador">Tipo do Colaborador:</label>
														<select class="form-control input-sm" style="width: 100%" name="tipoColaborador" id="tipoColaborador" disabled>
															<option value="">Selecione</option>
														</select>														   
													</div>	
													<div class="form-group-sm required col-xs-3 col-sm-3 col-md-3 col-lg-3" >
														<label class="control-label label-sm" for="cartao">Código do Cartão:</label>
														<input class="form-control input-sm" type="text" maxlength="50" value="" id="cartao" name="cartao"  placeholder="Código do Cartão"  data-toggle="popover" data-html="true" data-placement="right" data-title="Código" data-content="Favor informar o código do cartão." disabled />
													</div>
												
												</div>													

												<div class="row clearfix">
													<div class="form-group-sm required col-xs-6 col-sm-6 col-md-6 col-lg-6" >
														<label class="control-label label-sm" for="nome">Nome:</label>
														<input class="form-control input-sm" type="text" maxlength="100" value="" id="nome" name="nome"  placeholder="Informe o nome Completo"  data-toggle="popover" data-html="true" data-placement="right" data-title="Nome" data-content="Favor informar o nome do funcionário." disabled />
													</div>
													<div class="form-group-sm col-xs-3 col-sm-3 col-md-3 col-lg-3" >
														<label class="control-label label-sm" for="vinculo">Vínculo:</label>
														<select class="form-control" style="width: 100%" name="vinculo" id="vinculo" disabled>
															<option value="">Selecione</option>
															<option value="BOLS">BOLS</option>
															<option value="ESTAG">ESTAG</option>
															<option value="PREST">PREST</option>
															<option value="PROF-VIS">PROF-VIS</option>
															<option value="PROJ-ESP">PROJ-ESP</option>
															<option value="SERV">SERV</option>
													   </select>													
													</div>
													<div class="form-group-sm col-xs-3 col-sm-3 col-md-3 col-lg-3" >
														<label class="control-label label-sm" for="modalidade">Modalidade:</label>
														<select class="form-control" style="width: 100%" name="modalidade" id="modalidade" disabled>
															<option value="">Selecione</option>
															<option value="CAPES">CAPES</option>
															<option value="CED">CED</option>
															<option value="CIEE">CIEE</option>
															<option value="CNPQ">CNPQ</option>
															<option value="CONTRATO DISEG">CONTRATO DISEG</option>
															<option value="EFETIVO">EFETIVO</option>
															<option value="FAPERJ">FAPERJ</option>
															<option value="FIOTEC">FIOTEC</option>
															<option value="NOVA RIO - PCD">NOVA RIO - PCD</option>
															<option value="NOVA RIO - PREP.">NOVA RIO - PREP.</option>
															<option value="NOVA RIO 4">NOVA RIO 4</option>
															<option value="PROF-VIS">PROF-VIS</option>
															<option value="PROVOC">PROVOC</option>
															<option value="RPA FIOTEC">RPA FIOTEC</option>
															<option value="TESOURO">TESOURO</option>
															<option value="TRANSEGUR">TRANSEGUR</option>
															<option value="W ENGENHARIA">W ENGENHARIA</option>
													   </select>													
													</div>													
												</div>

												<div class="row clearfix">
													<div class="form-group-sm col-xs-3 col-sm-3 col-md-3 col-lg-3" >
														<label class="control-label label-sm" for="origemUO">UO:</label>
														<input class="form-control input-sm text-right" maxlength="30" type="text" value="" id="origemUO" name="origemUO" readonly="readonly" disabled />
													</div>
													<div class="form-group-sm col-xs-3 col-sm-3 col-md-3 col-lg-3" >
														<label class="control-label label-sm" for="alocacao">UO Lotacao:</label>
														<select class="form-control input-sm" style="width: 100%" name="alocacao" id="alocacao" disabled>
															<option value="">Selecione</option>
														</select>															
													</div>    												
													<div class="form-group-sm required col-xs-3 col-sm-3 col-md-3 col-lg-3" >
														<label class="control-label label-sm" for="jornada">Jornada de Trabalho:</label>
														<select class="form-control" style="width: 100%" name="jornada" id="jornada"  disabled>
															<option value="">Selecione</option>														
													   </select>	
													</div>
													<div class="form-group-sm col-xs-3 col-sm-3 col-md-3 col-lg-3" >
														<label class="control-label label-sm" for="horario">Horário:</label>
														<select class="form-control" style="width: 100%" name="horario" id="horario" disabled>
															<option value="">Selecione</option>
															<option value="06:00 às 12:00">06:00 às 12:00</option>
															<option value="06:00 às 15:00">06:00 às 15:00</option>
															<option value="06:00 às 15:48">06:00 às 15:48</option>
															<option value="06:00 às 18:00">06:00 às 18:00</option>
															<option value="07:00 às 16:00">07:00 às 16:00</option>
															<option value="07:00 às 16:48">07:00 às 16:48</option>
															<option value="07:00 às 18:00">07:00 às 18:00</option>
															<option value="07:00 às 19:00">07:00 às 19:00</option>
															<option value="08:00 às 12:00">08:00 às 12:00</option>
															<option value="08:00 às 14:00">08:00 às 14:00</option>
															<option value="08:00 às 15:00">08:00 às 15:00</option>
															<option value="08:00 às 17:00">08:00 às 17:00</option>
															<option value="08:00 às 19:00">08:00 às 19:00</option>
															<option value="08:00 às 20:00">08:00 às 20:00</option>
															<option value="09:00 às 15:00">09:00 às 15:00</option>
															<option value="09:00 às 18:00">09:00 às 18:00</option>
															<option value="10:00 às 16:00">10:00 às 16:00</option>
															<option value="10:00 às 17:00">10:00 às 17:00</option>
															<option value="10:00 às 19:00">10:00 às 19:00</option>
															<option value="11:00 às 17:00">11:00 às 17:00</option>
															<option value="12:00 às 21:00">12:00 às 21:00</option>
															<option value="13:00 às 17:00">13:00 às 17:00</option>
															<option value="13:00 às 18:00">13:00 às 18:00</option>
															<option value="13:00 às 19:00">13:00 às 19:00</option>
															<option value="13:00 às 22:00">13:00 às 22:00</option>
															<option value="18:00 às 06:00">18:00 às 06:00</option>
															<option value="19:00 às 07:00">19:00 às 07:00</option>
															<option value="20:00 às 08:00">20:00 às 08:00</option>
															<option value="21:00 às 05:48">21:00 às 05:48</option>
															<option value="21:00 às 06:00">21:00 às 06:00</option>
															<option value="22:00 às 05:00">22:00 às 05:00</option>
															<option value="22:00 às 05:48">22:00 às 05:48</option>
															<option value="22:00 às 06:00">22:00 às 06:00</option>
													   </select>	
													</div>													
												</div>	

												<div class="row clearfix">
													<div class="form-group-sm col-xs-12 col-sm-12 col-md-12 col-lg-12" >
														<label class="control-label label-sm" for="obs">Observações</label>
														<textarea class="form-control" rows="2" id="obs" name="obs" maxlength="10000"></textarea>
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

										</form>	
									</div>

                                </div>
                            </div>
							
                            <div class="row clearfix" id="boxListagem">
                                <div class="col-md-12 column">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Listagem de Funcionários</h3>
                                        </div>
                                        <div class="panel-body">						
                                        <!-- Listagem - INICIO -->
                                            <form id="formPesquisa" name="formPesquisa" action="action.php" onSubmit="return false;" class="form-horizontal" >
                                                <input type="hidden" id="acao0" name="acao" value="filtrar" />
                                                <input type="hidden" id="Ativo" name="Ativo" value="1" />
                                                
                                                <div class="row clearfix">
                                                    <div class="col-md-12 column">
                                                        <div class="form-group-sm col-xs-6 col-sm-6 col-md-6 col-lg-6 ">
                                                            <label for="filtroNome" class="control-label label-sm">Nome:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="filtroNome" name="filtroNome"  />
                                                        </div>
														
                                                        <div class="form-group-sm col-xs-3 col-sm-3 col-md-3 col-lg-3" >
                                                            <label class="control-label label-sm" for="filtroUoAlocacao">UO Lotação:</label>
															<select class="form-control input-sm" id="filtroUoAlocacao" name="filtroUoAlocacao" style="width: 100%" >
																<option value="">Selecione</option>
															</select>
                                                        </div>
                                                    </div>
                                                </div>
												
                                                <div class="row clearfix">
                                                    <div class="col-md-12 column">
														<div class="form-group-sm col-xs-2 col-sm-2 col-md-2col-lg-2" >
															<label class="control-label label-sm" for="filtroTipoColaborador">Tipo do Colaborador:</label>
															<select class="form-control input-sm" style="width: 100%" name="filtroTipoColaborador" id="filtroTipoColaborador">
																<option value="">Selecione</option>
															</select>	
														</div>
														
														<div class="form-group-sm col-xs-2 col-sm-2 col-md-2col-lg-2" >
															<label class="control-label label-sm" for="filtroVinculo">Vínculo:</label>
															<select class="form-control" style="width: 100%" name="filtroVinculo" id="filtroVinculo">
																<option value="">Selecione</option>
																<option value="BOLS">BOLS</option>
																<option value="ESTAG">ESTAG</option>
																<option value="PREST">PREST</option>
																<option value="PROF-VIS">PROF-VIS</option>
																<option value="PROJ-ESP">PROJ-ESP</option>
																<option value="SERV">SERV</option>
														   </select>													
														</div>
														
														<div class="form-group-sm col-xs-2 col-sm-2 col-md-2col-lg-2" >
															<label class="control-label label-sm" for="filtroModalidade">Modalidade:</label>
															<select class="form-control" style="width: 100%" name="filtroModalidade" id="filtroModalidade">
																<option value="">Selecione</option>
																<option value="CAPES">CAPES</option>
																<option value="CED">CED</option>
																<option value="CIEE">CIEE</option>
																<option value="CNPQ">CNPQ</option>
																<option value="CONTRATO DISEG">CONTRATO DISEG</option>
																<option value="EFETIVO">EFETIVO</option>
																<option value="FAPERJ">FAPERJ</option>
																<option value="FIOTEC">FIOTEC</option>
																<option value="NOVA RIO-PCD">NOVA RIO-PCD</option>
																<option value="NOVA RIO-PREP">NOVA RIO-PREP</option>
																<option value="NOVA RIO 4">NOVA RIO 4</option>
																<option value="PROF-VIS">PROF-VIS</option>
																<option value="PROVOC">PROVOC</option>
																<option value="RPA FIOTEC">RPA FIOTEC</option>
																<option value="TESOURO">TESOURO</option>
																<option value="TRANSEGUR">TRANSEGUR</option>
																<option value="W ENGENHARIA">W ENGENHARIA</option>
														   </select>													
														</div>
														
														<div class="form-group-sm col-xs-3 col-sm-3 col-md-3 col-lg-3" >
															<label class="control-label label-sm" for="filtroJornada">Jornada de Trabalho:</label>
															<select class="form-control" style="width: 100%" name="filtroJornada" id="filtroJornada">
																<option value="">Selecione</option>													
														   </select>	
														</div>														

														<div class="form-group-sm col-xs-3 col-sm-3 col-md-3 col-lg-3 text-right" >
                                                            <button type="button" class="btn btn-default btn-filtro" id="bt_pesquisar" onclick="carregarLista(13);" disabled="disabled" ><span class="fa fa-search black"></span> Pesquisar</button>
                                                        </div>
														
													</div>
														
                                                </div>
												
                                            </form>
                                            
                                            <div class="separacao_linha-sm"><span></span></div>
                                            <div class="row clearfix">
                                                <div class="col-lg-12 column">
                                                    <table id="tabListagem" class="table table-striped table-bordered table-hover table-condensed "  >
                                                        <thead>
                                                            <tr class="">
                                                                <th><b>&nbsp;</b></th>
                                                                <th><b>CPF</b></th>
                                                                <th><b>Nome Completo / Código Cartão </b></th>
                                                                <th><b>UO Lotação</b></th>
                                                                <th><b>Vínculo</b></th>
                                                                <th><b>Modalidade</b></th>
																<th><b>Jornada</b></th>
																<th><b>Tipo Colaborador</b></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        <!-- Listagem - FINAL -->
										</div> <!--fecha body-->
                                    </div><!--fecha panel-->
										
                                </div><!--fecha coluna-->
                            </div>

                        </div>
                    </div>
                </div>
				
            </div><!-- MODULO CONTEUDO - FINAL ******************************************************************************************************************** //-->