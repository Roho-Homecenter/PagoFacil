<?php

class cryp_3DES {  

    /**
     * input = dato a encriptar en formato cadena
     * 
     * tcKeyCipher = llave de cifrado
     */
    public static function encryptWithKEy($input, $tcKeyCipher){
        $lenght=strlen($input);
        $input=str_pad($input,($lenght+8-($lenght%8)), "\0");
        return base64_encode(openssl_encrypt($input, "DES-EDE3", $tcKeyCipher,OPENSSL_ZERO_PADDING));
    }



    public static function decryptWithKEy($encrypted, $tcKeyCipher){
        return openssl_decrypt(base64_decode($encrypted), 'DES-EDE3', $tcKeyCipher, OPENSSL_ZERO_PADDING);
    }
}