<?php
class Rss {
	// Declaracao de variaveis
	private $conexao = null;
	private $servidor;
	private $usuario;
	private $senha;
	private $alias;
	
	/**
	 * Construtor
	 */
	public function __construct() {
		// Dados para conexao com o banco de dados
		$this->servidor = "localhost";
		$this->usuario = "covisa_admin";
		$this->senha = "senhacovisa";
		$this->alias = "covisa_asapainel";
		
		// Efetua a conexao com o banco e seleciona a base de dados
		$this->conexao = mysql_connect ( $this->servidor, $this->usuario, $this->senha );
		if ($this->conexao) {
			mysql_select_db ( $this->alias, $this->conexao );
		}
	}
	
	/**
	 * Gera o RSS 2.0
	 *
	 * @param String $titulo
	 *        	titulo do rss
	 *        	
	 * @param String $link
	 *        	url do site
	 *        	
	 * @param String $descricao
	 *        	descricao do rss
	 *        	
	 * @param String $tabela
	 *        	tabela do banco de dados que será puxada as informacoes
	 *        	
	 * @param String $campo
	 *        	campo da tabela pelo qual sera ordenado, de forma decrescente, o rss
	 *        	
	 * @param String $destino
	 *        	url de destino das noticias - Ex: http://www.site.com.br/noticia?id=
	 *        	
	 * @return void
	 */
	public function rss($titulo, $link, $descricao, $tabela, $classe, $destino) {
		// Seleciona os dados no banco de dados
		$sql = "SELECT * FROM $tabela WHERE txt_classe ='$classe' AND txt_ativo=1 AND txt_portal=1 ORDER BY txt_registro DESC;";
		$res = mysql_query ( $sql );
		
		// Cria a variavel $xml com o codigo xml necessario para criar o RSS
		$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
		$xml .= "<rss version=\"2.0\">";
		$xml .= "<channel>";
		$xml .= "<title>$titulo</title>";
		$xml .= "<link>$link</link>";
		$xml .= "<description>$descricao</description>";
		$xml .= "<language>pt-br</language>";
		
		// Verifica se o numero de linhas resultantes da query eh maior do que zero
		if (mysql_numrows ( $res ) > 0) {
			// "Quebra" a matriz
			while ( $dados = mysql_fetch_array ( $res ) ) {
				$xml .= "<item>";
				$xml .= "<title>" . $rs ["txt_titulo"] . "</title>";
				$xml .= "<link>" . $destino . $rs ['txt_id'] . "</link>";
				$xml .= "</item>";
			}
		}
		
		$xml .= "</channel>";
		$xml .= "</rss>";
		
		// Retorna o valor da variavel $xml
		return $xml;
	}
}
?>