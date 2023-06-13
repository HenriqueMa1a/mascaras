            <!-- MODULO CONTEUDO - INICIO ******************************************************************************************************************* //-->
            <div class="row clearfix">
                <div class="col-md-2 col-lg-3  column hidden-xs">
                </div>
                <div class="col-sm-9 col-md-7 col-lg-6 column"><!-- MODULO CONTEUDO - INICIO *** //-->
                    <div class="space-40 hidden-xs hidden-sm"></div>
                    <div class="space-10 visible-sm"></div>
                    <!-- Login - INICIO -->
                    <div id="div_minha_conta" class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="glyphicon glyphicon-lock"></span> Acesso ao Sistema
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div id="panel_alert" class="alert alert-dismissable alert-danger" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                <form class="form-horizontal" id="formLogin" method="post" action="action.php">
                                    <input type="hidden" id="controle" name="controle" value="Usuario" />
                                    <input type="hidden" id="acao" name="acao" value="autenticar" />
                                    <div class="space-10"></div>
                                    <div class="form-group required" id="group-email">
                                        <label for="acessoEmail" class="col-sm-3 col-md-3 col-lg-3 control-label">Email:</label>
                                        <div class="col-sm-9 col-md-8 col-lg-8 input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                            <input type="text" class="form-control" id="acessoEmail" name="acessoEmail" placeholder="email" data-toggle="popover" data-placement="top" data-title="E-mail" data-content="Favor informar seu endereço de e-mail. Caso não tenha e-mail clique no link 'Login por CPF' para se autenticação com seu CPF." />
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label for="acessoSenha" class="col-sm-3 col-md-3 col-lg-3 control-label">Senha:</label>
                                        <div class="col-sm-7 col-md-7 col-lg-6 input-group" >
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                            <input type="password" class="form-control" id="acessoSenha" name="acessoSenha" placeholder="senha" data-toggle="popover" data-placement="bottom" data-title="Senha" data-content="Favor informar sua senha de acesso. Caso não se lembre clique no link 'Enqueci minha senha' para recebe-la no seu e-mail." />
                                        </div>
                                    </div>
                                    <div class="space-10"></div>
                                    <div class="form-group">
                                        <div class="col-lg-12 text-right">
                                            <button type="submit" class="btn btn-success" id="bt_enviar"><span class="fa fa-key"></span>  Entrar </button>
                                        </div>
                                    </div>
									
                                </form>
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                <div class="separacao_linha-sm"><span></span></div>
                                <div class="col-sm-6 text-left">
                                    <p>
                                        <span class="glyphicon glyphicon-credit-card blue"></span> <a title="Autenticação por CPF" href="controller.php?mod=autenticacao-cpf">Login por CPF</a>
                                    </p>
                                    <p style="display:none;">
                                        <span class="fa fa-user-plus blue"></span> <a href="controller.php?mod=criar-conta" title="Criar uma conta">Criar uma Conta</a>
                                    </p>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <span class="fa fa-lock blue"></span> <a title="Esqueci minha Senha" href="controller.php?mod=lembrete-senha">Esqueci minha Senha</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space-20"></div>
                </div>
                <div class="col-sm-3 col-md-3 column"><!-- CONTEUDO - DIREITA - INICIO *** //-->
                    <div class="space-10 visible-sm"></div>
                    <div class="well">
                        <h4>Informações</h4>
                        <p>Área para acesso ao conteúdo restrito do sistema.</p>
                    </div>
                </div>
            </div>
            <!-- MODULO CONTEUDO - FINAL *** //-->