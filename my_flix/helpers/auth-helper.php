<?php

function Hashing($string){

    $salt = "MyEncryptionKey";
    $enc_key = bin2hex($string);
    $enc_salt = bin2hex($salt);
    return hash('sha512', $enc_key.$enc_salt);
}

function GenerateToken(){

    return bin2hex(openssl_random_pseudo_bytes(64));

}
