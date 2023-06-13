<?php
/**
 * Classe de utilidades para tratamento de Arquivos para upload
 * @author  Kellen Nery  
 */
class Arquivo {

    private static $_mensagem = null;
    private static $_erro = 0;

    private static $_caminho = '../../../arquivos/';
    private static $_nome = null;
    private static $_tipo = null;
    private static $_extensao = null;
    private static $_tamanho = 0;

    public static function setErro( $p_erro ){ self::$_erro = $p_erro; }
    public static function getErro(){ return self::$_erro; }

    public static function setMensagem( $p_mensagem ){ self::$_mensagem = $p_mensagem; }
    public static function getMensagem(){ return self::$_mensagem; }

    public static function setCaminho( $p_caminho ){ self::$_caminho = $p_caminho; }
    public static function getCaminho(){ return self::$_caminho; }

    public static function setNome( $p_nome ){ self::$_nome = $p_nome; }
    public static function getNome(){ return self::$_nome; }

    public static function setTipo( $p_tipo ){ self::$_tipo = $p_tipo; }
    public static function getTipo(){ return self::$_tipo; }

    public static function setExtensao( $p_extensao ){ self::$_extensao = $p_extensao; }
    public static function getExtensao(){ return self::$_extensao; }

    public static function setTamanho( $p_tamanho ){ self::$_tamanho = $p_tamanho; }
    public static function getTamanho(){ return self::$_tamanho; }


    /**
    *   função para Validar Tipo de arquivo
    *
    *   @param string $p_tipo O Tipo de Arquivo 
    *   @return boolean TRUE Se a gravação for ok
    */
    public static function validarTipoArquivo($p_tipo){
        
        $retorno = false;
        //return $retorno;
        switch ($p_tipo) {
            case "image/jpeg": $retorno = true; break; 
            case "image/pjpeg":    $retorno = true; break;
            case "image/jpg": $retorno = true; break;
            case "image/gif": $retorno = true; break;    
            case "image/png": $retorno = true; break;
            case "image/tiff": $retorno = true; break;
            case "application/pdf": $retorno = true; break;
            case "application/msword": $retorno = true; break;
            case "application/vnd.ms-excel": $retorno = true; break;
            case "application/ms-powerpointl": $retorno = true; break;
            case "text/xml": $retorno = true; break;
            //case "text/html": $retorno = true; break;
            default: $retorno = false; break;   
        }
        return $retorno;
    }    
    
    /**
    *   função para Validar Extensão do arquivo
    *
    *   @param string $p_tipo O Tipo de Arquivo 
    *   @return boolean TRUE Se a gravação for ok
    */
    public static function validarExtensaoArquivo($p_extensao){
        
        $retorno = false;
        //return $retorno;
        switch (strtolower($p_extensao)) {
            case "jpeg": $retorno = true; break; 
            case "pjpeg":    $retorno = true; break;
            case "jpg": $retorno = true; break;
            case "gif": $retorno = true; break;    
            case "png": $retorno = true; break;
            case "tiff": $retorno = true; break;
            case "pdf": $retorno = true; break;
            case "doc": $retorno = true; break;
            case "docx": $retorno = true; break;
            case "xls": $retorno = true; break;
            case "xlsx": $retorno = true; break;
            case "ppt": $retorno = true; break;
            case "pptx": $retorno = true; break;
            case "pps": $retorno = true; break;
            case "ppsx": $retorno = true; break;
            case "ppsx": $retorno = true; break;
            case "ret": $retorno = true; break; // .ret -> Arquivo de Retorno Bancário do Itaú
            case "txt": $retorno = true; break;
            case "xml": $retorno = true; break;
            //case "text/html": $retorno = true; break;
            default: $retorno = false; break;   
        }
        return $retorno;
    }    
    
