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
		Naam Auth - Login
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
				<a class="navbar-brand" href="javascript:;">Authentication</a>
			</div>
			<button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
				<span class="sr-only">Toggle navigation</span>
				<span class="navbar-toggler-icon icon-bar"></span>
				<span class="navbar-toggler-icon icon-bar"></span>
				<span class="navbar-toggler-icon icon-bar"></span>
			</button>
			<div class="collapse navbar-collapse justify-content-end">
				<ul class="navbar-nav">
					<li class="nav-item ">
						<a href="/home" class="nav-link">
							<i class="material-icons">home</i>
							Home
						</a>
					</li>
					<li class="nav-item  active ">
						<a href="login" class="nav-link">
							<i class="material-icons">fingerprint</i>
							Login
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="wrapper wrapper-full-page">
		<div class="page-header login-page header-filter" filter-color="black" style="background-image: url('/assets/images/login.jpg'); background-size: cover; background-position: top center;">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
						<form class="form login-form" method="post">
							<div class="card card-login card-hidden">
								<div class="card-header card-header-rose text-center">
									<h4 class="card-title">Login</h4>
								</div>
								<div class="card-body ">
									<p class="card-description text-center">Be Classical</p>
									<span class="bmd-form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">
													<i class="material-icons">email</i>
												</span>
											</div>
											<input type="email" name="login_email" required class="form-control" placeholder="email address">
										</div>
									</span>
									<span class="bmd-form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">
													<i class="material-icons">lock_outline</i>
												</span>
											</div>
											<input type="password" name="login_password" required class="form-control" placeholder="password">
										</div>
									</span>
								</div>
								<div class="card-footer justify-content-center">
									<button type="submit" class="btn btn-rose btn-link btn-lg login-btn">Let's Go</button>
								</div>
							</div>
						</form>
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