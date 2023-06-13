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
                                <div class="col-sm-12 col-md-7 col-lg-7 column">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><span class="fa fa-pencil-square-o"></span> Formulário de Cadastro</h3>
                                        </div>
                                        <div class="panel-body">
                                            <form id="formCadastro" name="formCadastro" action="action.php" method="post" onsubmit="return false;" >
                                                <input type="hidden" id="controle" name="controle" value="" />
                                                <input type="hidden" id="acao" name="acao" value="" />
                                                <input type="hidden" id="Id" name="Id" value="" />
                                                <input type="hidden" id="IdEmpresa" name="IdEmpresa" value="" />
                                                <input type="hidden" id="IdStatus" name="IdStatus" value="" />
                                                <input type="hidden" id="IdUsuarioAcao" name="IdUsuarioAcao" value="" />
                                                
                                                <div class="row clearfix mb-10">
                                                    <div class="form-group-sm required col-xs-6 col-sm-4 col-md-3 col-lg-3" >
                                                        <label class="control-label label-sm">Id: </label>
                                                        <input class="form-control input-sm text-right" type="text" value="0" id="labelId" name="labelId" readonly="readonly" />
                                                    </div>
                                                    <div class="form-group-sm col-xs-6 col-sm-6 col-md-6 col-lg-6"  id="boxIdParente" >
                                                        <label class="control-label label-sm" for="IdParente">Evento Principal:</label>
                                                        <select class="form-control input-sm" id="IdParente" name="IdParente" onchange=""  data-toggle="popover" data-html="true" data-placement="right" data-title="Evento Principal" data-content="No caso de ser um cadastro de um Evento Principal, favor não preencher.">
                                                                <option value="">[Nenhum]</option>
                                                        </select>
                                                    </div> 
                                                    
                                                </div>
                                                <div class="row clearfix mb-10">
                                                    <div class="form-group-sm required col-xs-6 col-sm-6 col-md-3 col-lg-3"  id="boxIdTipoEvento" >
                                                        <label class="control-label label-sm" for="IdTipoEvento">Tipo de Evento:</label>
                                                        <select class="form-control input-sm" id="IdTipoEvento" name="IdTipoEvento" onchange="IdTdata-toggle="popover" data-html="true" data-placement="right" data-title="Tipo de Evento" data-content="Favor informar o tipo do evento." onchange="IdTipoEvento_onchange(this.value, 13);"  >
                                                                <option value="">[Nenhum]</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group-sm required col-xs-8 col-sm-4 col-md-4 col-lg-4"  id="boxIdLocalizacao" >
                                                        <label class="control-label label-sm" for="IdLocalizacao">Localização:</label>
                                                        <select class="form-control input-sm" id="IdLocalizacao" name="IdLocalizacao" onchange="" data-toggle="popover" data-html="true" data-placement="right" data-title="Localização" data-content="Favor informar a localização do evento.">
                                                                <option value="">[Nenhum]</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group-sm required col-xs-4 col-sm-3 col-md-3 col-lg-3">
                                                        <label class="control-label label-sm" for="Capacidade">Capacidade: </label>
                                                        <input class="form-control input-sm  text-right" type="text" maxlength="11" value="" id="Capacidade" name="Capacidade" placeholder="0" data-toggle="popover" data-html="true" data-placement="bottom" data-title="Capacidade" data-content="Favor informar à capacidade total do local do evento."  />
                                                    </div>
                                                    <div class="form-group-sm required col-xs-4 col-sm-2 col-md-2 col-lg-2">
                                                        <label class="control-label label-sm" for="CargaHoraria">Carga Horária: </label>
                                                        <input class="form-control input-sm  text-right" type="text" maxlength="5" value="" id="CargaHoraria" name="CargaHoraria" placeholder="0" data-toggle="popover" data-html="true" data-placement="bottom" data-title="Capacidade" data-content="Favor informar à carga horária total do evento. Esta informação poderá ser impressa no certificado de participação do evento.<br>Formato: 00:00"  />
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="form-group-sm required col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                                        <label class="control-label label-sm" for="Nome">Nome:</label>
                                                        <input class="form-control input-sm" type="text" maxlength="100" value="" id="Nome" name="Nome"  placeholder="nome"  data-toggle="popover" data-html="true" data-placement="bottom" data-title="Nome" data-content="Favor informar o nome com no máximo 50 caracteres." />
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="form-group required col-xs-6 col-sm-3 col-md-3 col-lg-3" >
                                                        <label class="control-label label-sm" for="DataInicial">Data Inicial:</label>
                                                        <input class="form-control input-sm" type="text" maxlength="14" value="" id="DataInicial" name="DataInicial"  onchange="calcularDataFinal();"/>
                                                    </div>                                                                                                                 
                                                    <div class="form-group required col-xs-6 col-sm-3 col-md-3 col-lg-3" >
                                                        <label class="control-label label-sm" for="DataInicial">Horário:</label>
                                                        <select class="form-control input-sm" id="HoraInicial" name="HoraInicial" onchange="" >
                                                                <option value="00:00">00:00</option><option value="01:00">01:00</option><option value="02:00">02:00</option><option value="03:00">03:00</option><option value="04:00">04:00</option><option value="05:00">05:00</option><option value="06:00">06:00</option><option value="07:00">07:00</option><option value="08:00">08:00</option><option value="09:00">09:00</option><option value="10:00">10:00</option><option value="11:00">11:00</option>
                                                                <option value="12:00">12:00</option><option value="13:00">13:00</option><option value="14:00">14:00</option><option value="15:00">15:00</option><option value="16:00">16:00</option><option value="17:00">17:00</option><option value="18:00">18:00</option><option value="19:00">19:00</option><option value="20:00">20:00</option><option value="21:00">21:00</option><option value="22:00">22:00</option><option value="23:00">23:00</option>
                                                        </select>
                                                    </div>                                                                                                                 
                                                    <div class="form-group required col-xs-6 col-sm-3 col-md-3 col-lg-3" >                                                 
                                                        <label class="control-label label-sm" for="DataFinal">Data Final:</label>                                     
                                                        <input class="form-control input-sm" type="text" maxlength="14" value="" id="DataFinal" name="DataFinal" />
                                                    </div>
                                                    <div class="form-group required col-xs-6 col-sm-3 col-md-3 col-lg-3" >
                                                        <label class="control-label label-sm" for="HoraFinal">Horário:</label>
                                                        <select class="form-control input-sm" id="HoraFinal" name="HoraFinal" onchange="" >
                                                                <option value="00:00">00:00</option><option value="01:00">01:00</option><option value="02:00">02:00</option><option value="03:00">03:00</option><option value="04:00">04:00</option><option value="05:00">05:00</option><option value="06:00">06:00</option><option value="07:00">07:00</option><option value="08:00">08:00</option><option value="09:00">09:00</option><option value="10:00">10:00</option><option value="11:00">11:00</option>
                                                                <option value="12:00">12:00</option><option value="13:00">13:00</option><option value="14:00">14:00</option><option value="15:00">15:00</option><option value="16:00">16:00</option><option value="17:00">17:00</option><option value="18:00">18:00</option><option value="19:00">19:00</option><option value="20:00">20:00</option><option value="21:00">21:00</option><option value="22:00">22:00</option><option value="23:00">23:00</option>
                                                        </select>
                                                    </div>                                                                                                                 
                                                </div>
                                                <div class="row clearfix" id="boxTextoCertificado">
                                                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                                        <label class="control-label label-sm" for="TextoCertificado">Texto do Certificado:</label>
                                                        <textarea class="form-control input-sm" rows="1" id="TextoCertificado" name="TextoCertificado" maxlength="512" ></textarea>
                                                    </div>
                                                </div>
                                                <div class="row clearfix" id="boxObservacao">
                                                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                                        <label class="control-label label-sm" for="Observacao">Observações:</label>
                                                        <textarea class="form-control input-sm" rows="1" id="Observacao" name="Observacao" maxlength="512" ></textarea>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="form-group-sm  col-xs-6 col-sm-6 col-md-3 col-lg-3" >
                                                        <label class="control-label label-sm" for="Solicitacoes">Solicitações: </label>
                                                        <input class="form-control input-sm text-right" type="text" value="0" id="Solicitacoes" name="Solicitacoes" readonly="readonly" data-toggle="popover" data-html="true" data-placement="right" data-title="Solicitacoes" data-content="Quantidade total de solicitações de inscrição."/>
                                                    </div>
                                                    <div class="form-group-sm  col-xs-6 col-sm-6 col-md-3 col-lg-3" >
                                                        <label class="control-label label-sm" for="Aprovados">Inscrições: </label>
                                                        <input class="form-control input-sm text-right" type="text" value="0" id="Aprovados" name="Aprovados" readonly="readonly" data-toggle="popover" data-html="true" data-placement="right" data-title="Aprovados" data-content="Quantidade total de solicitações de inscrição confirmadas."/>
                                                    </div>
                                                    <div class="form-group-sm  col-xs-6 col-sm-6 col-md-3 col-lg-3" >
                                                        <label class="control-label label-sm" for="Reprovados">Reprovados: </label>
                                                        <input class="form-control input-sm text-right" type="text" value="0" id="Reprovados" name="Reprovados" readonly="readonly" data-toggle="popover" data-html="true" data-placement="right" data-title="Reprovados" data-content="Quantidade total de solicitações de inscrição recusadas."/>
                                                    </div>
                                                    <div class="form-group-sm  col-xs-6 col-sm-6 col-md-3 col-lg-3" >
                                                        <label class="control-label label-sm" for="Presentes">Presentes: </label>
                                                        <input class="form-control input-sm text-right" type="text" value="0" id="Presentes" name="Presentes" readonly="readonly" data-toggle="popover" data-html="true" data-placement="right" data-title="Presentes" data-content="Quantidade total de inscritos presentes no envento."/>
                                                    </div>
                                                </div>
                                                <div class="separacao_linha-sm"><span></span></div>
                                                <div class="row clearfix">
                                                    <div class="form-group-sm required col-xs-12 col-sm-3 col-md-3 col-lg-2">
                                                        <label class="control-label label-sm" for="Ativo">Ativo:</label>
                                                        <select class="form-control input-sm" id="Ativo" name="Ativo" >
                                                            <option value="">[Selecione]</option>
                                                            <option value="1">Sim</option>
                                                            <option value="0">Não</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group-sm col-xs-12 col-sm-5 col-md-5 col-lg-4  ">
                                                        <label class="control-label label-sm" for="NomeStatus">Status:</label>
                                                        <input class="form-control input-sm" type="text" maxlength="50" value="" id="NomeStatus" name="NomeStatus" readonly="readonly" />
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="form-group-sm col-xs-2 col-sm-2 col-md-2 col-lg-2 ">
                                                        <label class="control-label label-sm" for="Revisao">Rev.:</label>
                                                        <input class="form-control input-sm text-right" type="text" maxlength="3" value="" id="Revisao" name="Revisao" readonly="readonly" />
                                                    </div>                                                        
                                                    <div class="form-group-sm col-xs-12 col-sm-4 col-md-4 col-lg-4  ">
                                                        <label class="control-label label-sm" for="DataAcao">Última Atualização:</label>
                                                        <input class="form-control input-sm" type="text" maxlength="50" value="" id="DataAcao" name="DataAcao" readonly="readonly" />
                                                    </div>
                                                    <div class="form-group-sm col-xs-12 col-sm-4 col-md-4 col-lg-4  ">
                                                        <label class="control-label label-sm" for="NomeUsuarioAcao">Usuário:</label>
                                                        <input class="form-control input-sm" type="text" maxlength="50" value="" id="NomeUsuarioAcao" name="NomeUsuarioAcao" readonly="readonly" />
                                                    </div>
                                                </div>
                                                <div class="separacao_linha"></div>
                                                <div class="row clearfix mb-14">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" id="boxToolbarEdicao">
                                                        <button type="button" id="bt_cancelar" class="btn btn-default btn-espace" title="Cancelar Operação" onclick="cancelar();"><span class="fa fa-stop"></span> Cancelar</button>
                                                        <button type="button" id="bt_editar"   class="btn btn-warning btn-espace" title="Editar Registro"   onclick="editar();"  disabled="disabled" ><span class="fa fa-pencil"></span> Editar</button>
                                                        <button type="button" id="bt_excluir"  class="btn btn-danger btn-espace"  title="Excluir Registro"  onclick="excluir();" disabled="disabled" ><span class="fa fa-trash" ></span> Excluir</button>
                                                        <button type="button" id="bt_gravar"   class="btn btn-success btn-espace" title="Gravar Registro"   onclick="gravar();"  disabled="disabled" ><span class="fa fa-floppy-o"></span> Gravar</button>
                                                        
                                                    </div>
                                                </div>
                                            </form>	
                                        </div>
                                    </div>							
                                </div>
                                <div class="col-sm-12 col-md-5 col-lg-5 column"><!-- CONTEUDO - DIREITA - INICIO *** //-->
                                    <div class="space-10 visible-sm"></div>
                                    
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><span class="fa fa-users blue"></span> Participantes do Evento</h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div id="boxMensagem" class="clearfix alert-sm"></div><!-- MENSAGEM PEQUENA //-->
                                                    <div class="row clearfix mb-14" id="boxToolbarTransacao">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <button type="button" id="bt_add_transacao" class="btn btn-sm btn-success btn-espace" title="Solicitar Inscrição"  onclick="abrirFormTransacao();"  disabled="disabled" ><span class="fa fa-plus"></span> Inscrição</button>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix mb-14">
                                                        <div class="col-md-12 column">
                                                            <p class="text-subtitulo" style="margin-left: 10px;"><b>Filtros:&nbsp;</b></p>
                                                            <form id="formPesquisa2" name="formPesquisa2" action="action.php" onSubmit="return false;" class="form-horizontal" >
                                                                <input type="hidden" id="acao0" name="acao" value="filtrar" />
                                                                <input type="hidden" id="Ativo" name="Ativo" value="1" />

                                                                <div class="form-group-sm col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                    <label for="filtroNome" class="control-label label-sm">Nome:</label>
                                                                    <input class="form-control input-sm" type="text" maxlength="50" value="" id="filtroNome2" name="Nome"  />
                                                                </div>												
                                                                <div class="form-group-sm col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                    <label class="control-label label-sm" for="filtroIdStatus" >Status:</label>
                                                                    <select class="form-control input-sm" id="filtroIdStatus2" name="IdStatus" onchange="" >
                                                                        <option value="">[Todos]</option>
                                                                        <option value="1">Pré-Inscrito</option>
                                                                        <option value="2">Inscrito</option>
                                                                        <option value="3">Recusado</option>
                                                                        <!-- <option value="4">Cancelada</option>-->
                                                                        <!-- <option value="5">Confirmado</option>-->
                                                                        <option value="6">Presente</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group-sm col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" >
                                                                    <button type="button" class="btn btn-sm btn-default btn-espace" id="bt_pesquisar2" onclick="carregarListaParticipantes(13);" disabled="disabled" ><span class="fa fa-search black"></span> Pesquisar</button>
                                                                    <button type="button" id="bt_relatorio_transacao"   class="btn btn-sm btn-default btn-espace" title="Gerar Lista de Presença" onclick="carregarRelatorioTransacao('excel', 13);" disabled="disabled" ><span class="fa fa-table green"></span> Lista de Presença</button>
                                                                </div>
                                                            </form>
                                                            <br/>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix mb-14" id="boxFormularioTransacao" style="display: none;">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">   
                                                            <div class="panel panel-info">
                                                                <div class="panel-heading">
                                                                    <h3 class="panel-title"><span class="fa fa-user-plus"></span> Formulário de Inscrição</h3>
                                                                </div>
                                                                <div class="panel-body">

                                                                    <form id="formTransacao" name="formTransacao" action="action.php" onSubmit="return false;" >
                                                                        <input type="hidden" id="controle1" name="controle" value="" />
                                                                        <input type="hidden" id="acao1" name="acao" value="" />
                                                                        <input type="hidden" id="Id1" name="Id" value="" />
                                                                        <input type="hidden" id="IdEventoParticipante1" name="IdEventoParticipante" value="" />
                                                                        <input type="hidden" id="IdEvento1" name="IdEvento" value="" />
                                                                        <input type="hidden" id="IdParticipante1" name="IdParticipante" value="" />
                                                                        
                                                                    <div class="row clearfix mb-10">
                                                                        <div class="form-group-sn required col-xs-6 col-sm-5 col-md-5 col-lg-5" id="boxTransacao1" style="display: none;">
                                                                            <label class="control-label label-sm" for="IdTransacao1">Transação:</label>
                                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="NomeTransacao1" name="NomeTransacao"  readonly="readonly" style="display:none;" />
                                                                            <select class="form-control input-sm" id="IdTransacao" name="IdTransacao1" onchange="IdTransacao_onchange(this.value);">
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row clearfix " id="">
                                                                        <div class="form-group required col-xs-6 col-sm-4 col-md-4 col-lg-4" id="boxDocumento1" style="display: none;">
                                                                            <label class="control-label label-sm" for="Documento1" id="lblDocumento1">Nº Documento:</label>
                                                                            <input class="form-control input-sm text-right" type="text" maxlength="10" value="" id="Documento1" name="Documento" style="max-width:120px;" />
                                                                        </div>
                                                                        <div class="form-group required col-xs-6 col-sm-6 col-md-6 col-lg-6" id="boxDataTransacao1">
                                                                            <label class="control-label label-sm" for="DataTransacao1" id="lblDataTransacao1">Data:</label>
                                                                            <input class="form-control input-sm" type="text" maxlength="14" value="" id="DataTransacao1" name="DataTransacao" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row clearfix " id="boxDetalhe1">
                                                                        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                                                            <label class="control-label label-sm" for="Detalhe" id="lblDetalhe1">Detalhamento:</label>
                                                                            <input class="form-control input-sm" type="text" id="Detalhe1" name="Detalhe" maxlength="255"  />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row clearfix " id="boxObservacao1">
                                                                        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                                                            <label class="control-label label-sm" for="Observacao1">Observações:</label>
                                                                            <textarea class="form-control input-sm" rows="1" id="Observacao1" name="Observacao" maxlength="400" ></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row clearfix " id="boxStatus1">
                                                                        <div class="form-group required col-xs-6 col-sm-6 col-md-6 col-lg-6" id="boxDataAcao1">
                                                                            <label class="control-label label-sm" for="DataAcao1" id="lblDataAcao1">Ultima Atualização:</label>
                                                                            <input class="form-control input-sm" type="text" maxlength="14" value="" id="DataAcao1" name="DataAcao" readonly="readonly"/>
                                                                        </div>
                                                                        <div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6" >
                                                                            <label class="control-label label-sm" for="NomeStatus1" id="lblNomeStatus1">Status:</label>
                                                                            <input class="form-control input-sm" type="text" id="NomeStatus1" name="NomeStatus" maxlength="50" readonly="readonly" />
                                                                            <input type="hidden" id="IdStatus1" name="IdStatus" value="" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row clearfix " id="boxAprovacao1">
                                                                        <div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6" >
                                                                            <label class="control-label label-sm" for="DataAprovacao1" id="lblUsuarioAprovacao1">DataAprovação:</label>
                                                                            <input class="form-control input-sm" type="text" id="DataAprovacao1" name="DataAprovacao" maxlength="50" readonly="readonly" />
                                                                        </div>
                                                                        <div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6" >
                                                                            <label class="control-label label-sm" for="NomeUsuarioAprovacao1" id="lblUsuarioAprovacao1">Aprovador:</label>
                                                                            <input class="form-control input-sm" type="text" id="NomeUsuarioAprovacao1" name="NomeUsuarioAprovacao" maxlength="50" readonly="readonly" />
                                                                            <input type="hidden" id="IdUsuarioAprovacao1" name="IdUsuarioAprovacao" value="" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="separacao_linha"></div>
                                                                    <div class="row clearfix">
                                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                                                                            <button type="button" id="bt_fechar_transacao"    class="btn btn-sm btn-default btn-espace" title="Fechar"              onclick="fecharFormTransacao();"                   ><span class="fa fa-stop"     ></span> Fechar</button>
                                                                            <button type="button" id="bt_editar_transacao"    class="btn btn-sm btn-warning btn-espace" title="Editar Transação"    onclick="editarTransacao();"     disabled="disabled"><span class="fa fa-pencil"  ></span> Editar</button>
                                                                            <button type="button" id="bt_excluir_transacao"   class="btn btn-sm btn-danger btn-espace"  title="Excluir Transação"   onclick="excluirTransacao();"    disabled="disabled"><span class="fa fa-trash"   ></span> Excluir</button>
                                                                            <button type="button" id="bt_gravar_transacao"    class="btn btn-sm btn-success btn-espace" title="Gravar Transação"    onclick="gravarTransacao();"     disabled="disabled"><span class="fa fa-floppy-o"></span> Gravar</button>
                                                                            <button type="button" id="bt_reprovar_transacao"  class="btn btn-sm btn-danger btn-espace"  title="Autorizar Transação" onclick="reprovarTransacao();"   disabled="disabled"><span class="fa fa-times"   ></span> Reprovar</button>
                                                                            <button type="button" id="bt_aprovar_transacao"   class="btn btn-sm btn-success btn-espace" title="Aprovar Transação"   onclick="aprovarTransacao();"    disabled="disabled"><span class="fa fa-check"   ></span> Aprovar</button>
                                                                            <button type="button" id="bt_comunicar_transacao" class="btn btn-sm btn-default btn-espace" title="Enviar Email"        onclick="comunicarTransacao();"  disabled="disabled"><span class="fa fa-envelope-o blue"></span> Comunicar</button>
                                                                            <button type="button" id="bt_confirmar_transacao" class="btn btn-sm btn-primary btn-espace" title="Gravar Transação"    onclick="confirmarTransacao();"  disabled="disabled"><span class="fa fa-check"   ></span> Confirmar Presença</button>
                                                                        </div>
                                                                    </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-14">
                                                        <table id="tabListagemParticipantes" class="table table-striped table-bordered table-hover table-condensed">
                                                            <thead>
                                                                <tr class="">
                                                                    <th><b>&nbsp;</b></th>
                                                                    <th><b>Id&nbsp;</b></th>
                                                                    <th><b>IdEvento&nbsp;</b></th>
                                                                    <th><b>Evento</b></th>
                                                                    <th><b>Saldo</b></th>
                                                                    <th><b>Inscrição&nbsp;</b></th>
                                                                    <th><b>Participante</b></th>
                                                                    <th><b>IdStatus</b></th>
                                                                    <th><b>Status</b></th>
																	<th><b>Observação</b></th>
																	<th><b>Certificado</b></th>
																	<th><b>IdTipoEvento</b></th>
																	<th><b>Presença</b></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
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
                                            <div class="row clearfix">
                                                <div class="col-md-12 column">
                                                    
                                                    <p class="text-subtitulo" style="margin-left: 10px;"><b>Filtros:&nbsp;</b></p>
                                                    <form id="formPesquisa" name="formPesquisa" action="action.php" onSubmit="return false;" class="form-horizontal" >
                                                        <input type="hidden" id="acao0" name="acao" value="filtrar" />
                                                        <input type="hidden" id="Ativo" name="Ativo" value="1" />

                                                        <div class="form-group-sm col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                            <label for="filtroIdTipoEvento" class="control-label label-sm">Tipo de Evento:</label>
                                                            <select class="form-control input-sm" id="filtroIdTipoEvento" name="filtroIdTipoEvento" onchange="" >
                                                                    <option value="">[Nenhum]</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group-sm col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                            <label for="filtroNome" class="control-label label-sm">Nome:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="filtroNome" name="filtroNome"  />
                                                        </div>												
                                                        <div class="form-group-sm col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right" >
                                                            <br/>
                                                            <button type="button" class="btn btn-default btn-filtro" id="bt_pesquisar" onclick="carregarLista(13);" disabled="disabled" ><span class="fa fa-search black"></span> Pesquisar</button>
                                                            <button type="button" class="btn btn-default btn-filtro" id="bt_atualizar" onclick="atualizarParticipantes(13);" disabled="disabled" ><span class="fa fa-refresh blue"></span> Atualizar Solicitações</button> 
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
                                                                <th><b>&nbsp;</b></th>
                                                                <th><b>Id&nbsp;</b></th>
                                                                <th><b>Tipo</b></th>
                                                                <th><b>Nome</b></th>
                                                                <th><b>Data</b></th>
                                                                <th><b>Capacidade&nbsp;</b></th>
                                                                <th><b>Solicitações&nbsp;</b></th>
                                                                <th><b>Inscrições&nbsp;</b></th>
                                                                <th><b>Saldo&nbsp;</b></th>
                                                                <th><b>Ativo</b></th>
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