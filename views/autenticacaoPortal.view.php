            <!-- MODULO CONTEUDO - INICIO ******************************************************************************************************************* //-->
            <div class="row clearfix">
                <div class="col-md-2 col-lg-2  column hidden-xs">
                </div>
                <div class="col-sm-9 col-md-7 col-lg-6 column"><!-- MODULO CONTEUDO - INICIO *** //-->
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
									<input type="hidden" id="acessoEmail" name="acessoEmail"  />
									<input type="hidden" id="acessoSenha" name="acessoSenha" value="autenticar" />
                                    <div class="space-10"></div>
									
									<div class="col-sm-12 col-md-12 col-lg-12">		
									<?php
										if ($sisConfig->LogotipoAbertura){
											echo '<img id="imgLogoPrincipal" src="images/'.$sisConfig->LogotipoAbertura.'" 
											style="border-radius: 10px; width:100%"
											alt="LogotipoAberturaPrincipal: '.$sisConfig->Nome.'" />';
										} else {
											echo 'Dashboard';
										}
									?>
									</div>		
									
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
										<div class="separacao_linha-sm"><span></span></div>
										<div class="form-group">
											<div class="col-lg-12 text-right">
												<button type="submit" class="btn btn-success" id="bt_enviar"><span class="fa fa-key"></span>  Entrar </button>
											</div>
										</div>

									</div>
                                </form>
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