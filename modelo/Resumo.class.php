<?php
/**
* @description Classe de negócio Resumo. 
* @author Kellen Nery
* @date 26/05/2020
* @version 1.0
* @package MDS
* @copyright 
*/
class Resumo {
	private $_Id = 0;
	private $_IdUsuario = 0;
	private $_CodResumo;
	private $_IdEvento;
	private $_NomeUsuario;
	private $_NomeCompleto;
	private $_Cpf;
	private $_Passaporte;
	private $_Pais;	
	private $_Estado;
	private $_Email;
	private $_Tipo = 0;
	private $_Titulo = '';
	private $_Introducao = '';
	private $_Instituicao = '';
	private $_Objetivo = '';
	private $_Metodologia = '';
	private $_Resultado = '';
	private $_Conclusao = '';
	private $_ano = '';
	private $_IdUsuarioAprovacao = 0;
	private $_NomeUsuarioAprovacao = '';
	private $_DataAprovacao;
	private $_Observacao = '';
	private $_Nota = 0;
	private $_IdStatus = 0;
	private $_Revisao = 0;
	private $_FlagPolitica = 0;
	private $_FlagPolitica1 = 0;
	private $_FlagPolitica2 = 0;
	private $_FlagPolitica3 = 0;
	private $_Ativo = 0;
	private $_DataInclusao;
	private $_DataAlteracao;
	private $_Autor1;
	private $_Autor2;
	private $_Autor3;
	private $_Autor4;
	private $_Autor5;
	private $_Autor6;
	private $_Autor7;
	private $_Autor8;
	private $_Autor9;
	private $_Autor10;
	private $_Justificativa8;
	private $_Justificativa9;
	private $_Justificativa10;
	private $_Instituicao1;
	private $_Instituicao2;
	private $_Instituicao3;
	private $_Instituicao4;
	private $_Instituicao5;
	private $_Instituicao6;
	private $_Instituicao7;
	private $_Instituicao8;
	private $_Instituicao9;
	private $_Instituicao10;
	private $_Email1;
	private $_Email2;
	private $_Email3;
	private $_Email4;
	private $_Email5;
	private $_Email6;
	private $_Email7;
	private $_Email8;
	private $_Email9;
	private $_Email10;
	private $_Apresentador1 = 0;
	private $_Apresentador2 = 0;
	private $_Apresentador3 = 0;
	private $_Apresentador4 = 0;
	private $_Apresentador5 = 0;
	private $_Apresentador6 = 0;
	private $_Apresentador7 = 0;
	private $_Apresentador8 = 0;
	private $_Apresentador9 = 0;
	private $_Apresentador10 = 0;
	private $_OutroResumo = 0;
	private $_Gest_Resumo = 0;
	private $_Est_Qualitativo = 0;
	private $_OutrosTemas;
	private $_palavraChave;
	private $_contadorTipo;
    private $_Chave;
	private $_NomeContato;
	private $_TelefoneContato;
    private $_EmailContato;
	private $_Referencia;
	private $_Bloco;
	private $_Poster;
	private $_DataApresentacao;
	private $_HoraApresentacao;
	private $_File1;
	private $_File2;
    

