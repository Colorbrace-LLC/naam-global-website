<?php
session_name('naamglobal');
session_start();
$page = 'Tours';
$subpage = 'tbooking';
include 'ng-header.php';

$bookingslug = isset($_GET['bookingslug']) ? $_GET['bookingslug'] : ''; 

 ?>
      <div class="content">
        <div class="content">
          <div class="container-fluid">
           
          <?php if(!$bookingslug) : ?>
            <h3>Manage Bookings</h3>
            <br>
            <div class="row">
               <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">tour</i>
                  </div>
                 </div>
                <div class="card-body">
                  
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th >Name</th>
                          <th class="disabled-sorting">Email</th>
                          <th class="disabled-sorting">Phone</th>
                          <th>Submitted on</th>
                          <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Submitted on</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php 
                        $gql = "SELECT * FROM ng_students WHERE submitted = ? AND account_type = ?";
                        $submitted ='yes';
                        $actype = 'tour';
                        $stmt = $db->prepare($gql);
                        $stmt->bind_param('ss',$submitted,$actype);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        while ($row = $res->fetch_assoc()) :
                          $submitted = date_create($row['submitted_on']);
                         
                        ?>
                        <tr>
                          <td><?=htmlspecialchars_decode(html_entity_decode($row['first_name']." ". $row['other_names'],ENT_QUOTES)) ?></td>
                          <td><?=htmlspecialchars_decode(html_entity_decode($row['email_address'],ENT_QUOTES)) ?></td>
                          <td><?=htmlspecialchars_decode(html_entity_decode($row['phone_number'],ENT_QUOTES)) ?></td>
                          <td><?=date_format($submitted, "jS M Y"); ?></td>
                          <td class="text-right">
                            <a href="/admin-cp/students/application/<?=encode($row['id'],"e")?>"  class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">create</i></a>
                          
                          </td>
                        </tr>
                       <?php endwhile; if($res->num_rows == 0) :?>
                        <tr>
                          <td colspan="7" class="text-center">No tour bookings submitted</td>
                        </tr>
                     <?php endif; ?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            </div>
            <?php endif; if ($bookingslug) : 

              $bookingslug = encode(trim($bookingslug),'d');
              $uql = "SELECT * FROM ng_students WHERE id = ?";
              $ustmt = $db->prepare($uql);
              $ustmt->bind_param('i',$bookingslug);
              $ustmt->execute();
              $ures = $ustmt->get_result();
              $urow = $ures->fetch_assoc();

              if ($ures->num_rows == 0) {
                 $_SESSION['showError'] =  "<script>function showError() {
     iziToast.warning({
         title: 'Known error!',
         message: 'Invalid parameter supplied',
         position: 'bottomRight'  });
 } showError(); </script>";
                redirect("/admin-cp/students/application");
                exit();
              }

              $profileArray = $urow['profile_info'];

$profileArray = unserialize($profileArray);

$academicArray = $urow['academic_info'];

$academicArray = unserialize($academicArray);

$programArray = $urow['program_info'];

$programArray = unserialize($programArray);

$documentsArray = $urow['documents_info'];

$documentsArray = unserialize($documentsArray);

$parentsArray = $urow['parents_info'];

$parentsArray = unserialize($parentsArray);

$referralArray = $urow['referral_info'];

