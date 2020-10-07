<!DOCTYPE html>
<html>
<head>
	<title>NMC Scrapper</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
	<div class="mt-5">
		<form method="post" class="md5-form">
  <div class="form-group">
    <label for="md5">Enter value</label>
    <input type="text" class="form-control" id="md5" name="md5" aria-describedby="md5Help" placeholder="e.g 1">
    <small id="md5Help" class="form-text text-muted">Enter value to fetch and save</small>
  </div>
 
  <button type="submit" class="btn btn-primary sub">Fetch & Save</button>
</form>
<div class="mt-3 response">
	
</div>
	</div>
</div>
</body>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script type="text/javascript">
	$(document).ready(function(){

			var md5_form = $('form.md5-form'), md5_button = $('button.sub');

			md5_form.on('submit',function(md5){
				md5.preventDefault();
				md5_button.text("Fetching...");
				md5_button.addClass('disabled');
				$.post("processor.php",md5_form.serialize(),function(response){
				$('div.response').html(response);
				md5_button.text("Fetch & Save");
				md5_button.removeClass('disabled');
				});
			});
	});
</script>
</html>