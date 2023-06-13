<?php
/**
 * Classe de utilidades para Formatação de dados
 * @author  Kellen Nery
 */
class Formatacao {

    /**
    *   função para formatar ou desformatar CPF/CNPJ 
    *
    *   @param string $campo O CPF/CNPJ que será formatado ou desformatado
    *   @param boolean TRUE $formato Flag que indica se o campo vai ser formatado ou desformatado
    *   @return string $campo O resultado da formatação
    */
    private static function formatarCPF_CNPJ($campo, $formatado = true){
        //retira formato
        $codigoLimpo = preg_replace("/[^0-9]/","", $campo); 
        // pega o tamanho da string menos os digitos verificadores
        $tamanho = (strlen($codigoLimpo) -2);
        //verifica se o tamanho do código informado é válido
        if ($tamanho != 9 && $tamanho != 12){
            return false;
        }
     
        if ($formatado){
            // seleciona a máscara para cpf ou cnpj
            $mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##';
     
            $indice = -1;
            for ($i=0; $i < strlen($mascara); $i++) {
                if ($mascara[$i]=='#') $mascara[$i] = $codigoLimpo[++$indice];
            }
            //retorna o campo formatado
            $retorno = $mascara;
     
        }else{
            //se não quer formatado, retorna o campo limpo
            $retorno = $codigoLimpo;
        }
     
        return $retorno;
     
    }

    /**
    *   função para formatar ou desformatar CPF 
    *
    *   @param string $campo O CPF que será formatado ou desformatado
    *   @param boolean TRUE $formato Flag que indica se o campo vai ser formatado ou desformatado
    *   @return string $campo O resultado da formatação
    */
    public static function formatarCPF($campo, $formatado = true){
        return self::formatarCPF_CNPJ($campo, $formatado);
    }

    /**
    *   função para formatar ou desformatar CNPJ usando a mascara
    *
    *   @param string $campo O CNPJ que será formatado ou desformatado
    *   @param boolean TRUE $formato Flag que indica se o campo vai ser formatado ou desformatado
    *   @return string $campo O resultado da formatação
    */
    public static function formatarCNPJ($campo, $formatado = true){
        return self::formatarCPF_CNPJ($campo, $formatado);
    }

    /**
    *   função para formatar ou desformatar CEP
    *
    *   @param string $campo O CEP que será formatado ou desformatado
    *   @param boolean TRUE $formato Flag que indica se o campo vai ser formatado ou desformatado
    *   @return string $campo O resultado da formatação
    */
    public static function formatarCEP($campo, $formatado = true){
         //retira formato
        $codigoLimpo = preg_replace("/[^0-9]/","", $campo); 

        // pega o tamanho da string menos os digitos verificadores
        $tamanho = strlen($codigoLimpo);
        
        //return $tamanho;
        //verifica se o tamanho do código informado é válido
        if ($tamanho != 8) return $false;
     
        if ($formatado){
            // seleciona a máscara para CEP
            $mascara = '#####-###';
     
            $indice = -1;
            for ($i=0; $i < strlen($mascara); $i++) {
                if ($mascara[$i]=='#') $mascara[$i] = $codigoLimpo[++$indice];
            }
            //retorna o campo formatado
            $retorno = $mascara;
     
        }else{
            //se não quer formatado, retorna o campo limpo
            $retorno = $codigoLimpo;
        }
        return $retorno;
     
    }

    /**
    *   função para formatar ou desformatar Telefone
    *
    *   @param string $campo O Telefone que será formatado ou desformatado
    *   @param boolean TRUE $formato Flag que indica se o campo vai ser formatado ou desformatado
    *   @return string $campo O resultado da formatação
    */
    public static function formatarTelefone($campo, $formatado = true){
        //retira formato
        $codigoLimpo = preg_replace("/[^0-9]/","", $campo); 
        // pega o tamanho da string menos os digitos verificadores
        $tamanho = strlen($codigoLimpo);
        //verifica se o tamanho do código informado é válido
        if ($tamanho != 8 && $tamanho != 10){
            return false;
        }
     
        if ($formatado){
            // seleciona a máscara para cpf ou cnpj
            $mascara = ($tamanho == 8) ? '####-####' : '(##) ####-####';
     
            $indice = -1;
            for ($i=0; $i < strlen($mascara); $i++) {
                if ($mascara[$i]=='#') $mascara[$i] = $codigoLimpo[++$indice];
            }
            //retorna o campo formatado
            $retorno = $mascara;
     
        }else{
            //se não quer formatado, retorna o campo limpo
            $retorno = $codigoLimpo;
        }
        return $retorno;
     
    }

