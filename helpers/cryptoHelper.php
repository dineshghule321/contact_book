<?php
/**
 * Created by PhpStorm.
 * User: trilok
 * Date: 28/11/16
 * Time: 7:07 PM
 */

function sha1Md5DualEncryption($hash)
{
    $salt = sha1(md5($hash));
    $hash = md5($hash . $salt);
    return $hash;
}

function generateRandomString($length = 15)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}



?>