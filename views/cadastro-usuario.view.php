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
                                    <button type="button" id="bt_incluir" class="btn btn-primary btn-espace" title="Adicionar um novo registro" onclick="novo();"><span class="glyphicon glyphicon-plus"></span> Adicionar</button>
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
											
												<div class="row clearfix"></div>
												<!-- <div class="separacao_campos"><span>Dados Pessoais</span></div> -->
												<div class="row clearfix">
													<!-- Fotografia ** INÍCIO **-->
													<form id="formFotografia" name="formFotografia" method="post" enctype="multipart/form-data">
														<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" >
															<div class="form-group " >
																<ul class="ace-thumbnails">
																	<li>
																		<a href="javascript:selecionaFoto();" data-rel="colorbox">
																			<img id="foto" name="foto" src="fotos/foto-vazia3.jpg" width="190" height="261" />
																			<div class="text">
																				<div class="inner">Adicione uma Foto</div>
																			</div>
																		</a>
																		<input type="file" id="myfile" name="myfile" onchange="previewImagem('')">
																	</li>
																</ul>
															</div>
														</div>
														<input type="submit" value="EnviarFoto" style="display: none">	
													</form>
													<!-- Fotografia ** FIM **-->
													
													<div class="col-xs-12 col-sm-8 col-md-9 col-lg-9" >
														<div class="row clearfix">
															<div class="form-group-sm col-xs-6 col-sm-6 col-md-2 col-lg-2" >
																<input class="form-check-input" type="checkbox" name="ativo" id="ativo" value=""  disabled required>
																<label class="form-check-label" for="ativo">Ativo</label>
															</div>
														</div>	
														<div class="row clearfix">
															<div class="form-group-sm col-xs-6 col-sm-6 col-md-3 col-lg-3" >
																<label class="control-label label-sm">Id: </label>
																<input class="form-control input-sm text-right" type="text" value="" id="IdUser" name="IdUser" readonly="readonly" disabled />
															</div>																
														</div>																
													
														<div class="row clearfix">
															<div class="form-group-sm required col-xs-6 col-sm-6 col-md-6 col-lg-3 " >
																<label class="control-label label-sm" for="idTipo">Tipo de Usuário:</label>
																<select class="form-control input-sm" style="width: 100%" name="idTipo" id="idTipo" disabled required>
																	<option value="">Selecione</option>
																</select>
															</div>
															<div class="form-group-sm required col-xs-6 col-sm-6 col-md-6 col-lg-3" id="boxNomePerfil" >
																<label class="control-label label-sm" for="idPerfil">Perfil do Usuário:</label>
																<select class="form-control input-sm" style="width: 100%" name="idPerfil" id="idPerfil" disabled required>
																	<option value="">Selecione</option>
																</select>																	
															</div>
														</div>
														
														<div class="row clearfix">
															<div class="form-group-sm col-xs-3 col-sm-3 col-md-3 col-lg-3" id="boxCPF" >
																<label class="control-label label-sm" for="CPF">CPF: </label>
																<input class="form-control input-sm" type="text" maxlength="14" value="" id="CPF" name="CPF" readonly="readonly" placeholder="___.___.___-__" />
																<span id="lblCPFError" class="label label-danger" style="display: none;"></span>
															</div>	
															<div class="form-group-sm required col-xs-6 col-sm-6 col-md-6 col-lg-6">
																<label class="control-label label-sm" for="nome">Nome Completo:</label>
																<input class="form-control input-sm" type="text" maxlength="50" value="" id="nome" name="nome"  placeholder="Digite o Nome Completo"  />
															</div>	
															<div class="form-group-sm col-xs-3 col-sm-3 col-md-3 col-lg-3">
																<label class="control-label label-sm" for="dataNascimento">Data de Nascimento:</label>
																<input class="form-control input-sm" type="text" maxlength="14" value="" id="dataNascimento" name="dataNascimento"  placeholder="__/__/____"  />
															</div>																	
														</div>
														<div class="row clearfix">
															<div class="form-group-sm required col-xs-6 col-sm-6 col-md-6 col-lg-6" >
																<label class="control-label label-sm" for="email">E-mail:</label>
																<input class="form-control input-sm" type="text" maxlength="50" value="" id="email" name="email" onchange="conferirEmail(13);" placeholder="Digite o e-mail" data-toggle="popover" data-title="Email" data-content="Favor informar seu email de contato, este email será utilizado para acessar o sistema e receber mensagens. (Exemplo: seunome@cbvolei.org.br)" />
																<span id="lblEmailError" class="label label-danger" style="display: none;"></span>
															</div>
															<div class="form-group-sm col-xs-3 col-sm-3 col-md-3 col-lg-3" >
																<label class="control-label label-sm">Conta: </label>
																<input class="form-control input-sm text-right" type="text" value="" id="conta" name="conta" readonly="readonly" disabled />
																<br>
															</div>								
															<!--
															<div class="form-group-sm required col-xs-3 col-sm-3 col-md-3 col-lg-3" >
																<label class="control-label label-sm">Senha: </label>
																<input class="form-control input-sm" type="password" value="" id="senha" name="senha" disabled />
																<br>
															</div>																
															-->
														</div>
														
														<!--xxxx-->	
														<div class="row clearfix">
															<div class="form-group-sm required col-xs-4 col-sm-4 col-md-4 col-lg-4">
																<label for="Senha">Senha:*</label>
																<div class="input-group">  
																	<span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
																	<input type="password" class="form-control" style="" name="senha" id="senha" required></input>
																</div>
															</div>

															<div class="form-group-sm required col-xs-4 col-sm-4 col-md-4 col-lg-4">  
																<label for="Senha2">Confirmação de Senha:*</label> 
																<div class="input-group">
																	<span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
																	<input type="password" class="form-control" style="" name="senha2" id="senha2" required></input>
																</div>				
															</div>					
														</div>
														<!--xxxx-->				
														
														
														
													</div>
												</div>
												<div class="separacao_campos"><span>Contato</span></div>
												<div class="row clearfix">
													<div class="form-group-sm col-xs-6 col-sm-4 col-md-2 col-lg-2" >
														<label class="control-label label-sm" for="telefone">Telefone</label>
														<input class="form-control input-sm masktel1" type="text" maxlength="30" value="" id="telefone" name="telefone" placeholder="(__)___-____"   />
													</div>
													<div class="form-group-sm col-xs-6 col-sm-4 col-md-2 col-lg-2" >
														<label class="control-label label-sm" for="celular">Celular</label>
														<input class="form-control input-sm masktel2" type="text" maxlength="30" value="" id="celular" name="celular" placeholder="(__)____-____" />
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
                                            <h3 class="panel-title">Listagem de Usuários</h3>
                                        </div>
                                        <div class="panel-body">						
                                        <!-- Listagem - INICIO -->
                                            <form id="formPesquisa" name="formPesquisa" action="action.php" onSubmit="return false;" class="form-horizontal" >
                                                <input type="hidden" id="acao0" name="acao" value="filtrar" />
                                                <input type="hidden" id="Ativo" name="Ativo" value="1" />
                                                
												<div class="row clearfix">
                                                    <div class="col-md-12 column">
                                                        <div class="form-group-sm col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
                                                            <label for="filtroNome" class="control-label label-sm">Nome:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="filtroNome" name="filtroNome"  />
                                                        </div>
                                                        <div class="form-group-sm col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
                                                            <label for="filtroTipo" class="control-label label-sm">Tipo:</label>
															<select class="form-control input-sm" id="filtroTipo" name="filtroTipo" style="width: 100%" >
																<option value="">Selecione</option>
															</select>															
                                                        </div>
                                                        <div class="form-group-sm col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
                                                            <label for="filtroPerfil" class="control-label label-sm">Perfil:</label>
															<select class="form-control input-sm" id="filtroPerfil" name="filtroPerfil" style="width: 100%" >
																<option value="">Selecione</option>
															</select>		
                                                        </div>														
														
														<div class="form-group-sm col-xs-6 col-sm-3 col-md-3 col-lg-3 text-right" >
                                                            <button type="button" class="btn btn-default btn-filtro" id="bt_pesquisar" onclick="carregarLista(13);" disabled="disabled" ><span class="fa fa-search black"></span> Pesquisar</button>
                                                        </div>
                                                    </div>
                                                </div>												
                                            </form>
                                            
                                            <div class="separacao_linha-sm"><span></span></div>
                                            <div class="row clearfix">
                                                <div class="col-lg-12 column">
                                                    <table id="tabListagem" class="table table-striped table-bordered table-hover table-condensed" >
                                                        <thead>
                                                            <tr class="">
                                                                <th><b>&nbsp;</b></th>
                                                                <th><b>Nº </b></th>
                                                                <th><b>Nome / E-mail </b></th>
                                                                <th><b>Tipo de Usuário</b></th>
                                                                <th><b>Perfil de Acesso</b></th>
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