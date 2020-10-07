<?php
session_name('naamglobal');
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  require_once 'includes/dbcon.php';
  require_once 'includes/functions.php';


  require 'includes/src/Exception.php';
  require 'includes/src/PHPMailer.php';
  require 'includes/src/SMTP.php';

//home subscribe
  if (isset($_POST['email_id'])) {

    $email = test_input($_POST['email_id']);
    $name = test_input($_POST['name_id']);

  if (empty($name)) {
      echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Your name is required',
       position: 'bottomRight'  });</script>";
       exit();
     }

    if (empty($email)) {
      echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Email Address is required',
       position: 'bottomRight'  });</script>";
       exit();
     }

     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Enter valid email address',
        position: 'bottomRight'  });</script>";
        exit();
      }

      if( checkSubscription($email) == true) : 
       echo "<script> iziToast.warning({
        title: 'Notice!',
        message: 'You have already subscribed. Thank you',
        position: 'bottomRight'  });</script>";
        exit();

      endif;

      $sql = "INSERT INTO ng_subscribers (name,email_address,source,date_added) VALUES (?,?,?,?)";
      $stmt = $db->prepare($sql);
      $source = "Homepage";
      $date = date('Y-m-d H:i:s');
      $stmt->bind_param('ssss',$name,$email,$source,$date);
      $stmt->execute();

      if ($stmt->affected_rows == 1) {
        newNotification(test_output($name),"subscribed to our newsletter","name");

        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'You have successfully subscribed. Thank you',
          position: 'bottomRight'  })</script>";
          exit();
        }

      }
//service fetch
      elseif (isset($_POST['service_id'])) {
        $id = $_POST['service_id'];
        $id = encode($id,'d');

        $sql = "SELECT id,name FROM ng_service_category WHERE sid = ? AND enabled = ?";
        $stmt = $db->prepare($sql);
        $enabled = "yes";
        $stmt->bind_param('ss',$id,$enabled);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($sid,$sname);

        $output = " <option value='' disabled selected>Choose category</option>";
        while ($stmt->fetch()) {
          $output.="<option value = '". encode($sid,'e')."'>".htmlspecialchars_decode(html_entity_decode($sname,ENT_QUOTES))."</option>";
        }

        echo $output;

      } 
