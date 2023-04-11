<?php

namespace App\Libraries;

class Safeencryption
{
    var $skey = "holidaysbookersj"; // you can change it, it must 16 digit
    public function safe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }

    public function safe_b64decode($string)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public function encode($value)
    {
        if (!$value) {
            return false;
        }
        $text = $value;
        //using OpenSSL 
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($value, 'aes-256-cbc', $this->skey, 0, $iv);
        //return base64_encode($encrypted . '::' . $iv);
        return trim($this->safe_b64encode($encrypted . '::' . $iv));
    }

    public function decode($value)
    {
        if (!$value) {
            return false;
        }

        //using OpenSSL 
        $value = $this->safe_b64decode($value);
        list($encrypted_data, $iv) = explode('::', $value, 2);
        // list($encrypted_data, $iv) = explode('::', base64_decode($value), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $this->skey, 0, $iv);
    }
}