	public function setId($p_Id) {
		$this->_Id = $p_Id;
	}
	public function getId() {
		return $this->_Id;
	}
	public function setIdUsuario($p_IdUsuario) {
		$this->_IdUsuario = $p_IdUsuario;
	}
	public function getIdUsuario() {
		return $this->_IdUsuario;
	}
	public function setCodResumo($p_CodResumo) {
		$this->_CodResumo = $p_CodResumo;
	}
	public function getCodResumo() {
		return $this->_CodResumo;
	}
	public function setIdEvento($p_IdEvento) {
		$this->_IdEvento = $p_IdEvento;
	}
	public function getIdEvento() {
		return $this->_IdEvento;
	}		
	public function setNomeUsuario($p_NomeUsuario) {
		$this->_NomeUsuario = $p_NomeUsuario;
	}
	public function getNomeUsuario() {
		return $this->_NomeUsuario;
	}
	public function setTipo($p_Tipo) {
		$this->_Tipo = $p_Tipo;
	}
	public function getTipo() {
		return $this->_Tipo;
	}
	public function setTitulo($p_Titulo) {
		$this->_Titulo = $p_Titulo;
	}
	public function getTitulo() {
		return $this->_Titulo;
	}
	public function setIntroducao($p_Introducao) {
		$this->_Introducao = $p_Introducao;
	}
	public function getIntroducao() {
		return $this->_Introducao;
	}
	public function setInstituicao($p_Instituicao) {
		$this->_Instituicao = $p_Instituicao;
	}
	public function getInstituicao() {
		return $this->_Instituicao;
	}
	public function setObjetivo($p_Objetivo) {
		$this->_Objetivo = $p_Objetivo;
	}
	public function getObjetivo() {
		return $this->_Objetivo;
	}
	public function setMetodologia($p_Metodologia) {
		$this->_Metodologia = $p_Metodologia;
	}
	public function getMetodologia() {
		return $this->_Metodologia;
	}
	public function setResultado($p_Resultado) {
		$this->_Resultado = $p_Resultado;
	}
	public function getResultado() {
		return $this->_Resultado;
	}
	public function setConclusao($p_Conclusao) {
		$this->_Conclusao = $p_Conclusao;
	}
	public function getConclusao() {
		return $this->_Conclusao;
	}
	public function setAno($p_Ano) {
		$this->_Ano = $p_Ano;
	}
	public function getAno() {
		return $this->_Ano;
	}
	public function setNota($p_Nota) {
		$this->_Nota = $p_Nota;
	}
	public function getNota() {
		return $this->_Nota;
	}
	public function setIdStatus($p_IdStatus) {
		$this->_IdStatus = $p_IdStatus;
	}
	public function getIdStatus() {
		return $this->_IdStatus;
	}
	public function setRevisao($p_Revisao) {
		$this->_Revisao = $p_Revisao;
	}
	public function getRevisao() {
		return $this->_Revisao;
	}
	public function setFlagPolitica($p_FlagPolitica) {
		$this->_FlagPolitica = $p_FlagPolitica;
	}
	public function getFlagPolitica() {
		return $this->_FlagPolitica;
	}
	public function setFlagPolitica1($p_FlagPolitica1) {
		$this->_FlagPolitica1 = $p_FlagPolitica1;
	}
	public function getFlagPolitica1() {
		return $this->_FlagPolitica1;
	}
	public function setFlagPolitica2($p_FlagPolitica2) {
		$this->_FlagPolitica2 = $p_FlagPolitica2;
	}
	public function getFlagPolitica2() {
		return $this->_FlagPolitica2;
	}
	public function setFlagPolitica3($p_FlagPolitica3) {
		$this->_FlagPolitica3 = $p_FlagPolitica3;
	}
	public function getFlagPolitica3() {
		return $this->_FlagPolitica3;
	}
	public function setAtivo($p_Ativo) {
		$this->_Ativo = $p_Ativo;
	}
	public function getAtivo() {
		return $this->_Ativo;
	}
	public function setIdUsuarioAprovacao($p_IdUsuarioAprovacao) {
		$this->_IdUsuarioAprovacao = $p_IdUsuarioAprovacao;
	}
	public function getIdUsuarioAprovacao() {
		return $this->_IdUsuarioAprovacao;
	}
	public function setNomeUsuarioAprovacao($p_NomeUsuarioAprovacao) {
		$this->_NomeUsuarioAprovacao = $p_NomeUsuarioAprovacao;
	}
	public function getNomeUsuarioAprovacao() {
		return $this->_NomeUsuarioAprovacao;
	}
	public function setDataAprovacao($p_DataAprovacao) {
		$this->_DataAprovacao = $p_DataAprovacao;
	}
	public function getDataAprovacao() {
		return $this->_DataAprovacao;
	}
	public function setObservacao($p_Observacao) {
		$this->_Observacao = $p_Observacao;
	}
	public function getObservacao() {
		return $this->_Observacao;
	}
	public function setDataInclusao($p_DataInclusao) {
		$this->_DataInclusao = $p_DataInclusao;
	}
	public function getDataInclusao() {
		return $this->_DataInclusao;
	}
	public function setDataAlteracao($p_DataAlteracao) {
		$this->_DataAlteracao = $p_DataAlteracao;
	}
	public function getDataAlteracao() {
		return $this->_DataAlteracao;
	}
	public function setAutor1($p_Autor1) {
		$this->_Autor1 = $p_Autor1;
	}
	public function getAutor1() {
		return $this->_Autor1;
	}
	public function setAutor2($p_Autor2) {
		$this->_Autor2 = $p_Autor2;
	}
	public function getAutor2() {
		return $this->_Autor2;
	}
	public function setAutor3($p_Autor3) {
		$this->_Autor3 = $p_Autor3;
	}
	public function getAutor3() {
		return $this->_Autor3;
	}
	public function setAutor4($p_Autor4) {
		$this->_Autor4 = $p_Autor4;
	}
	public function getAutor4() {
		return $this->_Autor4;
	}
	public function setAutor5($p_Autor5) {
		$this->_Autor5 = $p_Autor5;
	}
	public function getAutor5() {
		return $this->_Autor5;
	}
	public function setAutor6($p_Autor6) {
		$this->_Autor6 = $p_Autor6;
	}
	public function getAutor6() {
		return $this->_Autor6;
	}
	public function setAutor7($p_Autor7) {
		$this->_Autor7 = $p_Autor7;
	}
	public function getAutor7() {
		return $this->_Autor7;
	}
	public function setAutor8($p_Autor8) {
		$this->_Autor8 = $p_Autor8;
	}
	public function getAutor8() {
		return $this->_Autor8;
	}
	public function setAutor9($p_Autor9) {
		$this->_Autor9 = $p_Autor9;
	}
	public function getAutor9() {
		return $this->_Autor9;
	}
	public function setAutor10($p_Autor10) {
		$this->_Autor10 = $p_Autor10;
	}
	public function getAutor10() {
		return $this->_Autor10;
	}
	public function setJustificativa8($p_Justificativa8) {
		$this->_Justificativa8 = $p_Justificativa8;
	}
	public function getJustificativa8() {
		return $this->_Justificativa8;
	}
	public function setJustificativa9($p_Justificativa9) {
		$this->_Justificativa9 = $p_Justificativa9;
	}
	public function getJustificativa9() {
		return $this->_Justificativa9;
	}
	public function setJustificativa10($p_Justificativa10) {
		$this->_Justificativa10 = $p_Justificativa10;
	}
	public function getJustificativa10() {
		return $this->_Justificativa10;
	}
	public function setInstituicao1($p_Instituicao1) {
		$this->_Instituicao1 = $p_Instituicao1;
	}
	public function getInstituicao1() {
		return $this->_Instituicao1;
	}
	public function setInstituicao2($p_Instituicao2) {
		$this->_Instituicao2 = $p_Instituicao2;
	}
	public function getInstituicao2() {
		return $this->_Instituicao2;
	}
	public function setInstituicao3($p_Instituicao3) {
		$this->_Instituicao3 = $p_Instituicao3;
	}
	public function getInstituicao3() {
		return $this->_Instituicao3;
	}
	public function setInstituicao4($p_Instituicao4) {
		$this->_Instituicao4 = $p_Instituicao4;
	}
	public function getInstituicao4() {
		return $this->_Instituicao4;
	}
	public function setInstituicao5($p_Instituicao5) {
		$this->_Instituicao5 = $p_Instituicao5;
	}
	public function getInstituicao5() {
		return $this->_Instituicao5;
	}
	public function setInstituicao6($p_Instituicao6) {
		$this->_Instituicao6 = $p_Instituicao6;
	}
	public function getInstituicao6() {
		return $this->_Instituicao6;
	}
	public function setInstituicao7($p_Instituicao7) {
		$this->_Instituicao7 = $p_Instituicao7;
	}
	public function getInstituicao7() {
		return $this->_Instituicao7;
	}
	public function setInstituicao8($p_Instituicao8) {
		$this->_Instituicao8 = $p_Instituicao8;
	}
	public function getInstituicao8() {
		return $this->_Instituicao8;
	}
	public function setInstituicao9($p_Instituicao9) {
		$this->_Instituicao9 = $p_Instituicao9;
	}
	public function getInstituicao9() {
		return $this->_Instituicao9;
	}
	public function setInstituicao10($p_Instituicao10) {
		$this->_Instituicao10 = $p_Instituicao10;
	}
	public function getInstituicao10() {
		return $this->_Instituicao10;
	}
	public function setEmail1($p_Email1) {
		$this->_Email1 = $p_Email1;
	}
	public function getEmail1() {
		return $this->_Email1;
	}
	public function setEmail2($p_Email2) {
		$this->_Email2 = $p_Email2;
	}
	public function getEmail2() {
		return $this->_Email2;
	}
	public function setEmail3($p_Email3) {
		$this->_Email3 = $p_Email3;
	}
	public function getEmail3() {
		return $this->_Email3;
	}
	public function setEmail4($p_Email4) {
		$this->_Email4 = $p_Email4;
	}
	public function getEmail4() {
		return $this->_Email4;
	}
	public function setEmail5($p_Email5) {
		$this->_Email5 = $p_Email5;
	}
	public function getEmail5() {
		return $this->_Email5;
	}
	public function setEmail6($p_Email6) {
		$this->_Email6 = $p_Email6;
	}
	public function getEmail6() {
		return $this->_Email6;
	}
	public function setEmail7($p_Email7) {
		$this->_Email7 = $p_Email7;
	}
	public function getEmail7() {
		return $this->_Email7;
	}
	public function setEmail8($p_Email8) {
		$this->_Email8 = $p_Email8;
	}
	public function getEmail8() {
		return $this->_Email8;
	}
	public function setEmail9($p_Email9) {
		$this->_Email9 = $p_Email9;
	}
	public function getEmail9() {
		return $this->_Email9;
	}
	public function setEmail10($p_Email10) {
		$this->_Email10 = $p_Email10;
	}
	public function getEmail10() {
		return $this->_Email10;
	}
	public function setApresentador1($p_Apresentador1) {
		$this->_Apresentador1 = $p_Apresentador1;
	}
	public function getApresentador1() {
		return $this->_Apresentador1;
	}
	public function setApresentador2($p_Apresentador2) {
		$this->_Apresentador2 = $p_Apresentador2;
	}
	public function getApresentador2() {
		return $this->_Apresentador2;
	}
	public function setApresentador3($p_Apresentador3) {
		$this->_Apresentador3 = $p_Apresentador3;
	}
	public function getApresentador3() {
		return $this->_Apresentador3;
	}
	public function setApresentador4($p_Apresentador4) {
		$this->_Apresentador4 = $p_Apresentador4;
	}
	public function getApresentador4() {
		return $this->_Apresentador4;
	}
	public function setApresentador5($p_Apresentador5) {
		$this->_Apresentador5 = $p_Apresentador5;
	}
	public function getApresentador5() {
		return $this->_Apresentador5;
	}
	public function setApresentador6($p_Apresentador6) {
		$this->_Apresentador6 = $p_Apresentador6;
	}
	public function getApresentador6() {
		return $this->_Apresentador6;
	}
	public function setApresentador7($p_Apresentador7) {
		$this->_Apresentador7 = $p_Apresentador7;
	}
	public function getApresentador7() {
		return $this->_Apresentador7;
	}
	public function setApresentador8($p_Apresentador8) {
		$this->_Apresentador8 = $p_Apresentador8;
	}
	public function getApresentador8() {
		return $this->_Apresentador8;
	}
	public function setApresentador9($p_Apresentador9) {
		$this->_Apresentador9 = $p_Apresentador9;
	}
	public function getApresentador9() {
		return $this->_Apresentador9;
	}
	public function setApresentador10($p_Apresentador10) {
		$this->_Apresentador10 = $p_Apresentador10;
	}
	public function getApresentador10() {
		return $this->_Apresentador10;
	}
	public function setOutroResumo($p_OutroResumo) {
		$this->_OutroResumo = $p_OutroResumo;
	}
	public function getOutroResumo() {
		return $this->_OutroResumo;
	}
	public function setGest_Resumo($p_Gest_Resumo) {
		$this->_Gest_Resumo = $p_Gest_Resumo;
	}
	public function getGest_Resumo() {
		return $this->_Gest_Resumo;
	}
	public function setEst_Qualitativo($p_Est_Qualitativo) {
		$this->_Est_Qualitativo = $p_Est_Qualitativo;
	}
	public function getEst_Qualitativo() {
		return $this->_Est_Qualitativo;
	}
	public function setOutrosTemas($p_OutrosTemas) {
		$this->_OutrosTemas = $p_OutrosTemas;
	}
	public function getOutrosTemas() {
		return $this->_OutrosTemas;
	}
	public function setPalavraChave($p_PalavraChave) {
		$this->_palavraChave = $p_PalavraChave;
	}
	public function getPalavraChave() {
		return $this->_palavraChave;
	}
	public function setContadorTipo($p_ContadorTipo) {
		$this->_contadorTipo = $p_ContadorTipo;
	}
	public function getContadorTipo() {
		return $this->_contadorTipo;
	}
	public function setChave($p_Chave){ $this->_Chave = $p_Chave;}
	public function getChave(){ return $this->_Chave;}
	
