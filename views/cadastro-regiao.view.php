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
                                <div class="col-sm-12 col-md-9 col-lg-9 column">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">
                                                Formulário de Cadastro
                                            </h3>
                                        </div>
                                        <div class="panel-body">
                                            <form id="formCadastro" name="formCadastro" action="action.php" method="post" onsubmit="return false;" >
                                                <input type="hidden" id="controle" name="controle" value="" />
                                                <input type="hidden" id="acao" name="acao" value="" />
                                                <input type="hidden" id="Id" name="Id" value="" />
                                                <input type="hidden" id="Codigo" name="Codigo" value="" />
                                                <input type="hidden" id="IdStatus" name="IdStatus" value="" />
                                                <input type="hidden" id="IdUsuarioAcao" name="IdUsuarioAcao" value="" />
                                                
                                                <div class="row clearfix">
                                                    <div class="form-group-sm required col-xs-6 col-sm-6 col-md-3 col-lg-3" >
                                                        <label class="control-label label-sm">Id: </label>
                                                        <input class="form-control input-sm text-right" type="text" value="0" id="labelId" name="labelId" readonly="readonly" />
                                                    </div>
                                                    <div class="form-group-sm required col-xs-6 col-sm-6 col-md-3 col-lg-3" >
                                                        <label class="control-label label-sm">Codigo: </label>
                                                        <input class="form-control input-sm" type="text" value="0" id="labelCodigo" name="labelCodigo" readonly="readonly" />
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="form-group-sm required col-xs-6 col-sm-6 col-md-3 col-lg-3"  id="boxIdPais">
                                                        <label class="control-label label-sm" for="IdPais">País:</label>
                                                        <select class="form-control input-sm" id="IdPais" name="IdPais" onchange="IdPais_onchange(this.value, 13);" >
                                                                <option value="">[Nenhum]</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="form-group-sm required col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                                        <label class="control-label label-sm" for="Sigla">Sigla: </label>
                                                        <input class="form-control input-sm" type="text" maxlength="2" value="" id="Sigla" name="Sigla" placeholder="sigla" data-toggle="popover" data-html="true" data-placement="right" data-title="Sigla" data-content="Favor informar a sigla com 2 caracteres."  />
                                                    </div>
                                                    <div class="form-group-sm required required col-xs-12 col-sm-12 col-md-6 col-lg-6" >
                                                        <label class="control-label label-sm" for="Nome">Nome:</label>
                                                        <input class="form-control input-sm" type="text" maxlength="50" value="" id="Nome" name="Nome"  placeholder="nome" data-toggle="popover" data-html="true" data-placement="right" data-title="Nome" data-content="Favor informar o nome com no máximo 50 caracteres." />
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
                                                    <div class="form-group-sm col-xs-2 col-sm-1 col-md-1 col-lg-1 ">
                                                        <label class="control-label label-sm" for="Revisao">Rev.:</label>
                                                        <input class="form-control input-sm text-right" type="text" maxlength="3" value="" id="Revisao" name="Revisao" readonly="readonly" />
                                                    </div>                                                        
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
                                <div class="col-sm-6 col-md-3 col-lg-3 column"><!-- CONTEUDO - DIREITA - INICIO *** //-->
                                    <div class="space-10 visible-sm"></div>
                                    <div class="well"> 
                                        <h3><span class="glyphicon glyphicon-info-sign"></span> Dica</h3>
                                        <p>Mantenha seus dados atualizados para facilitar a comunicação do sistema.</p>
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
                                                            <label for="filtroIdPais" class="control-label label-sm">País:</label>
                                                            <select class="form-control input-sm" id="filtroIdPais" name="filtroIdPais" onchange="" >
                                                                    <option value="">[Nenhum]</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group-sm col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                            <label for="filtroNome" class="control-label label-sm">Nome:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="filtroNome" name="filtroNome"  />
                                                        </div>												
                                                        <div class="form-group-sm col-xs-6 col-sm-2 col-md-2 col-lg-2 col-lg-3" >
                                                            <br/>
                                                            <button id="bt_pesquisar" onclick="carregarLista();" class="btn btn-info btn-sm btn-espace" type="submit">
                                                                <i class="glyphicon glyphicon-search"></i> Consultar
                                                            </button>
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
                                                                <th><b>Pais</b></th>
                                                                <th><b>Sigla</b></th>
                                                                <th><b>Nome</b></th>
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