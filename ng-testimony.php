<?php
session_name('naamglobal');
session_start();
$page = 'testimony';
$page_title = 'Our Happy Customers : ';
include "ng-header.php";
?>

<section class="breadcrumb-section pt-0">
    <img src="/assets/images/services.jpg" class="bg-img img-fluid blur-up lazyload" alt="">
    <div class="breadcrumb-content">
        <div>
            <h2>Testimonials</h2>
            <nav aria-label="breadcrumb" class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Our Story</li>
                    <li class="breadcrumb-item active" aria-current="page">Testimonial</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="title-breadcrumb">Naam</div>
</section>
  
    <section class="testimonial-section  animated-section">
        <div class="animation-section">
            <div class="cross po-2"></div>
            <div class="round po-5"></div>
            <div class="round r-2 po-6"></div>
            <div class="round r-2 po-7"></div>
            <div class="round r-y po-8"></div>
            <div class="square po-10"></div>
            <div class="square s-2 po-12"></div>
        </div>
        <div class="container ">
            <div class="title-3 rounded">
                <span class="title-label">Testimonials</span>
                <h2>our happy customers<span>customers</span></h2>
            </div>
            <div class="slide-1">
                 <?php 
        $sql = "SELECT * FROM ng_testimonies WHERE enabled  = ? ORDER BY id DESC ";
        $stmt = $db->prepare($sql);
        $enabled = 'yes';
        $stmt->bind_param('s',$enabled);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) :
        ?>
                <div>
                    <div class="row">
                        <div class="col-xl-8 offset-xl-2">
                            <div class="testimonial">
                                <div class="left-part">
                                    <img src="/assets/images/testimonials/<?=$row['image']?>" class="img-fluid blur-up lazyload" alt="<?=htmlspecialchars_decode(html_entity_decode($row['testimony_by'],ENT_QUOTES)); ?>">
                                    <div class="design">
                                        <i class="fas fa-comments"></i>
                                        <i class="fas fa-comments light"></i>
                                    </div>
                                </div>
                                <div class="right-part">
                                    <p>
                                        "<?=htmlspecialchars_decode(html_entity_decode($row['testimony'],ENT_QUOTES)); ?>"
                                    </p>
                                    <div class="detail">
                                       
                                        <h6><?=htmlspecialchars_decode(html_entity_decode($row['testimony_by'],ENT_QUOTES)); ?></h6>
                                    </div>
                                </div>
                                <div class="quote-icon">
                                    <i class="fas fa-quote-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            </div>
        </div>
    </section>

<?php include "ng-footer.php" ?>