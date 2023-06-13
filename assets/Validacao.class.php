<?php
/**
 * Classe de utilidades para Validação de Campos
 * 
 * @author  Kellen Nery
 */
class Validacao {

    /**
    *   Função para validar e-mail usando expressão regular
    *
    *   @param string $valor O e-mail para o teste de validarção
    *   @return boolean TRUE Se string $mail passar pela validarção
    */
    public static function validarEmail($valor) {
        $conta = "/^[a-zA-Z0-9\._-]+@";
        $domino = "[a-zA-Z0-9\._-]+.";
        $extensao = "([a-zA-Z]{2,4})$/";

        $padrao = $conta.$domino.$extensao;
        
        if (preg_match($padrao, trim($valor)))
            return true;
        else
            return false;
    }

    /**
    *   função para validar URL usando expressão regular
    *
    *   @param string $valor A URL para o teste de validarção
    *   @return boolean TRUE Se string $mail passar pela validarção
    */
    public static function validarURL($valor) {
        $domino = "/^[a-zA-Z0-9\._-]+.";
        $extensao = "([a-zA-Z]{2,4})$/";

        $padrao = $domino.$extensao;

        if (preg_match($padrao, trim($valor)))
            return true;
        else
            return false;
    }

    /**
    *   função para validar data usando expressão regular
    *
    *   @param string $valor A data para o teste de validarção
    *   @return boolean TRUE Se string $mail passar pela validarção
    */
    public static function validarData($valor) {
        $padrao = "/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/";

        if (preg_match($padrao, trim($valor))) {
        
            $data = explode("/","$valor"); // fatia a string $dat em pedados, usando / como referência
            $d = $data[0];
            $m = $data[1];
            $y = $data[2];
        
            return checkdate($m,$d,$y);
        } else
            return false;
    }

    /**
    *   função para validar CEP usando expressão regular
    *
    *   @param string $valor O CEP para o teste de validarção
    *   @return boolean TRUE Se string $mail passar pela validarção
    */
    public static function validarCEP($valor) {
        $padrao = "/^[0-9]{5}-[0-9]{3}$/";

        if (preg_match($padrao, trim($valor)))
            return true;
        else
            return false;
    }

    /**
    *   função para validar IP usando expressão regular
    *
    *   @param string $valor O IP para o teste de validarção
    *   @return boolean TRUE Se string $mail passar pela validarção
    */
    public static function validarIP($valor) {
        $padrao = "/^([0-9]{1,3}\.){3}[0-9]{1,3}$/";

        if (preg_match($padrao, trim($valor)))
            return true;
        else
            return false;
    }

    /**
    *   função para validar Telefone usando expressão regular
    *
    *   @param string $valor O Telefone para o teste de validarção no formato: 9999-9999
    *   @return boolean TRUE Se string $mail passar pela validarção
    */
    public static function validarTelefone($valor) {
        $padrao = "/^[0-9]{4}-[0-9]{4}$/";

        if (preg_match($padrao, trim($valor)))
            return true;
        else
            return validarTelefoneComDDD($valor);
    }

    /**
    *   função para validar Telefone com DDD usando expressão regular
    *
    *   @param string $valor O Telefone com DDD para o teste de validarção no formato: (99) 9999-9999
    *   @return boolean TRUE Se string $mail passar pela validarção
    */
    public static function validarTelefoneComDDD($valor) {
        $padrao = "/^\([0-9]{2}\) [0-9]{4}-[0-9]{4}$/";

        if (preg_match($padrao, trim($valor)))
            return true;
        else
            return false;
    }

    /**
     *   função para validar CPF usando expressão regular
     *
     *   @param string $valor O CPF para o teste de validarção no formato: 999.999.999-99
     * 
     *   @return boolean true|false Se string $mail passar pela validarção
     */
    public static function validarCPF($valor) {
        $padrao = "/^([0-9]){3}\.([0-9]){3}\.([0-9]){3}-([0-9]){2}$/";
        $padraoLimpo = "/^([0-9]){11}$/";

        if (preg_match($padrao, trim($valor)) || preg_match($padraoLimpo, trim($valor))){
            // Formato Válido
            // agora validar o algorítimo de formação do CPF.
            $cpf = preg_replace ("@[./-]@", "", $valor);

            
            $nulos = array("12345678909","11111111111","22222222222","33333333333",
                           "44444444444","55555555555","66666666666","77777777777",
                           "88888888888","99999999999","00000000000");
                           
            /*Retorna falso se houver letras no cpf */
            if (!(preg_match("/^[0-9]/",$cpf)))
                return false;

            /* Retorna falso se o cpf for nulo */
            if( in_array($cpf, $nulos) )
                return false;

            /*Calcula o penúltimo dígito verificador*/
            $acum=0;
            for($i=0; $i<9; $i++) {
              $acum+= $cpf[$i]*(10-$i);
            }

            $x=$acum % 11;
            $acum = ($x>1) ? (11 - $x) : 0;
            /* Retorna falso se o digito calculado eh diferente do passado na string */
            if ($acum != $cpf[9]){
              return false;
            }
            /*Calcula o último dígito verificador*/
            $acum=0;
            for ($i=0; $i<10; $i++){
              $acum+= $cpf[$i]*(11-$i);
            }  

            $x=$acum % 11;
            $acum = ($x > 1) ? (11-$x) : 0;
            /* Retorna falso se o digito calculado eh diferente do passado na string */
            if ( $acum != $cpf[10]){
              return false;
            }  
            /* Retorna verdadeiro se o cpf eh valido */
            return true;

        }else {
            return false;
        }
    }

