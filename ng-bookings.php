<?php
session_name('naamglobal');
session_start();
$page = 'bookings';
$page_title = 'Service Bookings : ';
include "ng-header.php";
?>

<section class="breadcrumb-section pt-0">
    <img src="/assets/images/bookings.jpg" class="bg-img img-fluid blur-up lazyload" alt="">
    <div class="breadcrumb-content">
        <div>
            <h2>Service Bookings</h2>
            <nav aria-label="breadcrumb" class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Service Bookings</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="title-breadcrumb">Naam</div>
</section>
  
 <section class="section-b-space dark-cls animated-section">
        <img src="/assets/images/cab/grey-bg.jpg" alt="" class="img-fluid blur-up lazyload bg-img">
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
                            <h3>Service Bookings</h3>
                        </div>
                        <form method="post" enctype="multipart/form-data" class="service-form">
                           <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" name="bfname" id="fname" placeholder="first name"
                                        required="">
                                </div>
                                 <div class="form-group col-md-6">
                                    <input type="text" class="form-control" name="boname" id="oname" placeholder="other names"
                                        required="">
                                </div>
                                </div>
                                <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="valid email address"
                                        required="">
                                </div>
                                 <div class="form-group col-md-6">
                                    <input type="number" class="form-control" name="phone" id="phone" placeholder="valid phone number"
                                        required="">
                                </div>
                                </div>
                            <div class="form-group">
                                <label for="service">Select service</label>
                                 <select id="service" class="form-control" required name="service">
                                <option value="" disabled selected>choose service</option>
                                <?php 
                                   $sql = "SELECT * FROM ng_services";
                                   $stmt  = $db->prepare($sql);
                                   $stmt->execute();
                                   $res = $stmt->get_result();
                                   while ($row = $res->fetch_assoc()) :
                                   ?>
                                   <option value="<?=encode($row['id'])?>"><?=$row['title']?></option>
                               <?php endwhile; if ($res->num_rows == 0) : ?>
                               <option value="" disabled>No service available</option>
                           <?php endif; ?>
                               </select>
                            </div>
                             <div class="form-group">
                                <label for="category">Select category <span  style="display: none" class="float right cat-loader spinner-border spinner-border-sm text-danger "></span></label>
                                 <select id="category" class="form-control" name="category" required disabled>
                                <option value="" disabled selected>Choose category</option>
                               
                               </select>
                            </div>

                           
                            <div class="form-group">
                                <label for="exampleInputPassword1">Optional Notes</label>
                               <textarea class="form-control" id="notes" name="notes" placeholder="Optional message to us"></textarea>
                            </div>
                            <div class="button-bottom">
                                <button type="submit" class="w-100 btn btn-solid service-btn">Book Now</button>
                               
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php include "ng-footer.php" ?>