<?php
error_reporting(E_ALL); 
ini_set('user_agent',$_SERVER['HTTP_USER_AGENT']??null);
ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors',TRUE);
ini_set('log_errors',TRUE);
ini_set('error_log', 'errors.log');

require_once 'dbcon.php';



date_default_timezone_set('Africa/Accra');

$cfql = "SELECT site_name,site_url,site_logo,address,support_email,phone_number,policies,terms FROM ng_settings";
$cfstmt = $db->prepare($cfql);
$cfstmt->execute();
$cfstmt->store_result();
$cfstmt->bind_result($site_name,$site_url,$site_logo,$site_address,$site_email,$site_phone,$site_policies,$site_terms);
$cfstmt->fetch();


function redirect($location){
  $data = "<script>location.replace('".$location."');</script>";
  echo $data;
}


function generateRandomString($length = 10) {
  $characters = 'abcdefghijklmnopqrstuvwxyz123456789';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

function passwordEncryption($password) {
  $BlowFish_Hash_Format = "$2y$10$";
  $Salt_Length = 22;
  $Salt = generateSalt($Salt_Length);
  $Formatting_BlowFish_With_Salt = $BlowFish_Hash_Format . $Salt;
  $Hash = crypt($password, $Formatting_BlowFish_With_Salt);
  return $Hash;
}

function generateSalt($length){
  $Unique_Random_String = md5(uniqid(mt_rand(), true));

  $Base64_String = base64_encode($Unique_Random_String);

  $Modified_Base64_String = str_replace('+', '.', $Base64_String);

  $Salt = substr($Modified_Base64_String, 0, $length);

  return $Salt;
}

function passwordCheck($password, $Existing_Hash) {
  $Hash = crypt($password, $Existing_Hash);

  if ($Hash === $Existing_Hash) {
    return true;
  }else{
    return false;
  }
}

function passwordStrength($password){
  $uppercase = preg_match('@[A-Z]@', $password);
  $lowercase = preg_match('@[a-z]@', $password);
  $number = preg_match('@[0-9]@', $password);

  if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
    return true;
  }else{
    return false;
  }

}

function countAllBookings(){

  global $db;

  $hql = "SELECT * FROM ng_bookings";
  $hstmt = $db->prepare($hql);
  $hstmt->execute();

  while ($hres = $hstmt->get_result()) {
    return $hres->num_rows;
  }
  // else {
  //   return false;
  // }


}

function getLastBooking(){

  global $db;

  $sql = "SELECT date_added FROM ng_bookings WHERE id = (
    SELECT MAX(id) FROM ng_bookings)";
  $query = mysqli_query($db,$sql);
  $res = mysqli_fetch_array($query);

  return $res[0];
}

function countAllNotifs(){

 global $db;

  $hql = "SELECT * FROM ng_notifications WHERE enabled = ?";
  $enabled = 'yes';
  $hstmt = $db->prepare($hql);
  $hstmt->bind_param('s',$enabled);
  $hstmt->execute();

  while ($hres = $hstmt->get_result()) {
    return $hres->num_rows;
  }
}

function getLastApplication($type){

  global $db;

  if ($type == 'student') {
    $sql = "SELECT submitted_on FROM ng_students WHERE submitted = 'yes' AND account_type ='$type' ORDER BY submitted_on DESC LIMIT 1";
  $query = mysqli_query($db,$sql);
  $res = mysqli_fetch_array($query);

  return $res[0];
  }elseif ($type =='visa') {
    $sql = "SELECT last_updated FROM ng_visa_application ORDER BY last_updated DESC LIMIT 1";
$query = mysqli_query($db,$sql);
$res = mysqli_fetch_array($query);

return $res[0];
  }elseif ($type == 'tour') {
     $sql = "SELECT last_updated FROM ng_tour_bookings ORDER BY last_updated DESC LIMIT 1";
$query = mysqli_query($db,$sql);
$res = mysqli_fetch_array($query);

return $res[0];
  }else{
    return 0;
  }
 
}

function newNotification($placeholder,$message,$type) {

  global $db;

  if ($type == 'id') {
    
    $sql = "SELECT first_name,other_names FROM ng_students WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i',$placeholder);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($fname,$oname);
    $stmt->fetch();

    $nql = "INSERT INTO ng_notifications (notif_from,body,enabled,submitted_on) VALUES (?,?,?,?)";
    $nstmt = $db->prepare($nql);
    $name = $fname." ".$oname;
    $date = date('Y-m-d H:i:s');
    $enabled = 'yes';
    $nstmt->bind_param('ssss',$name,$message,$enabled,$date);
    $nstmt->execute();

  }elseif ($type == 'name') {
   
    $nql = "INSERT INTO ng_notifications (notif_from,body,enabled,submitted_on) VALUES (?,?,?,?)";
    $nstmt = $db->prepare($nql);
    $date = date('Y-m-d H:i:s');
    $enabled = 'yes';
    $nstmt->bind_param('ssss',$placeholder,$message,$enabled,$date);
    $nstmt->execute();
  }else{
    //do nothing
  }
}

