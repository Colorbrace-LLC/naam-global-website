<?php
session_name('naamglobal');
session_start();
ignore_user_abort(true);
set_time_limit(0); 

$file = isset($_GET['file']) ? $_GET['file'] : '';

if ($file) {
  $path_parts = pathinfo($_GET['file']);
  $file_name  = $path_parts['basename'];
  
   $path_to_filevault_dir = "assets/files";
  

  $path_to_file  = $path_to_filevault_dir . '/' . $file_name;
  

  if (!file_exists($path_to_file)) {
    
    exit('<div style="border-radius: 5px;margin: 0 0 20px;padding: 15px 30px 15px 15px;border-left: 5px solid #eee;border-color: #f62d51;color: #fff!important;background-color: #f62d51 !important;">
    <h4 style=" font-weight: 600;margin-top: 0;">A Technical Error Has Occurred!</h4>

    <p style=" margin-bottom: 0;">Invalid file specified. Please notify the webmaster if you think this is a mistake using the <a href="/contact-us" style="color:#fff;text-decoration:underline;">contact form</a>.</p>
    </div>');
  }
  
  if (!is_readable($path_to_file)) {
   
    exit('<div style="border-radius: 5px;margin: 0 0 20px;padding: 15px 30px 15px 15px;border-left: 5px solid #eee;border-color: #f62d51;color: #fff!important;background-color: #f62d51 !important;">
    <h4 style=" font-weight: 600;margin-top: 0;">A Technical Error Has Occurred!</h4>

    <p style=" margin-bottom: 0;">There is a problem that we need to fix.If you are a user seeing this message please reach us by using the <a href="/contact-us" style="color:#fff;text-decoration:underline;">contact form</a>.</p>
    </div>');
  }
  
  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  header('Content-Type: ' . finfo_file($finfo, $path_to_file));
  
  $finfo = finfo_open(FILEINFO_MIME_ENCODING);
  header('Content-Transfer-Encoding: ' . finfo_file($finfo, $path_to_file)); 

  header('Content-disposition: attachment; filename="' . basename($path_to_file) . '"'); 

  readfile($path_to_file);
}
else {
 
  
 $_SESSION['showError'] =  "<script>function readError() {
     iziToast.warning({
         title: 'Download Error!',
         message: 'Missing file parameter. check link and try again',
         position: 'topRight'  });
        ]
    } readError(); </script>";

    ?>

    <script type="text/javascript">
      function backAway(){

        window.history.back();
        window.location.replace('/me');
      }
      backAway();
    </script>

    <?php
  } 
  ?>

?>