    /**
    *   função para gravar arquivo
    *
    *   @param string $p_InputArquivo O nome do campo do formulario de upload 
    *   @param string $p_Nome O Nome que deve ser gravado o arquivo
    *   @param string $p_Caminho O endereço onde deve ser gravado o arquivo 
    *   @return boolean TRUE Se a gravação for ok
    */
    public static function gravarArquivo($p_InputArquivo, $p_Nome = null, $p_Caminho = null){
        
        try {
            if ($p_Caminho) self::$_caminho = $p_Caminho;
            
            if (isset($_FILES[$p_InputArquivo])){
                if ($_FILES[$p_InputArquivo]["error"] > 0) {
                    // echo "Return Code: " . $_FILES[$p_InputArquivo]["error"] . "<br />";
                    //$ERRO_CODIGO = 82;
                    //$ERRO_MENSAGEM = "[".$_FILES[$p_InputArquivo]["error"]."] Erro tentando receber arquivo: ".$_FILES[$p_InputArquivo]["name"];
    
                    switch ($_FILES[$p_InputArquivo]["error"]) {
                        case 1: /* UPLOAD_ERR_INI_SIZE */
                            throw new Exception("The uploaded file exceeds the upload_max_filesize directive (".ini_get("upload_max_filesize").") in php.ini.", 1);
                            break;
                        case 2: /* UPLOAD_ERR_FORM_SIZE */
                            throw new Exception("The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.", 2);
                            break;
                        case 3: /* UPLOAD_ERR_PARTIAL */
                            throw new Exception("The uploaded file was only partially uploaded.", 3);
                            break;
                        case 4: /* UPLOAD_ERR_NO_FILE */
                            throw new Exception("No file was uploaded.", 0);
                            break;
                        case 6: /* UPLOAD_ERR_NO_TMP_DIR */
                            throw new Exception("Missing a temporary folder.", 6);
                        default: /* ? */
                            throw new Exception("An unknown file upload error occured".$_FILES[$p_InputArquivo]["error"], $_FILES[$p_InputArquivo]["error"]);
                    }            
                    // $ERRO_NOTAS = $_FILES[$p_InputArquivo]["error"];
                    //header("Location: "."erro.php?e_tit=".$ERRO_TITULO."&e_cod=".$ERRO_CODIGO."&e_msg=".$ERRO_MENSAGEM."&e_not=".$ERRO_NOTAS);
                    return false;
                    
                } else {
                    
                    // Seta Variaveis do Arquivo
                    self::$_nome = $_FILES[$p_InputArquivo]['name'];
                    self::$_tipo = $_FILES[$p_InputArquivo]["type"];
                    self::$_tamanho = $_FILES[$p_InputArquivo]["size"];
                    $e = explode(".", self::$_nome); // split by '.'
                    self::$_extensao = $e[count($e)-1]; // get last chunk
                
                    if (self::validarTipoArquivo(self::$_tipo) || self::validarExtensaoArquivo(self::$_extensao)) {             
    
                        /*
                        echo "Upload: " . $_FILES[$p_InputArquivo]["name"] . "<br />";
                        echo "Type: " . $_FILES[$p_InputArquivo]["type"] . "<br />";
                        echo "Size: " . ($_FILES[$p_InputArquivo]["size"] / 1024) . " Kb<br />";
                        echo "Temp file: " . $_FILES[$p_InputArquivo]["tmp_name"] . "<br />";
                        echo "ArquivoTemp: " . $ArquivoTemp. "<br />";
                        echo "ARQ_FORMATO: " . $ARQ_FORMATO. "<br />"; // */
                        if ($p_Nome) self::$_nome = $p_Nome .'.'. self::$_extensao;
    
                        if (move_uploaded_file($_FILES[$p_InputArquivo]["tmp_name"], self::$_caminho . self::$_nome)){
                            self::$_erro = 0;
                            self::$_mensagem = "Arquivo recebido com sucesso.\n (".self::$_caminho.self::$_nome.")";
                            //self::excluirArquivo($_FILES[$p_InputArquivo]);
                            return true;
                        } else {
                            self::$_mensagem = 'Erro ao mover arquivo: ' . $_FILES[$p_InputArquivo]["tmp_name"] . ' >> ' . self::$_caminho.self::$_nome .'';
                            self::$_erro = '903'; 
                            return false;
                        }
                    } else {
                        self::$_mensagem = 'Tipo de Arquivo inválido: ' . self::$_tipo . ' (' . self::$_extensao .')';
                        self::$_erro = '902'; 
                        return false;
                    }
                }
            } else {
                self::$_mensagem = 'O imput file não foi passada por parametro';
                self::$_erro = '901'; 
                return false;
            }
        }catch ( Exception $ex ){ self::$_mensagem = $ex->getMessage(); self::$_erro = $ex->getCode(); return false; }
    }
    
