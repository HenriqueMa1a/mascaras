<?php
/**
 * Classe de utilidades para tratamento de Data e Hora
 * @author  Kellen Nery
 */
class DataHora {

    private static $data;
    private static $hora;
 
    /**
    *   função para calcular data 
    *
    *   @param string $campo O CPF/CNPJ que será formatado ou desformatado
    *   @param boolean TRUE $formato Flag que indica se o campo vai ser formatado ou desformatado
    *   @return string $campo O resultado da formatação
    */
    public static function setDataHora($data="",$hora="")    {

        if($hora==""){
            $hora = date("H:i:s");
        }

        if($data==""){
            $data = date("d/m/Y ");
        } else if (self::validarData($data,"d")) {
            die ("Padrao de data ($data) invalido! - Padrao = 15/01/2007");
        }

        self::$data = explode("/",$data);
        self::$hora = explode(":",$hora);
    }

    public static function getData(){
        return self::$data[0]."/".self::$data[1]."/".self::$data[2];
    }
    
    public static function setData($data=""){
        if($data==""){
            $data = date("d/m/Y ");
        } else if (self::validarData($data,"d")) {
            die ("Padrao de data ($data) invalido! - Padrao = 15/01/2007");
        }
        self::$data = explode("/",$data);
    }
    
    public static function getHora(){
        return self::$hora[0].":".self::$hora[1].":".self::$hora[2];
    }
    
    public static function setHora($hora=""){
        if($hora==""){
            $hora = date("H:i:s");
        }
        self::$hora = explode(":",$hora);
    }
    
    private static function validarData($data,$op){

        switch($op){

            case "d": // Padrao: 15/01/2007

                $er = "/(([0][1-9]|[1-2][0-9]|[3][0-1])\/([0][1-9]|[1][0-2])\/([0-9]{4}))/";
                if(preg_match($er,$data)){
                    return 0;
                } else{
                    return 1;
                }

            break;

            case "dh": // Padrao 15/01/2007 10:30:00

                $er = "/(([0][1-9]|[1-2][0-9]|[3][0-1])\/([0][1-9]|[1][0-2])\/([0-9]{4})*)/";
                if(preg_match($er,$data)){
                    return 0;
                } else {
                    return 1;
                }

            break;

        }

    }

    // DATA
    public static function somaDia($data, $dias=1){

        self::setDataHora($data);

        self::setDataHora(strftime("%d/%m/%Y", mktime(0, 0, 0, self::$data[1], self::$data[0]+$dias, self::$data[2])),"");
        return self::$data[0]."/".self::$data[1]."/".self::$data[2];
    }

    public static function somaMes($data, $meses=1){

        self::setDataHora($data);
        
        self::setDataHora(strftime("%d/%m/%Y", mktime(0, 0, 0, self::$data[1]+$meses, self::$data[0], self::$data[2])),"");
        return self::$data[0]."/".self::$data[1]."/".self::$data[2];
    }

    public static function somaAno($data, $anos=1){

        self::setDataHora($data);
    
        self::setDataHora(strftime("%d/%m/%Y", mktime (0, 0, 0, self::$data[1], self::$data[0], self::$data[2]+$anos)),"");
        return self::$data[0]."/".self::$data[1]."/".self::$data[2];
    }

    // HORA
    public static function somaSegundo($data, $segundos=1){

        self::setDataHora($data);

        self::setDataHora("",strftime("%H:%M:%S",mktime(self::$hora[0],self::$hora[1],self::$hora[2]+$segundos, 0, 0, 0)));
        return self::$hora;
    }

    public static function somaMinuto($data, $minutos=1){

        self::setDataHora($data);

        self::setDataHora("",strftime("%H:%M:%S",mktime(self::$hora[0],self::$hora[1]+$minutos,self::$hora[2], 0, 0, 0)));
        return self::$hora;
    }

    public static function somaHora($data, $horas=1){

        self::setDataHora($data);

        self::setDataHora("",strftime("%H:%M:%S",mktime(self::$hora[0]+$horas,self::$hora[1],self::$hora[2], 0, 0, 0)));
        return self::$hora;
    }
 