function getApplied($type) {

  global $db;

if ($type == 'student') {
 $sql = "SELECT COUNT(`submitted`) FROM ng_students WHERE submitted = 'yes' AND account_type ='$type'";
$query = mysqli_query($db,$sql);
$res = mysqli_fetch_array($query);

return $res[0];
}elseif ($type =='visa') {
 
$sql = "SELECT COUNT(`sid`) FROM ng_visa_application";
$query = mysqli_query($db,$sql);
$res = mysqli_fetch_array($query);

return $res[0];
}elseif ($type == 'tour') {
 $sql = "SELECT COUNT(`sid`) FROM ng_tour_bookings";
$query = mysqli_query($db,$sql);
$res = mysqli_fetch_array($query);

return $res[0];
}else{
  return 0;
}

}


function fetchSchoolName($id){

  global $db;

  $hql = "SELECT name FROM ng_schools WHERE id = ?";
  $hstmt = $db->prepare($hql);
  $hstmt->bind_param('s',$id);
  $hstmt->execute();
  $hstmt->store_result();
  $hstmt->bind_result($school);
  $hstmt->fetch();

   return $school;

}

function checkSubscription($email){

  global $db;

  $sql = "SELECT * FROM ng_subscribers WHERE email_address = ? ";
  $stmt = $db->prepare($sql);
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $stmt -> store_result();
  if ($stmt->num_rows > 0) {
    return true;
  }
  else {
    return false;
  }


}

function checkSlug($slug){
  global $db;

  $query = "SELECT * FROM ng_schools WHERE slug = ? ";
  $stmt = $db->prepare($query);
  $stmt->bind_param('s', $slug);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows > 0) {
    return true;
  }
  else{
    return $slug;
  }
}


function siteURL()
{
  $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
  $domainName = $_SERVER['HTTP_HOST'].'/';
  return $protocol.$domainName;
}

function checkEmail($email){

  global $db;

  $sql = "SELECT * FROM ng_students WHERE email_address = ? ";
  $stmt = $db->prepare($sql);
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $stmt -> store_result();
  if ($stmt->num_rows > 0) {
    return true;
  }
  else {
    return false;
  }


}
function checkStaffEmail($email){

  global $db;

  $sql = "SELECT * FROM ng_admin WHERE email_address = ? ";
  $stmt = $db->prepare($sql);
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $stmt -> store_result();
  if ($stmt->num_rows > 0) {
    return true;
  }
  else {
    return false;
  }


}



function studentEmailLogin($email,$password){

  global $db;

  $sql = "SELECT * FROM ng_students WHERE email_address = ? ";
  $stmt = $db->prepare($sql);
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $res = $stmt->get_result();

  if ($values = $res->fetch_assoc()) {
    if (passwordCheck($password,$values['password'])) {
     return $values;
   }
 }
 else {
  return null;
}

}

function staffEmailLogin($email,$password){

  global $db;

  $sql = "SELECT * FROM ng_admin WHERE email_address = ? ";
  $stmt = $db->prepare($sql);
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $res = $stmt->get_result();

  if ($values = $res->fetch_assoc()) {
    if (passwordCheck($password,$values['password'])) {
     return $values;
   }
 }
 else {
  return null;
}

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlentities($data, ENT_QUOTES);
  $data = htmlspecialchars($data);
  return $data;
}

function test_output($data) {
  $data = htmlspecialchars_decode($data);
  $data = html_entity_decode($data, ENT_QUOTES);
  $data = strip_tags($data);
  return $data;
}





function newSingleUpload($file,$type,$for,$default){

  if (is_uploaded_file($file['tmp_name'])) {

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    switch ($type) {
      case 'image':
      $allowed = array('jpg', 'jpeg', 'png');
      $size = 2097152;
      break;
      case 'document':
      $allowed = array('docx', 'pdf', 'doc');
      $size = 10485760;
      break;
      default:
      $allowed = array('jpg','jpeg','png','docx','pdf','doc');
      $size = 10485760;
      break;
    }

    switch ($for) {
      case 'profile':
      $destination = 'assets/images/profile/';
      break;
      case 'files':
      $destination = 'assets/files/';
      break;
      case 'tours':
         $destination = '../assets/images/tour/';
        break;
      case 'visa':
         $destination = '../assets/images/visas/';
        break;
      case 'school':
        $destination = '../assets/images/schools/';
        break;
      case 'blog':
        $destination = '../assets/images/blog/';
        break;
      case 'avatar':
        $destination = '../assets/images/avatar/';
        break;
      case 'testimony':
        $destination = '../assets/images/testimonials/';
        break;
       case 'images':
        $destination = '../assets/images/';
        break;
      default:
      # code...
      break;
    }

    if (in_array($fileActualExt, $allowed)) {

      if ($fileError === 0) {

        if ($fileSize < $size) {

          $fileNameNew = date('YmdHis', time()).mt_rand().".".$fileActualExt;
          $fileDestination = $destination.$fileNameNew;

          if(move_uploaded_file($fileTmpName, $fileDestination)){

            if($for == 'files') {
               $result = array('name'=>$fileName,'type'=> $fileType, 'path'=> $fileNameNew);
            return $result;
          }else{
            return $fileNameNew;
          }
           
          }else{
            return 5;
          }

        }else{
          return 4;
        }

      }else{
        return 3;
      }
    }else{
     return 2;
   }

 }else{
  return $default;
}

}



