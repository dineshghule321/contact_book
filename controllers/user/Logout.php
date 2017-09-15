<?php

/**
 * Created by PhpStorm.
 * User: dinesh
 * Date: 6/9/17
 * Time: 1:33 PM
 */

session_start();
//start config
require_once('../../config/config.php');

$rootViews =$rootView."user/login.php";
session_destroy();
print("<script>window.location='" . $rootViews . "'</script>");
exit;

?>