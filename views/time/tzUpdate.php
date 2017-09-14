<?php
/**
 * Created by PhpStorm.
 * User: dinesh
 * Date: 11/7/17
 * Time: 12:42 PM
 */
if (!isset($_SESSION)) {
    session_start();
}
$docrootpath = __DIR__;
$docrootpath = explode('/views', $docrootpath);
$docrootpath = $docrootpath[0] . "/";

// Include dependent files
require_once("{$docrootpath}config/config.php");
require_once("{$docrootpath}models/user/User.php");
$User=new User();
$returnArr = array();

if ($_POST["userTimezone"] != "") {
    if (strtolower($_SESSION["timezone"]) == strtolower($_POST["userTimezone"])) {
        $returnArr["errCode"] = "-1";
        $returnArr["errMsg"] = "Timezone is Uptodate";
    } else {
        $result = $User->setUserNotifyInfo($_SESSION["id"], "timezone", $_POST["userTimezone"]);
        if (noError($result)) {
            unset($_SESSION["timezone"]);
            $_SESSION["timezone"]=$_POST["userTimezone"];
            $returnArr["errCode"] = "-1";
            $returnArr["errMsg"] = "Timezone Updated Success";
        } else {
            $returnArr['errCode'] = 3;
            $returnArr['errMsg'] = "Failed to upgrade Timezone";
        }
    }

} else {
    $returnArr["errCode"] = "2";
    $returnArr["errMsg"] = "Error In Updating Timezone.";
}

echo(json_encode($returnArr));
?>