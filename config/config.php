<?php

$rootUrl = "http://localhost/contact_book/"; //Static

$docRoot = $_SERVER['DOCUMENT_ROOT'] . "/contact_book/";

if($_SERVER['DOCUMENT_ROOT']=="")
{
   $docRoot = dirname(__DIR__)."/";
}

$mode  = "development"; //Static

$rootUrlImages = "{$rootUrl}assets/images/";
$rootUrlJs = "{$rootUrl}assets/js/";
$rootUrlCss = "{$rootUrl}assets/css/";

$docViews = "{$docRoot}views/";

/****************************************************/
define("MAILGUN_API_KEY", "key-2b8f2419e616db09b1297ba51d7cc770");
define("MAILGUN_DOMAIN", "searchtrade.com");
define("DIR_ASSETS_EMAIL_TEMPLATES", "{$docRoot}assets/email_template/");
/****************************************************/

if ($mode != "production") {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}else
{
    ini_set('display_errors', 0);
    error_reporting(0);
}

if ( date_default_timezone_set( "UTC" ) != TRUE)
{
    $now = new DateTime();
    $now->setTimezone(new DateTimeZone('UTC'));
}

/***************Log Path Array *****************/
$logPath["userManagement"]   = $docRoot."logs/UserMgmt/";
/***************************************/

function loadSystem($docRoot)
{
    require_once("{$docRoot}config/DB.php");
    require_once("{$docRoot}config/errorMap.php");
    require_once("{$docRoot}helpers/deviceHelper.php");
    require_once("{$docRoot}helpers/arrayHelper.php");
    require_once("{$docRoot}helpers/stringHelper.php");
    require_once("{$docRoot}helpers/cryptoHelper.php");
    require_once("{$docRoot}helpers/date_helpers.php");
    require_once("{$docRoot}libraries/backend_libraries/xmlProcessor/xmlProcessor.php");
}
loadSystem($docRoot);

?>

