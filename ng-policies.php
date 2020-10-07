<?php
session_name('naamglobal');
session_start();
$page = 'policies';
$page_title = 'Policies and Legal Notices : ';
include "ng-header.php";
?>

<section class="breadcrumb-section pt-0">
    <img src="/assets/images/services.jpg" class="bg-img img-fluid blur-up lazyload" alt="">
    <div class="breadcrumb-content">
        <div>
            <h2>Policies and Legal Noticies</h2>
            <nav aria-label="breadcrumb" class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Policies and Legal Notices</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="title-breadcrumb">Naam</div>
</section>

  <section class="small-section bg-inner" data-sticky_parent>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="pro_sticky_info" data-sticky_column>
                        <div class="faq-tab">
                            <ul class="nav nav-tabs" id="top-tab" role="tablist">
                                <li class="nav-item"><a data-toggle="tab" class="nav-link active"
                                        href="#policies">Policies</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#terms">Terms & Legal Noticies</a>
                                </li>
                               
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="product_img_scroll" data-sticky_column>
                        <div class="faq-content tab-content" id="top-tabContent">
                            <div class="tab-pane fade show active" id="policies">
                                <div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>
                                                Privacy Policies
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                          <?=htmlspecialchars_decode(html_entity_decode($site_policies,ENT_QUOTES)) ?>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                           
                            <div class="tab-pane fade" id="terms">
                                <div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>
                                                Terms & Legal Noticies
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                          <?=htmlspecialchars_decode(html_entity_decode($site_terms,ENT_QUOTES)) ?>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include "ng-footer.php" ?>