//servie add
      elseif (isset($_POST['bfname'])) {
        $fname = test_input($_POST['bfname']);
        $oname = test_input($_POST['boname']);
        $email = $_POST['email'];
        $phone = test_input($_POST['phone']);
        $service = test_input($_POST['service']);
        $category = test_input($_POST['category']);
        $notes = test_input($_POST['notes']);


        if (empty($fname)) {
          echo "<script> iziToast.warning({
        title: 'Field Required!',
        message: 'First name cannot be empty',
        position: 'bottomRight'  });</script>";
        exit();
        }
        if (empty($oname)) {
          echo "<script> iziToast.warning({
        title: 'Field Required!',
        message: 'Other name(s) cannot be empty',
        position: 'bottomRight'  });</script>";
        exit();
        }
         if (empty($email)) {
          echo "<script> iziToast.warning({
        title: 'Field Required!',
        message: 'Email Address cannot be empty',
        position: 'bottomRight'  });</script>";
        exit();
        }

     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Enter a valid email address',
        position: 'bottomRight'  });</script>";
        exit();
      }
         if (empty($phone)) {
          echo "<script> iziToast.warning({
        title: 'Field Required!',
        message: 'Phone number cannot be empty',
        position: 'bottomRight'  });</script>";
        exit();
        }

     if (!filter_var($phone, FILTER_SANITIZE_NUMBER_INT)) {
      echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Enter a valid phone number',
        position: 'bottomRight'  });</script>";
        exit();
      }

         if (empty($service)) {
          echo "<script> iziToast.warning({
        title: 'Field Required!',
        message: 'Select a service',
        position: 'bottomRight'  });</script>";
        exit();
        }
         if (empty($category)) {
          echo "<script> iziToast.warning({
        title: 'Field Required!',
        message: 'Select a service category',
        position: 'bottomRight'  });</script>";
        exit();
        }
        $sql = "INSERT INTO ng_bookings (sid,cid,first_name,other_names,email_address,phone_number,notes,date_added) VALUES (?,?,?,?,?,?,?,?)";
         $stmt = $db->prepare($sql);
      $service = encode($service,'d');
      $category = encode($category,'d');
      $date = date('Y-m-d H:i:s');
      $stmt->bind_param('ssssssss',$service,$category,$fname,$oname,$email,$phone,$notes,$date);
      $stmt->execute();
 if ($stmt->affected_rows == 1) {

      $mail = new PHPMailer(true);

      try {
        
   $mail->SMTPDebug = 0;                      
   $mail->isSMTP();                                            
   $mail->Host       = "mail.colorbrace.com";                   
   $mail->SMTPAuth   = true;                                  
   $mail->Username   = 'customer-support@colorbrace.com';                     
   $mail->Password   = 'customersupport@live';                   
   $mail->SMTPSecure = 'ssl';        
   $mail->Port       = 465;

   $mail->setFrom('customer-support@colorbrace.com', 'Naamglobal Services');
   $mail->addAddress(test_output($email), test_output($fname. " ". $oname));    
   $mail->addReplyTo('customer-support@colorbrace.com', 'Naamglobal Services'); 

   $mail->isHTML(true);
   $mail->Subject = 'Booking Receipt';
   $mail->Body    = 'Hello '. test_output($fname). ' , Your service booking has been received. Be sure to keep an eye on your email and phone. We will regularly contact you through this medium for further processing. Thank you';
   $mail->AltBody = 'Hello '. test_output($fname). ' , Your service booking has been received. Be sure to keep an eye on your email and phone. We will regularly contact you through this medium for further processing. Thank you';

  if ($mail->send()) {

newNotification(test_output($fname." ".$oname),"booked a new service", "name");
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Booking request sent successfully. Check your email for a confirmation email. Thank you',
          position: 'bottomRight'  }); $('form.service-form').find('input:not(input[type="."submit"."])').val(''); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
        }
      } catch (Exception $e) {
        
   echo "<script> iziToast.warning({
      title: 'Mail error!',
      message: 'An error occured while sending confirmation email to $email. Quote error information when you contact us. <em>Mailer Error: {$mail->ErrorInfo}</em>',
      position: 'bottomRight'  });</script>";
      }

    
        }else{
          echo "<script> iziToast.warning({
        title: 'Error!',
        message: 'An unknown error occured. contact us to resolve this',
        position: 'bottomRight'  });</script>";
        exit();
        }
      }
      //sign up form
      elseif (isset($_POST['first_name'])) {
        $fname = test_input($_POST['first_name']);
        $oname = test_input($_POST['other_names']);
        $email = test_input($_POST['email_address']);
        $phone = test_input($_POST['phone_number']);
        $type = test_input($_POST['type']);
        $pass = $_POST['password'];
        $cpass = $_POST['cpass'];


        if (empty($fname)) {
          echo "<script> iziToast.warning({
        title: 'Field Required!',
        message: 'First name cannot be empty',
        position: 'bottomRight'  });</script>";
        exit();
        }
        if (empty($oname)) {
          echo "<script> iziToast.warning({
        title: 'Field Required!',
        message: 'Other name(s) cannot be empty',
        position: 'bottomRight'  });</script>";
        exit();
        }

 if (empty($type)) {
          echo "<script> iziToast.warning({
        title: 'Field Required!',
        message: 'Select account type you want to create',
        position: 'bottomRight'  });</script>";
        exit();
        }         if (empty($email)) {
          echo "<script> iziToast.warning({
        title: 'Field Required!',
        message: 'Email Address cannot be empty',
        position: 'bottomRight'  });</script>";
        exit();
        }

     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Enter a valid email address',
        position: 'bottomRight'  });</script>";
        exit();
      }
         if (empty($phone)) {
          echo "<script> iziToast.warning({
        title: 'Field Required!',
        message: 'Phone number cannot be empty',
        position: 'bottomRight'  });</script>";
        exit();
        }

     if (!filter_var($phone, FILTER_SANITIZE_NUMBER_INT)) {
      echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Enter a valid phone number',
        position: 'bottomRight'  });</script>";
        exit();
      }

       if (empty($pass)) {
          echo "<script> iziToast.warning({
        title: 'Field Required!',
        message: 'Password cannot be empty',
        position: 'bottomRight'  });</script>";
        exit();
        }

        if (empty($cpass)) {
          echo "<script> iziToast.warning({
        title: 'Field Required!',
        message: 'Confirm Password cannot be empty',
        position: 'bottomRight'  });</script>";
        exit();
        }

        if ($pass != $cpass) {
            echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Passwords do not match. Check and retry',
        position: 'bottomRight'  });</script>";
        exit();
        }

        if(checkEmail($email) == true) :

           echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Email address already belongs to another account',
        position: 'bottomRight'  });</script>";
        exit();

      endif;

      if (passwordStrength($pass) == true) {
        echo "<script> iziToast.warning({
          title: 'Action Required!',
          message: 'Password should be at least 8 charecters long and should contain at least 1 upper case letter, 1 lower case letter and 1 number ',
          position: 'bottomRight'  });</script>";
          exit();
      }
        $password = passwordEncryption($pass);
        
        $sql = "INSERT INTO ng_students (first_name,other_names,account_type,email_address,phone_number,password,profile_info,parents_info,referral_info,academic_info,program_info,documents_info,date_joined,enabled) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

         $profileArray = array('title'=>'','avatar'=>'','fname' =>'' , 'mname' => '', 'sname' => '', 'dob'=> '', 'place' => '', 'hometown' => '', 'languages' => '', 'religion' => '', 'marital' =>'', 'gender' => '' , 'nationality' =>'', 'phone'=>'', 'email' => '', 'home_phone'=>'' , 'postal' => '', 'residential' => '');

      $profileArray = serialize($profileArray);

      $parentsArray = array('mother' => array('title'=> '', 'fname'=>'', 'mname'=>'', 'sname'=>'','religion'=>'','dob'=>'','place'=>'','hometown'=>'','marital'=>'','nationality'=>'') , 'father'=> array('title'=> '', 'fname'=>'', 'mname'=>'', 'sname'=>'','religion'=>'','dob'=>'','place'=>'','hometown'=>'','marital'=>'','nationality'=>''), 'sponsor' => array('relation'=> '', 'name'=>'', 'nationality'=>'', 'residence'=>'','address'=>'','phone'=>'','email'=>'') );



        $parentsArray = serialize($parentsArray);

        $referralArray  = array('title' =>'' , 'name'=> '' ,'nationality' => '', 'occupation' => '', 'work' => '', 'residence' => '', 'phone' => '', 'email' => '', 'date' => '');

        $referralArray = serialize($referralArray);

         $academicArray = array('jhs' => array('certification' => '', 'institution' => '','qualification' => '', 'from'=>'', 'to'=>'') , 'shs' => array('certification' => '', 'institution' => '','qualification' => '', 'from'=>'', 'to'=>'') , 'tertiary' => array('institution' => $tinst,'qualification' => '', 'from'=>'', 'to'=>'') ,  );

      $academicArray = serialize($academicArray);

      $programArray  = array('program' =>'' , '1st' => array('name' =>'' , '1st_choice' => '', '2nd_choice' => '', '3rd_choice'=> '' ,'status' => ''), '2nd' =>  array('name' =>'' , '1st_choice' => '', '2nd_choice' => '', '3rd_choice'=> '', 'status' => '' ), '3rd' =>  array('name' =>'' , '1st_choice' => '', '2nd_choice' => '', '3rd_choice'=> '', 'status' => '' ));

        $programArray = serialize($programArray);


         $documentsArray = array('passport' => array('name'=>'','type'=> '', 'path'=> '') , 'birthcert' => array('name'=>'','type'=> '', 'path'=> ''), 'wasscecert' => array('name'=>'','type'=> '', 'path'=> ''), 'acacert' => array('name'=>'','type'=> '', 'path'=> ''), 'transcripts' => array('name'=>'','type'=> '', 'path'=> ''), 'ielts'=> array('name'=>'','type'=> '', 'path'=> ''), 'bank' => array('name'=>'','type'=> '', 'path'=> ''), 'reference' => array('name'=>'','type'=> '', 'path'=> ''), 'statement' => array('name'=>'','type'=> '', 'path'=> ''), 'sponsorship' => array('name'=>'','type'=> '', 'path'=> '') );

      $documentsArray = serialize($documentsArray);

        $stmt = $db->prepare($sql);
        $date = date('Y-m-d H:i:s');
        $enabled = 'no';
        $stmt->bind_param('ssssssssssssss',$fname,$oname,$type,$email,$phone,$password,$profileArray,$parentsArray,$referralArray,$academicArray,$programArray,$documentsArray,$date,$enabled);
        $stmt->execute();

        if ($stmt->affected_rows === 1) {
          $mail = new PHPMailer(true);

      try {
        
   $mail->SMTPDebug = 0;                      
   $mail->isSMTP();                                            
   $mail->Host       = "mail.colorbrace.com";                   
   $mail->SMTPAuth   = true;                                  
   $mail->Username   = 'customer-support@colorbrace.com';                     
   $mail->Password   = 'customersupport@live';                   
   $mail->SMTPSecure = 'ssl';        
   $mail->Port       = 465;

   $mail->setFrom('customer-support@colorbrace.com', 'Naamglobal Services');
   $mail->addAddress( test_output($email),  test_output($fname). " ".  test_output($oname));    
   $mail->addReplyTo('customer-support@colorbrace.com', 'Naamglobal Services'); 

   $mail->isHTML(true);
   $mail->Subject = 'Account Created';
   $mail->Body    = '<p>Hello '. test_output($fname). ' , You have successfully created an account with <b>Naam Global Educational Services</b></p>. Please login with your email and password and continue your '.$type.' application process. Thank you <p> <a href="https://www.naamglobal.co.uk/signin" target="_blank">Login here</a>';
   $mail->AltBody = 'Hello '.  test_output($fname). ' , You have successfully created an account with Naam Global Educational Services. Please login with your email and password and continue your application process. Thank you. https://www.naamglobal.co.uk/signin';

  if ($mail->send()) {
newNotification(test_output($fname." ".$oname),"created a new account with us","name");
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Account created successfully. Check your email for a confirmation mail. Thank you',
          position: 'bottomRight'  }); $('form.signup-form').find('input:not(input[type="."submit"."])').val(''); setTimeout(function () {
          location.replace('/signin');}, 2000);</script>";
          exit();
        }
      } catch (Exception $e) {
        
   echo "<script> iziToast.warning({
      title: 'Mail error!',
      message: 'An error occured while sending account creation details to $email. Quote error information when you contact us. <em>Mailer Error: {$mail->ErrorInfo}</em>',
      position: 'bottomRight'  });</script>";
      }
        }else{
            echo "<script> iziToast.warning({
        title: 'Error!',
        message: 'An unknown error occured. contact us to resolve this',
        position: 'bottomRight'  });</script>";
        exit();

        }
      }
      //login
      elseif (isset($_POST['user_email'])) {
       $email = test_input($_POST['user_email']);
       $password = $_POST['user_password'];

        if (empty($email)) {
      echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Email Address is required',
       position: 'bottomRight'  });</script>";
       exit();
     }

     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Enter valid email address',
        position: 'bottomRight'  });</script>";
        exit();
      }
        if (empty($password)) {
      echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Password is required',
       position: 'bottomRight'  });</script>";
       exit();
     }

     $studentExist  = studentEmailLogin($email,$password);


     if ($studentExist) {

        session_regenerate_id();
        $studentToken = bin2hex(openssl_random_pseudo_bytes(24));

        $_SESSION['student_token'] = $studentToken;
        $_SESSION['student_email'] = $studentExist['email_address'];
        $_SESSION['student_login_status'] = true;
        $_SESSION['student_name'] = $studentExist['first_name'] ." ". $studentExist['other_names'] ;

        if (isset($_POST['rememberme']) && (!empty($_POST['rememberme'])) && $_POST['rememberme'] == 'yes' ) {
         $expireTime = time() + 86400;

         $tokenName = $_SESSION['student_token'];
         $studentEmail = $_SESSION['student_email'];

         $token_encryption = detail_secure($tokenName, 'e');
         $email_encryption = detail_secure($studentEmail, 'e');

         $tokenCookieName = encode("studentToken",'e');
         $emailCookieName = encode("studentEmail",'e');
         setcookie($tokenCookieName, $token_encryption, $expireTime, "/");
         setcookie($emailCookieName, $email_encryption, $expireTime, "/");
        }

 echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Login success, redirecting to dashboard',
          position: 'bottomRight' }); $('form.login-form').find('input:not(input[type="."submit"."])').val(''); setTimeout(function () {
          location.replace('/me');}, 2000);</script>";
          exit();


   } else{

     echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Invalid credentials. Check details and retry.',
       position: 'bottomRight'  });</script>";
       exit();
   }

      }

      //profile set
      elseif (isset($_POST['p_fname'])) {
       $status =  studentLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/signin');
          },3000);
          </script>";
          exit();
       }

       $title = test_input($_POST['title']);
       $fname = test_input($_POST['p_fname']);
       $mname  = test_input($_POST['p_mname']);
       $sname  = test_input($_POST['p_sname']);
       $dob  = test_input($_POST['dob']);
       $place  = test_input($_POST['place']);
       $hometown  = test_input($_POST['hometown']);
       $languages  = test_input($_POST['languages']);
       $religion  = test_input($_POST['religion']);
       $marital  = test_input($_POST['marital']);
       $gender  = test_input($_POST['gender']);
       $nationality  = test_input($_POST['nationality']);
       $phone  = test_input($_POST['phone']);
       $email  = test_input($_POST['email']);
       $home_phone  = test_input($_POST['home_phone']);
       $postal  = test_input($_POST['postal']);
       $residential  = test_input($_POST['residential']);
       $default = $_POST['default_image'];

       if (empty($fname) || empty($sname) || empty($dob) || empty($languages) || empty($religion) || empty($marital) || empty($gender) || empty($nationality) || empty($phone) || empty($email) || empty($home_phone) || empty($postal) || empty($residential)) {
          echo "<script> iziToast.warning({
       title: 'Field(s) Required!',
       message: 'One or more required field(s) is empty. Check and resubmit',
       position: 'bottomRight'  });</script>";
       exit();
       }

          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Enter valid email address',
        position: 'bottomRight'  });</script>";
        exit();
      }
        if (!filter_var($phone, FILTER_SANITIZE_NUMBER_INT)) {
      echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Enter a valid phone number',
        position: 'bottomRight'  });</script>";
        exit();
      }
       if (!filter_var($home_phone, FILTER_SANITIZE_NUMBER_INT)) {
      echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Enter a valid home phone number',
        position: 'bottomRight'  });</script>";
        exit();
      }

      $pathResponse = newSingleUpload($_FILES['profile_image'],'image','profile',$default);


          $response = array(1,2,3,4,5);

  if (in_array($pathResponse, $response)) {
    switch ($pathResponse) {
      case 1:
      $c_title = "Image Required";
      $c_message = "Please upload an image for your profile";
      break;
      case 2:
      $c_title = "Unsupoorted File";
      $c_message = "The file uploaded appears not be an image. png, jpg and jpeg files only";
      break;
      case 3:
      $c_title = "File Error";
      $c_message = "An unexpected error occured. Reload page and retry";
      break;
      case 4:
      $c_title = "Large File Size";
      $c_message = "Your file is larger than the maximum of 2MB";
      break;
      case 5:
      $c_title = "Upload Error";
      $c_message = "Could not move file to destination folder. contact support";
      break;
      default:
        # nothing here...
      break;
    }
   echo "<script> iziToast.warning({
      title: '$c_title!',
      message: '$c_message',
      position: 'bottomRight'  });</script>";
      exit(); 
    }

      $profileArray = array('title'=>$title,'avatar'=>$pathResponse,'fname' =>$fname , 'mname' => $mname, 'sname' => $sname, 'dob'=> $dob, 'place' => $place, 'hometown' => $hometown, 'languages' => $languages, 'religion' => $religion, 'marital' =>$marital, 'gender' => $gender , 'nationality' =>$nationality, 'phone'=>$phone, 'email' => $email, 'home_phone'=>$home_phone , 'postal' => $postal, 'residential' => $residential);

      $profileArray = serialize($profileArray);

      $sql = "UPDATE ng_students SET profile_info = ? WHERE email_address = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('ss', $profileArray,$status);
      $stmt->execute();

      if ($stmt->affected_rows === 1) {
       echo "<script> iziToast.success({
          title: 'Success!', 
          message: 'Profile Updated Successfully.Reloading page',
          position: 'bottomRight'  }); $('form.profile-form').find('input:not(input[type="."submit"."])').val(''); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
         echo "<script> iziToast.warning({
        title: 'Warning!',
        message: 'No updates detected hence no changes were made to existing information. Contact us if you think this is an error.',
        position: 'bottomRight'  });</script>";
        exit();
      }
      }
