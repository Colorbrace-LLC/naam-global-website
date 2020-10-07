<?php
session_name('naamglobal');
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

	  require_once '../includes/dbcon.php';
  require_once '../includes/functions.php';


  require '../includes/src/Exception.php';
  require '../includes/src/PHPMailer.php';
  require '../includes/src/SMTP.php';

	if (isset($_POST['login_email'])) {
		 $email = test_input($_POST['login_email']);
       $password = $_POST['login_password'];

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

      $adminExist  = staffEmailLogin($email,$password);


     if ($adminExist) {

        session_regenerate_id();
        $adminToken = bin2hex(openssl_random_pseudo_bytes(24));

        $_SESSION['admin_token'] = $adminToken;
        $_SESSION['admin_email'] = $adminExist['email_address'];
        $_SESSION['admin_login_status'] = true;
        $_SESSION['admin_name'] = $adminExist['first_name'] ." ". $adminExist['other_names'] ;


 echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Login success, redirecting to dashboard',
          position: 'bottomRight' }); $('form.login-form').find('input:not(input[type="."submit"."])').val(''); setTimeout(function () {
          location.replace('dashboard');}, 2000);</script>";
          exit();


   } else{

     echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Invalid credentials. Check details and retry.',
       position: 'bottomRight'  });</script>";
       exit();
   }
	}elseif (isset($_POST['nfid'])) {

     $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }


		$id = trim($_POST['nfid']);

    if (empty($id)) {
      echo "<script> iziToast.warning({
        title: 'Unknown Error!',
        message: 'An error occured. reload page and retry',
        position: 'bottomRight'  });</script>";
        exit();
    }

    $id = encode($id,'d');


    $sql = "UPDATE ng_notifications SET enabled = ? WHERE id = ?";
    $enabled = 'no';
    $stmt = $db->prepare($sql);
    $stmt->bind_param('si',$enabled,$id);
    $stmt->execute();

    if ($stmt->affected_rows == 1) {
       echo "<script> iziToast.success({
          title: 'Success!', 
          message: 'Notification marked as read.',
          position: 'bottomRight'  }); </script>";
    }
	}elseif (isset($_POST['user_id'])) {
   $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

       $userid = $_POST['user_id'];
        if (empty($userid)) {
          echo "<script> iziToast.warning({
       title: 'Unknown Error!',
       message: 'An error occured. Reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $userid = encode($userid,'d');
       $first_name = test_input($_POST['first_name']);
       $other_names = test_input($_POST['other_names']);
       $email_address = test_input($_POST['email_address']);
       $phone_number = test_input($_POST['phone_number']);
       $account_type = test_input($_POST['account_type']);
       $email_verified = test_input($_POST['email_verified']);
       $phone_verified = test_input($_POST['phone_verified']);
       $password = $_POST['password'];
       $c_password = $_POST['password_c'];
       $enabled = test_input($_POST['user_status']);
       $emailid = $_POST['user_email'];
       $emailid = encode($emailid,'d');

       if (empty($first_name)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'First name is required',
       position: 'bottomRight'  });</script>";
       exit();
       }

       if (empty($other_names)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Other names is required',
       position: 'bottomRight'  });</script>";
       exit();
       }

       if (empty($email_address)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Email address is required',
       position: 'bottomRight'  });</script>";
       exit();
       }

       if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
      echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Enter a valid email address',
        position: 'bottomRight'  });</script>";
        exit();
      }

       if (empty($phone_number)) {
          echo "<script> iziToast.warning({
        title: 'Field Required!',
        message: 'Phone number is required',
        position: 'bottomRight'  });</script>";
        exit();
        }

     if (!filter_var($phone_number, FILTER_SANITIZE_NUMBER_INT)) {
      echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Enter a valid phone number',
        position: 'bottomRight'  });</script>";
        exit();
      }

       if (empty($email_verified)) {
          echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Select email verification status',
        position: 'bottomRight'  });</script>";
        exit();
        }

       if (empty($phone_verified)) {
          echo "<script> iziToast.warning({
        title: 'Field Required!',
        message: 'Select phone number verification status',
        position: 'bottomRight'  });</script>";
        exit();
        }
      if ($email_address != $emailid) {
        if(checkEmail($email_address) == true) :

           echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Email address already belongs to another account ',
        position: 'bottomRight'  });</script>";
        exit();

      endif;
      }

      if (!empty($password)) {
        if ($password != $c_password) {
            echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Passwords do not match. Check and retry',
        position: 'bottomRight'  });</script>";
        exit();
        }
         if (passwordStrength($password) == true) {
        echo "<script> iziToast.warning({
          title: 'Action Required!',
          message: 'Password should be at least 8 charecters long and should contain at least 1 upper case letter, 1 lower case letter and 1 number ',
          position: 'bottomRight'  });</script>";
          exit();
      }
      $password = passwordEncryption($password);
      }

      $sql = "UPDATE ng_students SET first_name = ?, other_names = ?, email_address = ?, phone_number = ?, account_type = ?, email_verified = ?, phone_verified = ?, password = IFNULL(password, ?) , enabled = ?  WHERE id = ?";

      $stmt = $db->prepare($sql);
      $stmt->bind_param('sssssssssi',$first_name,$other_names,$email_address,$phone_number,$account_type,$email_verified,$phone_verified,$password,$enabled,$userid);
      $stmt->execute();

      if ($stmt->affected_rows == 1) {
       echo "<script> iziToast.success({
          title: 'Success!',
          message: 'User details updated successfully, reloading page',
          position: 'bottomRight' }); $('form.update-form').find('input:not(input[type="."submit"."])').val(''); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'No changes were made. reload page and retry if it\'s an error.',
       position: 'bottomRight'  });</script>";
       exit();
      }



  } 
