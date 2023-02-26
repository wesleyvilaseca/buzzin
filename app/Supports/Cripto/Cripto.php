<?php

namespace App\Supports\Cripto;

use Exception;

trait Cripto
{
    private static $metodo  = 'aes-256-ctr';
    /**
     * Encrypts (but does not authenticate) a message
     * 
     * @param string $message - plaintext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encode - set to TRUE to return a base64-encoded 
     * @return string (raw binary)
     */
    public static function encrypt($message, $encode = true)
    {
        $key = env('CRIPTO_KEY');
        $nonceSize = openssl_cipher_iv_length(self::$metodo);
        $nonce = openssl_random_pseudo_bytes($nonceSize);

        $ciphertext = openssl_encrypt(
            json_encode($message),
            self::$metodo,
            $key,
            OPENSSL_RAW_DATA,
            $nonce
        );

        // Now let's pack the IV and the ciphertext together
        // Naively, we can just concatenate
        if ($encode) {
            return self::base64url_encode($nonce . $ciphertext);
        }
        return $nonce . $ciphertext;
    }

    /**
     * Decrypts (but does not verify) a message
     * 
     * @param string $message - ciphertext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encoded - are we expecting an encoded string?
     * @return string
     */
    public static function decrypt($message, $encoded = true)
    {
        $key = env('CRIPTO_KEY');

        if ($encoded) {
            $message = self::base64url_decode($message);
            if ($message === false) {
                throw new Exception('Encryption failure');
            }
        }

        $nonceSize = openssl_cipher_iv_length(self::$metodo);
        $nonce = mb_substr($message, 0, $nonceSize, '8bit');
        $ciphertext = mb_substr($message, $nonceSize, null, '8bit');

        $plaintext = openssl_decrypt(
            $ciphertext,
            self::$metodo,
            $key,
            OPENSSL_RAW_DATA,
            $nonce
        );
        return json_decode($plaintext);
    }

    public static function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public static function base64url_decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
}