    /**
    *   função para formatar ou desformatar Data SQL
    *
    *   @param string $campo O Telefone que será formatado ou desformatado
    *   @param boolean TRUE $formato Flag que indica se o campo vai ser formatado ou desformatado
    *   @return string $campo O resultado da formatação
    */
    public static function formatarDataSQL($campo, $formatado = true){
        $retorno = '';
        
        if (!(strpos($campo, " ")===false)){
            $parte = explode(" ", $campo); // fatia a string $dat em pedados, usando / como referência
            $campo = $parte[0]; // fatia a string $dat em pedados, usando / como referência
        }
        
        if ($formatado){
            $data = explode("/", $campo); // fatia a string $dat em pedados, usando / como referência
            $d = $data[0];
            $m = $data[1];
            $y = $data[2];    
            $retorno = $y.'-'.$m.'-'.$d;
        } else {
            $data = explode("-", $campo); // fatia a string $dat em pedados, usando / como referência
            $y = $data[0];    
            $m = $data[1];
            $d = $data[2];
            $retorno = $d.'/'.$m.'/'.$y;
        }
        return $retorno;
    }

    /**
    *   função para formatar ou desformatar Data SQL
    *
    *   @param string $campo O Telefone que será formatado ou desformatado
    *   @param boolean TRUE $formato Flag que indica se o campo vai ser formatado ou desformatado
    *   @return string $campo O resultado da formatação
    */
    public static function formatarDataHoraSQL($campo, $formatado = true){
        $retorno = '';
        
        if ($formatado){
            $parte = explode(" ", $campo); // fatia a string $dat em pedados, usando / como referência

            $data = explode("/", $parte[0]); // fatia a string $dat em pedados, usando / como referência
            $d = $data[0];
            $m = $data[1];
            $y = $data[2];    
            $retorno = $y.'-'.$m.'-'.$d;
            if (isset($parte[1])) $retorno.= ' '.$parte[1];
        } else {
            $parte = explode(" ", $campo); // fatia a string $dat em pedados, usando / como referência

            $data = explode("-", $parte[0]); // fatia a string $dat em pedados, usando / como referência
            $y = $data[0];    
            $m = $data[1];
            $d = $data[2];
            $retorno = $d.'/'.$m.'/'.$y;
            if (isset($parte[1])){
                            $pos = strrpos($parte[1], '.');
                            if ($pos===false) {
                               $retorno.= ' '.$parte[1];
                            } else { 
                                $retorno.= ' '.substr($parte[1], 0, $pos);
                            }
                        }
        }
        return $retorno;
    }
    
    /**
    *   função para limpar formatação de campo
    *
    *   @param string $campo O Telefone que será formatado ou desformatado
    *   @return string $campo O resultado da formatação
    */
    public static function limparFormatacao($campo){
        
        //$retorno =  str_replace(".", "", str_replace("-", "", str_replace("/", "", str_replace("-", "", $campo))));
        //return $retorno;
        $str = $campo;
        $str = preg_replace('/[^a-z0-9]/i', '', $str);
        $str = preg_replace('/_+/', '', $str);
        return $str;
    }

    /**
    *   função para truncar valores numéricosde campo
    *
    *   @param double $curValor O Valor que será truncado
    *   @return string $intDecimais O número de casas decimais que serão truncados
    */
    public static function truncar($curValor, $intDecimais){
        
        $curValor=intval($curValor*intval((10^$intDecimais)));
        $curValor=$curValor/intval((10^$intDecimais));
        $retorno=$curValor;
        return $retorno;
    }
    
    /**
    *   função para excluir acentos e caracteres especiais
    *
    *   @param string $texto O Texto que será removido os acentos
    *   @return string $retorno O Texto limpo
    */
    public static function excluirAcentos($texto){
        $str = $texto;
        $str = preg_replace('/[áàãâä]/ui', 'a', $str);
        $str = preg_replace('/[éèêë]/ui', 'e', $str);
        $str = preg_replace('/[íìîï]/ui', 'i', $str);
        $str = preg_replace('/[óòõôö]/ui', 'o', $str);
        $str = preg_replace('/[úùûü]/ui', 'u', $str);
        $str = preg_replace('/[ç]/ui', 'c', $str);
        return $str;
    } 
    
    /**
    *   função para converte Texto em Link
    *
    *   @param string $texto O Texto que será convertido
    *   @return string $retorno O Link gerado pelo texto
    */
    public static function textoToLink($texto){
        $str = $texto;
        $str = preg_replace('/[áàãâä]/ui', 'a', $str);
        $str = preg_replace('/[éèêë]/ui', 'e', $str);
        $str = preg_replace('/[íìîï]/ui', 'i', $str);
        $str = preg_replace('/[óòõôö]/ui', 'o', $str);
        $str = preg_replace('/[úùûü]/ui', 'u', $str);
        $str = preg_replace('/[ç]/ui', 'c', $str);
        // $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
        $str = preg_replace('/[^a-z0-9]/i', '_', $str);
        $str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)
        return $str;
    }
        
}