//academic form
      elseif (isset($_POST['jcertification'])) {
        $status =  studentLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/signin');
          },3000);
          </script>";
          exit();
       }

        $jcert = test_input($_POST['jcertification']);
        $jinst = test_input($_POST['jinstitution']);
        $jqual = test_input($_POST['jqualification']);
        $jfrom = test_input($_POST['jfromyear']);
        $jto = test_input($_POST['jtoyear']);
         $scert = test_input($_POST['scertification']);
        $sinst = test_input($_POST['sinstitution']);
        $squal = test_input($_POST['squalification']);
        $sfrom = test_input($_POST['sfromyear']);
        $sto = test_input($_POST['stoyear']);
        $tinst = test_input($_POST['tinstitution']);
        $tqual = test_input($_POST['tqualification']);
        $tfrom = test_input($_POST['tfromyear']);
        $tto = test_input($_POST['ttoyear']);

          if (empty($jcert) || empty($jinst) || empty($jqual) || empty($jfrom) || empty($jto) || empty($scert) || empty($sinst) || empty($squal) || empty($sfrom) || empty($sto)) {
          echo "<script> iziToast.warning({
       title: 'Field(s) Required!',
       message: 'One or more required field(s) is empty. Check and resubmit',
       position: 'bottomRight'  });</script>";
       exit();
       }


          if (!is_numeric($jto) || !is_numeric($jfrom) || !is_numeric($sto)  || !is_numeric($sfrom)) {
      echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Qualification from and to  must be a valid year and in digit format',
        position: 'bottomRight'  });</script>";
        exit();
      }

      $academicArray = array('jhs' => array('certification' => $jcert, 'institution' => $jinst,'qualification' => $jqual, 'from'=>$jfrom, 'to'=>$jto) , 'shs' => array('certification' => $scert, 'institution' => $sinst,'qualification' => $squal, 'from'=>$sfrom, 'to'=>$sto) , 'tertiary' => array('institution' => $tinst,'qualification' => $tqual, 'from'=>$tfrom, 'to'=>$tto) ,  );

      $academicArray = serialize($academicArray);

       $sql = "UPDATE ng_students SET academic_info = ? WHERE email_address = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('ss', $academicArray,$status);
      $stmt->execute();

      if ($stmt->affected_rows === 1) {
       echo "<script> iziToast.success({
          title: 'Success!', 
          message: 'Academic Info Updated Successfully.Reloading page',
          position: 'bottomRight'  }); $('form.academic-form').find('input:not(input[type="."submit"."])').val(''); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
         echo "<script> iziToast.warning({
        title: 'Warning!',
        message: 'No updates detected hence no changes were made to existing information. Contact us if you think this is an error.',
        position: 'bottomRight'  });</script>";
        exit();
      }
    }
    //program form

    elseif (isset($_POST['pos'])) {
       $status =  studentLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/signin');
          },3000);
          </script>";
          exit();
       }
     $pos = test_input($_POST['pos']);
      $_1st_school = test_input($_POST['1st_school']);
      $_1st_choice_1st = test_input($_POST['1st_choice_1st']);
      $_1st_choice_2nd = test_input($_POST['1st_choice_2nd']);
      $_1st_choice_3rd = test_input($_POST['1st_choice_3rd']);
      @$_2nd_school = test_input($_POST['2nd_school']);
      @$_2nd_choice_1st = test_input($_POST['2nd_choice_1st']);
      @$_2nd_choice_2nd = test_input($_POST['2nd_choice_2nd']);
      @$_2nd_choice_3rd = test_input($_POST['2nd_choice_3rd']);
      @$_3rd_school = test_input($_POST['3rd_school']);
      @$_3rd_choice_1st = test_input($_POST['3rd_choice_1st']);
      @$_3rd_choice_2nd = test_input($_POST['3rd_choice_2nd']);
      @$_3rd_choice_3rd = test_input($_POST['3rd_choice_3rd']);

         if (empty($_1st_school) || empty($_1st_choice_1st) || empty($_1st_choice_2nd) || empty($_1st_choice_3rd)) {
          echo "<script> iziToast.warning({
       title: 'Field(s) Required!',
       message: 'One or more required field(s) in first school is empty. Check and resubmit',
       position: 'bottomRight'  });</script>";
       exit();
       }


       $_1st_school = encode($_1st_school,'d');

     
       if (!empty($_2nd_school)) {
          
        if ($_2nd_school == 'nonefor2nd') {
          
         $_2nd_choice_1st = '';
         $_2nd_choice_2nd = '';
         $_2nd_choice_3rd = '';
       }else{
        if (empty($_2nd_choice_1st) || empty($_2nd_choice_2nd) || empty($_2nd_choice_3rd)) {
          echo "<script> iziToast.warning({
       title: 'Field(s) Required!',
       message: 'One or more required field(s) in second school choices is empty. Check and resubmit',
       position: 'bottomRight'  });</script>";
       exit();
       }
        $_2nd_school = encode($_2nd_school,'d');
      }

     }

       if (!empty($_3rd_school)) {
          
          if ($_3rd_school == 'nonefor3rd') {
           
         $_3rd_choice_1st = '';
         $_3rd_choice_2nd = '';
         $_3rd_choice_3rd = '';
       }
else{
  if (empty($_3rd_choice_1st) || empty($_3rd_choice_2nd) || empty($_3rd_choice_3rd)) {
          echo "<script> iziToast.warning({
       title: 'Field(s) Required!',
       message: 'One or more required field(s) in third school choices is empty. Check and resubmit',
       position: 'bottomRight'  });</script>";
       exit();
       }

      $_3rd_school = encode($_3rd_school,'d');
    }
       }


     

       $schools = array($_1st_school,$_2nd_school,$_3rd_school);

       if(count(array_unique($schools))<count($schools)){
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'You can only select one unique school from each list. check and retry',
       position: 'bottomRight'  });</script>";
       exit();

       }

       if ($_3rd_school == 'nonefor3rd') {
            $_3rd_school = '';
          }
          if ($_2nd_school == 'nonefor2nd') {
          $_2nd_school = '';
        }

        $programArray  = array('program' =>$pos , '1st' => array('name' =>$_1st_school , '1st_choice' => $_1st_choice_1st, '2nd_choice' => $_1st_choice_2nd, '3rd_choice'=> $_1st_choice_3rd ,'status' => ''), '2nd' =>  array('name' =>$_2nd_school , '1st_choice' => $_2nd_choice_1st, '2nd_choice' => $_2nd_choice_2nd, '3rd_choice'=> $_2nd_choice_3rd, 'status' => '' ), '3rd' =>  array('name' =>$_3rd_school , '1st_choice' => $_3rd_choice_1st, '2nd_choice' => $_3rd_choice_2nd, '3rd_choice'=> $_3rd_choice_3rd, 'status' => '' ));

        $programArray = serialize($programArray);

       $sql = "UPDATE ng_students SET program_info = ? WHERE email_address = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('ss', $programArray,$status);
      $stmt->execute();

      if ($stmt->affected_rows === 1) {
       echo "<script> iziToast.success({
          title: 'Success!', 
          message: 'Program Info Updated Successfully.Reloading page',
          position: 'bottomRight'  }); $('form.program-form').find('input:not(input[type="."submit"."])').val(''); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
         echo "<script> iziToast.warning({
        title: 'Warning!',
        message: 'No updates detected hence no changes were made to existing information. Contact us if you think this is an error.',
        position: 'bottomRight'  });</script>";
        exit();
      }

  }
  //parents form
  elseif (isset($_POST['m_title'])) {

    $status =  studentLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/signin');
          },3000);
          </script>";
          exit();
       }

    $m_title  = test_input($_POST['m_title']);
    $m_religion = test_input($_POST['m_religion']);
    $m_fname = test_input($_POST['m_fname']);
    $m_mname = test_input($_POST['m_mname']);
    $m_sname = test_input($_POST['m_sname']);
    $m_dob = test_input($_POST['m_dob']);
    $m_place = test_input($_POST['m_place']);
    $m_hometown = test_input($_POST['m_hometown']);
    $m_marital = test_input($_POST['m_marital']);
    $m_nationality = test_input($_POST['m_nationality']);

    $f_title  = test_input($_POST['f_title']);
    $f_religion = test_input($_POST['f_religion']);
    $f_fname = test_input($_POST['f_fname']);
    $f_mname = test_input($_POST['f_mname']);
    $f_sname = test_input($_POST['f_sname']);
    $f_dob = test_input($_POST['f_dob']);
    $f_place = test_input($_POST['f_place']);
    $f_hometown = test_input($_POST['f_hometown']);
    $f_marital = test_input($_POST['f_marital']);
    $f_nationality = test_input($_POST['f_nationality']);

    $relation  = test_input($_POST['relationship']);
    $sp_name = test_input($_POST['sp_name']);
    $s_nationality = test_input($_POST['s_nationality']);
    $s_residence = test_input($_POST['s_residence']);
    $s_address = test_input($_POST['s_address']);
    $s_phone = test_input($_POST['s_phone']);
    $s_email = test_input($_POST['s_email']);

 if (empty($m_title) || empty($m_religion) || empty($m_fname) || empty($m_sname) || empty($m_dob) || empty($m_place) || empty($m_hometown) || empty($m_marital) || empty($m_nationality)) {
          echo "<script> iziToast.warning({
       title: 'Field(s) Required!',
       message: 'One or more required field(s) is empty in Mothers details. Check and resubmit',
       position: 'bottomRight'  });</script>";
       exit();
       }

       if (empty($f_title) || empty($f_religion) || empty($f_fname) || empty($f_sname) || empty($f_dob) || empty($f_place) || empty($f_hometown) || empty($f_marital) || empty($f_nationality)) {
          echo "<script> iziToast.warning({
       title: 'Field(s) Required!',
       message: 'One or more required field(s) is empty in Fathers details. Check and resubmit',
       position: 'bottomRight'  });</script>";
       exit();
       }

         if (empty($relation) || empty($sp_name) || empty($s_nationality) || empty($s_residence) || empty($s_address) || empty($s_phone) || empty($s_email)) {
          echo "<script> iziToast.warning({
       title: 'Field(s) Required!',
       message: 'One or more required field(s) is empty in Sponsor details. Check and resubmit',
       position: 'bottomRight'  });</script>";
       exit();
       }

    $parentsArray = array('mother' => array('title'=> $m_title, 'fname'=>$m_fname, 'mname'=>$m_mname, 'sname'=>$m_sname,'religion'=>$m_religion,'dob'=>$m_dob,'place'=>$m_place,'hometown'=>$m_hometown,'marital'=>$m_marital,'nationality'=>$m_nationality) , 'father'=> array('title'=> $f_title, 'fname'=>$f_fname, 'mname'=>$f_mname, 'sname'=>$f_sname,'religion'=>$f_religion,'dob'=>$f_dob,'place'=>$f_place,'hometown'=>$f_hometown,'marital'=>$f_marital,'nationality'=>$f_nationality), 'sponsor' => array('relation'=> $relation, 'name'=>$sp_name, 'nationality'=>$s_nationality, 'residence'=>$s_residence,'address'=>$s_address,'phone'=>$s_phone,'email'=>$s_email) );



        $parentsArray = serialize($parentsArray);

       $sql = "UPDATE ng_students SET parents_info = ? WHERE email_address = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('ss', $parentsArray,$status);
      $stmt->execute();

      if ($stmt->affected_rows === 1) {
       echo "<script> iziToast.success({
          title: 'Success!', 
          message: 'Parents and Sponsor Info Updated Successfully.Reloading page',
          position: 'bottomRight'  }); $('form.parents-form').find('input:not(input[type="."submit"."])').val(''); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
         echo "<script> iziToast.warning({
        title: 'Warning!',
        message: 'No updates detected hence no changes were made to existing information. Contact us if you think this is an error.',
        position: 'bottomRight'  });</script>";
        exit();
      }

  }
  //

  elseif (isset($_POST['r_title'])) {

    $status =  studentLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/signin');
          },3000);
          </script>";
          exit();
       }

    $r_title = test_input($_POST['r_title']);
    $r_name = test_input($_POST['r_name']);
    $r_nationality = test_input($_POST['r_nationality']);
    $r_occupation = test_input($_POST['r_occupation']);
    $r_work = test_input($_POST['r_work']);
    $r_residence = test_input($_POST['r_residence']);
    $r_phone = test_input($_POST['r_phone']);
    $r_email = test_input($_POST['r_email']);
    $r_date = test_input($_POST['r_date']);


      if (empty($r_title) || empty($r_name) || empty($r_nationality) || empty($r_occupation) || empty($r_work) || empty($r_residence) || empty($r_phone) || empty($r_email) || empty($r_date)) {
          echo "<script> iziToast.warning({
       title: 'Field(s) Required!',
       message: 'One or more required field(s) is empty in Referral details. Check and resubmit',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $referralArray  = array('title' =>$r_title , 'name'=> $r_name ,'nationality' => $r_nationality, 'occupation' => $r_occupation, 'work' => $r_work, 'residence' => $r_residence, 'phone' => $r_phone, 'email' => $r_email, 'date' => $r_date);

        $referralArray = serialize($referralArray);

       $sql = "UPDATE ng_students SET referral_info = ? WHERE email_address = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('ss', $referralArray,$status);
      $stmt->execute();

      if ($stmt->affected_rows === 1) {
       echo "<script> iziToast.success({
          title: 'Success!', 
          message: 'Referral Info Updated Successfully.Reloading page',
          position: 'bottomRight'  }); $('form.parents-form').find('input:not(input[type="."submit"."])').val(''); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
         echo "<script> iziToast.warning({
        title: 'Warning!',
        message: 'No updates detected hence no changes were made to existing information. Contact us if you think this is an error.',
        position: 'bottomRight'  });</script>";
        exit();
      }
  }
  // documents upload
  elseif (isset($_POST['docsupload'])) {
    $status =  studentLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/signin');
          },3000);
          </script>";
          exit();
       }

        $response = array(1,2,3,4,5);

       $passport_default = json_decode(base64_decode($_POST['passport_default']),true);

       $passport = newSingleUpload($_FILES['passport'],'','files',$passport_default);

       if (in_array($passport, $response)) {
    switch ($passport) {
      case 2:
      $c_title = "Unsupoorted File";
      $c_message = "The passport file uploaded appears not be an image or document file.";
      break;
      case 3:
      $c_title = "File Error";
      $c_message = "An unexpected error occured while uploading the passport file. Reload page and retry";
      break;
      case 4:
      $c_title = "Large File Size";
      $c_message = "The passport file is larger than the maximum of 10MB";
      break;
      case 5:
      $c_title = "Upload Error";
      $c_message = "Could not move passport file to destination folder. contact support";
      break;
      default:
        # nothing here...
      break;
    }
   echo "<script> iziToast.warning({
      title: '$c_title!',
      message: '$c_message',
      position: 'bottomRight'  });</script>";
      exit(); 
    }
