        <!-- MODULO CONTEUDO - INICIO ******************************************************************************************************************* //-->
        <div class="col-md-12 column">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="panel-title"><?php echo $sisModulo->Imagem.' '.$sisModulo->Descricao; ?></span>
                    <button id="bt_sair" class="btn btn-default btn-sm btn-painel pull-right" title="Voltar" onclick="sair();" type="button"><span class="fa fa-reply"></span> Voltar</button>
                </div>
                <div class="panel-body">
                    <div class="row clearfix" id="boxToolbar">
                        <div id="menu_cadastro" class="col-md-12 col-lg-12 column linha-bottom">
                            <button type="button" id="bt_incluir" class="btn btn-primary btn-espace" title="Adicionar um novo registro" onclick="novo();" disabled="disabled"><span class="glyphicon glyphicon-plus"></span> Adicionar</button>
                        </div>
                    </div>
                    <div class="row clearfix" id="boxSteps" style="display: none;">
                        <div class="row bs-wizard" style="border-bottom:0;">
                            <div id="step-1" class="col-xs-4 bs-wizard-step active">
                                <div class="text-center bs-wizard-stepnum">Formulário de Cadastro</div>
                                <div class="progress"><div class="progress-bar"></div></div>
                                <a href="#" class="bs-wizard-dot" onclick="goToStep(1);"></a>
                                <div class="bs-wizard-info text-center">1º Passo</div>
                            </div>
                            <div id="step-2" class="col-xs-4 bs-wizard-step disabled">
                                <div class="text-center bs-wizard-stepnum">Documentação</div>
                                <div class="progress"><div class="progress-bar"></div></div>
                                <a href="#" class="bs-wizard-dot" onclick="goToStep(2);"></a>
                                <div class="bs-wizard-info text-center">2º Passo</div>
                            </div>
                            <div id="step-3" class="col-xs-4 bs-wizard-step disabled">
                                <div class="text-center bs-wizard-stepnum">Registro Profissional</div>
                                <div class="progress"><div class="progress-bar"></div></div>
                                <a href="#" class="bs-wizard-dot" onclick="goToStep(3);"></a>
                                <div class="bs-wizard-info text-center">3º Passo</div>
                            </div>

                        </div>
                    </div>
                    <div class="row clearfix" id="boxFormulario" style="display: none;">
                        <div class="col-sm-12 col-md-12 col-lg-12 column">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> <span class="glyphicon glyphicon-user blue"></span>
                                        Formulário de Cadastro
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <form id="formCadastro" name="formCadastro" action="action.php" method="post" onsubmit="return false;" >
                                        <input type="hidden" id="controle" name="controle" value="" />
                                        <input type="hidden" id="acao" name="acao" value="" />
                                        <input type="hidden" id="Id" name="Id" value="" />
                                        <input type="hidden" id="IdTipo" name="IdTipo" value="" />
                                        <input type="hidden" id="Ativo" name="Ativo" value="" />
                                        <input type="hidden" id="IdFed" name="IdFed" value="" />
                                        <input type="hidden" id="IdStatus" name="IdStatus" value="" />
                                        <input type="hidden" id="IdTipoPessoa" name="IdTipoPessoa" value="" />
                                        <input type="hidden" id="NotaOficial" name="NotaOficial" value="" />
                                        <input type="hidden" id="EstadoCivil" name="EstadoCivil" value="" />
                                        <input type="hidden" id="Nacionalidade" name="Nacionalidade" value="" />
                                        <input type="hidden" id="IdEndereco1" name="IdEndereco1" value="" />
                                        <input type="hidden" id="IdEndereco2" name="IdEndereco2" value="" />
                                        <input type="hidden" id="Critica" name="Critica" value="" />
                                        
                                        <input type="hidden" id="IdUsuarioCadastro" name="IdUsuarioCadastro" value="" />
                                        <input type="hidden" id="IdUsuarioAcao" name="IdUsuarioAcao" value="" />
                                        
                                        <input type="hidden" id="Docs" name="Docs" value="" />
                                        <input type="hidden" id="DocsObr" name="DocsObr" value="" />
                                        <input type="hidden" id="DocsCritica" name="DocsCritica" value="" />
                                       
                                        <div>
                                            <!-- Nav tabs -->
                                            <ul id="myTabs" class="nav nav-tabs" role="tablist">
                                                <li role="presentation" class="active"><a href="#tabPessoal" aria-controls="tabPessoal" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-user"></span> Pessoais</a></li>
                                                <li role="presentation"><a href="#tabDoc" aria-controls="tabDoc" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-credit-card"></span> Documentação</a></li>
                                                <li role="presentation"><a href="#tabContato" aria-controls="tabContato" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-envelope"></span> Contato</a></li>
                                                <li role="presentation"><a href="#tabEndRes" aria-controls="tabEndRes" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-inbox"></span> Endereço Residencial</a></li>
                                                <li role="presentation"><a href="#tabEndCom" aria-controls="tabEndCom" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-inbox"></span> Endereço Comercial</a></li>
                                                <li role="presentation"><a href="#tabOutros" aria-controls="tabOutros" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-option-horizontal"></span> Outros</a></li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div id="myTabContent" class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="tabPessoal">
                                                    <div class="row clearfix mt-10">
                                                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" >
                                                            <div class="form-group " >
                                                                <label class="control-label label-sm">Fotografia: </label>
                                                                <div class="mb-14">
                                                                    <img id="arqFotografia" name="arqFotografia" src="_files/pessoas/pes-000000000000.jpg" alt="..."  class="img-thumbnail" />
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-lg-12 ">
                                                                <input class="input" type="file" id="Fotografia" name="Fotografia"  style="max-width:250px;" />
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9" >
                                                            <div class="form-group required col-xs-12 col-sm-6 col-md-3 col-lg-3" id="boxCPF" >
                                                                <label class="control-label label-sm" for="CPF">CPF: </label>
                                                                <input class="form-control input-sm" type="text" maxlength="14" value="" id="CPF" name="CPF" onchange="conferirCPF(13);" placeholder="___.___.___-__" data-toggle="popover" data-title="Número do CPF" data-content="Favor informar seu CFP. (Exemplo: 001.001.001-00)" />
                                                                <span id="lblCPFError" class="label label-danger" style="display: none;"></span>
                                                            </div>
                                                            <div class="form-group required col-xs-6 col-sm-6 col-md-3 col-lg-2" >
                                                                <label class="control-label label-sm" for="Sexo">Sexo:</label>
                                                                <select class="form-control input-sm" id="Sexo" name="Sexo" >
                                                                    <option value="">[Selecione]</option>
                                                                    <option value="F">Feminino</option>
                                                                    <option value="M">Masculino</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group required col-xs-6 col-sm-6 col-md-3 col-lg-2" >
                                                                <label class="control-label label-sm" for="DataNascimento">Nascimento:</label>
                                                                <input class="form-control input-sm" type="text" maxlength="14" value="" id="DataNascimento" name="DataNascimento" placeholder="__/__/____" />
                                                            </div>                                                            
                                                            <div class="form-group col-xs-6 col-sm-6 col-md-3 col-lg-2" >
                                                                <label class="control-label label-sm">Matrícula: </label>
                                                                <input class="form-control input-sm text-right" type="text" maxlength="20" value="" id="Matricula" name="Matricula" readonly="readonly" style=""/>
                                                            </div>
                                                            <div class="form-group col-xs-6 col-sm-6 col-md-3 col-lg-3 ">
                                                                <label class="control-label label-sm" for="NomeStatus">Status:</label>
                                                                <input class="form-control input-sm" type="text" maxlength="50" value="" id="NomeStatus" name="NomeStatus" readonly="readonly" style="max-width:200px;" />
                                                            </div>
                                                            <div class="form-group required col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <label class="control-label label-sm" for="Nome">Nome Completo:</label>
                                                                <input class="form-control input-sm" type="text" maxlength="50" value="" id="Nome" name="Nome"  placeholder="nome"  />
                                                            </div>
                                                            <div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3" >
                                                                <label class="control-label label-sm" for="Apelido">Nome Abreviado: </label>
                                                                <input class="form-control input-sm" type="text" maxlength="50" value="" id="Apelido" name="Apelido" placeholder="apelido" />
                                                            </div>
                                                            <div class="form-group required col-xs-12 col-sm-12 col-md-6 col-lg-6" >
                                                                <label class="control-label label-sm" for="Mae">Nome da Mãe: </label>
                                                                <input class="form-control input-sm" type="text" maxlength="50" value="" id="Mae" name="Mae" placeholder="nome da mãe"  />
                                                            </div>
                                                            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6" >
                                                                <label class="control-label label-sm" for="Pai">Nome Pai: </label>
                                                                <input class="form-control input-sm" type="text" maxlength="50" value="" id="Pai" name="Pai" placeholder="nome do pai"  />
                                                            </div>

                                                            <div class="form-group  col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                                                <label class="control-label label-sm" for="IdEstadoCivil">Estado Civil:</label>
                                                                <select class="form-control input-sm" id="IdEstadoCivil" name="IdEstadoCivil" data-toggle="popover" data-title="IdEstadoCivil" data-content="Favor informar o Estado Civil.">
                                                                    <option value="">[Selecione]</option>
                                                                    <option value="1">Solteiro(a)</option>
                                                                    <option value="2">Casado(a)</option>
                                                                    <option value="3">Companheiro(a)</option>
                                                                    <option value="4">Separado(a)</option>
                                                                    <option value="5">Divorciado(a)</option>
                                                                    <option value="6">Viúvo(a)</option>
                                                                </select>
                                                            </div>                                                            
                                                            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6" >
                                                                <label class="control-label label-sm" for="Conjuge">Conjuge: </label>
                                                                <input class="form-control input-sm" type="text" maxlength="50" value="" id="Conjuge" name="Conjuge" placeholder="Conjuge"  />
                                                            </div>
                                                            
                                                            <div class="form-group  col-xs-6 col-sm-3 col-md-3 col-lg-2">
                                                                <label class="control-label label-sm" for="TipoSanguineo">T.Sanguíneo:</label>
                                                                <select class="form-control input-sm" id="TipoSanguineo" name="TipoSanguineo" data-toggle="popover" data-title="Tipo Sanguíneo" data-content="Favor informar o tipo sanguíneo da pessoa.">
                                                                    <option value="">[Selecione]</option>
                                                                    <option value="A+">A+</option>
                                                                    <option value="A-">A-</option>
                                                                    <option value="B+">B+</option>
                                                                    <option value="B-">B-</option>
                                                                    <option value="AB+">AB+</option>
                                                                    <option value="AB-">AB-</option>
                                                                    <option value="O+">O+</option>
                                                                    <option value="O-">O-</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group  col-xs-6 col-sm-3 col-md-3 col-lg-2">
                                                                <label class="control-label label-sm" for="Peso">Peso:</label>
                                                                <div class=" input-group" >
                                                                    <input class="form-control input-sm text-right" type="text" maxlength="3" value="" id="Peso" name="Peso" placeholder="peso"  />
                                                                    <span class="input-group-addon input-sm">kg</span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group  col-xs-6 col-sm-3 col-md-3 col-lg-2">
                                                                <label class="control-label label-sm" for="Altura">Altura:</label>
                                                                <div class=" input-group" >
                                                                    <input class="form-control input-sm  text-right" type="text" maxlength="3" value="" id="Altura" name="Altura" placeholder="altura"  />
                                                                    <span class="input-group-addon input-sm">cm</span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group  col-xs-6 col-sm-6 col-md-2 col-lg-2" id="box-Calcado">
                                                                <label class="control-label label-sm" for="Calcado">Calcado:</label>
                                                                <div class=" input-group" >
                                                                    <input class="form-control input-sm text-right" type="text" maxlength="2" value="" id="Calcado" name="Calcado" placeholder="__"  />
                                                                    <span class="input-group-addon input-sm">#</span>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div role="tabpanel" class="tab-pane" id="tabDoc">
                                                    <div class="row clearfix mt-10">
                                                        <div class="form-group required col-xs-12 col-sm-4 col-md-4 col-lg-4" id="box-IdNacionalidade">
                                                            <label class="control-label label-sm" for="IdNacionalidade">Nacionalidade:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="NomeNacionalidade" name="NomeNacionalidade" readonly="readonly" style="display: none;" />
                                                            <select class="form-control input-sm" id="IdNacionalidade" name="IdNacionalidade" onchange="Nacionalidade_onchange(this.value);">
                                                                    <option value="">[Nenhum]</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group required col-xs-12 col-sm-4 col-md-4 col-lg-4" id="box-UFNaturalidade">
                                                            <label class="control-label label-sm" for="UFNaturalidade">Naturalidade (UF):</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="NomeNaturalidade" name="NomeNaturalidade" readonly="readonly" style="display: none;" />
                                                            <select class="form-control input-sm" id="UFNaturalidade" name="UFNaturalidade" >
                                                                    <option value="">[Nenhum]</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group required col-xs-12 col-sm-4 col-md-4 col-lg-4" >
                                                            <label class="control-label label-sm" for="Naturalidade">Naturalidade (Cidade):</label>
                                                            <input class="form-control input-sm" type="text" maxlength="30" value="" id="Naturalidade" name="Naturalidade" placeholder="natural da cidade"  />
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix">
                                                        <div class="form-group col-xs-4 col-sm-3 col-md-2 col-lg-2" id="boxRGNumero" >
                                                            <label class="control-label label-sm" for="RGNumero">RG:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="20" value="" id="RGNumero" name="RGNumero" placeholder="nº do RG"  />
                                                        </div>
                                                        <div class="form-group col-xs-4 col-sm-3 col-md-2 col-lg-2" id="boxRGOrgao" >
                                                            <label class="control-label label-sm" for="RGOrgao">Orgão do RG:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="20" value="" id="RGOrgao" name="RGOrgao" placeholder="orgão do RG "  />
                                                        </div>
                                                        <div class="form-group col-xs-4 col-sm-3 col-md-2 col-lg-2" >
                                                            <label class="control-label label-sm" for="RGData">Emissão do RG:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="20" value="" id="RGData" name="RGData" placeholder="__/__/____"  />
                                                        </div>
                                                        <div class="form-group col-xs-6 col-sm-6 col-md-3 col-lg-3" id="boxPassaporte">
                                                            <label class="control-label label-sm" for="PassNumero">Passaporte:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="20" value="" id="PassNumero" name="PassNumero" placeholder="nº do Passaporte"  />
                                                        </div>
                                                        <div class="form-group col-xs-6 col-sm-6 col-md-3 col-lg-3" >
                                                            <label class="control-label label-sm" for="PassValidade">Validade do Passaporte:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="14" value="" id="PassValidade" name="PassValidade" placeholder="__/__/____" />
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix">
                                                        <div class="form-group col-xs-12 col-sm-4 col-md-2 col-lg-2" >
                                                            <label class="control-label label-sm" for="CRNumero">Certif. de Reservista:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="20" value="" id="CRNumero" name="CRNumero" placeholder="nº do Certificado de Reservista"  />
                                                        </div>
                                                        <div class="form-group col-xs-6 col-sm-4 col-md-2 col-lg-2" >
                                                            <label class="control-label label-sm" for="CROrgao">Orgão do CR:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="20" value="" id="CROrgao" name="CROrgao" placeholder="orgão do CR "  />
                                                        </div>
                                                        <div class="form-group col-xs-6 col-sm-4 col-md-2 col-lg-2" >
                                                            <label class="control-label label-sm" for="CRData">Emissão do CR:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="20" value="" id="CRData" name="CRData" placeholder="__/__/____" />
                                                        </div>
                                                        <div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3" >
                                                            <label class="control-label label-sm" for="PIS">PIS: </label>
                                                            <input class="form-control input-sm" type="text" maxlength="14" value="" id="PIS" name="PIS" placeholder="nº do PIS"  />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div role="tabpanel" class="tab-pane" id="tabContato">
                                                    <div class="row clearfix mt-10">
                                                        <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6" >
                                                            <label class="control-label label-sm" for="Email">Email:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="Email" name="Email" onchange="conferirEmail(13);" placeholder="e-mail" data-toggle="popover" data-title="Email" data-content="Favor informar seu email de contato, este email será utilizado para acessar o sistema e receber mensagens. (Exemplo: seunome@seudominio.com.br)" />
                                                            <span id="lblEmailError" class="label label-danger" style="display: none;"></span>
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix mt-10">
                                                        <div class="form-group col-xs-6 col-sm-4 col-md-2 col-lg-2" >
                                                            <label class="control-label label-sm" for="Telefone">Telefone</label>
                                                            <input class="form-control input-sm" type="text" maxlength="30" value="" id="Telefone" name="Telefone" placeholder="telefone"   />
                                                        </div>
                                                        <div class="form-group col-xs-6 col-sm-4 col-md-2 col-lg-2" >
                                                            <label class="control-label label-sm" for="Telefone">Celular</label>
                                                            <input class="form-control input-sm" type="text" maxlength="30" value="" id="Celular" name="Celular" placeholder="celular"  />
                                                        </div>
                                                        <div class="form-group col-xs-1 col-sm-4 col-md-2 col-lg-2" >
                                                            <label class="control-label label-sm" for="Outro">Outro Contato</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="Outro" name="Outro" placeholder="outro contato"  />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div role="tabpanel" class="tab-pane" id="tabEndRes">
                                                    <div class="row clearfix mt-10">
                                                        <div class="form-group col-sm-8 col-md-4 col-lg-4" id="boxLogradouro1">
                                                            <label class="control-label label-sm" for="Logradouro1">Logradouro: </label>
                                                            <input class="form-control input-sm" type="text" maxlength="200" value="" id="Logradouro1" name="Logradouro1" placeholder="logradouro"  />
                                                        </div>
                                                        <div class="form-group col-sm-4 col-md-2 col-lg-2" id="boxNumero1">
                                                            <label class="control-label label-sm" for="Numero1">Numero:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="10" value="" id="Numero1" name="Numero1" placeholder="numero"  />
                                                        </div>
                                                        <div class="form-group col-sm-6 col-md-3 col-lg-3" id="boxComplemento1">
                                                            <label class="control-label label-sm" for="Complemento1">Complemento:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="30" value="" id="Complemento1" name="Complemento1" placeholder="complemento"  />
                                                        </div>
                                                        <div class="form-group col-sm-6 col-md-3 col-lg-3" id="boxBairro1">
                                                            <label class="control-label label-sm" for="Bairro1">Bairro:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="Bairro1" name="Bairro1" placeholder="bairro" />
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix">
                                                        <div class="form-group col-sm-6 col-md-3 col-lg-3" id="boxCidade1">
                                                            <label class="control-label label-sm" for="Cidade1">Cidade:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="Cidade1" name="Cidade1"  placeholder="cidade ou município" />
                                                        </div>
                                                        <div class="form-group col-sm-6 col-md-3 col-lg-3" id="boxCEP1">
                                                            <label class="control-label label-sm" for="CEP1">CEP:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="10" value="" id="CEP1" name="CEP1" placeholder="_____-__"  style="width:100px;" />
                                                        </div>
                                                        <div class="form-group required col-sm-6 col-md-3 col-lg-3"  id="boxIdPais1">
                                                            <label class="control-label label-sm" for="IdPais1">País:</label>
                                                            <select class="form-control input-sm" id="IdPais1" name="IdPais1" onchange="carregarComboEstado('UF1', this.value, 0, 13);" >
                                                                    <option value="">[Nenhum]</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group required col-sm-6 col-md-3 col-lg-3"  id="boxUF1">
                                                            <label class="control-label label-sm" for="UF1">Estado/Distristo:</label>
                                                            <select class="form-control input-sm" id="UF1" name="UF1" >
                                                                    <option value="">[Nenhum]</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div role="tabpanel" class="tab-pane" id="tabEndCom">
                                                    <div class="row clearfix mt-10">
                                                        <div class="form-group col-sm-8 col-md-4 col-lg-4" >
                                                            <label class="control-label label-sm" for="Endereco2">Logradouro: </label>
                                                            <input class="form-control input-sm" type="text" maxlength="200" value="" id="Logradouro2" name="Logradouro2" placeholder="logradouro"  />
                                                        </div>
                                                        <div class="form-group col-sm-4 col-md-2 col-lg-2" >
                                                            <label class="control-label label-sm" for="Numero2">Numero:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="10" value="" id="Numero2" name="Numero2" placeholder="numero"  />
                                                        </div>
                                                        <div class="form-group col-sm-6 col-md-3 col-lg-3" >
                                                            <label class="control-label label-sm" for="Complemento2">Complemento:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="30" value="" id="Complemento2" name="Complemento2" placeholder="complemento"  />
                                                        </div>
                                                        <div class="form-group col-sm-6 col-md-3 col-lg-3" >
                                                            <label class="control-label label-sm" for="Bairro2">Bairro:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="Bairro2" name="Bairro2" placeholder="bairro" />
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix">
                                                        <div class="form-group col-sm-6 col-md-3 col-lg-3" >
                                                            <label class="control-label label-sm" for="Cidade2">Cidade:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="Cidade2" name="Cidade2"  placeholder="cidade ou município" />
                                                        </div>
                                                        <div class="form-group col-sm-6 col-md-3 col-lg-3" >
                                                            <label class="control-label label-sm" for="CEP2">CEP:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="10" value="" id="CEP2" name="CEP2" placeholder="_____-___"  style="width:100px;" />
                                                        </div>
                                                        <div class="form-group col-sm-6 col-md-3 col-lg-3" >
                                                            <label class="control-label label-sm" for="IdPais2">País:</label>
                                                            <select class="form-control input-sm" id="IdPais2" name="IdPais2" onchange="carregarComboEstado('UF2', this.value, 0, 13);" >
                                                                    <option value="">[Nenhum]</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-sm-6 col-md-3 col-lg-3" >
                                                            <label class="control-label label-sm" for="UF2">Estado/Distristo:</label>
                                                            <select class="form-control input-sm" id="UF2" name="UF2" >
                                                                    <option value="">[Nenhum]</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div role="tabpanel" class="tab-pane" id="tabOutros">
                                                    <div class="row clearfix mt-10">
                                                        <div class="form-group col-xs-4 col-sm-4 col-md-2 col-lg-2" >
                                                            <label class="control-label label-sm" for="BancoNumero">Nº doBanco:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="3" value="" id="BancoNumero" name="BancoNumero" placeholder="nº do banco"  />
                                                        </div>
                                                        <div class="form-group col-xs-4 col-sm-4 col-md-2 col-lg-2" >
                                                            <label class="control-label label-sm" for="BancoAgencia">Agencia:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="6" value="" id="BancoAgencia" name="BancoAgencia" placeholder="nº da agencia"  />
                                                        </div>
                                                        <div class="form-group col-xs-4 col-sm-4 col-md-2 col-lg-2" >
                                                            <label class="control-label label-sm" for="BancoConta">C/C:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="20" value="" id="BancoConta" name="BancoConta" placeholder="nº da c/c"  />
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix">
                                                        <div class="form-group col-sm-6 col-md-3 col-lg-3" >
                                                            <label class="control-label label-sm" for="IdEscolaridade">Escolaridade:</label>
                                                            <select class="form-control input-sm" id="IdEscolaridade" name="IdEscolaridade" >
                                                                <option value="0">Não Informado</option>
                                                                <option value="1">Ens. Fundamental</option>
                                                                <option value="2">Ensino Médio</option>
                                                                <option value="3">Ensino Superior</option>
                                                                <option value="4">Pós Graduação</option>
                                                                <option value="5">Doutorado</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-sm-6 col-md-3 col-lg-3" >
                                                            <label class="control-label label-sm" for="Instituicao">Instituição de Ensino:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="Instituicao" name="Instituicao" placeholder="instituição de ensino"  />
                                                        </div>
                                                        <div class="form-group col-sm-6 col-md-3 col-lg-3" >
                                                            <label class="control-label label-sm" for="Idioma">Conhecimento de Idiomas:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="Idioma" name="Idioma" placeholder="idiomas"  />
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix">
                                                        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                                            <label class="control-label label-sm" for="Observacao">Observações:</label>
                                                            <textarea class="form-control" rows="2" id="Observacao" name="Observacao" maxlength="1000" ></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix mt-10">
                                                        <div class="form-group col-xs-6 col-sm-6 col-md-3 col-lg-2  ">
                                                            <label class="control-label label-sm" for="DataCadastro">Data Cadastro:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="DataCadastro" name="DataCadastro" readonly="readonly" />
                                                        </div>
                                                        <div class="form-group col-xs-6 col-sm-6 col-md-3 col-lg-3  ">
                                                            <label class="control-label label-sm" for="NomeUsuarioAcao">Usuário do Cadastro:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="NomeUsuarioCadastro" name="NomeUsuarioCadastro" readonly="readonly" />
                                                        </div>
                                                        <div class="form-group col-xs-2 col-sm-1 col-md-1 col-lg-1  ">
                                                            <label class="control-label label-sm" for="Revisao">Rev.:</label>
                                                            <input class="form-control input-sm text-right" type="text" maxlength="3" value="" id="Revisao" name="Revisao" readonly="readonly" />
                                                        </div>                                                        
                                                        <div class="form-group col-xs-6 col-sm-6 col-md-3 col-lg-2  ">
                                                            <label class="control-label label-sm" for="DataAcao">Última Atualização:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="DataAcao" name="DataAcao" readonly="readonly" />
                                                        </div>
                                                        <div class="form-group col-xs-6 col-sm-6 col-md-3 col-lg-3  ">
                                                            <label class="control-label label-sm" for="NomeUsuarioAcao">Usuário da Atualização:</label>
                                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="NomeUsuarioAcao" name="NomeUsuarioAcao" readonly="readonly" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix mt-10 mb-14">
                                            <div class="col-xs-12 col-sm-2 col-md-3 col-lg-3">
                                                <div id="boxCritica" class="clearfix alert-sm"></div><!-- MENSAGEM PEQUENA //-->
                                            </div>
                                            <div class="col-xs-12 col-sm-10 col-md-9 col-lg-9 text-right" id="boxToolbarEdicao">
                                                <button type="button" id="bt_cancelar" class="btn btn-default btn-espace" title="Cancelar Operação" onclick="cancelar();"><span class="glyphicon glyphicon-stop"></span> Cancelar</button>
                                                <button type="button"  id="bt_editar"   class="btn btn-warning btn-espace" title="Editar Registro"   onclick="editar();"  disabled="disabled" ><span class="glyphicon glyphicon-pencil"></span> Editar</button>
                                                <button type="button"  id="bt_excluir"  class="btn btn-danger btn-espace"  title="Excluir Registro"  onclick="excluir();" disabled="disabled" ><span class="glyphicon glyphicon-remove" ></span> Excluir</button>
                                                <button type="button"  id="bt_gravar"   class="btn btn-success btn-espace" title="Gravar Registro"   onclick="gravar();"  disabled="disabled" ><span class="glyphicon glyphicon-floppy-disk"></span> Gravar</button>
                                                <button type="button"  id="bt_aprovar" class="btn btn-primary btn-espace bt_aprovar" title="Aprovar cadastro profissional" onclick="aprovar();" disabled="disabled"><span class="glyphicon glyphicon-ok"></span> Aprovar</button>
                                            </div>
                                        </div>
                                    </form>    
                                    <div class="separacao_linha-sm"><span></span></div>
                                    <div class="row clearfix mb-14">
                                        <div class="form-group-sn col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="panel panel-default hidden">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><span class="fa fa-file-pdf-o red"></span> Documentos</h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div id="boxMensagemDoc" class="clearfix alert-sm"></div><!-- MENSAGEM PEQUENA //-->
                                                    
                                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                        <table id="tabListagemDocumento" class="table table-striped table-bordered table-hover table-condensed">
                                                            <thead>
                                                                <tr class="">
                                                                    <th><b>&nbsp;</b></th>
                                                                    <th><b>&nbsp;</b></th>
                                                                    <th style="width: 50%;"><b>Documento</b></th>
                                                                    <th><b>Data</b></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                        
                                                        <div class="row clearfix mb-14" id="boxToolbarDocumento">
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                <button type="button"  id="bt_add_documento" class="btn btn-default btn-sm" title="Incluir um novo Documento" onclick="abrirFormDocumento();" disabled="disabled"><span class="glyphicon glyphicon-picture blue"></span> Adicionar Documento</button>
                                                            </div>
                                                        </div>
                                                        <div class="row clearfix mb-14" id="boxFormularioDocumento" style="display: none;">
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">
                                                                        <h3 class="panel-title"> Adicionar Documento</h3>
                                                                    </div>
                                                                    <div class="panel-body">
                                                                        <form id="formDocumento" name="formDocumento" action="action.php" onSubmit="return false;" >
                                                                            <input type="hidden" id="IdDocumento" name="IdDocumento" value="" />
                                                                            <input type="hidden" id="Id2" name="Id" value="" />
                                                                            <input type="hidden" id="IdPessoa2" name="IdPessoa" value="" />
                                                                            <input type="hidden" id="controle2" name="controle" value="" />
                                                                            <input type="hidden" id="acao2" name="acao" value="" />
                                                                        <div class="row clearfix mb-6">
                                                                            <div class="form-group-sn col-lg-12" >
                                                                                <label class="control-label label-sm" for="IdTipoDocumento">Tipo de Documento: </label>
                                                                                <select class="form-control input-sm" id="IdTipoDocumento" name="IdTipoDocumento" >
                                                                                    <option value="">[Selecione]</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row clearfix mb-6">
                                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
                                                                                <label class="control-label label-sm" for="Nome">Arquivo:</label>
                                                                                <input class="input" type="file" value="" id="Arquivo" name="Arquivo" placeholder="Selecionar o arquivo..." />
                                                                            </div>
                                                                        </div>
                                                                        <div class="row clearfix">
                                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right linha-top">
                                                                                <a id="bt_cancelar_turma" class="btn btn-default  btn-sm btn-espace" onclick="cancelarDocumento();"><span class="glyphicon glyphicon-stop"></span> Cancelar</a>
                                                                                <a id="bt_gravar_turma" class="btn btn-success  btn-sm btn-espace" onclick="gravarDocumento();"><span class="glyphicon glyphicon-save"></span> Enviar Arquivo</a>
                                                                            </div>
                                                                        </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="boxCriticaDoc" class="clearfix alert-sm"></div><!-- MENSAGEM PEQUENA //-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-sn col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><span class="fa fa-tag blue"></span> &nbsp;Registros Profissionais</h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div id="boxMensagemReg" class="clearfix alert-sm"></div><!-- MENSAGEM PEQUENA //-->
                                                    
                                                    <div class="col-xs-12 col-sm-9 col-md-10 col-lg-10">
                                                        <table id="tabListagemRegistro" class="table table-striped table-bordered table-hover table-condensed">
                                                            <thead>
                                                                <tr class="">
                                                                    <th style="width: 5%;"><b>&nbsp;</b></th>
                                                                    <th style="width: 5%;"><b>&nbsp;</b></th>
                                                                    <th style="width: 20%;"><b>Empresa</b></th>
                                                                    <th style="width: 18%;"><b>Cargo</b></th>
                                                                    <th style="width: 15%;"><b>Vínculo</b></th>
                                                                    <th style="width: 15%;"><b>Ult. Atualização</b></th>
                                                                    <th><b>Status</b></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-3 col-md-2 col-lg-2">
                                                        <div class="row clearfix mb-14" id="boxToolbarRegistro">
                                                            <button type="button" id="bt_add_registro" class="btn btn-default btn-sm" title="Incluir um novo Documento" onclick="abrirFormRegistro();" disabled="disabled"><span class="glyphicon glyphicon-tag blue"></span> Adicionar novo perfil</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="row clearfix mb-14" id="boxFormularioRegistro" style="display: none;">
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">
                                                                        <h3 class="panel-title"> Novo Perfil</h3>
                                                                    </div>
                                                                    <div class="panel-body">
                                                                        <form id="formRegistro" name="formRegistro" action="action.php" onSubmit="return false;" >
                                                                            <input type="hidden" id="controle3" name="controle" value="" />
                                                                            <input type="hidden" id="acao3" name="acao" value="" />
                                                                            <input type="hidden" id="Id3" name="Id" value="" />
                                                                            <input type="hidden" id="IdPessoa3" name="IdPessoa" value="" />
                                                                            <input type="hidden" id="AnosRegistro" name="AnosRegistro" value="" />
                                                                            <input type="hidden" id="DiasLiberacao" name="DiasLiberacao" value="" />
                                                                            
                                                                            <input type="hidden" id="IdTarifa" name="IdTarifa" value="" />
                                                                            <input type="hidden" id="ValorTaxa" name="ValorTaxa" value="" />
                                                                            <input type="hidden" id="ValorAno" name="ValorAno" value="" />
                                                                            <input type="hidden" id="NomeTarifa" name="NomeTarifa" />
                                                                            <input type="hidden" id="IdVinculo" name="IdVinculo" />
                                                                            
                                                                        <div class="row clearfix">
                                                                            <div class="form-group required col-xs-12 col-sm-4 col-md-4 col-lg-4"  id="box-IdEmpresa3">
                                                                                <label class="control-label label-sm" id="lblIdEmpresa3">Empresa / Associação:</label>
                                                                                <input class="form-control input-sm" type="text" maxlength="50" value="" id="NomeEmpresa3" name="NomeEmpresa" readonly="readonly" style="display: none;" />
                                                                                <select class="form-control input-sm" id="IdEmpresa3" name="IdEmpresa" onchange="IdEmpresa3_onchange(this.value, 13);">
                                                                                    <option value="">[Selecione]</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group required col-xs-12 col-sm-4 col-md-4 col-lg-4" >
                                                                                <label class="control-label label-sm" for="IdProfissao">Cargo:</label>
                                                                                <select class="form-control input-sm" id="IdProfissao" name="IdProfissao" onchange="IdProfissao_onchange(this.value);">
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group required col-xs-12 col-sm-4 col-md-4 col-lg-4" id="box-IdProfissaoNivel" style="display:none;">
                                                                                <label class="control-label label-sm" for="IdProfissaoNivel" id="lblIdProfissaoNivel">Nível do Cargo:</label>
                                                                                <select class="form-control input-sm" id="IdProfissaoNivel" name="IdProfissaoNivel" onchange="IdProfissaoNivel_onchange(this.value);">
                                                                                    <option value="">[Selecione]</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row clearfix">
                                                                            <div class="form-group required col-xs-6 col-sm-3 col-md-2 col-lg-2" >
                                                                                <label class="control-label label-sm" for="DataInicial">Data Admissão:</label>
                                                                                <input class="form-control input-sm" type="text" maxlength="14" value="" id="DataInicial" name="DataInicial"  onchange="calcularDataFinal();"/>
                                                                            </div>
                                                                            <div class="form-group col-xs-6 col-sm-3 col-md-2 col-lg-2" >
                                                                                <label class="control-label label-sm" for="DataFinal">Data Desligamento:</label>
                                                                                <input class="form-control input-sm" type="text" maxlength="14" value="" id="DataFinal" name="DataFinal" />
                                                                            </div>
                                                                            <div class="form-group  col-xs-4 col-sm-3 col-md-3 col-lg-3" id="box-Setor" >
                                                                                <label class="control-label label-sm" for="IdSetor">Setor:</label>
                                                                                <select class="form-control input-sm" id="IdSetor" name="IdSetor">
                                                                                    <option value="">[Selecione]</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-4"  id="box-Contrato">
                                                                                <label class="control-label label-sm" id="lblIdContrato3">Contrato:</label>
                                                                                <input class="form-control input-sm" type="text" maxlength="50" value="" id="NomeContrato" name="NomeContrato" readonly="readonly" style="display: none;" />
                                                                                <select class="form-control input-sm" id="IdContrato" name="IdContrato">
                                                                                    <option value="">[Selecione]</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row clearfix " id="box-Observacao2">
                                                                            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                                                                <label class="control-label label-sm" for="Observacao">Observações:</label>
                                                                                <textarea class="form-control input-sm" rows="1" id="Observacao3" name="Observacao" maxlength="255" ></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row clearfix">
                                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right linha-top">
                                                                                <button type="button" id="bt_cancelar_turma" class="btn btn-default  btn-sm btn-espace" onclick="cancelarRegistro();"><span class="glyphicon glyphicon-stop"></span> Cancelar</button>
                                                                                <button type="button" id="bt_gravar_turma" class="btn btn-success  btn-sm btn-espace" onclick="gravarRegistro();"><span class="glyphicon glyphicon-floppy-disk"></span> Gravar Perfil</button>
                                                                            </div>
                                                                        </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix" id="boxListagem">
                        <div class="col-md-12 column">
                            <div class="panel panel-default">
                                <div class="panel-heading"><span class="fa fa-filter"></span> Filtros da Consulta</div>
                                <div class="panel-body">
                                <!-- Listagem - INICIO -->
                                    <div class="row clearfix">
                                        <div class="col-md-12 column">
                                            
                                            <form id="formPesquisa" name="formPesquisa" action="action.php" onSubmit="return false;" class="form-horizontal" >
                                                <input type="hidden" id="controle0" name="controle" value="" />
                                                <input type="hidden" id="acao0" name="acao" value="filtrar" />
                                                <input type="hidden" id="filtroIdTipo" name="IdTipo" value="" />
                                                <input type="hidden" id="filtroIdPessoa" name="IdPessoa" value="" />
                                                
                                            <div class="row clearfix">
                                                <div class="form-group-sm col-xs-12 col-sm-6 col-md-4 col-lg-4" id="boxFiltroIdEmpresa">
                                                    <label class="control-label label-sm" for="filtroIdEmpresa" id="lblFiltroIdEmpresa">Empresa:</label>
                                                    <select class="form-control input-sm" id="filtroIdEmpresa" name="IdEmpresa" onchange="filtroIdEmpresa_onchange(this.value, 13);">
                                                        <option value="">[Todas]</option>
                                                    </select>
                                                </div>
                                                <div class="form-group-sm col-xs-12 col-sm-6 col-md-4 col-lg-3" id="boxFiltroIdContrato" style="">
                                                    <label class="control-label label-sm" for="filtroIdContrato" id="lblFiltroIdContrato">Contrato:</label>
                                                    <select class="form-control input-sm" id="filtroIdContrato" name="IdContrato" >
                                                        <option value="">[Todas]</option>
                                                    </select>
                                                </div>
                                                <div class="form-group-sm col-xs-6 col-sm-6 col-md-2 col-lg-3" >
                                                    <label class="control-label label-sm" for="filtroIdStatus">Status:</label>
                                                    <select class="form-control input-sm" id="filtroIdStatus" name="IdStatus"  >
                                                        <option value="">[Todos]</option>
                                                        <option value="1">Pendente</option>
                                                        <option value="9">Cancelado</option>
                                                        <option value="10" selected="selected">Registrado</option>
                                                    </select>
                                                </div>
                                                <!--
                                                <div class="form-group-sm col-xs-6 col-sm-6 col-md-2 col-lg-1" >
                                                    <label class="control-label label-sm" for="filtroAtivo">Ativo:</label>
                                                    <select class="form-control input-sm" id="filtroAtivo" name="Ativo"  >
                                                        <option value="">[Todos]</option>
                                                        <option value="1" selected="selected">Sim</option>
                                                        <option value="0">Não</option>
                                                    </select>
                                                </div>
                                                -->
                                            </div>
                                            <div class="row clearfix">
                                                <div class="form-group-sm col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                    <label for="filtroNome" class="control-label label-sm">Nome:</label>
                                                    <input class="form-control input-sm" type="text" maxlength="50" value="" id="filtroNome" name="Nome" />
                                                </div>
                                                <div class="form-group-sm col-xs-12 col-sm-3 col-md-2 col-lg-2">
                                                    <label for="filtroNome" class="control-label label-sm">CPF:</label>
                                                    <input class="form-control input-sm" type="text" maxlength="50" value="" id="filtroCPF" name="CPF" placeholder="___.___.___-__" />
                                                </div>
                                                <div class="form-group-sm col-xs-6 col-sm-2 col-md-2 col-lg-2" >
                                                    <label class="control-label label-sm" for="DataNascimento">Nascimento:</label>
                                                    <input class="form-control input-sm" type="text" maxlength="14" value="" id="filtroDataNascimento" name="DataNascimento"  style="max-width:120px;" placeholder="__/__/____" />
                                                </div>
                                                <div class="form-group-sm col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                                    <label for="filtroNome" class="control-label label-sm">Matrícula:</label>
                                                    <input class="form-control input-sm" type="text" maxlength="6" value="" id="filtroMatricula" name="Matricula" />
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="form-group-sm col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" >
                                                    <button type="button" class="btn btn-default" id="bt_pesquisar" onclick="carregarLista(13);" disabled="disabled" ><span class="fa fa-search blue"></span> Consultar</button>
                                                    <!-- <button type="button" class="btn btn-default " id="bt_relatorio" onclick="carregarRelatorio('grafico', 13);" disabled="disabled" ><span class="fa fa-signal blue"></span> Visualziar Gráfico</button> -->
                                                    <button type="button" class="btn btn-default" id="bt_relatorio_pdf" onclick="carregarRelatorio('pdf', 13);" disabled="disabled" ><span class="fa fa-file-pdf-o red"></span> Visualizar PDF</button>
                                                    <button type="button" class="btn btn-default" id="bt_relatorio_excel" onclick="carregarRelatorio('excel', 13);" disabled="disabled" ><span class="fa fa-table green"></span> Visualizar Planilha</button>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="separacao_linha-sm"><span></span></div>
                                    <div class="row clearfix">
                                        <div class="col-lg-12 column">
                                            <table id="tabListagem" class="table table-striped table-bordered table-hover table-condensed">
                                                <thead>
                                                    <tr class="">
                                                        <th><b>&nbsp;</b></th>
                                                        <th><b>Matrícula&nbsp;</b></th>
                                                        <th><b>Empresa</b></th>
                                                        <th><b>Nome</b></th>
                                                        <th><b>Nascimento</b></th>
                                                        <th><b>Status</b></th>
                                                        <th><b>Ult. Atualização</b></th>
                                                        <th><b>&nbsp;</b></th>
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
    
