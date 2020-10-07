<?php
include_once 'includes/functions.php' ?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="rica">
    <meta name="keywords" content="rica">
    <meta name="author" content="rica">
    <link rel="icon" href="/assets/images/favicon.png" type="image/x-icon" />
    <title><?=test_output($page_title).$site_name?></title>

    <link
            href="https://fonts.googleapis.com/css?family=Nunito:300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap"
            rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,500,600,700,800,900&amp;display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Vampiro+One&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script:400,700&amp;display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome.css">

    <link rel="stylesheet" type="text/css" href="/assets/css/animate.css">

    <link rel="stylesheet" type="text/css" href="/assets/css/slick.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/slick-theme.css">

    <link rel="stylesheet" type="text/css" href="/assets/css/magnific-popup.css">

    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.css">

    <link rel="stylesheet" type="text/css" href="/assets/css/themify-icons.css">

    <link rel="stylesheet" type="text/css" href="/assets/css/naam-home.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/iziToast.min.css">

</head>

<body>

<header class="overlay-black">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="menu">
                    <div class="brand-logo">
                        <a href="/home">
                            <img src="/assets/images/<?=$site_logo?>" alt=""
                                 class="img-fluid blur-up lazyload">
                        </a>
                    </div>
                    <nav>
                        <div class="main-navbar">
                            <div id="mainnav">
                                <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
                                <div class="menu-overlay"></div>
                                <ul class="nav-menu">
                                    <li class="back-btn">
                                        <div class="mobile-back text-right">
                                            <span>Back</span>
                                            <i aria-hidden="true" class="fa fa-angle-right pl-2"></i>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="/services" class="nav-link">Browse Services</a>
                                    </li>
                                    <li>
                                        <a href="/blog" class="nav-link">Blog</a>
                                    </li>
                                    <li>
                                        <a href="/schools" class="nav-link">Schools</a>
                                    </li>
                                   
                                   
                                    <li class="dropdown">
                                        <a href="#!" class="nav-link menu-title">Our Story</a>
                                        <ul class="nav-submenu menu-content">
                                            <li><a href="/our-history" >History</a>
                                            </li>
                                             <li><a href="/testimony" >Testimonial</a>
                                            </li>
                                            <li><a href="/mission-and-vision" >Mission and Vision</a>
                                            </li>
                                        </ul>
                                    </li>
                                   

                                    <li class="dropdown">
                                        <a href="#!" class="nav-link menu-title">Connect</a>
                                        <ul class="nav-submenu menu-content">
                                            <li><a href="/contact-us" >Contact us</a>
                                            </li>
                                             <li><a href="/faqs" >FAQs</a>
                                            </li>
                                            </li>
                                        </ul>
                                    </li>
                                                                      
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <ul class="header-right">
                        <?php if (!isset($_SESSION['student_login_status'])) {
                        
                         ?>
                        <li class="user user-light" data-toggle="tooltip" title="Login" data-placement="left" >
                            <a href="/signin">
                                <i class="fas fa-lock"></i>
                            </a>
                        </li>
                        <li class="user user-light" data-toggle="tooltip" title="Signup" data-placement="right" >
                            <a href="/signup">
                                <i class="fas fa-user-plus"></i>
                            </a>
                        </li>
                        <?php } else { ?>
                             <li class="user user-light" data-toggle="tooltip" title="Dashboard" data-placement="left" >
                            <a href="/me">
                                <i class="fas fa-user"></i>
                            </a>
                        </li>
                        <?php }?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>