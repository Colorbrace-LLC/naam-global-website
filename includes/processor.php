<?php
session_name('myprofile');
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {


  include 'functions.php';

  if (isset($_POST['name'])) {

    $name = test_input($_POST['name']);
    $email = test_input($_POST['email']);
    $subject = mysqli_real_escape_string($db, test_input($_POST['subject']));
    $message = mysqli_real_escape_string($db, test_input($_POST['message']));

    if (empty($subject)) {
      echo "Subject cannot be empty";
      exit();
    }

    if (empty($message)) {
      echo "Message cannot be empty";
    }

    if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
     echo "Only letters and white spaces are allowed for name";
     exit();

   }

   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Please enter a valid email address";
    exit();
    
  }
  $sql = "INSERT INTO mp_contact (name,email_address,subject,message,date_created,status) VALUES (?,?,?,?,?,?)";

  $stmt = $db->prepare($sql);
  $date_created = date('Y-m-d H:i:s');
  $status = 'active';

  $stmt->bind_param('ssssss', $name,$email,$subject,$message,$date_created,$status);
  $stmt->execute();

  if ($stmt->affected_rows ==1) {
    echo 1;

  }else{
   echo 'error submitting form. please try again';

 }

}elseif (isset($_POST['comment_name'])) {

  $blog_id = encode($_POST['blog_id'], 'd');
  $name = test_input($_POST['comment_name']);
  $captcha =  test_input($_POST['captcha_code']);
  $comment = test_input($_POST['comments']);

  if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
   echo "Only letters and white spaces are allowed for name";
   exit();

 }

 if (empty($name)) {
   echo "Your name cannot be empty";
   exit();
 }

 if (empty($comment)) {
   echo "Dont keep your comments. let us know";
   exit();
 }


 if (empty($blog_id)) {
   echo "An error occured. reload page and retry again";
   exit();
 }

 if (empty($captcha)) {
   echo "Type captcha code to continue";
   exit();
 }

 if (!preg_match("/^[a-zA-Z0-9]*$/", $captcha)) {
   echo "No special characters allowed in captcha. Check and retry";
   exit();

 }

 if (strcmp($_SESSION['captcha_code'], $captcha) != 0) {

  echo "The captcha code does not match!";
  exit();
}


$sql = "INSERT INTO mp_comments (blog_id,comment_by,comment,date_created) VALUES (?,?,?,?)";

$stmt = $db->prepare($sql);
$date_created = date('Y-m-d H:i:s');

$stmt->bind_param('ssss',$blog_id,$name,$comment,$date_created);
$stmt->execute();

