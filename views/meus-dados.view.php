                <div class="row clearfix"> <!-- CONTEUDO - MEIO - INICIO *** //-->
                    <div class="col-sm-12 col-md-12 col-lg-12 column">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h2 class="panel-title"><?php echo $sisModulo->Imagem.' '.$sisModulo->Nome ?></h2>
                            </div>
                            <div class="panel-body">
                                <form id="formCadastro" name="formCadastro" action="action.php" method="post" onsubmit="return false;" >
                                    <input type="hidden" id="controle" name="controle" value="Usuario" />
                                    <input type="hidden" id="acao" name="acao" value="editar" />
                                    <input type="hidden" id="Id" name="Id" value="" />
                                    <input type="hidden" id="IdUsuario" name="IdUsuario" value="" />
                                    <input type="hidden" id="IdTipo" name="IdTipo" value="" />
                                    <input type="hidden" id="IdStatus" name="IdStatus" value="" />
                                    <input type="hidden" id="IdEmpresa" name="IdEmpresa" value="" />
                                    <input type="hidden" id="IdPessoa" name="IdPessoa" value="" />
                                    <input type="hidden" id="IdPerfil" name="IdPerfil" value="" />
                                    <input type="hidden" id="Conta" name="Conta" value="" />
                                    <input type="hidden" id="Ativo" name="Ativo" value="" />
                                    <input type="hidden" id="IdUsuarioAcao" name="IdUsuarioAcao" value="" />
                                    
                                    <input type="hidden" id="IdEndereco1" name="IdEndereco1" value="" />
                                    <input type="hidden" id="IdEndereco2" name="IdEndereco2" value="" />

                                    <div class="row clearfix">
                                    </div>
                                    <!-- <div class="separacao_campos"><span>Dados Pessoais</span></div> -->
                                    <div class="row clearfix">
                                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" >
                                            <div class="form-group " >
                                                <label class="control-label label-sm">Fotografia: </label>
                                                <div class="mb-14">
                                                    <img id="arqFotografia" name="arqFotografia" src="fotos/kellen.jpg" alt="..."  class="img-thumbnail"
														width="auto" height="auto"  onclick='alert("Teste");' style="cursor:pointer;"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9" >
											<div class="row clearfix mb-14">
												<div class="form-group required col-xs-12 col-sm-6 col-md-6 col-lg-3 " >
													<label class="control-label label-sm" for="NomeTipo">Tipo de Usuário:</label>
													<input class="form-control input-sm" type="text" maxlength="50" value="" id="NomeTipo" name="NomeTipo" readonly="readonly" />
												</div>
												<div class="form-group required col-xs-12 col-sm-6 col-md-6 col-lg-3" id="boxNomePerfil" >
													<label class="control-label label-sm" for="NomePerfil">Perfil do Usuário:</label>
													<input class="form-control input-sm" type="text" maxlength="50" value="" id="NomePerfil" name="NomePerfil" readonly="readonly" />
												</div>
											</div>
											<div class="row clearfix">
												<div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3" id="boxCPF" >
													<label class="control-label label-sm" for="CPF">CPF: </label>
													<input class="form-control input-sm" type="text" maxlength="14" value="" id="CPF" name="CPF" onchange="conferirCPF(13);" placeholder="___.___.___-__" data-toggle="popover" data-title="Número do CPF" data-content="Favor informar seu CFP. (Exemplo: 001.001.001-00)" />
													<span id="lblCPFError" class="label label-danger" style="display: none;"></span>
												</div>	
											</div>
											<div class="row clearfix">
												<div class="form-group required col-xs-12 col-sm-8 col-md-6 col-lg-6">
													<label class="control-label label-sm" for="Nome">Nome Completo:</label>
													<input class="form-control input-sm" type="text" maxlength="50" value="" id="Nome" name="Nome"  placeholder="nome"  />
												</div>
												<div class="form-group required col-xs-12 col-sm-6 col-md-6 col-lg-6" >
													<label class="control-label label-sm" for="Email">Email:</label>
													<input class="form-control input-sm" type="text" maxlength="50" value="" id="Email" name="Email" onchange="conferirEmail(13);" placeholder="e-mail" data-toggle="popover" data-title="Email" data-content="Favor informar seu email de contato, este email será utilizado para acessar o sistema e receber mensagens. (Exemplo: seunome@cbvolei.org.br)" />
													<span id="lblEmailError" class="label label-danger" style="display: none;"></span>
												</div>
											</div>
                                        </div>
                                    </div>
                                    <div class="separacao_campos"><span>Contato</span></div>
                                    <div class="row clearfix mb-14">
                                        <div class="form-group col-xs-6 col-sm-4 col-md-2 col-lg-2" >
                                            <label class="control-label label-sm" for="Telefone">Telefone</label>
                                            <input class="form-control input-sm" type="text" maxlength="30" value="" id="Telefone" name="Telefone" placeholder="telefone"   />
                                        </div>
                                        <div class="form-group col-xs-6 col-sm-4 col-md-2 col-lg-2" >
                                            <label class="control-label label-sm" for="Telefone">Celular</label>
                                            <input class="form-control input-sm" type="text" maxlength="30" value="" id="Celular" name="Celular" placeholder="celular"  />
                                        </div>
                                    </div>
                                    <div class="separacao_linha-sm"><span></span></div>
                                    <div class="row clearfix">
                                        <div class="form-group col-xs-6 col-sm-6 col-md-3 col-lg-3  ">
                                            <label class="control-label label-sm" for="DataCadastro">Data Cadastro:</label>
                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="DataCadastro" name="DataCadastro" readonly="readonly" />
                                        </div>
                                        <div class="form-group col-xs-6 col-sm-6 col-md-3 col-lg-3  ">
                                            <label class="control-label label-sm" for="DataAcao">Última Atualização:</label>
                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="DataAcao" name="DataAcao" readonly="readonly" />
                                        </div>
                                        <div class="form-group col-xs-6 col-sm-6 col-md-3 col-lg-3  ">
                                            <label class="control-label label-sm" for="NomeUsuarioAcao">Usuário da Atualização:</label>
                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="NomeUsuarioAcao" name="NomeUsuarioAcao" readonly="readonly" />
                                        </div>
                                    </div>
                                    <div class="separacao_linha-sm"></div>
                                    <div class="row clearfix">
                                        <div class="col-md-12 col-lg-12 text-right">
                                            <button type="button" id="bt_voltar" class="btn btn-default btn-espace" onclick="sair();" title="Voltar" data-content="Clique aqui sair desta tela."><span class="glyphicon glyphicon-chevron-left"></span> Voltar</button>
                                            <button type="button" id="bt_cancelar" class="btn btn-default btn-espace" title="Cancelar Operação" onclick="cancelar();"><span class="glyphicon glyphicon-stop"></span> Cancelar</button>
                                            <button type="button" id="bt_senha"  class="btn btn-info btn-espace"    onclick="alterarSenha();" title="Alterar Senha" data-content="Clique aqui para ir para tela de alteração de senha."><span class="glyphicon glyphicon-lock"></span> Alterar Senha</button>
                                            <button type="button" id="bt_editar" class="btn btn-warning btn-espace" onclick="editar();" disabled="disabled" title="Editar Registro"  ><span class="glyphicon glyphicon-pencil"></span> Editar</button>
                                            <button type="button" id="bt_gravar" class="btn btn-success btn-espace" onclick="gravar();" disabled="disabled" title="Gravar Registro"  data-content="Clique aqui para gravar os seus dados atualizados." ><span class="glyphicon glyphicon-floppy-disk"></span> Gravar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 column"><!-- CONTEUDO - DIREITA - INICIO *** //-->
                    <div class="space-10 visible-sm"></div>
                    <div class="well"> 
                        <h3><span class="glyphicon glyphicon-info-sign"></span> Dica</h3>
                        <p>Mantenha seus dados atualizados para facilitar a comunicação do sistema com você.</p>
                    </div>        
                </div>    
            </div><!-- CONTEUDO - MEIO - FINAL *** //-->