    /**
    *   função para validar CNPJ usando expressão regular
    *
    *   @param string $valor O CNPJ para o teste de validarção no formato: 99.999.999/9999-99
    *   @return boolean TRUE Se string $mail passar pela validarção
    */
    public static function validarCNPJ($valor) {
        $padrao = "/^([0-9]){2}\.([0-9]){3}\.([0-9]){3}\/([0-9]){4}-([0-9]){2}$/";

        if (preg_match($padrao, trim($valor))){
            
            $str = preg_replace ("@[./-]@", "", $valor);
            
            if (strlen($str) <> 14) return false;

            $soma = 0;

            $soma += ($str[0] * 5);
            $soma += ($str[1] * 4);
            $soma += ($str[2] * 3);
            $soma += ($str[3] * 2);
            $soma += ($str[4] * 9);
            $soma += ($str[5] * 8);
            $soma += ($str[6] * 7);
            $soma += ($str[7] * 6);
            $soma += ($str[8] * 5);
            $soma += ($str[9] * 4);
            $soma += ($str[10] * 3);
            $soma += ($str[11] * 2);

            $d1 = $soma % 11;
            $d1 = $d1 < 2 ? 0 : 11 - $d1;

            $soma = 0;
            $soma += ($str[0] * 6);
            $soma += ($str[1] * 5);
            $soma += ($str[2] * 4);
            $soma += ($str[3] * 3);
            $soma += ($str[4] * 2);
            $soma += ($str[5] * 9);
            $soma += ($str[6] * 8);
            $soma += ($str[7] * 7);
            $soma += ($str[8] * 6);
            $soma += ($str[9] * 5);
            $soma += ($str[10] * 4);
            $soma += ($str[11] * 3);
            $soma += ($str[12] * 2);


            $d2 = $soma % 11;
            $d2 = $d2 < 2 ? 0 : 11 - $d2;

            if ($str[12] == $d1 && $str[13] == $d2) {
                return true;
            }
            else {
                return false;
            }
            
        } else
            return false;
    }
    
}
/* 
 
Expressões regulares são uma funcionalidade incrível… É possível interagir com strings e verificar a sua sintaxe…

Normalmente se usa regexp (Regular Expression) pra algumas tarefas simples mas muito úteis: como validar um e-mail, validar uma url, validar a formatação de uma senha que precise ter no minimo 2 letras, 6 números e 7 caracteres… Isso tudo pode e deve ser validardo com expressões regulares.

Antes de mostrar o código da validarção de e-mail, vou fazer uma breve introdução aos possíveis “formatos” de uma regexp… Nem todas serão usadas, mas é bom que vocês já vejam tudo que é possível fazer:

    \s -> Significa um espaço em branco
    ^ -> Significa o início da string
    $ -> Significa o fim da string
    . -> Significa qualquer caractere
    (bola|casa) -> Significa bola ou casa
    [0-9] ->Significa qualquer número entre zero e nove
    [a-z] -> Significa qualquer letra minúscula
    [A-Z] -> Significa qualquer letra maiúscula
    [a-zA-Z] -> Qualquer letra maiúscula ou minúscula
    [^a-z] -> Significa a não ocorrência (falta / proibição) de letras minúsculas. O circunflexo (^) tem significado de ‘não existe’
    ? -> Significa nenhuma ou uma ocorrência caractere anterior
    * -> Significa nenhuma ou várias ocorrências do caractere anterior
    + -> Significa – no mínimo – uma ocorrência do caractere anterior
    {3} -> Significa exatamente três caracteres
    {3,} -> Significa três ou mais caracteres
    {3,6} -> Significa entre três e seis caracteres, pode ser 4, 5 também

Mas calma… Onde isso tudo vai?

Vamos a um exemplo simpes… 
    Uma regexp pra verificar um nome de usuario que precise ter no mínimo 5 caracteres e possa ser composto apenas por letras minusculas e números: ^[a-z0-9]{5,}$

O nome desse ‘bloco’ da regexp é chamado pattern, ou padrão. Ao validar uma string você compara um pattern com uma string, e se ela validar, ou seja, cumprir as condições, a string está dentro do formato.
*/