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
                                </div>
                            </div>

							<div id="boxMensagem" class="clearfix alert-sm"></div><!-- MENSAGEM PEQUENA //-->
							<form id="formTransacao" name="formTransacao" action="action.php" onSubmit="return false;" >
								<input type="hidden" id="controle1" name="controle" value="EventoParticipacao" />
								<input type="hidden" id="acao1" name="acao" value="" />
								<input type="hidden" id="Id1" name="Id" value="" />  
								<input type="hidden" id="Situacao1" name="Situacao" value="" /> 
								<input type="hidden" id="IdEvento1" name="IdEvento" value="" />
								<input type="hidden" id="IdParticipante1" name="IdParticipante" value="" />
							</form>	
                            
                            <div class="row clearfix" id="boxListagem">
                                <div class="col-md-12 column">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Listagem</h3>
                                        </div>
                                        <div class="panel-body">						
                                        <!-- Listagem - INICIO -->
                                            <div class="row clearfix">
                                                <div class="col-md-12 column">
                                                    
                                                    <p class="text-subtitulo" style="margin-left: 10px;"><b>Filtros:&nbsp;</b></p>
                                                    <form id="formPesquisa" name="formPesquisa" action="action.php" onSubmit="return false;" class="form-horizontal" >
                                                        <input type="hidden" id="acao0" name="acao" value="filtrar" />
                                                        <input type="hidden" id="Ativo" name="Ativo" value="1" />

														<div class="row clearfix" style="margin-left: 10px;">
															<div class="form-group-sm col-xs-6 col-sm-6 col-md-6 col-lg-6">
																<label for="filtroIdEventoPrincipal" class="control-label label-sm">Evento Principal:</label>
																<select class="form-control input-sm" id="filtroIdEventoPrincipal" name="filtroIdEventoPrincipal" disabled >
																	<option value="3">IV International Symposium on Immunobiologicals</option>
																</select>
															</div>
														</div>	
														
														<div class="row clearfix" style="margin-left: 10px;">
															<div class="form-group-sm col-xs-2 col-sm-2 col-md-2 col-lg-2" style="display: none;">
																<label for="filtroIdEvento" class="control-label label-sm">Evento:</label>
																<select class="form-control input-sm" id="filtroIdEvento" name="filtroIdEvento" onchange="" >
																		<option value="">[Nenhum]</option>
																</select>
															</div>														
															<div class="form-group-sm col-xs-3 col-sm-3 col-md-3 col-lg-3">
																<label for="filtroParticipante" class="control-label label-sm">Participante:</label>
																<input class="form-control input-sm" type="text" maxlength="50" value="" id="filtroParticipante" name="filtroParticipante"  />
															</div>	
															<div class="form-group-sm col-xs-2 col-sm-2 col-md-2 col-lg-2 ">
																<label class="control-label label-sm" for="filtroIdStatus">Status da Inscrição:</label>
																<select class="form-control input-sm" id="filtroIdStatus" name="filtroIdStatus">
																	<option value="">Todos</option>
																	<option value="1">Pendente</option>
																	<option value="10">Concluído</option>
																	<option value="8">Em análise</option>
																</select>
															</div>
															<div class="form-group-sm col-xs-5 col-sm-5 col-md-5 col-lg-5 text-right" >
																<br/>
																<button type="button" class="btn btn-default btn-filtro" id="bt_pesquisar" onclick="carregarLista(13);" disabled="disabled" ><span class="fa fa-search black"></span> Pesquisar</button>
																<button type="button" class="btn btn-default btn-filtro" id="bt_atualizar" onclick="atualizarParticipantes(13);" disabled="disabled" ><span class="fa fa-refresh blue"></span> Atualizar Solicitações</button> 
																<button type="button" class="btn btn-default btn-filtro" id="bt_listaPresenca" onclick="carregarRelatorioTransacao('excel', 13);" disabled="disabled" ><span class="fa fa-table green"></span> Lista de Presença</button> 
															</div>
														</div>
                                                    </form>
                                                    <br/>
                                                    
                                                </div>
                                            </div>
                                            <div class="separacao_linha-sm"><span></span></div>
                                            <div class="row clearfix">
                                                <div class="col-lg-12 column">
                                                    <table id="tabListagem" class="table table-striped table-bordered table-hover table-condensed">
                                                        <thead>
                                                            <tr class="">
                                                                <!--<th><b>&nbsp;</b></th>-->
                                                                <th><b>Id&nbsp;</b></th>
                                                                <th><b>Documento</b></th>
																<th><b>Participante</b></th>
																<th><b>E-mail</b></th>
                                                                <th><b>Decisão</b></th>
																<th><b>Status</b></th>
                                                                <th><b>Presença</b></th>
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