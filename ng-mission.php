<?php
session_name('naamglobal');
session_start();
$page = 'mission';
$page_title = 'Our Mission : ';
include "ng-header.php";
?>

<section class="breadcrumb-section pt-0">
    <img src="/assets/images/services.jpg" class="bg-img img-fluid blur-up lazyload" alt="">
    <div class="breadcrumb-content">
        <div>
            <h2>Mission and Vision</h2>
            <nav aria-label="breadcrumb" class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Our Story</li>
                    <li class="breadcrumb-item active" aria-current="page">Mission and Vision</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="title-breadcrumb">Naam</div>
</section>
  
    <section class="section-b-space animated-section dark-cls">
        <img src="/assets/images/cab/grey-bg.jpg" alt="Naam Global Educational Services Mission and Vision" class="img-fluid blur-up lazyload bg-img">
        <div class="animation-section">
            <div class="cross po-1"></div>
            <div class="cross po-2"></div>
            <div class="cross po-3"></div>
            <div class="round po-4"></div>
            <div class="round po-5"></div>
            <div class="round r-2 po-6"></div>
            <div class="round r-2 po-7"></div>
            <div class="round r-y po-8"></div>
            <div class="round r-y po-9"></div>
            <div class="square po-10"></div>
            <div class="square po-11"></div>
            <div class="square s-2 po-12"></div>
        </div>
        <div class="container">
            <div class="title-1">
                <span class="title-label">our</span>
                <h2>mission and vission</h2>
            </div>
            <div class="row service-section color-svg">
                <div class="col-lg-6">
                    <div class="service-box wow fadeInUp">
                        <div>
                            <div class="service-icon">
                               <i class="fas fa-bullseye fa-3x text-danger"></i>
                            </div>
                            <h3>Mission</h3>
                            <p>We have come to stay and to save our prospective clients from now and in the future from the hassle students go through during their admission process. Our partner agencies are rated highly globally and we are not different from them.</p>
                           
                        </div>
                    </div>
                </div>
               
                <div class="col-lg-6">
                    <div class="service-box wow fadeInUp">
                        <div>
                            <div class="service-icon">
                           <i class="fas fa-low-vision  fa-3x text-danger"></i>
                            </div>
                            <h3>Vision</h3>
                            <p>To make international education and services accessible through Naam Global.</p>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include "ng-footer.php" ?>