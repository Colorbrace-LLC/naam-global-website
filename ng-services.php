<?php
session_name('naamglobal');
session_start();
$page = 'services';
$page_title = 'Educational Services : ';
include "ng-header.php";
?>

<section class="breadcrumb-section pt-0">
    <img src="/assets/images/services.jpg" class="bg-img img-fluid blur-up lazyload" alt="">
    <div class="breadcrumb-content">
        <div>
            <h2>services</h2>
            <nav aria-label="breadcrumb" class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">services</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="title-breadcrumb">Naam</div>
</section>
<div class="error"></div>
<section class="book-table section-b-space p-0 single-table">
    <div class="container">
        <div class="row">
            <div class="col my-auto d-flex justify-content-center">
                <div class="table-form" >
                    <form>
                        <a href="/service-bookings" class="btn btn-rounded color1">Book a service</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-b-space animated-section dark-cls">
    <img src="/assets/images/grey-bg.jpg" alt="" class="img-fluid blur-up lazyload bg-img">
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
            <h2>awesome services</h2>
        </div>
        <div class="row service-section">
            <?php 
        $sql = "SELECT * FROM ng_services WHERE enabled  = ?";
        $stmt = $db->prepare($sql);
        $enabled = 'yes';
        $stmt->bind_param('s',$enabled);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) :
        ?>
            <div class="col-lg-4 mt-3">
                <div class="service-box wow fadeInUp">
                    <div>
                        <div class="service-icon">
                         <i class="fas fa-<?=$row['icon']?> fa-3x text-danger "></i>
                     </div>
                     <h3><?=htmlspecialchars_decode(html_entity_decode($row['title'],ENT_QUOTES)); ?></h3>
                     <p><?=htmlspecialchars_decode(html_entity_decode($row['description'],ENT_QUOTES)); ?></p>

                </div>
            </div>
        </div>

<?php endwhile; ?>
    </div>
</div>
</section>



<section class=" medium-section">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-6">
                <div class="subscribe-detail">
                    <div>
                        <h2>Are you ready? Get it right with us</h2>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-lg-6">
                <div class="input-section">
                  
                    <a href="/service-bookings" class="btn btn-rounded btn-sm color1">Book A Service</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include "ng-footer.php" ?>