if ($stmt->affected_rows ==1) {
  echo 1;

}else{
 echo 'error submitting form. please try again';

}



}elseif (isset($_POST['module_val'])) {

  $name = test_input($_POST['module_name']);
  $val = test_input($_POST['module_val']);

  if (!preg_match("/^[a-z]*$/", strtolower($name))) {
   echo "<script> iziToast.warning({
    title: 'Module Error!',
    message: 'An error occured verifying module name. reload page and retry',
    position: 'topRight'  });</script>";
    exit();

  }

  if (!preg_match("/^[a-z]*$/", strtolower($val))) {
   echo "<script> iziToast.warning({
    title: 'Module Error!',
    message: 'An error occured verifying module update. reload page and retry',
    position: 'topRight'  });</script>";
    exit();

  }

  if ($val == 'yes') {
    $update = 'Enabled';
  }else{
    $update = 'Disabled';
  }

  $sql = "UPDATE mp_modules SET  enabled = ?  WHERE name = ?";
  $stmt = $db->prepare($sql);
  $stmt->bind_param('ss',$val,$name);
  $stmt->execute();

  if ($stmt->affected_rows == 1) {

   echo '<script> iziToast.success({
    title: "Update Success!",
    message: "'.$name.' Module '.$update.' successfully",
    position: "topRight"  }); $("label[for='.'\''.$name.'\''.']").text("'.$update.'")</script>';
    exit();

  }else{

    echo "<script> iziToast.warning({
      title: 'Nothing Happened!',
      message: 'No changes were made. Contact support if you think it\'s an error',
      position: 'topRight'  });</script>";
      exit();
    }

  }elseif (isset($_POST['cvid'])) {

   $id = test_input($_POST['cvid']);

   if (empty($id)) {
    echo " Something went wrong. Reload page and retry";
    exit();
  }

  $id = encode($id,'d');

  $sql = "SELECT * FROM mp_contact WHERE id = ?";
  $stmt = $db->prepare($sql);
  $stmt->bind_param('i',$id);
  $stmt->execute();

  $res = $stmt->get_result();

  $output  = "";

  while ($row = $res->fetch_assoc()) :

    $output.= '<div class="modal-header">';
    $output.= '<h5 class="modal-title">'.htmlspecialchars_decode($row['subject']).'</h5>';
    $output.= '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    $output.= '<span aria-hidden="true">&times;</span>';
    $output.= '</button>';
    $output.= '</div>';
    $output.= '<div class="modal-body">';
    $output.= htmlspecialchars_decode($row['message']);
    $output.= '</div>';
    $output.= '<div class="modal-footer bg-whitesmoke br">';
    $output.= '<a href="compose-'.encode($row['id'], 'e').'" class="btn btn-primary">Reply</a>';
    $output.= '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
    $output.= '</div>';
  endwhile;

  echo $output;

}elseif (isset($_POST['dvid'])) {

 $id = test_input($_POST['dvid']);

 if (empty($id)) {
   echo "<script> iziToast.warning({
    title: 'Data Error!',
    message: 'Something went wrong. Reload page and retry',
    position: 'topRight'  });</script>";
    exit();

  }

  $id = encode($id,'d');

  $sql = "DELETE FROM mp_contact WHERE id = ?";
  $stmt = $db->prepare($sql);
  $stmt->bind_param('i',$id);
  $stmt->execute();

  if ($stmt->affected_rows == 1) {

   echo "<script> iziToast.success({
    title: 'Delete Success!',
    message: 'Contact information deleted successfully',
    position: 'topRight'  });setTimeout(function () {
      location.reload();
    }, 2000);</script>";
    exit();
  }else{

   echo "<script> iziToast.warning({
    title: 'Nothing Happened!',
    message: 'Something happened and no changes were made. Contact support if you think it\'s an error',
    position: 'topRight'  });</script>";
    exit();
  }
}elseif (isset($_POST['blog_title'])) {

  $title = test_input($_POST['blog_title']);
  $slug = test_input($_POST['slug']);
  $category = test_input($_POST['category']);
  $tags = test_input($_POST['tags']);
  $excerpt = test_input($_POST['excerpt']);
  $body = test_input($_POST['post_body']);
  $status = test_input($_POST['status']);
  $excerptLength = $_POST['maxExcerpt'];

  if (empty($title)) {
   echo "<script> iziToast.warning({
    title: 'Title Required!',
    message: 'Blog title can not be empty',
    position: 'topRight'  });</script>";
    exit();
  }

  if (empty($slug)) {
   echo "<script> iziToast.warning({
    title: 'Slug Error!',
    message: 'Reload page and retry',
    position: 'topRight'  });</script>";
    exit();
  }

  if (empty($category)) {
   echo "<script> iziToast.warning({
    title: 'Category Required!',
    message: 'Blog category can not be empty',
    position: 'topRight'  });</script>";
    exit();
  }

  if (empty($tags)) {
   echo "<script> iziToast.warning({
    title: 'Tags Required!',
    message: 'Blog tags can not be empty',
    position: 'topRight'  });</script>";
    exit();
  }

  if (empty($excerpt)) {
   echo "<script> iziToast.warning({
    title: 'Excerpt Required!',
    message: 'Blog excerpt can not be empty',
    position: 'topRight'  });</script>";
    exit();
  }

  if ($excerptLength < 0) {
   echo "<script> iziToast.warning({
    title: 'Excerpt Limit!',
    message: 'Only 250 characters are allowed for blog excerpt!',
    position: 'topRight'  });</script>";
    exit();
  }

  if (empty($body)) {
   echo "<script> iziToast.warning({
    title: 'Body Required!',
    message: 'Blog body can not be empty',
    position: 'topRight'  });</script>";
    exit();
  }
  if (empty($status)) {
   echo "<script> iziToast.warning({
    title: 'Status Required!',
    message: 'Please select a blog status',
    position: 'topRight'  });</script>";
    exit();
  }

  $pathResponse = newSingleUpload($_FILES['image'], 'image','blog');

  $response = array(1,2,3,4,5);

  if (in_array($pathResponse, $response)) {
    switch ($pathResponse) {
      case 1:
      $c_title = "Image Required";
      $c_message = "Please upload an image for the blog post";
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
      $c_message = "COuld not move file to destination folder. contact support";
      break;
      default:
        # nothing here...
      break;
    }

    echo "<script> iziToast.warning({
      title: '$c_title!',
      message: '$c_message',
      position: 'topRight'  });</script>";
      exit(); 
    }

    $nslug = checkSlug($slug);

    if ($nslug == true) {
      $nslug = $slug.'-'.date('Y').time();
    }

    $imagePath = $pathResponse;

    $sql = "INSERT INTO mp_blog (title,excerpt,message,slug,tags,image,category,date_created,enabled) VALUES(?,?,?,?,?,?,?,?,?)";
    $stmt = $db->prepare($sql);
    $date_created = date('Y-m-d H:i:s');

    $stmt->bind_param('sssssssss',$title,$excerpt,$body,$nslug,$tags,$imagePath,$category,$date_created,$status);
    $stmt->execute();

    if ($stmt->affected_rows == 1) {

     echo "<script> iziToast.success({
      title: 'Post Success!',
      message: 'Blog post created successfully',
      position: 'topRight'  });setTimeout(function () {
        location.reload();
      }, 2000);</script>";
      exit();
    }else{

     echo "<script> iziToast.warning({
      title: 'Nothing Happened!',
      message: 'Something happened. Reload page and retry. Contact support if you think it\'s an error',
      position: 'topRight'  });</script>";
      exit();
    }

  }elseif (isset($_POST['bdelid'])) {
   $id = test_input($_POST['bdelid']);

   if (empty($id)) {
     echo "<script> iziToast.warning({
      title: 'Data Error!',
      message: 'Something went wrong. Reload page and retry',
      position: 'topRight'  });</script>";
      exit();

    }

    $id = encode($id,'d');

    $sql = "DELETE FROM mp_blog WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i',$id);
    $stmt->execute();

    if ($stmt->affected_rows == 1) {

     echo "<script> iziToast.success({
      title: 'Delete Success!',
      message: 'Blog post deleted successfully',
      position: 'topRight'  });setTimeout(function () {
        location.reload();
      }, 2000);</script>";
      exit();
    }else{

     echo "<script> iziToast.warning({
      title: 'Nothing Happened!',
      message: 'Something happened and no changes were made. Contact support if you think it\'s an error',
      position: 'topRight'  });</script>";
      exit();
    }
  }elseif (isset($_POST['beid'])) {
   $id = test_input($_POST['beid']);

   if (empty($id)) {
    echo " Something went wrong. Reload page and retry";
    exit();
  }

  $id = encode($id,'d');

  $sql = "SELECT * FROM mp_blog WHERE id = ?";
  $stmt = $db->prepare($sql);
  $stmt->bind_param('i',$id);
  $stmt->execute();

  $res = $stmt->get_result();

  $output  = "";

  while ($row = $res->fetch_assoc()) :

    $output.= '<div class="modal-header">';
    $output.= '<h5 class="modal-title">'.htmlspecialchars_decode($row['title']).'</h5>';
    $output.= '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    $output.= '<span aria-hidden="true">&times;</span>';
    $output.= '</button>';
    $output.= '</div>';
    $output.= '<div class="modal-body">';
    $output.= " <form class='blog-edit' method='post' enctype='multipart/form-data'>";
    $output.= " <div class='form-group'>";
    $output.= "<div class='form-line'>";
    $output.= "<label class='form-label'>Post Title</label>";
    $output.= "<input type='text' class='form-control ep-title' name='eblog_title' value='".htmlspecialchars_decode($row['title'])."' required>";
    $output.= "</div>";
    $output.= "</div>";
    $output.= " <div class='form-group form-float'>";
    $output.= " <div class='form-line'>";
    $output.= " <label class='form-label'>Category</label>";
    $output.= "<input type='text' class='form-control' name='ecategory'  value='".htmlspecialchars_decode($row['category'])."' required>";
    $output.= "</div>";
    $output.= "</div>";
    $output.= " <div class='form-group form-float'>";
    $output.= " <div class='form-line'>";
    $output.= " <label class='form-label'>Tags</label>";
    $output.= "<input type='text' class='form-control inputtags' value='".trim($row['tags'],',')."'  required>";
    $output.= "</div>";
    $output.= "</div>";
    $output.= " <div class='form-group form-float'>";
    $output.= " <div class='form-line'>";
    $output.= " <label class='form-label'>Thumbnail <em>square image (500x500 pixels recommended)</em></label>";
    $output.= "<div id='image-preview' class='image-preview'>";
    $output.= "<label for='image-upload' id='image-label'>Choose/Drag & Drop</label>";
    $output.= "<input type='file' name='eimage' id='image-upload' />";
    $output.= "</div>";
    $output.= "</div>";
    $output.= "</div>";
    $output.= " <div class='form-group form-float'>";
    $output.= " <div class='form-line'>";
    $output.= " <label class='form-label'>Excerpts <em>250 chars. max</em></label>";
    $output.= " <textarea class='summernote-excerpt' id='eexcerpt' name='eexcerpt' >".htmlspecialchars_decode(html_entity_decode($row['excerpt'],ENT_QUOTES))."</textarea>";
    $output.= "</div>";
    $output.=" <input type='hidden' name='maxExcerpt' class='maxExcerpt' /> ";
    $output.= "</div>";

    $output.= " <div class='form-group form-float'>";
    $output.= " <div class='form-line'>";
    $output.= " <label class='form-label'>Excerpts <em>250 chars. max</em></label>";
    $output.= " <textarea class='summernote' id='ebody' name='ebody' >".htmlspecialchars_decode(html_entity_decode($row['message'],ENT_QUOTES))."</textarea>";
    $output.= "</div>";
    $output.= "</div>";
    $output.= "<div class='form-group form-float'>";
    $output.= "<div class='form-line'>";
    $output.= "<label class='form-label'>Status</label>";
    $output.= "<select class='form-control' required name='estatus'>";
    if($row['enabled'] == 'yes'){
       $output.= "<option value='yes' selected = 'selected'>Publish</option>";
       $output.="<option value='no' >Draft</option>";
    }else{
      $output.= "<option value='yes'>Publish</option>";
      $output.="<option value='no'  selected = 'selected'>Draft</option>";
    }
   
    $output.= "</select>";
    $output.= " </div>";
    $output.= "</div>";
    $output.= " <div class='progress mb-3' style='display: none;'>";
    $output.= " <div class='progress-bar' role='progressbar' aria-valuenow='0' aria-valuemin='0'
            aria-valuemax='100'>0</div>";
    $output.= " </div>";
    $output.= "</div>";  
    $output .="<button type='submit' class='btn btn-primary m-t-15 waves-effect'>Update Post</button>";
    $output.="</form>";
    $output.= '</div>';
    $output.="";
  endwhile;

  echo $output;
}elseif (condition) {
  # code...
}

}


?>