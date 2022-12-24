<?php

class AES7CBCCrypto{

    private $algorithm = MCRYPT_RIJNDAEL_128;
    private $mode = MCRYPT_MODE_CBC;

    public function decrypt($key_base64,$encrypted_base64,$debug = False){

        $encrypted = base64_decode($encrypted_base64);
        $key = base64_decode($key_base64);
        
        $key_size =  strlen($key);
        if ($debug == True){
            echo "\n\n############# DECRYPT DEBUG INFO #########################\n";
            echo "Key size: " . $key_size . "\n";
        }

        $iv_size = mcrypt_get_iv_size($this->algorithm, $this->mode);
        if ($debug == True){
            echo "IV  size: " . $iv_size . "\n";
        }

        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        for ($i = 0; $i < $iv_size; $i++) {
            $iv[$i] = "\000";
        }
        

        $data = mcrypt_decrypt($this->algorithm, $key, $encrypted, $this->mode, $iv);
        $padding = ord($data[strlen($data) - 1]);
        $decrypted = substr($data, 0, - $padding);
        if($debug == True){
            echo "Final Decrypted Plain Text result -> " .$decrypted . "\n";
            echo "#######################################################\n";
        }
        return $decrypted;
    }

    public function encrypt($key_base64,$plain_text, $debug = False){

        $key = base64_decode($key_base64);

        $iv_size = mcrypt_get_iv_size($this->algorithm, $this->mode);
        if ($debug == True){
            echo "\n\n############# ENCRYPT DEBUG INFO #########################\n";
            echo "IV  size: " . $iv_size . "\n";
        }

        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        for ($i = 0; $i < $iv_size; $i++) {
            $iv[$i] = "\000";
        }

        $data = $plain_text;

        $padding = 16 - (strlen($data) % 16);
        $data .= str_repeat(chr($padding), $padding); 

        $encrypted = mcrypt_encrypt($this->algorithm, $key, $data, $this->mode, $iv);
        $encrypted_base64 = base64_encode($encrypted);
        if ($debug == True){
            echo "Final Encrypted result Base64 Encoded -> " . $encrypted_base64 . "\n";
            echo "#######################################################\n";
        }
        return $encrypted_base64;
    }

    public function toB64($plain_text){
        return base64_encode($plain_text);
    }
    public function fromB64($b64encoded_string){
        return base64_decode($b64encoded_string);
    }
}


?>
