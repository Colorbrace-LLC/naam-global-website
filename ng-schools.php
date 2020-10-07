<?php
session_name('naamglobal');
session_start();
$page = 'schools';
$page_title = 'Partnered Schools : ';
include "ng-header.php";

$schoolslug = isset($_GET['schoolslug']) ? $_GET['schoolslug'] : ''; 

if (!$schoolslug) : 
    ?>

    <section class="breadcrumb-section pt-0">
        <img src="/assets/images/schools-image.jpg" class="bg-img img-fluid blur-up lazyload" alt="">
        <div class="breadcrumb-content">
            <div>
                <h2>Partnered Schools</h2>
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">schools</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="title-breadcrumb">Naam</div>
    </section>
    <div class="error"></div>

    <section class="blog_section section-b-space ratio_55 animated-section dark-cls">
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
            <div class="slide-3 no-arrow">
                <?php 
                $sql = "SELECT * FROM ng_schools WHERE enabled  = ? ORDER BY id DESC";
                $stmt = $db->prepare($sql);
                $enabled = 'yes';
                $stmt->bind_param('s',$enabled);
                $stmt->execute();
                $res = $stmt->get_result();
                while ($row = $res->fetch_assoc()) :
                    ?>
                    <div>
                        <div class="blog-wrap">
                            <div class="blog-image">
                                <div>
                                    <img src="/assets/images/schools/<?=$row['image']?>" class="img-fluid blur-up lazyload bg-img"
                                    alt="<?=htest_output($row['name']); ?>">
                                </div>

                            </div>
                            <div class="blog-details">
                                <h6><i class="fas fa-map-marker-alt"></i><?=htest_output($row['location']); ?></h6>
                                <a href="/school/<?=$row['slug']?>">
                                    <h5><?=htest_output($row['name']); ?></h5>

                                </a>
                                <?=htest_output($row['description']); ?>

                            </div>
                            <p class="text-center"> <a href="/school/<?=$row['slug']?>" class="btn btn-curve btn-lower color1">view details</a></p>
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
                        <p class="text-center"> <a href="/home" class="btn btn-curve btn-lower color1">go home</a></p>
                    </div>

                </div>
            <?php endif;?>
        </div>
    </div>
</section>
<?php endif; if($schoolslug):

$slug =trim($schoolslug);

$cql = "SELECT * FROM ng_schools WHERE enabled = ? AND slug = ?";
$cstmt= $db->prepare($cql);
$status = 'yes';
$cstmt->bind_param('ss', $status,$slug);
$cstmt->execute();
$cres = $cstmt->get_result();
while($crow = $cres->fetch_assoc()) : ?>

    <section class="breadcrumb-section pt-0">
        <img src="/assets/images/schools-image.jpg" class="bg-img img-fluid blur-up lazyload" alt="">
        <div class="breadcrumb-content">
            <div>
                <h2>Partnered Schools</h2>
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="/schools">schools</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?=htest_output($crow['name']); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="title-breadcrumb">Naam</div>
    </section>

    <section class="single-section small-section bg-inner">
        <div class="container">
            <div class="row">
               <div class="col-xl-9 col-lg-8">
                <div class="description-section tab-section">
                    <div class="menu-top menu-up">
                        <ul class="nav nav-tabs" id="top-tab" role="tablist">
                            <li class="nav-item"><a data-toggle="tab" class="nav-link active"
                                href="#about">About</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#gallery">gallery</a>
                                </li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#reviews">reviews</a>
                                </li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#courses">courses</a>
                                </li>
                            </ul>
                        </div>
                        <div class="description-details tab-content" id="top-tabContent">
                            <div class="menu-part about tab-pane fade show active" id="about">
                                <div class="about-sec">

                                    <?=htest_output($crow['description']); ?>
                                </div>

                            </div>
                            <div class="menu-part tab-pane fade" id="gallery">
                                <div class="container-fluid p-0 ratio3_2">
                                    <div class="row  zoom-gallery">
                                        <?php $images   = $crow['images']; 

                                        $imag = explode(',',trim($images,','));

                                        $i = 1;
                                        foreach ($imag as $image) :
                                            ?>

                                            <div class="col-lg-4 col-sm-6">
                                                <div class="overlay">
                                                    <a href="/assets/images/schools/gallery/<?=$image?>">
                                                        <div class="overlay-background">
                                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                                        </div>
                                                        <img src="/assets/images/schools/gallery/<?=$image?>" alt="Image <?=$i++?>"
                                                        class="img-fluid blur-up lazyload bg-img">
                                                    </a>
                                                </div>
                                            </div>

                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="menu-part tab-pane fade review" id="reviews">
                              <?php 
                              $rql = "SELECT * FROM ng_reviews WHERE scid = ? AND enabled = ?";
                              $rstmt= $db->prepare($rql);
                              $scid = $crow['id'];
                              $status = 'yes';
                              $rstmt->bind_param('ss',$scid,$status);
                              $rstmt->execute();
                              $rres = $rstmt->get_result();

                              while($rrow = $rres->fetch_assoc()) : 
                                $dated = date_create($rrow['date_created']);
                                $num = $rrow['stars'];
                                $stql = "SELECT first_name,other_names FROM ng_students WHERE id = ?";
                                $sttmt = $db->prepare($stql);
                                $stid = $rrow['sid'];
                                $sttmt->bind_param('i',$stid);
                                $sttmt->execute();
                                $sttmt->store_result();
                                $sttmt->bind_result($fname,$lname);
                                $sttmt->fetch();
                                ?>

                                <div class="review-box">
                                    <div class="rating">
                                     <?php
                                     $j = 0;
                                     for ($i=0; $i < 5; $i++) { 
                                        $j++;
                                        if ($num >= $j) {
                                           echo '<i class="fas fa-star"></i>';
                                       }else{
                                           echo '<i class="far fa-star"></i>';

                                       }
                                   }
                                   ?>
                                   <span><?=htest_output($rrow['title']) ?> </span>
                               </div>
                               <h6>by <?=htest_output($fname. " ".$lname) ?> , <?=date_format($dated,'M d, Y')?> </h6>
                               <?=htest_output($rrow['message']) ?> 

                           </div>
                       <?php endwhile; if($rres->num_rows == 0) : ?>
                       <div class="review-box">
                        No reviews yet. Be the first ☺. Apply today.
                    </div>

                <?php endif; ?>
            </div>
            <div class="about menu-part tab-pane fade" id="courses">
             <div class="about-sec">
                <?php 
                $courses = $crow['cid'];
                $courses = explode(',', trim($courses,','));

                foreach ($courses as $course) :

                    $qql = "SELECT name,description FROM ng_courses WHERE id = ?";
                    $qstmt  = $db->prepare($qql);
                    $qstmt->bind_param('i',$course);
                    $qstmt->execute();
                    $qstmt->store_result();
                    $qstmt->bind_result($cname,$cdesc);
                    $qstmt->fetch();
                    ?>
                    <h6> <?=htest_output($cname) ?> </h6>
                    <ul>
                        <li> <?=htest_output($cdesc) ?> </li>

                    </ul>
                <?php endforeach; if (empty($courses)) : ?>
                <h6> No courses </h6>
                <ul>
                    <li> No courses added for this school. Check in later </li>

                </ul>
            <?php endif?>
        </div>
    </div>