//delete user
  elseif (isset($_POST['udel'])) {
      $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

       $id = $_POST['udel'];

       if (empty(trim($id))) {
          echo "<script> iziToast.warning({
       title: 'Unknown Error!',
       message: 'An error occured. Reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $id = encode($id,'d');

       $sql = "DELETE FROM ng_students WHERE id = ?";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('i',$id);
       $stmt->execute();

       if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'User deleted successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.replace('/admin-cp/students/manage');}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
	//loadResponse modal
  elseif (isset($_POST['uid'])) {
     $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

    $id = $_POST['uid'];
    $sid = $_POST['sid'];

     if (empty($id) || empty($sid)) {
      echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
      $id = encode($id,'d');
      $sid = encode($sid,'d');

      switch ($id) {
        case 1:
          $arr = "1st";
          break;
        case 2:
          $arr = "2nd";
          break;
        case 3:
            $arr = "3rd";
            break;  
        default:
          # nothing
          break;
      }

      $sql = "SELECT program_info FROM ng_students WHERE id = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('i',$sid);
      $stmt->execute();
      $res = $stmt->get_result();

      $output = "";
      while ($row = $res->fetch_assoc()) {
        $programArray = $row['program_info'];

        $programArray = unserialize($programArray);
        $ps = $as = $ds = $cs = "";

         if($programArray[$arr]['status'] == 'processing') : $ps = "selected"; endif;
        if($programArray[$arr]['status'] == 'accepted') : $as =  "selected"; endif;
        if($programArray[$arr]['status'] == 'declined') : $ds = "selected"; endif;
        if($programArray[$arr]['status'] == 'cancelled') : $cs = "selected"; endif;

        $output.='<div class="modal-header text-center">';
        $output.='<h4 class="modal-title w-100 font-weight-bold">'.fetchSchoolName($programArray[$arr]['name']).'</h4>';
        $output.='<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        $output.='<span aria-hidden="true">&times;</span>';
        $output.='</button>';
        $output.='</div>';
        $output.='<form method="post" class="response-form">';
        $output.='<div class="modal-body mx-3">';
        $output.='<div class="md-form mb-5">';
         $output.='<label  for="s_progress">Select progress</label>';
        $output.=' <select class="form-control"  id="s_progress" required name="s_progress">';
        $output.='<option disabled selected value="">Select progress</option>';
        $output.='<option value="processing" '.$ps .'>Processing</option>';
        $output.='<option value="accepted" '.$as .'>Accepted</option>';
        $output.='<option value="declined" '. $ds.'>Declined</option>';
        $output.='<option value="cancelled" '. $cs. '>Cancelled</option>';
        $output.='</select>';
        $output.='</div>';
         $output.='<div class="md-form mb-5">';
         $output.='<input type="hidden" name="arr" value="'.encode($arr,"e").'">';
          $output.='<input type="hidden" name="sid" value="'.encode($sid,"e").'">';
           $output.='<label  for="s_choice">Update for</label>';
        $output.=' <select class="form-control"  title="Select type" id="s_choice" required name="s_choice">';
        $output.='<option disabled selected value="">Select update for</option>';
        $output.='<option value="all">All</option>';
        foreach(array_slice($programArray[$arr], 1, -1) as $choice) :
            $output.='<option>'.$choice.'</option>';
        endforeach;
        $output.='</select>';
        $output.='</div>';
        $output.='<div class="md-form mb-5">';
        $output.='<input type="text" name="s_note" placeholder="e.g processing your application" id="s_note" class="form-control" required>';
        $output.=' <label  for="s_note">Attached note</label>';
        $output.='</div>';
        $output.='</div>';
        $output.='<div class="modal-footer d-flex justify-content-center">';
        $output.='<button type="submit" class="btn btn-danger response-btn">Update progress</button>';
        $output.=' </div>';
        $output.='</form>';
        $output.='<script type="text/javascript">';
        $output.=' var response_form = $("form.response-form"), response_btn = $("button.response-btn"), loader_white =  "<span class=spinner-border spinner-border-sm text-white></span>";';
        $output.='response_form.on("submit",function(rf){';
        $output.='rf.preventDefault();';
        $output.='response_btn.html("Processing "+loader_white);';
        $output.='$.post("/admin-cp/processor.php", response_form.serialize(), function(data){';
        $output.='response_form.after(data);';
        $output.='response_btn.text("Update progress");';
       $output.='});';
        $output.='});';
        $output.='</script>';
      
       
      }
      echo $output;
     }
  
  //process update modal
  elseif (isset($_POST['arr'])) {
    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }
       $arr = $_POST['arr'];
       $sid = $_POST['sid'];

        if (empty($arr) || empty($sid)) {
      echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry. $sid',
       position: 'bottomRight'  });</script>";
       exit();
      }


      $progress = test_input($_POST['s_progress']);
      $choice = test_input($_POST['s_choice']);
      $note = test_input($_POST['s_note']);

       if (empty($progress)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Please select a progress from the list to update',
       position: 'bottomRight'  });</script>";
       exit();
       }

       if (empty($choice)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Please select a choice from the list to update',
       position: 'bottomRight'  });</script>";
       exit();
       }


       if (empty($note)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Please add a note to your update,
       position: 'bottomRight'  });</script>";
       exit();
       }

       if ($choice == 'all') {
         $choice = '';
       } else{
        $choice =  " [".$choice."]";
       }

       $arr = encode($arr,'d');
       $sid = encode($sid,'d');

      $sql = "SELECT program_info FROM ng_students WHERE id = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('i',$sid);
      $stmt->execute();
      $res = $stmt->get_result();
      $row = $res->fetch_assoc();

       $programArray = $row['program_info'];

      $programArray = unserialize($programArray);

       $programArray[$arr]["status"] = $progress;

       $programArray = serialize($programArray);

      $uql = "UPDATE ng_students SET program_info = ? WHERE id = ?";
      $ustmt = $db->prepare($uql);
      $ustmt->bind_param('si',$programArray,$sid);
      $ustmt->execute();
     
     if ($ustmt->affected_rows == 1) {

      $aql = "INSERT INTO ng_activities (sid,type,message,date_added) VALUES(?,?,?,?)";
      $astmt = $db->prepare($aql);
      $type = 'school';
      $message = $note.$choice;
      $date = date("Y-m-d H:i:s");
      $astmt->bind_param('isss',$sid,$type,$message,$date);
      $astmt->execute();
      if ($astmt->affected_rows==1) {
         echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Application details updated successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      } else{
        echo "<script> iziToast.warning({
       title: 'Known error!',
       message: 'An error occured updating activity, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
     
     }else{
      echo "<script> iziToast.warning({
       title: 'Known error!',
       message: 'An error occured updating data, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
     }


  }
  //destination form
  elseif (isset($_POST['des_name'])) {
     $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

       $name = test_input($_POST['des_name']);
       $region = test_input($_POST['des_region']);
       $status = test_input($_POST['des_status']);

         if (empty($name)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Destination name is required',
       position: 'bottomRight'  });</script>";
       exit();
       }
         if (empty($region)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Destination region is required',
       position: 'bottomRight'  });</script>";
       exit();
       }
         if (empty($status)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Please select a status, to continue',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $pathResponse = newSingleUpload($_FILES['des_image'],'image','tours','');

        $response = array(1,2,3,4,5,'');

          if (in_array($pathResponse, $response)) {
    switch ($pathResponse) {
      case 1:
      $c_title = "Image Required";
      $c_message = "Please upload an image for your tour destination";
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
      case '':
         $c_title = "Upload Error";
      $c_message = "Please select an image for your destination";
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

    $sql = "INSERT INTO ng_destinations (name,image,region,enabled) VALUES(?,?,?,?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('ssss',$name,$pathResponse,$region,$status);
    $stmt->execute();

    if ($stmt->affected_rows == 1) {
     echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Destination added successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      } else{
        echo "<script> iziToast.warning({
       title: 'Known error!',
       message: 'An error occured adding destination, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
  //delete destination
  elseif (isset($_POST['deldes'])) {
         $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

       $id = $_POST['deldes'];

       if (empty(trim($id))) {
          echo "<script> iziToast.warning({
       title: 'Unknown Error!',
       message: 'An error occured. Reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $id = encode($id,'d');

       $sql = "DELETE FROM ng_destinations WHERE id = ?";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('i',$id);
       $stmt->execute();

       if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Destination deleted successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
  //edit destination
  elseif (isset($_POST['editdes'])) {
    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

    $id = $_POST['editdes'];

     if (empty($id)) {
      echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
      $id = encode($id,'d');

      $sql = "SELECT * FROM ng_destinations WHERE id = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('i',$id);
      $stmt->execute();
      $res = $stmt->get_result();

      $output = "";
      while ($row = $res->fetch_assoc()) {
      $checked = $row['enabled'];
      if ($checked == 'yes') {
       $echeck = "checked";
       $ncheck = "";
      }else{
         $echeck = "";
       $ncheck = "checked";
      }

        $output.='<div class="modal-header text-center">';
        $output.='<h4 class="modal-title w-100 font-weight-bold">'.test_output($row["name"]).'</h4>';
        $output.='<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        $output.='<span aria-hidden="true">&times;</span>';
        $output.='</button>';
        $output.='</div>';
        $output.='<div class="modal-body mx-3">';
        $output.='<form method="post" class="editdes-form" enctype="multipart/form-data">';
        $output.=' <div class="form-group">';
        $output.='<label for="e_des_name" class="bmd-label-floating">Name <small>e.g werder bremen</small></label>';
         $output.='<input type="text" class="form-control" value="'.test_output($row["name"]).'" name="e_des_name"  id="e_des_name">';
        $output.='</div>';
        $output.='<div class="form-group">';
        $output.='<input type="hidden" name="desid" value="'.encode($row["id"],"e").'">';
        $output.='<input type="hidden" name="desimage" value="'.encode($row["image"],"e").'">';
        $output.='<label for="e_des_region" class="bmd-label-floating">Region <small>e.g Europe</small></label>';
        $output.='<input type="text" class="form-control" value="'.test_output($row["region"]).'" name="e_des_region"  id="e_des_region">';
        $output.='</div>';
        $output.='<div class="fileinput fileinput-new text-center" data-provides="fileinput">';
        $output.='<div class="fileinput-new thumbnail">';
        $output.='<img src="/assets/images/tour/'.$row["image"].'" alt="...">';
         $output.='</div>';
         $output.='<div class="fileinput-preview fileinput-exists thumbnail"></div>';
          $output.='<div>';
           $output.='<span class="btn btn-danger btn-round btn-file">';
        $output.='<span class="fileinput-new">Change image</span>';
        $output.='<span class="fileinput-exists">Change</span>';
        $output.='<input type="file" name="e_des_image" accept=".jpg,.jpeg,.png" />';
        $output.=' </span>';
        $output.='<a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput">';
        $output.='<i class="fa fa-times"></i> Remove</a>';
        $output.=' </div>';
        $output.=' </div>';
        $output.='<div class="form-check">';
        $output.='<div class="col-sm-10 checkbox-radios">';
        $output.='<div class="form-check form-check-inline">';
        $output.='<label class="form-check-label">';
        $output.='<input class="form-check-input" type="radio" name="e_des_status"'.$echeck.' value="yes"> Enabled';
        $output.='<span class="circle">';
        $output.=' <span class="check"></span>';
        $output.='</span>';
        $output.='</label>';
        $output.='</div>';
        $output.='<div class="form-check form-check-inline">';
        $output.='<label class="form-check-label">';
        $output.='<input class="form-check-input" type="radio" name="e_des_status"'.$ncheck.' value="no"> Disabled';
        $output.='<span class="circle">';
        $output.=' <span class="check"></span>';
        $output.='</span>';
        $output.='</label>';
        $output.='</div>';
        $output.='</div>';
        $output.='</div>';
        $output.='<div class="progress md-progress" style="display: none;height: 10px">';
        $output.='<div class="progress-bar bg-danger" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>';
        $output.='</div>';
        $output.='<div class="card-footer ">';
        $output.='<button type="submit" class="btn btn-fill btn-danger editdes-btn">update</button>';
        $output.='</div>';
        $output.='</form>';
         $output.='</div>';
        $output.='<script type="text/javascript">';
        $output.=' var response_form = $("form.editdes-form"), response_btn = $("button.editdes-btn"), loader_white =  "<span class=spinner-border spinner-border-sm text-white></span>";';
        $output.='response_form.on("submit",function(rf){';
        $output.='rf.preventDefault();';
        $output.='$("div.progress").show("fadeInUp");';
        $output.='$.ajax({';
        $output.='xhr: function() {';
        $output.=' var xhr = new window.XMLHttpRequest();';
        $output.='xhr.upload.addEventListener("progress", function(evt) {';
        $output.='if (evt.lengthComputable) {';
        $output.='var percentComplete = ((evt.loaded / evt.total) * 100);';
        $output.='$(".progress-bar").width(percentComplete + "%");';
        $output.=' $(".progress-bar").html(percentComplete+"%");';
        $output.=' }';
        $output.='}, false);';
        $output.='return xhr;';
        $output.='},';
        $output.='url: "/admin-cp/processor.php",';
        $output.='type: "POST",';
        $output.='data:  new FormData(this),';
        $output.='contentType: false,';
        $output.='cache: false,';
        $output.='processData:false,';
        $output.='beforeSend : function()';
        $output.='{response_btn.html("Processing "+loader_white);},';
        $output.='success: function(data){response_form.after(data);response_btn.text("Update");}';
       $output.='});';
        $output.='});';
        $output.='</script>';
      
       
      }
      echo $output;
  }
  //edit destination
  elseif (isset($_POST['desid'])) {
    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }
       $id = $_POST['desid'];
       $image = $_POST['desimage'];

        if (empty($id) || empty($image)) {
      echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry. $sid',
       position: 'bottomRight'  });</script>";
       exit();
      }

      $id = encode($id,'d');
      $image = encode($image,'d');

      $name = test_input($_POST['e_des_name']);
      $region = test_input($_POST['e_des_region']);
      $status = test_input($_POST['e_des_status']);

      if (empty($name)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Destination name can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
         if (empty($region)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Destination region can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
         if (empty($status)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Please select a status, to continue',
       position: 'bottomRight'  });</script>";
       exit();
       }
      if(is_uploaded_file($_FILES['e_des_image']['tmp_name'])){


       $pathResponse = newSingleUpload($_FILES['e_des_image'],'image','tours','');

        $response = array(1,2,3,4,5,'');

          if (in_array($pathResponse, $response)) {
    switch ($pathResponse) {
      case 1:
      $c_title = "Image Required";
      $c_message = "Please upload an image for your tour destination";
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
      case '':
         $c_title = "Upload Error";
      $c_message = "Please select an image for your destination";
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

    unlink("../assets/images/tour/$image");

      }else{
        $pathResponse = $image;
      }

      $sql = "UPDATE ng_destinations SET name = ?, image = ?, region = ?, enabled = ? WHERE id = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('ssssi',$name,$pathResponse,$region,$status,$id);
      $stmt->execute();

      if ($stmt->affected_rows == 1) {
       echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Destination updated successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'No changes were made., reload page and retry if you think it is an error.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
  //visa types
  elseif (isset($_POST['vis_name'])) {
        $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

       $name = test_input($_POST['vis_name']);
       $status = test_input($_POST['vis_status']);

         if (empty($name)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Destination name is required',
       position: 'bottomRight'  });</script>";
       exit();
       }
         
         if (empty($status)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Please select a status, to continue',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $pathResponse = newSingleUpload($_FILES['vis_image'],'image','visa','');

        $response = array(1,2,3,4,5,'');

          if (in_array($pathResponse, $response)) {
    switch ($pathResponse) {
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
      case '':
       $c_title = "Image Required";
      $c_message = "Please upload an image for your visa type";
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

    $sql = "INSERT INTO ng_visas (name,image,enabled) VALUES(?,?,?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('sss',$name,$pathResponse,$status);
    $stmt->execute();

    if ($stmt->affected_rows == 1) {
     echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Visa type added successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      } else{
        echo "<script> iziToast.warning({
       title: 'Known error!',
       message: 'An error occured adding visa type, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
  //delete visa type
  elseif (isset($_POST['delvis'])) {
           $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

       $id = $_POST['delvis'];

       if (empty(trim($id))) {
          echo "<script> iziToast.warning({
       title: 'Unknown Error!',
       message: 'An error occured. Reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $id = encode($id,'d');

       $sql = "DELETE FROM ng_visas WHERE id = ?";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('i',$id);
       $stmt->execute();

       if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Visa type deleted successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
  // edit visa type
  elseif (isset($_POST['editvis'])) {
     $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

    $id = $_POST['editvis'];

     if (empty($id)) {
      echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
      $id = encode($id,'d');

      $sql = "SELECT * FROM ng_visas WHERE id = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('i',$id);
      $stmt->execute();
      $res = $stmt->get_result();

      $output = "";
      while ($row = $res->fetch_assoc()) {
      $checked = $row['enabled'];
      if ($checked == 'yes') {
       $echeck = "checked";
       $ncheck = "";
      }else{
         $echeck = "";
       $ncheck = "checked";
      }

        $output.='<div class="modal-header text-center">';
        $output.='<h4 class="modal-title w-100 font-weight-bold">'.test_output($row["name"]).'</h4>';
        $output.='<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        $output.='<span aria-hidden="true">&times;</span>';
        $output.='</button>';
        $output.='</div>';
        $output.='<div class="modal-body mx-3">';
        $output.='<form method="post" class="editvis-form" enctype="multipart/form-data">';
        $output.=' <div class="form-group">';
         $output.='<input type="hidden" name="visid" value="'.encode($row["id"],"e").'">';
        $output.='<input type="hidden" name="visimage" value="'.encode($row["image"],"e").'">';
        $output.='<label for="e_vis_name" class="bmd-label-floating">Name <small>e.g student visa</small></label>';
         $output.='<input type="text" class="form-control" value="'.test_output($row["name"]).'" name="e_vis_name"  id="e_vis_name">';
        $output.='</div>';
        $output.='<div class="fileinput fileinput-new text-center" data-provides="fileinput">';
        $output.='<div class="fileinput-new thumbnail">';
        $output.='<img src="/assets/images/visas/'.$row["image"].'" alt="...">';
         $output.='</div>';
         $output.='<div class="fileinput-preview fileinput-exists thumbnail"></div>';
          $output.='<div>';
           $output.='<span class="btn btn-danger btn-round btn-file">';
        $output.='<span class="fileinput-new">Change image</span>';
        $output.='<span class="fileinput-exists">Change</span>';
        $output.='<input type="file" name="e_vis_image" accept=".jpg,.jpeg,.png" />';
        $output.=' </span>';
        $output.='<a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput">';
        $output.='<i class="fa fa-times"></i> Remove</a>';
        $output.=' </div>';
        $output.=' </div>';
        $output.='<div class="form-check">';
        $output.='<div class="col-sm-10 checkbox-radios">';
        $output.='<div class="form-check form-check-inline">';
        $output.='<label class="form-check-label">';
        $output.='<input class="form-check-input" type="radio" name="e_vis_status"'.$echeck.' value="yes"> Enabled';
        $output.='<span class="circle">';
        $output.=' <span class="check"></span>';
        $output.='</span>';
        $output.='</label>';
        $output.='</div>';
        $output.='<div class="form-check form-check-inline">';
        $output.='<label class="form-check-label">';
        $output.='<input class="form-check-input" type="radio" name="e_vis_status"'.$ncheck.' value="no"> Disabled';
        $output.='<span class="circle">';
        $output.=' <span class="check"></span>';
        $output.='</span>';
        $output.='</label>';
        $output.='</div>';
        $output.='</div>';
        $output.='</div>';
        $output.='<div class="progress md-progress" style="display: none;height: 10px">';
        $output.='<div class="progress-bar bg-danger" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>';
        $output.='</div>';
        $output.='<div class="card-footer ">';
        $output.='<button type="submit" class="btn btn-fill btn-danger editvis-btn">update</button>';
        $output.='</div>';
        $output.='</form>';
         $output.='</div>';
        $output.='<script type="text/javascript">';
        $output.=' var response_form = $("form.editvis-form"), response_btn = $("button.editvis-btn"), loader_white =  "<span class=spinner-border spinner-border-sm text-white></span>";';
        $output.='response_form.on("submit",function(rf){';
        $output.='rf.preventDefault();';
        $output.='$("div.progress").show("fadeInUp");';
        $output.='$.ajax({';
        $output.='xhr: function() {';
        $output.=' var xhr = new window.XMLHttpRequest();';
        $output.='xhr.upload.addEventListener("progress", function(evt) {';
        $output.='if (evt.lengthComputable) {';
        $output.='var percentComplete = ((evt.loaded / evt.total) * 100);';
        $output.='$(".progress-bar").width(percentComplete + "%");';
        $output.=' $(".progress-bar").html(percentComplete+"%");';
        $output.=' }';
        $output.='}, false);';
        $output.='return xhr;';
        $output.='},';
        $output.='url: "/admin-cp/processor.php",';
        $output.='type: "POST",';
        $output.='data:  new FormData(this),';
        $output.='contentType: false,';
        $output.='cache: false,';
        $output.='processData:false,';
        $output.='beforeSend : function()';
        $output.='{response_btn.html("Processing "+loader_white);},';
        $output.='success: function(data){response_form.after(data);response_btn.text("Update");}';
       $output.='});';
        $output.='});';
        $output.='</script>';
      
       
      }
      echo $output;
  }
  //update visa type
  elseif (isset($_POST['visid'])) {
     $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }
       $id = $_POST['visid'];
       $image = $_POST['visimage'];

        if (empty($id) || empty($image)) {
      echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry. $sid',
       position: 'bottomRight'  });</script>";
       exit();
      }

      $id = encode($id,'d');
      $image = encode($image,'d');

      $name = test_input($_POST['e_vis_name']);
      $status = test_input($_POST['e_vis_status']);

      if (empty($name)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Visa type name can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
        
         if (empty($status)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Please select a status, to continue',
       position: 'bottomRight'  });</script>";
       exit();
       }
      if(is_uploaded_file($_FILES['e_vis_image']['tmp_name'])){


       $pathResponse = newSingleUpload($_FILES['e_vis_image'],'image','visa','');

        $response = array(1,2,3,4,5,'');

          if (in_array($pathResponse, $response)) {
    switch ($pathResponse) {
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
      case '':
         $c_title = "Image Required";
      $c_message = "Please upload an image for your visa application type";
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

    unlink("../assets/images/visas/$image");

      }else{
        $pathResponse = $image;
      }

      $sql = "UPDATE ng_visas SET name = ?, image = ?, enabled = ? WHERE id = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('sssi',$name,$pathResponse,$status,$id);
      $stmt->execute();

      if ($stmt->affected_rows == 1) {
       echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Visa type updated successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'No changes were made., reload page and retry if you think it is an error.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
  // course form
  elseif (isset($_POST['cs_name'])) {
     $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }
       $name = test_input($_POST['cs_name']);
       $description = test_input($_POST['cs_des']);
       $status = test_input($_POST['cs_status']);

       if (empty($name)) {
         echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Course name is required',
       position: 'bottomRight'  });</script>";
       exit();
       }
       if (empty($description)) {
         echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Course description is required',
       position: 'bottomRight'  });</script>";
       exit();
       }

       if (empty($status)) {
         echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Select a status for your course',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $sql = "INSERT INTO ng_courses (name,description,enabled) VALUES(?,?,?)";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('sss',$name,$description,$status);
       $stmt->execute();

       if ($stmt->affected_rows == 1) {
          echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Course added successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
       }else{
        echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
       }

  }
  //delete course
  elseif (isset($_POST['delcourse'])) {
    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

       $id = $_POST['delcourse'];

       if (empty(trim($id))) {
          echo "<script> iziToast.warning({
       title: 'Unknown Error!',
       message: 'An error occured. Reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $id = encode($id,'d');

       $sql = "DELETE FROM ng_courses WHERE id = ?";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('i',$id);
       $stmt->execute();

       if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Course deleted successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
  //edit course
  elseif (isset($_POST['editcourse'])) {
     $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

    $id = $_POST['editcourse'];

     if (empty($id)) {
      echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
      $id = encode($id,'d');

      $sql = "SELECT * FROM ng_courses WHERE id = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('i',$id);
      $stmt->execute();
      $res = $stmt->get_result();

      $output = "";
      while ($row = $res->fetch_assoc()) {
      $checked = $row['enabled'];
      if ($checked == 'yes') {
       $echeck = "checked";
       $ncheck = "";
      }else{
         $echeck = "";
       $ncheck = "checked";
      }

        $output.='<div class="modal-header text-center">';
        $output.='<h4 class="modal-title w-100 font-weight-bold">'.test_output($row["name"]).'</h4>';
        $output.='<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        $output.='<span aria-hidden="true">&times;</span>';
        $output.='</button>';
        $output.='</div>';
        $output.='<div class="modal-body mx-3">';
        $output.='<form method="post" class="editcourse-form" enctype="multipart/form-data">';
        $output.=' <div class="form-group">';
         $output.='<input type="hidden" name="csid" value="'.encode($row["id"],"e").'">';
        $output.='<label for="e_cs_name" class="bmd-label-floating">Name <small>e.g computer science</small></label>';
         $output.='<input type="text" class="form-control" value="'.test_output($row["name"]).'" name="e_cs_name"  id="e_cs_name">';
        $output.='</div>';
       $output.=' <div class="form-group">';
        $output.='<label for="e_cs_des" class="bmd-label-floating">Description <small>e.g edit description</small></label>';
         $output.='<textarea rows="3" class="form-control" name="e_cs_des"  id="e_cs_des">'.test_output($row["description"]).'</textarea>';
        $output.='</div>';
        $output.='<div class="form-check">';
        $output.='<div class="col-sm-10 checkbox-radios">';
        $output.='<div class="form-check form-check-inline">';
        $output.='<label class="form-check-label">';
        $output.='<input class="form-check-input" type="radio" name="e_cs_status"'.$echeck.' value="yes"> Enabled';
        $output.='<span class="circle">';
        $output.=' <span class="check"></span>';
        $output.='</span>';
        $output.='</label>';
        $output.='</div>';
        $output.='<div class="form-check form-check-inline">';
        $output.='<label class="form-check-label">';
        $output.='<input class="form-check-input" type="radio" name="e_cs_status"'.$ncheck.' value="no"> Disabled';
        $output.='<span class="circle">';
        $output.=' <span class="check"></span>';
        $output.='</span>';
        $output.='</label>';
        $output.='</div>';
        $output.='</div>';
        $output.='</div>';
        $output.='<div class="progress md-progress" style="display: none;height: 10px">';
        $output.='<div class="progress-bar bg-danger" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>';
        $output.='</div>';
        $output.='<div class="card-footer ">';
        $output.='<button type="submit" class="btn btn-fill btn-danger editcourse-btn">update</button>';
        $output.='</div>';
        $output.='</form>';
         $output.='</div>';
        $output.='<script type="text/javascript">';
        $output.=' var response_form = $("form.editcourse-form"), response_btn = $("button.editcourse-btn"), loader_white =  "<span class=spinner-border spinner-border-sm text-white></span>";';
        $output.='response_form.on("submit",function(rf){';
        $output.='rf.preventDefault();';
        $output.='response_btn.html("Processing "+loader_white);';
        $output.='$.post("/admin-cp/processor.php", response_form.serialize(), function(data){';
        $output.='response_form.after(data);';
        $output.='response_btn.text("Update");';
       $output.='});';
        $output.='});';
        $output.='</script>';
      
       
      }
      echo $output;
  }
  //update course details
  elseif (isset($_POST['csid'])) {
    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }
       $id = $_POST['csid'];

        if (empty($id)) {
      echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry. $sid',
       position: 'bottomRight'  });</script>";
       exit();
      }

      $id = encode($id,'d');

      $name = test_input($_POST['e_cs_name']);
      $description = test_input($_POST['e_cs_des']);
      $status = test_input($_POST['e_cs_status']);

      if (empty($name)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Course name can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }

       if (empty($description)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Course description can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
         
         if (empty($status)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Please select a status, to continue',
       position: 'bottomRight'  });</script>";
       exit();
       }

      $sql = "UPDATE ng_courses SET name = ?, description = ?, enabled = ? WHERE id = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('sssi',$name,$description,$status,$id);
      $stmt->execute();

      if ($stmt->affected_rows == 1) {
       echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Course updated successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'No changes were made. Reload page and retry if you think it is an error.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
  // school form
  elseif (isset($_POST['school_name'])) {
     $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }
       $name = test_input($_POST['school_name']);
       $slug = test_input($_POST['school_slug']);
       $description = test_input($_POST['school_des']);
       $location = test_input($_POST['school_loc']);
       $courses = $_POST['school_courses'];
       $status = test_input($_POST['school_status']);

        if (empty($name)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'School name can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
       if (empty($slug)) {
           echo "<script> iziToast.warning({
       title: 'Slug Error!',
       message: 'An error occured while fetching slug. Reload page and retry',
       position: 'bottomRight'  });</script>";
       exit();
       }
       if (empty($description)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'School description can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
       if (empty($location)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'School Address can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
       if (empty($courses)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Please select one or more courses offered in the school',
       position: 'bottomRight'  });</script>";
       exit();
       }
      
       if (empty($status)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Select a status to continue',
       position: 'bottomRight'  });</script>";
       exit();
       }


       $pathResponse = newSingleUpload($_FILES['school_image'],'image','school','');

        $response = array(1,2,3,4,5,'');

          if (in_array($pathResponse, $response)) {
    switch ($pathResponse) {
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
      $c_message = "Your main school image is larger than the maximum of 2MB";
      break;
      case 5:
      $c_title = "Upload Error";
      $c_message = "Could not move file to destination folder. contact support";
      break;
      case '':
         $c_title = "Image Required";
      $c_message = "Please upload an image for your school";
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

      $attached = "";
       if (array_sum($_FILES['school_images']['size']) > 0) {

         $ofile = $_FILES['school_images'];
         $file_desc = multipleUpload($ofile);

         foreach($file_desc as $val){

           $ofileName = $val['name'];
           $ofileTmpName = $val['tmp_name'];
           $ofileSize= $val['size'];
           $ofileError = $val['error'];
           $ofileType = $val['type'];

           $ofileExt = explode('.', $ofileName);
           $ofileActualExt = strtolower(end($ofileExt));

           $oallowed = array('jpg', 'png', 'jpeg');

           if (in_array($ofileActualExt, $oallowed)) {
             if ($ofileError === 0) {
               if ($ofileSize < 10485760){
                 $ofileNameNew = date('Ymdhis',time()).mt_rand().".".$ofileActualExt;
                 $ofileDestination = '../assets/images/schools/gallery/'.$ofileNameNew;
                 move_uploaded_file($ofileTmpName, $ofileDestination);

                 $attached .= "$ofileNameNew,";

               } else{ 
                  echo "<script> iziToast.warning({
                   title: 'File Size!',
                    message: 'One or more file is/are larger the maximum of 10MB',
                    position: 'bottomRight'  });</script>";
                    exit(); 
               }
             }
             else {
              echo "<script> iziToast.warning({
                   title: 'File Error!',
                    message: 'There was an error uploading one or more files',
                    position: 'bottomRight'  });</script>";
                    exit(); 
             }
           } else {
            echo "<script> iziToast.warning({
                   title: 'Unsupoorted file!',
                    message: 'One or more files uploaded appears not be an image. png, jpg and jpeg files only',
                    position: 'bottomRight'  });</script>";
                    exit(); 
           }
         }


       }
       $c="";
       foreach ($courses as $course) {
         $c .="$course,";
       }
       $c = trim($c,",");
        $nslug = checkSlug($slug);

    if ($nslug == true) {
      $slug = $slug.'-'.date('Y').time();
    }
       $sql = "INSERT INTO ng_schools (cid,images,name,description,slug,image,location,enabled) VALUES (?,?,?,?,?,?,?,?)";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('ssssssss',$c,$attached,$name,$description,$slug,$pathResponse,$location,$status);
       $stmt->execute();

        if ($stmt->affected_rows == 1) {
       echo "<script> iziToast.success({
          title: 'Success!',
          message: 'School added successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured. Reload page and retry',
       position: 'bottomRight'  });</script>";
       exit();
      }

  }
  //delete school
  elseif (isset($_POST['delschool'])) {
    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

       $id = $_POST['delschool'];

       if (empty($id)) {
          echo "<script> iziToast.warning({
       title: 'Unknown Error!',
       message: 'An error occured. Reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $id = encode($id,'d');

       $pql = "SELECT images,image FROM ng_schools WHERE id = ?";
       $pstmt = $db->prepare($pql);
       $pstmt->bind_param('i',$id);
       $pstmt->execute();
       $pstmt->Store_result();
       $pstmt->bind_result($images,$image);
       $pstmt->fetch();

       if (!empty($images)) {
         $images = explode(',', $images);
         foreach ($images as $key) {
           unlink("../assets/images/schools/gallery/$key");
         }
       }

       unlink("../assets/images/schools/$image");

       $sql = "DELETE FROM ng_schools WHERE id = ?";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('i',$id);
       $stmt->execute();

       if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'School deleted successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
  //edit school
  elseif (isset($_POST['school_id'])) {
    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }
       $id = $_POST['school_id'];
       $image = $_POST['schoolimage'];


       if (empty($id) || empty($image)) {
      echo "<script> iziToast.warning({
        title: 'Unknown Error!',
        message: 'An error occured. reload page and retry',
        position: 'bottomRight'  });</script>";
        exit();
    }

    $id = encode($id,'d');
    $image = encode($image,'d');


       $name = test_input($_POST['e_school_name']);
       $description = test_input($_POST['e_school_des']);
       $location = test_input($_POST['e_school_loc']);
       $courses = $_POST['e_school_courses'];
       $status = test_input($_POST['e_school_status']);


        if (empty($name)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'School name can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
       
       if (empty($description)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'School description can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
       if (empty($location)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'School Address can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
       if (empty($courses)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Please select one or more courses offered in the school',
       position: 'bottomRight'  });</script>";
       exit();
       }
      
       if (empty($status)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Select a status to continue',
       position: 'bottomRight'  });</script>";
       exit();
       }
          if(is_uploaded_file($_FILES['e_school_image']['tmp_name'])){


       $pathResponse = newSingleUpload($_FILES['e_school_image'],'image','school','');

        $response = array(1,2,3,4,5,'');

          if (in_array($pathResponse, $response)) {
    switch ($pathResponse) {
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
      $c_message = "Your main school image is larger than the maximum of 2MB";
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

    unlink("../assets/images/schools/$image");

      }else{
        $pathResponse = $image;
      }


           $attached = "";

        if (isset($_POST['del_others'])) {
           $delold = $_POST['del_others'];
          
          if ($delold == 'yes') {
            $arr = encode($_POST['schoolimages'],'d');
            $arr = trim($arr,",");
            $arr = explode(',', $arr);
            foreach ($arr as $key) {
             unlink("../assets/images/schools/gallery/$key");
            }
          }else{
            $attached = encode($_POST['schoolimages'],'d');
          }
        }
       if (array_sum($_FILES['e_school_images']['size']) > 0) {

         $ofile = $_FILES['e_school_images'];
         $file_desc = multipleUpload($ofile);

         foreach($file_desc as $val){

           $ofileName = $val['name'];
           $ofileTmpName = $val['tmp_name'];
           $ofileSize= $val['size'];
           $ofileError = $val['error'];
           $ofileType = $val['type'];

           $ofileExt = explode('.', $ofileName);
           $ofileActualExt = strtolower(end($ofileExt));

           $oallowed = array('jpg', 'png', 'jpeg');

           if (in_array($ofileActualExt, $oallowed)) {
             if ($ofileError === 0) {
               if ($ofileSize < 10485760){
                 $ofileNameNew = date('Ymdhis',time()).mt_rand().".".$ofileActualExt;
                 $ofileDestination = '../assets/images/schools/gallery/'.$ofileNameNew;
                 move_uploaded_file($ofileTmpName, $ofileDestination);

                 $attached .= "$ofileNameNew,";

               } else{ 
                  echo "<script> iziToast.warning({
                   title: 'File Size!',
                    message: 'One or more file is/are larger the maximum of 10MB',
                    position: 'bottomRight'  });</script>";
                    exit(); 
               }
             }
             else {
              echo "<script> iziToast.warning({
                   title: 'File Error!',
                    message: 'There was an error uploading one or more files',
                    position: 'bottomRight'  });</script>";
                    exit(); 
             }
           } else {
            echo "<script> iziToast.warning({
                   title: 'Unsupoorted file!',
                    message: 'One or more files uploaded appears not be an image. png, jpg and jpeg files only',
                    position: 'bottomRight'  });</script>";
                    exit(); 
           }
         }


       }

       $c="";
       foreach ($courses as $course) {
         $c .="$course,";
       }
       $c = trim($c,",");

       $sql = "UPDATE ng_schools SET cid = ?, images = ?,  name = ?, description = ?, image = ?, location = ? , enabled = ? WHERE id = ?";

       $stmt = $db->prepare($sql);
       $stmt->bind_param('sssssssi',$c,$attached,$name,$description,$pathResponse,$location,$status,$id);
       $stmt->execute();

       if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'School details updated successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.replace('/admin-cp/school/manage');}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }

  }
  //review management
  elseif (isset($_POST['revid'])) {
    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }
       $id = $_POST['revid'];

       if (empty($id)) {
      echo "<script> iziToast.warning({
        title: 'Unknown Error!',
        message: 'An error occured. reload page and retry',
        position: 'bottomRight'  });</script>";
        exit();
    }

    $id = encode($id,'d');

    $role = $_POST['role'];

    if ($role == 'approve') {

        $sql = "UPDATE ng_reviews SET enabled = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $enabled = 'yes';
        $stmt->bind_param('si',$enabled,$id);
        $stmt->execute();
         if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Review approved successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }
      
    }elseif ($role == 'disable') {
       $sql = "UPDATE ng_reviews SET enabled = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $enabled = 'no';
        $stmt->bind_param('si',$enabled,$id);
        $stmt->execute();
      if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Review disabled successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }
    }elseif ($role == 'delete') {
       $sql = "DELETE FROM ng_reviews WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i',$id);
        $stmt->execute();
       if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Review deleted successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }
    }else{
       echo "<script> iziToast.warning({
        title: 'Unknown Error!',
        message: 'An error occured. reload page and retry',
        position: 'bottomRight'  });</script>";
        exit();
    }
  }
  // services form
  elseif (isset($_POST['ser_name'])) {

    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

   $name = test_input($_POST['ser_name']);
   $icon = test_input($_POST['ser_icon']);
   $description = test_input($_POST['ser_des']);
   $status = test_input($_POST['ser_status']);


        if (empty($name)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Service name can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
       if (empty($icon)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'An icon for your service',
       position: 'bottomRight'  });</script>";
       exit();
       }
       if (empty($description)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Service description can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
       if (empty($status)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Service status can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $sql = "INSERT INTO ng_services (title,icon,description,enabled) VALUES (?,?,?,?)";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('ssss',$name,$icon,$description,$status);
       $stmt->execute();
        if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Service added successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }
    else{
       echo "<script> iziToast.warning({
        title: 'Unknown Error!',
        message: 'An error occured. reload page and retry',
        position: 'bottomRight'  });</script>";
        exit();
    }

  }
  // delete service
  elseif (isset($_POST['delservice'])) {
        $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

       $id = $_POST['delservice'];

       if (empty(trim($id))) {
          echo "<script> iziToast.warning({
       title: 'Unknown Error!',
       message: 'An error occured. Reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $id = encode($id,'d');

       $sql = "DELETE FROM ng_services WHERE id = ?";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('i',$id);
       $stmt->execute();

       if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Service deleted successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
  //edit service
  elseif (isset($_POST['editservice'])) {
     $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

    $id = $_POST['editservice'];

     if (empty($id)) {
      echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
      $id = encode($id,'d');

      $sql = "SELECT * FROM ng_services WHERE id = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('i',$id);
      $stmt->execute();
      $res = $stmt->get_result();

      $output = "";
      while ($row = $res->fetch_assoc()) {
      $checked = $row['enabled'];
      if ($checked == 'yes') {
       $echeck = "checked";
       $ncheck = "";
      }else{
         $echeck = "";
       $ncheck = "checked";
      }

        $output.='<div class="modal-header text-center">';
        $output.='<h4 class="modal-title w-100 font-weight-bold">'.test_output($row["title"]).'</h4>';
        $output.='<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        $output.='<span aria-hidden="true">&times;</span>';
        $output.='</button>';
        $output.='</div>';
        $output.='<div class="modal-body mx-3">';
        $output.='<form method="post" class="editservice-form" enctype="multipart/form-data">';
        $output.=' <div class="form-group">';
         $output.='<input type="hidden" name="esid" value="'.encode($row["id"],"e").'">';
        $output.='<label for="e_ser_name" class="bmd-label-floating">Name <small>e.g Test preparation</small></label>';
         $output.='<input type="text" class="form-control" value="'.test_output($row["title"]).'" name="e_ser_name"  id="e_ser_name">';
        $output.='</div>';
         $output.=' <div class="form-group">';
        $output.='<label for="e_ser_icon" class="bmd-label-floating">Icon <small>e.g book-open</small></label>';
         $output.='<input type="text" class="form-control" value="'.test_output($row["icon"]).'" name="e_ser_icon"  id="e_ser_icon">';
        $output.='</div>';
       $output.=' <div class="form-group">';
        $output.='<label for="e_ser_des" class="bmd-label-floating">Description <small>e.g edit description</small></label>';
         $output.='<textarea rows="3" class="form-control" name="e_ser_des"  id="e_ser_des">'.test_output($row["description"]).'</textarea>';
        $output.='</div>';
        $output.='<div class="form-check">';
        $output.='<div class="col-sm-10 checkbox-radios">';
        $output.='<div class="form-check form-check-inline">';
        $output.='<label class="form-check-label">';
        $output.='<input class="form-check-input" type="radio" name="e_ser_status"'.$echeck.' value="yes"> Enabled';
        $output.='<span class="circle">';
        $output.=' <span class="check"></span>';
        $output.='</span>';
        $output.='</label>';
        $output.='</div>';
        $output.='<div class="form-check form-check-inline">';
        $output.='<label class="form-check-label">';
        $output.='<input class="form-check-input" type="radio" name="e_ser_status"'.$ncheck.' value="no"> Disabled';
        $output.='<span class="circle">';
        $output.=' <span class="check"></span>';
        $output.='</span>';
        $output.='</label>';
        $output.='</div>';
        $output.='</div>';
        $output.='</div>';
        $output.='<div class="card-footer ">';
        $output.='<button type="submit" class="btn btn-fill btn-danger editservice-btn">update</button>';
        $output.='</div>';
        $output.='</form>';
         $output.='</div>';
        $output.='<script type="text/javascript">';
        $output.=' var response_form = $("form.editservice-form"), response_btn = $("button.editservice-btn"), loader_white =  "<span class=spinner-border spinner-border-sm text-white></span>";';
        $output.='response_form.on("submit",function(rf){';
        $output.='rf.preventDefault();';
        $output.='response_btn.html("Processing "+loader_white);';
        $output.='$.post("/admin-cp/processor.php", response_form.serialize(), function(data){';
        $output.='response_form.after(data);';
        $output.='response_btn.text("Update");';
       $output.='});';
        $output.='});';
        $output.='</script>';
      
       
      }
      echo $output;
  }
  // update service
  elseif (isset($_POST['esid'])) {
     $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }
       $id = $_POST['esid'];

        if (empty($id)) {
      echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry. $sid',
       position: 'bottomRight'  });</script>";
       exit();
      }

      $id = encode($id,'d');

      $name = test_input($_POST['e_ser_name']);
      $icon = test_input($_POST['e_ser_icon']);
      $description = test_input($_POST['e_ser_des']);
      $status = test_input($_POST['e_ser_status']);

      if (empty($name)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Service name can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
if (empty($icon)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Service icon can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }

       if (empty($description)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Service description can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
         
         if (empty($status)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Please select a status, to continue',
       position: 'bottomRight'  });</script>";
       exit();
       }

      $sql = "UPDATE ng_services SET title = ?, icon = ?, description = ?, enabled = ? WHERE id = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('ssssi',$name,$icon,$description,$status,$id);
      $stmt->execute();

      if ($stmt->affected_rows == 1) {
       echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Service updated successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'No changes were made. Reload page and retry if you think it is an error.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
  // services category form
  elseif (isset($_POST['cat_name'])) {

    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

   $name = test_input($_POST['cat_name']);
   $service = $_POST['cat_service'];
   $status = test_input($_POST['cat_status']);


        if (empty($name)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Category name can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
    
       if (empty($service)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Select a service category',
       position: 'bottomRight'  });</script>";
       exit();
       }
       if (empty($status)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Category status can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $service = encode($service,'d');

       $sql = "INSERT INTO ng_service_category (sid,name,enabled) VALUES (?,?,?)";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('iss',$service,$name,$status);
       $stmt->execute();
        if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Category added successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }
    else{
       echo "<script> iziToast.warning({
        title: 'Unknown Error!',
        message: 'An error occured. reload page and retry',
        position: 'bottomRight'  });</script>";
        exit();
    }

  }
  // delete service category
  elseif (isset($_POST['delcategory'])) {
        $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

       $id = $_POST['delcategory'];

       if (empty(trim($id))) {
          echo "<script> iziToast.warning({
       title: 'Unknown Error!',
       message: 'An error occured. Reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $id = encode($id,'d');

       $sql = "DELETE FROM ng_service_category WHERE id = ?";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('i',$id);
       $stmt->execute();

       if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Category deleted successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
  //edit service category
  elseif (isset($_POST['editcategory'])) {
     $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

    $id = $_POST['editcategory'];

     if (empty($id)) {
      echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
      $id = encode($id,'d');

      $sql = "SELECT * FROM ng_service_category WHERE id = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('i',$id);
      $stmt->execute();
      $res = $stmt->get_result();

      $output = "";
      while ($row = $res->fetch_assoc()) {
      $checked = $row['enabled'];
      if ($checked == 'yes') {
       $echeck = "checked";
       $ncheck = "";
      }else{
         $echeck = "";
       $ncheck = "checked";
      }

        $output.='<div class="modal-header text-center">';
        $output.='<h4 class="modal-title w-100 font-weight-bold">'.test_output($row["name"]).'</h4>';
        $output.='<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        $output.='<span aria-hidden="true">&times;</span>';
        $output.='</button>';
        $output.='</div>';
        $output.='<div class="modal-body mx-3">';
        $output.='<form method="post" class="editcategory-form" enctype="multipart/form-data">';
        $output.=' <div class="form-group mb-5">';
         $output.='<input type="hidden" name="catid" value="'.encode($row["id"],"e").'">';
        $output.=' <label for="e_cat_service"class="bmd-label-floating" >Edit Service </label>';
         $output.='<select class=" form-control mt-3" data-size="3"  data-style=" select-with-transition" title="Select service" id="e_cat_service" required name="e_cat_service">';
         $fql = "SELECT * FROM ng_services WHERE enabled = ?";
                   $fstmt = $db->prepare($fql);
                   $enabled = 'yes';
                   $fstmt->bind_param('s',$enabled);
                   $fstmt->execute();
                   $fres = $fstmt->get_result();
                   while($frow = $fres->fetch_assoc()) :
                    if ($frow['id'] == $row['sid']) {
                      $selected = "selected";
                    }
                    else{
                      $selected = "";
                    }
         $output.='<option  value="'.encode($frow["id"]).'" '.$selected.'>'.test_output($frow["title"]) .'</option>';
       endwhile;
         $output.='</select>';
        $output.='</div>';
         $output.=' <div class="form-group" >';
        $output.='<label for="e_cat_name" class="bmd-label-floating">Name <small>e.g edit name</small></label>';
         $output.='<input type="text" class="form-control" value="'.test_output($row["name"]).'" name="e_cat_name"  id="e_cat_name">';
        $output.='</div>';
        $output.='<div class="form-check">';
        $output.='<div class="col-sm-10 checkbox-radios">';
        $output.='<div class="form-check form-check-inline">';
        $output.='<label class="form-check-label">';
        $output.='<input class="form-check-input" type="radio" name="e_cat_status"'.$echeck.' value="yes"> Enabled';
        $output.='<span class="circle">';
        $output.=' <span class="check"></span>';
        $output.='</span>';
        $output.='</label>';
        $output.='</div>';
        $output.='<div class="form-check form-check-inline">';
        $output.='<label class="form-check-label">';
        $output.='<input class="form-check-input" type="radio" name="e_cat_status"'.$ncheck.' value="no"> Disabled';
        $output.='<span class="circle">';
        $output.=' <span class="check"></span>';
        $output.='</span>';
        $output.='</label>';
        $output.='</div>';
        $output.='</div>';
        $output.='</div>';
        $output.='<div class="card-footer ">';
        $output.='<button type="submit" class="btn btn-fill btn-danger editcategory-btn">update</button>';
        $output.='</div>';
        $output.='</form>';
         $output.='</div>';
        $output.='<script type="text/javascript">';
        $output.=' var response_form = $("form.editcategory-form"), response_btn = $("button.editcategory-btn"), loader_white =  "<span class=spinner-border spinner-border-sm text-white></span>";';
        $output.='response_form.on("submit",function(rf){';
        $output.='rf.preventDefault();';
        $output.='response_btn.html("Processing "+loader_white);';
        $output.='$.post("/admin-cp/processor.php", response_form.serialize(), function(data){';
        $output.='response_form.after(data);';
        $output.='response_btn.text("Update");';
       $output.='});';
        $output.='});';
        $output.='</script>';
      
       
      }
      echo $output;
  }
  // update service
  elseif (isset($_POST['catid'])) {
     $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }
       $id = $_POST['catid'];

        if (empty($id)) {
      echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry. $sid',
       position: 'bottomRight'  });</script>";
       exit();
      }

      $id = encode($id,'d');

      $name = test_input($_POST['e_cat_name']);
      $service = $_POST['e_cat_service'];
      $status = test_input($_POST['e_cat_status']);

      if (empty($name)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Category name can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
if (empty($service)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Select a service to continue',
       position: 'bottomRight'  });</script>";
       exit();
       }
