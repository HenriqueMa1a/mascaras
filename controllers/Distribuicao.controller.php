<?php
if(!class_exists('DistribuicaoDAO')){ require_once 'models/DistribuicaoDAO.class.php';}
/**
 *  Controle responsável pela módulo Inscricao. 
 */
class DistribuicaoController extends Controller{
    
    /**
     * Contrutor da Classe
     *
     * @return void
     */    
    public function __construct(){
        parent::__construct('cadastro-distribuicao');
        $this->Config->Debug=1;
		
		define('_JEXEC', 1 );
		define('JPATH_BASE', "/var/www/html/isi" );
		define( 'DS','/' );
		//echo "<!-- JPATH_BASE.DS=".JPATH_BASE.DS." //-->";
		
		//require_once(JPATH_BASE.DS. 'includes'.DS.'defines.php' );
		//require_once(JPATH_BASE.DS.'includes'.DS.'framework.php' );
		//require_once(JPATH_BASE.DS.'libraries/joomla/database/factory.php');
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
            $aColumns = array(0=>'img', 1=>'id', 2=>'user_full_name', 3=>'username', 4=>'name', 5=>'ativo', 6=>'', 7=>'' );
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
            
            $nome = self::getVar('nome');
            $posto = self::getVar('posto');
			$dataInicial = (self::getVar('dataInicial')) ? Formatacao::formatarDataSQL(self::getVar('dataInicial')) : '';  
			$dataFinal = (self::getVar('dataFinal')) ? Formatacao::formatarDataSQL(self::getVar('dataFinal')) : '';
			
            $DAO = new DistribuicaoDAO();
            $listagem = $DAO->listar(null, null, 'data', 'desc', $nome, $posto, $dataInicial, $dataFinal, null);
            if ($listagem) { 
                $this->response->page = ($DAO->getPaginaAtual()) ? $DAO->getPaginaAtual(): 1; // 1; 
                $this->response->total = ($DAO->getTotalPaginas()) ? $DAO->getTotalPaginas(): 1; // 1; 
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem); // count($listagem);

                $i = 0;
                foreach ($listagem as $item){ 
                    $bt_view = '<a class="btn btn-vazio btn-sm btn-grid" title="Visualizar registro." onclick="visualizar('.$item->getIdDistribuicao().');"><span class="glyphicon glyphicon-search"></span>';
					$this->response->aaData[$i] = array($bt_view, $item->getIdDistribuicao(), $item->getData(), $item->getDescricaoPosto(), $item->getNomeFuncionario(), $item->getQtde());
                    $i++;
                }
                $this->response->records = $i;
                $this->response->sucesso = 1;
                $this->response->iTotalRecords = $this->response->records;
                $this->response->iTotalDisplayRecords = $this->response->records;
            }else{
                $this->response->page = 0; 
                $this->response->total = 0; 
                $this->response->records = 0;
                if ($DAO->getErro()){
                    $this->response->erro = $DAO->getErro();
                    $this->response->mensagem = $DAO->getMensagem();
                }
            }
            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
	