</div>
</div>
</div>
<div class="col-xl-3 col-lg-4 ">
    <div class="sticky-cls-top">
        <div class="single-sidebar">
            <div class="selection-section">
                <h4 class="title">Apply for school</h4> 
                <?php if(!isset($_SESSION['student_login_status']) && @$_SESSION['student_login_status'] != true){ ?>
                    <div class="book-btn-section border-top-0">
                        <div class="detail-top">
                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name">
                              <input type="text" id="other_names" name="first_name" class="form-control" placeholder="Other Names">
                            <input type="email" id="email" name="email" class="form-control"
                            placeholder="Enter your email">
                            <input type="number" id="phone" class="form-control" placeholder="Phone Number">
                        </div>


                        <div class="selector">
                            <select>
                                <option value="" disabled selected>Select course</option>
                                <?php
                                foreach ($courses as $selc) : 
                                   $qql = "SELECT name,id FROM ng_courses WHERE id = ?";
                                   $qstmt  = $db->prepare($qql);
                                   $qstmt->bind_param('i',$selc);
                                   $qstmt->execute();
                                   $qstmt->store_result();
                                   $qstmt->bind_result($nname,$cid);
                                   $qstmt->fetch();

                                   ?>
                                   <option value="<?=encode($cid)?>"><?=$nname?></option>
                               <?php endforeach; if (empty($courses)) : ?>
                               <option value="" disabled>No course available</option>
                           <?php endif; ?>
                               </select>
                           </div>
                           <small>By continuing, an account will be created for you and you agree to our <a href="/privacy-policy" target="_blank">Policies and Legal Notices</a> </small>
                           <button class="btn btn-rounded btn-sm color1">start my
                           journey</button>
                       </div>
                   <?php } else { ?>
                    <div class="book-btn-section border-top-0">
                        <div class="detail-top">
                            <a href="/me/apply?school=slug" class="btn btn-rounded btn-sm color1">Apply on dashboard</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="single-sidebar p-0">
            <div class="newsletter-sec">
                <div>
                    <h4 class="title">always first</h4>
                    <p>Be the first to find out latest and exclusive offers for <?=htest_output($crow['name']); ?></p>
                    <form>
                        <input type="email" id="email1" class="form-control"
                        placeholder="Enter your email">
                        <div class="button">
                            <a href="#" class="btn btn-solid ">be the first</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</section>
<?php endwhile; if ($cres->num_rows == 0) : ?>
<section class="breadcrumb-section pt-0">
    <img src="/assets/images/schools-image.jpg" class="bg-img img-fluid blur-up lazyload" alt="">
    <div class="breadcrumb-content">
        <div>
            <h2>Partnered Schools</h2>
            <nav aria-label="breadcrumb" class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="/schools">schools</a></li>
                    <li class="breadcrumb-item active" aria-current="page">School not found</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="title-breadcrumb">Naam</div>
</section>
<section class="single-section small-section bg-inner">
    <div class="container">
        <div class="row">
           <div class="col-12">
              <div>
                <div class="blog-wrap">

                    <div class="blog-details">

                        <h5 class="text-center">Ooops! School link is invalid</h5>
                        <p class="text-center"> <a href="/schools" class="btn btn-curve btn-lower color1">Browse Schools</a></p>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
</section>
<?php endif; ?>
<?php endif; ?>

<?php include "ng-footer.php" ?>