$service = encode($service,'d');
       
         if (empty($status)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Please select a status, to continue',
       position: 'bottomRight'  });</script>";
       exit();
       }

      $sql = "UPDATE ng_service_category SET sid = ?, name = ?, enabled = ? WHERE id = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('sssi',$service,$name,$status,$id);
      $stmt->execute();

      if ($stmt->affected_rows == 1) {
       echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Category updated successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'No changes were made. Reload page and retry if you think it is an error.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
  //service bookings update
  elseif (isset($_POST['servid'])) {
     $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }
       $id = $_POST['servid'];

       if (empty($id)) {
      echo "<script> iziToast.warning({
        title: 'Unknown Error!',
        message: 'An error occured. reload page and retry',
        position: 'bottomRight'  });</script>";
        exit();
    }

    $id = encode($id,'d');

    $role = $_POST['role'];
    $name = $_POST['name'];
    $service = $_POST['service'];
    $category = $_POST['category'];
    $email = $_POST['email'];

    if ($role == 'reviewing') {

        $sql = "UPDATE ng_bookings SET status = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $status = 'reviewing';
        $stmt->bind_param('si',$status,$id);
        $stmt->execute();
         if ($stmt->affected_rows ==1) {
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
   $mail->addAddress($email, $name);    
   $mail->addReplyTo('customer-support@colorbrace.com', 'Naamglobal Services'); 

   $mail->isHTML(true);
   $mail->Subject = 'Booking Status Update';
   $mail->Body    = 'Hello '. $name. ' , Your service booking for '.$service. ' in '.$category. ' has been updated to be on <b>review</b>. Be sure to keep an eye on your email and phone. We will regularly contact you through this medium for further processing. Thank you';
   $mail->AltBody = 'Hello '. $name. ' , Your service booking for '.$service. ' in '.$category. ' has been updated to be on review. Be sure to keep an eye on your email and phone. We will regularly contact you through this medium for further processing. Thank you';

  if ($mail->send()) {

         echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Booking status updated successfully. Email Notification sent to user, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
        }
      } catch (Exception $e) {
        
   echo "<script> iziToast.warning({
      title: 'Mail error!',
      message: 'An error occured while sending confirmation email to $email. Quote error information when you contact us. <em>Mailer Error: {$mail->ErrorInfo}</em>',
      position: 'bottomRight'  });</script>";
      }

       
      }
      
    }elseif ($role == 'processing') {
       $sql = "UPDATE ng_bookings SET status = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $status = 'processing';
        $stmt->bind_param('si',$status,$id);
        $stmt->execute();
      if ($stmt->affected_rows ==1) {
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
   $mail->addAddress($email, $name);    
   $mail->addReplyTo('customer-support@colorbrace.com', 'Naamglobal Services'); 

   $mail->isHTML(true);
   $mail->Subject = 'Booking Status Update';
   $mail->Body    = 'Hello '. $name. ' , Your service booking for '.$service. ' in '.$category. ' has been updated to <b>processing</b>. Be sure to keep an eye on your email and phone. We will regularly contact you through this medium for further processing. Thank you';
   $mail->AltBody = 'Hello '. $name. ' , Your service booking for '.$service. ' in '.$category. ' has been updated to processing. Be sure to keep an eye on your email and phone. We will regularly contact you through this medium for further processing. Thank you';

  if ($mail->send()) {

         echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Booking status updated successfully. Email Notification sent to to user. reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
        }
      } catch (Exception $e) {
        
   echo "<script> iziToast.warning({
      title: 'Mail error!',
      message: 'An error occured while sending confirmation email to $email. Quote error information when you contact us. <em>Mailer Error: {$mail->ErrorInfo}</em>',
      position: 'bottomRight'  });</script>";
      }

      }
    }elseif ($role == 'completed') {
       $sql = "UPDATE ng_bookings SET status = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $status = 'completed';
        $stmt->bind_param('si',$status,$id);
        $stmt->execute();
      if ($stmt->affected_rows ==1) {
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
   $mail->addAddress($email, $name);    
   $mail->addReplyTo('customer-support@colorbrace.com', 'Naamglobal Services'); 

   $mail->isHTML(true);
   $mail->Subject = 'Booking Status Update';
   $mail->Body    = 'Hello '. $name. ' , Your service booking for '.$service. ' in '.$category. ' has been <b>completed</b>. Be sure to keep an eye on your email and phone. Further instructions will be sent regarding this service. Thank you';
   $mail->AltBody = 'Hello '. $name. ' , Your service booking for '.$service. ' in '.$category. ' has been completed. Be sure to keep an eye on your email and phone. Further instructions will be sent regarding this service. Thank you';

  if ($mail->send()) {

         echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Booking status updated successfully. Email Notification sent to to user. reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
        }
      } catch (Exception $e) {
        
   echo "<script> iziToast.warning({
      title: 'Mail error!',
      message: 'An error occured while sending confirmation email to $email. Quote error information when you contact us. <em>Mailer Error: {$mail->ErrorInfo}</em>',
      position: 'bottomRight'  });</script>";
      }

      }
    }elseif ($role == 'cancelled') {
       $sql = "UPDATE ng_bookings SET status = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $status = 'cancelled';
        $stmt->bind_param('si',$status,$id);
        $stmt->execute();
      if ($stmt->affected_rows ==1) {
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
   $mail->addAddress($email, $name);    
   $mail->addReplyTo('customer-support@colorbrace.com', 'Naamglobal Services'); 

   $mail->isHTML(true);
   $mail->Subject = 'Booking Status Update';
   $mail->Body    = 'Hello '. $name. ' , Your service booking for '.$service. ' in '.$category. ' has been <b>cancelled</b>. A number of reasons led to the cancellation of your service. Try again next time. Thank you';
   $mail->AltBody = 'Hello '. $name. ' , Your service booking for '.$service. ' in '.$category. ' has been cancelled. A number of reasons led to the cancellation of your service. Try again next time. Thank you';

  if ($mail->send()) {

         echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Booking status updated successfully. Email Notification sent to to user. reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
        }
      } catch (Exception $e) {
        
   echo "<script> iziToast.warning({
      title: 'Mail error!',
      message: 'An error occured while sending confirmation email to $email. Quote error information when you contact us. <em>Mailer Error: {$mail->ErrorInfo}</em>',
      position: 'bottomRight'  });</script>";
      }

      }
    }else{
       echo "<script> iziToast.warning({
        title: 'Unknown Error!',
        message: 'An error occured. reload page and retry',
        position: 'bottomRight'  });</script>";
        exit();
    }
  }
  //blog form
   elseif (isset($_POST['blog_title'])) {
    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }
       $name = test_input($_POST['blog_title']);
       $slug = test_input($_POST['blog_slug']);
       $excerpt = test_input($_POST['blog_excerpt']);
       $body = test_input($_POST['blog_body']);
       $status = test_input($_POST['blog_status']);

        if (empty($name)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Blog title can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
       if (empty($slug)) {
           echo "<script> iziToast.warning({
       title: 'Slug Error!',
       message: 'An error occured while fetching slug. Reload page and retry',
       position: 'bottomRight'  });</script>";
       exit();
       }
       if (empty($excerpt)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Blog excerpt can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }

       if (strlen($_POST['blog_excerpt']) > 250) {
         echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Blog excerpt should be less than 250 characters',
       position: 'bottomRight'  });</script>";
       exit();
       }
       if (empty($body)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Blog message body can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
      
       if (empty($status)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Select a status to continue',
       position: 'bottomRight'  });</script>";
       exit();
       }


       $pathResponse = newSingleUpload($_FILES['blog_image'],'image','blog','');

        $response = array(1,2,3,4,5,'');

          if (in_array($pathResponse, $response)) {
    switch ($pathResponse) {
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
      $c_message = "Blog image is larger than the maximum of 2MB";
      break;
      case 5:
      $c_title = "Upload Error";
      $c_message = "Could not move file to destination folder. contact support";
      break;
      case '':
         $c_title = "Image Required";
      $c_message = "Please upload an image for your blog post";
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

        $nslug = checkSlug($slug);

    if ($nslug == true) {
      $slug = $slug.'-'.date('Y').time();
    }
       $sql = "INSERT INTO ng_blog (title,slug,excerpt,description,image,date_created,status) VALUES (?,?,?,?,?,?,?)";
       $stmt = $db->prepare($sql);
       $date = date("Y-m-d H:i:s");
       $stmt->bind_param('sssssss',$name,$slug,$excerpt,$body,$pathResponse,$date,$status);
       $stmt->execute();

        if ($stmt->affected_rows == 1) {
       echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Blog post added successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured. Reload page and retry',
       position: 'bottomRight'  });</script>";
       exit();
      }

  }
  //delete blog
  elseif (isset($_POST['delblog'])) {
     $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

       $id = $_POST['delblog'];

       if (empty($id)) {
          echo "<script> iziToast.warning({
       title: 'Unknown Error!',
       message: 'An error occured. Reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $id = encode($id,'d');

       $pql = "SELECT image FROM ng_blog WHERE id = ?";
       $pstmt = $db->prepare($pql);
       $pstmt->bind_param('i',$id);
       $pstmt->execute();
       $pstmt->Store_result();
       $pstmt->bind_result($image);
       $pstmt->fetch();

       unlink("../assets/images/blog/$image");

       $sql = "DELETE FROM ng_blog WHERE id = ?";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('i',$id);
       $stmt->execute();

       if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Blog deleted successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
  //update blog post
 elseif (isset($_POST['blog_id'])) {
    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }
       $id = $_POST['blog_id'];
       $image = $_POST['blogimage'];


       if (empty($id) || empty($image)) {
      echo "<script> iziToast.warning({
        title: 'Unknown Error!',
        message: 'An error occured. reload page and retry',
        position: 'bottomRight'  });</script>";
        exit();
    }

    $id = encode($id,'d');
    $image = encode($image,'d');


       $name = test_input($_POST['e_blog_title']);
       $excerpt = test_input($_POST['e_blog_excerpt']);
       $body = test_input($_POST['e_blog_body']);
       $status = test_input($_POST['e_blog_status']);


        if (empty($name)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Blog title can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
       
       if (empty($excerpt)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Blog excerpt can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
        if (strlen($_POST['e_blog_excerpt']) > 250) {
         echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Blog excerpt should be less than 250 characters',
       position: 'bottomRight'  });</script>";
       exit();
       }
       if (empty($body)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Blog post body can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
       
      
       if (empty($status)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Select a status to continue',
       position: 'bottomRight'  });</script>";
       exit();
       }
          if(is_uploaded_file($_FILES['e_blog_image']['tmp_name'])){


       $pathResponse = newSingleUpload($_FILES['e_blog_image'],'image','blog','');

        $response = array(1,2,3,4,5,'');

          if (in_array($pathResponse, $response)) {
    switch ($pathResponse) {
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
      $c_message = "Your blog post image is larger than the maximum of 2MB";
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

    unlink("../assets/images/blog/$image");

      }else{
        $pathResponse = $image;
      }

       $sql = "UPDATE ng_blog SET title = ?, excerpt = ?,  description = ?, image = ?, status = ? WHERE id = ?";

       $stmt = $db->prepare($sql);
       $stmt->bind_param('sssssi',$name,$excerpt,$body,$pathResponse,$status,$id);
       $stmt->execute();

       if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Blog post updated successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.replace('/admin-cp/blog/manage');}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }

  }

  //staff form
   elseif (isset($_POST['s_fname'])) {
    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }
       $fname = test_input($_POST['s_fname']);
       $oname = test_input($_POST['s_onames']);
       $email = test_input($_POST['s_email']);
       $role = test_input($_POST['s_role']);
       $status = test_input($_POST['staff_status']);

        if (empty($fname)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Staff first name can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
        if (empty($oname)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Staff other names can not be empty',
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
        message: 'Enter a valid email address',
        position: 'bottomRight'  });</script>";
        exit();
      }

        if(checkStaffEmail($email) == true) :

           echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Email address already belongs to another staff ',
        position: 'bottomRight'  });</script>";
        exit();

      endif;
      
       if (empty($role)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Select a role to continue',
       position: 'bottomRight'  });</script>";
       exit();
       }
      
       if (empty($status)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Select a status to continue',
       position: 'bottomRight'  });</script>";
       exit();
       }


       $pathResponse = newSingleUpload($_FILES['staff_image'],'image','avatar','');

        $response = array(1,2,3,4,5,'');

          if (in_array($pathResponse, $response)) {
    switch ($pathResponse) {
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
      $c_message = "Staff image is larger than the maximum of 2MB";
      break;
      case 5:
      $c_title = "Upload Error";
      $c_message = "Could not move file to destination folder. contact support";
      break;
      case '':
         $c_title = "Image Required";
      $c_message = "Please upload an image for your staff";
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

      $password = generateRandomString();
      $hash = passwordEncryption($password);
       $sql = "INSERT INTO ng_admin (first_name,other_names,email_address,password,avatar,role,status,last_updated) VALUES (?,?,?,?,?,?,?,?)";
       $stmt = $db->prepare($sql);
       $date = date("Y-m-d H:i:s");
       $stmt->bind_param('ssssssss',$fname,$oname,$email,$hash,$pathResponse,$role,$status,$date);
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
   $mail->addAddress($email, $fname);    
   $mail->addReplyTo('customer-support@colorbrace.com', 'Naamglobal Services'); 

   $mail->isHTML(true);
   $mail->Subject = 'Account Details';
   $mail->Body    = 'Hello '. $fname. ' ,  An administrative account has been successfully created for you on <b>Naam Global\'s website</b>. <hr> <p> Login email : <b>'.$email.'</b> </p>  <p> Login password : <b>'.$password.'</b> </p> <p> Login Link : <b><a href="https://naamglobal.co.uk/admin-cp/login" target="_blank">Login Link</a></b> </p> <hr> Thank you';
   $mail->AltBody = 'Hello '. $fname. ' , An administrative account has been successfully created for you on Naam Globals website. Your email address is '.$email.' and your password is '.$password.' . Copy and paste the following link to continue. Link : https://naamglobal.co.uk/admin-cp/login';

  if ($mail->send()) {

       echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Staff account created successfully, Login password has been sent to the email address. Check spam folder if not found in inbox',
          position: 'bottomRight' });$('form.staff-form').find('input:not(input[type="."submit"."])').val('');  </script>";
          exit();
        }
      } catch (Exception $e) {
        
   echo "<script> iziToast.warning({
      title: 'Mail error!',
      message: 'An error occured while sending account email to $email. Quote error information when you contact us. <em>Mailer Error: {$mail->ErrorInfo}</em>',
      position: 'bottomRight'  });</script>";
      }
       
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured. Reload page and retry',
       position: 'bottomRight'  });</script>";
       exit();
      }

  }
  //delete staff
  elseif (isset($_POST['delstaff'])) {
     $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

       $id = $_POST['delstaff'];

       if (empty($id)) {
          echo "<script> iziToast.warning({
       title: 'Unknown Error!',
       message: 'An error occured. Reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $id = encode($id,'d');

       $pql = "SELECT avatar FROM ng_admin WHERE id = ?";
       $pstmt = $db->prepare($pql);
       $pstmt->bind_param('i',$id);
       $pstmt->execute();
       $pstmt->Store_result();
       $pstmt->bind_result($image);
       $pstmt->fetch();

       unlink("../assets/images/avatar/$image");

       $sql = "DELETE FROM ng_admin WHERE id = ?";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('i',$id);
       $stmt->execute();

       if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Staff removed successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
  //update staff details
 elseif (isset($_POST['staff_id'])) {
    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }
       $id = $_POST['staff_id'];
        $emailid = $_POST['staff_emailid'];


       if (empty($id) || empty($emailid)) {
      echo "<script> iziToast.warning({
        title: 'Unknown Error!',
        message: 'An error occured. reload page and retry',
        position: 'bottomRight'  });</script>";
        exit();
    }

    $id = encode($id,'d');

