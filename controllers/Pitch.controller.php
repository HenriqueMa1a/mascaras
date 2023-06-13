<?php

require_once ('models/PessoaDAO.class.php');
require_once ('models/EventoDAO.class.php');
require_once ('models/Evento.class.php');
require_once ('assets/Email.class.php');
require_once ('assets/UUID.class.php');
require_once ('includes/global.joomla.php');
require_once ('modelo/PitchDAO.class.php');
require_once ('modelo/Pitch.class.php');
require_once ('models/InscricaoDAO.class.php');

/**
 *  Controle responsável pela módulo Pitch. 
 * 
 */
class PitchController extends Controller{ 
    
    /**
     * Contrutor da Classe
     *
     * @return void
     */    
    public function __construct(){
        parent::__construct('pitch');
    }
	
    private $_arrStatus = array (
			"" => "-",
			0 => "-",
			1 => "Em Edicao",
			2 => "Submetido",
			3 => "Aprovado",
			4 => "Reprovado"
	);  

	private $_arrFases = array (
			"" => "-",
			0 => "-",
			1 => "É apenas uma ideia?",
			2 => "Já possui um protótipo/piloto/produto mínimo viável (MVP)?",
			3 => "O produto/serviço já foi validado?",
			4 => "A solução já está sendo comercializada?"
	);	
	

