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
                                <div class="col-sm-12 col-md-8 col-lg-8 column">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><span class="fa fa-pencil-square-o"></span> Formulário de Cadastro</h3>
                                        </div>
                                        <div class="panel-body">
                                            <form id="formCadastro" name="formCadastro" action="action.php" method="post" onsubmit="return false;" >
                                                <input type="hidden" id="controle" name="controle" value="" />
                                                <input type="hidden" id="acao" name="acao" value="" />
                                                <input type="hidden" id="Id" name="Id" value="" />
                                                <input type="hidden" id="Chave" name="Chave" value="" />
                                                
                                                <input type="hidden" id="Autor1" name="Autor1" value="" />
                                                <input type="hidden" id="Instituicao1" name="Instituicao1" value="" />
                                                <input type="hidden" id="Email1" name="Email1" value="" />
                                                <input type="hidden" id="Apresentador1" name="Apresentador1" value="" />
                                                
                                                <input type="hidden" id="Tipo" name="Tipo" value="" />
                                                <input type="hidden" id="Titulo" name="Titulo" value="" />
                                                <input type="hidden" id="Instroducao" name="Instroducao" value="" />
                                                <input type="hidden" id="Objetivo" name="Objetivo" value="" />
                                                <input type="hidden" id="Metodologia" name="Metodologia" value="" />
                                                <input type="hidden" id="Resultado" name="Resultado" value="" />
                                                <input type="hidden" id="Conclusao" name="Conclusao" value="" />
                                                <input type="hidden" id="PalavraChave" name="PalavraChave" value="" />
                                                
                                                <div class="row clearfix mb-14">
                                                    <div class="form-group-sm required col-xs-6 col-sm-6 col-md-3 col-lg-3" >
                                                        <label class="control-label label-sm">Id: </label>
                                                        <input class="form-control input-sm text-right" type="text" value="0" id="labelId" name="labelId" readonly="readonly" />
                                                    </div>
                                                    <div class="form-group-sm required col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                                        <label class="control-label label-sm" for="Codigo">Código: </label>
                                                        <input class="form-control input-sm" type="text" maxlength="10" value="" id="Codigo" name="Codigo" placeholder="codigo"  data-toggle="popover" data-html="true" data-placement="right" data-title="Código" data-content="Favor informar o código de identificação do Resumo." readonly="readonly"/>
                                                    </div>
                                                    <div class="form-group-sm required col-xs-6 col-sm-6 col-md-4 col-lg-4">
                                                        <label class="control-label label-sm" for="Classificacao">Classificação: </label>
                                                        <input class="form-control input-sm" type="text" maxlength="6" value="" id="Classificacao" name="Classificacao" placeholder="Classificacao"  data-toggle="popover" data-html="true" data-placement="right" data-title="Classificação" data-content="Favor informar o Classificação do Resumo." readonly="readonly" />
                                                    </div>
                                                    <div class="form-group-sm col-xs-6 col-sm-2 col-md-2 col-lg-2 ">
                                                        <label class="control-label label-sm" for="Revisao">Versao:</label>
                                                        <input class="form-control input-sm text-right" type="text" maxlength="3" value="" id="Revisao" name="Revisao" readonly="readonly" />
                                                    </div>
                                                </div>
                                                
                                                <div class="row clearfix mb-14">
                                                    <div class="form-group-sm required col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                        <label class="control-label label-sm" for="NomeUsuarioCadastro">Nome do Autor: </label>
                                                        <input class="form-control input-sm" type="text" maxlength="6" value="" id="NomeUsuarioCadastro" name="NomeUsuarioCadastro" placeholder="Nome" data-toggle="popover" data-html="true" data-placement="right" data-title="Classificação" data-content="Nome de quem cadastrou o Resumo." readonly="readonly" />
                                                    </div>
                                                    <div class="form-group-sm col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
                                                        <label class="control-label label-sm" for="NomeStatus">Status:</label>
                                                        <select class="form-control input-sm" id="IdStatus" name="IdStatus" onchange="IdStatus_onchange(this.value);">
                                                            <option id="optIdStatus1" value="1">Enviado</option>
                                                            <option id="optIdStatus2" value="2">Em Analise</option>
                                                            <option id="optIdStatus3" value="3">Com Pendência</option>
															<option id="optIdStatus9" value="9">Com Pendência do NIT</option>
															<option id="optIdStatus8" value="8">Aguardando Aprovação do NIT</option>
                                                            <!-- <option id="optIdStatus4" value="4">Aprovado para Publicação</option>-->
                                                            <option id="optIdStatus5" value="5">Aprovado para Publicação e Exposição</option>
                                                            <option id="optIdStatus6" value="6">Aprovado para Publicação, Exposição e Apresentação</option>
                                                            <option id="optIdStatus7" value="7">Recusado</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group-sm col-xs-6 col-sm-3 col-md-3 col-lg-3  ">
                                                        <label class="control-label label-sm" for="DataCadastro">Data do Cadastro:</label>
                                                        <input class="form-control input-sm" type="text" maxlength="50" value="" id="DataCadastro" name="DataCadastro" readonly="readonly" />
                                                    </div>
                                                </div>
                                                
                                                <div class="row clearfix mb-14" id="boxObservacao">
                                                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                                        <label class="control-label label-sm" for="Observacao">Observações:</label>
                                                        <textarea class="form-control" rows="2" id="Observacao" name="Observacao" maxlength="10000"></textarea>
                                                    </div>
                                                </div>
                                                
                                                <div class="row clearfix mb-14" id="boxReferencia">
                                                    <div class="form-group required col-xs-6 col-sm-3 col-md-3 col-lg-3" >
                                                        <label class="control-label label-sm" for="DataApresentacao">Data Apresentacao:</label>
                                                        <input class="form-control input-sm" type="text" maxlength="14" value="" id="DataApresentacao" name="DataApresentacao"  />
                                                    </div>
                                                    <div class="form-group required col-xs-6 col-sm-2 col-md-2 col-lg-2" >
                                                        <label class="control-label label-sm" for="DataApresentacao">Horário:</label>
														<input type="time" maxlength="8" id="HoraApresentacao" name="HoraApresentacao" pattern="[0-9]{2}:[0-9]{2} [0-9]{2}$" />	
                                                    <!--    <select class="form-control input-sm" id="HoraApresentacao" name="HoraApresentacao" onchange="" >
                                                                <option value="00:00">00:00</option><option value="01:00">01:00</option><option value="02:00">02:00</option><option value="03:00">03:00</option><option value="04:00">04:00</option><option value="05:00">05:00</option><option value="06:00">06:00</option><option value="07:00">07:00</option><option value="08:00">08:00</option><option value="09:00">09:00</option><option value="10:00">10:00</option><option value="11:00">11:00</option>
                                                                <option value="12:00">12:00</option><option value="13:00">13:00</option><option value="14:00">14:00</option><option value="15:00">15:00</option><option value="16:00">16:00</option><option value="17:00">17:00</option><option value="18:00">18:00</option><option value="19:00">19:00</option><option value="20:00">20:00</option><option value="21:00">21:00</option><option value="22:00">22:00</option><option value="23:00">23:00</option>
                                                        </select>-->
                                                    </div>
                                                    <div class="form-group required col-xs-4 col-sm-2 col-md-2 col-lg-2" >
                                                        <label class="control-label label-sm" for="Referencia">Código Ref.:</label>
                                                        <input class="form-control input-sm" type="text" maxlength="20" value="" id="Referencia" name="Referencia" />
                                                    </div>
                                                    <div class="form-group required col-xs-4 col-sm-2 col-md-2 col-lg-2" >
                                                        <label class="control-label label-sm" for="Bloco">Bloco:</label>                                     
                                                        <input class="form-control input-sm" type="text" maxlength="20" value="" id="Bloco" name="Bloco" />
                                                    </div>
                                                    <div class="form-group required col-xs-4 col-sm-2 col-md-2 col-lg-2" >
                                                        <label class="control-label label-sm" for="Poster">Poster:</label>                                     
                                                        <input class="form-control input-sm" type="text" maxlength="20" value="" id="Poster" name="Poster" />
                                                    </div>
                                                </div>
                                                
                                                <div class="row clearfix mb-30">
                                                    <div class="form-group-sm required col-xs-12 col-sm-3 col-md-3 col-lg-2"  style="display:none;">
                                                        <label class="control-label label-sm" for="Ativo">Ativo:</label>
                                                        <select class="form-control input-sm" id="Ativo" name="Ativo" >
                                                            <option value="">[Selecione]</option>
                                                            <option value="1">Sim</option>
                                                            <option value="0">Não</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group-sm col-xs-6 col-sm-3 col-md-3 col-lg-3  ">
                                                        <label class="control-label label-sm" for="DataAcao">Última Atualização:</label>
                                                        <input class="form-control input-sm" type="text" maxlength="50" value="" id="DataAcao" name="DataAcao" readonly="readonly" />
                                                    </div>
                                                    <div class="form-group-sm col-xs-6 col-sm-5 col-md-5 col-lg-4  ">
                                                        <label class="control-label label-sm" for="NomeUsuarioAcao">Usuário:</label>
                                                        <input class="form-control input-sm" type="text" maxlength="50" value="" id="NomeUsuarioAcao" name="NomeUsuarioAcao" readonly="readonly" />
                                                    </div>
                                                </div>
                                                <div class="separacao_campos"><span>Resumo</span></div>
                                                <div class="row clearfix">
                                                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                                        <div class="panel panel-default">
                                                            <div class="panel-body">
                                                                <h4 align="justify" class="mb-5" id="pTitulo"  ></h4>
                                                                <p align="justify" class="mb-10" id="pAutores" ></p>
                                                                <p align="justify" class="mb-10"><strong>Introduction:</strong>    <span id="pIntroducao"   class="pSitacao"></span></p>
                                                                <p align="justify" class="mb-10"><strong>Objective:</strong>       <span id="pObjetivo"     class="pSitacao"></span></p>
                                                                <p align="justify" class="mb-10"><strong>Methodology:</strong>    <span id="pMetodologia"  class="pSitacao"></span></p>
                                                                <p align="justify" class="mb-10"><strong>Results:</strong>      <span id="pResultado"    class="pSitacao"></span></p>
                                                                <p align="justify" class="mb-10"><strong>Conclusion:</strong>      <span id="pConclusao"    class="pSitacao"></span></p>
                                                                <p align="justify" class="mb-10"><strong>Keywords: </strong><span id="pPalavraChave" class="pSitacao"></span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="separacao_linha"></div>
                                                <div class="row clearfix mb-14">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" id="boxToolbarEdicao">
                                                        <button type="button" id="bt_cancelar"  class="btn btn-default btn-espace" title="Cancelar Operação"  onclick="cancelar();"><span class="fa fa-arrow-left"></span> Voltar</button>
                                                        <button type="button" id="bt_editar"    class="btn btn-warning btn-espace" title="Editar Registro"    onclick="editar();"    disabled="disabled"><span class="fa fa-pencil"></span> Editar</button>
                                                        <button type="button" id="bt_excluir"   class="btn btn-danger btn-espace"  title="Excluir Registro"   onclick="excluir();"   disabled="disabled"><span class="fa fa-trash-o" ></span> Excluir</button>
                                                        <button type="button" id="bt_gravar"    class="btn btn-success btn-espace" title="Gravar Registro"    onclick="gravar();"    disabled="disabled"><span class="fa fa-floppy-o"></span> Gravar</button>
                                                        <button type="button" id="bt_reprovar"  class="btn btn-danger btn-espace"  title="Reprovar Transação" onclick="reprovar();"  disabled="disabled"><span class="fa fa-close"></span> Reprovar</button>
                                                        <button type="button" id="bt_aprovar"   class="btn btn-success btn-espace" title="Aprovar Transação"  onclick="aprovar();"   disabled="disabled"><span class="fa fa-check"></span> Aprovar</button>
                                                        <button type="button" id="bt_comunicar" class="btn btn-default btn-espace" title="Enviar Email"       onclick="comunicar();" disabled="disabled"><span class="fa fa-envelope-o"></span> Comunicar</button>
                                                    </div>
                                                </div>
                                            </form>	
                                        </div>
                                    </div>							
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-4 column"><!-- CONTEUDO - DIREITA - INICIO *** //-->
                                    <div class="space-10 visible-sm"></div>
                                    <div class="row clearfix mb-20">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><span class="fa fa-history brown"></span> Historico de Revisões</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div id="boxMensagemHistorico" class="clearfix alert-sm"></div><!-- MENSAGEM PEQUENA //-->
                                                
                                                <table id="tabListagemHistorico" class="table table-striped table-bordered table-hover table-condensed">
                                                    <thead>
                                                        <tr class="">
                                                            <th><b>&nbsp;</b></th>
                                                            <th><b>Id</b></th>
                                                            <th style="width: 40%;"><b>Código</b></th>
                                                            <th><b>Revisão</b></th>
                                                            <th><b>Data</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                                
                                            </div>
                                        </div>
                                    </div>
									
									
                                    <div class="row clearfix mb-20">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><span class="fa fa-cloud-download brown"></span> Autorizações da Chefia</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div id="boxMensagemAutorizacao" class="clearfix alert-sm"></div><!-- MENSAGEM PEQUENA //-->
                                                
                                                <table id="tabListagemAutorizacao" class="table table-striped table-bordered table-hover table-condensed">
                                                    <thead>
                                                        <tr class="">
                                                            <th style="width: 80%;"><b>Arquivo</b></th>
                                                            <th><b>Baixar</b></th>
															<th><b>Remover</b></th>
															<th><b>Enviar</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
												
												<!--
												<a href="../admin/anexos/Id340_Anexo1_20181205.png" download>
													<span class="fa fa-download"></span> </a>	
												-->	
													
                                                </table>
                                                
                                            </div>
                                        </div>
                                    </div>									
									
									
                                    <div class="row clearfix">
                                        <div class="well"> 
                                            <h3><span class="glyphicon glyphicon-info-sign yellow"></span> Dica:</h3>
                                            <p><b>Alteração de Status:</b></p>
                                            <ol>
                                                <li>Clique no botão <span class="label label-warning">Editar</span>.</li>
                                                <li>Alterar o campo <b>Status</b></li>
                                                <li>Clique no botão <span class="label label-success">Gravar</span>.</li>
                                                <li>Aguarde que o sistema exibirá uma mensagem com o resultado da operação.</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row clearfix" id="boxListagem">
                                <div class="col-md-12 column">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Listagem</h3>
                                        </div>
                                        <div class="panel-body">						
                                        <!-- Listagem - INICIO -->
                                            <form id="formPesquisa" name="formPesquisa" action="action.php" onSubmit="return false;" class="form-horizontal" >
                                                <input type="hidden" id="acao0" name="acao" value="filtrar" />
                                                <input type="hidden" id="Ativo" name="Ativo" value="1" />

                                                <div class="row clearfix">
                                                    <div class="col-md-12 column">
                                                        <p class="text-subtitulo" style="margin-left: 10px;"><b>Filtros:&nbsp;</b></p>
                                                        
														<div class="row clearfix" style="margin-left: 1px;">
															<div class="form-group-sm col-xs-6 col-sm-6 col-md-6 col-lg-6">
																<label for="filtroIdEventoPrincipal" class="control-label label-sm">Evento Principal:</label>
																<select class="form-control input-sm" id="filtroIdEventoPrincipal" name="filtroIdEventoPrincipal" onchange="" >
																		<option value="">[Nenhum]</option>
																</select>
															</div>
														</div>														
														
														<div class="form-group-sm col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
                                                            <label for="filtroNome" class="control-label label-sm">Nome:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="filtroNome" name="filtroNome"  />
                                                        </div>
                                                        <div class="form-group-sm col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
                                                            <label for="filtroTitulo" class="control-label label-sm">Titulo:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="filtroTitulo" name="filtroTitulo"  />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="col-md-12 column">
                                                            
                                                            <div class="form-group-sm col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
                                                                <label class="control-label label-sm" for="filtroIdTipo">Classificação:</label>
                                                                <select class="form-control input-sm" id="filtroIdTipo" name="filtroIdTipo">
                                                                    <option value="">Todos</option>
                                                                    <option value="1">V (Vacina)</option>
                                                                    <option value="2">B (Biofármaco) </option>
                                                                    <option value="3">R (Reativo para diagnóstico)</option>
                                                                    <option value="4">OTR (Outros temas relacionados)</option>
                                                                    <option value="5">G (Gestão)</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group-sm col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
                                                                <label class="control-label label-sm" for="filtroIdStatus">Status:</label>
                                                                <select class="form-control input-sm" id="filtroIdStatus" name="filtroIdStatus">
                                                                    <option value="">Todos</option>
                                                                    <option  value="1">Enviado</option>
                                                                    <option  value="2">Em Analise</option>
                                                                    <option  value="3">Com Pendencia</option>
																	<option  value="9">Com Pendência do NIT</option>
																	<option  value="8">Aguardando Aprovação do NIT</option>
                                                                    <!-- <option value="4">Aprovado para Publicação</option>-->
                                                                    <option  value="5">Aprovado para Publicação e Exposição</option>
                                                                    <option  value="6">Aprovado para Publicação, Exposição e Apresentação</option>
                                                                    <option  value="7">Recusado</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group-sm col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right" >
                                                                <br/>
                                                                <button type="button" class="btn btn-default btn-filtro" id="bt_pesquisar" onclick="carregarLista(13);" disabled="disabled" ><span class="fa fa-search black"></span> Pesquisar</button>
                                                                <button type="button" class="btn btn-default btn-filtro" id="bt_relatorio_excel" onclick="carregarRelatorio('excel', 13);" disabled="disabled" ><span class="fa fa-table green"></span> Visualizar Planilha</button>
																<button type="button" class="btn btn-default btn-filtro" id="bt_seleciona" onclick="selecionarFormato();" disabled="disabled" ><span class="fa fa-download"></span> Listar Resumos</button>
                                                            </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="separacao_linha-sm"><span></span></div>
                                            <div class="row clearfix">
                                                <div class="col-lg-12 column">
                                                    <table id="tabListagem" class="table table-striped table-bordered table-hover table-condensed">
                                                        <thead>
                                                            <tr class="">
                                                                <th><b>&nbsp;</b></th>
                                                                <th><b>&nbsp;</b></th>
                                                                <th><b>Id</b></th>
                                                                <th><b>Nome&nbsp;</b></th>
                                                                <th><b>Pessoa de Contato&nbsp;</b></th>
                                                                <th><b>Código</b></th>
                                                                <th><b>Título do Resumo</b></th>
                                                                <th><b>Classificação</b></th>
                                                                <th><b>Data de Cadastro</b></th>
                                                                <th><b>Status</b></th>
                                                                <th><b>Rev.&nbsp;</b></th>
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
			
			<div id="dialog-formato" title="Selecione o formato de impressão"> </div> 