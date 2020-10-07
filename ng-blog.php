<?php
session_name('naamglobal');
session_start();
$page = 'blog';
$page_title = 'News Stand : ';
include "ng-header.php";

$total_pages = $db->query("SELECT * FROM ng_blog WHERE status = 'published'")->num_rows;

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

$num_results_on_page = 6;

if ($istmt = $db->prepare('SELECT * FROM ng_blog WHERE status = ? ORDER BY id DESC LIMIT ?,?')) {
    $status = 'published';
    $calc_page = ($page - 1) * $num_results_on_page;
    $istmt->bind_param('sii', $status, $calc_page, $num_results_on_page);
    $istmt->execute(); 

    $iresult = $istmt->get_result();
    
} 

?>

<section class="breadcrumb-section pt-0">
    <img src="/assets/images/blog.jpg" class="bg-img img-fluid blur-up lazyload" alt="">
    <div class="breadcrumb-content">
        <div>
            <h2>Blog</h2>
            <nav aria-label="breadcrumb" class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">blog</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="title-breadcrumb">Naam</div>
</section>
<div class="error"></div>

<section class="section-b-space bg-white">
    <div class="container">
        <div class="row" data-sticky_parent>
            <?php  $blogslug = isset($_GET['blogslug']) ? $_GET['blogslug'] : '';  if (!$blogslug) : ?>
            <div class="col-lg-12">
                <div class="blog_section mt-0 blog-inner ratio_55">
                    <div class="row">
                        <?php  while ($irow = $iresult->fetch_assoc()) : 
                            $dated = date_create($irow['date_created']);

                            ?>
                            <div class="col-md-6">
                                <div class="blog-wrap wow fadeInUp">
                                    <div class="blog-image">
                                        <a href="/blog/<?=$irow['slug']?>">
                                            <img src="/assets/images/blog/<?=$irow['image']?>"
                                            class="img-fluid blur-up lazyload bg-img" alt="<?=htmlspecialchars_decode(html_entity_decode($irow['title'],ENT_QUOTES)); ?>">
                                        </a>
                                        <div class="blog-label">
                                            <div>
                                                <h3>  <?=date_format($dated,'d'); ?></h3>
                                                <h6> <?=date_format($dated,'M'); ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="blog-details">
                                        <h6><i class="fas fa-calendar-alt"></i>  <?=date_format($dated,'Y'); ?></h6>
                                        <a href="/blog/<?=$irow['slug']?>">
                                            <h5><?=htmlspecialchars_decode(html_entity_decode($irow['title'],ENT_QUOTES)); ?> </h5>

                                        </a>
                                        <?=htmlspecialchars_decode(html_entity_decode($irow['excerpt'],ENT_QUOTES)); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                        <nav aria-label="Naam Blog Pagination" class="pagination-section mt-0">
                            <ul class="pagination">
                                <?php if ($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="/blog-<?=$page-1?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>

                                <?php endif; ?>
                                <?php if ($page > 3) : ?>
                                  <li class="page-item"><a class="page-link" href="/blog-1">1</a></li>
                                  <li class="page-item dots">...</li>
                              <?php  endif; ?>
                              <?php if ($page-2 > 0) : ?>
                               <li class="page-item"><a class="page-link" href="/blog-<?=$page-2?>"><?=$page-2?></a></li>
                           <?php  endif; ?>
                           <?php if ($page-1 > 0) : ?>
                             <li class="page-item"><a class="page-link" href="/blog-<?=$page-1?>"><?=$page-1?></a></li>
                         <?php  endif; ?>
                         <li class="page-item active"><a class="page-link" href="/blog-<?=$page?>"><?=$page?></a></li>
                         <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1) : ?>
                            <li class="page-item"><a class="page-link" href="/blog-<?=$page+1?>"><?=$page+1?></a></li>
                        <?php  endif; ?>
                        <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1) : ?>
                           <li class="page-item"><a class="page-link" href="/blog-<?=$page+2?>"><?=$page+2?></a></li>
                       <?php  endif; ?>
                       <?php if ($page < ceil($total_pages / $num_results_on_page)-2) : ?>
                         <li class="page-item dots">...</li>
                         <li class="page-item"><a href="/blog-<?=ceil($total_pages / $num_results_on_page)?>"  class="page-link"><?=ceil($total_pages / $num_results_on_page)?></a></li>
                     <?php  endif; ?>
                     <?php if ($page < ceil($total_pages / $num_results_on_page)) : ?>
                         <li class="page-item">
                            <a class="page-link" href="/blog-<?=$page+1?>" aria-label="Next">
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
<?php endif; if($blogslug):

