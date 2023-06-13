<?php
/**
 * Classe para Criptografia de e Descriptografia textos
 * @author  Kellen Nery
 */
class Criptografia {
    
    // Parâmetros de paginacao
    private static $encrypt_method = "AES-256-CBC";
    private static $secret_key = 'A6B54863-A75E-4329-A487-C21DB5D740FF';
    private static $secret_iv = 'secret_iv_string';
    
    /**
     * simple method to encrypt or decrypt a plain text string
     * initialization vector(IV) has to be the same when encrypting and decrypting
     * PHP 5.4.9
     *
     * this is a beginners template for simple encryption decryption
     * before using this in production environments, please read about encryption
     *
     * @param string $string: string to encrypt or decrypt
     *
     * @return string
     */
    public static function encode($string) {
        $output = false;
        // hash
        $key = hash('sha256', self::$secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', self::$secret_iv), 0, 16);

        $output = openssl_encrypt($string, self::$encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);

        return $output;
    }

    /**
     * simple method to encrypt or decrypt a plain text string
     * initialization vector(IV) has to be the same when encrypting and decrypting
     * PHP 5.4.9
     *
     * this is a beginners template for simple encryption decryption
     * before using this in production environments, please read about encryption
     *
     * @param string $string: string to encrypt or decrypt
     *
     * @return string
     */
    public static function decode($string) {
        $output = false;

        // hash
        $key = hash('sha256', self::$secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', self::$secret_iv), 0, 16);

        $output = openssl_decrypt(base64_decode($string), self::$encrypt_method, $key, 0, $iv);

        return $output;
    }
    
    /* 
    // Usage
    // Named-based UUID.
    $chave = Criptografia::encode('minha-senha');
    Console.Write("Criptografia::encode('minha-senha')=" . $chave);
    Console.Write("Criptografia::decode('$chave')=" . Criptografia::decode($chave));
    // */
}