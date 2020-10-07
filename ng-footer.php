<!-- footer start -->
<footer class="effect-cls-up footer-bg">
   <img src="/assets/images/tour/background/13.jpg" class="img-fluid blur-up lazyload bg-img" alt="">
   <div class="footer section-b-space section-t-space">
    <div class="container">
        <div class="row order-row">

            <div class="col-12">
                                <div class="footer-content">
                    <div class="footer-place">
                        <div class="row">
                            <?php 
                            $sql = "SELECT * FROM ng_schools WHERE enabled  = ? ORDER BY id DESC";
                            $stmt = $db->prepare($sql);
                            $enabled = 'yes';
                            $stmt->bind_param('s',$enabled);
                            $stmt->execute();
                            $res = $stmt->get_result();
                            while ($row = $res->fetch_assoc()) :
                                ?>
                                <div class="col-3">
                                    <div class="place rounded5 ratio2_1 ">
                                        <a href="/school/<?=$row['slug']?>">
                                            <img src="/assets/images/schools/<?=$row['image']?>"
                                            class="img-fluid blur-up lazyload" alt="<?=htmlspecialchars_decode(html_entity_decode($row['name'],ENT_QUOTES)); ?>">
                                            <div class="overlay">
                                                <h6><?=htmlspecialchars_decode(html_entity_decode($row['name'],ENT_QUOTES)); ?></h6>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php endwhile;  if($res->num_rows == 0) : ?>
                            <div class="blog-wrap">

                                <div class="blog-details">
                                    <a href="#!">
                                        <h5 class="text-center">No schools to show</h5>

                                    </a>

                                </div>
                                <p class="text-center"> <a href="/home" class="btn btn-curve btn-lower color1">go home</a></p>
                            </div>
                        <?php endif; ?>


                    </div>
                </div>
            </div>
        </div>
        
  
    </div>
</div>
</div>
<div class="sub-footer">
    <div class="container">
        <div class="row ">
            <div class="col-6">
             <small class="text-muted"> &copy; <?=date('Y')?> <?=$site_name?></small> 
                  
                </div>
                <div class="col-6">
                    <div class="copy-right">
                        <p><a href="/privacy-policy" class="text-muted"><small> policies and legal notices</small></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="tap-top">
    <div>
        <i class="fas fa-angle-up"></i>
    </div>
</div>

<script src="/assets/js/jquery-3.5.1.min.js"></script>

<script src="/assets/js/popper.min.js"></script>

<script src="/assets/js/slick.js"></script>

<script src="/assets/js/jquery.ripples.js"></script>

<?php if ($page == 'blog') : ?>
 <script src="/assets/js/footer-reveal.min.js"></script>

 <script src="/assets/js/wow.min.js"></script>
<?php endif; ?>
<?php if ($page == 'schools') : ?>
    <script src="../assets/js/jquery.magnific-popup.js"></script>
    <script src="../assets/js/zoom-gallery.js"></script>
<?php endif; ?>

<?php if ($page == 'me') : ?>
    <script src='/assets/js/apexcharts.js'></script>
<?php endif; ?>
<script src="/assets/js/bootstrap.js"></script>

<script src="/assets/js/lazysizes.min.js"></script>
<script src="/assets/js/iziToast.min.js"></script>

<script src="/assets/js/script.js"></script>
<script src="/assets/js/controller.js"></script>


<script>
    $(document).ready(function () {
        try {
            $('.ripple-effect').ripples({
                resolution: 256,
                perturbance: 0.005
            });
        } catch (e) {
            $('.error').show().text(e);
        }
    });
    <?php if ($page == 'blog') : ?>
        $('footer').footerReveal();
        new WOW().init();
    <?php endif; ?>
    <?php if (isset($arow['account_type']) && $arow['account_type'] == 'student') : $total = $i; $accepted = round(($a/3) * 100); $declined = round(($d/3) * 100); $processing = round(($p/3) * 100);  ?>
        var options = {
            chart: {
                height: 350,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    dataLabels: {
                        name: {
                            fontSize: '22px',
                        },
                        value: {
                            fontSize: '16px',
                        },
                        total: {
                            show: true,
                            label: 'Applied',
                            formatter: function (w) {

                                return <?=$total?>
                            }
                        }
                    }
                }
            },
            series: [<?=$accepted?>, <?=$declined?>, <?=$processing?>],
            labels: ['Accepted', 'Cancelled', 'Processing'],
            colors:[ '#28A745', '#FFC107', '#17A2B8'],
            stroke: {
                lineCap: "round",
            }

        }

        var chart = new ApexCharts(
            document.querySelector("#chart"),
            options
            );

        chart.render();

    <?php endif; ?>

    <?php if(isset($arow['submitted']) && $arow['submitted'] =='yes') :
        ?>
        $('button[type="submit"]').remove();
        $('form input, select, textarea').attr('disabled','disabled');
    <?php endif; ?>
</script>

</body>


</html>
<?php 
if (isset($_SESSION['showError'])) {
    echo $_SESSION['showError'];
    unset($_SESSION['showError']);
}
if (isset($_SESSION['logoutError'])) {
    echo $_SESSION['logoutError'];
    unset($_SESSION['logoutError']);
}

if (isset($_SESSION['logoutSuccess'])) {
    echo $_SESSION['logoutSuccess'];
    unset($_SESSION['logoutSuccess']);
}

?>