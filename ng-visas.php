<?php
session_name('naamglobal');
session_start();
$page = 'visa';
$page_title = 'Visa Application : ';
include "ng-header.php";

$total_pages = $db->query("SELECT * FROM ng_visas WHERE enabled = 'yes'")->num_rows;

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

$num_results_on_page = 6;

if ($istmt = $db->prepare('SELECT * FROM ng_visas WHERE enabled = ? ORDER BY id DESC LIMIT ?,?')) {
    $status = 'yes';
    $calc_page = ($page - 1) * $num_results_on_page;
    $istmt->bind_param('sii', $status, $calc_page, $num_results_on_page);
    $istmt->execute(); 

    $iresult = $istmt->get_result();
    
} 

?>

<section class="breadcrumb-section pt-0">
    <img src="/assets/images/visa-background.jpg" class="bg-img img-fluid blur-up lazyload" alt="">
    <div class="breadcrumb-content">
        <div>
            <h2>Visa Application</h2>
            <nav aria-label="breadcrumb" class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Visa Application</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="title-breadcrumb">Naam</div>
</section>
<section class="book-table section-b-space p-0 single-table">
    <div class="container">
        <div class="row">
            <div class="col my-auto d-flex justify-content-center">
                <div class="table-form" >
                    <form>
                        <a href="/signup?type=visa" class="btn btn-rounded color1">Apply For Visa</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="small-section bg-inner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 ratio3_2">
                <div class="product-wrapper-grid special-section grid-box">
                    <div class="row content grid">
                     <?php  while ($irow = $iresult->fetch_assoc()) : 

                        ?>
                        <div class="col-xl-4 col-sm-6 popular grid-item wow fadeInUp">
                            <div class="special-box p-0">
                                <div class="special-img">
                                    <a href="#!">
                                        <img src="/assets/images/visas/<?=$irow['image']?>"
                                        class="img-fluid blur-up lazyload bg-img" alt="<?=htmlspecialchars_decode(html_entity_decode($irow['name'],ENT_QUOTES)); ?>">
                                    </a>

                                    <div class="content_inner">
                                        <a href="#!">
                                            <h5><?=htmlspecialchars_decode(html_entity_decode($irow['name'],ENT_QUOTES)); ?></h5>
                                        </a>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; if ($iresult->num_rows == 0) : ?>
                    <div class="blog-single-detail">

                        <div class="title-part">

                            <h3>No visas available. check in later</h3>
                        </div>

                    </div>
                <?php endif ?>
            </div>
        </div>
        <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
            <nav aria-label="Naam Des Pagination" class="pagination-section mt-0">
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="/visa-application/<?=$page-1?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>

                    <?php endif; ?>
                    <?php if ($page > 3) : ?>
                      <li class="page-item"><a class="page-link" href="/visa-application/1">1</a></li>
                      <li class="page-item dots">...</li>
                  <?php  endif; ?>
                  <?php if ($page-2 > 0) : ?>
                   <li class="page-item"><a class="page-link" href="/visa-application/<?=$page-2?>"><?=$page-2?></a></li>
               <?php  endif; ?>
               <?php if ($page-1 > 0) : ?>
                 <li class="page-item"><a class="page-link" href="/visa-application/<?=$page-1?>"><?=$page-1?></a></li>
             <?php  endif; ?>
             <li class="page-item active"><a class="page-link" href="/visa-application/<?=$page?>"><?=$page?></a></li>
             <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1) : ?>
                <li class="page-item"><a class="page-link" href="/visa-application/<?=$page+1?>"><?=$page+1?></a></li>
            <?php  endif; ?>
            <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1) : ?>
               <li class="page-item"><a class="page-link" href="/visa-application/<?=$page+2?>"><?=$page+2?></a></li>
           <?php  endif; ?>
           <?php if ($page < ceil($total_pages / $num_results_on_page)-2) : ?>
             <li class="page-item dots">...</li>
             <li class="page-item"><a href="/visa-application/<?=ceil($total_pages / $num_results_on_page)?>"  class="page-link"><?=ceil($total_pages / $num_results_on_page)?></a></li>
         <?php  endif; ?>
         <?php if ($page < ceil($total_pages / $num_results_on_page)) : ?>
             <li class="page-item">
                <a class="page-link" href="/visa-application/<?=$page+1?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        <?php  endif; ?>

    </ul>
</nav>
<?php endif; ?>
</div>
</div>
</div>
</section>
<?php include "ng-footer.php" ?>