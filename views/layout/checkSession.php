<?php
$docrootpath = __DIR__;
$docrootpath = explode('/contact_book', $docrootpath);
$docrootpath = $docrootpath[0] . "/contact_book/";

require_once("{$docrootpath}config/config.php");
if(empty($_SESSION))
{
    $rootViews =$rootView."user/login.php";
    print("<script>window.location='" . $rootViews . "'</script>");
}else{
    if($_SESSION["userLogin"]!=1)
    {
        $rootViews =$rootView."user/login.php";
        print("<script>window.location='" . $rootViews . "'</script>");
    }
}