//     $passport_type = getFileType($_FILES['passport']);
//     $passport_name = getFileName($_FILES['passport']);

// $passport_array = array('name'=> $passport_name ,'type' => $passport_type ,'path' => $passport);



       $birthcert_default = json_decode(base64_decode($_POST['birthcert_default']),true);
       $birth_cert = newSingleUpload($_FILES['birth_cert'],'','files',$birthcert_default);

       if (in_array($birth_cert, $response)) {
    switch ($birth_cert) {
      case 2:
      $c_title = "Unsupoorted File";
      $c_message = "The birth certificate file uploaded appears not be an image or document file.";
      break;
      case 3:
      $c_title = "File Error";
      $c_message = "An unexpected error occured while uploading birth certificate. Reload page and retry";
      break;
      case 4:
      $c_title = "Large File Size";
      $c_message = "birth certificate file is larger than the maximum of 10MB";
      break;
      case 5:
      $c_title = "Upload Error";
      $c_message = "Could not move birth certificate file to destination folder. contact support";
      break;
      default:
        # nothing here...
      break;
    }
   echo "<script> iziToast.warning({
      title: '$c_title!',
      message: '$c_message',
      position: 'bottomRight'  });</script>";
      exit(); 
    }

    // $birthcert_type = getFileType($_FILES['birth_cert']);
    // $birthcert_name = getFileName($_FILES['birth_cert']);
    // $birthcert_array = array( 'name'=> $birthcert_name ,'type' => $birthcert_type ,'path' => $birth_cert);


       $wasscecert_default = json_decode(base64_decode($_POST['wasscecert_default']),true);
       $wassce_cert = newSingleUpload($_FILES['wassce_cert'],'','files',$wasscecert_default);

         if (in_array($wassce_cert, $response)) {
    switch ($wassce_cert) {
      case 2:
      $c_title = "Unsupoorted File";
      $c_message = "The Wassce Certificate file uploaded appears not be an image or document file.";
      break;
      case 3:
      $c_title = "File Error";
      $c_message = "An unexpected error occured while uploading Wassce Certificate. Reload page and retry";
      break;
      case 4:
      $c_title = "Large File Size";
      $c_message = "Wassce Certificate file is larger than the maximum of 10MB";
      break;
      case 5:
      $c_title = "Upload Error";
      $c_message = "Could not move Wassce certificate file to destination folder. contact support";
      break;
      default:
        # nothing here...
      break;
    }
   echo "<script> iziToast.warning({
      title: '$c_title!',
      message: '$c_message',
      position: 'bottomRight'  });</script>";
      exit(); 
    }

    // $wasscecert_type = getFileType($_FILES['wassce_cert']);
    // $wasscecert_name = getFileName($_FILES['wassce_cert']);
    // $wasscecert_array = array( 'name'=> $wasscecert_name ,'type' => $wasscecert_type ,'path' => $wassce_cert);

       $acacert_default = json_decode(base64_decode($_POST['acacert_default']),true);
       $aca_cert = newSingleUpload($_FILES['aca_cert'],'','files',$acacert_default);

 if (in_array($aca_cert, $response)) {
    switch ($aca_cert) {
      case 2:
      $c_title = "Unsupoorted File";
      $c_message = "The Academic Certificate file uploaded appears not be an image or document file.";
      break;
      case 3:
      $c_title = "File Error";
      $c_message = "An unexpected error occured while uploading Academic Certificate. Reload page and retry";
      break;
      case 4:
      $c_title = "Large File Size";
      $c_message = "Academic Certificate file is larger than the maximum of 10MB";
      break;
      case 5:
      $c_title = "Upload Error";
      $c_message = "Could not move Academic Certificate file to destination folder. contact support";
      break;
      default:
        # nothing here...
      break;
    }
   echo "<script> iziToast.warning({
      title: '$c_title!',
      message: '$c_message',
      position: 'bottomRight'  });</script>";
      exit(); 
    }

    // $acacert_type = getFileType($_FILES['aca_cert']);
    // $acacert_name = getFileName($_FILES['aca_cert']);
    // $acacert_array = array( 'name'=> $acacert_name ,'type' => $acacert_type ,'path' => $aca_cert);


       $transcripts_default = json_decode(base64_decode($_POST['transcripts_default']),true);
       $transcripts = newSingleUpload($_FILES['transcripts'],'document','files',$transcripts_default);

        if (in_array($transcripts, $response)) {
    switch ($transcripts) {
      case 2:
      $c_title = "Unsupoorted File";
      $c_message = "The Academic Transcripts file uploaded appears not be a document file. (pdf,docx and doc) only";
      break;
      case 3:
      $c_title = "File Error";
      $c_message = "An unexpected error occured while uploading Academic Transcripts. Reload page and retry";
      break;
      case 4:
      $c_title = "Large File Size";
      $c_message = "Academic Transcripts file is larger than the maximum of 10MB";
      break;
      case 5:
      $c_title = "Upload Error";
      $c_message = "Could not move Academic transcripts file to destination folder. contact support";
      break;
      default:
        # nothing here...
      break;
    }
   echo "<script> iziToast.warning({
      title: '$c_title!',
      message: '$c_message',
      position: 'bottomRight'  });</script>";
      exit(); 
    }

    // $transcripts_type = getFileType($_FILES['transcripts']);
    // $transcripts_name = getFileName($_FILES['transcripts']);
    // $transcripts_array = array( 'name'=> $transcripts_name ,'type' => $transcripts_type ,'path' => $transcripts);

       $ielts_default = json_decode(base64_decode($_POST['ielts_default']),true);
       $ielts = newSingleUpload($_FILES['ielts'],'document','files',$ielts_default);

        if (in_array($ielts, $response)) {
    switch ($ielts) {
      case 2:
      $c_title = "Unsupoorted File";
      $c_message = "The IELTS Results file uploaded appears not be a document file. (pdf,docx and doc) only";
      break;
      case 3:
      $c_title = "File Error";
      $c_message = "An unexpected error occured while uploading  IELTS Results. Reload page and retry";
      break;
      case 4:
      $c_title = "Large File Size";
      $c_message = " IELTS Results file is larger than the maximum of 10MB";
      break;
      case 5:
      $c_title = "Upload Error";
      $c_message = "Could not move  IELTS Results file to destination folder. contact support";
      break;
      default:
        # nothing here...
      break;
    }
   echo "<script> iziToast.warning({
      title: '$c_title!',
      message: '$c_message',
      position: 'bottomRight'  });</script>";
      exit(); 
    }

    // $ielts_type = getFileType($_FILES['ielts']);
    // $ielts_name = getFileName($_FILES['ielts']);
    // $ielts_array = array( 'name'=> $ielts_name ,'type' => $ielts_type ,'path' => $ielts);

       $bank_default = json_decode(base64_decode($_POST['bank_default']),true);
       $bank = newSingleUpload($_FILES['bank'],'document','files',$bank_default);

        if (in_array($bank, $response)) {
    switch ($bank) {
      case 2:
      $c_title = "Unsupoorted File";
      $c_message = "The Bank Statement file uploaded appears not be a document file. (pdf,docx and doc) only";
      break;
      case 3:
      $c_title = "File Error";
      $c_message = "An unexpected error occured while uploading Bank Statement. Reload page and retry";
      break;
      case 4:
      $c_title = "Large File Size";
      $c_message = "Bank Statement file is larger than the maximum of 10MB";
      break;
      case 5:
      $c_title = "Upload Error";
      $c_message = "Could not move Bank Statement file to destination folder. contact support";
      break;
      default:
        # nothing here...
      break;
    }
   echo "<script> iziToast.warning({
      title: '$c_title!',
      message: '$c_message',
      position: 'bottomRight'  });</script>";
      exit(); 
    }

    // $bank_type = getFileType($_FILES['bank']);
    // $bank_name = getFileName($_FILES['bank']);
    // $bank_array = array( 'name'=> $bank_name ,'type' => $bank_type ,'path' => $bank);

       $reference_default = json_decode(base64_decode($_POST['reference_default']),true);
       $reference = newSingleUpload($_FILES['reference'],'document','files',$reference_default);

        if (in_array($reference, $response)) {
    switch ($reference) {
      case 2:
      $c_title = "Unsupoorted File";
      $c_message = "The Academic Reference file uploaded appears not be a document file. (pdf,docx and doc) only";
      break;
      case 3:
      $c_title = "File Error";
      $c_message = "An unexpected error occured while uploading  Academic Reference. Reload page and retry";
      break;
      case 4:
      $c_title = "Large File Size";
      $c_message = " Academic Reference file is larger than the maximum of 10MB";
      break;
      case 5:
      $c_title = "Upload Error";
      $c_message = "Could not move  Academic Reference file to destination folder. contact support";
      break;
      default:
        # nothing here...
      break;
    }
   echo "<script> iziToast.warning({
      title: '$c_title!',
      message: '$c_message',
      position: 'bottomRight'  });</script>";
      exit(); 
    }

    // $reference_type = getFileType($_FILES['reference']);
    // $reference_name = getFileName($_FILES['reference']);
    // $reference_array = array( 'name'=> $reference_name ,'type' => $reference_type ,'path' => $reference);

       $statement_default = json_decode(base64_decode($_POST['statement_default']),true);
       $statement = newSingleUpload($_FILES['statement'],'document','files',$statement_default);

        if (in_array($transcripts, $response)) {
    switch ($transcripts) {
      case 2:
      $c_title = "Unsupoorted File";
      $c_message = "The personal statement file uploaded appears not be a document file. (pdf,docx and doc) only";
      break;
      case 3:
      $c_title = "File Error";
      $c_message = "An unexpected error occured while uploading personal statement. Reload page and retry";
      break;
      case 4:
      $c_title = "Large File Size";
      $c_message = "personal statement file is larger than the maximum of 10MB";
      break;
      case 5:
      $c_title = "Upload Error";
      $c_message = "Could not move personal statement file to destination folder. contact support";
      break;
      default:
        # nothing here...
      break;
    }
   echo "<script> iziToast.warning({
      title: '$c_title!',
      message: '$c_message',
      position: 'bottomRight'  });</script>";
      exit(); 
    }

    // $statement_type = getFileType($_FILES['statement']);
    // $statement_name = getFileName($_FILES['statement']);
    // $statement_array = array( 'name'=> $statement_name ,'type' => $statement_type ,'path' => $statement);

       $sponsorship_default = json_decode(base64_decode($_POST['sponsorship_default']),true);
       $sponsorship = newSingleUpload($_FILES['sponsorship'],'document','files',$sponsorship_default);

        if (in_array($transcripts, $response)) {
    switch ($transcripts) {
      case 2:
      $c_title = "Unsupoorted File";
      $c_message = "The Sponsorship Letter file uploaded appears not be a document file. (pdf,docx and doc) only";
      break;
      case 3:
      $c_title = "File Error";
      $c_message = "An unexpected error occured while uploading Sponsorship Letter. Reload page and retry";
      break;
      case 4:
      $c_title = "Large File Size";
      $c_message = "Sponsorship Letter file is larger than the maximum of 10MB";
      break;
      case 5:
      $c_title = "Upload Error";
      $c_message = "Could not move Sponsorship Letter file to destination folder. contact support";
      break;
      default:
        # nothing here...
      break;
    }
   echo "<script> iziToast.warning({
      title: '$c_title!',
      message: '$c_message',
      position: 'bottomRight'  });</script>";
      exit(); 
    }

    // $sponsorship_type = getFileType($_FILES['sponsorship']);
    // $sponsorship_name = getFileName($_FILES['sponsorship']);
    // $sponsorship_array = array( 'name'=> $sponsorship_name ,'type' => $sponsorship_type ,'path' => $sponsorship);

     
     $documentsArray = array('passport' => $passport , 'birthcert' => $birth_cert, 'wasscecert' => $wassce_cert, 'acacert' => $aca_cert, 'transcripts' => $transcripts, 'ielts'=> $ielts, 'bank' => $bank, 'reference' => $reference, 'statement' => $statement, 'sponsorship' => $sponsorship );

      $documentsArray = serialize($documentsArray);

       $sql = "UPDATE ng_students SET documents_info = ? WHERE email_address = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('ss', $documentsArray,$status);
      $stmt->execute();

      if ($stmt->affected_rows === 1) {
       echo "<script> iziToast.success({
          title: 'Success!', 
          message: 'Documents Updated Successfully.Reloading page',
          position: 'bottomRight'  }); $('form.documents-form').find('input:not(input[type="."submit"."])').val(''); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
         echo "<script> iziToast.warning({
        title: 'Warning!',
        message: 'No updates detected hence no changes were made to existing information. Contact us if you think this is an error.',
        position: 'bottomRight'  });</script>";
        exit();
      }

  

  }

  //delete document

  elseif (isset($_POST['deleteid'])) {
     $status =  studentLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/signin');
          },3000);
          </script>";
          exit();
       }

       $delid = $_POST['deleteid'];

       $delid = encode($delid,'d');

       $sql = "SELECT documents_info FROM ng_students WHERE email_address = ?";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('s',$status);
       $stmt->execute();
       $stmt->store_result();
       $stmt->bind_result($docsArray);
       $stmt->fetch();

       $docsArray = unserialize($docsArray);
      
        unset($docsArray[$delid]);

             $neDocsArray = serialize($docsArray);

       $iql = "UPDATE ng_students SET documents_info = ? WHERE email_address = ?";
      $itmt = $db->prepare($iql);
      $itmt->bind_param('ss', $neDocsArray,$status);
      $itmt->execute();

      if ($itmt->affected_rows === 1) {
       echo "<script> iziToast.success({
          title: 'Success!', 
          message: '$delid removed Successfully.Reloading page',
          position: 'bottomRight'  });setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
         echo "<script> iziToast.warning({
        title: 'Warning!',
        message: 'No updates detected hence no changes were made to existing information. Contact us if you think this is an error.',
        position: 'bottomRight'  });</script>";
        exit();
      }
  }
  //

  elseif (isset($_POST['finished'])) {
    
        $status =  studentLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/signin');
          },3000);
          </script>";
          exit();
       }

       $finished = $_POST['finished'];

       if ($finished != 'finished') {
            echo "<script> iziToast.warning({
        title: 'Error!',
        message: 'An error occured. That is own we know. Reload page and retry',
        position: 'bottomRight'  });</script>";
        exit();
       }
       if (isset($_POST['agree'])) {
         $agree = $_POST['agree'];

         if (empty($agree) || $agree != 'yes') {
            echo "<script> iziToast.warning({
        title: 'Error!',
        message: 'An error occured. That is own we know. Reload page and retry',
        position: 'bottomRight'  });</script>";
        exit();
         }
       }else{
         echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'You need to agree to our terms and conditions',
        position: 'bottomRight'  });</script>";
        exit();
       }


       $sql = "UPDATE ng_students SET submitted = ?, submitted_on = ? WHERE email_address = ?";
       $stmt = $db->prepare($sql);
       $submitted = 'yes';
       $submitted_on = date('Y-m-d H:i:s');
       $stmt->bind_param('sss', $submitted,$submitted_on,$status);
       $stmt->execute();

       if ($stmt->affected_rows === 1) {
       echo "<script> iziToast.success({
          title: 'Success!', 
          message: 'Your application has been submitted. You can track progress on your dashboard.Thank you',
          position: 'bottomRight'  });setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
         echo "<script> iziToast.warning({
        title: 'Warning!',
        message: 'No updates detected hence no changes were made to existing information. Contact us if you think this is an error.',
        position: 'bottomRight'  });</script>";
        exit();
      }
  }

  //contact form

  elseif (isset($_POST['c_name'])) {
   $name = test_input($_POST['c_name']);
   $phone = test_input($_POST['c_phone']);
   $email = test_input($_POST['c_email']);
   $message = test_input($_POST['c_message']);

 if (empty($name)) {
      echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Your name is required',
       position: 'bottomRight'  });</script>";
       exit();
     }


   if (empty($email)) {
      echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Email Address is required',
       position: 'bottomRight'  });</script>";
       exit();
     }

     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Enter valid email address',
        position: 'bottomRight'  });</script>";
        exit();
      }

      if (empty($message)) {
      echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Your messgae is required',
       position: 'bottomRight'  });</script>";
       exit();
     }
      if (!empty($phone)) {
         if (!filter_var($phone, FILTER_SANITIZE_NUMBER_INT)) {
      echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Enter a valid phone number',
        position: 'bottomRight'  });</script>";
        exit();
      }
    
  }

    $sql = "INSERT INTO ng_contact (name,phone,email,message,date_sent) VALUES (?,?,?,?,?)";
      $stmt = $db->prepare($sql);
      $date = date('Y-m-d H:i:s');
      $stmt->bind_param('sssss',$name,$phone,$email,$message,$date);
      $stmt->execute();

      if ($stmt->affected_rows == 1) {
newNotification(test_output($name),"sent a message through the contact form","name");
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Your message has been sent successfully. We will get in touch soon. Thank you',
          position: 'bottomRight'  }); $('form.contact-form').find('input:not(input[type="."submit"."])').val(''); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
        }else{
           echo "<script> iziToast.warning({
          title: 'Error!',
          message: 'An error occured. Reach us by phone to resolve this issue',
          position: 'bottomRight'  })</script>";
          exit();
        }
}
  // tour form