    /**
    *   função para gravar arquivo
    *
    *   @param string $p_InputArquivo O nome do campo do formulario de upload 
    *   @param string $p_Nome O Nome que deve ser gravado o arquivo
    *   @param string $p_Caminho O endereço onde deve ser gravado o arquivo 
    *   @return boolean TRUE Se a gravação for ok
    */
    public static function verificar($p_InputArquivo){
        
        try {
            
            if (isset($_FILES[$p_InputArquivo])){
                if ($_FILES[$p_InputArquivo]["error"] > 0) {
                    // echo "Return Code: " . $_FILES[$p_InputArquivo]["error"] . "<br />";
                    //$ERRO_CODIGO = 82;
                    //$ERRO_MENSAGEM = "[".$_FILES[$p_InputArquivo]["error"]."] Erro tentando receber arquivo: ".$_FILES[$p_InputArquivo]["name"];
    
                    switch ($_FILES[$p_InputArquivo]["error"]) {
                        case 1: /* UPLOAD_ERR_INI_SIZE */
                            throw new Exception("The uploaded file exceeds the upload_max_filesize directive (".ini_get("upload_max_filesize").") in php.ini.", 1);
                            break;
                        case 2: /* UPLOAD_ERR_FORM_SIZE */
                            throw new Exception("The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.", 2);
                            break;
                        case 3: /* UPLOAD_ERR_PARTIAL */
                            throw new Exception("The uploaded file was only partially uploaded.", 3);
                            break;
                        case 4: /* UPLOAD_ERR_NO_FILE */
                            throw new Exception("No file was uploaded.", 0);
                            break;
                        case 6: /* UPLOAD_ERR_NO_TMP_DIR */
                            throw new Exception("Missing a temporary folder.", 6);
                        default: /* ? */
                            throw new Exception("An unknown file upload error occured".$_FILES[$p_InputArquivo]["error"], $_FILES[$p_InputArquivo]["error"]);
                    }            
                    // $ERRO_NOTAS = $_FILES[$p_InputArquivo]["error"];
                    //header("Location: "."erro.php?e_tit=".$ERRO_TITULO."&e_cod=".$ERRO_CODIGO."&e_msg=".$ERRO_MENSAGEM."&e_not=".$ERRO_NOTAS);
                    return false;
                    
                } else {
                    
                    // Seta Variaveis do Arquivo
                    self::$_nome = $_FILES[$p_InputArquivo]['name'];
                    self::$_tipo = $_FILES[$p_InputArquivo]["type"];
                    self::$_tamanho = $_FILES[$p_InputArquivo]["size"];
                    $e = explode(".", self::$_nome); // split by '.'
                    self::$_extensao = $e[count($e)-1]; // get last chunk
                
                    if (self::validarTipoArquivo(self::$_tipo) || self::validarExtensaoArquivo(self::$_extensao)) {             
                        self::$_erro = 0;
                        self::$_mensagem = "Arquivo recebido com sucesso.\n (".self::$_caminho.self::$_nome.")";
                        //self::excluirArquivo($_FILES[$p_InputArquivo]);
                        return true;
                    } else {
                        self::$_mensagem = 'Tipo de Arquivo inválido: ' . self::$_tipo . ' (' . self::$_extensao .')';
                        self::$_erro = '902'; 
                        return false;
                    }
                }
            } else {
                self::$_mensagem = 'O imput file não foi passada por parametro';
                self::$_erro = '901'; 
                return false;
            }
        }catch ( Exception $ex ){ self::$_mensagem = $ex->getMessage(); self::$_erro = $ex->getCode(); return false; }
    }
    
    /**
    *   função para Criar arquivo (Este Não substitui o existente)
    *
    *   @param string $p_InputArquivo O nome do campo do formulario de upload 
    *   @param string $p_Nome O Nome que deve ser gravado o arquivo
    *   @param string $p_Caminho O endereço onde deve ser gravado o arquivo 
    *   @return boolean TRUE Se a gravação for ok
    */
    public static function criarArquivo($p_InputArquivo, $p_Nome = null, $p_Caminho = null){

        try {  
            if ($p_Caminho) self::$_caminho = $p_Caminho;

            if ($_FILES[$p_InputArquivo]["error"] > 0) {
                return false;
            } else {
                // Seta Variaveis do Arquivo
                self::$_nome = $_FILES[$p_InputArquivo]['name'];
                
                if (!is_file(self::$_caminho . self::$_nome)){  
                    return self::gravarArquivo($p_InputArquivo, $p_Nome, $p_Caminho);
                } else {
                    throw new Exception("Já existe um arquivo na base de dados este nesmo nome. (".self::$_caminho . self::$_nome.")", 0);
                    //break;
                }
            }
        }catch ( Exception $ex ){ self::$_mensagem = $ex->getMessage(); self::$_erro = $ex->getCode(); return false; }
        
    }