$fname = test_input($_POST['e_s_fname']);
       $oname = test_input($_POST['e_s_onames']);
       $email = test_input($_POST['e_s_email']);
       $role = test_input($_POST['e_s_role']);
       $status = test_input($_POST['e_staff_status']);
        $password = $_POST['password'];
       $c_password = $_POST['password_c'];
      
       $emailid = encode($emailid,'d');


        if (empty($fname)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Staff first name can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
        if (empty($oname)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Staff other names can not be empty',
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
        message: 'Enter a valid email address',
        position: 'bottomRight'  });</script>";
        exit();
      }

       if (empty($role)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Select a role to continue',
       position: 'bottomRight'  });</script>";
       exit();
       }
      
       if (empty($status)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Select a status to continue',
       position: 'bottomRight'  });</script>";
       exit();
       }


      if ($email != $emailid) {
        if(checkStaffEmail($email) == true) :

           echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Email address already belongs to another account ',
        position: 'bottomRight'  });</script>";
        exit();

      endif;
      }

      if (!empty($password)) {
        if ($password != $c_password) {
            echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Passwords do not match. Check and retry',
        position: 'bottomRight'  });</script>";
        exit();
        }
         if (passwordStrength($password) == true) {
        echo "<script> iziToast.warning({
          title: 'Action Required!',
          message: 'Password should be at least 8 charecters long and should contain at least 1 upper case letter, 1 lower case letter and 1 number ',
          position: 'bottomRight'  });</script>";
          exit();
      }
      $password = passwordEncryption($password);
      }

      
       $sql = "UPDATE ng_admin SET first_name = ?, other_names = ?,  email_address = ?, password = IFNULL(password, ?), role= ?, status = ? WHERE id = ?";

       $stmt = $db->prepare($sql);
       $stmt->bind_param('ssssssi',$fname,$oname,$email,$password,$role,$status,$id);
       $stmt->execute();

       if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Staff details updated successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.replace('/admin-cp/staff/manage');}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'No changes were made.Reload page and retry if you think it\'s an error.',
       position: 'bottomRight'  });</script>";
       exit();
      }

  }

  //Testimony form
   elseif (isset($_POST['t_name'])) {
    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }
       $name = test_input($_POST['t_name']);
       $body = test_input($_POST['t_body']);
       $status = test_input($_POST['t_status']);

        if (empty($name)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Testifier name can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
        if (empty($body)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Testimony body can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
      
       if (empty($status)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Select a status to continue',
       position: 'bottomRight'  });</script>";
       exit();
       }


       $pathResponse = newSingleUpload($_FILES['testimony_image'],'image','testimony','');

        $response = array(1,2,3,4,5,'');

          if (in_array($pathResponse, $response)) {
    switch ($pathResponse) {
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
      $c_message = "Testifier image is larger than the maximum of 2MB";
      break;
      case 5:
      $c_title = "Upload Error";
      $c_message = "Could not move file to destination folder. contact support";
      break;
      case '':
         $c_title = "Image Required";
      $c_message = "Please upload an image for your Testifier";
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

     
       $sql = "INSERT INTO ng_testimonies (testimony_by,testimony,image,enabled) VALUES (?,?,?,?)";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('ssss',$name,$body,$pathResponse,$status);
       $stmt->execute();

        if ($stmt->affected_rows == 1) {

          echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Testimony added successfully, reloading page',
          position: 'bottomRight' });$('form.testimony-form').find('input:not(input[type="."submit"."]), textarea').val('');  setTimeout(function () {
          location.reload();}, 2000); </script>";
          exit();
       
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured. Reload page and retry',
       position: 'bottomRight'  });</script>";
       exit();
      }

  }
  //delete testimony
  elseif (isset($_POST['deltestimony'])) {
     $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

       $id = $_POST['deltestimony'];

       if (empty($id)) {
          echo "<script> iziToast.warning({
       title: 'Unknown Error!',
       message: 'An error occured. Reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $id = encode($id,'d');

       $pql = "SELECT image FROM ng_testimonies WHERE id = ?";
       $pstmt = $db->prepare($pql);
       $pstmt->bind_param('i',$id);
       $pstmt->execute();
       $pstmt->Store_result();
       $pstmt->bind_result($image);
       $pstmt->fetch();

       unlink("../assets/images/testimonials/$image");

       $sql = "DELETE FROM ng_testimonies WHERE id = ?";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('i',$id);
       $stmt->execute();

       if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Testimony deleted successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
  //update testimony
 elseif (isset($_POST['testimony_id'])) {
    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }
       $id = $_POST['testimony_id'];

       if (empty($id)) {
      echo "<script> iziToast.warning({
        title: 'Unknown Error!',
        message: 'An error occured. reload page and retry',
        position: 'bottomRight'  });</script>";
        exit();
    }

    $id = encode($id,'d');

      $name = test_input($_POST['e_t_name']);
      $body = test_input($_POST['e_t_body']);
      $status = test_input($_POST['e_t_status']);
        


        if (empty($name)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Testifier name can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
        if (empty($body)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Testimony body can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
         
       if (empty($status)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Select a status to continue',
       position: 'bottomRight'  });</script>";
       exit();
       }

      
       $sql = "UPDATE ng_testimonies SET testimony_by = ?, testimony = ?, enabled = ? WHERE id = ?";

       $stmt = $db->prepare($sql);
       $stmt->bind_param('sssi',$name,$body,$status,$id);
       $stmt->execute();

       if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Testimony updated successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.replace('/admin-cp/testimony/manage');}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'No changes were made.Reload page and retry if you think it\'s an error.',
       position: 'bottomRight'  });</script>";
       exit();
      }

  }

  //delete susbcriber
  elseif (isset($_POST['delsub'])) {
    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

       $id = $_POST['delsub'];

       if (empty(trim($id))) {
          echo "<script> iziToast.warning({
       title: 'Unknown Error!',
       message: 'An error occured. Reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $id = encode($id,'d');

       $sql = "DELETE FROM ng_subscribers WHERE id = ?";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('i',$id);
       $stmt->execute();

       if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Subscriber removed successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
  //
  elseif (isset($_POST['site_name'])) {
   $name = test_input($_POST['site_name']);
   $address = test_input($_POST['site_address']);
   $email = test_input($_POST['site_email']);
   $phone = test_input($_POST['site_phone']);
   $policy =test_input($_POST['site_policy']);
   $terms = test_input($_POST['site_terms']);

     if (empty($name)) {
      echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Site Name is required',
       position: 'bottomRight'  });</script>";
       exit();
     }

      if (empty($address)) {
      echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Business Address is required',
       position: 'bottomRight'  });</script>";
       exit();
     }


    if (empty($email)) {
      echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Support email address is required',
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
       message: 'Phone number is required',
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

       if (empty($policy)) {
      echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Privacy policy is required',
       position: 'bottomRight'  });</script>";
       exit();
     }
      if (empty($terms)) {
      echo "<script> iziToast.warning({
       title: 'Field Required!',
       message: 'Business terms is required',
       position: 'bottomRight'  });</script>";
       exit();
     }

   
    $image = $_POST['siteimage'];


       if (empty($image)) {
      echo "<script> iziToast.warning({
        title: 'Unknown Error!',
        message: 'An error occured. reload page and retry',
        position: 'bottomRight'  });</script>";
        exit();
    }

    $image = encode($image,'d');

      if(is_uploaded_file($_FILES['site_logo']['tmp_name'])){


       $pathResponse = newSingleUpload($_FILES['site_logo'],'image','images','');

        $response = array(2,3,4,5,'');

          if (in_array($pathResponse, $response)) {
    switch ($pathResponse) {
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
      $c_message = "Your site image is larger than the maximum of 2MB";
      break;
      case 5:
      $c_title = "Upload Error";
      $c_message = "Could not move file to destination folder. contact support";
      break;
      case '':
         $c_title = "Image Required";
      $c_message = "Please select an image for your business";
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

    unlink("../assets/images/$image");

      }else{
        $pathResponse = $image;
      }

      $sql = "UPDATE ng_settings SET site_name = ? , site_logo = ? , address = ?, support_email = ?, phone_number = ?, policies = ?, terms = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('sssssss',$name,$pathResponse,$address,$email,$phone,$policy,$terms);
      $stmt->execute();

        if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Site settings updated successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
  //compose form
  elseif (isset($_POST['receivers_name'])) {
    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

       $receiver = $_POST['receivers_name'];
       $email = $_POST['receivers_email'];
       $subject = $_POST['subject'];
       $body = $_POST['message_body'];

       if (empty($receiver)) {
         echo  "<script> iziToast.warning({
       title: 'Field required!',
       message: 'Enter Receivers name.',
       position: 'bottomRight'  });</script>";
       exit();
       }
       if (empty($email)) {
         echo  "<script> iziToast.warning({
       title: 'Field required!',
       message: 'Enter Receivers email address.',
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
      if (empty($subject)) {
         echo  "<script> iziToast.warning({
       title: 'Field required!',
       message: 'Enter Message subject.',
       position: 'bottomRight'  });</script>";
       exit();
       }

       if (empty($body)) {
         echo  "<script> iziToast.warning({
       title: 'Field required!',
       message: 'Enter Message body.',
       position: 'bottomRight'  });</script>";
       exit();
       }


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
   $mail->addAddress($email, $receiver);    
   $mail->addReplyTo('customer-support@colorbrace.com', 'Naamglobal Services'); 

   $mail->isHTML(true);
   $mail->Subject = $subject;
   $mail->Body    = $body;
   $mail->AltBody = $body;

  if ($mail->send()) {

         echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Email message sent successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.replace('/admin-cp/compose');}, 2000);</script>";
          exit();
        }
      } catch (Exception $e) {
        
   echo "<script> iziToast.warning({
      title: 'Mail error!',
      message: 'An error occured while sending message to $email. Quote error information when you contact us. <em>Mailer Error: {$mail->ErrorInfo}</em>',
      position: 'bottomRight'  });</script>";
      }

  }
  //mp profile
  elseif (isset($_POST['my_id'])) {
    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

       $id = $_POST['my_id'];
       $emailid = $_POST['myemail'];
       $image = $_POST['my_pic'];


       if (empty($id) || empty($emailid) || empty($image)) {
      echo "<script> iziToast.warning({
        title: 'Unknown Error!',
        message: 'An error occured. reload page and retry',
        position: 'bottomRight'  });</script>";
        exit();
    }

    $id = encode($id,'d');