elseif (isset($_POST['tour_des'])) {
        
         $status =  studentLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/signin');
          },3000);
          </script>";
          exit();
       }
       $id = $_POST['tid'];
       $id = encode($id,'d');
       if (empty($id)) {
          echo "<script> iziToast.warning({
       title: 'unknown error!',
       message: 'An error occured, reload page and retry',
       position: 'bottomRight'  });</script>";
       exit();
       }

        $destination = $_POST['tour_des'];
        $expected_start = test_input($_POST['tour_date']);
        $accomodation = $_POST['accomodation'];
        $notes = test_input($_POST['add_notes']);
        $duration = test_input($_POST['duration']);
       

        if (empty($destination)) {
      echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Select a tour destination',
       position: 'bottomRight'  });</script>";
       exit();
     }
     $destination = encode($destination,'d');
     if (empty($expected_start)) {
      echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Specify expected date of beginning your tour',
       position: 'bottomRight'  });</script>";
       exit();
     }

     if (empty($duration)) {
      echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Specify duration of your tour in number of days',
       position: 'bottomRight'  });</script>";
       exit();
     }

     if (!is_numeric($duration)) {
        echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Enter a valid number for duration',
       position: 'bottomRight'  });</script>";
       exit();
     }

      if (empty($accomodation)) {
      echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Specify wether to provide accomodation or not',
       position: 'bottomRight'  });</script>";
       exit();
     }

     if ($accomodation == 'yes') {
      $rooms = $_POST['rooms'];
      $adults = $_POST['adults'];
      $children = $_POST['children'];

        if (empty($rooms)) {
           echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Specify number of rooms',
       position: 'bottomRight'  });</script>";
       exit();
           
         } 
         if (!is_numeric($rooms)) {
        echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Enter a valid number for rooms',
       position: 'bottomRight'  });</script>";
       exit();
     }

           if ($children == '') {
           echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Specify number of children',
       position: 'bottomRight'  });</script>";
       exit();
           
         }

         if (!is_numeric($children)) {
        echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Enter a valid number for children',
       position: 'bottomRight'  });</script>";
       exit();
     }

           if ($adults == '') {
           echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Specify number of adults',
       position: 'bottomRight'  });</script>";
       exit();
           
         }
         if (!is_numeric($adults)) {
        echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Enter a valid number for adults',
       position: 'bottomRight'  });</script>";
       exit();
     }


        if (empty($adults) && empty($children)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Specify at least one child or adult',
       position: 'bottomRight'  });</script>";
       exit();
           
         }  
         
     }else{
       $rooms =  $adults = $children = '';
     }

