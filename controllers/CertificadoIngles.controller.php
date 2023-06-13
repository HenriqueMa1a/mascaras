<?php
if(!class_exists('EventoDAO')){ require_once 'models/EventoDAO.class.php';}
if(!class_exists('EventoParticipanteDAO')){ require_once 'models/EventoParticipanteDAO.class.php';}
if(!class_exists('EventoPresencaDAO')){ require_once 'models/EventoPresencaDAO.class.php';}
if(!class_exists('InscricaoDAO')){ require_once 'models/InscricaoDAO.class.php';}
if(!class_exists('ResumoDAO')){ require_once 'modelo/ResumoDAO.class.php';}
/**
 *  Controle responsável pela módulo EventoParticipante. 
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
class CertificadoInglesController extends Controller{
    
    private $_NomeStatus = array(0=>'Not defined', 1=>'Pre-Registration', 2=>'Registered', 3=>'Refused', 4=>'Canceled', 5=>'Confirmed', 6=>'Present', 7=>'', 8=>'', 9=>'');
    
    /**
     * Contrutor da Classe
     *
     * @return void
     */    
    public function __construct(){
        parent::__construct('cadastro-evento-participante');
    }
    
    
    /**
     *  Método para listar todos registros
     *
     * @return array Retornar o array aaData[] = {{Link, Id, Sigla, Nome, Ativo},...}
     */    
    public function listar() { 
   
        try {
			
            $IdParticipante = self::getVar('IdParticipante');
			
			$daoEvento = new EventoDAO();
            //$daoEventoPresenca = new EventoPresencaDAO();
			//$daoResumo = new ResumoDAO();
            $daoEventoParticipante = new EventoParticipanteDAO();

            $listaEventoParticipante = $daoEventoParticipante->listarCertificados($IdParticipante);
			$_arrEventoPrincipal = array(); //utilizado para saber se já foi apresentado o certificado de um evento principal para algum subevento

            if ($listaEventoParticipante) {          
                $i = 0;
				$resul =  " não existe";
                foreach ($listaEventoParticipante as $item){
					
					//procurar o evento que esse participante está inscrito
					$objEvento = $daoEvento->retornar($item->getIdEvento());
					if ($objEvento){
						//se é evento principal só existe um único evento
						if ($objEvento->getIdEvento() == $objEvento->getIdParente()){
							$this::mostrarCertificadoEvento($item, $i);	
							
						}else { //subevento						
							if (!in_array($objEvento->getIdParente(), $_arrEventoPrincipal)){
								$this::mostrarCertificadoSubEvento($item, $i, $objEvento->getIdParente());
							}
							$_arrEventoPrincipal[] = $objEvento->getIdParente();
							
						}		
					}
                    $i++;
				}
				
                $this->response->sucesso = 1;

            }else{

            }
            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $daoEventoParticipante->_query; }
            $daoEventoParticipante->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }


	public function mostrarCertificadoSubEvento($p_Item, $p_i, $p_EventoPrincipal) { 
	
		$daoEvento = new EventoDAO();
		$daoEventoPresenca = new EventoPresencaDAO();
		$daoResumo = new ResumoDAO();
		$daoEventoParticipante = new EventoParticipanteDAO();
	
		$_arrSubEventos = array();

		//buscar todas as participações do inscrito no evento principal
		$daoSubEventos = new EventoParticipanteDAO();
		$listaSubEventos = $daoSubEventos->listarPorEventoPrincipalParticipante($p_Item->getIdParente(), $p_Item->getIdParticipante());
		
		foreach ($listaSubEventos as $subEvento){
			$IdEventoParticipante = $subEvento->getId();
			$idParticipante = $subEvento->getIdParticipante();
			$idEvento = $subEvento->getIdEvento();
			$idParente = $subEvento->getIdParente();
			$idStatus = $subEvento->getIdStatus();
			$objPresenca = $daoEventoPresenca->retornarPorEventoParticipante($idParente, $idParticipante);
			$_arrSubEventos[] = array($IdEventoParticipante, $idParticipante, $idEvento, $idParente, $idStatus, $objPresenca);
		}
		
		$status = 'reprovado';
		$presenca = 0;
		$idEvenPart = $_arrSubEventos[0][0];
		$chave = '';
		foreach ($_arrSubEventos as $row){
			if($row[4] == 2){ //pelo menos 1 evento Aprovado
				$status = 'aprovado';
				$idEvenPart = $row[0];
			}
			if($row[5] <> null){
				$presenca = 1;
				$chave = $row[5]->getChave();
			}			
		}

		//Dados do Evento Principal
		$EventoPai = $daoEvento->retornar($p_EventoPrincipal);		

		//Dados do Evento retornado acima (aprovado ou reprovado)
		$EventoParticipante = $daoEventoParticipante->retornar($idEvenPart);			
		
		//Status do filho
		if($EventoParticipante->getIdStatus()==2){ // Aprovado
			$NomeStatus = '<span class="label label-success">'.$this->_NomeStatus[$EventoParticipante->getIdStatus()].'</span>';
		} else if($EventoParticipante->getIdStatus()==3){ // Reprovado
			$NomeStatus = '<span class="label label-danger">'.$this->_NomeStatus[$EventoParticipante->getIdStatus()].'</span>';
		} else if($EventoParticipante->getIdStatus()==4){ // Cancelado
			$NomeStatus = '<span class="label label-danger">'.$this->_NomeStatus[$EventoParticipante->getIdStatus()].'</span>';
		} else if($EventoParticipante->getIdStatus()==5){ // Confirmado
			$NomeStatus = '<span class="label label-success">'.$this->_NomeStatus[$EventoParticipante->getIdStatus()].'</span>';
		} else if($EventoParticipante->getIdStatus()==6){ // Presente
			$NomeStatus = '<span class="label label-success">'.$this->_NomeStatus[$EventoParticipante->getIdStatus()].'</span>';
		} else {
			$NomeStatus = '<span class="label label-default">'.$this->_NomeStatus[$EventoParticipante->getIdStatus()].'</span>';
		}

		$strCertificado = '';
		$obs = '';	
		$ano = date( 'Y', strtotime($EventoPai->getDataInicial()) );			
		$strCertificadoPoster = array(); 		
	
		//Certificados de Autores
		$objResumo = $daoResumo->verificaResumoPorID($p_Item->getIdParticipante());				
		foreach ($objResumo as $itemResumo){ 
			//se o participante tiver trabalho submetido aprovado para exposição ou apresentação, cria botão(ões), SEM NECESSIDADE DE PRESENÇA NO EVENTO
			//mas apenas quando o evento já estiver terminado, ou seja, data final do evento maior que a data corrente
			if ( ( ($itemResumo->getIdStatus()==5)||($itemResumo->getIdStatus()==6) ) && ($itemResumo->getAno()==$ano) && (strtotime(date('Y-m-d H:i:s')) > strtotime($EventoPai->getDataFinal())) ){ 
				$strCertificadoPoster[] = '<button type="button" class="btn btn-default btn-xs" onclick="visualizarCertificadoPoster(\''.$itemResumo->getChave().'\','.$itemResumo->getId().','.$ano.');" title="View Certificate Poster"><span class="glyphicon glyphicon-file blue"></span> Certificate</button>';	
			}
		}			

		if ( ($presenca) && ($status == 'aprovado') ){
			$strCertificado = '<button type="button" class="btn btn-default btn-xs" onclick="visualizarCertificado(\''.$chave.'\','.$ano.');" title="View Certificate"><span class="glyphicon glyphicon-file red"></span> Certificate</button>';
		} else{ 
			if($EventoParticipante->getIdStatus() <> 2){
				$obs = $EventoParticipante->getObservacao();	
			}else {
				if ( strtotime(date('Y-m-d H:i:s')) < strtotime($EventoPai->getDataFinal()) ) {
					$obs = 'Certificate not yet available';	
				}else{
					$obs = 'Was not present at the event';	
				}	
			}							
		}						

		$this->response->aaData[$p_i] = array($bt_view, $p_Item->getId(), $EventoPai->getIdEvento(), $EventoPai->getNome(), $strSaldo, $p_Item->getIdParticipante(), $p_Item->getNomeParticipante(), $EventoParticipante->getIdStatus(), $NomeStatus, $strCertificado, $strCertificadoPoster, $obs, $p_Item->getIdTipoEvento(), $chkPresenca);

	}


	
	
	public function mostrarCertificadoEvento($p_Item, $p_i) { 
		
		$daoEventoPresenca = new EventoPresencaDAO();
		$daoResumo = new ResumoDAO();
	
		if($p_Item->getIdStatus()==2){ // Aprovado
			$NomeStatus = '<span class="label label-success">'.$this->_NomeStatus[$p_Item->getIdStatus()].'</span>';
		} else if($p_Item->getIdStatus()==3){ // Reprovado
			$NomeStatus = '<span class="label label-danger">'.$this->_NomeStatus[$p_Item->getIdStatus()].'</span>';
		} else if($p_Item->getIdStatus()==4){ // Cancelado
			$NomeStatus = '<span class="label label-danger">'.$this->_NomeStatus[$p_Item->getIdStatus()].'</span>';
		} else if($p_Item->getIdStatus()==5){ // Confirmado
			$NomeStatus = '<span class="label label-success">'.$this->_NomeStatus[$p_Item->getIdStatus()].'</span>';
		} else if($p_Item->getIdStatus()==6){ // Presente
			$NomeStatus = '<span class="label label-success">'.$this->_NomeStatus[$p_Item->getIdStatus()].'</span>';
		} else {
			$NomeStatus = '<span class="label label-default">'.$this->_NomeStatus[$p_Item->getIdStatus()].'</span>';
		}	

		$strCertificado = '';
		$obs = $p_Item->getObservacao();
		$objPresenca = $daoEventoPresenca->retornarPorEventoParticipante($p_Item->getIdEvento(), $p_Item->getIdParticipante());
		$ano = date( 'Y', strtotime($p_Item->getDataInicial()) );

		if ($objPresenca){
			$strCertificado = '<button type="button" class="btn btn-default btn-xs" onclick="visualizarCertificado(\''.$objPresenca->getChave().'\','.$ano.');" title="View Certificate"><span class="glyphicon glyphicon-file red"></span> Certificate</button>';
		} else{ 
			if($p_Item->getIdStatus()<>2){
				$obs = $p_Item->getObservacao();
			}else {
				$obs = 'Was not present at the event';	
			}							
		}

		//Para colocar o botão que baixa os certificados dos autores de trabalho
		$strCertificadoPoster = array(); 
		$objResumo = $daoResumo->verificaResumoPorID($p_Item->getIdParticipante());				
		foreach ($objResumo as $itemResumo){ 
			//se o participante tiver trabalho submetido aprovado para exposição ou apresentação, cria botão(ões), SEM NECESSIDADE DE PRESENÇA NO EVENTO
			if ( ( ($itemResumo->getIdStatus()==5)||($itemResumo->getIdStatus()==6) ) && ($itemResumo->getAno()==$ano) ){ 
				$strCertificadoPoster[] = '<button type="button" class="btn btn-default btn-xs" onclick="visualizarCertificadoPoster(\''.$itemResumo->getChave().'\','.$itemResumo->getId().','.$ano.');" title="View Certificate Poster"><span class="glyphicon glyphicon-file blue"></span> Certificate</button>';	
			}
		}					

		$this->response->aaData[$p_i] = array($bt_view, $p_Item->getId(), $p_Item->getIdEvento(), $p_Item->getNomeEvento(), $strSaldo, $p_Item->getIdParticipante(), $p_Item->getNomeParticipante(), $p_Item->getIdStatus(), $NomeStatus, $strCertificado, $strCertificadoPoster, $obs, $p_Item->getIdTipoEvento(), $chkPresenca);
	
	}
	
	

        
}