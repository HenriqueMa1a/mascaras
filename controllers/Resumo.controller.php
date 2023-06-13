<?php

if(!class_exists('ResumoDAO')){ require_once 'modelo/ResumoDAO.class.php';}
if(!class_exists('InscricaoDAO')){ require_once 'models/InscricaoDAO.class.php';}
if(!class_exists('PessoaDAO')){ require_once 'models/PessoaDAO.class.php';}
if(!class_exists('EventoDAO')){ require_once 'models/EventoDAO.class.php';}
require_once ("assets/Email.class.php");
/**
 *  Controle responsável pela módulo Resumo. 
 * 
 * @package Controller
 * @category Controller
 * @version 1.0
 * @since   2020-05-21
 * @version 1.6
 * @author  Kellen Nery
 * 
 * 
 * @edit    2020-05-22<br />
 *          Kellen Nery <kellen.nery@bio.fiocruz.br>
 *          Implementação da Documentação
 */
class ResumoController extends Controller{
    
    /**
     * Contrutor da Classe
     *
     * @return void
     */    
    public function __construct(){
        parent::__construct('cadastro-resumo');
    }
    
    // Array de Nomes
    private $_arrTipos = array(
            "" => "-",
            0 => "-",
            1 => "V (Vacina)",
            2 => "B (Biofármaco)",
            3 => "R (Reativo para diagnóstico)",
            4 => "OTR (Outros temas relacionados)",
            5 => "G (Gestão)",
            9 => "TESTE" 
    );
    private $_arrStatus = array (
            "" => "-",
            0 => "-",
            1 => "Enviado",
            2 => "Em Analise",
            3 => "Com Pendencia",
            4 => "Aprovado para Publicação",
            5 => "Aprovado para Publicação e Exposição",
            6 => "Aprovado para Publicação, Exposição e Apresentação",
            7 => "Recusado", 
			8 => "Aguardando Aprovação do NIT",
			9 => "Com Pendência do NIT"
    );  
    
    private function getNumeroInstituicao($p_arrInstituicao, $p_Instituicao) {
        $result = array_unique($p_arrInstituicao);
        
        $v = 1;
        $valor = '';
        $retorno = 0;
        foreach ( $result as $p_r ) {
            if ($p_r != '' || $p_r != null) {
                if ($p_Instituicao == $p_r) {
                    $valor = $p_r;
                    $retorno = $v;
                }
            }
            $v ++;
        }
        return $retorno;
    }
    
    /**
     *  Método para retornar um registro
     *
     * @return object Objeto do tipo Resumo
     */    
    public function retornar() {
        
        try{
            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso ", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }

            //$this->response->IdUsuario = $this->Usuario->Id;
            
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
			
            if ($Id){
                $DAO = new ResumoDAO();
                $obj = $DAO->retorna($Id);
				
                if ($obj){ 
                    $this->response->Id = $obj->getId();
                    $this->response->Chave = $obj->getChave();
                    $this->response->idResumo = $obj->getId();
					$this->response->Tipo = $obj->getTipo();
                    $this->response->Codigo = $obj->getCodResumo();
                    $this->response->Classificacao = $this->_arrTipos[$obj->getTipo()];
					$this->response->Titulo = utf8_encode ( $obj->getTitulo () );
					$this->response->autor1 = utf8_encode ( $obj->getAutor1 () );
					$this->response->autor2 = utf8_encode ( $obj->getAutor2 () );
					$this->response->autor3 = utf8_encode ( $obj->getAutor3 () );
					$this->response->autor4 = utf8_encode ( $obj->getAutor4 () );
					$this->response->autor5 = utf8_encode ( $obj->getAutor5 () );
					$this->response->autor6 = utf8_encode ( $obj->getAutor6 () );
					$this->response->autor7 = utf8_encode ( $obj->getAutor7 () );
					$this->response->autor8 = utf8_encode ( $obj->getAutor8 () );
					$this->response->autor9 = utf8_encode ( $obj->getAutor9 () );
					$this->response->autor10 = utf8_encode ( $obj->getAutor10 () );
					$this->response->instituicao1 = utf8_encode ( $obj->getInstituicao1 () );
					$this->response->instituicao2 = utf8_encode ( $obj->getInstituicao2 () );
					$this->response->instituicao3 = utf8_encode ( $obj->getInstituicao3 () );
					$this->response->instituicao4 = utf8_encode ( $obj->getInstituicao4 () );
					$this->response->instituicao5 = utf8_encode ( $obj->getInstituicao5 () );
					$this->response->instituicao6 = utf8_encode ( $obj->getInstituicao6 () );
					$this->response->instituicao7 = utf8_encode ( $obj->getInstituicao7 () );
					$this->response->instituicao8 = utf8_encode ( $obj->getInstituicao8 () );
					$this->response->instituicao9 = utf8_encode ( $obj->getInstituicao9 () );
					$this->response->instituicao10 = utf8_encode ( $obj->getInstituicao10 () );
					$this->response->email1 = $obj->getEmail1 ();
					$this->response->email2 = $obj->getEmail2 ();
					$this->response->email3 = $obj->getEmail3 ();
					$this->response->email4 = $obj->getEmail4 ();
					$this->response->email5 = $obj->getEmail5 ();
					$this->response->email6 = $obj->getEmail6 ();
					$this->response->email7 = $obj->getEmail7 ();
					$this->response->email8 = $obj->getEmail8 ();
					$this->response->email9 = $obj->getEmail9 ();
					$this->response->email10 = $obj->getEmail10 ();
					$this->response->apresentador1 = $obj->getApresentador1();
					$this->response->apresentador2 = $obj->getApresentador2();
					$this->response->apresentador3 = $obj->getApresentador3();
					$this->response->apresentador4 = $obj->getApresentador4();
					$this->response->apresentador5 = $obj->getApresentador5();
					$this->response->apresentador6 = $obj->getApresentador6();
					$this->response->apresentador7 = $obj->getApresentador7();
					$this->response->apresentador8 = $obj->getApresentador8();
					$this->response->apresentador9 = $obj->getApresentador9();
					$this->response->apresentador10 = $obj->getApresentador10();
					$this->response->justificativa8 = utf8_encode ($obj->getJustificativa8 ());
					$this->response->justificativa9 = utf8_encode ($obj->getJustificativa9 ());
					$this->response->justificativa10 = utf8_encode ($obj->getJustificativa10 ());
					$this->response->Introducao = utf8_encode ($obj->getIntroducao());
					$this->response->Objetivo = utf8_encode ($obj->getObjetivo());
					$this->response->Metodologia = utf8_encode ($obj->getMetodologia ());
					$this->response->Resultado = utf8_encode ($obj->getResultado ());
					$this->response->Conclusao = utf8_encode ($obj->getConclusao ());
					$this->response->PalavraChave = utf8_encode ($obj->getPalavraChave());
					$this->response->Referencia = utf8_encode ($obj->getReferencia());
					
					$this->response->DataAcao = $obj->getDataAlteracao();
					$this->response->NomeUsuarioAcao = utf8_encode($obj->getNomeUsuario());	
					
					$this->response->Bloco = utf8_encode ($obj->getBloco());
					$this->response->Poster = utf8_encode ($obj->getPoster());
                    $this->response->dtApresentacao = $obj->getDataApresentacao();
					
					$this->response->File1 = utf8_encode ($obj->getFile1());
					$this->response->File2 = utf8_encode ($obj->getFile2());
					
					
                    if (($obj->getDataApresentacao()!='') && ($obj->getDataApresentacao()!='0000-00-00') && ($obj->getDataApresentacao()!='0000-00-00 00:00:00')){
                        $dtDataApresentacao = explode(" ", Formatacao::formatarDataHoraSQL($obj->getDataApresentacao(), false)); 
                        if (count($dtDataApresentacao)>1){
                            $this->response->DataApresentacao = $dtDataApresentacao[0];
                            $this->response->HoraApresentacao = substr($dtDataApresentacao[1], 0, 5);
                        } else {
                            $this->response->DataApresentacao = Formatacao::formatarDataSQL($obj->getDataApresentacao(), false);
                            //$this->response->HoraApresentacao = '00:00';
							$this->response->HoraApresentacao = substr($obj->getHoraApresentacao(), -8, 5);
                        }
                    } else {
                        $this->response->DataApresentacao = '';
                        $this->response->HoraApresentacao = '00:00';
                    }
                    
                    // 
					$autor1  = utf8_encode ($obj->getAutor1());
					$autor2  = utf8_encode ($obj->getAutor2());
					$autor3  = utf8_encode ($obj->getAutor3());
					$autor4  = utf8_encode ($obj->getAutor4());
					$autor5  = utf8_encode ($obj->getAutor5());
					$autor6  = utf8_encode ($obj->getAutor6());
					$autor7  = utf8_encode ($obj->getAutor7());
					$autor8  = utf8_encode ($obj->getAutor8());
					$autor9  = utf8_encode ($obj->getAutor9());
					$autor10 = utf8_encode ($obj->getAutor10());
					
					$instituicao1  = utf8_encode ($obj->getInstituicao1());
					$instituicao2  = utf8_encode ($obj->getInstituicao2());
					$instituicao3  = utf8_encode ($obj->getInstituicao3());
					$instituicao4  = utf8_encode ($obj->getInstituicao4());
					$instituicao5  = utf8_encode ($obj->getInstituicao5());
					$instituicao6  = utf8_encode ($obj->getInstituicao6());
					$instituicao7  = utf8_encode ($obj->getInstituicao7());
					$instituicao8  = utf8_encode ($obj->getInstituicao8());
					$instituicao9  = utf8_encode ($obj->getInstituicao9());
					$instituicao10 = utf8_encode ($obj->getInstituicao10());					
		
                    //$arrAutores = array(1=>$obj->getAutor1(), 2=>$obj->getAutor2(), 3=>$obj->getAutor3(), 4=>$obj->getAutor4(), 5=>$obj->getAutor5(), 6=>$obj->getAutor6(), 7=>$obj->getAutor7(), 8=>$obj->getAutor8(), 9=>$obj->getAutor9(), 10=>$obj->getAutor10());
					$arrAutores = array(1=>$autor1, 2=>$autor2, 3=>$autor3, 4=>$autor4, 5=>$autor5, 6=>$autor6, 7=>$autor7, 8=>$autor8, 9=>$autor9, 10=>$autor10);
                    //$arrInstituicao = array(1=>$obj->getInstituicao1(), 2=>$obj->getInstituicao2(), 3 => $obj->getInstituicao3(), 4 => $obj->getInstituicao4(), 5 => $obj->getInstituicao5(), 6 => $obj->getInstituicao6(), 7 => $obj->getInstituicao7(), 8 => $obj->getInstituicao8(), 9 => $obj->getInstituicao9(), 10=>$obj->getInstituicao10());
					$arrInstituicao = array(1=>$instituicao1, 2=>$instituicao2, 3=>$instituicao3, 4=>$instituicao4, 5=>$instituicao5, 6=>$instituicao6, 7=>$instituicao7, 8=>$instituicao8, 9=>$instituicao9, 10=>$instituicao10);
                    $arrInstituicaoIndex = array_unique($arrInstituicao);
                    
                    $statusApresentador = array(1=>($obj->getApresentador1()==1)?'*':'', 2=>($obj->getApresentador2()==1)?'*':'', 3=>($obj->getApresentador3()==1)?'*':'', 4=>($obj->getApresentador4()==1)?'*':'', 5=>($obj->getApresentador5()==1)?'*':'', 6=>($obj->getApresentador6()==1)?'*':'', 7=>($obj->getApresentador7()==1)?'*':'', 8=>($obj->getApresentador8()==1)?'*':'', 9=>($obj->getApresentador9()==1)?'*':'', 10=>($obj->getApresentador10()==1)?'*':'');
                    
                    $this->response->arrAutores = $arrAutores;
                    $this->response->arrInstituicao = $arrInstituicao;
                    $this->response->arrInstituicaoIndex = $arrInstituicaoIndex;
                    $this->response->statusApresentador = $statusApresentador;
                    
                    $html = '';
                    $i = 1;
                    $asterisco = '*';
					$linhaInstituicao='';
                    foreach($arrInstituicaoIndex as $p_Instituicao) {
						if ($i == 1) {
							$contador = 1;
							foreach ($arrAutores as $p_Autores) {
								if ($p_Autores != '' || $p_Autores != null) {
									if ($contador==1) {
										if ($obj->getApresentador1()==1) {
											$html.= trim($p_Autores) . "<sup>1</sup>" . $asterisco . "; ";
										} else {
											$html.= trim($p_Autores) . "<sup>1</sup>; ";
										}
									} else {
										if ($arrInstituicao != '' || $arrInstituicao != null) {
											$html.= trim($p_Autores)."<sup>". $this->getNumeroInstituicao($arrInstituicao, $arrInstituicao[$contador]) ."</sup>". $statusApresentador[$contador] ."; ";
										}
									}
								}
								$apresentador = "";
								$contador ++;
							}
							$html = substr(trim($html),0, -1).'.';
							$html.='<br/>';
						}
						if ($p_Instituicao != '' || $p_Instituicao != null) {
							if ($linhaInstituicao!=''){$linhaInstituicao.= "<br/>";}
							//$html.= trim("<sup>". $i ."</sup>".$p_Instituicao) . ";<br/>";
							$linhaInstituicao.= trim ( "<sup>" . $i . "</sup>" . $p_Instituicao ) . ";";
						}
						
						$i ++;
					}
                    $linhaInstituicao = substr(trim($linhaInstituicao),0, -1).'.';
					$html.= $linhaInstituicao;
                    
					$this->response->Autores = $html;
                    
					$this->response->FlagPolitica = '';($obj->getFlagPolitica())? true: false;
					$this->response->FlagPolitica1 = '';($obj->getFlagPolitica1())? true: false;
					$this->response->FlagPolitica2 = '';($obj->getFlagPolitica2())? true: false;
					//$this->response->FlagPolitica3 = '';($obj->getFlagPolitica3())? true: false;
                    $this->response->Observacao = htmlspecialchars_decode($obj->getObservacao ());
                    //$this->response->ComentarioBanca = $obj->getComentarioBanca();
                    
                    $this->response->IdStatus = $obj->getIdStatus();
                    $this->response->NomeStatus = $this->_arrStatus[$obj->getIdStatus()];
                    $this->response->Ativo = ($obj->getAtivo())? 1: 0;
                    $this->response->Revisao = $obj->getRevisao();
                    //$this->response->Acao = $obj->getAcao();
                    //$this->response->IdUsuarioAcao = $obj->getIdUsuarioAcao();
                    $this->response->IdUsuarioCadastro = $obj->getIdUsuario();
					
                    $this->response->DataCadastro = ($obj->getDataInclusao()) ? Formatacao::formatarDataHoraSQL($obj->getDataInclusao(), false) : '';

                    $this->response->IdUsuario = $obj->getIdUsuario();
                    $this->response->IdUsuarioAprovacao = $obj->getIdUsuarioAprovacao();
                    
                    $uDAO = new InscricaoDAO();
                    $obj1 = $uDAO->retornarPorUsuario($obj->getIdUsuario());
					
                    if ($obj1){
                        $this->response->NomeUsuarioCadastro = $obj1->getNomeCompleto(); //$obj->getNomeUsuarioAcao();
                    }
					
                    $this->response->query2 = $uDAO->_query;

                    $this->response->sucesso = 1;
					
                    $this->response->mensagem = "Registro com id: '$Id' foi localizado com sucesso.";
					
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro com id: '$Id'.";
                }
				
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
				
                $DAO->Close();	
				
            } else {
                $this->response->mensagem = "O identificador do registro é um parametro obrigatório.";
            }
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }

        return ($this->response->sucesso==1);
    }