$tourArray = array("destination" => $destination, "expected_start" => $expected_start, "accomodation" => array("supported"=> $accomodation, "rooms" => $rooms, "children"=>$children, "adults"=>$adults), "notes"=>$notes, "duration"=>$duration );

$tourArray = serialize($tourArray);

    $sql = "INSERT INTO ng_tour_bookings (sid,tour_details,last_updated) VALUES(?,?,?)";
      $stmt = $db->prepare($sql);
      $date = date('Y-m-d H:i:s');
      $stmt->bind_param('iss', $id,$tourArray,$date);
      $stmt->execute();

      if ($stmt->affected_rows === 1) {
        newNotification($id,"created a new account with us","id");
       echo "<script> iziToast.success({
          title: 'Success!', 
          message: 'Booking added Successfully.Reloading page',
          position: 'bottomRight'  });setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
         echo "<script> iziToast.warning({
        title: 'Warning!',
        message: 'An error occured. Reload page and retry or cantact us if persistent.',
        position: 'bottomRight'  });</script>";
        exit();
      }
}
elseif (isset($_POST['t_fname'])) {
  $status =  studentLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/signin');
          },3000);
          </script>";
          exit();
       }

       $title = test_input($_POST['title']);
       $fname = test_input($_POST['t_fname']);
       $mname  = test_input($_POST['t_mname']);
       $sname  = test_input($_POST['t_sname']);
       $hometown  = test_input($_POST['hometown']);
       $gender  = test_input($_POST['gender']);
       $nationality  = test_input($_POST['nationality']);
       $postal  = test_input($_POST['postal']);
       $residential  = test_input($_POST['residential']);
       $default = $_POST['default_image'];

       if (empty($fname) || empty($sname) || empty($gender) || empty($nationality)  || empty($hometown) || empty($postal) || empty($residential)) {
          echo "<script> iziToast.warning({
       title: 'Field(s) Required!',
       message: 'One or more required field(s) is empty. Check and resubmit',
       position: 'bottomRight'  });</script>";
       exit();
       }

      $pathResponse = newSingleUpload($_FILES['profile_image'],'image','profile',$default);


          $response = array('',2,3,4,5);

  if (in_array($pathResponse, $response)) {
    switch ($pathResponse) {
      case '':
      $c_title = "Image Required";
      $c_message = "Please upload an image for your profile";
      break;
      case 2:
      $c_title = "Unsupoorted File";
      $c_message = "The file uploaded appears not be an image. png, jpg and jpeg files only";
      break;
      case 3:
      $c_title = "File Error";
      $c_message = "An unexpected error occured. Reload page and retry";
      break;
      case 4:
      $c_title = "Large File Size";
      $c_message = "Your file is larger than the maximum of 2MB";
      break;
      case 5:
      $c_title = "Upload Error";
      $c_message = "Could not move file to destination folder. contact support";
      break;
      default:
        # nothing here...
      break;
    }
   echo "<script> iziToast.warning({
      title: '$c_title!',
      message: '$c_message',
      position: 'bottomRight'  });</script>";
      exit(); 
    }

      $profileArray = array('title'=>$title,'avatar'=>$pathResponse,'fname' =>$fname , 'mname' => $mname, 'sname' => $sname, 'dob'=> null, 'place' => null, 'hometown' => $hometown, 'languages' => null, 'religion' => null, 'marital' =>null, 'gender' => $gender , 'nationality' =>$nationality, 'phone'=>null, 'email' => null, 'home_phone'=>null , 'postal' => $postal, 'residential' => $residential);

      $profileArray = serialize($profileArray);

      $sql = "UPDATE ng_students SET first_name = ?, other_names = ?,  profile_info = ? WHERE email_address = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('ssss',$fname,$sname,$profileArray,$status);
      $stmt->execute();

      if ($stmt->affected_rows === 1) {
       echo "<script> iziToast.success({
          title: 'Success!', 
          message: 'Profile Updated Successfully.Reloading page',
          position: 'bottomRight'  }); $('form.tour-form').find('input:not(input[type="."submit"."])').val(''); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
         echo "<script> iziToast.warning({
        title: 'Warning!',
        message: 'No updates detected hence no changes were made to existing information. Contact us if you think this is an error.',
        position: 'bottomRight'  });</script>";
        exit();
      }
}

