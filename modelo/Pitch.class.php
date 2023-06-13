<?php
/**
* @description Classe de negócio Pitch. 
* @date 08/05/2020
*/
class Pitch {
	private $_Id = 0;
	private $_IdParticipante;
	private $_NomeCompleto;
	private $_Cpf;
	private $_Passaporte;
	private $_Email;
	private $_Telefone;
	private $_IdEvento;
	private $_NomeEvento;
	private $_Descricao;
	private $_Website;	
	private $_TipoSolucao;
	private $_Problema;
	private $_Solucao;
	private $_Relevancia;
	private $_ModeloNegocios;
	private $_Equipe;
	private $_Fase;
	private $_Metas;
	private $_Innovation;
	private $_Links;
	private $_Status;
	private $_DataCadastro;
	private $_Acao;
	private $_DataAcao;
	private $_IdUsuarioAcao;
	private $_NomeUsuarioAcao;
	private $_Revisao;
	private $_Ativo;
	private $_Chave;
	private $_Referencia;
	private $_DataApresentacao;
	private $_HoraApresentacao;	
	private $_Observacao;	

	public function setId($p_Id) { $this->_Id = $p_Id; }
	public function getId() { return $this->_Id; }
 
	public function setIdParticipante($p_IdParticipante){ $this->_IdParticipante = $p_IdParticipante;}
	public function getIdParticipante(){ return $this->_IdParticipante;}

	public function setNomeCompleto($p_NomeCompleto){ $this->_NomeCompleto = $p_NomeCompleto;}
	public function getNomeCompleto(){ return $this->_NomeCompleto;}

	public function setCpf($p_Cpf){ $this->_Cpf = $p_Cpf;}
	public function getCpf(){ return $this->_Cpf;}

	public function setPassaporte($p_Passaporte){ $this->_Passaporte = $p_Passaporte;}
	public function getPassaporte(){ return $this->_Passaporte;}

	public function setEmail($p_Email){ $this->_Email = $p_Email;}
	public function getEmail(){ return $this->_Email;}
	
	public function setTelefone($p_Telefone){ $this->_Telefone = $p_Telefone;}
	public function getTelefone(){ return $this->_Telefone;}

	public function setIdEvento($p_IdEvento){ $this->_IdEvento = $p_IdEvento;}
	public function getIdEvento(){ return $this->_IdEvento;}

	public function setNomeEvento($p_NomeEvento){ $this->_NomeEvento = $p_NomeEvento;}
	public function getNomeEvento(){ return $this->_NomeEvento;}	
	
	public function setDescricao($p_Descricao){ $this->_Descricao = $p_Descricao;}
	public function getDescricao(){ return $this->_Descricao;}	
	
	public function setWebsite($p_Website){ $this->_Website = $p_Website;}
	public function getWebsite(){ return $this->_Website;}	

	public function setTipoSolucao($p_TipoSolucao){ $this->_TipoSolucao = $p_TipoSolucao;}
	public function getTipoSolucao(){ return $this->_TipoSolucao;}	

	public function setProblema($p_Problema){ $this->_Problema = $p_Problema;}
	public function getProblema(){ return $this->_Problema;}	

	public function setSolucao($p_Solucao){ $this->_Solucao = $p_Solucao;}
	public function getSolucao(){ return $this->_Solucao;}	

	public function setRelevancia($p_Relevancia){ $this->_Relevancia = $p_Relevancia;}
	public function getRelevancia(){ return $this->_Relevancia;}	

	public function setModeloNegocios($p_ModeloNegocios){ $this->_ModeloNegocios = $p_ModeloNegocios;}
	public function getModeloNegocios(){ return $this->_ModeloNegocios;}	

	public function setEquipe($p_Equipe){ $this->_Equipe = $p_Equipe;}
	public function getEquipe(){ return $this->_Equipe;}	
	
	public function setFase($p_Fase){ $this->_Fase = $p_Fase;}
	public function getFase(){ return $this->_Fase;}	

	public function setMetas($p_Metas){ $this->_Metas = $p_Metas;}
	public function getMetas(){ return $this->_Metas;}		

	public function setInnovation($p_Innovation){ $this->_Innovation = $p_Innovation;}
	public function getInnovation(){ return $this->_Innovation;}		

	public function setLinks($p_Links){ $this->_Links = $p_Links;}
	public function getLinks(){ return $this->_Links;}	

	public function setStatus($p_Status){ $this->_Status = $p_Status;}
	public function getStatus(){ return $this->_Status;}	
	
	public function setDataCadastro($p_DataCadastro){ $this->_DataCadastro = $p_DataCadastro;}
	public function getDataCadastro(){ return $this->_DataCadastro;}	
	
	public function setAcao($p_Acao){ $this->_Acao = $p_Acao;}
	public function getAcao(){ return $this->_Acao;}	

	public function setDataAcao($p_DataAcao){ $this->_DataAcao = $p_DataAcao;}
	public function getDataAcao(){ return $this->_DataAcao;}	

	public function setIdUsuarioAcao($p_IdUsuarioAcao){ $this->_IdUsuarioAcao = $p_IdUsuarioAcao;}
	public function getIdUsuarioAcao(){ return $this->_IdUsuarioAcao;}		

	public function setNomeUsuarioAcao($p_NomeUsuarioAcao){ $this->_NomeUsuarioAcao = $p_NomeUsuarioAcao;}
	public function getNomeUsuarioAcao(){ return $this->_NomeUsuarioAcao;}		

	public function setRevisao($p_Revisao){ $this->_Revisao = $p_Revisao;}
	public function getRevisao(){ return $this->_Revisao;}
	
	public function setAtivo($p_Ativo){ $this->_Ativo = $p_Ativo;}
	public function getAtivo(){ return $this->_Ativo;}
	
	public function setChave($p_Chave){ $this->_Chave = $p_Chave;}
	public function getChave(){ return $this->_Chave;}

	public function setReferencia($p__Referencia){ $this->_Referencia = $p__Referencia;}
	public function getReferencia(){ return $this->_Referencia;}

	public function setDataApresentacao($p_DataApresentacao){ $this->_DataApresentacao = $p_DataApresentacao;}
	public function getDataApresentacao(){ return $this->_DataApresentacao;}

	public function setHoraApresentacao($p_HoraApresentacao){ $this->_HoraApresentacao = $p_HoraApresentacao;}
	public function getHoraApresentacao(){ return $this->_HoraApresentacao;}

	public function setObservacao($p_Observacao){ $this->_Observacao = $p_Observacao;}
	public function getObservacao(){ return $this->_Observacao;}	
	
	
}

?>


