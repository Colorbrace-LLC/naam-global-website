<?php
session_name('naamglobal');
session_start();
$page = 'signin';
$page_title = 'Sign In : ';
include "ng-header.php";

if (isset($_SESSION['student_login_status'])  && $_SESSION['student_login_status'] === true) {

    redirect('/me');

    }
?>

<section class="breadcrumb-section pt-0">
    <img src="/assets/images/auth.jpg" class="bg-img img-fluid blur-up lazyload" alt="">
    <div class="breadcrumb-content">
        <div>
            <h2>Sign In</h2>
            <nav aria-label="breadcrumb" class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Auth</li>
                    <li class="breadcrumb-item active" aria-current="page">Sign In</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="title-breadcrumb">Naam</div>
</section>
  
 <section class="section-b-space dark-cls animated-section">
        <img src="/assets/images/grey-bg.jpg" alt="" class="img-fluid blur-up lazyload bg-img">
        <div class="animation-section">
            <div class="cross po-1"></div>
            <div class="cross po-2"></div>
            <div class="round po-4"></div>
            <div class="round po-5"></div>
            <div class="round r-y po-8"></div>
            <div class="square po-10"></div>
            <div class="square po-11"></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="offset-lg-3 col-lg-6 offset-sm-2 col-sm-8 col-12">
                    <div class="account-sign-in">
                        <div class="title">
                            <h3>Login</h3>
                        </div>
                        <form method="post" enctype="multipart/form-data" class="login-form">
                            <div class="form-group">
                                <label for="user_email">Email address</label>
                                <input type="email" class="form-control" id="user_email" name="user_email" 
                                    aria-describedby="emailHelp" placeholder="Enter email">
                                <small id="emailHelp" class="form-text text-muted">Enter email address used during registration</small>
                            </div>
                            <div class="form-group">
                                <label for="user_password">Password</label>
                                <input type="password" class="form-control" name="user_password" id="user_password"
                                    placeholder="Password">
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" value="yes" name="rememberme" id="rememberme">
                                <label class="form-check-label" for="rememberme">remember me</label>
                            </div>
                            <div class="button-bottom">
                                <button type="submit" class="w-100 btn btn-solid login-btn">login</button>
                                <div class="divider">
                                    <h6>or</h6>
                                </div>
                                <button type="button" class="w-100 btn btn-solid btn-outline"
                                    onclick="window.location.href = '/signup';">Create Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php include "ng-footer.php" ?>