elseif (isset($_POST['o_mail_id'])) {
     $status =  studentLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/signin');
          },3000);
          </script>";
          exit();
       }

       $o_mail_id = $_POST['o_mail_id'];
       $o_mail_id = encode($o_mail_id,'d');

       if (empty($o_mail_id)) {
            echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry',
       position: 'bottomRight'  });</script>";
       exit();
       }

        $oldmail = test_input($_POST['old_mail']);
        $newmail = test_input($_POST['new_mail']);
        $confirmmail = test_input($_POST['confirm_mail']);

        if (empty($oldmail)) {
          echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Enter old email address',
       position: 'bottomRight'  });</script>";
       exit();
        }

          if (!filter_var($oldmail, FILTER_VALIDATE_EMAIL)) {
      echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Enter valid email address for old email box',
        position: 'bottomRight'  });</script>";
        exit();
      }

        if (empty($newmail)) {
          echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Enter new email address',
       position: 'bottomRight'  });</script>";
       exit();
        }

          if (!filter_var($newmail, FILTER_VALIDATE_EMAIL)) {
      echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Enter valid email address for new email box',
        position: 'bottomRight'  });</script>";
        exit();
      }

  if (empty($confirmmail)) {
          echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'confirm new email address',
       position: 'bottomRight'  });</script>";
       exit();
        }

        if ($newmail != $confirmmail) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Email addresses do not match',
       position: 'bottomRight'  });</script>";
       exit();
        }

        if ($oldmail != $o_mail_id) {
            echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Incorrect old email address',
       position: 'bottomRight'  });</script>";
       exit();
        }

        if ($oldmail == $newmail) {
            echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Old email is same as new email',
       position: 'bottomRight'  });</script>";
       exit();
        }

          if(checkEmail($newmail) == true) :

           echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Email address already belongs to another account',
        position: 'bottomRight'  });</script>";
        exit();

      endif;

        $sql = "UPDATE ng_students SET email_address = ? WHERE email_address = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('ss',$newmail,$status);
        $stmt->execute();

         if ($stmt->affected_rows === 1) {
       echo "<script> iziToast.success({
          title: 'Success!', 
          message: 'Email Updated Successfully.Logging you out',
          position: 'bottomRight'  }); $('form.mail-form').find('input:not(input[type="."submit"."])').val(''); setTimeout(function () {
          location.replace('logout/".$_SESSION['student_token']."');}, 2000);</script>";
          exit();
      }else{
         echo "<script> iziToast.warning({
        title: 'Warning!',
        message: 'No updates detected hence no changes were made to existing information. Contact us if you think this is an error.',
        position: 'bottomRight'  });</script>";
        exit();
      }

    }
    //old phone
    elseif (isset($_POST['o_ph_id'])) {
     $status =  studentLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/signin');
          },3000);
          </script>";
          exit();
       }

       $o_ph_id = $_POST['o_ph_id'];
       $o_ph_id = encode($o_ph_id,'d');

       if (empty($o_ph_id)) {
            echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry',
       position: 'bottomRight'  });</script>";
       exit();
       }

        $oldphone = test_input($_POST['ph-o']);
        $newphone = test_input($_POST['ph-n']);
        $confirmphone = test_input($_POST['ph-c']);

        if (empty($oldphone)) {
          echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Enter old phone number',
       position: 'bottomRight'  });</script>";
       exit();
        }

           if (!filter_var($oldphone, FILTER_SANITIZE_NUMBER_INT)) {
      echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Enter a valid phone number',
        position: 'bottomRight'  });</script>";
        exit();
      }

        if (empty($newphone)) {
          echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Enter new phone number',
       position: 'bottomRight'  });</script>";
       exit();
        }

           if (!filter_var($newphone, FILTER_SANITIZE_NUMBER_INT)) {
      echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Enter a valid phone number for new phone number',
        position: 'bottomRight'  });</script>";
        exit();
      }


  if (empty($confirmphone)) {
          echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'confirm new phone number',
       position: 'bottomRight'  });</script>";
       exit();
        }

        if ($newphone != $confirmphone) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Phone numbers do not match',
       position: 'bottomRight'  });</script>";
       exit();
        }

        if ($oldphone != $o_ph_id) {
            echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Incorrect old phone number',
       position: 'bottomRight'  });</script>";
       exit();
        }

        if ($oldphone == $newphone) {
            echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Old phone number is same as new phone number',
       position: 'bottomRight'  });</script>";
       exit();
        }


        $sql = "UPDATE ng_students SET phone_number = ? WHERE email_address = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('ss',$newphone,$status);
        $stmt->execute();

         if ($stmt->affected_rows === 1) {
       echo "<script> iziToast.success({
          title: 'Success!', 
          message: 'Phone number Updated Successfully.Reloading page',
          position: 'bottomRight'  }); $('form.phone-form').find('input:not(input[type="."submit"."])').val(''); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
         echo "<script> iziToast.warning({
        title: 'Warning!',
        message: 'No updates detected hence no changes were made to existing information. Contact us if you think this is an error.',
        position: 'bottomRight'  });</script>";
        exit();
      }

    }

