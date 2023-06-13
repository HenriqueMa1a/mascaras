            <!-- MODULO CONTEUDO - INICIO *** //-->
            <div class="row clearfix">
                <div class="col-md-2 col-lg-3 column hidden-xs hidden-sm">
                </div>
                <div class="col-sm-8 col-md-7 col-lg-6 column"><!-- MODULO CONTEUDO - INICIO *** //-->
                    <div class="space-40 hidden-xs hidden-sm"></div>
                    <div class="space-10 visible-sm"></div>
                    <!-- Contato - INICIO -->
                    <div id="div_minha_conta" class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="glyphicon glyphicon-lock"></span>
                                Alterar Senha
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div id="panel_alert" class="alert alert-dismissable alert-danger" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                <form class="form-horizontal" id="formCadastro" method="post" action="action.php">
                                    <input type="hidden" id="controle" name="controle" value="Usuario" />
                                    <input type="hidden" id="acao" name="acao" value="editarSenha" />
                                        <div class="space-10"></div>
                                        <div class="form-group required">
                                            <label for="SenhaAtual" class="col-sm-5 col-md-4 col-lg-4 control-label">Senha Atual: </label>
                                            <div class="col-lg-6 input-group" >
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                                <input type="password" class="form-control" id="SenhaAtual" name="SenhaAtual" placeholder="senha" />
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <label for="SenhaNova" class="col-sm-5 col-md-4 col-lg-4 control-label">Senha Nova: </label>
                                            <div class="col-lg-6 input-group" >
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                                <input type="password" class="form-control" id="SenhaNova" name="SenhaNova" placeholder="senha nova" />
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <label for="SenhaNova2" class="col-sm-5 col-md-4 col-lg-4 control-label">Confirme a Senha: </label>
                                            <div class="col-lg-6 input-group" >
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                                <input type="password" class="form-control" id="SenhaNova2" name="SenhaNova2" placeholder="confirme a senha" />
                                            </div>
                                        </div>
                                        <div class="separacao_linha"></div>
                                        <div class="row clearfix mb-14">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" id="boxToolbarEdicao">
                                                <button type="button" id="bt_cancelar" class="btn btn-default btn-espace" title="Cancelar Operação" onclick="cancelar();"><span class="glyphicon glyphicon-stop"></span> Cancelar</button>
                                                <button type="button" id="bt_gravar"   class="btn btn-success btn-espace" title="Gravar Registro"   onclick="gravar();"  ><span class="glyphicon glyphicon-floppy-disk"></span> Gravar</button>
                                            </div>
                                        </div>
                                 </form>
                            </div>
                        </div>
                    </div>
                    <div class="space-20"></div>
                    <!-- MODULO CONTEUDO - FINAL *** //-->
                </div>
                <div class="col-sm-4 col-md-3 col-lg-3 column"><!-- CONTEUDO - DIREITA - INICIO *** //-->
                    <div class="space-10 visible-sm"></div>
                    <div class="well"> 
                        <h3><span class="glyphicon glyphicon-info-sign"></span>Dica</h3>
                        <p>Dica para construçãom de senha:</p>
                        <ul>
                            <li>Sejam fáceis de lembrar;</li>
                            <li>Contenham no mínimo 6 (seis) caractéres;</li>
                            <li>Contenha três dos seguintes critérios de complexidade: caracteres maiúsculos, minúsculos, especiais (símbolos) e números;</li>
                            <li>Sejam isentas de caracteres idênticos consecutivos ou de grupois de caracteres, por exemplo: aaa, abc, 111, 123...;</li>
                            <li>Não sejam baseadas em informações pssoais;</li>
                        </ul>
                    </div>		
                </div>
            </div>
            <!-- MODULO CONTEUDO - FINAL *** //-->