     /**
    *   função para calcular diferença entre data e hora 
    *
    *   @param string $datamenor A Data menor que será feita ca diferença
    *   @param string $datamaior A Data maior que será feita ca diferença
    *   @param string $tipo O Tipo de resultado que deseja diferença (s, m, h, D, d, M)
    *   @return string $campo O resultado da diferença
    */
    public static function diferencaDataHora($datamenor, $datamaior="", $tipo="", $sep='/'){

        if(self::validarData($datamenor,"dh")){
            die ("data errada - $datamenor");
        }

        if($datamaior==""){
            $datamaior = date("d/m/Y H:i:s");
        }

        if($tipo==""){
            $tipo = "h";
        }
        
        list ($diamenor, $mesmenor, $anomenor, $horamenor, $minutomenor, $segundomenor) = explode("[: -]",$datamenor);
        list ($diamaior, $mesmaior, $anomaior, $horamaior, $minutomaior, $segundomaior) = explode("[: -]",$datamaior);

        $segundos = mktime($horamaior,$minutomaior,$segundomaior,$mesmaior,$diamaior, $anomaior)-mktime($horamenor,$minutomenor,$segundomenor,$mesmenor,$diamenor, $anomenor);

        switch($tipo){
            case "s": // Segundo
                $diferenca = $segundos;
            break;

            case "n": // Minuto
                $diferenca = ($segundos/60);
            break;

            case "H": // Hora
                $diferenca = ($segundos/3600);
            break;

            case "h": // Hora Arredondada
                $diferenca = floor($segundos/3600);
            break;

            case "D": // Dia
                $diferenca = floor($segundos/86400);
            break;

            case "d": // Dia Arredondado
                $diferenca = floor($segundos/86400);
            break;

            case "m": // Mes 
                $diferenca = ($segundos/2592000);
            break;
            
            case "M": // Mes Arredondado
                $diferenca = floor($segundos/2592000);
            break;
            
            case "a": // Ano 
            case "y": // Ano Arredondado
                $diferenca = ($segundos/31536000);
            break;
            
            case "A": // Ano Arredondado
            case "Y": // Ano Arredondado
                $diferenca = floor($segundos/31536000);
            break;
        }
        return $diferenca;

    }

    /**
    *   função para calcular diferença entre datas 
    *
    *   @param string $datamenor A Data menor que será feita ca diferença
    *   @param string $datamaior A Data maior que será feita ca diferença
    *   @param string $tipo O Tipo de resultado que deseja diferença (D, d, M)
    *   @return string $campo O resultado da diferença
    */
    public static function diferencaData($datamenor, $datamaior="", $tipo=""){

        if ($datamenor==''){
            if(self::validarData($datamaior,"d")){
                die ("data errada - $datamaior");
            }
            $datamenor = date("d/m/Y");
        } else {
            if(self::validarData($datamenor,"d")){
                die ("data errada - $datamenor");
            }
        }
        if($datamaior=='') $datamaior = date("d/m/Y"); 
        if($tipo=="") $tipo = "d";

        //list ($diamenor, $mesmenor, $anomenor) = split("[/: ]",$datamenor);
        //list ($diamaior, $mesmaior, $anomaior) = split("[/: ]",$datamaior);
        list ($diamenor, $mesmenor, $anomenor) = explode("/",$datamenor);
        list ($diamaior, $mesmaior, $anomaior) = explode("/",$datamaior);

        
        $segundos = mktime(0, 0, 0, $mesmaior, $diamaior, $anomaior)-mktime(0, 0, 0, $mesmenor, $diamenor, $anomenor);
        switch($tipo){
            case "d": // Dia
                $diferenca = ($segundos/86400);
            break;

            case "D": // Dia Arredondado
                $diferenca = floor($segundos/86400);
            break;

            case "m": // Mes 
                $diferenca = ($segundos/2592000);
            break;
            
            case "M": // Mes Arredondado
                $diferenca = floor($segundos/2592000);
            break;
            
            case "a": // Ano Arredondado
            case "y": // Ano Arredondado
                //$diferenca = ($segundos / 31536000);
                $diferenca = ((((($segundos) / 60) / 60) / 24) / 365.25);
            break;

            case "A": // Ano Arredondado
            case "Y": // Ano Arredondado
                //$diferenca = floor($segundos / 31536000);
                $diferenca = floor((((($segundos) / 60) / 60) / 24) / 365.25);
            break;
        }
        return $diferenca;
    }

    /**
    *   função para retornar a data do ultimo dia do mês.
    *
    *   @param string $data A Data do um dia do mês 
    *   @return string $data O Data do ultimo dia do mês da diferença
    */    
    public static function ultimoDataMes($data){
        /*Desmembrando a Data*/
        list($newDia, $newMes, $newAno) = explode("/", $data);
        return date("d/m/Y", mktime(0, 0, 0, $newMes+1, 0, $newAno));
    }    
    
    /**
    *   função para retornar a idade .
    *
    *   @param string $data A Data de Nascimento 
    *   @return string $data A Idade 
    */    
    public static function getIdade($data){
        // Separa em dia, mês e ano
        if (strpos($data, "/")===false){
            if (stripos($data, "-")===false){
                return 0;
            } else {
                list($ano, $mes, $dia) = explode('-', $data);
            }
        } else {
            list($dia, $mes, $ano) = explode('/', $data);
        }
        
        // Descobre que dia é hoje e retorna a unix timestamp
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        
        // Descobre a unix timestamp da data de nascimento do fulano
        $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
       
        // Depois apenas fazemos o cálculo já citado :)
        $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);

        return $idade;

    }    
    
}