    /**
     *  Método para criar um novo registro
     *
     * @return int O Identificador do registro criado
     */    
    public function incluir() {
        try {
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            $Sigla = self::getVar('Sigla');
            $Nome = self::getVar('Nome');
            $Ativo = self::getVar('Ativo');
            
            // Criticar campos
            if(!$Sigla) {
                $this->response->mensagem = "O campo <b>Sigla</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Nome) {
                $this->response->mensagem = "O campo <b>Nome</b> é de preenchimento obrigatório.";
                return false;
            }
            /*
            $DAO = new ResumoDAO();

            $obj = new Resumo();
            $obj->setId($Id);
            $obj->setSigla($Sigla);
            $obj->setNome($Nome);
            $obj->setAtivo($Ativo);
            if ($DAO->salvar($obj)){
                $Id = $obj->getId();
                $this->response->Id=$Id;
                $this->response->sucesso = 1;
                $this->response->mensagem = "Registro '$Nome' foi cadastrado com sucesso.";
            } else {
                $this->response->mensagem = $DAO->getMensagem();
            }
            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();
            */
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
    
    /**
     *  Método para editar um registro
     *
     * @return bool Se atualização relizada com sucesso
     */    
    public function editar() { 
        try {
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            $Sigla = self::getVar('Sigla');
            $Nome = self::getVar('Nome');
            $Ativo = self::getVar('Ativo');
            
            // Criticar campos
            if(!$Sigla) {
                $this->response->mensagem = "O campo <b>Sigla</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Nome) {
                $this->response->mensagem = "O campo <b>Nome</b> é de preenchimento obrigatório.";
                return false;
            }
            $this->response->Id=$Id;
            if ($Id){
                /*
                $DAO = new ResumoDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    $obj->setSigla($Sigla);
                    $obj->setNome($Nome);
                    $obj->setAtivo($Ativo);
                    if ($DAO->atualizar($obj)){
                        $this->response->sucesso = 1;
                        $this->response->mensagem = "Registro '$Nome' atualizado com sucesso.";
                    } else {
                        $this->response->mensagem = $DAO->getMensagem();
                    }
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro com id: '$Id'.";
                }
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
                $DAO->Close();
                */
            } else {
                $this->response->mensagem = "O identificador do registro é um parametro obrigatório.";
            }
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
    
    /**
     * Método para excluir um registro
     * 
     * @param int Identificador do registro 
     *
     * @return bool Se atualização relizada com sucesso
     */    
    public function excluir($p_Id=null){
        try {
            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }
            
            // Coletar parametros
            if ($p_Id>0) {
                $Id = $p_Id;
            } else {
                $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            }
            $this->response->Id = $Id;
            if ($Id){
                /* 
                $DAO = new ResumoDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    $this->response->Nome = $obj->getNome();
                    if ($DAO->excluir($Id)){
                        $this->response->sucesso = 1;
                        $this->response->mensagem = "O registro <b>'".$obj->getNome()."'</b> foi removido com sucesso.";
                    } else {
                        $this->response->mensagem = $DAO->getMensagem();
                    }
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro de Id: '$Id'.";
                }
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
                $DAO->Close();
                */
            } else {
                $this->response->mensagem = "O identificador do registro é um parametro obrigatório.";
            }
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
    
    /**
     *  Método para listar todos registros
     *
     * @return array Retornar o array aaData[] = {{Link, Id, Sigla, Nome, Ativo},...}
     */    
    public function listar() {
		
        $page = self::getVar('iDisplayStart');
        $rows = self::getVar('iDisplayLength');
        $sidx = self::getVar('sidx');
        $sord = self::getVar('sord');
        //$sEcho = self::getVar('sEcho');
		
        try { 
          
            /** Ordering */
            $aColumns = array(0=>'img', 1=>'1', 3=>'sigla', 4=>'nome', 5=>'ativo', 6=>'' );
            $sOrder = "";
            if (self::getVar('iSortCol_0')){
                $iSortCol_0 = self::getVar('iSortCol_0');
                $bSortable = 'bSortable_'.$iSortCol_0;
                if (self::getVar($bSortable)=='true'){
                    $sidx = $aColumns[intval($iSortCol_0)];
                    $sord = self::getVar('sSortDir_0');
                } 
            } else {
                $sidx = '1';
                $sord = 'desc';
            }
            $this->response->sidx = $sidx;
            $this->response->sord = $sord;
            $this->response->sOrder = $sOrder;
            
            $Id = self::getVar('Id');
			$EventoPrincipal = self::getVar('EventoPrincipal');	
			
			/*Não precisa mais buscar os resumos pelos Ano, pois será utilizado id_evento como chave estrangeira na tabela cad_resumo*/
            //$Ano = date("Y");
			//if($EventoPrincipal != null){
			//	$DAOEvento = new EventoDAO();		
			//	$objEvento = $DAOEvento->retornar($EventoPrincipal);
			//	$Ano = date( 'Y', strtotime($objEvento->getDataInicial()) );
			//}else {
			//	$Ano = null;
			//}

            $Titulo = self::getVar('Titulo');
            $Nome = self::getVar('Nome');
            $IdUsuario = self::getVar('IdUsuario');			
            $IdTipo = self::getVar('IdTipo');
            $IdStatus = self::getVar('IdStatus');

         /* $arrUsuario = array();
            $uDAO = new InscricaoDAO();
            $listagem = $uDAO->listar(null, null, 'u.id', 'asc', null, null, null, null, null, null);
            if ($listagem) {
                foreach ($listagem as $item){
                    $Id = $item->getIdUsuario();
                    $arrUsuario[$Id] = new stdClass;
                    $arrUsuario[$Id]->Id = $Id;
                    $arrUsuario[$Id]->Nome = $item->getNomeCompleto();
                    $arrUsuario[$Id]->DataNascimento = $item->getDataNascimento();
                    $arrUsuario[$Id]->Email = $item->getEmail();
                }
            }
         */ 
			$DAO = new ResumoDAO();		
            $listagem = $DAO->lista($page, $rows, $sidx, $sord, $EventoPrincipal, $IdUsuario, $IdTipo, $Titulo, $Nome, $IdStatus);	
			
            if ($listagem) { 
                $this->response->page = ($DAO->getPaginaAtual()) ? $DAO->getPaginaAtual(): 1; // 1; 
                $this->response->total = ($DAO->getTotalPaginas()) ? $DAO->getTotalPaginas(): 1; // 1; 
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem); // count($listagem);
                $i = 0;
                foreach ($listagem as $item){
                    $bt_view = '<a class="btn btn-vazio btn-sm btn-grid" title="Visualizar registro." onclick="visualizar('.$item->getId().');"><span class="glyphicon glyphicon-search"></span>';
                    $bt_acoes = '<a class="btn btn-vazio btn-sm btn-grid" title="Visualizar impressão do Resumo." onclick="visualizarImpressao('.$item->getId().');"><span class="fa fa-file-pdf-o red"></span>';
                    $DataInclusao = Formatacao::formatarDataHoraSQL ($item->getDataInclusao(), false);
                    //if (array_key_exists($item->getIdUsuario(), $arrUsuario)){
                    //    $Nome = $arrUsuario[$item->getIdUsuario()]->Nome;
                    //    $Email = '<span class="label label-default">'.$arrUsuario[$item->getIdUsuario()]->Email.'</span>';
                    //    $DataNascimento = $arrUsuario[$item->getIdUsuario()]->DataNascimento;
                    //} else {
                    //    $Nome = '';
                    //    $Email = '';
                    //    $DataNascimento = '';
                    //}
					
					$Email = '<span class="label label-default">'.$item->getEmail().'</span>';
					$EmailContato = '<span class="label label-default">'.$item->getEmailContato().'</span>';
					$TelefoneContato = '&nbsp;&nbsp;<span class="label label-default">'.$item->getTelefoneContato().'</span>';
                    
                    $this->response->aaData[$i] = array($bt_view, $bt_acoes, $item->getId(), utf8_encode($item->getNomeCompleto()).'<br/>'.$Email, utf8_encode($item->getNomeContato()).'<br/>'.$EmailContato.$TelefoneContato, $item->getCodResumo(), utf8_encode(strip_tags($item->getTitulo())), $this->_arrTipos[$item->getTipo()], $DataInclusao, $this->_arrStatus[$item->getIdStatus()], $item->getRevisao() );
                    //$this->response->aaData[$i] = array($bt_view, $bt_acoes, $item->getId(), $item->getCodResumo(), utf8_encode(strip_tags($item->getTitulo())), $this->_arrTipos[$item->getTipo()], $DataInclusao, $this->_arrStatus[$item->getIdStatus()], $item->getRevisao(), '' );
					$i++;
                }
                $this->response->sucesso = 1;
                $this->response->iTotalRecords = $this->response->records;
                $this->response->iTotalDisplayRecords = $this->response->records;

            }else{
                $this->response->page = 0; 
                $this->response->total = 0; 
                $this->response->records = 0;
                $this->response->mensagem = "Nenhum registro encontrado para o filtro selecionado ";
            }
            $this->response->query = $DAO->_query;
            $DAO->Close();
			
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        
		return ($this->response->sucesso==1);
    }

    /**
     *  Método para listar registro para um ComboBox
     *
     * @return array Retornar o array rows[] = {{value:'', text:''},...}
     */    
    public function listarCombo() {
        try {
            $Id = self::getVar('Id');
            $Nome = self::getVar('Nome');
        
            $DAO = new ResumoDAO();
            $listagem = $DAO->listar(null, null, 'nome', 'asc', $Id, $Nome);
            if ($listagem) {
                $this->response->records = count($listagem);
                $i = 0;
                foreach ($listagem as $item){
                    $this->response->rows[$i]['value'] = intval($item->getId()); 
                    $this->response->rows[$i]['text'] = $item->getNome();
                    $this->response->rows[$i]['activated'] = ($item->getAtivo())? 1: 0;
                    $i++;
                }
                $this->response->sucesso=1;
            }else{
                $this->response->records=0;
            }
            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    } 

   
    /**
     * Método para listar todos registros Históricos
     *
     * @param Strins Chave de identificação do registro 
     *
     * @return array Retornar o array aaData[] = {{Link, Id, Sigla, Nome, Ativo},...}
     */    
    public function listarHistorico() {
        
        try {
            /** Ordering */
            $aColumns = array(0=>'img', 1=>'1', 3=>'sigla', 4=>'nome', 5=>'ativo', 6=>'' );
            $sOrder = "";
            if (self::getVar('iSortCol_0')){
                $iSortCol_0 = self::getVar('iSortCol_0');
                $bSortable = 'bSortable_'.$iSortCol_0;
                if (self::getVar($bSortable)=='true'){
                    $sidx = $aColumns[intval($iSortCol_0)];
                    $sord = self::getVar('sSortDir_0');
                } 
            } else {
                $sidx = '1';
                $sord = 'desc';
            }
            $this->response->sidx = $sidx;
            $this->response->sord = $sord;
            $this->response->sOrder = $sOrder;
            
            $Id = self::getVar('Id');
            $Chave = self::getVar('Chave');
            
            if ($Chave!=''){
                $DAO = new ResumoDAO();
                $listagem = $DAO->listarHistorico($page, $rows, $sidx, $sord, $Chave);
                if ($listagem) {
                    $this->response->page = ($DAO->getPaginaAtual()) ? $DAO->getPaginaAtual(): 1; // 1; 
                    $this->response->total = ($DAO->getTotalPaginas()) ? $DAO->getTotalPaginas(): 1; // 1; 
                    $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem); // count($listagem);

                    $i = 0;
                    foreach ($listagem as $item){
                        $bt_view = '<a class="btn btn-vazio btn-sm btn-grid" title="Visualizar impressão do Resumo." onclick="visualizarImpressao('.$item->getId().');"><span class="fa fa-file-pdf-o red"></span>';
                        $DataInclusao = Formatacao::formatarDataHoraSQL ($item->getDataInclusao(), false);
                        
                        $this->response->aaData[$i] = array($bt_view, $item->getId(), $item->getCodResumo(), $this->_arrTipos[$item->getTipo()], $item->getRevisao(), $DataInclusao, $item->getDataAlteracao());
                        $i++;
                    }
                    $this->response->sucesso = 1;
                    $this->response->iTotalRecords = $this->response->records;
                    $this->response->iTotalDisplayRecords = $this->response->records;
                }else{
                    $this->response->page = 0; 
                    $this->response->total = 0; 
                    $this->response->records = 0;
                    $this->response->mensagem = "Não existe histório para este registro.";
                }
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
                $DAO->Close();
            } else {
                $this->response->mensagem = "A chave identificadora do registro é um parametro obrigatório.";
            }
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
    
	function limparHTML($html) {
		$texto = trim ( $html );
		$texto = str_replace ( "&nbsp;", " ", $texto );		

		$texto = str_replace ( "<p>", "<span>", $texto );
		$texto = str_replace ( "<p ", "<span ", $texto );
		$texto = str_replace ( "</p>", "</span>", $texto );
		
		return $texto;
	}
 
 
    public function relatorioWord() {

		isset ( $_GET ['acao'] ) ? $acao = $_GET ['acao'] : $acao = '';
		isset ( $_GET ['page'] ) ? $page = $_GET ['page'] : $page = '';
		isset ( $_GET ['rows'] ) ? $rows = $_GET ['rows'] : $rows = '';
		isset ( $_GET ['sidx'] ) ? $sidx = $_GET ['sidx'] : $sidx = '';
		isset ( $_GET ['sord'] ) ? $sord = $_GET ['sord'] : $sord = '';
		if (! $sidx)
			$sidx = 1;	
	
		$Titulo = filter_input(INPUT_GET, 'Titulo');
		$Nome = filter_input(INPUT_GET, 'Nome');
		$IdTipo = filter_input(INPUT_GET, 'IdTipo', FILTER_SANITIZE_NUMBER_INT);
		$IdStatus = filter_input(INPUT_GET, 'IdStatus', FILTER_SANITIZE_NUMBER_INT);
		$EventoPrincipal = filter_input(INPUT_GET, 'EventoPrincipal', FILTER_SANITIZE_NUMBER_INT);
		$ExibeAutor = filter_input(INPUT_GET, 'ExibeAutor');		
	
		$DAO = new ResumoDAO();
		$listagem = $DAO->lista($page, $rows, 'Codigo', $sord, $EventoPrincipal, '', $IdTipo, $Titulo, $Nome, $IdStatus);

		$this->response->cabecalho='';
		$this->response->html='';

		// Cabeçalho 
		$this->_Pagina = 'A4';
		$this->response->cabecalho = (file_exists('views/cabecalho.'.$this->_Formato.'.html'))? file_get_contents('views/cabecalho.'.$this->_Formato.'.html'): '';
		
		if ($listagem) {

			$html = '';	
			
			foreach ($listagem as $objResumo){
				
				$IdResumo = $objResumo->getId();
				
				//Código do Resumo
				$html.= '<font color="blue"><b>Summary Code: </b>' . strip_tags ( $this::limparHTML($objResumo->getCodResumo()) ) . '</font> &nbsp;&nbsp;&nbsp;&nbsp;<font color="red"><b>Version: ' . $objResumo->getRevisao() . "</b></font><br><br>";
				// Titulo						
				$html.= '<p align="justify" style="font-size:12pt;"> <strong>' . strip_tags($objResumo->getTitulo()) . "</strong><br/><br/></p>";
				//$html.= '<br/>';
				
				//**** INICIO - Exibir Autor e Instituição ****//
				$autor1 = $objResumo->getAutor1 ();
				$autor2 = $objResumo->getAutor2 ();
				$autor3 = $objResumo->getAutor3 ();
				$autor4 = $objResumo->getAutor4 ();
				$autor5 = $objResumo->getAutor5 ();
				$autor6 = $objResumo->getAutor6 ();
				$autor7 = $objResumo->getAutor7 ();
				$autor8 = $objResumo->getAutor8 ();
				$autor9 = $objResumo->getAutor9 ();
				$autor10 = $objResumo->getAutor10 ();
				$arrAutores = array (
						"autores" => array (
								1 => $autor1,
								2 => $autor2,
								3 => $autor3,
								4 => $autor4,
								5 => $autor5,
								6 => $autor6,
								7 => $autor7,
								8 => $autor8,
								9 => $autor9,
								10 => $autor10 
						) 
				);
				
				$Instituicao1 = $objResumo->getInstituicao1 ();
				$Instituicao2 = $objResumo->getInstituicao2 ();
				$Instituicao3 = $objResumo->getInstituicao3 ();
				$Instituicao4 = $objResumo->getInstituicao4 ();
				$Instituicao5 = $objResumo->getInstituicao5 ();
				$Instituicao6 = $objResumo->getInstituicao6 ();
				$Instituicao7 = $objResumo->getInstituicao7 ();
				$Instituicao8 = $objResumo->getInstituicao8 ();
				$Instituicao9 = $objResumo->getInstituicao9 ();
				$Instituicao10 = $objResumo->getInstituicao10 ();
				$arrInstituicao = array (
						"instituicao" => array (
								1 => $Instituicao1,
								2 => $Instituicao2,
								3 => $Instituicao3,
								4 => $Instituicao4,
								5 => $Instituicao5,
								6 => $Instituicao6,
								7 => $Instituicao7,
								8 => $Instituicao8,
								9 => $Instituicao9,
								10 => $Instituicao10 
						) 
				);
				$result = array_unique ( $arrInstituicao ["instituicao"] );

				$i = 1;
				$asterisco = '*';
				$arrInstCompare = array (
						"instCompare" => array (
								1 => $Instituicao1,
								2 => $Instituicao2,
								3 => $Instituicao3,
								4 => $Instituicao4,
								5 => $Instituicao5,
								6 => $Instituicao6,
								7 => $Instituicao7,
								8 => $Instituicao8,
								9 => $Instituicao9,
								10 => $Instituicao10 
						) 
				);
				$linhaInstituicao='';
				
				foreach ( $result as $p_Instituicao ) {
					if ($i == 1) {
						$contador = 1;
						$linhaAutores='';
						foreach ( $arrAutores ["autores"] as $p_Autores ) {
							if ($p_Autores != '' || $p_Autores != null) {
								
								if ($contador == 1) {
									if ($objResumo->getApresentador1 () == 1) {
										$linhaAutores.= trim ( $p_Autores ) . "<sup>1</sup>" . $asterisco . "; ";
									} else {    
										$linhaAutores.= trim ( $p_Autores ) . "<sup>1</sup>; ";
									}
								} else {
									if ($arrInstCompare != '' || $arrInstCompare != null) {
										$linhaAutores.= trim ( $p_Autores ) . "<sup>" . trim($this::numInstituicao ( $arrInstCompare ["instCompare"] [$contador], $IdResumo )) . "</sup>" . trim($this::statusApresentador ( $contador, $IdResumo )) . "; ";
									}
								}
							}
							$apresentador = "";
							
							$contador ++;
						}
						$linhaAutores = substr(trim($linhaAutores),0, -1).'.';
						if ($ExibeAutor == 'S'){
							$$html.= '<p align="justify">';
							$html.= utf8_encode($linhaAutores). '<br/></p>';
						}
					}
					
					if ($p_Instituicao != '' || $p_Instituicao != null) {
						if ($linhaInstituicao!=''){$linhaInstituicao.= "<br/></p>";}
						$linhaInstituicao.= trim ( "<sup>" . $i . "</sup>" . $p_Instituicao ) . ";";
					}
					
					$i ++;
				}

				$linhaInstituicao = substr(trim($linhaInstituicao),0, -1).'.';
				if ($ExibeAutor == 'S'){
					$html.= utf8_encode($linhaInstituicao);		
					$html = $html . '<br/><br/></p>';
				}				
				//**** FIM - Exibir Autor e Instituição ****//
				// Introdução
				$html.= '<b>Introduction: </b>' . $this::limparHTML($objResumo->getintroducao ()) . "<br/><br/></p>";
				// Objetivos
				$html.= '<b>Objective: </b>' . $this::limparHTML($objResumo->getObjetivo ()) . "<br/><br/></p>";
				// Metodologia
				$html.= '<b>Methodology: </b>' . $this::limparHTML($objResumo->getMetodologia ()) . "<br/><br/></p>";
				// Resultados
				$html.= '<b>Results: </b>' . $this::limparHTML($objResumo->getResultado ()) . "<br/><br/></p>";
				// Conclusão
				$html.= '<b>Conclusion: </b>' . $this::limparHTML($objResumo->getConclusao ()) . "<br/><br/></p>";
				// Palavras-Chave
				$html.= '<strong>Palavras-Chave:</strong> ' . $this::limparHTML($objResumo->getPalavraChave ()) . "<br/><br/></p>";
				
				// Quebrar página
				$html.= '<br style="page-break-after: always;">';
				
						
			}
		
		$this->response->html = $html;

		}

	}


    /**
     *  Função local para montar a array de Instituições
     */ 
	function numInstituicao($Instituicao, $IdResumo) {
		$DAO = new ResumoDAO ();
		$objResumo = $DAO->retorna($IdResumo);
		$Instituicao1 = $objResumo->getInstituicao1 ();
		$Instituicao2 = $objResumo->getInstituicao2 ();
		$Instituicao3 = $objResumo->getInstituicao3 ();
		$Instituicao4 = $objResumo->getInstituicao4 ();
		$Instituicao5 = $objResumo->getInstituicao5 ();
		$Instituicao6 = $objResumo->getInstituicao6 ();
		$Instituicao7 = $objResumo->getInstituicao7 ();
		$Instituicao8 = $objResumo->getInstituicao8 ();
		$Instituicao9 = $objResumo->getInstituicao9 ();
		$Instituicao10 = $objResumo->getInstituicao10 ();
		$arrInstituicao = array (
				"instituicao" => array (
						1 => $Instituicao1,
						2 => $Instituicao2,
						3 => $Instituicao3,
						4 => $Instituicao4,
						5 => $Instituicao5,
						6 => $Instituicao6,
						7 => $Instituicao7,
						8 => $Instituicao8,
						9 => $Instituicao9,
						10 => $Instituicao10 
				) 
		);
		$result = array_unique ( $arrInstituicao ["instituicao"] );
		
		$v = 1;
		$valor = '';
		$retorno = 0;
		foreach ( $result as $p_r ) {
			if ($p_r != '' || $p_r != null) {
				if ($Instituicao == $p_r) {
					$valor = $p_r;
					$retorno = $v;
				}
			}
			$v ++;
		}
		return $retorno;
	}

	/**
     *  Função local para montar a array de Apresentadores
     */ 
	function statusApresentador($num, $id) {
		$DAO = new ResumoDAO ();
		$objValor = $DAO->retornaApresentador ( $id );
		$result = "";
		$arr = array (
				"apresentador" => array (
						1 => $objValor->getApresentador1 (),
						2 => $objValor->getApresentador2 (),
						3 => $objValor->getApresentador3 (),
						4 => $objValor->getApresentador4 (),
						5 => $objValor->getApresentador5 (),
						6 => $objValor->getApresentador6 (),
						7 => $objValor->getApresentador7 (),
						8 => $objValor->getApresentador8 (),
						9 => $objValor->getApresentador9 (),
						10 => $objValor->getApresentador10 () 
				) 
		);
		if ($arr ["apresentador"] [$num] == 1) {
			$result = " *";
		}
		return $result;
	} 


    /**
     *  Método para listar todos registros
     *
     * @return array Retornar o array aaData[] = {{Link, Id, Sigla, Nome, Ativo},...}
     */    
    public function relatorio() {
        $page = self::getVar('iDisplayStart');
        $rows = self::getVar('iDisplayLength');
        $sidx = self::getVar('sidx');
        $sord = self::getVar('sord');
        //$sEcho = self::getVar('sEcho');

        try {
            $DAO = new ResumoDAO();

            /** Ordering */
            $aColumns = array(0=>'img', 1=>'1', 2=>'nome', 3=>'apelido', 4=>'nome', 5=>'resumo' );
            $sOrder = "";
            if (self::getVar('iSortCol_0')){
                $iSortCol_0 = self::getVar('iSortCol_0');
                $bSortable = 'bSortable_'.$iSortCol_0;
                if (self::getVar($bSortable)=='true'){
                    $sidx = $aColumns[intval($iSortCol_0)];
                    $sord = self::getVar('sSortDir_0');
                } 
            } else if (is_numeric($sidx)) {
                $sidx = $aColumns[$sidx];
            } else {
                $sidx = 'codigo';
                $sord = 'desc';
            }
            $this->response->sidx = $sidx;
            $this->response->sord = $sord;
            $this->response->sOrder = $sOrder;
            
            // Paramentros
            $IdEmpresa = self::getVar('IdEmpresa', FILTER_SANITIZE_NUMBER_INT);
            $Tipo = self::getVar('Tipo');
            $Nivel = self::getVar('Nivel');
            $IdParente = self::getVar('IdParente');
            $NomeParente = '';
            $Id = self::getVar('Id');
            //$Ano = date("Y");
            $Codigo = self::getVar('Codigo');
            $Titulo = self::getVar('Titulo');
            $Nome = self::getVar('Nome');
            $IdUsuario = self::getVar('IdUsuario');
            $IdTipo = self::getVar('IdTipo');
            $IdStatus = self::getVar('IdStatus');
			
			$EventoPrincipal = self::getVar('EventoPrincipal');			
			if($EventoPrincipal != null){
				$DAOEvento = new EventoDAO();		
				$objEvento = $DAOEvento->retornar($EventoPrincipal);
				$idEvento = $objEvento->getIdEvento();
				//$Ano = date( 'Y', strtotime($objEvento->getDataInicial()) );
			}else {
				$idEvento = null;
				//$Ano = null;
			}	
            
            $this->response->cabecalho='';
            $this->response->html='';
            
            // Cabeçalho 
                $this->_Pagina = 'A4';
                $this->response->cabecalho = (file_exists('views/cabecalho.'.$this->_Formato.'.html'))? file_get_contents('views/cabecalho.'.$this->_Formato.'.html'): '';
                $this->response->cabecalho = str_replace("{SISNOME}", $this->Config->Nome, $this->response->cabecalho);
                $this->response->cabecalho = str_replace("{SISVERSAO}", $this->Config->Versao, $this->response->cabecalho);
                $this->response->cabecalho = str_replace("{TITULO}", "Relatório de Resumos", $this->response->cabecalho);
                $this->response->cabecalho = str_replace("{TIMESTAMP}", date("j-m-Y H:m"), $this->response->cabecalho);
                // Filtros
                $strFiltro = '';
                //$strFiltro .= ($Tipo)? "Tipo: <em>$Tipo</em> &nbsp;&nbsp;&nbsp;": ""; 
                //$strFiltro .= ($Nivel)? "Nivel: <em>$Nivel</em> &nbsp;&nbsp;": ""; 
                //$strFiltro .= ($NomeParente)? "Conta Principal: <em>$NomeParente</em> &nbsp;&nbsp;&nbsp;": ""; 
                $strFiltro .= ($Codigo)? "Código: <em>$Codigo</em> &nbsp;&nbsp;&nbsp;": ""; 
                $strFiltro .= ($Nome)? "Titulo: <em>$Titulo</em> &nbsp;&nbsp;&nbsp;": ""; 
                $strFiltro .= ($IdStatus)? "Titulo: <em>$IdStatus</em> &nbsp;&nbsp;&nbsp;": ""; 
                $strFiltro .= (!$strFiltro)? "-x-": ""; 
                $this->response->cabecalho = str_replace("{FILTRO}", $strFiltro, $this->response->cabecalho);
            
            // Formato
            if (($this->_Formato=='excel') || ($this->_Formato=='pdf')){
                // Cabeçalho da Tabela
                $this->response->html.= "<table style='border: 0.5px solid #000000; font-family: arial; font-size: 8pt; vertical-align: top; ' cellspacing='0' cellpadding='5'>"
                                            ."<tr style='background-color: #ccc; '>"
                                            ."    <td width='30' style='border: 0.5px solid #000000;'><b>#</b></td>"
                                            ."    <td width='200' style='border: 0.5px solid #000000;'><b>Autor</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Co-autores</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Instituições</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Nome Inscrito</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>E-mail</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Cpf</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Passaporte</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Estado</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>País</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Data Nascimento</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Telefone</b></td>"
                                            ."    <td width='100' style='border: 0.5px solid #000000;'><b>Código</b></td>"
                                            ."    <td width='60' style='border: 0.5px solid #000000;'><b>Titulo</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Palavras-Chave</b></td>"
                                            ."    <td width='60' style='border: 0.5px solid #000000;'><b>Classificação</b></td>"
                                            ."    <td width='50' style='border: 0.5px solid #000000;'><b>Data do Cadastro</b></td>"
                                            ."    <td width='50' style='border: 0.5px solid #000000;'><b>Status do Resumo</b></td>"
                                            ."    <td width='50' style='border: 0.5px solid #000000;'><b>Revisão</b></td>"
                                            ."</tr>";
            }
                        
            
            $listagem = $DAO->lista($page, $rows, $sidx, $sord, $idEvento, $IdUsuario, $IdTipo, $Titulo, $Nome, $IdStatus);

            if ($listagem) {
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem);
                
                //$this->response->html.= "<tr><td colspan='5'>".$DAO->_query."</td></tr>";
                
                $i = 0;
                foreach ($listagem as $item){
                    $cor = ($i%2==0? '#eee': '#fff');
                    
                    $Ativo = ($item->getAtivo())? 'sim': 'não';
                    //$DataCadastro = ($item->getDataCadastro()) ? Formatacao::formatarDataHoraSQL($item->getDataCadastro(), false) : '';
                    $DataCadastro = ($item->getDataInclusao()) ? Formatacao::formatarDataHoraSQL($item->getDataInclusao(), false) : '';
                    
					//Co-Autores
					$autor2 = $item->getAutor2 ();
					$autor3 = $item->getAutor3 ();
					$autor4 = $item->getAutor4 ();
					$autor5 = $item->getAutor5 ();
					$autor6 = $item->getAutor6 ();
					$autor7 = $item->getAutor7 ();
					$autor8 = $item->getAutor8 ();
					$autor9 = $item->getAutor9 ();
					$autor10 = $item->getAutor10 ();
					$arrAutores = array (
							"autores" => array (
									1 => $autor2,
									2 => $autor3,
									3 => $autor4,
									4 => $autor5,
									5 => $autor6,
									6 => $autor7,
									7 => $autor8,
									8 => $autor9,
									9 => $autor10 
							) 
					);
					$linhaAutores='';
					foreach ( $arrAutores ["autores"] as $p_Autores ) {
						if ($p_Autores != '' || $p_Autores != null) {
							$linhaAutores.= trim ( $p_Autores ). "; ";
						}
					}
					$linhaAutores = substr(trim($linhaAutores),0, -1).'.';
					////////////////////Fim Co-Autores
					
					//Instituições
					$Instituicao1 = $item->getInstituicao1 ();
					$Instituicao2 = $item->getInstituicao2 ();
					$Instituicao3 = $item->getInstituicao3 ();
					$Instituicao4 = $item->getInstituicao4 ();
					$Instituicao5 = $item->getInstituicao5 ();
					$Instituicao6 = $item->getInstituicao6 ();
					$Instituicao7 = $item->getInstituicao7 ();
					$Instituicao8 = $item->getInstituicao8 ();
					$Instituicao9 = $item->getInstituicao9 ();
					$Instituicao10 = $item->getInstituicao10 ();
					$arrInstituicao = array (
							"instituicao" => array (
									1 => $Instituicao1,
									2 => $Instituicao2,
									3 => $Instituicao3,
									4 => $Instituicao4,
									5 => $Instituicao5,
									6 => $Instituicao6,
									7 => $Instituicao7,
									8 => $Instituicao8,
									9 => $Instituicao9,
									10 => $Instituicao10 
							) 
					);
					$result = array_unique ( $arrInstituicao ["instituicao"] );
					$linhaInstituicao='';
					foreach ( $result as $p_Instituicao ) {
						if ($p_Instituicao != '' || $p_Instituicao != null) {
							$linhaInstituicao.= trim ( $p_Instituicao ). "; ";
						}
					}
					$linhaInstituicao = substr(trim($linhaInstituicao),0, -1).'.';
					////////////////////Fim Instituições
					
                    $this->response->html.= "<tr style='background-color: $cor;'>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getId()."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".utf8_encode($item->getAutor1())."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".utf8_encode($linhaAutores)."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".utf8_encode($linhaInstituicao)."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".utf8_encode($item->getNomeCompleto())."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".utf8_encode($item->getEmail())."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".utf8_encode($item->getCpf())."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".utf8_encode($item->getPassaporte())."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".utf8_encode($item->getEstado())."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".utf8_encode($item->getPais())."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".substr($item->getDataNascimento(),0, 10)."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getTelefoneContato()."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getCodResumo()."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".utf8_encode(strip_tags($item->getTitulo()))."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".utf8_encode($item->getPalavraChave())."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$this->_arrTipos[$item->getTipo()]."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$DataCadastro."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$this->_arrStatus[$item->getIdStatus()]."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getRevisao()."</td>"
                                            ."</tr>";
                    $i++;
                }
                $this->response->html.= "<tr style='background-color: #ccc;'>"
                                        ."    <td  style='border: 0.5px solid #000000; text-align:right;' colspan='2'> <b>Total de registros</b></td>"
                                        ."    <td  style='border: 0.5px solid #000000; text-align:right;'><b>".$i."</b></td>"
                                        ."</tr>";
                $this->response->sucesso = 1;
            }else{
                $this->response->records = 0;
                if ($DAO->getErro()){
                    $this->response->erro = $DAO->getErro();
                    $this->response->mensagem = $DAO->getMensagem();
                }
            }
            
            $this->response->html.= "</table>";
            
            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
 
    /**
     * Método para comunicar usuário da inscrição (enviar email)
     * 
     * @param int $p_Id Identificador do registro 
     * @param int $p_IdUsuario Identificador do Usuário registro 
     *
     * @return bool Se atualização relizada com sucesso
     */    
    public function comunicar($p_Id=null){

        try {
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            
            $this->response->Id=$Id;
            if ($Id){
                $DAO = new ResumoDAO();
                $obj = $DAO->retorna($Id);
                if ($obj){
                    $uDAO = new InscricaoDAO();
                    $obj1 = $uDAO->retornarPorUsuario($obj->getIdUsuario());
                    if ($obj1){
                        $this->response->IdUsuario = $obj1->getIdUsuario(); 
                        $this->response->Nome = $obj1->getNome(); 
                        $this->response->Email = $obj1->getEmail();
                    }
                    $this->response->query2 = $uDAO->_query;

                    $this->response->Id = $obj->getId();
                    $this->response->Codigo = $obj->getCodResumo();
                    $this->response->Titulo = $obj->getTitulo();
                    $this->response->IdUsuario = $obj->getIdUsuario();
					$IdStatus = $obj->getIdStatus();
                    $this->response->IdStatus = $IdStatus;
                    $this->response->NomeStatus = $this->_arrStatus[$IdStatus];
                    $this->response->TextoStatus = ' ';
                    //$this->response->DataCadastro = ($obj->getDataCadastro()) ? Formatacao::formatarDataHoraSQL($obj->getDataCadastro(), false) : '';
					$this->response->DataCadastro = ($obj->getDataInclusao()) ? Formatacao::formatarDataHoraSQL($obj->getDataInclusao(), false) : '';
                    $this->response->Observacao = $obj->getObservacao();
                    $this->response->Referencia = $obj->getReferencia();
                    $this->response->DataApresentacao = $obj->getDataApresentacao();
                    $this->response->HoraApresentacao = $obj->getHoraApresentacao();
                    $this->response->Bloco = $obj->getBloco();
                    $this->response->Poster = $obj->getPoster();
                    
					if($obj1->getIdPais() == 76){ 
						
						// Email em Português
						$Conteudo = '';
						$this->response->Assunto = "Trabalho: ".$this->response->Referencia." - Status: ".$this->response->NomeStatus;
						if ($IdStatus==2){ // 2 => "Em Analise",
							$this->response->Assunto = "Trabalho em análise – IV International Symposium on Immunobiologicals de Bio-Manguinhos";
							$Conteudo = (file_exists('templates/resumo.em-analise.email.html'))? file_get_contents('templates/resumo.em-analise.email.html'): '';
							
						} else if ($IdStatus==3){   //  3 => "Com Pendencia",
							$this->response->Assunto = "Pendências no trabalho submetido ao IV International Symposium on Immunobiologicals de Bio-Manguinhos";
							$Conteudo = (file_exists('templates/resumo.com-pendencia.email.html'))? file_get_contents('templates/resumo.com-pendencia.email.html'): '';
							
						} else if ($IdStatus==4){   //  4 => "Aprovado para Publicação",
							$this->response->Assunto = "Código: ".$this->response->Referencia." - Trabalho aprovado no IV International Symposium on Immunobiologicals de Bio-Manguinhos";
							$Conteudo = (file_exists('templates/resumo.aprovado.email.html'))? file_get_contents('templates/resumo.aprovado.email.html'): '';
							$this->response->TextoStatus = '( <b>X</b> ) Aprovado somente para Publicação.';
							
						} else if ($IdStatus==5){   //  5 => "Aprovado para Publicação e Exposição",
							$this->response->Assunto = "Código: ".$this->response->Referencia." - Trabalho aprovado no IV International Symposium on Immunobiologicals de Bio-Manguinhos";
							$Conteudo = (file_exists('templates/resumo.aprovado.email.html'))? file_get_contents('templates/resumo.aprovado.email.html'): '';
							$this->response->TextoStatus = '( <b>X</b> ) Aprovado para Publicação e Exposição de Poster.';
							
						} else if ($IdStatus==6){   //   6 => "Aprovado para Publicação, Exposição e Apresentação",
							if ($this->response->Referencia){
								$this->response->Assunto = 'Código: '.$this->response->Referencia." - Trabalho selecionado para apresentação oral em plenária no IV International Symposium on Immunobiologicals de Bio-Manguinhos";
							} else {
								$this->response->Assunto = "Trabalho selecionado para apresentação oral em plenária no IV International Symposium on Immunobiologicals de Bio-Manguinhos";
							}
							$Conteudo = (file_exists('templates/resumo.aprovado.apresentacao.email.html'))? file_get_contents('templates/resumo.aprovado.apresentacao.email.html'): '';
							$this->response->TextoStatus = '( <b>X</b> ) Aprovado para Publicação, Exposição de Poster e Apresentação.';
							
						} else if ($IdStatus==7){   //  7 => "Recusado" 
							$this->response->Assunto = "Trabalho não aceito no IV International Symposium on Immunobiologicals de Bio-Manguinhos";
							$Conteudo = (file_exists('templates/resumo.recusado.email.html'))? file_get_contents('templates/resumo.recusado.email.html'): '';

						} else if ($IdStatus==9){   //  9 => "Com Pendência do NIT" 
							$this->response->Assunto = "Pendências do NIT no trabalho submetido ao IV International Symposium on Immunobiologicals de Bio-Manguinhos";
							$Conteudo = (file_exists('templates/resumo.com-pendencia-nit.email.html'))? file_get_contents('templates/resumo.com-pendencia-nit.email.html'): '';
														

						} else if($IdStatus==8){   //  8 => "Aguardando aprovação do NIT"
									$this->response->Assunto = "Trabalho submetido (com obrigação de aprovação prévia pelo NIT-Bio) – IV International Symposium on Immunobiologicals de Bio-Manguinhos";
									$Conteudo = "";
									$Conteudo .= "Prezado(a) <em>".$obj1->getNome()."</em><br/>";
									$Conteudo .= "<br/>";
									$Conteudo .= "<br/>";
									$Conteudo .= "Seu trabalho com título "."'".$obj->getTitulo()."'"."  foi atualizado com sucesso na base de dados do IV International Symposium on Immunobiologicals de Bio-Manguinhos, ";
									$Conteudo .= "mas, como tem autor(es) de Bio-Manguinhos, será necessária a avaliação e aprovação do NIT-Bio para ser efetivamente cadastrado no sistema. <br/>";
									$Conteudo .= "<br/>";
									$Conteudo .= "Assim que o NIT-Bio aprovar seu resumo pelo sistema, não será mais possível fazer alterações no texto submetido. <br/>";
									$Conteudo .= "<br/>";
									$Conteudo .= "<br/>";
									$Conteudo .= "Atenciosamente,<br/>";
									$Conteudo .= "<br/>";
									$Conteudo .= "<font face='Arial' color='DarkBlue' size=2><b>Núcleo de Inovação Tecnológica</b></font><br/>";
									$Conteudo .= "<font face='Arial' color='Gray' size=2>IV International Symposium on Immunobiologicals</font><br/>";
									$Conteudo .= "<font face='Arial' color='Gray' size=2>Bio-Manguinhos | FIOCRUZ</font><br/>";
									$Conteudo .= "http://isi.bio.fiocruz.br<br/>";
									$Conteudo .= "";	
						}else if($IdStatus==1){   //  1 => "Enviado"
									$this->response->Assunto = "Trabalho submetido - IV International Symposium on Immunobiologicals de Bio-Manguinhos";
									$Conteudo = "";
									$Conteudo .= "Prezado(a) <em>".$obj1->getNome()."</em><br/>";
									$Conteudo .= "<br/>";
									$Conteudo .= "<br/>";
									$Conteudo .= "Seu trabalho com título "."'".$obj->getTitulo()."'"." foi recebido na base de dados do IV International Symposium on Immunobiologicals de Bio-Manguinhos. <br/>";
									$Conteudo .= "<br/>";
									$Conteudo .= "Até o final do prazo de submissões de trabalhos, você ainda poderá fazer alterações no texto submetido, acessando seu cadastro no site http://isi.bio.fiocruz.br/index.php/submissao-resumos-poster <br/>";
									$Conteudo .= "<br/>";
									$Conteudo .= "Atenciosamente,<br/>";
									$Conteudo .= "<br/>";
									$Conteudo .= "<font face='Arial' color='DarkBlue' size=2><b>Comissão Científica e Tecnológica</b></font><br/>";
									$Conteudo .= "<font face='Arial' color='Gray' size=2>IV International Symposium on Immunobiologicals</font><br/>";
									$Conteudo .= "<font face='Arial' color='Gray' size=2>Bio-Manguinhos | FIOCRUZ</font><br/>";
									$Conteudo .= "http://isi.bio.fiocruz.br<br/>";
									$Conteudo .= "";								

						} else {
							$Conteudo = (file_exists('templates/resumo.comunicar.email.html'))? file_get_contents('templates/resumo.comunicar.email.html'): '';
							$Conteudo ='';
						}	
						
						if ($Conteudo!=''){
							$Conteudo = str_replace("{NOME}", $this->response->Nome, $Conteudo);
							$Conteudo = str_replace("{TITULO}", $this->response->Titulo, $Conteudo);
							$Conteudo = str_replace("{MENSAGEM}", $this->response->TextoStatus, $Conteudo);
							if ($this->response->Codigo){ $Conteudo = str_replace("{CODIGO}", $this->response->Codigo, $Conteudo);} else {$Conteudo = str_replace("{CODIGO}", "", $Conteudo);}
							if ($this->response->Referencia){ $Conteudo = str_replace("{REFERENCIA}", 'Código: <b>'.$this->response->Referencia.'</b>, ', $Conteudo);} else {$Conteudo = str_replace("{REFERENCIA}", "", $Conteudo);}
							if ($this->response->DataApresentacao){ $Conteudo = str_replace("{DATA-APRESENTACAO}", 'Dia: <b>'.$this->response->DataApresentacao.'</b><br/>'.'Hora: <b>'.$this->response->HoraApresentacao.'</b> <br/>', $Conteudo);} else {$Conteudo = str_replace("{DATA-APRESENTACAO}", "", $Conteudo);}
							if ($this->response->Bloco){ $Conteudo = str_replace("{BLOCO}", '<b>'.$this->response->Bloco.'</b> ', $Conteudo);} else {$Conteudo = str_replace("{BLOCO}", "", $Conteudo);}
							if ($this->response->Poster){ $Conteudo = str_replace("{POSTER}", 'Poster: <b>'.$this->response->Poster.'</b> <br/>', $Conteudo);} else {$Conteudo = str_replace("{POSTER}", "", $Conteudo);}
							if ($this->response->NomeStatus){ $Conteudo = str_replace("{STATUS}", $this->response->NomeStatus, $Conteudo);} else {$Conteudo = str_replace("{STATUS}", "", $Conteudo);}
							$obs = "";
							if ($this->response->Observacao) { $obs = str_replace("\n", "<br>", $this->response->Observacao); } //recurso criado exibir parágrafos no corpo email
							if ($this->response->Observacao){ $Conteudo = str_replace("{OBSERVACAO}", $obs, $Conteudo);} else {$Conteudo = str_replace("{OBSERVACAO}", "", $Conteudo);}
						}									
			
					}else { //email em Inglês
						$Conteudo = '';
						$this->response->Assunto = "Word: ".$this->response->Referencia." - Status: ".$this->response->NomeStatus;
						if ($IdStatus==2){ // 2 => "Em Analise",
							$this->response->Assunto = "Work under analysis - IV International Symposium on Immunobiologicals of Bio-Manguinhos";
							$Conteudo = (file_exists('templates/abstract.analysis.email.html'))? file_get_contents('templates/abstract.analysis.email.html'): '';
							
						} else if ($IdStatus==3){   //  3 => "Com Pendencia",
							$this->response->Assunto = "Issues in the work submitted to the IV International Symposium on Immunobiologicals of Bio-Manguinhos";
							$Conteudo = (file_exists('templates/abstract.pendency.email.html'))? file_get_contents('templates/abstract.pendency.email.html'): '';
							
						} else if ($IdStatus==4){   //  4 => "Aprovado para Publicação",
							$this->response->Assunto = "Code: ".$this->response->Referencia." - Work approved at the IV International Symposium on Immunobiologicals of Bio-Manguinhos";
							$Conteudo = (file_exists('templates/abstract.approved.email.html'))? file_get_contents('templates/abstract.approved.email.html'): '';
							$this->response->TextoStatus = '( <b>X</b> ) Aprovado somente para Publicação.';
							
						} else if ($IdStatus==5){   //  5 => "Aprovado para Publicação e Exposição",
							$this->response->Assunto = "Code: ".$this->response->Referencia." - Work approved at the IV International Symposium on Immunobiologicals of Bio-Manguinhos";
							$Conteudo = (file_exists('templates/abstract.approved.email.html'))? file_get_contents('templates/abstract.approved.email.html'): '';
							$this->response->TextoStatus = '( <b>X</b> ) Approved for Poster Publication and Exhibition.';
							
						} else if ($IdStatus==6){   //   6 => "Aprovado para Publicação, Exposição e Apresentação",
							if ($this->response->Referencia){
								$this->response->Assunto = 'Code: '.$this->response->Referencia." - Selected work for oral presentation in plenary at the IV International Symposium on Immunobiologicals of Bio-Manguinhos";
							} else {
								$this->response->Assunto = "Selected work for oral presentation in plenary at IV International Symposium on Immunobiologicals of Bio-Manguinhos";
							}
							$Conteudo = (file_exists('templates/abstract.approved.presentation.email.html'))? file_get_contents('templates/abstract.approved.presentation.email.html'): '';
							$this->response->TextoStatus = '( <b>X</b> ) Approved for Publication, Poster Exhibition and Presentation.';
							
						} else if ($IdStatus==7){   //  7 => "Recusado" 
							$this->response->Assunto = "Work not accepted in IV International Symposium on Immunobiologicals of Bio-Manguinhos";
							$Conteudo = (file_exists('templates/abstract.refused.email.html'))? file_get_contents('templates/abstract.refused.email.html'): '';

						} else if ($IdStatus==9){   //  9 => "Com Pendência do NIT" 
							$this->response->Assunto = "Pending the NIT in the work submitted to the IV International Symposium on Immunobiologicals of Bio-Manguinhos";
							$Conteudo = (file_exists('templates/abstract.pendency-nit.email.html'))? file_get_contents('templates/abstract.pendency-nit.email.html'): '';


						} else if($IdStatus==8){   //  8 => "Aguardando aprovação do NIT"
							$this->response->Assunto = "Work submitted (with prior approval by NIT-Bio) – IV International Symposium on Immunobiologicals of Bio-Manguinhos, ";
							$Conteudo = "";
							$Conteudo .= "Dear  <em>".$obj1->getNome()."</em><br/>";
							$Conteudo .= "<br/>";
							$Conteudo .= "<br/>";
							$Conteudo .= "Your abstract "."'".$obj->getTitulo()."'"."  was received in our database and, but, as it has at least one co-author that has any kind of contractual linkage to Bio-Manguinhos, ";
							$Conteudo .= "it must be assessed by the Bio-Manguinhos’ Technological Innovation Advisory (NIT-Bio) in order to complete the submission. <br/>";
							$Conteudo .= "<br/>";
							$Conteudo .= "As soon as you receive a positive feedback from the NIT-Bio, you won’t be able to make any changes on the text and it will be forwarded to evaluation by the ";
							$Conteudo .= "Scientific and Technological Committee of the IV International Symposium. <br/><br/>";
							$Conteudo .= "<br/>";
							$Conteudo .= "<br/>";
							$Conteudo .= "Sincerely yours,<br/>";
							$Conteudo .= "<br/>";
							$Conteudo .= "<font face='Arial' color='DarkBlue' size=2><b>Technology Transfer Office</b></font><br/>";
							$Conteudo .= "<font face='Arial' color='Gray' size=2>IV International Symposium on Immunobiologicals</font><br/>";
							$Conteudo .= "<font face='Arial' color='Gray' size=2>Bio-Manguinhos | FIOCRUZ</font><br/>";
							$Conteudo .= "http://isi.bio.fiocruz.br<br/>";
							$Conteudo .= "";						
						
						}else if($IdStatus==1){   //  1 => "Enviado"
							$this->response->Assunto = "Work submitted - IV International Symposium on Immunobiologicals of Bio-Manguinhos";
							$Conteudo = "";
							$Conteudo .= "Dear  <em>".$obj1->getNome()."</em><br/>";
							$Conteudo .= "<br/>";
							$Conteudo .= "<br/>";
							$Conteudo .= "Your abstract with the title "."'".$obj->getTitulo()."'"." was received at the IV International Symposium on Immunobiologicals database. <br/>";
							$Conteudo .= "<br/>";
							$Conteudo .= "Until the end of the submissions period, you still can make changes in the text, by accessing you account at https://isi.bio.fiocruz.br/index.php/en/submissions-of-abstracts-and-posters <br/>";
							$Conteudo .= "<br/>";
							$Conteudo .= "Best regards,<br/>";
							$Conteudo .= "<br/>";
							$Conteudo .= "<font face='Arial' color='DarkBlue' size=2><b>Scientific and Technological Committee</b></font><br/>";
							$Conteudo .= "<font face='Arial' color='Gray' size=2>IV International Symposium on Immunobiologicals</font><br/>";
							$Conteudo .= "<font face='Arial' color='Gray' size=2>Bio-Manguinhos | FIOCRUZ</font><br/>";
							$Conteudo .= "http://isi.bio.fiocruz.br<br/>";
							$Conteudo .= "";	

						} else {
							$Conteudo = (file_exists('templates/abstract.communicate.email.html'))? file_get_contents('templates/abstract.communicate.email.html'): '';
							$Conteudo ='';
						}
						
						if ($Conteudo!=''){
							$Conteudo = str_replace("{NOME}", $this->response->Nome, $Conteudo);
							$Conteudo = str_replace("{TITULO}", $this->response->Titulo, $Conteudo);
							$Conteudo = str_replace("{MENSAGEM}", $this->response->TextoStatus, $Conteudo);
							if ($this->response->Codigo){ $Conteudo = str_replace("{CODIGO}", $this->response->Codigo, $Conteudo);} else {$Conteudo = str_replace("{CODIGO}", "", $Conteudo);}
							if ($this->response->Referencia){ $Conteudo = str_replace("{REFERENCIA}", 'Code: <b>'.$this->response->Referencia.'</b>, ', $Conteudo);} else {$Conteudo = str_replace("{REFERENCIA}", "", $Conteudo);}
							if ($this->response->DataApresentacao){ $Conteudo = str_replace("{DATA-APRESENTACAO}", 'Day: <b>'.$this->response->DataApresentacao.'</b><br/>'.'Hour: <b>'.$this->response->HoraApresentacao.'</b> <br/>', $Conteudo);} else {$Conteudo = str_replace("{DATA-APRESENTACAO}", "", $Conteudo);}
							if ($this->response->Bloco){ $Conteudo = str_replace("{BLOCO}", '<b>'.$this->response->Bloco.'</b> ', $Conteudo);} else {$Conteudo = str_replace("{BLOCO}", "", $Conteudo);}
							if ($this->response->Poster){ $Conteudo = str_replace("{POSTER}", 'Poster: <b>'.$this->response->Poster.'</b> <br/>', $Conteudo);} else {$Conteudo = str_replace("{POSTER}", "", $Conteudo);}
							if ($this->response->NomeStatus){ $Conteudo = str_replace("{STATUS}", $this->response->NomeStatus, $Conteudo);} else {$Conteudo = str_replace("{STATUS}", "", $Conteudo);}
							$obs = "";
							if ($this->response->Observacao) { $obs = str_replace("\n", "<br>", $this->response->Observacao); } //recurso criado exibir parágrafos no corpo email
							if ($this->response->Observacao){ $Conteudo = str_replace("{OBSERVACAO}", $obs, $Conteudo);} else {$Conteudo = str_replace("{OBSERVACAO}", "", $Conteudo);}
						}								

					}
					
					// Enviar Email;
					if ($Conteudo!=''){
						if (($IdStatus==9) || ($IdStatus==2) || ($IdStatus==7) || ($IdStatus==8)){
							if (Email::enviar($this->response->Nome, $this->response->Email, 'isi@bio.fiocruz.br; Livia.faria@bio.fiocruz.br; katia.reis@bio.fiocruz.br', $this->response->Assunto, $Conteudo)){
								$this->response->sucesso = 1;
								$this->response->erro = 0;
								$this->response->mensagem .= "<br/>Um mensagem foi enviado com sucesso para <b>".$this->response->Nome."</b> <em>(".$this->response->Email.")</em>.";
							} else {
								$this->response->erro = 243;
								$this->response->mensagem = "<br/>Erro ao enviar comunicado para <b>".$this->response->Nome."</b> <em>(".$this->response->Email.")</em>.";
								$this->response->mensagem .= "[".Email::getErro()." - ".Email::getMensagem()."]";
							}							
						} else{
							if (Email::enviar($this->response->Nome, $this->response->Email, 'isi@bio.fiocruz.br', $this->response->Assunto, $Conteudo)){
								$this->response->sucesso = 1;
								$this->response->erro = 0;
								$this->response->mensagem .= "<br/>Um mensagem foi enviado com sucesso para <b>".$this->response->Nome."</b> <em>(".$this->response->Email.")</em>.";
							} else {
								$this->response->erro = 243;
								$this->response->mensagem = "<br/>Erro ao enviar comunicado para <b>".$this->response->Nome."</b> <em>(".$this->response->Email.")</em>.";
								$this->response->mensagem .= "[".Email::getErro()." - ".Email::getMensagem()."]";
							}								
						}

					} else {
						$this->response->mensagem .= "<br/>Alerta: Não existe template de email para esta operação.";
					}
                        
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro com id: '$Id'.";
                }
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
                $DAO->Close();
            } else {
                $this->response->mensagem = "O identificador do registro é um parametro obrigatório.";
            }
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);	
	
    }
    
    /**
     *  Método para alterarStatus um registro
     *
     * @return bool Se atualização relizada com sucesso
     */    
    public function alterarStatus() {
        try {
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            $Codigo = self::getVar('Codigo');
            $Chave = self::getVar('Chave');
            $IdStatus = self::getVar('IdStatus', FILTER_SANITIZE_NUMBER_INT);
            $Observacao = self::getVar('Observacao');
            $Referencia = self::getVar('Referencia');
            $Bloco = self::getVar('Bloco');
            $Poster = self::getVar('Poster');
            $DataApresentacao = self::getVar('DataApresentacao');
            $HoraApresentacao = self::getVar('HoraApresentacao');
            
            // Criticar campos
            if(!$IdStatus) {
                $this->response->mensagem = "O campo <b>IdStatus</b> é de preenchimento obrigatório.";
                return false;
            }
            
            if ( ($IdStatus==3) || ($IdStatus==7) || ($IdStatus==9) ) {  //Com Pendência, Recusado, Com Pendência do NIT
                if(!$Observacao){
                    $this->response->mensagem = "O campo <b>Observação</b> é de preenchimento obrigatório.";
                    return false;
                }
            }
            $dtApresentacao = null;
            if($DataApresentacao) {
                if (!Validacao::validarData($DataApresentacao)){
                    $this->response->DataApresentacao = $DataApresentacao;
                    $this->response->mensagem = "Erro: O campo <b>Data Apresentacao</b> está com valor inválido. (Formato: dd/mm/yyyy)";
                    return false;
                }
                // Preparar Campos
                $HoraApresentacao = (strpos($HoraApresentacao, ':')!==false)? $HoraApresentacao.':00': '00:00:00';
                $dtApresentacao = Formatacao::formatarDataSQL($DataApresentacao).' '.$HoraApresentacao;
            }
            
            $this->response->Id=$Id;
            if ($Id){
                $DAO = new ResumoDAO();
                $obj = $DAO->retorna($Id);
                if ($obj){
                    $uDAO = new InscricaoDAO();
                    $obj1 = $uDAO->retornarPorUsuario($obj->getIdUsuario());
                    if ($obj1){
                        $this->response->IdUsuario = $obj1->getIdUsuario(); 
                        $this->response->Nome = $obj1->getNome(); 
                        $this->response->Email = $obj1->getEmail();
                    }
                    $this->response->query2 = $uDAO->_query;

                    $this->response->Id = $obj->getId();
                    $this->response->Codigo = $obj->getCodResumo();
                    $this->response->Titulo = $obj->getTitulo();
                    $this->response->IdUsuario = $obj->getIdUsuario();
                    $this->response->IdStatus = $IdStatus;
                    $this->response->NomeStatus = $this->_arrStatus[$IdStatus];
                    $this->response->TextoStatus = ' ';
                    //$this->response->DataCadastro = ($obj->getDataCadastro()) ? Formatacao::formatarDataHoraSQL($obj->getDataCadastro(), false) : '';
					$this->response->DataCadastro = ($obj->getDataInclusao()) ? Formatacao::formatarDataHoraSQL($obj->getDataInclusao(), false) : '';
                    $this->response->Observacao = $Observacao;
                    $this->response->Referencia = $Referencia;
                    $this->response->DataApresentacao = $DataApresentacao;
                    $this->response->HoraApresentacao = $HoraApresentacao;
                    $this->response->Bloco = $Bloco;
                    $this->response->Poster = $Poster;
                    
                    if ($DAO->alterarStatus($Id, $IdStatus, $Observacao, $Referencia, $dtApresentacao, $HoraApresentacao, $Bloco, $Poster)){
						
                        $this->response->sucesso = 1;
                        $this->response->mensagem = "Resumo foi atualizado com sucesso.(".$this->response->Id.")";
                        
						if($obj1->getIdPais() == 76){
							
							// Email em Português
							$Conteudo = '';
							$this->response->Assunto = "Trabalho: ".$this->response->Referencia." - Status: ".$this->response->NomeStatus;
							if ($IdStatus==2){ // 2 => "Em Analise",
								$this->response->Assunto = "Trabalho em análise – V International Symposium on Immunobiologicals de Bio-Manguinhos";
								$Conteudo = (file_exists('templates/resumo.em-analise.email.html'))? file_get_contents('templates/resumo.em-analise.email.html'): '';
								
							} else if ($IdStatus==3){   //  3 => "Com Pendencia",
								$this->response->Assunto = "Pendências no trabalho submetido ao V International Symposium on Immunobiologicals de Bio-Manguinhos";
								$Conteudo = (file_exists('templates/resumo.com-pendencia.email.html'))? file_get_contents('templates/resumo.com-pendencia.email.html'): '';
								
							} else if ($IdStatus==4){   //  4 => "Aprovado para Publicação",
								$this->response->Assunto = "Código: ".$this->response->Referencia." - Trabalho aprovado no V International Symposium on Immunobiologicals de Bio-Manguinhos";
								$Conteudo = (file_exists('templates/resumo.aprovado.email.html'))? file_get_contents('templates/resumo.aprovado.email.html'): '';
								$this->response->TextoStatus = '( <b>X</b> ) Aprovado somente para Publicação.';
								
							} else if ($IdStatus==5){   //  5 => "Aprovado para Publicação e Exposição",
								$this->response->Assunto = "Código: ".$this->response->Referencia." - Trabalho aprovado no V International Symposium on Immunobiologicals de Bio-Manguinhos";
								$Conteudo = (file_exists('templates/resumo.aprovado.email.html'))? file_get_contents('templates/resumo.aprovado.email.html'): '';
								$this->response->TextoStatus = '( <b>X</b> ) Aprovado para Publicação e Exposição de Poster.';
								
							} else if ($IdStatus==6){   //   6 => "Aprovado para Publicação, Exposição e Apresentação",
								if ($this->response->Referencia){
									$this->response->Assunto = 'Código: '.$this->response->Referencia." - Trabalho selecionado para apresentação oral em plenária no V International Symposium on Immunobiologicals de Bio-Manguinhos";
								} else {
									$this->response->Assunto = "Trabalho selecionado para apresentação oral em plenária no V International Symposium on Immunobiologicals de Bio-Manguinhos";
								}
								$Conteudo = (file_exists('templates/resumo.aprovado.apresentacao.email.html'))? file_get_contents('templates/resumo.aprovado.apresentacao.email.html'): '';
								$this->response->TextoStatus = '( <b>X</b> ) Aprovado para Publicação, Exposição de Poster e Apresentação.';
								
							} else if ($IdStatus==7){   //  7 => "Recusado" 
								$this->response->Assunto = "Trabalho não aceito no V International Symposium on Immunobiologicals de Bio-Manguinhos";
								$Conteudo = (file_exists('templates/resumo.recusado.email.html'))? file_get_contents('templates/resumo.recusado.email.html'): '';

							} else if ($IdStatus==9){   //  9 => "Com Pendência do NIT" 
								$this->response->Assunto = "Pendências do NIT no trabalho submetido ao V International Symposium on Immunobiologicals de Bio-Manguinhos";
								$Conteudo = (file_exists('templates/resumo.com-pendencia-nit.email.html'))? file_get_contents('templates/resumo.com-pendencia-nit.email.html'): '';
															
							} else {
								$Conteudo = (file_exists('templates/resumo.comunicar.email.html'))? file_get_contents('templates/resumo.comunicar.email.html'): '';
								$Conteudo ='';
							}

							if ($Conteudo!=''){
								$Conteudo = str_replace("{NOME}", $this->response->Nome, $Conteudo);
								$Conteudo = str_replace("{TITULO}", $this->response->Titulo, $Conteudo);
								$Conteudo = str_replace("{MENSAGEM}", $this->response->TextoStatus, $Conteudo);
								if ($this->response->Codigo){ $Conteudo = str_replace("{CODIGO}", $this->response->Codigo, $Conteudo);} else {$Conteudo = str_replace("{CODIGO}", "", $Conteudo);}
								if ($this->response->Referencia){ $Conteudo = str_replace("{REFERENCIA}", 'Código: <b>'.$this->response->Referencia.'</b>, ', $Conteudo);} else {$Conteudo = str_replace("{REFERENCIA}", "", $Conteudo);}
								if ($this->response->DataApresentacao){ $Conteudo = str_replace("{DATA-APRESENTACAO}", 'Dia: <b>'.$this->response->DataApresentacao.'</b><br/>'.'Hora: <b>'.$this->response->HoraApresentacao.'</b> <br/>', $Conteudo);} else {$Conteudo = str_replace("{DATA-APRESENTACAO}", "", $Conteudo);}
								if ($this->response->Bloco){ $Conteudo = str_replace("{BLOCO}", '<b>'.$this->response->Bloco.'</b> ', $Conteudo);} else {$Conteudo = str_replace("{BLOCO}", "", $Conteudo);}
								if ($this->response->Poster){ $Conteudo = str_replace("{POSTER}", 'Poster: <b>'.$this->response->Poster.'</b> <br/>', $Conteudo);} else {$Conteudo = str_replace("{POSTER}", "", $Conteudo);}
								if ($this->response->NomeStatus){ $Conteudo = str_replace("{STATUS}", $this->response->NomeStatus, $Conteudo);} else {$Conteudo = str_replace("{STATUS}", "", $Conteudo);}
								$obs = "";
								if ($this->response->Observacao) { $obs = str_replace("\n", "<br>", $this->response->Observacao); } //recurso criado exibir parágrafos no corpo email
								if ($this->response->Observacao){ $Conteudo = str_replace("{OBSERVACAO}", $obs, $Conteudo);} else {$Conteudo = str_replace("{OBSERVACAO}", "", $Conteudo);}
                            }
							
				
						}else { //email em Inglês
							$Conteudo = '';
							$this->response->Assunto = "Word: ".$this->response->Referencia." - Status: ".$this->response->NomeStatus;
							if ($IdStatus==2){ // 2 => "Em Analise",
								$this->response->Assunto = "Work under analysis - V International Symposium on Immunobiologicals of Bio-Manguinhos";
								$Conteudo = (file_exists('templates/abstract.analysis.email.html'))? file_get_contents('templates/abstract.analysis.email.html'): '';
								
							} else if ($IdStatus==3){   //  3 => "Com Pendencia",
								$this->response->Assunto = "Issues in the work submitted to the V International Symposium on Immunobiologicals of Bio-Manguinhos";
								$Conteudo = (file_exists('templates/abstract.pendency.email.html'))? file_get_contents('templates/abstract.pendency.email.html'): '';
								
							} else if ($IdStatus==4){   //  4 => "Aprovado para Publicação",
								$this->response->Assunto = "Código: ".$this->response->Referencia." - Trabalho aprovado no V International Symposium on Immunobiologicals of Bio-Manguinhos";
								$Conteudo = (file_exists('templates/abstract.approved.email.html'))? file_get_contents('templates/abstract.approved.email.html'): '';
								$this->response->TextoStatus = '( <b>X</b> ) Aprovado somente para Publicação.';
								
							} else if ($IdStatus==5){   //  5 => "Aprovado para Publicação e Exposição",
								$this->response->Assunto = "Code: ".$this->response->Referencia." - Work approved at the V International Symposium on Immunobiologicals of Bio-Manguinhos";
								$Conteudo = (file_exists('templates/abstract.approved.email.html'))? file_get_contents('templates/abstract.approved.email.html'): '';
								$this->response->TextoStatus = '( <b>X</b> ) Approved for Poster Publication and Exhibition.';
								
							} else if ($IdStatus==6){   //   6 => "Aprovado para Publicação, Exposição e Apresentação",
								if ($this->response->Referencia){
									$this->response->Assunto = 'Code: '.$this->response->Referencia." - Selected work for oral presentation in plenary at the V International Symposium on Immunobiologicals of Bio-Manguinhos";
								} else {
									$this->response->Assunto = "Selected work for oral presentation in plenary at V International Symposium on Immunobiologicals of Bio-Manguinhos";
								}
								$Conteudo = (file_exists('templates/abstract.approved.presentation.email.html'))? file_get_contents('templates/abstract.approved.presentation.email.html'): '';
								$this->response->TextoStatus = '( <b>X</b> ) Approved for Publication, Poster Exhibition and Presentation.';
								
							} else if ($IdStatus==7){   //  7 => "Recusado" 
								$this->response->Assunto = "Work not accepted in V International Symposium on Immunobiologicals of Bio-Manguinhos";
								$Conteudo = (file_exists('templates/abstract.refused.email.html'))? file_get_contents('templates/abstract.refused.email.html'): '';

							} else if ($IdStatus==9){   //  9 => "Com Pendência do NIT" 
								$this->response->Assunto = "Pending the NIT in the work submitted to the V International Symposium on Immunobiologicals of Bio-Manguinhos";
								$Conteudo = (file_exists('templates/abstract.pendency-nit.email.html'))? file_get_contents('templates/abstract.pendency-nit.email.html'): '';
															
							} else {
								$Conteudo = (file_exists('templates/abstract.communicate.email.html'))? file_get_contents('templates/abstract.communicate.email.html'): '';
								$Conteudo ='';
							}

							if ($Conteudo!=''){
								$Conteudo = str_replace("{NOME}", $this->response->Nome, $Conteudo);
								$Conteudo = str_replace("{TITULO}", $this->response->Titulo, $Conteudo);
								$Conteudo = str_replace("{MENSAGEM}", $this->response->TextoStatus, $Conteudo);
								if ($this->response->Codigo){ $Conteudo = str_replace("{CODIGO}", $this->response->Codigo, $Conteudo);} else {$Conteudo = str_replace("{CODIGO}", "", $Conteudo);}
								if ($this->response->Referencia){ $Conteudo = str_replace("{REFERENCIA}", 'Code: <b>'.$this->response->Referencia.'</b>, ', $Conteudo);} else {$Conteudo = str_replace("{REFERENCIA}", "", $Conteudo);}
								if ($this->response->DataApresentacao){ $Conteudo = str_replace("{DATA-APRESENTACAO}", 'Day: <b>'.$this->response->DataApresentacao.'</b><br/>'.'Hour: <b>'.$this->response->HoraApresentacao.'</b> <br/>', $Conteudo);} else {$Conteudo = str_replace("{DATA-APRESENTACAO}", "", $Conteudo);}
								if ($this->response->Bloco){ $Conteudo = str_replace("{BLOCO}", '<b>'.$this->response->Bloco.'</b> ', $Conteudo);} else {$Conteudo = str_replace("{BLOCO}", "", $Conteudo);}
								if ($this->response->Poster){ $Conteudo = str_replace("{POSTER}", 'Poster: <b>'.$this->response->Poster.'</b> <br/>', $Conteudo);} else {$Conteudo = str_replace("{POSTER}", "", $Conteudo);}
								if ($this->response->NomeStatus){ $Conteudo = str_replace("{STATUS}", $this->response->NomeStatus, $Conteudo);} else {$Conteudo = str_replace("{STATUS}", "", $Conteudo);}
								$obs = "";
								if ($this->response->Observacao) { $obs = str_replace("\n", "<br>", $this->response->Observacao); } //recurso criado exibir parágrafos no corpo email
								if ($this->response->Observacao){ $Conteudo = str_replace("{OBSERVACAO}", $obs, $Conteudo);} else {$Conteudo = str_replace("{OBSERVACAO}", "", $Conteudo);}
                            }	
						}
                        
                        // Enviar Email;
                        if ($Conteudo!=''){   
							if (($IdStatus==9) || ($IdStatus==2) || ($IdStatus==7)){
								if (Email::enviar($this->response->Nome, $this->response->Email, 'isi@bio.fiocruz.br; Livia.faria@bio.fiocruz.br; katia.reis@bio.fiocruz.br', $this->response->Assunto, $Conteudo)){
									$this->response->sucesso = 1;
									$this->response->erro = 0;
									$this->response->mensagem .= "<br/>Um mensagem foi enviado com sucesso para <b>".$this->response->Nome."</b> <em>(".$this->response->Email.")</em>.";
								} else {
									$this->response->erro = 243;
									$this->response->mensagem = "<br/>Erro ao enviar comunicado para <b>".$this->response->Nome."</b> <em>(".$this->response->Email.")</em>.";
									$this->response->mensagem .= "[".Email::getErro()." - ".Email::getMensagem()."]";
								}															
							} else{
								if (Email::enviar($this->response->Nome, $this->response->Email, 'isi@bio.fiocruz.br', $this->response->Assunto, $Conteudo)){
									$this->response->sucesso = 1;
									$this->response->erro = 0;
									$this->response->mensagem .= "<br/>Um mensagem foi enviado com sucesso para <b>".$this->response->Nome."</b> <em>(".$this->response->Email.")</em>.";
								} else {
									$this->response->erro = 243;
									$this->response->mensagem = "<br/>Erro ao enviar comunicado para <b>".$this->response->Nome."</b> <em>(".$this->response->Email.")</em>.";
									$this->response->mensagem .= "[".Email::getErro()." - ".Email::getMensagem()."]";
								}	
							}
                        } else {
                            $this->response->mensagem .= "<br/>Alerta: Não existe template de email para esta operação.";
                        }
                        
                    } else {
                        $this->response->mensagem = $DAO->getMensagem();
                    }
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro com id: '$Id'.";
                }
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
                $DAO->Close();
            } else {
                $this->response->mensagem = "O identificador do registro é um parametro obrigatório.";
            }
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
        
    }
	

    
}