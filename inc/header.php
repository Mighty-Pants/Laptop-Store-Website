<?php
ob_start();
include 'lib/session.php';
Session::init();
?>

<?php
include 'lib/database.php';
include 'helpers/format.php';

spl_autoload_register(function ($className) {
    include_once "classes/" . $className . ".php";
});

$db = new database();
$fm = new Format();
$order = new Order();
$cart = new Cart();
$user = new User();
$product = new Product1();
$category = new category();
$feedback = new Feedback();

?>
<?php
$login_check = Session::get('user_login');
if (isset($_GET['logout_user'])) {
    $delOrder = $order->delDataCart();
    Session::destroy();
}
?>

<?php
//tim kiem
$search = '';
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $search = Session::get('keyword');
}else{
    Session::set('keyword','');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Bootshop online Shopping cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">


    <!-- Bootstrap style -->
    <link id="callCss" rel="stylesheet" href="themes/bootshop/bootstrap.min.css" media="screen" />
    <link href="themes/css/base.css" rel="stylesheet" media="screen" />
    <!-- Bootstrap style responsive -->
    <link href="themes/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="themes/css/font-awesome.css" rel="stylesheet" type="text/css">
    <!-- Google-code-prettify -->
    <link href="themes/js/google-code-prettify/prettify.css" rel="stylesheet" />
    <!-- fav and touch icons -->
    <link rel="shortcut icon" href="themes/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="themes/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="themes/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="themes/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="themes/images/ico/apple-touch-icon-57-precomposed.png">
    <style type="text/css" id="enject"></style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div id="header">
        <div class="container">
            <div id="welcomeLine" class="row">
                <div class="span6">
                    <?php
                    if ($login_check == true) {
                        echo 'Xin chào,<strong> ';
                        echo Session::get('user_name');
                        echo ' !</strong>';
                    }
                    ?>
                </div>
                <div class="span6">
                    <div class="pull-right">
                        <a href="product_summary.php"><span class="btn btn-mini btn-primary"><i class="icon-shopping-cart icon-white"></i>[
                                <?php
                                if ($login_check == true) {
                                    echo Session::get('qty');
                                } else echo '0';
                                ?>
                                ] sản phẩm trong giỏ </span> </a>
                    </div>
                </div>
            </div>
            <!-- Navbar ================================================== -->
            <div id="logoArea" class="navbar">
                <a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-inner">
                    <a class="brand" href="index.php"><img src="themes/images/logo.png" alt="Bootsshop" /></a>
                    <form class="form-inline navbar-search" method="GET" action="search_product.php">
                        <input id="" class="srchTxt" type="text" value="<?php if($search) echo $search?>" name="keyword"/>
                        <button type="submit" id="submitButton" class="btn btn-primary">Tìm kiếm</button>
                    </form>
                    <ul id="topMenu" class="nav pull-right">
                        <li class=""><a href="index.php">Home</a></li>
                        <li class=""><a href="contact.php">Contact</a></li>
                        <?php
                        if ($login_check == true) {
                            echo '<li class=""><a href="profile.php">Profile</a></li>';
                        }
                        ?>
                        <li class="">
                            <?php

                            if ($login_check == false)
                                echo '<a href="login.php"  style="padding-right:0"><span class="btn btn-large btn-success">Login</span></a>';
                            else
                                echo '<a href="?logout_user=' . Session::get('user_id') . '"  style="padding-right:0"><span class="btn btn-large btn-success">Logout</span></a>';
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>