	public function setNomeContato($p_NomeContato) {
		$this->_NomeContato = $p_NomeContato;
	}
	public function getNomeContato() {
		return $this->_NomeContato;
	}
 
	public function setTelefoneContato($p_TelefoneContato) {
		$this->_TelefoneContato = $p_TelefoneContato;
	}
	public function getTelefoneContato() {
		return $this->_TelefoneContato;
	} 

	public function setEmailContato($p_EmailContato) {
		$this->_EmailContato = $p_EmailContato;
	}
	public function getEmailContato() {
		return $this->_EmailContato;
	} 
	
	public function setNomeCompleto($p_NomeCompleto) {
		$this->_NomeCompleto = $p_NomeCompleto;
	}
	public function getNomeCompleto() {
		return $this->_NomeCompleto;
	} 
	
	public function setEmail($p_Email) {
		$this->_Email = $p_Email;
	}
	public function getEmail() {
		return $this->_Email;
	} 	
	
	public function getComentarioBanca() { return $this->_ComentarioBanca; }
	public function setComentarioBanca($p_ComentarioBanca) { $this->_ComentarioBanca = $p_ComentarioBanca; }
 
	public function setReferencia($p_Referencia){ $this->_Referencia = $p_Referencia;}
	public function getReferencia(){ return $this->_Referencia;}

