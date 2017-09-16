<?php


/**
 * ----------------------------------------------------------------------------------------
 * parse query and clean query from XSS and SQL Injections
 * ----------------------------------------------------------------------------------------
 * @param $string
 * @return string
 */
function cleanQuery($string)
{
    $string=htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    $string = trim($string);
    $string = addslashes($string);
    return $string;
}


?>