    /**
    *   função para excluir(excluir) arquivo 
    *
    *   @param string $p_Nome O Nome que deve ser gravado o arquivo
    *   @param string $p_Caminho O endereço onde deve ser gravado o arquivo 
    *   @return boolean TRUE Se a remoção for ok
    */
    public static function excluirArquivo($p_Nome, $p_Caminho = null){
        $arquivo = $p_Nome;
        if ($p_Caminho)
            $arquivo = $p_Caminho.$p_Nome;
        else 
            $arquivo = self::$_caminho.$p_Nome;
        
        if (is_file($arquivo)){  
            /* echo "Arquivo existe:".$arquivo."<br/>"; */ 
            return @unlink($arquivo);;
        } else {
            /* echo "Arquivo não encontrado:".$arquivo."<br/>"; */ 
        }
    }

    /**
    *   função para ler o binario do Arquivo (padrão PostgreSQL)
    *
    *   @param string $p_Nome O Nome de Arquivo 
    *   @param string $p_Caminho O Path do Arquivo 
    *   @return string birario do arquivo
    */
    public static function prepararDBString($p_Nome, $p_Caminho = null){
        $arquivo = $p_Nome;
        if ($p_Caminho){
            $arquivo = $p_Caminho.$p_Nome;
        } else {
            if (is_file($p_Nome)){
                $arquivo = $p_Nome;
            } else if (is_file(self::$_caminho.$p_Nome)){
                $arquivo = self::$_caminho.$p_Nome;
            } else {
                return null;
            }
        }
        $out = null;
        $handle = @fopen($arquivo, 'rb');
        if ($handle)
        {
            $content = @fread($handle, filesize($arquivo));
            $content = bin2hex($content);
            @fclose($handle);
            $out = "0x".$content;
        }
        return $out;
    
    }
    
    /**
    *   função para ler o binario do Arquivo
    *
    *   @param string $p_Nome O Nome de Arquivo 
    *   @param string $p_Caminho O Path do Arquivo 
    *   @return string birario do arquivo
    */
    public static function getBinario($p_Nome, $p_Caminho = null){
        $arquivo = $p_Nome;
        if ($p_Caminho){
            $arquivo = $p_Caminho.$p_Nome;
        } else {
            if (is_file($p_Nome)){
                $arquivo = $p_Nome;
            } else if (is_file(self::$_caminho.$p_Nome)){
                $arquivo = self::$_caminho.$p_Nome;
            } else {
                return null;
            }
        }
        return file_get_contents($arquivo);
    }
    
    /**
    *   função para Validar Tipo de arquivo
    *
    *   @param string $p_tipo O Tipo de Arquivo 
    *   @return boolean TRUE Se a gravação for ok
    */
    public static function getContentType($p_extensao){
        
        $retorno = '';
        switch (strtolower($p_extensao)) {
            case "jpg": $retorno = "image/jpeg"; break; 
            case "pjpeg": $retorno = "image/pjpeg";    break;
            case "gif": $retorno = "image/gif"; break;    
            case "png": $retorno = "image/png"; break;
            case "tif": $retorno = "image/tiff"; break;
            case "tiff": $retorno = "image/tiff"; break;
            case "pdf": $retorno = "application/pdf"; break;
            case "doc": $retorno = "application/msword"; break;
            case "docx": $retorno = "application/msword"; break;
            case "xls": $retorno = "application/vnd.ms-excel"; break;
            case "ppt": $retorno = "application/ms-powerpointl"; break;
            case "xml": $retorno = "text/xml"; break;
            case "html": $retorno = "text/html"; break;
            default: $retorno = "text/text"; break;   
        }
        return $retorno;
    }    
    
    
}