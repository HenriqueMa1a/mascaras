<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once "admin/includes/global.joomla.php";
require_once "admin/includes/private.php";
require_once "admin/includes/format.php";

$TXT_BUSCA = "";
$PAG_NUMERO = 1;

getDadosModulo ();

// IsOnLine();

getDadosUsuario ();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
include_once ('tags.php');
include_once ('estilos.php');
include_once ('javascripts.php');
include_once ('bootstrap.php');

include_once ('jquery.php');
if (file_exists ( 'modulos/' . $MOD_CLASSE . '.js.php' ))
	include_once ('modulos/' . $MOD_CLASSE . '.js.php');
?> 
<link type='text/css' href='../admin/assets/css/bootstrap-mcc.css?dh=2016021611' rel='stylesheet' />
<link type='text/css' href='../admin/assets/css/bootstrap-mcc-datatables.css?dh=2016021611' rel='stylesheet' />

</head>
<body style="width:100%;">
<?php // include("cabecalho.php"); ?>
<div id="content">
		<!-- MODULO CONTEUDO - INICIO *** //-->

                        <div class="panel panel-info mt-20">
                            <div class="panel-heading"><h2 class="panel-title"><span class="glyphicon glyphicon-user" ></span> Minha Inscrição</h2></div>
                            <div class="panel-body">
                                <form id="formCadastro" name="formCadastro" action="action.php" method="post" onsubmit="return false;" >
                                    <input type="hidden" id="controle" name="controle" value="Usuario" />
                                    <input type="hidden" id="acao" name="acao" value="editar" />
                                    <input type="hidden" id="Id" name="Id" value="" />
                                    <input type="hidden" id="IdUsuario" name="IdUsuario" value="" />
                                    <input type="hidden" id="IdTipo" name="IdTipo" value="" />
                                    <input type="hidden" id="IdStatus" name="IdStatus" value="" />
                                    <input type="hidden" id="IdEmpresa" name="IdEmpresa" value="" />
                                    <input type="hidden" id="IdFormulario" name="IdFormulario" value="" />
                                    
                                    <div class="separacao_campos"><span>Dados Pessoais</span></div>
                                    <div class="row clearfix">
                                        <div class="form-group col-xs-4 col-sm-2 col-md-2 col-lg-2"  id="boxRegistro">
                                            <label class="control-label label-sm">Inscrição: </label>
                                            <input class="form-control input-sm text-right" type="text" value="0" id="Matricula" name="Matricula" readonly="readonly" />
                                        </div>
                                        <div class="form-group col-xs-6 col-sm-6 col-md-3 col-lg-3  ">
                                            <label class="control-label label-sm" for="DataCadastro">Data Inscrição:</label>
                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="DataCadastro" name="DataCadastro" readonly="readonly" />
                                        </div>
                                        
                                    </div>
                                    <div class="row clearfix">
                                        <div class="form-group required col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <label class="control-label label-sm" for="Nome">Nome Completo:</label>
                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="Nome" name="Nome"  placeholder="nome" readonly="readonly" />
                                        </div>
                                        <div class="form-group col-xs-12 col-sm-3 col-md-3 col-lg-3" id="boxApelido" >
                                            <label class="control-label label-sm" for="Apelido">Nome para Crachá: </label>
                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="Apelido" name="Apelido" readonly="readonly" />
                                        </div>
                                        <div class="form-group col-xs-6 col-sm-3 col-md-3 col-lg-3" >
                                            <label class="control-label label-sm" for="DataNascimento">Nascimento:</label>
                                            <input class="form-control input-sm" type="text" maxlength="14" value="" id="DataNascimento" name="DataNascimento" readonly="readonly" />
                                        </div>
                                    </div>
                                    <div class="row clearfix mb-14">
                                        <div class="form-group required col-xs-12 col-sm-6 col-md-6 col-lg-6" >
                                            <label class="control-label label-sm" for="Email">Email (login):</label>
                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="Email" name="Email" onchange="conferirEmail(13);" placeholder="e-mail" data-toggle="popover" data-title="Email" data-content="Favor informar seu email de contato, este email será utilizado para acessar o sistema e receber mensagens. (Exemplo: seunome@seudominio.com.br)"  readonly="readonly" />
                                            <span id="lblEmailError" class="label label-danger" style="display: none;"></span>
                                        </div>
                                        <div class="form-group col-xs-6 col-sm-3 col-md-3 col-lg-3" >
                                            <label class="control-label label-sm" for="Telefone">Telefone</label>
                                            <input class="form-control input-sm" type="text" maxlength="30" value="" id="Telefone" name="Telefone" placeholder="telefone"  readonly="readonly"  />
                                        </div>
                                        <div class="form-group col-xs-1 col-sm-3 col-md-3 col-lg-3" id="boxOutro">
                                            <label class="control-label label-sm" for="Outro">Outro Telefone</label>
                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="Outro" name="Outro" placeholder="outro telefone"  readonly="readonly" />
                                        </div>
                                    </div>
                                    <div class="separacao_campos" style="display: none;"><span>Endereço</span></div>
                                    <div class="row clearfix mt-10" style="display: none;">
                                        <div class="form-group col-sm-8 col-md-4 col-lg-4" id="boxLogradouro1">
                                            <label class="control-label label-sm" for="Logradouro1">Endereço: </label>
                                            <input class="form-control input-sm" type="text" maxlength="200" value="" id="Logradouro1" name="Logradouro1" placeholder="Endereço" readonly="readonly" />
                                        </div>
                                        <div class="form-group col-sm-4 col-md-2 col-lg-2" id="boxNumero1">
                                            <label class="control-label label-sm" for="Numero1">Numero:</label>
                                            <input class="form-control input-sm" type="text" maxlength="10" value="" id="Numero1" name="Numero1" placeholder="numero" readonly="readonly" />
                                        </div>
                                        <div class="form-group col-sm-6 col-md-3 col-lg-3" id="boxComplemento1">
                                            <label class="control-label label-sm" for="Complemento1">Complemento:</label>
                                            <input class="form-control input-sm" type="text" maxlength="30" value="" id="Complemento1" name="Complemento1" placeholder="complemento" readonly="readonly" />
                                        </div>
                                        <div class="form-group col-sm-6 col-md-3 col-lg-3" id="boxBairro1">
                                            <label class="control-label label-sm" for="Bairro1">Bairro:</label>
                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="Bairro1" name="Bairro1" placeholder="bairro" readonly="readonly" />
                                        </div>
                                    </div>
                                    <div class="row clearfix" style="display: none;">
                                        <div class="form-group col-sm-6 col-md-3 col-lg-3" id="boxCidade1">
                                            <label class="control-label label-sm" for="Cidade1">Cidade:</label>
                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="Cidade1" name="Cidade1"  placeholder="cidade ou município" readonly="readonly" />
                                        </div>
                                        <div class="form-group col-sm-6 col-md-3 col-lg-3" id="boxCEP1">
                                            <label class="control-label label-sm" for="CEP1">CEP:</label>
                                            <input class="form-control input-sm" type="text" maxlength="10" value="" id="CEP1" name="CEP1" placeholder="_____-__"  style="width:100px;" readonly="readonly" />
                                        </div>
                                        <div class="form-group required col-sm-6 col-md-3 col-lg-3"  id="boxEstado1">
                                            <label class="control-label label-sm" for="Estado1">Estado/Distristo:</label>
                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="Estado1" name="Estado1"  placeholder="estado" readonly="readonly" />
                                        </div>
                                        <div class="form-group required col-sm-6 col-md-3 col-lg-3"  id="boxPais1">
                                            <label class="control-label label-sm" for="Pais1">País:</label>
                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="Pais1" name="Pais1"  placeholder="pais" readonly="readonly" />
                                        </div>
                                    </div>                                    
                                    <div class="row clearfix" id="boxObservacao" style="display: none;">
                                        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                            <label class="control-label label-sm" for="Observacao">Observações:</label>
                                            <textarea class="form-control" rows="2" id="Observacao" name="Observacao" maxlength="1000" ></textarea>
                                        </div>
                                    </div>
                                    <div class="separacao_linha-sm"><span></span></div>
                                    <div class="row clearfix">
                                        <div class="form-group col-xs-6 col-sm-3 col-md-3 col-lg-3  ">
                                            <label class="control-label label-sm" for="NomeStatus">Status:</label>
                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="NomeStatus" name="NomeStatus" readonly="readonly" />
                                        </div>
                                        <div class="form-group col-xs-6 col-sm-3 col-md-3 col-lg-3  ">
                                            <label class="control-label label-sm" for="DataAcao">Última Atualização:</label>
                                            <input class="form-control input-sm" type="text" maxlength="50" value="" id="DataAcao" name="DataAcao" readonly="readonly" />
                                        </div>
                                        <div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <button type="button" id="bt_editar" class="btn btn-warning btn-espace" onclick="editarInscricao();" disabled="disabled" title="Editar Registro"  ><span class="glyphicon glyphicon-pencil"></span> Alterar Inscrição</button>
                                            <?php  
                                                $userToken = JSession::getFormToken();
                                                
                                                //formando url de retorno após logout
                                                $redirectUrl = "index.php?option=com_users&view=login";
                                                //url codificada
                                                $redirectUrlencoded = urlencode(base64_encode($redirectUrl));
                                                echo '<a class="btn btn-danger  btn-espace" href="../index.php?option=com_users&task=user.logout&' .
                                                $userToken . '=1&return='.$redirectUrlencoded.'" target="_top">'.'<span class="glyphicon glyphicon-off" aria-hidden="true"></span> Sair'.'</a>';
                                            ?>
                                        </div>
                                    </div>
                                </form>
                                
                                    <div class="separacao_campos"><span>Eventos / Palestras / Atividades</span></div>
                                    <div class="row clearfix mb-14">
                                        <div class="form-group-sn col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><span class="fa fa-calendar blue"></span> Eventos Solicitados</h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div id="boxMensagem3" class="clearfix alert-sm"></div><!-- MENSAGEM PEQUENA //-->
                                                    
                                                    <form id="formTransacao" name="formTransacao" action="action.php" onSubmit="return false;" >
                                                        <input type="hidden" id="controle1" name="controle" value="EventoParticipacao" />
                                                        <input type="hidden" id="acao1" name="acao" value="" />
                                                        <input type="hidden" id="Id1" name="Id" value="" />
                                                        <input type="hidden" id="IdEventoParticipante1" name="IdEventoParticipante" value="" />
                                                        <input type="hidden" id="IdEvento1" name="IdEvento" value="" />
                                                        <input type="hidden" id="IdParticipante1" name="IdParticipante" value="" />
                                                        <input type="hidden" id="Observacao1" name="Observacao" value="" />
                                                    </form>
                                                    
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <table id="tabListagemEventos" class="table table-striped table-bordered table-hover table-condensed">
                                                            <thead>
                                                                <tr class="">
                                                                    <th width="6%"><b>Id&nbsp;</b></th>
                                                                    <th><b>Evento</b></th>
                                                                    <th width="10%"><b>Status&nbsp;</b></th>
                                                                    <th width="20%"><b>Observação&nbsp;</b></th>
                                                                    <th width="15%"><b>&nbsp;</b></th>
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
                            </div>
                        </div>
                        
		<!-- Pacotes - INICIO -->
		
</div>
</body>
</html>