$slug =trim($blogslug);

$cql = "SELECT * FROM ng_blog WHERE status = ? AND slug = ?";
$cstmt= $db->prepare($cql);
$status = 'published';
$cstmt->bind_param('ss', $status,$slug);
$cstmt->execute();
$cres = $cstmt->get_result();

?>
<div class="col-lg-9">
    <?php while ($crow = $cres->fetch_assoc()) :
        $posted = date_create($crow['date_created']);
        ?>
        <div class="blog-single-detail">
            <div class="top-image">
                <img src="/assets/images/blog/<?=$crow['image']?>" alt="<?=htmlspecialchars_decode(html_entity_decode($crow['title'],ENT_QUOTES)); ?>" class="img-fluid blur-up lazyload container-fluid">
            </div>
            <div class="title-part">
                <ul class="post-detail">
                    <li><?=date_format($posted, 'jS F Y')?></li>
                </ul>
                <h3><?=htmlspecialchars_decode(html_entity_decode($crow['title'],ENT_QUOTES)); ?></h3>
            </div>
            <div class="detail-part">
                <?=htmlspecialchars_decode(html_entity_decode($crow['description'],ENT_QUOTES)); ?>
            </div>
        </div>
    <?php endwhile; if ($cres->num_rows == 0) : ?>
    <div class="blog-single-detail">
            
            <div class="title-part">
               
                <h3>Blog post is not found</h3>
            </div>
            
        </div>
<?php endif ?>
</div>
<div class="col-lg-3">
    <div class="sticky-cls-top">
        <div class="blog-sidebar">
            <div class="blog-wrapper">
                <div class="sidebar-title">
                    <h5>Recent Articles</h5>
                </div>
                <div class="sidebar-content">
                    <ul class="blog-post">
                      <?php

                      $aql = "SELECT * FROM ng_blog WHERE status = ? AND slug != ? ORDER BY id DESC";
                      $astmt= $db->prepare($aql);
                      $status = 'published';
                      $astmt->bind_param('ss', $status,$slug);
                      $astmt->execute();
                      $ares = $astmt->get_result();

                      while ($arow = $ares->fetch_assoc()) :
                        $posted  = date_create($arow['date_created']);
                        ?>
                        <li>
                            <div class="media">
                                <img class="img-fluid blur-up lazyload"
                                src="/assets/images/blog/<?=$arow['image']?>"
                                alt=" <?=htmlspecialchars_decode(html_entity_decode($arow['title'],ENT_QUOTES)); ?>">
                                <div class="media-body align-self-center">
                                    <div>
                                        <h6><a href="/blog/<?=$arow['slug']?>" class="text-dark"><?=htmlspecialchars_decode(html_entity_decode($arow['title'],ENT_QUOTES)); ?></a></h6>
                                        <p><?=date_format($posted, 'd M Y'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endwhile; if ($ares->num_rows == 0) :?>
                    <li>
                            <div class="media">
                                
                                <div class="media-body align-self-center">
                                    <div>
                                        <h6>No other article available</h6>
                                    </div>
                                </div>
                            </div>
                        </li>
                <?php endif; ?>
                </ul>
            </div>
        </div>

    </div>
</div>
</div>
<?php endif; ?>
</div>
</div>
</section>

<?php include "ng-footer.php" ?>