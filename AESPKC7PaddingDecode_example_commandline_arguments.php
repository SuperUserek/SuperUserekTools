<?php
// include cryptography tools from url
// download file once then reuse it
// USAGE:
// php .\AESPKC7PaddingDecode_example_commandline_arguments.php "#SuperHiddenKey#" "MWSDHbTRt+rlsrgR1loScAG/vij9D7/zVCmPP+Ep+BI="

if (isset($argc)) {
    if(isset($argv[1])){
		echo "Decoding # ". $argv[2] . "\n";
        echo "Using KEY # ". $argv[1] . "\n";
    }
    else {
        echo "You have not passed parameters!!\n";
        echo "usage: ".$argv[0]. " (BASE64_KEY) (BASE64 encoded string)";
        exit();
    }
}

$filedownloaded=file_exists("cryptography_superuserek_tools.php");
if ($filedownloaded == false){
    echo "Downloading cryptofile.\n";
    $cryptotools=file_get_contents("https://raw.githubusercontent.com/SuperUserek/SuperUserekTools/main/cryptography_superuserek_tools.php",true);
    file_put_contents("cryptography_superuserek_tools.php",$cryptotools);
}
include_once("cryptography_superuserek_tools.php");
try{
    // Call AES7CBCCrypto class and asign it to variable ($aespk7padding)
    $aespk7padding = new AES7CBCCrypto();
    $my_secret_key=$argv[1];// KEY MUST BE 16 24 or 32 characters as for AES Encoding Standards FROM COMMAND LINE
    //Encode plain text key to Base64 using using AES7CBCCrypto class
    $encoded_key=$aespk7padding->toB64($my_secret_key); // KEY HAS TO BE CONVERTED to BASE64 prior encoding
    $my_encrypted_message=$argv[2]; //ENCODED MESSAGE TAKEM FROM COMMAND LINE
    // ----------------         Try Decode encoded results to check if it matches:
    $my_decrypted_message = $aespk7padding->decrypt($encoded_key,$my_encrypted_message); // WITHOUT DEBUG - RETURN ONLY RESULT
    //$my_decrypted_message = $aespk7padding->decrypt($encoded_key,$my_encrypted_message,$debug=True); // WITH DEBUG
    echo "DECODED: [".$my_decrypted_message."]\n";
}catch (\Throwable $th) {
    "ERROR";
}
?>
