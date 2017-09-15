<?php
if(!isset($_SESSION))
{
    session_start();
}
header('Content-Type: text/html; charset=utf-8');
$docrootpath = __DIR__;
$docrootpath = explode('/contact_book', $docrootpath);
$docrootpath = $docrootpath[0] . "/contact_book/";

require_once("{$docrootpath}config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?= $rootUrl; ?>assets/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Contact Book</a>
        </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <?php
                if(isset($_SESSION["userLogin"])) {
                    ?>
                <!--<form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>-->
                <?php
                }
                ?>
                <ul class="nav navbar-nav navbar-right">
                    <?php
                    if(isset($_SESSION["userLogin"])) {
                        echo '<li><a href="'.$rootUrl.'controllers/user/Logout.php">Logout</a></li>';
                    }else
                    {
                       // echo '<li><a href="#">Login</a></li>';
                    }
                    ?>
                </ul>
            </div>

    </div>
</nav>