$fname = test_input($_POST['my_f_name']);
       $oname = test_input($_POST['my_o_name']);
       $email = test_input($_POST['my_email']);
        $password = $_POST['my_password'];
       $c_password = $_POST['my_password_c'];
      
       $emailid = encode($emailid,'d');
       $image = encode($image, 'd');


        if (empty($fname)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'First name can not be empty',
       position: 'bottomRight'  });</script>";
       exit();
       }
        if (empty($oname)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Other names can not be empty',
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
        message: 'Enter a valid email address',
        position: 'bottomRight'  });</script>";
        exit();
      }

       

      if ($email != $emailid) {
        if(checkStaffEmail($email) == true) :

           echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Email address already belongs to another account ',
        position: 'bottomRight'  });</script>";
        exit();

      endif;
      }

      if (!empty($password)) {
        if ($password != $c_password) {
            echo "<script> iziToast.warning({
        title: 'Action Required!',
        message: 'Passwords do not match. Check and retry',
        position: 'bottomRight'  });</script>";
        exit();
        }
         if (passwordStrength($password) == true) {
        echo "<script> iziToast.warning({
          title: 'Action Required!',
          message: 'Password should be at least 8 charecters long and should contain at least 1 upper case letter, 1 lower case letter and 1 number ',
          position: 'bottomRight'  });</script>";
          exit();
      }
      $password = passwordEncryption($password);
      }

        if(is_uploaded_file($_FILES['my_image']['tmp_name'])){


       $pathResponse = newSingleUpload($_FILES['my_image'],'image','avatar','');

        $response = array(2,3,4,5,'');

          if (in_array($pathResponse, $response)) {
    switch ($pathResponse) {
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
      case '':
         $c_title = "Image required";
      $c_message = "Please select an image for your avatar";
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

    unlink("../assets/images/avatar/$image");

      }else{
        $pathResponse = $image;
      }

      if (empty($password)) {
         $sql = "UPDATE ng_admin SET first_name = ?, other_names = ?,  email_address = ?,  avatar = ? WHERE id = ?";
          $stmt = $db->prepare($sql);
       $stmt->bind_param('ssssi',$fname,$oname,$email,$pathResponse,$id);
       $stmt->execute();
      } else{
       $sql = "UPDATE ng_admin SET first_name = ?, other_names = ?,  email_address = ?, password = ?,  avatar = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
       $stmt->bind_param('sssssi',$fname,$oname,$email,$password,$pathResponse,$id);
       $stmt->execute();
     }

      

       if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Profile details updated successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'No changes were made.Reload page and retry if you think it\'s an error. $stmt->error',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
  // update tour progress
  elseif (isset($_POST['tuid'])) {
     $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

    $id = $_POST['tuid'];
    $sid = $_POST['tsid'];

     if (empty($id) || empty($sid)) {
      echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
      $id = encode($id,'d');
      $sid = encode($sid,'d');

    
      $sql = "SELECT * FROM ng_tour_bookings WHERE id = ? AND sid = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('ii',$id,$sid);
      $stmt->execute();
      $res = $stmt->get_result();

      $output = "";
      while ($row = $res->fetch_assoc()) {
        $tourArray = $row['tour_details'];

        $tourArray = unserialize($tourArray);
        $ps = $as  = $cs = "";

         if($row['status'] == 'processing') : $ps = "selected"; endif;
        if($row['status'] == 'approved') : $as =  "selected"; endif;
        if($row['status'] == 'cancelled') : $cs = "selected"; endif;

        $output.='<div class="modal-header text-center">';
        $output.='<h4 class="modal-title w-100 font-weight-bold">'.test_output($tourArray['destination']).'</h4>';
        $output.='<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        $output.='<span aria-hidden="true">&times;</span>';
        $output.='</button>';
        $output.='</div>';
        $output.='<form method="post" class="response-form">';
        $output.='<div class="modal-body mx-3">';
        $output.='<div class="md-form mb-5">';
         $output.='<label  for="t_progress">Select progress</label>';
        $output.=' <select class="form-control"  id="t_progress" required name="t_progress">';
        $output.='<option disabled selected value="">Select progress</option>';
        $output.='<option value="processing" '.$ps .'>Processing</option>';
        $output.='<option value="approved" '.$as .'>Approved</option>';
        $output.='<option value="cancelled" '. $cs. '>Cancelled</option>';
        $output.='</select>';
        $output.='</div>';
         $output.='<div class="md-form">';
         $output.='<input type="hidden" name="tour_id" value="'.encode($id,"e").'">';
          $output.='<input type="hidden" name="tourist_id" value="'.encode($sid,"e").'">';
        $output.='</div>';
        $output.='<div class="md-form mb-5">';
        $output.='<input type="text" name="t_note" placeholder="e.g processing your booking" id="t_note" class="form-control" required>';
        $output.=' <label  for="t_note">Attached note</label>';
        $output.='</div>';
        $output.='</div>';
        $output.='<div class="modal-footer d-flex justify-content-center">';
        $output.='<button type="submit" class="btn btn-danger response-btn">Update progress</button>';
        $output.=' </div>';
        $output.='</form>';
        $output.='<script type="text/javascript">';
        $output.=' var response_form = $("form.response-form"), response_btn = $("button.response-btn"), loader_white =  "<span class=spinner-border spinner-border-sm text-white></span>";';
        $output.='response_form.on("submit",function(rf){';
        $output.='rf.preventDefault();';
        $output.='response_btn.html("Processing "+loader_white);';
        $output.='$.post("/admin-cp/processor.php", response_form.serialize(), function(data){';
        $output.='response_form.after(data);';
        $output.='response_btn.text("Update progress");';
       $output.='});';
        $output.='});';
        $output.='</script>';
      
       
      }
      echo $output;
     }
  
  //update tour
  elseif (isset($_POST['tourist_id'])) {
   $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }
       $id = $_POST['tour_id'];
       $sid = $_POST['tourist_id'];

       $id = encode($id,'d');
       $sid = encode($sid,'d');

        if (empty($id) || empty($sid)) {
      echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry. $sid',
       position: 'bottomRight'  });</script>";
       exit();
      }

       $progress = test_input($_POST['t_progress']);
      $note = test_input($_POST['t_note']);

       if (empty($progress)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Please select a progress from the list to update',
       position: 'bottomRight'  });</script>";
       exit();
       }

       if (empty($note)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Please add a note to your update,
       position: 'bottomRight'  });</script>";
       exit();
       }

       $sql = "UPDATE ng_tour_bookings SET status = ? WHERE id = ? AND sid = ?";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('sii',$progress,$id,$sid);
       $stmt->execute();

      if ($stmt->affected_rows == 1) {

      $aql = "INSERT INTO ng_activities (sid,type,message,date_added) VALUES(?,?,?,?)";
      $astmt = $db->prepare($aql);
      $type = 'tour';
      $message = $note;
      $date = date("Y-m-d H:i:s");
      $astmt->bind_param('isss',$sid,$type,$message,$date);
      $astmt->execute();
      if ($astmt->affected_rows==1) {
         echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Tour booking details updated successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      } else{
        echo "<script> iziToast.warning({
       title: 'Known error!',
       message: 'An error occured updating activity, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
     
     }else{
      echo "<script> iziToast.warning({
       title: 'Known error!',
       message: 'An error occured updating data, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
     }
  }

   // update visa progress
  elseif (isset($_POST['vuid'])) {
     $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

    $id = $_POST['vuid'];
    $sid = $_POST['vsid'];

     if (empty($id) || empty($sid)) {
      echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
      $id = encode($id,'d');
      $sid = encode($sid,'d');

    
      $sql = "SELECT * FROM ng_visa_application WHERE id = ? AND sid = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param('ii',$id,$sid);
      $stmt->execute();
      $res = $stmt->get_result();

      $output = "";
      while ($row = $res->fetch_assoc()) {
        $visaArray = $row['visa_details'];

        $visaArray = unserialize($visaArray);
        $ps = $as  = $cs = "";

         if($row['status'] == 'processing') : $ps = "selected"; endif;
        if($row['status'] == 'completed') : $as =  "selected"; endif;
        if($row['status'] == 'cancelled') : $cs = "selected"; endif;

        $output.='<div class="modal-header text-center">';
        $output.='<h4 class="modal-title w-100 font-weight-bold">'.test_output($visaArray['type']).'</h4>';
        $output.='<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        $output.='<span aria-hidden="true">&times;</span>';
        $output.='</button>';
        $output.='</div>';
        $output.='<form method="post" class="response-form">';
        $output.='<div class="modal-body mx-3">';
        $output.='<div class="md-form mb-5">';
         $output.='<label  for="v_progress">Select progress</label>';
        $output.=' <select class="form-control"  id="v_progress" required name="v_progress">';
        $output.='<option disabled selected value="">Select progress</option>';
        $output.='<option value="processing" '.$ps .'>Processing</option>';
        $output.='<option value="completed" '.$as .'>Completed</option>';
        $output.='<option value="cancelled" '. $cs. '>Cancelled</option>';
        $output.='</select>';
        $output.='</div>';
         $output.='<div class="md-form">';
         $output.='<input type="hidden" name="visa_id" value="'.encode($id,"e").'">';
          $output.='<input type="hidden" name="visag_id" value="'.encode($sid,"e").'">';
        $output.='</div>';
        $output.='<div class="md-form mb-5">';
        $output.='<input type="text" name="v_note" placeholder="e.g processing your visa application" id="v_note" class="form-control" required>';
        $output.=' <label  for="v_note">Attached note</label>';
        $output.='</div>';
        $output.='</div>';
        $output.='<div class="modal-footer d-flex justify-content-center">';
        $output.='<button type="submit" class="btn btn-danger response-btn">Update progress</button>';
        $output.=' </div>';
        $output.='</form>';
        $output.='<script type="text/javascript">';
        $output.=' var response_form = $("form.response-form"), response_btn = $("button.response-btn"), loader_white =  "<span class=spinner-border spinner-border-sm text-white></span>";';
        $output.='response_form.on("submit",function(rf){';
        $output.='rf.preventDefault();';
        $output.='response_btn.html("Processing "+loader_white);';
        $output.='$.post("/admin-cp/processor.php", response_form.serialize(), function(data){';
        $output.='response_form.after(data);';
        $output.='response_btn.text("Update progress");';
       $output.='});';
        $output.='});';
        $output.='</script>';
      
       
      }
      echo $output;
     }
  
  //update tour
  elseif (isset($_POST['visa_id'])) {
   $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }
       $id = $_POST['visa_id'];
       $sid = $_POST['visag_id'];

       $id = encode($id,'d');
       $sid = encode($sid,'d');

        if (empty($id) || empty($sid)) {
      echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry. $sid',
       position: 'bottomRight'  });</script>";
       exit();
      }

       $progress = test_input($_POST['v_progress']);
      $note = test_input($_POST['v_note']);

       if (empty($progress)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Please select a progress from the list to update',
       position: 'bottomRight'  });</script>";
       exit();
       }

       if (empty($note)) {
           echo "<script> iziToast.warning({
       title: 'Action Required!',
       message: 'Please add a note to your update,
       position: 'bottomRight'  });</script>";
       exit();
       }

       $sql = "UPDATE ng_visa_application SET status = ? WHERE id = ? AND sid = ?";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('sii',$progress,$id,$sid);
       $stmt->execute();

      if ($stmt->affected_rows == 1) {

      $aql = "INSERT INTO ng_activities (sid,type,message,date_added) VALUES(?,?,?,?)";
      $astmt = $db->prepare($aql);
      $type = 'visa';
      $message = $note;
      $date = date("Y-m-d H:i:s");
      $astmt->bind_param('isss',$sid,$type,$message,$date);
      $astmt->execute();
      if ($astmt->affected_rows==1) {
         echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Visa application updated successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      } else{
        echo "<script> iziToast.warning({
       title: 'Known error!',
       message: 'An error occured updating activity, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
     
     }else{
      echo "<script> iziToast.warning({
       title: 'Known error!',
       message: 'An error occured updating data, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
     }
  }

  //delete contact form message
  elseif (isset($_POST['delcon'])) {
    $status =  staffLoginStatus();

       if ($status == false) {
         echo "
        <script> iziToast.warning({
         title: 'Session Timeout!',
         message: 'Your session timed out. Redirecting to login',
         position: 'topRight'  });
         setTimeout(function(){
          location.replace('/admin-cp/login');
          },3000);
          </script>";
          exit();
       }

       $id = $_POST['delcon'];

       if (empty(trim($id))) {
          echo "<script> iziToast.warning({
       title: 'Unknown Error!',
       message: 'An error occured. Reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
       }

       $id = encode($id,'d');

       $sql = "DELETE FROM ng_contact WHERE id = ?";
       $stmt = $db->prepare($sql);
       $stmt->bind_param('i',$id);
       $stmt->execute();

       if ($stmt->affected_rows ==1) {
        echo "<script> iziToast.success({
          title: 'Success!',
          message: 'Contact mesaage deleted successfully, reloading page',
          position: 'bottomRight' }); setTimeout(function () {
          location.reload();}, 2000);</script>";
          exit();
      }else{
echo "<script> iziToast.warning({
       title: 'Unknown error!',
       message: 'An error occured, reload page and retry.',
       position: 'bottomRight'  });</script>";
       exit();
      }
  }
	//the road ends here
	} else {
    include 'ng-error.php';
  }

