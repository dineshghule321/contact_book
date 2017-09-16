<?php

/*
 *----------------------------------------------------------------------------------------------------
 * Logout controller used for Logout  of User  Contact Book
 * controller destroy session and redirect to login page
 *----------------------------------------------------------------------------------------------------
 */

session_start();
//start config
require_once('../../config/config.php');

$rootViews =$rootView."user/login.php";
session_destroy();
print("<script>window.location='" . $rootViews . "'</script>");
exit;

?>