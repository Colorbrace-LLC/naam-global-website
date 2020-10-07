<?php
session_name('naamglobal');
session_start();
require_once '../includes/functions.php';


if(!function_exists('hash_equals')) {
    function hash_equals($str1, $str2) {
        if(strlen($str1) != strlen($str2)) {
            return false;
        } else {
            $res = $str1 ^ $str2;
            $ret = 0;
            for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
                return !$ret;
        }
    }
}

$queryStrToken = isset($_GET['token']) ? $_GET['token'] : '';


if (isset($_SESSION['admin_token'])) {

    $token = $_SESSION['admin_token'];

}else{

    $token = "Invalid";
}

if(hash_equals($token, $queryStrToken)){


  session_destroy();
  
  session_name('naamglobal');
  session_start();
  $_SESSION['logoutSuccess'] =  "<script>function logoutSuccess() {
     iziToast.success({
         title: 'Success!',
         message: 'You have securely logged out',
         position: 'bottomRight'  });
 } logoutSuccess(); </script>";


 redirect('/admin-cp/login');

}else{ 

    $_SESSION['logoutError'] =  "<script>function logoutError() {
     iziToast.warning({
         title: 'Action Required!',
         message: 'You cannot logout without a valid token',
         position: 'bottomRight'  });
 } logoutError(); </script>";

 ?>

 <script type="text/javascript">
    function backAway(){

        window.history.back();
        window.location.replace('/admin-cp/login');
    }
    backAway();
</script>

<?php
}

?>