    /**
     *  Método para retornar um registro
     *
     * @return object Objeto do tipo Funcionario
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
                $DAO = new DistribuicaoDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    $this->response->idDistribuicao = $obj->getIdDistribuicao();
                    $this->response->data = $obj->getData();
                    $this->response->idFuncionario = $obj->getIdFuncionario();
					$this->response->nomeFuncionario = $obj->getNomeFuncionario();
					$this->response->jornadaTrabalho = $obj->getJornadaTrabalho();
					$this->response->descricaoJornada = $obj->getDescricaoJornada();
                    $this->response->idPosto = $obj->getIdPosto();
					$this->response->descricaoPosto = $obj->getDescricaoPosto();
                    $this->response->qtde = $obj->getQtde();
                    $this->response->acao = $obj->getAcao();
                    $this->response->dataAcao = $obj->getDataAcao();
					$this->response->idUsuarioAcao = $obj->getIdUsuarioAcao();
					$this->response->nomeUsuarioAcao = $obj->getNomeUsuarioAcao();

                    $this->response->sucesso = 1;
                    $this->response->mensagem = "Registro com id: '$Id' foi localizado com sucesso.";
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro com id: '$Id'.";
                    if ($DAO->getErro()){
                        $this->response->erro = $DAO->getErro();
                        $this->response->mensagem = $DAO->getMensagem();
                    }
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
            $IdFuncionario = self::getVar('idFuncionario');
            $IdPosto = self::getVar('idPosto');
			$Qtde = self::getVar('qtde');
            $IdUsuarioAcao = self::getVar('IdUsuarioAcao');
			$DataDistribuicao = self::getVar('dataDistribuicao');
			
            // Criticar campos
            if(!$IdFuncionario){
                $this->response->mensagem = "O campo <b>Funcionario</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$IdPosto){
                $this->response->mensagem = "O campo <b>Posto de Entrega</b> é de preenchimento obrigatório.";
                return false;
            }
			
            if(!$Qtde){
                $this->response->mensagem = "O campo <b>Quantidade</b> é de preenchimento obrigatório.";
                return false;
            }			
            
            $obj = new Distribuicao();
            $obj->setIdFuncionario($IdFuncionario);
			$obj->setIdPosto($IdPosto);
            $obj->setQtde(intval($Qtde));
			$obj->setIdUsuarioAcao($IdUsuarioAcao);
			$obj->setData(Formatacao::formatarDataHoraSQL($DataDistribuicao));
            
            $DAO = new DistribuicaoDAO();
            if ($DAO->salvar($obj)){
                $Id = $obj->getIdDistribuicao();
                $this->response->Id=$Id;
				
                $this->response->sucesso = 1;
                $this->response->mensagem = "Entrega realizada com sucesso.";
            } else {
                $this->response->mensagem = $DAO->getMensagem();
            }

            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();
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
            $IdFuncionario = self::getVar('idFuncionario', FILTER_SANITIZE_NUMBER_INT);
            $IdPosto = self::getVar('idPosto', FILTER_SANITIZE_NUMBER_INT);
			$Qtde = self::getVar('qtde', FILTER_SANITIZE_NUMBER_INT);
			$DataDistribuicao = self::getVar('dataDistribuicao');
			$IdUsuarioAcao = self::getVar('IdUsuarioAcao', FILTER_SANITIZE_NUMBER_INT);
            
            // Criticar campos
            if(!$IdFuncionario) {
                $this->response->mensagem = "O campo <b>Funcionario</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$IdPosto) {
                $this->response->mensagem = "O campo <b>Posto de Entrega</b> é de preenchimento obrigatório.";
                return false;
            }
            
            if((!$Qtde)||($Qtde == 0)) {
                $this->response->mensagem = "O campo <b>Quantidade</b> é de preenchimento obrigatório.";
                return false;
            }

            if(!$DataDistribuicao) {
                $this->response->mensagem = "Erro: O campo <b>Data da Entrega</b> é de preenchimento obrigatório.";
                return false;
            } 	
			
            $this->response->Id=$Id;
            if ($Id){
                $DAO = new DistribuicaoDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
					//$obj->setIdTipoUsuario($Id);
                    $obj->setIdFuncionario($IdFuncionario);
                    $obj->setIdPosto($IdPosto);
                    $obj->setData(Formatacao::formatarDataHoraSQL($DataDistribuicao));
                    $obj->setQtde($Qtde);

                    if ($DAO->atualizar($obj)){
                        $this->response->sucesso = 1;
                        $this->response->mensagem = "Registro atualizado com sucesso.";
                    } else {
                        $this->response->erro = $DAO->getErro();
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
                $DAO = new DistribuicaoDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    //$this->response->Nome = $obj->getNome();
                    if ($DAO->excluir($Id)){
                        $this->response->sucesso = 1;
                        $this->response->mensagem = "O registro <b>$Id do dia " . $obj->getData() . "</b> foi removido com sucesso.";
                    } else {
                        $this->response->mensagem = $DAO->getMensagem();
                    }
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro de Id: '$Id'.";
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
            $DAO = new DistribuicaoDAO();

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
                $sidx = 'id_distribuicao';
                $sord = 'desc';
            }
            $this->response->sidx = $sidx;
            $this->response->sord = $sord;
            $this->response->sOrder = $sOrder;
            
            // Parametros
            $funcionario = self::getVar('funcionario');
            $posto = self::getVar('posto');
            $dataInicial = self::getVar('dataInicial');
            $dataFinal = self::getVar('dataFinal');
            
            $this->response->cabecalho='';
            $this->response->html='';
            
            // Cabeçalho 
                $this->_Pagina = 'A4';
                $this->response->cabecalho = (file_exists('views/cabecalho.'.$this->_Formato.'.html'))? file_get_contents('views/cabecalho.'.$this->_Formato.'.html'): '';
                $this->response->cabecalho = str_replace("{SISNOME}", "Controle de Distribuição de Máscaras", $this->response->cabecalho);
                $this->response->cabecalho = str_replace("{SISVERSAO}", "1.0", $this->response->cabecalho);
                $this->response->cabecalho = str_replace("{TITULO}", "Relatório de Distribuição de Máscaras", $this->response->cabecalho);
                $this->response->cabecalho = str_replace("{TIMESTAMP}", date("j-m-Y H:m"), $this->response->cabecalho);
                // Filtros
                $strFiltro = '';
                $strFiltro .= ($funcionario)? "Funcionário: <em>$funcionario</em> &nbsp;&nbsp;&nbsp;": ""; 
				$strFiltro .= ($posto)? "Posto: <em>$posto</em> &nbsp;&nbsp;&nbsp;": ""; 
				$strFiltro .= ($dataInicial)? "Data Inicial: <em>$dataInicial</em> &nbsp;&nbsp;&nbsp;": ""; 
				$strFiltro .= ($dataFinal)? "Data Final: <em>$dataFinal</em> &nbsp;&nbsp;&nbsp;": ""; 
                $strFiltro .= (!$strFiltro)? "-x-": ""; 
                $this->response->cabecalho = str_replace("{FILTRO}", $strFiltro, $this->response->cabecalho);
            
            // Formato
            if (($this->_Formato=='excel') || ($this->_Formato=='pdf')){
                // Cabeçalho da Tabela
                $this->response->html.= "<table style='border: 0.5px solid #000000; font-family: arial; font-size: 8pt; vertical-align: top; ' cellspacing='0' cellpadding='5'>"
                                            ."<tr style='background-color: #ccc; '>"
                                            ."    <td width='30' style='border: 0.5px solid #000000;'><b>#</b></td>"
                                            ."    <td width='200' style='border: 0.5px solid #000000;'><b>Data do Registro</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Funcionário</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Modalidade</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Tipo Colaborador</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Código UO</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Sigla da UO</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Seção</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Divisão</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Departamento</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Vice-Diretoria</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Diretoria</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Posto de Entrega</b></td>"
											."    <td width='200' style='border: 0.5px solid #000000;'><b>Quantidade</b></td>"
                                            ."</tr>";
            }
            
            $listagem = $DAO->listar($page, $rows, $sidx, $sord, $funcionario, $posto, $dataInicial, $dataFinal, null);
            if ($listagem) {
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem);
                
                //$this->response->html.= "<tr><td colspan='5'>".$DAO->_query."</td></tr>";
                
                $i = 0;
                foreach ($listagem as $item){
                    $cor = ($i%2==0? '#eee': '#fff');
                    $DataCadastro = ($item->getData()) ? Formatacao::formatarDataHoraSQL($item->getData(), false) : '';
					
                    $this->response->html.= "<tr style='background-color: $cor;'>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getIdDistribuicao()."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$DataCadastro."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".utf8_encode($item->getNomeFuncionario())."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".utf8_encode($item->getModalidade())."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".utf8_encode($item->getTipoColaborador())."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getUoCodigo()."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getUoAlocacao()."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getUoNivel1()."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getUoNivel2()."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getUoNivel3()."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getUoNivel4()."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getUoNivel5()."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".utf8_encode($item->getDescricaoPosto())."</td>"
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getQtde()."</td>"
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
	
    
}