$referralArray = unserialize($referralArray);
$dob = htmlspecialchars_decode(html_entity_decode($profileArray['dob'],ENT_QUOTES));
$dob = date_create($dob);
            ?>

             <h3>Viewing <?=htmlspecialchars_decode(html_entity_decode($urow['first_name']." ". $urow['other_names'],ENT_QUOTES));?> </h3>
            <br>
             <div class="row">
          <div class="col-md-6">
              <div class="card ">
                <div class="card-header ">
                  <h4 class="card-title">Application details -
                    <small class="description"><?=htmlspecialchars_decode(html_entity_decode($urow['first_name']." ". $urow['other_names'],ENT_QUOTES));?></small>
                  </h4>
                </div>
                <div class="card-body ">
                  <div class="row">
                    <div class="col-lg-4 col-md-6">
                     
                      <ul class="nav nav-pills nav-pills-danger nav-pills-icons flex-column" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link " data-toggle="tab" href="#profileInfo" role="tablist">
                            <i class="material-icons">person</i> Profile
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#parentsInfo" role="tablist">
                            <i class="material-icons">people</i> Parents
                          </a>
                        </li>
                         <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#referralInfo" role="tablist">
                            <i class="material-icons">thumb_up</i> Referral
                          </a>
                        </li>
                       
                      </ul>
                    </div>
                    <div class="col-md-8">
                      <div class="tab-content">
                        <div class="tab-pane " id="profileInfo">
                         <div class="table-responsive">
                          <table class="table">
                            <tbody>
                               <tr>
                        <th>Name</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($profileArray['title'] ." ". $profileArray['fname'] ." ". $profileArray['mname']." ".$profileArray['sname'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td><?=date_format($dob,"jS M Y"); ?></td>
                    </tr>
                    <tr>
                        <th>Place of Birth</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($profileArray['place'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>Hometown</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($profileArray['hometown'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>Languages</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($profileArray['languages'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>Religion</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($profileArray['religion'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>Marital Status</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($profileArray['marital'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($profileArray['gender'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>Nationality</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($profileArray['nationality'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($profileArray['phone'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>Email Address</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($profileArray['email'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>Home Phone</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($profileArray['home_phone'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>Postal Address</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($profileArray['postal'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>Residential Address</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($profileArray['residential'],ENT_QUOTES)) ?></td>
                    </tr>
                            </tbody>
                          </table>
                         </div>
                        </div>
                        <div class="tab-pane" id="parentsInfo">
                            <h5>Mother's Details</h5>
         <div class="table-responsive">
            <table class="table">
                <tbody>
                     <tr>
                        <th>Name</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($parentsArray['mother']['title'] . " ". $parentsArray['mother']['fname'] . " ". $parentsArray['mother']['mname'] . " ". $parentsArray['mother']['sname'],ENT_QUOTES)) ?></td>
                    </tr>
                      <tr>
                        <th>Date of Birth</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($parentsArray['mother']['dob'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>Place of Birth</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($parentsArray['mother']['place'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>Hometown</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($parentsArray['mother']['hometown'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>Marital</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($parentsArray['mother']['marital'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>Nationality</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($parentsArray['mother']['nationality'],ENT_QUOTES)) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
         <h5>Father's Details</h5>
         <div class="table-responsive">
            <table class="table">
                <tbody>
                     <tr>
                        <th>Name</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($parentsArray['father']['title'] . " ". $parentsArray['father']['fname'] . " ". $parentsArray['father']['mname'] . " ". $parentsArray['father']['sname']),ENT_QUOTES) ?></td>
                    </tr>
                      <tr>
                        <th>Date of Birth</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($parentsArray['father']['dob'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>Place of Birth</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($parentsArray['father']['place'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>Hometown</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($parentsArray['father']['hometown'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>Marital</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($parentsArray['father']['marital'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>Nationality</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($parentsArray['father']['nationality'],ENT_QUOTES)) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
         <h5>Sponsor's Details</h5>
         <div class="table-responsive">
            <table class="table">
                <tbody>
                     <tr>
                        <th>Name</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($parentsArray['sponsor']['name'],ENT_QUOTES)) ?></td>
                    </tr>
                      <tr>
                        <th>Relationship</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($parentsArray['sponsor']['relation'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>Nationality</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($parentsArray['sponsor']['nationality'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>Country of Residence</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($parentsArray['sponsor']['residence'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>Residential Address</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($parentsArray['sponsor']['address'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>Phone Number</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($parentsArray['sponsor']['phone'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>Email Address</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($parentsArray['sponsor']['email'],ENT_QUOTES)) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
                        </div>
                        <div class="tab-pane" id="referralInfo">
                         <div class="table-responsive">
            <table class="table">
                <tbody>
                     <tr>
                        <th>Name</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($referralArray['title']." ". $referralArray['name'],ENT_QUOTES)) ?></td>
                    </tr>
                      <tr>
                        <th>Nationality</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($referralArray['nationality'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>Occupation/Position</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($referralArray['occupation'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>Work Address</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($referralArray['work'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>Residential Address</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($referralArray['residence'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>Phone Number</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($referralArray['phone'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>Email Address</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($referralArray['email'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>Date of Recommendation</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($referralArray['date'],ENT_QUOTES)) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card ">
                <div class="card-header ">
                  <h4 class="card-title">Application details -
                    <small class="description"><?=htmlspecialchars_decode(html_entity_decode($urow['first_name']." ". $urow['other_names'],ENT_QUOTES));?></small>
                  </h4>
                </div>
                <div class="card-body ">
                  <div class="row">
                    <div class="col-lg-4 col-md-6">
                     
                      <ul class="nav nav-pills nav-pills-danger nav-pills-icons flex-column" role="tablist">
                    
                         <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#academicInfo" role="tablist">
                            <i class="material-icons">library_books</i> Academic
                          </a>
                        </li>
                         <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#programInfo" role="tablist">
                            <i class="material-icons">school</i> Program
                          </a>
                        </li>
                         <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#documentsInfo" role="tablist">
                            <i class="material-icons">description</i> Documents
                          </a>
                        </li>
                      </ul>
                    </div>
                    <div class="col-md-8">
                      <div class="tab-content">
                        <div class="tab-pane " id="academicInfo">
                         <h5>Junior High School</h5>
         <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th>Certification</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($academicArray['jhs']['certification'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>Institution</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($academicArray['jhs']['institution'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>Qualifications</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($academicArray['jhs']['qualification'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>From</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($academicArray['jhs']['from'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>To</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($academicArray['jhs']['to'],ENT_QUOTES)) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h5>Senior High School</h5>
         <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th>Certification</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($academicArray['shs']['certification'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>Institution</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($academicArray['shs']['institution'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>Qualifications</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($academicArray['shs']['qualification'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>From</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($academicArray['shs']['from'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>To</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($academicArray['shs']['to'],ENT_QUOTES)) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h5>Tertiary Institution</h5>
         <div class="table-responsive">
            <table class="table">
                <tbody>
                     <tr>
                        <th>Institution</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($academicArray['tertiary']['institution'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>Qualifications</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($academicArray['tertiary']['qualification'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>From</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($academicArray['tertiary']['from'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>To</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($academicArray['tertiary']['to'],ENT_QUOTES)) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
                        </div>
                        <div class="tab-pane" id="programInfo">
                          <div class="table-responsive">
            <table class="table">
                <tbody>
                     <tr>
                        <th>Degree Program</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($programArray['program'],ENT_QUOTES)) ?></td>
                    </tr>
                     
                </tbody>
            </table>
        </div>
        <h5>School one <?php if(!empty(fetchSchoolName($programArray['1st']['name']))) : ?> <span class="pull-right"><button type="button" class="btn btn-sm btn-danger update-progress" data-its="<?=encode(1,'e')?>" data-student="<?=encode($urow['id'],'e')?>">Update progress</button></span><?php endif; ?></h5>
         <div class="table-responsive">
            <table class="table">
                <tbody>
                     <tr>
                        <th>School</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode(fetchSchoolName($programArray['1st']['name']),ENT_QUOTES)) ?></td>
                    </tr>
                      <tr>
                        <th>1st choice</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($programArray['1st']['1st_choice'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>2nd choice</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($programArray['1st']['2nd_choice'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>3rd choice</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($programArray['1st']['3rd_choice'],ENT_QUOTES)) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h5>School two  <?php if(!empty(fetchSchoolName($programArray['2nd']['name']))) : ?> <span class="pull-right"><button type="button" class="btn btn-sm btn-danger">Update progress</button></span><?php endif; ?></h5>
         <div class="table-responsive">
            <table class="table">
                <tbody>
                     <tr>
                        <th>School</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode(fetchSchoolName($programArray['2nd']['name']),ENT_QUOTES)) ?></td>
                    </tr>
                      <tr>
                        <th>1st choice</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($programArray['2nd']['1st_choice'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>2nd choice</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($programArray['2nd']['2nd_choice'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>3rd choice</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($programArray['2nd']['3rd_choice'],ENT_QUOTES)) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h5>School three  <?php if(!empty(fetchSchoolName($programArray['3rd']['name']))) : ?> <span class="pull-right"><button type="button" class="btn btn-sm btn-danger">Update progress</button></span><?php endif; ?></h5>
         <div class="table-responsive">
            <table class="table">
                <tbody>
                     <tr>
                        <th>School</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode(fetchSchoolName($programArray['3rd']['name']),ENT_QUOTES)) ?></td>
                    </tr>
                      <tr>
                        <th>1st choice</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($programArray['3rd']['1st_choice'],ENT_QUOTES)) ?></td>
                    </tr>
                     <tr>
                        <th>2nd choice</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($programArray['3rd']['2nd_choice'],ENT_QUOTES)) ?></td>
                    </tr>
                    <tr>
                        <th>3rd choice</th>
                        <td><?=htmlspecialchars_decode(html_entity_decode($programArray['3rd']['3rd_choice'],ENT_QUOTES)) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
                        </div>
                         <div class="tab-pane" id="documentsInfo">
                         <h5>Passport document</h5>
                          <?php if(!empty($documentsArray['passport']['name'])) {
                            switch (($documentsArray['birthcert']['type'])) {
      case 'image/jpeg':
          $file = 'image-file.png';
          break;
     case 'application/pdf':
          $file = 'pdf-file.png';
           break;
      case 'application/octet-stream':
         $file = 'docx-file.png';
          break;
      
          
      default:
          $file = 'image-file.png';
          break;
  }
     ?>
                          <div class="fileinput fileinput-new text-center">
                         <div class="fileinput-new thumbnail">
                          <img src="/assets/images/<?=$file?>"  alt="<?=$documentsArray['passport']['name']?>">
                        </div>
                         <button class="btn btn-danger btn-file" onclick='location.href="/download/<?=$documentsArray['passport']['path']?>"'>
                           <i class="material-icons">get_app</i> Download
                          </button>
                            <span class="text-muted"><?=fileSize_formatted("../assets/files/".$documentsArray['passport']['path'])?></span>
                          
                      </div>
                    <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>

                    <h5>Birth Certificate</h5>
                          <?php if(!empty($documentsArray['birthcert']['name'])) {
                            switch (($documentsArray['birthcert']['type'])) {
      case 'image/jpeg':
          $file = 'image-file.png';
          break;
     case 'application/pdf':
          $file = 'pdf-file.png';
           break;
      case 'application/octet-stream':
         $file = 'docx-file.png';
          break;
      
          
      default:
          $file = 'image-file.png';
          break;
  }
     ?>
                          <div class="fileinput fileinput-new text-center">
                         <div class="fileinput-new thumbnail">
                          <img src="/assets/images/<?=$file?>"  alt="<?=$documentsArray['birthcert']['name']?>">
                        </div>
                         <button class="btn btn-danger btn-file" onclick='location.href="/download/<?=$documentsArray['birthcert']['path']?>"'>
                           <i class="material-icons">get_app</i> Download
                          </button>
                            <span class="text-muted"><?=fileSize_formatted("../assets/files/".$documentsArray['birthcert']['path'])?></span>
                          
                      </div>
                    <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>

                      <h5>Wassce Certificate</h5>
                          <?php if(!empty($documentsArray['wasscecert']['name'])) {
                            switch (($documentsArray['wasscecert']['type'])) {
      case 'image/jpeg':
          $file = 'image-file.png';
          break;
     case 'application/pdf':
          $file = 'pdf-file.png';
           break;
      case 'application/octet-stream':
         $file = 'docx-file.png';
          break;
      
          
      default:
          $file = 'image-file.png';
          break;
  }
     ?>
                          <div class="fileinput fileinput-new text-center">
                         <div class="fileinput-new thumbnail">
                          <img src="/assets/images/<?=$file?>"  alt="<?=$documentsArray['wasscecert']['name']?>">
                        </div>
                         <button class="btn btn-danger btn-file" onclick='location.href="/download/<?=$documentsArray['wasscecert']['path']?>"'>
                           <i class="material-icons">get_app</i> Download
                          </button>
                            <span class="text-muted"><?=fileSize_formatted("../assets/files/".$documentsArray['wasscecert']['path'])?></span>
                          
                      </div>
                    <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                     <h5>Academic Degree Certificate</h5>
                          <?php if(!empty($documentsArray['acacert']['name'])) {
                            switch (($documentsArray['acacert']['type'])) {
      case 'image/jpeg':
          $file = 'image-file.png';
          break;
     case 'application/pdf':
          $file = 'pdf-file.png';
           break;
      case 'application/octet-stream':
         $file = 'docx-file.png';
          break;
      
          
      default:
          $file = 'image-file.png';
          break;
  }
     ?>
                          <div class="fileinput fileinput-new text-center">
                         <div class="fileinput-new thumbnail">
                          <img src="/assets/images/<?=$file?>"  alt="<?=$documentsArray['acacert']['name']?>">
                        </div>
                         <button class="btn btn-danger btn-file" onclick='location.href="/download/<?=$documentsArray['acacert']['path']?>"'>
                           <i class="material-icons">get_app</i> Download
                          </button>
                            <span class="text-muted"><?=fileSize_formatted("../assets/files/".$documentsArray['acacert']['path'])?></span>
                          
                      </div>
                    <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                     <h5>Academic Transcript Records</h5>
                          <?php if(!empty($documentsArray['transcripts']['name'])) {
                            switch (($documentsArray['transcripts']['type'])) {
      case 'image/jpeg':
          $file = 'image-file.png';
          break;
     case 'application/pdf':
          $file = 'pdf-file.png';
           break;
      case 'application/octet-stream':
         $file = 'docx-file.png';
          break;
      
          
      default:
          $file = 'image-file.png';
          break;
  }
     ?>
                          <div class="fileinput fileinput-new text-center">
                         <div class="fileinput-new thumbnail">
                          <img src="/assets/images/<?=$file?>"  alt="<?=$documentsArray['transcripts']['name']?>">
                        </div>
                         <button class="btn btn-danger btn-file" onclick='location.href="/download/<?=$documentsArray['transcripts']['path']?>"'>
                           <i class="material-icons">get_app</i> Download
                          </button>
                            <span class="text-muted"><?=fileSize_formatted("../assets/files/".$documentsArray['transcripts']['path'])?></span>
                          
                      </div>
                    <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                     <h5>IELTS Results Form</h5>
                          <?php if(!empty($documentsArray['ielts']['name'])) {
                            switch (($documentsArray['ielts']['type'])) {
      case 'image/jpeg':
          $file = 'image-file.png';
          break;
     case 'application/pdf':
          $file = 'pdf-file.png';
           break;
      case 'application/octet-stream':
         $file = 'docx-file.png';
          break;
      
          
      default:
          $file = 'image-file.png';
          break;
  }
     ?>
                          <div class="fileinput fileinput-new text-center">
                         <div class="fileinput-new thumbnail">
                          <img src="/assets/images/<?=$file?>"  alt="<?=$documentsArray['ielts']['name']?>">
                        </div>
                         <button class="btn btn-danger btn-file" onclick='location.href="/download/<?=$documentsArray['ielts']['path']?>"'>
                           <i class="material-icons">get_app</i> Download
                          </button>
                            <span class="text-muted"><?=fileSize_formatted("../assets/files/".$documentsArray['ielts']['path'])?></span>
                          
                      </div>
                    <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                     <h5>Bank Account Statement</h5>
                          <?php if(!empty($documentsArray['bank']['name'])) {
                            switch (($documentsArray['bank']['type'])) {
      case 'image/jpeg':
          $file = 'image-file.png';
          break;
     case 'application/pdf':
          $file = 'pdf-file.png';
           break;
      case 'application/octet-stream':
         $file = 'docx-file.png';
          break;
      
          
      default:
          $file = 'image-file.png';
          break;
  }
     ?>
                          <div class="fileinput fileinput-new text-center">
                         <div class="fileinput-new thumbnail">
                          <img src="/assets/images/<?=$file?>"  alt="<?=$documentsArray['bank']['name']?>">
                        </div>
                         <button class="btn btn-danger btn-file" onclick='location.href="/download/<?=$documentsArray['bank']['path']?>"'>
                           <i class="material-icons">get_app</i> Download
                          </button>
                            <span class="text-muted"><?=fileSize_formatted("../assets/files/".$documentsArray['bank']['path'])?></span>
                          
                      </div>
                    <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                     <h5>Academic Reference</h5>
                          <?php if(!empty($documentsArray['reference']['name'])) {
                            switch (($documentsArray['reference']['type'])) {
      case 'image/jpeg':
          $file = 'image-file.png';
          break;
     case 'application/pdf':
          $file = 'pdf-file.png';
           break;
      case 'application/octet-stream':
         $file = 'docx-file.png';
          break;
      
          
      default:
          $file = 'image-file.png';
          break;
  }
     ?>
                          <div class="fileinput fileinput-new text-center">
                         <div class="fileinput-new thumbnail">
                          <img src="/assets/images/<?=$file?>"  alt="<?=$documentsArray['reference']['name']?>">
                        </div>
                         <button class="btn btn-danger btn-file" onclick='location.href="/download/<?=$documentsArray['reference']['path']?>"'>
                           <i class="material-icons">get_app</i> Download
                          </button>
                            <span class="text-muted"><?=fileSize_formatted("../assets/files/".$documentsArray['reference']['path'])?></span>                          
                      </div>
                    <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                     <h5>Personal Statement</h5>
                          <?php if(!empty($documentsArray['statement']['name'])) {
                            switch (($documentsArray['statement']['type'])) {
      case 'image/jpeg':
          $file = 'image-file.png';
          break;
     case 'application/pdf':
          $file = 'pdf-file.png';
           break;
      case 'application/octet-stream':
         $file = 'docx-file.png';
          break;
      
          
      default:
          $file = 'image-file.png';
          break;
  }
     ?>
                          <div class="fileinput fileinput-new text-center">
                         <div class="fileinput-new thumbnail">
                          <img src="/assets/images/<?=$file?>"  alt="<?=$documentsArray['statement']['name']?>">
                        </div>
                         <button class="btn btn-danger btn-file" onclick='location.href="/download/<?=$documentsArray['statement']['path']?>"'>
                           <i class="material-icons">get_app</i> Download
                          </button>
                            <span class="text-muted"><?=fileSize_formatted("../assets/files/".$documentsArray['statement']['path'])?></span>                          
                      </div>
                    <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                     <h5>Sponsorship Letter</h5>
                          <?php if(!empty($documentsArray['sponsorship']['name'])) {
                            switch (($documentsArray['sponsorship']['type'])) {
      case 'image/jpeg':
          $file = 'image-file.png';
          break;
     case 'application/pdf':
          $file = 'pdf-file.png';
           break;
      case 'application/octet-stream':
         $file = 'docx-file.png';
          break;
      
          
      default:
          $file = 'image-file.png';
          break;
  }
     ?>
                          <div class="fileinput fileinput-new text-center">
                         <div class="fileinput-new thumbnail">
                          <img src="/assets/images/<?=$file?>"  alt="<?=$documentsArray['sponsorship']['name']?>">
                        </div>
                         <button class="btn btn-danger btn-file" onclick='location.href="/download/<?=$documentsArray['sponsorship']['path']?>"'>
                           <i class="material-icons">get_app</i> Download
                          </button>
                            <span class="text-muted"><?=fileSize_formatted("../assets/files/".$documentsArray['sponsorship']['path'])?></span>                          
                      </div>
                    <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <?php endif; ?>
          </div>
        </div>
      </div>
     <?php include 'ng-footer.php';?>