<?php
session_name('naamglobal');
session_start();
$page = 'home';
$page_title = 'Students Tour and Educational Travel : ';
include "ng-header.php";
?>


<section class="home_section  p-0"><div>
    <div class="home ripple-effect">
        <img src="/assets/images/stage-image.jpg" class="img-fluid blur-up lazyload bg-img" alt="Stage Image">
    </div>
</div>
<div class="offer-text">
    <h6>
        <span>s</span>
        <span>t</span>
        <span>a</span>
        <span>r</span>
        <span>t</span>
        <span></span>
        <span>y</span>
        <span>o</span>
        <span>u</span>
        <span>r</span>
        <span></span>
        <span>j</span>
        <span>o</span>
        <span>u</span>
        <span>n</span>
        <span>e</span>
        <span>y</span>
    </h6>
</div>
</section>
<div class="error"></div>
<section class="book-table section-b-space p-0 single-table">
    <div class="container">
        <div class="row">
            <div class="col my-auto d-flex justify-content-center">
                <div class="table-form" >
                    <form>
                        <a href="/signup?type=student" class="btn btn-rounded color1">Student Application</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="category-sec ratio3_2 section-b-space">
    <div class="container">
        <div class="title-1 title-5">
            <span class="title-label">featured</span>
            <h2>Services</h2>
            <p>A new perspective on the world.</p>
        </div>
        <div class="row">
            <div class="col">
                <div class="slide-3 arrow-classic">
                    <a href="/destinations">
                        <div class="category-box">
                            <div class="img-category">
                                <div class="side-effect"></div>
                                <div>
                                    <img src="/assets/images/tours.jpg" alt=""
                                    class="img-fluid blur-up lazyload bg-img">
                                </div>

                                <div class="like-cls">
                                    <i class="fas fa-heart"><span class="effect"></span></i>
                                </div>
                            </div>
                            <div class="content-category">
                                <div class="top">
                                    <h3>Tours</h3>

                                </div>
                                <p>We will take you to your places of interest.</p>
                                <h6><span> Browse Destinations</span>  </h6>
                            </div>
                        </div>
                    </a>
                    <a href="/visa-application">
                        <div class="category-box">
                            <div class="img-category">
                                <div class="side-effect"></div>
                                <div>
                                    <img src="/assets/images/visa-application.jpg" alt=""
                                    class="img-fluid blur-up lazyload bg-img">
                                </div>

                                <div class="like-cls">
                                    <i class="fas fa-heart"><span class="effect"></span></i>
                                </div>
                            </div>
                            <div class="content-category">
                                <div class="top">
                                    <h3>Visa Application</h3>

                                </div>
                                <p>Direct employment visas for jobs, family visas and much more</p>
                                <h6><span> Browse Visas</span>  </h6>
                            </div>
                        </div>
                    </a>
                    <a href="/schools">
                        <div class="category-box">
                            <div class="img-category">
                                <div class="side-effect"></div>
                                <div>
                                    <img src="/assets/images/schools.jpg" alt=""
                                    class="img-fluid blur-up lazyload bg-img">
                                </div>

                                <div class="like-cls">
                                    <i class="fas fa-heart"><span class="effect"></span></i>
                                </div>
                            </div>
                            <div class="content-category">
                                <div class="top">
                                    <h3>Study Abroad</h3>

                                </div>
                                <p>Experience a new dimension of knowledge with comfortability</p>
                                <h6><span> Browse Schools</span>  </h6>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-b-space distinct">
    <div class="container">
        <div class="title-1 title-5">
            <h2>some good reason</h2>
            <p>What you really care about is important to us</p>
        </div>
        <div class="row service-part">
            <div class="col-lg-3">
                <div class="service-wrapper">
                    <div>
                        <h3>Safety & Experience <i class="fas fa-heart"><span class="effect"></span></i></h3>
                        <h6>10 years + experience</h6>
                        <p>Safety is our priority, backed by our global presence and 50+ years of experience.</p>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="service-wrapper">
                    <div>
                        <h3>Dedicated Support <i class="fas fa-heart"><span class="effect"></span></i></h3>
                        <h6>We serve</h6>
                        <p>Feel confident knowing we build a team around every individual who travels with us.</p>
                       
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="service-wrapper">
                    <div>
                        <h3>Educational Impact<i class="fas fa-heart"><span class="effect"></span></i></h3>
                        <h6>Our philosophy</h6>
                        <p>We’re an education company first. Experiential travel is how we bring it to life.</p>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="service-wrapper">
                    <div>
                        <h3>Lowest Prices<i class="fas fa-heart"><span class="effect"></span></i></h3>
                        <h6>Our dedication</h6>
                        <p>Give more students an unforgettable experience with the lowest price.</p>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="blog_section section-b-space ratio_55">
  <div class="title-2">
    <h2>Partnered... <span>Schools</span></h2>
    <p><a href="/schools" class="btn btn-curve btn-lower">check all</a></p>
