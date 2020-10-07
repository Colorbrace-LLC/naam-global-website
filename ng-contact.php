<?php
session_name('naamglobal');
session_start();
$page = 'contact';
$page_title = 'Contact us : ';
include "ng-header.php";
?>

<section class="breadcrumb-section pt-0">
    <img src="/assets/images/services.jpg" class="bg-img img-fluid blur-up lazyload" alt="">
    <div class="breadcrumb-content">
        <div>
            <h2>Contact us</h2>
            <nav aria-label="breadcrumb" class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Connect</li>
                    <li class="breadcrumb-item active" aria-current="page">Contact us</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="title-breadcrumb">Naam</div>
</section>
  
  <section class="small-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="get-in-touch">
                        <h3>get in touch</h3>
                        <form method="post" enctype="multipart/form-data" class="contact-form">
                            <div class="form-row">
                                <label for="name">Full Name  <small>required</small></label>
                                <div class="form-group col-md-12">
                                    <input type="text" name="c_name" class="form-control" id="name" placeholder="full name"
                                        required="">
                                </div>
                                
                                <div class="form-group col-lg-6">
                                    <label for="phone"> Phone Number (optional)</label>
                                    <input type="text" class="form-control" id="review" name="c_phone" placeholder="phone number (optional)">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="email">Email Address  <small>required</small></label>
                                    <input type="email" class="form-control" name="c_email" id="email" placeholder="email address"
                                        required="">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="message">Message <small>required</small></label>
                                    <textarea class="form-control" placeholder="Write Your Message"
                                        id="message" name="c_message" rows="6"></textarea>
                                </div>
                                <div class="col-md-12 submit-btn">
                                    <button class="btn btn-solid contact-btn" type="submit">Send Your Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 contact_right contact_section">
                    <div class="row">
                        <div class="col-md-12 col-6">
                            <div class="contact_wrap">
                                <div class="title_bar">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <h4>Address</h4>
                                </div>
                                <div class="contact_content">
                                    <?=htmlspecialchars_decode(html_entity_decode($site_address,ENT_QUOTES)) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-6">
                            <div class="contact_wrap">
                                <div class="title_bar">
                                    <i class="fas fa-envelope"></i>
                                    <h4>email address</h4>
                                </div>
                                <div class="contact_content">
                                    <ul>
                                   <li> <?=htmlspecialchars_decode(html_entity_decode($site_email,ENT_QUOTES)) ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-6">
                            <div class="contact_wrap">
                                <div class="title_bar">
                                    <i class="fas fa-phone-alt"></i>
                                    <h4>phone</h4>
                                </div>
                                <div class="contact_content">
                                    <ul>
                                        <li>
                                    <?=htmlspecialchars_decode(html_entity_decode($site_phone,ENT_QUOTES)) ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php include "ng-footer.php" ?>