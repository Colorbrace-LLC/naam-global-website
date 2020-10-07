<?php
session_name('naamglobal');
session_start();
include_once '../includes/functions.php';

if (isset($_SESSION['staff_login_status'])  && $_SESSION['staff_login_status'] === true) {

	redirect('dashboard');

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="/assets/images/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>
		Error - Page not found
	</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/iziToast.min.css">


	<link href="/assets/css/naam-dashboard.css?v=2.1.2" rel="stylesheet" />
</head>

<body class="off-canvas-sidebar">

	<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
		<div class="container">
			<div class="navbar-wrapper">
				<a class="navbar-brand" href="javascript:;">Error page</a>
			</div>
			<button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
				<span class="sr-only">Toggle navigation</span>
				<span class="navbar-toggler-icon icon-bar"></span>
				<span class="navbar-toggler-icon icon-bar"></span>
				<span class="navbar-toggler-icon icon-bar"></span>
			</button>
			<div class="collapse navbar-collapse justify-content-end">
				<ul class="navbar-nav">
					<?php if(isset($_SESSION['admin_login_status'])) { ?>
					<li class="nav-item ">
						<a href="../dashboard" class="nav-link">
							<i class="material-icons">dashboard</i>
							Dashboard
						</a>
					</li>
				<?php } else { ?>
					<li class="nav-item  active ">
						<a href="../login" class="nav-link">
							<i class="material-icons">home</i>
							Home
						</a>
					</li>
				<?php } ?>
				</ul>
			</div>
		</div>
	</nav>
  <div class="wrapper wrapper-full-page">
    <div class="page-header error-page header-filter" style="background-image: url('/assets/images/clint-mckoy.jpg')">
      <div class="content-center">
        <div class="row">
          <div class="col-md-12">
            <h1 class="title">404</h1>
            <h2>Page not found :(</h2>
            <h4>Ooooups! Looks like you got lost.</h4>
          </div>
        </div>
      </div>
     	<footer class="footer">
				<div class="container">
					<nav class="float-left">
						<ul>
							<li>
								<a href="/home">
									Naam Global Educational Travel and Tour
								</a>
							</li>

						</ul>
					</nav>
					<div class="copyright float-right">
						&copy;
						<?=date('Y')?>, made with <i class="material-icons">favorite</i> by
						<a href="https://www.colorbrace.com/" target="_blank">Colorbrace LLC</a> for a better web.
					</div>
				</div>
			</footer>
    </div>
  </div>
	<script src="/assets/js/core/jquery.min.js"></script>
	<script src="/assets/js/core/popper.min.js"></script>
	<script src="/assets/js/core/bootstrap-material-design.min.js"></script>
	<script src="/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>

	<script src="/assets/js/plugins/bootstrap-notify.js"></script>

	<script src="/assets/js/naam-dashboard.js?v=2.1.2" type="text/javascript"></script>
	<script src="/assets/js/iziToast.min.js"></script>
	<script src="/assets/js/dash-controller.js" type="text/javascript"></script>

	
	<script>
		$(document).ready(function() {
			md.checkFullPageBackgroundImage();
			setTimeout(function() {
				$('.card').removeClass('card-hidden');
			}, 700);
		});
	</script>
</body>
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
</html>