</div>
<div class="container">
    <div class="slide-3 no-arrow">
        <?php 
        $sql = "SELECT * FROM ng_schools WHERE enabled  = ? ORDER BY id DESC LIMIT ? ";
        $stmt = $db->prepare($sql);
        $limit = 4;
        $enabled = 'yes';
        $stmt->bind_param('si',$enabled,$limit);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) :
        ?>
        <div>
            <div class="blog-wrap">
                <div class="blog-image">
                    <div>
                        <img src="/assets/images/schools/<?=$row['image']?>" class="img-fluid blur-up lazyload bg-img"
                        alt="<?=test_output($row['name']); ?>">
                    </div>

                </div>
                <div class="blog-details">
                    <h6><i class="fas fa-map-marker-alt"></i><?=test_output($row['location']); ?></h6>
                    <a href="/school/<?=$row['slug']?>">
                        <h5><?=test_output($row['name']); ?></h5>

                    </a>
                    <p><?=test_output($row['description']); ?>
                    </p>
                </div>
            </div>
        </div>
     <?php endwhile; if($res->num_rows == 0) :?>
     <div>
            <div class="blog-wrap">
               
                <div class="blog-details">
                    <a href="#!">
                        <h5 class="text-center">No schools to show</h5>

                    </a>
                
                </div>
            </div>
                
        </div>
<?php endif;?>
    </div>
</div>
</section>
<section class="about_section section-b-space distinct">
    <div class="container">
        <div class="title-3">
            <span class="title-label">our</span>
            <h2>History<span>naam global</span></h2>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="about_img">
                    <div class="side-effect"><span></span></div>
                    <img src="/assets/images/about.jpg" class="img-fluid blur-up lazyload" alt="">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about_content">
                    <div>
                        <h2>Your partner in global education</h2>
                        <p>Global students recruitment consultancy firm. Naam Global is committed to providing independent advice and support to international students applying to study abroad.</p>
                        <p>Our international education consultants are university trained graduates who are fully trained and experienced by trusted universities and partners. </p>
                        <div class="about_bottom">
                            <a href="/our-history" class="btn btn-rounded btn-sm color1">Read our story</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="subscribe_section medium-section">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-6">
                <div class="subscribe-detail">
                    <div>
                        <h2>the best in your inbox <span>our offer</span></h2>
                        <p>Hundreds of destinations. Endless possibilities.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-lg-6">
                <div class="input-section">
                    <div style="display: inline-flex;">
                    <input type="text" name="sub_name" id="sub_name" class="form-control" placeholder="Enter your name">
                    <input type="text" name="sub_email" id="sub_email" class="form-control" placeholder="Enter Your Email"
                    aria-label="user email">
                    <a href="#!" id="sub_trigger" class="btn btn-rounded btn-sm color1">subscribe</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include "ng-footer.php" ?>