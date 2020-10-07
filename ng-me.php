<?php
session_name('naamglobal');
session_start();
$page = 'me';
if (isset($_SESSION['student_name'])) {
}else {
    $_SESSION['student_name'] = 'Error';

}
$page_title = $_SESSION['student_name'].' : ';
include "ng-header.php";

if (studentConfirmLogin() == false) {
    $_SESSION['showError'] = "<script>function showError() {
     iziToast.warning({
         title: 'Action Required!',
         message: 'Unauthorized! You need to be logged in.',
         position: 'bottomRight'  });
     } showError(); </script>";

     redirect('/signin');
     exit();
 }
 $emailCookieName = encode("studentEmail",'e');

 $tokenCookieName = encode("studentToken",'e');
 if (isset($_SESSION['student_login_status'])  && $_SESSION['student_login_status'] === true) {

  $token = $_SESSION['student_token'];

  $sql = "SELECT * FROM ng_students WHERE email_address = ?";

  $astmt = $db->prepare($sql);
  $email_address = $_SESSION['student_email'];
  $astmt->bind_param("s", $email_address);
  $astmt->execute();

  $res = $astmt->get_result();
  $arow = $res->fetch_assoc();


} elseif (isset($_COOKIE[$emailCookieName])) {

   $decryptToken = $_COOKIE[$tokenCookieName];


   $token = detail_secure($decryptToken, 'd');

   $decryptIndex = $_COOKIE[$emailCookieName];

   $email_address =  detail_secure($decryptIndex, 'd');

   $sql = "SELECT * FROM ng_students WHERE email_address = ?";
   $astmt = $db->prepare($sql);
   $astmt->bind_param("s", $email_address);
   $astmt->execute();

   $res = $astmt->get_result();
   $arow = $res->fetch_assoc();

}

if ($res->num_rows === 0) {
 $_SESSION['showError'] = "<script>function showError() {
   iziToast.warning({
         title: 'Action Required!',
         message: 'Unauthorized! You need to be logged in.',
         position: 'bottomRight'  });
 } showError(); </script>";

 redirect('/signin');
 exit();  
}

$profileArray = $arow['profile_info'];

$profileArray = unserialize($profileArray);

$academicArray = $arow['academic_info'];

$academicArray = unserialize($academicArray);

$programArray = $arow['program_info'];

$programArray = unserialize($programArray);

$documentsArray = $arow['documents_info'];

$documentsArray = unserialize($documentsArray);

$parentsArray = $arow['parents_info'];

$parentsArray = unserialize($parentsArray);

$referralArray = $arow['referral_info'];

$referralArray = unserialize($referralArray);


?>

<section class="breadcrumb-section pt-0">
    <img src="/assets/images/services.jpg" class="bg-img img-fluid blur-up lazyload" alt="">
    <div class="breadcrumb-content">
        <div>
            <h2>My Dashboard</h2>
            <nav aria-label="breadcrumb" class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User</li>
                    <li class="breadcrumb-item active" aria-current="page">My Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="title-breadcrumb">Naam</div>
</section>

<?php 
$actype = $arow['account_type'];

switch ($actype) {
  case 'student':
   include 'ng-students.php';
    break;
  case 'tour':
   include 'ng-tours.php';
    break;
  case 'visa':
   include 'ng-visa.php';
    break;
  default:
    # code...
    break;
}

 ?>
<?php

 include "ng-footer.php" ?>