//password form
    elseif (isset($_POST['o_pass_id'])) {
     $status =  studentLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/signin');
          },3000);
          </script>";
          exit();
       }

       $o_pass_id = $_POST['o_pass_id'];
       $o_pass_id = encode($o_pass_id,'d');

       if (empty($o_pass_id)) {
            echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry',
       position: 'bottomRight'  });</script>";
       exit();
       }

        $oldpass = $_POST['p-o'];
        $newpass = $_POST['p-n'];
        $confirmpass = $_POST['p-c'];

        if (empty($oldpass)) {
          echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Enter old password',
       position: 'bottomRight'  });</script>";
       exit();
        }


        if (empty($newpass)) {
          echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Enter new password',
       position: 'bottomRight'  });</script>";
       exit();
        }


  if (empty($confirmpass)) {
          echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'confirm new password',
       position: 'bottomRight'  });</script>";
       exit();
        }

        if ($newpass != $confirmpass) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Passwords do not match',
       position: 'bottomRight'  });</script>";
       exit();
        }

         $studentExist  = studentEmailLogin($o_pass_id,$oldpass);
         if ($studentExist) {
           if (passwordStrength($newpass) == true) {
        echo "<script> iziToast.warning({
          title: 'Action Required!',
          message: 'Password should be at least 8 charecters long and should contain at least 1 upper case letter, 1 lower case letter and 1 number ',
          position: 'bottomRight'  });</script>";
          exit();
           }

        $password = passwordEncryption($newpass);
         }else {
           echo "<script> iziToast.warning({
          title: 'Action Required!',
          message: 'Incorrect old password',
          position: 'bottomRight'  });</script>";
          exit();
         }
       

        $sql = "UPDATE ng_students SET password = ? WHERE email_address = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('ss',$password,$status);
        $stmt->execute();

         if ($stmt->affected_rows === 1) {
       echo "<script> iziToast.success({
          title: 'Success!', 
          message: 'Password updated successfully.Reloading page',
          position: 'bottomRight'  }); $('form.password-form').find('input:not(input[type="."submit"."])').val(''); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
         echo "<script> iziToast.warning({
        title: 'Warning!',
        message: 'No updates detected hence no changes were made to existing information. Contact us if you think this is an error.',
        position: 'bottomRight'  });</script>";
        exit();
      }

    }

      elseif (isset($_POST['cancelid'])) {
     $status =  studentLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/signin');
          },3000);
          </script>";
          exit();
       }

       $delid = $_POST['cancelid'];

       $delid = encode($delid,'d');

       $iql = "UPDATE ng_tour_bookings SET status = ? WHERE id = ?";
      $itmt = $db->prepare($iql);
      $status = 'cancelled';
      $itmt->bind_param('si', $status,$delid);
      $itmt->execute();

      if ($itmt->affected_rows === 1) {
       echo "<script> iziToast.success({
          title: 'Success!', 
          message: 'Booking updated Successfully.Reloading page',
          position: 'bottomRight'  });setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
         echo "<script> iziToast.warning({
        title: 'Warning!',
        message: 'No updates detected hence no changes were made to existing information. Contact us if you think this is an error.',
        position: 'bottomRight'  });</script>";
        exit();
      }
  }

      elseif (isset($_POST['terminate_id'])) {
     $status =  studentLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/signin');
          },3000);
          </script>";
          exit();
       }

       $delid = $_POST['terminate_id'];

       $delid = encode($delid,'d');

       $name = $_POST['terminate_name'];

        $name = encode($name,'d');

        $email = $_POST['terminate_email'];

         $email = encode($email,'d');

         if (empty($delid) || empty($name) || empty($email)) {
            echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $reason = test_input($_POST['terminate_reason']);

       $sql = "INSERT INTO ng_terminate (name,email_address,reason,date_terminated) VALUES (?,?,?,?)";
       $stmt = $db->prepare($sql);
       $date = date("Y-m-d H:i:s");
       $stmt->bind_param('ssss',$name,$email,$reason,$date);
       $stmt->execute();

       if ($stmt->affected_rows == 1) {
           $iql = "DELETE FROM ng_students WHERE id = ?";
      $itmt = $db->prepare($iql);
      $itmt->bind_param('i',$delid);
      $itmt->execute();

      if ($itmt->affected_rows === 1) {
        newNotification(test_output($name),"deleted his account with us","name");
       echo "<script> iziToast.success({
          title: 'Success!', 
          message: 'Account terminated Successfully.Logging you out',
          position: 'bottomRight'  });setTimeout(function () {
          location.replace('/logout/".$_SESSION['student_token']."');}, 2000);</script>";
          exit();
      }else{
        echo "<script> iziToast.warning({
        title: 'Unknown error!',
        message: 'An error occured. Reload page and retry or contact us to delete your account manually',
        position: 'bottomRight'  });</script>";
        exit();
      }
       }else{
        echo "<script> iziToast.warning({
        title: 'Unknown error!',
        message: 'An error occured. Reload page and retry or contact us to delete your account manually',
        position: 'bottomRight'  });</script>";
        exit();
       }
        
    
  }
//visa from
  elseif (isset($_POST['visa_type'])) {
        
         $status =  studentLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/signin');
          },3000);
          </script>";
          exit();
       }
       $id = $_POST['vid'];
       $id = encode($id,'d');
       if (empty($id)) {
          echo "<script> iziToast.warning({
       title: 'unknown error!',
       message: 'An error occured, reload page and retry',
       position: 'bottomRight'  });</script>";
       exit();
       }

        $type = $_POST['visa_type'];
        $priority = test_input($_POST['priority']);
        $notes = test_input($_POST['add_notes']);
       

        if (empty($type)) {
      echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Select a visa application type',
       position: 'bottomRight'  });</script>";
       exit();
     }
     $type = encode($type,'d');
    

     if (empty($priority)) {
      echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Select a priority for your visa application',
       position: 'bottomRight'  });</script>";
       exit();
     }


$visaArray = array("type" => $type,  "priority" => $priority, "notes"=>$notes);

$visaArray = serialize($visaArray);

    $sql = "INSERT INTO ng_visa_application (sid,visa_details,last_updated) VALUES(?,?,?)";
      $stmt = $db->prepare($sql);
      $date = date('Y-m-d H:i:s');
      $stmt->bind_param('iss', $id,$visaArray,$date);
      $stmt->execute();

      if ($stmt->affected_rows === 1) {

        newNotification($id,"submited a new visa application","id");
       echo "<script> iziToast.success({
          title: 'Success!', 
          message: 'Application added Successfully.Reloading page',
          position: 'bottomRight'  });setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
         echo "<script> iziToast.warning({
        title: 'Warning!',
        message: 'An error occured. Reload page and retry or cantact us if persistent.',
        position: 'bottomRight'  });</script>";
        exit();
      }
}
 elseif (isset($_POST['visaid'])) {
     $status =  studentLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/signin');
          },3000);
          </script>";
          exit();
       }

       $delid = $_POST['visaid'];

       $delid = encode($delid,'d');

       $iql = "UPDATE ng_visa_application SET status = ? WHERE id = ?";
      $itmt = $db->prepare($iql);
      $status = 'cancelled';
      $itmt->bind_param('si', $status,$delid);
      $itmt->execute();

      if ($itmt->affected_rows === 1) {
       echo "<script> iziToast.success({
          title: 'Success!', 
          message: 'Visa application cancelled Successfully.Reloading page',
          position: 'bottomRight'  });setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
         echo "<script> iziToast.warning({
        title: 'Warning!',
        message: 'No updates detected hence no changes were made to existing information. Contact us if you think this is an error.',
        position: 'bottomRight'  });</script>";
        exit();
      }
  }
      else{
    //end of the road
      }

    } else{
      http_response_code(404);
      $arrayName = array(404 => 'Page Not Found', );
      print_r($arrayName);
    //include 'lm_404.php';
    }

    ?>