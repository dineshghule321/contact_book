<?php

$rootUrl = "http://localhost/contact_book/"; //Server ROOT URL

$docRoot = $_SERVER['DOCUMENT_ROOT'] . "/contact_book/"; //Document ROOT of server

if($_SERVER['DOCUMENT_ROOT']=="")
{
   $docRoot = dirname(__DIR__)."/";
}

$mode  = "development"; // System Mode

$rootUrlImages = "{$rootUrl}assets/images/";
$rootView = "{$rootUrl}views/";

if ($mode != "production") {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}else
{
    ini_set('display_errors', 0);
    error_reporting(0);
}

function loadSystem($docRoot)
{
    require_once("{$docRoot}config/DB.php");
    require_once("{$docRoot}config/errorMap.php");
    require_once("{$docRoot}helpers/arrayHelper.php");
    require_once("{$docRoot}helpers/stringHelper.php");
    require_once("{$docRoot}helpers/cryptoHelper.php");

}
loadSystem($docRoot);

?>

