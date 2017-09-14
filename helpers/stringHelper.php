<?php
/**
 * Created by PhpStorm.
 * User: trilok
 * Date: 28/11/16
 * Time: 7:03 PM
 */


function cleanQuery($string)
{
    $string=htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    $string = trim($string);
    $string = addslashes($string);
    return $string;
}

function cleanDisplayParameter($string)
{
    $string=htmlspecialchars_decode($string);
    $string=html_entity_decode($string,ENT_QUOTES);
    $string = sanitize_data($string);

    return $string;
}

function sanitize_data($input_data)
{
    return htmlentities(stripslashes($input_data), ENT_QUOTES | ENT_HTML5);
}


function decodeURLparameter($datastring)
{
    $decodedquery = urldecode($datastring);
    parse_str($decodedquery, $queryStringForTransaction);

    return $queryStringForTransaction;
}

function decodeRequestParameter($string)
{
    $reqParam = trim(urldecode($string));
    $reqParam = utf8_decode($reqParam);

    return $reqParam;

}

?>