function studentLogin(){
 $emailCookieName = encode("studentEmail",'e');
 if (isset($_SESSION['student_login_status']) || isset($_COOKIE[$emailCookieName])) {
   return true;
 }

}


function studentLoginStatus(){

  $emailCookieName = encode("studentEmail",'e');

  if (isset($_SESSION['student_email'])) {
    $email_address = $_SESSION['student_email'];
    return $email_address;

  }elseif (isset($_COOKIE[$emailCookieName])) {

    $decryptIndex = $_COOKIE[$emailCookieName];


    $email_address = detail_secure($decryptIndex, 'd');

    return $email_address;
  }else{
    return false;
  }

}
function staffLoginStatus(){

  if (isset($_SESSION['admin_email'])) {
    $email_address = $_SESSION['admin_email'];
    return $email_address;

  }else{
    return false;
  }

}

function staffLogin(){
  if (isset($_SESSION['admin_login_status'])) {
   return true;
 }

}

function detail_secure( $string, $action = 'e' ) {

  $output = false;

  $encrypt_method = "BF-CBC";
  $token_length = openssl_cipher_iv_length($encrypt_method); 
  $token_encryption_iv = substr(hash('sha256',$token_length),0,8);
  $token_encryption_key = openssl_digest(php_uname(), 'MD5', TRUE);

  if( $action == 'e' ) {
    $output = openssl_encrypt($string, $encrypt_method, $token_encryption_key, 0, $token_encryption_iv);

  }
  else if( $action == 'd' ){
    $output = openssl_decrypt($string, $encrypt_method, $token_encryption_key, 0, $token_encryption_iv);

  }

  return $output;

}
function encode( $string, $action = 'e' ) {

  $secret_key = 'learnmeo_secret_key@pennycodes';
  $secret_iv = 'learnmeo_secret_iv@pennycodes';

  $output = false;
  $encrypt_method = "AES-256-CBC";
  $key = hash( 'sha256', $secret_key );
  $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

  if( $action == 'e' ) {
    $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
  }
  else if( $action == 'd' ){
    $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
  }

  return $output;
}



function studentConfirmLogin(){
  if (!studentLogin()) {
    return false;
  }else{
    return true;
  }
}


function staffConfirmLogin(){
  if (!staffLogin()) {
    return false;
  }else{
    return true;
  }
}




function timeAgo($oldTime, $newTime) {
  $timeCalc = strtotime($newTime) - strtotime($oldTime);
  if ($timeCalc >= (60*60*24*30*12*2)){
    $timeCalc = intval($timeCalc/60/60/24/30/12) . " years ago";
  }else if ($timeCalc >= (60*60*24*30*12)){
    $timeCalc = intval($timeCalc/60/60/24/30/12) . " year ago";
  }else if ($timeCalc >= (60*60*24*30*2)){
    $timeCalc = intval($timeCalc/60/60/24/30) . " months ago";
  }else if ($timeCalc >= (60*60*24*30)){
    $timeCalc = intval($timeCalc/60/60/24/30) . " month ago";
  }else if ($timeCalc >= (60*60*24*2)){
    $timeCalc = intval($timeCalc/60/60/24) . " days ago";
  }else if ($timeCalc >= (60*60*24)){
    $timeCalc = " Yesterday";
  }else if ($timeCalc >= (60*60*2)){
    $timeCalc = intval($timeCalc/60/60) . " hours ago";
  }else if ($timeCalc >= (60*60)){
    $timeCalc = intval($timeCalc/60/60) . " hour ago";
  }else if ($timeCalc >= 60*2){
    $timeCalc = intval($timeCalc/60) . " minutes ago";
  }else if ($timeCalc >= 60){
    $timeCalc = intval($timeCalc/60) . " minute ago";
  }else if ($timeCalc >= 0){
    $timeCalc .= " seconds ago";
  }
  return $timeCalc;
}

function fileSize_formatted($filepath){

  $bytes = filesize($filepath);

  if ($bytes >= 1073741824) {
   return number_format($bytes / 1073741824, 2) . "GB";
 }elseif ($bytes >= 1048576) {
  return number_format($bytes / 1048576, 2) . "MB";  
}elseif ($bytes >= 1024) {
  return number_format($bytes / 1024, 2) . "KB";
}elseif ($bytes > 1) {
  return $bytes . "bytes";
}elseif ($bytes == 1) {
 return " 1 byte";
}else{
  return '0 bytes';
}
}

function multipleUpload($files){
  $file_ary = array();
  $file_count = count($files['name']);
  $file_key = array_keys($files);

  for($i=0; $i<$file_count;$i++){
    foreach ($file_key as $val) {
     $file_ary[$i][$val] = $files[$val][$i];
   }
 }
 return $file_ary;
}

?>
