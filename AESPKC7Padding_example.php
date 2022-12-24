<?php
// include cryptography tools from url
$cryptotools=file_get_contents("https://raw.githubusercontent.com/SuperUserek/SuperUserekTools/main/cryptography_superuserek_tools.php",true);
file_put_contents("cryptography_superuserek_tools.php",$cryptotools);
include_once("cryptography_superuserek_tools.php");

// Call AES7CBCCrypto class and asign it to variable ($aespk7padding)
$aespk7padding = new AES7CBCCrypto();

$my_secret_key="#SuperHiddenKey#"; // KEY MUST BE 16 24 or 32 characters as for AES Encoding Standards

//Encode plain text key to Base64 using using AES7CBCCrypto class
$encoded_key=$aespk7padding->toB64($my_secret_key); // KEY HAS TO BE CONVERTED to BASE64 prior encoding

$my_secret_message="SuperUser AES PKC7 with Padding";
// ----------------         Encode and get final result:
$my_encrypted_message = $aespk7padding->encrypt($encoded_key,$my_secret_message); // WITHOUT DEBUG - RETURN ONLY RESULT
//$my_encrypted_message = $aespk7padding->encrypt($encoded_key,$my_secret_message,$debug=True); // WITH DEBUG
echo $my_encrypted_message."\n";
// ----------------         Try Decode encoded results to check if it matches:
$my_decrypted_message = $aespk7padding->decrypt($encoded_key,$my_encrypted_message); // WITHOUT DEBUG - RETURN ONLY RESULT
//$my_decrypted_message = $aespk7padding->decrypt($encoded_key,$my_encrypted_message,$debug=True); // WITH DEBUG
echo $my_decrypted_message."\n";
?>