	public function setDataApresentacao($p_DataApresentacao){ $this->_DataApresentacao = $p_DataApresentacao;}
	public function getDataApresentacao(){ return $this->_DataApresentacao;}

	public function setHoraApresentacao($p_HoraApresentacao){ $this->_HoraApresentacao = $p_HoraApresentacao;}
	public function getHoraApresentacao(){ return $this->_HoraApresentacao;}

	public function setBloco($p_Bloco){ $this->_Bloco = $p_Bloco;}
	public function getBloco(){ return $this->_Bloco;}

	public function setPoster($p_Poster){ $this->_Poster = $p_Poster;}
	public function getPoster(){ return $this->_Poster;}	
	
	public function setDataNascimento($p_DataNascimento){ $this->_DataNascimento = $p_DataNascimento;}
	public function getDataNascimento(){ return $this->_DataNascimento;}

	public function setFile1($p_File1){ $this->_File1 = $p_File1;}
	public function getFile1(){ return $this->_File1;}

	public function setFile2($p_File2){ $this->_File2 = $p_File2;}
	public function getFile2(){ return $this->_File2;}	

	public function setCpf($p_Cpf){ $this->_Cpf = $p_Cpf;}
	public function getCpf(){ return $this->_Cpf;}	
	
	public function setPassaporte($p_Passaporte){ $this->_Passaporte = $p_Passaporte;}
	public function getPassaporte(){ return $this->_Passaporte;}	

	public function setPais($p_Pais){ $this->_Pais = $p_Pais;}
	public function getPais(){ return $this->_Pais;}

	public function setEstado($p_Estado){ $this->_Estado = $p_Estado;}
	public function getEstado(){ return $this->_Estado;}	
	
}
?>