    /**
     *  Método para atualizar o telefone de contato do Representante do Pitch
     *
     */    
    public function atualizarContato() {
        try {	
            $Id = self::getVar('Id');
            $Telefone = self::getVar('Telefone');
			$Campo = self::getVar('Campo');
        
            $DAO = new PessoaDAO();
			$obj = $DAO->retornar($Id);

            if ($obj) {
				if($DAO->atualizarCampo($Id, $Campo, $Telefone)){
					$this->response->sucesso=1;
					$this->response->mensagem = "Atualização realizada com sucesso.";
				} else{
					$this->response->mensagem = "Erro ao atualizar registro.";
				}
            }else{
                $this->response->mensagem = "Erro ao localizar o registro com id: '$Id'.";
            }
            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    } 
	
	
    /**
     *  Método para Listar os registros de Pitch
     *
     */    
    public function listar() {
		$IdUsuario = isset ( $_GET ['IdUsuario'] ) ? limpa_sql_injection ( trim ( ($_GET ['IdUsuario']) ) ) : '';
		$IdStatus = isset ( $_GET ['IdStatus'] ) ? limpa_sql_injection ( trim ( ($_GET ['IdStatus']) ) ) : '';
		$Titulo = isset ( $_GET ['Titulo'] ) ? limpa_sql_injection ( trim ( ($_GET ['Titulo']) ) ) : '';
		if ($sidx == 'NomeUsuario')
			$sidx = 'id_usuario';
		//$ano = date("Y");
		//A busca será pelo Evento Principal 
		$DAOEvento = new EventoDAO();
		$objEvento = new Evento();
		$objEvento = $DAOEvento->retornarEventoPrincipalAtivo();
		$IdEvento = $objEvento->getIdEvento();			
		$DAOEvento->Close();
		/**/		
		
		try {
			$response->IdUsuario = $IdUsuario;
			$DAO = new PitchDAO ();
			$listagem = $DAO->lista ( $page, $rows, $sidx, $sord, $IdEvento, $IdUsuario, null, $Titulo, null, $IdStatus );
			
			if ($listagem) {
				$response->page = 1;
				$response->total = 1;
				$response->records = count ( $listagem );
				
				$i = 0;
				foreach ( $listagem as $item ) {
					$DataAcao = Formatacao::formatarDataHoraSQL ( $item->getDataAcao(), false );
					
					$Fases = array (
							"" => "-",
							0 => "-",
							1 => "É apenas uma ideia?",
							2 => "Já possui um protótipo/piloto/produto mínimo viável (MVP)?",
							3 => "O produto/serviço já foi validado?",
							4 => "A solução já está sendo comercializada?"
					);
					$FaseDescricao = $Fases [$item->getFase()];
					
					$arrStatus = array (
							"" => "-",
							0 => "-",
							1 => "Em Edicao",
							2 => "Submetido",
							3 => "Aprovado",
							4 => "Reprovado"
					);
					$StatusDescricao = $arrStatus [$item->getStatus()];
					$Titulo = utf8_encode ( strip_tags ( $item->getDescricao() ) );
					
					
					$response->rows [$i] ['id'] = $i + 1;
					$response->rows [$i] ['cell'] = array (
							$item->getId (),  //0
							$item->getIdParticipante (),  //1
							$item->getTipoSolucao (), //2
							utf8_encode ( trim ($item->getDescricao () ) ), //3
							utf8_encode ( $StatusDescricao ),   //4
							$item->getStatus (), //5
							$item->getDataAcao () //6

					);
					
					$i ++;

				}

				$response->sucesso = 1;	

			} else { 
				
				$response->page = 0;
				$response->total = 0;
				$response->records = 0;
			}

			if(ob_get_length()>0){ob_end_clean();}
			$response->final = date('Y-m-d H:i:s').' '.microtime(true);
			exit(json_encode($response));

		} catch ( PDOException $ex ) {
			echo utf8_encode ( $ex->getMessage () );
		}
	}			

    /**
     *  Método para Listar os registros de Pitch
     *
     */    
    public function listarCadastro() {	
		
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
            
			$EventoPrincipal = self::getVar('EventoPrincipal');	
            $Titulo = self::getVar('Titulo');
            $Nome = self::getVar('Nome');
            $IdUsuario = self::getVar('IdUsuario');			
            $IdTipo = self::getVar('IdTipo');
            $IdStatus = self::getVar('IdStatus');	

			$DAO = new PitchDAO();		
            $listagem = $DAO->lista($page, $rows, $sidx, $sord, $EventoPrincipal, $IdUsuario, $IdTipo, $Titulo, $Nome, $IdStatus);
			
            if ($listagem) { 
                $this->response->page = ($DAO->getPaginaAtual()) ? $DAO->getPaginaAtual(): 1; // 1; 
                $this->response->total = ($DAO->getTotalPaginas()) ? $DAO->getTotalPaginas(): 1; // 1; 
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem); // count($listagem);
                $i = 0;
                foreach ($listagem as $item){ 
                    $bt_view = '<a class="btn btn-vazio btn-sm btn-grid" title="Visualizar registro." onclick="visualizar('.$item->getId().');"><span class="glyphicon glyphicon-search"></span>';
                    $bt_acoes = '<a class="btn btn-vazio btn-sm btn-grid" title="Visualizar impressão do Pitch." onclick="visualizarImpressao('.$item->getId().');"><span class="fa fa-file-pdf-o red"></span>';
                    $DataInclusao = Formatacao::formatarDataHoraSQL ($item->getDataAcao(), false);				
					$Email = '<span class="label label-default">'.$item->getEmail().'</span>';
					$Telefone = '&nbsp;&nbsp;<span class="label label-default">'.$item->getTelefone().'</span>';
					
					$status = '';

                    if($item->getStatus()==1){
                        $status = '<span class="label label-warning">'.$this->_arrStatus[$item->getStatus()].'</span>';
                    } else if($item->getStatus()==2){
                        $status = '<span class="label label-primary">'.$this->_arrStatus[$item->getStatus()].'</span>';
                    } else if($item->getStatus()==3){
                        $status = '<span class="label label-success">'.$this->_arrStatus[$item->getStatus()].'</span>';
                    } else if($item->getStatus()==4){
                        $status = '<span class="label label-danger">'.$this->_arrStatus[$item->getStatus()].'</span>';
                    } 			
					
                    $this->response->aaData[$i] = array($bt_view, $bt_acoes, $item->getId(), utf8_encode($item->getNomeCompleto().'<br/>'.$Email.$Telefone), $item->getTipoSolucao(), utf8_encode(strip_tags($item->getDescricao())), $DataInclusao, $status, $item->getRevisao() );
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
     *  Método para submeter o Pitch alterando o status do mesmo
     *
     */    
    public function submeterPitch() {
        try {	
            $Id = self::getVar('Id');
        
            $DAO = new PitchDAO();
			$obj = $DAO->retorna($Id);

            if ($obj) { 
				if($DAO->submete($Id)){ 
					$this->response->sucesso=1;
					$this->response->mensagem = "Documento enviado para análise com sucesso.";
					
					$Titulo = utf8_encode($obj->getDescricao());
					$Nome = $obj->getNomeCompleto();
					$Email = $obj->getEmail();					
					
					// enviar Email;
					$Assunto = "Proposta de projeto para o INOVA: Pitch Session enviada para análise";
					$Conteudo = "";
					$Conteudo .= "Prezado(a) <em>$Nome</em><br/>";
					$Conteudo .= "<br/>";
					$Conteudo .= "<br/>";
					$Conteudo .= "Seu projeto '$Titulo' enviado para concorrer a uma vaga para apresentação de Pitch na programação do Innovation Hub do IV International Symposium on Immunobiologicals de Bio-Manguinhos foi enviada para análise da Comissão de Seleção dos Projetos. <br/>";
					$Conteudo .= "<br/>";
					$Conteudo .= "A partir de agora você não poderá mais fazer alterações no texto submetido. E até o dia 15 de abril você receberá o parecer da comissão.<br/>";
					$Conteudo .= "<br/>";
					$conteudo .= "Qualquer dúvida, entre em contato com pitchsession@bio.fiocruz.br";
					$Conteudo .= "<br/>";
					$Conteudo .= "Atenciosamente,<br/>";
					$Conteudo .= "<br/>";
					$Conteudo .= "<font face='Arial' color='DarkBlue' size=2><b>Comissão Científica e Tecnológica</b></font><br/>";
					$Conteudo .= "<font face='Arial' color='Gray' size=2>IV International Symposium on Immunobiologicals</font><br/>";
					$Conteudo .= "<font face='Arial' color='Gray' size=2>Bio-Manguinhos | FIOCRUZ</font><br/>";
					$Conteudo .= "http://isi.bio.fiocruz.br<br/>";
					$Conteudo .= "";								

					if (Email::enviar($Nome, $Email, 'kellen.nery@bio.fiocruz.br', $Assunto,$Conteudo)){
						$response->erro = 242;
						$response->mensagem = utf8_encode ( "<b>$Nome</b>, o seu resumo com Titulo '$Titulo' foi enviado com sucesso." . $erroMsg);
					} else {
						$response->erro = 243;
						$response->mensagem = utf8_encode ( "<b>$Nome</b>, o seu resumo com o Titulo '$Titulo' foi enviado com sucesso.<br/>Mas tivemos problema no envio de seu email." . $erroMsg );
					}					
					
				} else{
					$this->response->mensagem = "Erro ao enviar documento.";
				}
            }else{
                $this->response->mensagem = "Erro ao localizar o registro com id: '$Id'.";
            }
            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    } 	
					
    /**
     *  Método para retorar a quantidade de documentos Pictu submetidos
     *
     */    
    public function contarPitch() {
		
		$IdUsuario = isset ( $_GET ['IdUsuario'] ) ? limpa_sql_injection ( trim ( ($_GET ['IdUsuario']) ) ) : '';
		//A busca será pelo Evento Principal 
		$DAOEvento = new EventoDAO();
		$objEvento = new Evento();
		$objEvento = $DAOEvento->retornarEventoPrincipalAtivo();
		$IdEvento = $objEvento->getIdEvento();			
		$DAOEvento->Close();
		/**/		

        try {	
            $DAO = new PitchDAO(); 		
			$obj = $DAO->conta($IdUsuario, $IdEvento);
			$this->response->qtd = $obj;
			$this->response->sucesso = 1;

            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }

		return ($this->response->sucesso==1);
    } 	
	
    /**
     *  Método para retornar um registro
     *
     * @return object Objeto do tipo Pitch
     */    
    public function retornar() {
        
        try{

            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);

            if ($Id){ 
                $DAO = new PitchDAO();
                $obj = $DAO->retorna($Id);
				
                if ($obj){ 
					$this->response->Id = $obj->getId();
					$this->response->Chave = $obj->getChave();
					$this->response->Descricao = utf8_encode ( $obj->getDescricao() );
					$this->response->WebSite = utf8_encode ( $obj->getWebsite() );
					$this->response->TipoSolucao = utf8_encode ( $obj->getTipoSolucao() );
					$this->response->Problema = utf8_encode ( $obj->getProblema() );
					$this->response->Solucao = utf8_encode ( $obj->getSolucao() );
					$this->response->Relevancia = utf8_encode ( $obj->getRelevancia() );
					$this->response->ModeloNegocios = utf8_encode ( $obj->getModeloNegocios() );
					$this->response->Equipe = utf8_encode ( $obj->getEquipe() );					
					$this->response->Fase = utf8_encode ( $obj->getFase() );
					$this->response->FaseDescricao = $this->_arrFases[$obj->getFase()];
					$this->response->Metas = utf8_encode ( $obj->getMetas() );
					$this->response->Innovation = utf8_encode ( $obj->getInnovation() )	;
					$this->response->Links = utf8_encode ( $obj->getLinks() );
					$this->response->IdStatus = $obj->getStatus();
					$this->response->DataAcao = $obj->getDataAcao();
					$this->response->NomeUsuarioAcao = utf8_encode ( $obj->getNomeUsuarioAcao() );
					$this->response->Revisao = $obj->getRevisao();					
					$this->response->Referencia = utf8_encode ($obj->getReferencia());
                    $this->response->dtApresentacao = $obj->getDataApresentacao();

                    if (($obj->getDataApresentacao()!='') && ($obj->getDataApresentacao()!='0000-00-00') && ($obj->getDataApresentacao()!='0000-00-00 00:00:00')){
                        $dtDataApresentacao = explode(" ", Formatacao::formatarDataHoraSQL($obj->getDataApresentacao(), false)); 
                        if (count($dtDataApresentacao)>1){
                            $this->response->DataApresentacao = $dtDataApresentacao[0];
                            $this->response->HoraApresentacao = substr($dtDataApresentacao[1], 0, 5);
                        } else {
                            $this->response->DataApresentacao = Formatacao::formatarDataSQL($obj->getDataApresentacao(), false);
							$this->response->HoraApresentacao = substr($obj->getHoraApresentacao(), -8, 5);
                        }
                    } else {
                        $this->response->DataApresentacao = '';
                        $this->response->HoraApresentacao = '00:00';
                    }	

                    //$html = '';
					//$this->response->Autores = $html;

                    $this->response->Observacao = htmlspecialchars_decode($obj->getObservacao ()); 
                    $this->response->IdStatus = $obj->getStatus();
                    $this->response->NomeStatus = $this->_arrStatus[$obj->getStatus()];
                    $this->response->Ativo = ($obj->getAtivo())? 1: 0;
                    $this->response->Revisao = $obj->getRevisao();
                    $this->response->DataCadastro = ($obj->getDataCadastro()) ? Formatacao::formatarDataHoraSQL($obj->getDataCadastro(), false) : '0000-00-00';		
                    $this->response->DataAcao = ($obj->getDataAcao()) ? Formatacao::formatarDataHoraSQL($obj->getDataAcao(), false) : '0000-00-00';
					//$this->response->IdUsuarioAcao = $obj->getIdUsuarioAcao();
					$this->response->NomeAutor = $obj->getNomeCompleto();
					
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
                $DAO = new PitchDAO();
                $listagem = $DAO->listarHistorico($page, $rows, $sidx, $sord, $Chave);
                if ($listagem) {
                    $this->response->page = ($DAO->getPaginaAtual()) ? $DAO->getPaginaAtual(): 1; // 1; 
                    $this->response->total = ($DAO->getTotalPaginas()) ? $DAO->getTotalPaginas(): 1; // 1; 
                    $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem); // count($listagem);

                    $i = 0;
                    foreach ($listagem as $item){
                        $bt_view = '<a class="btn btn-vazio btn-sm btn-grid" title="Visualizar impressão do Resumo." onclick="visualizarImpressao('.$item->getId().');"><span class="fa fa-file-pdf-o red"></span>';
                        $DataAlteracao = Formatacao::formatarDataHoraSQL ($item->getDataAcao(), false); 
                        $this->response->aaData[$i] = array($bt_view, $item->getId(), $item->getTiposolucao(), $item->getRevisao(), $DataAlteracao);
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

 
    /**
     *  Método para alterarStatus um registro
     *
     * @return bool Se atualização relizada com sucesso
     */    
    public function alterarStatus() {
        try {
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            $Chave = self::getVar('Chave');
            $IdStatus = self::getVar('IdStatus', FILTER_SANITIZE_NUMBER_INT);
            $Observacao = self::getVar('Observacao');
            $Referencia = self::getVar('Referencia');
            $DataApresentacao = self::getVar('DataApresentacao');
            $HoraApresentacao = self::getVar('HoraApresentacao');
            
            // Criticar campos
            if(!$IdStatus) {
                $this->response->mensagem = "O campo <b>IdStatus</b> é de preenchimento obrigatório.";
                return false;
            }
            
            $dtApresentacao = '0000-00-00';
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
                $DAO = new PitchDAO();
                $obj = $DAO->retorna($Id);
                if ($obj){
                    $uDAO = new InscricaoDAO();
                    $obj1 = $uDAO->retornarPorUsuario($obj->getIdParticipante());
                    if ($obj1){
                        $this->response->IdUsuario = $obj1->getIdUsuario(); 
                        $this->response->Nome = $obj1->getNome(); 
                        $this->response->Email = $obj1->getEmail();
                    }
                    $this->response->query2 = $uDAO->_query;

                    $this->response->Id = $obj->getId();
                    $this->response->Descricao = $obj->getDescricao();
                    $this->response->IdUsuario = $obj->getIdParticipante();
                    $this->response->IdStatus = $IdStatus;
                    $this->response->NomeStatus = $this->_arrStatus[$IdStatus];
                    $this->response->DataCadastro = ($obj->getDataCadastro()) ? Formatacao::formatarDataHoraSQL($obj->getDataCadastro(), false) : '';
                    $this->response->Observacao = $Observacao;
                    $this->response->Referencia = $Referencia;
                    $this->response->DataApresentacao = $DataApresentacao;
                    $this->response->HoraApresentacao = $HoraApresentacao;
                    
                    if ($DAO->alterarStatus($Id, $IdStatus, $this->_arrStatus[$IdStatus], $Observacao, $Referencia, $dtApresentacao, $HoraApresentacao)){
						
                        $this->response->sucesso = 1;
                        $this->response->mensagem = "Pitch foi atualizado com sucesso.(".$this->response->Id.")";
                        
					//	if($obj1->getIdPais() == 76){  //Email em Português
							$Conteudo = '';
							$this->response->Assunto = "";
							if ($IdStatus==3){ // 3 => "Aprovado",
								$this->response->Assunto = "Proposta de projeto ACEITA para apresentar no INOVA: Pitch Session / IV ISI";
								$Conteudo = (file_exists('templates/pitch.aprovado.email.html'))? file_get_contents('templates/pitch.aprovado.email.html'): '';
							} else if ($IdStatus==4){   //  4 => "Reprovado",
								$this->response->Assunto = "Proposta de projeto NÃO CLASSIFICADA no INOVA: Pitch Session / IV ISI";
								$Conteudo = (file_exists('templates/pitch.reprovado.email.html'))? file_get_contents('templates/pitch.reprovado.email.html'): '';							
							} else {
								$Conteudo ='';
							}

							if ($Conteudo!=''){
								$Conteudo = str_replace("{NOME}", $this->response->Nome, $Conteudo);
								$Conteudo = str_replace("{TITULO}", utf8_encode ($this->response->Descricao), $Conteudo);
								if ($this->response->DataApresentacao){ $Conteudo = str_replace("{DATA-APRESENTACAO}", $this->response->DataApresentacao.' às '.$this->response->HoraApresentacao, $Conteudo);} else {$Conteudo = str_replace("{DATA-APRESENTACAO}", "", $Conteudo);}
                            }
							
						/*}else { //email em Inglês
							$Conteudo = '';
							$this->response->Assunto = "";
							if ($IdStatus==3){ // 3 => "Aprovado",
								$this->response->Assunto = "Proposta de projeto ACEITA para apresentar no INOVA: Pitch Session / IV ISI";
								$Conteudo = (file_exists('templates/pitch.aprovado.email.html'))? file_get_contents('templates/pitch.aprovado.email.html'): '';
							} else if ($IdStatus==4){   //  4 => "Reprovado",
								$this->response->Assunto = "Proposta de projeto NÃO CLASSIFICADA no INOVA: Pitch Session / IV ISI";
								$Conteudo = (file_exists('templates/pitch.reprovado.email.html'))? file_get_contents('templates/pitch.reprovado.email.html'): '';							
							} else {
								$Conteudo ='';
							}

							if ($Conteudo!=''){
								$Conteudo = str_replace("{NOME}", $this->response->Nome, $Conteudo);
								$Conteudo = str_replace("{TITULO}", $this->response->Descricao, $Conteudo);
								if ($this->response->DataApresentacao){ $Conteudo = str_replace("{DATA-APRESENTACAO}", $this->response->DataApresentacao.' às '.$this->response->HoraApresentacao, $Conteudo);} else {$Conteudo = str_replace("{DATA-APRESENTACAO}", "", $Conteudo);}
                            }
						}*/
                        
                        // Enviar Email;
                        if ($Conteudo!=''){   
							if (Email::enviar($this->response->Nome, $this->response->Email, 'sact@bio.fiocruz.br', $this->response->Assunto, $Conteudo)){
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