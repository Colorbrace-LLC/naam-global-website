<?php
session_name('naamglobal');
session_start();
$page = 'signup';
$page_title = 'Sign Up : ';
include "ng-header.php";

$type = isset($_GET['type']) ? $_GET['type'] : '';
?>

<section class="breadcrumb-section pt-0">
    <img src="/assets/images/auth.jpg" class="bg-img img-fluid blur-up lazyload" alt="">
    <div class="breadcrumb-content">
        <div>
            <h2>Sign Up</h2>
            <nav aria-label="breadcrumb" class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Auth</li>
                    <li class="breadcrumb-item active" aria-current="page">Sign Up</li>
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
                            <h3>Sign Up</h3>
                        </div>
                        <form method="post" enctype="multipart/form-data" class="signup-form">
                           <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="fname">First Name</label>
                                    <input type="text" class="form-control" id="fname" name="first_name" placeholder="First name"
                                        required="">
                                </div>
                                 <div class="form-group col-md-6">
                                    <label for="oname">Other Names</label>
                                    <input type="text" class="form-control" id="oname" name="other_names" placeholder="Other names"
                                        required="">
                                </div>
                                </div>
                            <div class="form-group">
                                <label for="email_address">Email address</label>
                                <input type="email" class="form-control"  name="email_address" id="email_address"
                                    placeholder="Enter email address">
                            </div>
                            <div class="form-row">
                             <div class="form-group col-md-6">
                                <label for="phone_number">Phone Number</label>
                                <input type="number" class="form-control" name="phone_number" pattern="^\+(?:[0-9]●?){6,14}[0-9]$" id="phone_number" placeholder="Enter phone number">
                                <small class="text-muted">must begin with country code</small>
                            </div>
                             <div class="form-group col-md-6">
                                    <label for="type">Account Type</label>
                                    <select class="form-control" required name="type" id="type">
                                        <option  value="">Select Account Type</option>
                                        <option value="student" <?php if($type == 'student') : echo 'selected'; endif;?>>Student</option>
                                        <option value="tour"  <?php if($type == 'tour') : echo 'selected'; endif;?>>Tour Booking</option>
                                        <option value="visa"  <?php if($type == 'visa') : echo 'selected'; endif;?>>Visa Application</option>
                                    </select>
                                </div>
                        </div>
                             <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Password">
                            </div>
                             <div class="form-group col-md-6">
                                <label for="cpass">Confirm Password</label>
                                <input type="password" class="form-control" name="cpass" id="cpass"
                                    placeholder="Confirm Password">
                            </div>
                        </div>
                            <div class="button-bottom">
                                <button type="submit" class="w-100 btn btn-solid signup-btn">create account</button>
                                <div class="divider">
                                    <h6>or</h6>
                                </div>
                                <button type="submit" class="w-100 btn btn-solid btn-outline"
                                    onclick="window.location.href = '/signin';">login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php include "ng-footer.php" ?>