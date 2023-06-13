<?php
/**
 *  Controle de naveção do sistema.
 * 
 * @category Controller
 * 
 * @version 2.0
 * @author  Kellen Nery - kellen.nery@bio.fiocruz.br
 */
 

require_once 'assets/global.php'; 
if(!class_exists('Contexto')){ require_once 'controllers/Contexto.class.php';}
if(!class_exists('ModuloDAO')){ require_once 'models/ModuloDAO.class.php';}
if(!class_exists('FuncionalidadeDAO')){ require_once 'models/FuncionalidadeDAO.class.php';}
if(!class_exists('LogAcaoDAO')){ require_once 'models/LogAcaoDAO.class.php';}
    //var_dump($_SESSION);exit;
     
    // 1. Verifica o Módulo passado por parametro;
    $MOD_CHAVE = Contexto::iniciarModulo();
    $USO_ID = Contexto::getUsuario();

    // 2. Pegar dados do Grupo;
    $mDAO = new ModuloDAO();
	$objGrupo = $mDAO->retornarPorChave($sisModulo->Grupo->Chave);
    if ($objGrupo){
        $sisModulo->Grupo->Id = $objGrupo->getId();
        $sisModulo->Grupo->Nome = $objGrupo->getNome();
        $sisModulo->Grupo->Descricao = $objGrupo->getDescricao();
        $sisModulo->Grupo->Visao = ($objGrupo->getVisao()) ? $objGrupo->getVisao() : 'branco.view.php';
    } else {
        $sisModulo->Grupo->Id = -1; // Não encontrado
    }
    //if (($sisConfig->Debug)||($sisUsuario->Id==1)){ echo "<!-- Grupo:{Id:".$sisModulo->Grupo->Id.", Chave: \"".$sisModulo->Grupo->Chave."\", Nome: \"".$sisModulo->Grupo->Nome."\", Descricao: \"".$sisModulo->Grupo->Descricao.", Visao: \"".$sisModulo->Grupo->Visao."\"} -->\n"; }
    //if (($sisConfig->Debug)||($sisUsuario->Id==1)){ echo "<!-- Usuario:{Id:".$sisUsuario->Id.", Nome: \"".$sisUsuario->Nome."\", Nome: \"".$sisModulo->Grupo->Nome."\", Descricao: \"".$sisModulo->Grupo->Descricao."\"} -->\n";}

    // 2.1 Pegar dados do MODULO;
    $objModulo = $mDAO->retornarPorChave($sisModulo->Chave);   

    if ($objModulo){// Modulos Cadastrados, então precisa ter permissão.
        $sisModulo->Id = $objModulo->getId();
        $sisModulo->Nome = $objModulo->getNome();
        $sisModulo->Chave = $objModulo->getChave();
        $sisModulo->Controle = $objModulo->getControle();
        $sisModulo->Classe = $objModulo->getClasse();
        $sisModulo->Descricao = $objModulo->getDescricao();
        $sisModulo->Imagem = $objModulo->getImagem();
        $sisModulo->Publico = ($objModulo->getPublico())? 1: 0;
        $sisModulo->Parametros = json_decode($objModulo->getParametros());
        $sisModulo->Visao = $objModulo->getVisao();
        $sisModulo->View = ($objModulo->getVisao())? "views/".$objModulo->getVisao() : '';

        $mDAO->registrarVisitaPorChave($sisModulo->Id);
    
        $aOperacoes = array();
        $aOperacoes['visualizar'] = $sisModulo->Publico;
	
        $fDAO = new FuncionalidadeDAO();
        $listagem = $fDAO->listar(1, 1000, 'ordem', 'asc', $sisModulo->Id);
        if ($listagem) {
            foreach ($listagem as $item){
                $aOperacoes[$item->getOperacao()] = 0;
            }
        }
        //echo $fDAO->_query;
        if (($sisModulo->Id) && ($sisUsuario->IdPerfil)){
            $listagem = $fDAO->listar(1, 1000, 'ordem', 'asc', $sisModulo->Id, $sisUsuario->IdPerfil);
            if ($listagem) {
                foreach ($listagem as $item){
                    $aOperacoes[$item->getOperacao()] = $item->getAtivo();
                }
            } else if ($sisModulo->Publico) {
                // Modulo->Publico: Não precisa de Funcionalidade
            } else {
                Contexto::tratarErro(16, 'Controle de Módulos', 'O seu perfil não tem permissão para acessar este modulo.');
            } 
        } else if ($sisModulo->Publico) {
            // Modulo->Publico: Não precisa de Funcionalidade
        } else {
            Contexto::tratarErro(17, 'Controle de Módulos', 'O seu Perfil não encontado em nossa base de dados.');
        }
        $fDAO->Close();
        $sisModulo->Operacoes = json_encode($aOperacoes);
        
    //} else if (Contexto::moduloPublico()){ // Modulos NÃO Cadastrados e NÃO precisam de permissão.
    //   $sisModulo->Id = 0;
    //    $sisModulo->Classe = $sisModulo->Chave;
    } else {
        Contexto::tratarErro(18, 'Controle de Módulos', 'O Modulo não encontado em nossa base de dados.');
    }
    $mDAO->Close();
	
    if (!$sisModulo->View){
        $sisModulo->View = "views/".$sisModulo->Classe.".view.php";
    }
    if (($sisConfig->Debug)||($sisUsuario->Id==1)){ echo "<!-- Modulo:{Id:".$sisModulo->Id.", Chave: \"".$sisModulo->Chave."\", Classe: \"".$sisModulo->Classe."\", Nome: \"".$sisModulo->Nome."\", Descricao: \"".$sisModulo->Descricao."\", Publico: \"".$sisModulo->Publico."\", View: \"".$sisModulo->View."\"} -->\n"; }
 
    // 3. Verifica se esta logado;
    if ($sisUsuario->Id>0) { 
        // 4. Gravar LOG do Usuário/Ação
        if ($sisModulo->Classe != 'abertura'){ 
            try {
                $logDAO = new LogAcaoDAO();
                $logDAO->salvar(new LogAcao($sisModulo->Id, $sisModulo->Chave, $sisModulo->Classe, null, 'view', $sisModulo->Parametros, null, $sisUsuario->Id, $sisUsuario->IP));
                $logDAO->Close();
            }catch (PDOExeception $ex){
                $response->mensagem = utf8_encode("Erro (".$ex->getCode()."): ".$ex->getMessage());
                //echo "<!-- Erro:{Id:".$ex->getCode().", Menssagem: \"".$ex->getMessage()."\"} -->\n";
            }
        }
    } else if ($sisModulo->Publico) {
		// Modulo->Publico: Não precisa de Funcionalidade
    } else { // if (!Contexto::moduloPublico()){ 
		$sisModulo->Classe = 'autenticacao';
        $sisModulo->View = 'views/autenticacao.view.php';
    } 
    
    // 5. Verificar a existencia do arquivo.view da Classe do Módulo;
        if (file_exists($sisModulo->View)){ 
            // 6. Guardar Sessão e pelar para a View;
            $_SESSION['MODULO'] = serialize($sisModulo);
            $_COOKIE['MODULO'] = serialize($sisModulo);
            if ($sisModulo->Classe=='fullscreen'){ 
                require_once('views/bloco_cabecalho_fullscreen.php');
                require_once($sisModulo->View);
                require_once('views/bloco_rodape_fullscreen.php');
            } else { 
                require_once('views/bloco_cabecalho.php');
                require_once($sisModulo->View);
                require_once('views/bloco_rodape.php');
            }
        } else {
            Contexto::tratarErro(19, 'O controle não encontrou o módulo específico.');
            require_once('views/bloco_cabecalho.php');
            require_once('views/mensagem.view.php');
            require_once('views/bloco_rodape.php');
        }

