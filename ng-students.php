<section class="small-section dashboard-section bg-inner" data-sticky_parent>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="pro_sticky_info" data-sticky_column>
                    <div class="dashboard-sidebar">
                        <div class="profile-top">
                            <div class="profile-image">
                                <img src="/assets/images/profile/<?=$profileArray['avatar']?>" class="p-image img-fluid blur-up lazyload" alt="">
                                
                            </div>
                            <div class="profile-detail">
                                <h5><?=test_output($_SESSION['student_name']) ?></h5>
                                <h6><?=test_output($arow['phone_number']) ?></h6>
                                <h6><?=test_output($arow['email_address']) ?></h6>
                            </div>
                        </div>
                        <div class="faq-tab">
                            <ul class="nav nav-tabs" id="top-tab" role="tablist">
                                <li class="nav-item"><a data-toggle="tab" class="nav-link active"
  href="#dashboard">dashboard</a></li>
  <!-- profile -->
  <li class="nav-item"><a data-toggle="tab" class="nav-link "
      href="#profile">profile <span class="fas <?php if(empty($profileArray['avatar'])){ echo 'fa-window-close float-right text-danger'; } else{ echo 'fa-check-square float-right text-success';}?> "></span></a></li>
      <!-- academic -->
      <li class="nav-item <?php if(empty($profileArray['avatar'])) : echo 'bg-secondary'; endif;?>"><a data-toggle="tab" class="nav-link <?php if(empty($profileArray['avatar'])) : echo 'disabled'; endif;?>"
          href="#academic">academic <span class="fas <?php if(empty($academicArray['jhs']['certification'])){ echo 'fa-window-close float-right text-danger'; } else{ echo 'fa-check-square float-right text-success';}?> "></span></a></li>
          <!-- program of study -->
          <li class="nav-item <?php if(empty($academicArray['jhs']['certification'])) : echo 'bg-secondary'; endif;?>"><a data-toggle="tab" class="nav-link <?php if(empty($academicArray['jhs']['certification'])) : echo 'disabled'; endif;?>" href="#program">Program of Study  <span class="fas <?php if(empty($programArray['program'])){ echo 'fa-window-close float-right text-danger'; } else{ echo 'fa-check-square float-right text-success';}?> "></span></a></li>
          <!-- parents and sponsor -->
          <li class="nav-item <?php if(empty($programArray['program'])) : echo 'bg-secondary'; endif;?>"><a data-toggle="tab" class="nav-link <?php if(empty($programArray['program'])) : echo 'disabled'; endif;?>" href="#parents">Parents & Sponsor  <span class="fas <?php if(empty($parentsArray['mother']['fname'])){ echo 'fa-window-close float-right text-danger'; } else{ echo 'fa-check-square float-right text-success';}?> "></span></a></li>
          <!-- referral -->
          <li class="nav-item <?php if(empty($parentsArray['mother']['fname'])) : echo 'bg-secondary'; endif;?>"><a data-toggle="tab" class="nav-link <?php if(empty($parentsArray['mother']['fname'])) : echo 'disabled'; endif;?>" href="#referral">Referral  <span class="fas <?php if(empty($referralArray['name'])){ echo 'fa-window-close float-right text-danger'; } else{ echo 'fa-check-square float-right text-success';}?> "></span></a></li>
          <!-- documents -->
          <li class="nav-item <?php if(empty($referralArray['name'])) : echo 'bg-secondary'; endif;?>"><a data-toggle="tab" class="nav-link <?php if(empty($referralArray['name'])) : echo 'disabled'; endif;?>" href="#documents">Documents  <span class="fas <?php if(empty($documentsArray['statement']['path'])){ echo 'fa-window-close float-right text-danger'; } else{ echo 'fa-check-square float-right text-success';}?> "></span></a></li>
          <!-- review and submit -->
          <li class="nav-item <?php if(empty($documentsArray['statement']['path'])) : echo 'bg-secondary'; endif;?>"><a data-toggle="tab" class="nav-link <?php if(empty($documentsArray['statement']['path'])) : echo 'disabled'; endif;?>"
              href="#review">Review & Submit  <span class="fas <?php if($arow['submitted'] !='yes'){ echo 'fa-window-close float-right text-danger'; } else{ echo 'fa-check-square float-right text-success';}?> "></span></a></li>
              <!-- security -->
              <li class="nav-item"><a data-toggle="tab" class="nav-link"
                  href="#security">security</a></li>
                   <li class="nav-item"><a class="nav-link"
                  href="/logout/<?=$token?>">Logout</a></li>
              </ul>
          </div>
      </div>
  </div>
                                </div>
                                <div class="col-lg-9">
  <div class="product_img_scroll" data-sticky_column>
      <div class="faq-content tab-content" id="top-tabContent">
          <div class="tab-pane fade show active" id="dashboard">
              <div class="dashboard-main">
                  <div class="dashboard-intro">
                      <h5>welcome! <span><?=test_output($_SESSION['student_name']) ?></span></h5>
                      <?php 
                      $comArray = array(10);
                      if ($arow['email_verified'] == 'yes') {
                        array_push($comArray, 30);
                      }
                       if ($arow['phone_verified'] == 'yes') {
                        array_push($comArray, 30);
                      }
                      if (!empty($profileArray['avatar'])) {
                        array_push($comArray, 30);
                      }

                      ?>
                      <p>you have completed <?=array_sum($comArray) ?>% of your profile. 
                      </p>
                      <div class="complete-profile">
                          <div class="row">
                              <div class="col-xl-4">
<div class="complete-box <?php if ($arow['email_verified'] != 'yes') : echo 'not-complete'; endif;?>">
    <i class="far <?php if ($arow['email_verified'] != 'yes'){ echo 'fa-window-close'; } else { echo 'fa-check-square'; }?> "></i>
    <h6>verified email ID</h6>
</div>
                              </div>
                              <div class="col-xl-4">
<div class="complete-box  <?php if ($arow['phone_verified'] != 'yes') : echo 'not-complete'; endif;?>">
    <i class="far <?php if ($arow['phone_verified'] != 'yes'){ echo 'fa-window-close'; } else { echo 'fa-check-square'; }?>"></i>
    <h6>verified phone number</h6>
</div>
                              </div>
                              <div class="col-xl-4">
<div class="complete-box  <?php if (empty($profileArray['avatar'])) : echo 'not-complete'; endif;?>">
    <i class="far <?php if (empty($profileArray['avatar'])){ echo 'fa-window-close'; } else { echo 'fa-check-square'; }?>"></i>
    <h6>complete basic info</h6>
</div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="counter-section">
                      <div class="row">
                          <div class="col-xl-3 col-sm-6">
                              <div class="counter-box">
<span class="fas fa-school fa-2x blur-up lazyload mb-3 text-danger"></span>

<h3><?php 

$programs = array($programArray['1st']['name'],$programArray['2nd']['name'],$programArray['3rd']['name']);
      $i = 0;
      foreach ($programs as $scap) {
          if (!empty($scap)) {
              $i++;
          }
      }
        echo $i;

 ?></h3>
<h5>schools applied</h5>
                              </div>
                          </div>
                          <div class="col-xl-3 col-sm-6">
                              <div class="counter-box">
<span class="fas fa-user-check fa-2x blur-up lazyload mb-3 text-success"></span>
<h3><?php 

$status = array($programArray['1st']['status'],$programArray['2nd']['status'],$programArray['3rd']['status']);
      $a = 0;
      foreach ($status as $scap) {
          if ($scap == 'accepted') {
              $a++;
          }
      }
        echo $a;

 ?></h3>
<h5>schools accpeted</h5>
                              </div>
                          </div>
                          <div class="col-xl-3 col-sm-6">
                              <div class="counter-box">
<span class="fas fa-window-close fa-2x blur-up lazyload mb-3 text-warning"></span>

<h3><?php 

      $d = 0;
      foreach ($status as $scap) {
          if ($scap == 'declined' || $scap == 'cancelled') {
              $d++;
          }
      }
        echo $d;

 ?></h3>
<h5>Declined/Cancelled</h5>
                              </div>
                          </div>
                          <div class="col-xl-3 col-sm-6">
                              <div class="counter-box">  
                                 <span class="fas fa-sync fa-2x blur-up lazyload mb-3 text-info"></span>

                                 <h3><?php 
      $p = 0;
      foreach ($status as $scap) {
          if ($scap == 'processing') {
              $p++;
          }
      }
        echo $p;

 ?></h3>
                                 <h5>Processing</h5>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="dashboard-info">
                  <div class="row">
                      <div class="col-md-6">
                         <div class="detail-left">
                          <ul>
                              <li><span class="accepted"></span>Accepted</li>
                              <li><span class="cancelled"></span>Cancelled</li>
                              <li><span class="processing"></span>Processing</li>
                          </ul>
                      </div>
                      <div id="chart">

                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="activity-box">
                          <h6>recent activities</h6>
                          <ul>
                            <?php 

                            $tql = "SELECT * FROM ng_activities WHERE sid = ?  AND type = ?";
                            $tstmt = $db->prepare($tql);
                            $sid = $arow['id'];
                            $type = 'school';

                            $tstmt->bind_param('is',$sid,$type);
                            $tstmt->execute();
                            $tres = $tstmt->get_result();

                            while($trow = $tres->fetch_assoc()) :

                            ?>
                              <li>
                                <i class="fas fa-info-circle"></i>
                                    <?=test_output($trow['message']) ?>
                                <span><?=timeAgo($trow['date_added'], date('Y-m-d H:i:s'))?></span>
                              </li>
                          <?php endwhile;  if($tres->num_rows == 0) :?>
                              <li class="blue-line">
                                <i class="fas fa-info-circle"></i>
                               No new activity recorded yet.
                              </li>

                          <?php endif; ?>
                              
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- begin of students -->
  <div class="tab-pane fade" id="profile">
      <div class="single-section">

         <div class="description-section tab-section">
          <div class="menu-top menu-up">
              <ul class="nav nav-tabs" id="top-tab" role="tablist">
                  <li class="nav-item"><a data-toggle="tab" class="nav-link active for-personal"
                      href="#personal">Personal</a></li>
                      <li class="nav-item"><a data-toggle="tab" class="nav-link for-contact" href="#contact">Contact</a>
                      </li>

                  </ul>
              </div>
              <form class="profile-form" method="post" enctype="multipart/form-data">
                  <div class="description-details tab-content" id="top-tabContent">
                      <div class="menu-part about tab-pane fade show active" id="personal">

                         <div class="title-1">
                          <span class="title-label">Part a</span>
                          <h2>Personal Information</h2>
                      </div>

                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <div class="profile-image">
<img src="/assets/images/profile/<?=$profileArray['avatar']?>" class="img-fluid p-image blur-up lazyload" alt="">
<a class="profile-img p-file" href="javascript:void(0)" data-toggle="tooltip" data-title= "Edit Image">
    <input type="file" name="profile_image" accept=".jpg,.png,.jpeg" id="profile_image">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
    stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
    <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34">
    </path>
    <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
</svg>
                              </a>
                          </div>
                      </div>
                      <div class="form-group col-md-6">
                          <label for="title">Title</label>
                          <select class="form-control" name="title" id="title" required>
                              <option value="" selected disabled>Choose title</option>
                              <option <?php if($profileArray['title'] == 'Mr.') : echo "selected"; endif;?>>Mr.</option>
                              <option <?php if($profileArray['title'] == 'Mrs.') : echo "selected"; endif;?>>Mrs.</option>
                              <option <?php if($profileArray['title'] == 'Miss') : echo "selected"; endif;?>>Miss</option>
                              <option <?php if($profileArray['title'] == 'Rev') : echo "selected"; endif;?>>Rev</option>
                              <option <?php if($profileArray['title'] == 'Prof') : echo "selected"; endif;?>>Prof</option>
                          </select>
                      </div>
                  </div>
                  <input type="hidden" name="default_image" value="<?=$profileArray['avatar']?>">
                  <div class="form-row">
                      <div class="form-group col-md-4">
                          <label for="p_fname">First Name <small>required</small></label>
                          <input type="text" name="p_fname" value="<?=$profileArray['fname']?>" required placeholder="First Name" id="p_fname" class="form-control">
                      </div>
                      <div class="form-group col-md-4">
                          <label for="p_mname">Middle Name</label>
                          <input type="text" name="p_mname" value="<?=$profileArray['mname']?>" placeholder="Middle Name" id="p_mname" class="form-control">
                      </div> <div class="form-group col-md-4">
                          <label for="p_sname">Surname(s) <small>required</small></label>
                          <input type="text" name="p_sname" value="<?=$profileArray['sname']?>"    required placeholder="Surname" id="p_sname" class="form-control">
                      </div>
                  </div>
                  <div class="form-row">
                      <div class="form-group col-md-4">
                          <label for="dob">Date of Birth <small>required</small></label>
                          <input type="text"  placeholder="YYYY-MM-DD" pattern="(?:19|20)(?:(?:[13579][26]|[02468][048])-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))|(?:[0-9]{2}-(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:29|30))|(?:(?:0[13578]|1[02])-31)))" class="form-control " value="<?=$profileArray['dob']?>"  name="dob" id="dob" required  autocomplete="no">

                      </div>
                      <div class="form-group col-md-4">
                          <label for="place">Place of Birth <small>required</small></label>
                          <input type="text" name="place" value="<?=$profileArray['place']?>" required placeholder="Place of Birth" id="place" class="form-control">
                      </div> <div class="form-group col-md-4">
                          <label for="hometown">Hometown <small>required</small></label>
                          <input type="text" name="hometown"  value="<?=$profileArray['hometown']?>"  placeholder="Hometown" required id="hometown" class="form-control">
                      </div>
                  </div>
                  <div class="form-row">

                      <div class="form-group col-md-6">
                          <label for="languages">Languages Spoken <small>required</small></label>
                          <input type="text" name="languages"  value="<?=$profileArray['languages']?>"  required placeholder="e.g english,twi" id="languages" class="form-control">
                          <small class="text-muted">separate with comma</small>
                      </div> <div class="form-group col-md-6">
                          <label for="religion">Religion <small>required</small></label>
                          <input type="text" name="religion"  value="<?=$profileArray['religion']?>"  placeholder="e.g Christianity" required id="religion" class="form-control">
                      </div>
                  </div>
                  <div class="form-row">

                      <div class="form-group col-md-4">
                          <label for="marital">Marital Status <small>required</small></label>
                          <select class="form-control" required id="marital" name="marital">
                              <option value="" selected disabled>Select Marital Status</option>
                              <option <?php if($profileArray['marital'] == 'Single') : echo "selected"; endif;?>>Single</option>
                              <option  <?php if($profileArray['marital'] == 'Married') : echo "selected"; endif;?>>Married</option>
                              <option  <?php if($profileArray['marital'] == 'Divorced') : echo "selected"; endif;?>>Divorced</option>
                              <option  <?php if($profileArray['marital'] == 'Widowed') : echo "selected"; endif;?>>Widowed</option>
                          </select>
                      </div> <div class="form-group col-md-4">
                          <label for="gender">Gender <small>required</small></label>
                          <div class="form-inline">
                              <div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="gender" id="male"<?php if($profileArray['gender'] == 'male') : echo "checked"; endif;?> value="male">
<label class="form-check-label" for="male">Male</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" <?php if($profileArray['gender'] == 'female') : echo "checked"; endif;?> type="radio" name="gender" id="female" value="female">
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="nationality">Nationality <small>required</small></label>
                      <input type="text" name="nationality"  value="<?=$profileArray['nationality']?>"  required placeholder="e.g Ghanaian" id="nationality" class="form-control">
                  </div>
              </div>
              <div class="form-group">
                <button type="button" onclick="$('.for-contact').trigger('click');" class="btn btn-solid color1 float-right">Next</button>
            </div>
        </div>
        <div class="menu-part tab-pane fade" id="contact">
          <div class="title-1">
              <span class="title-label">Part b</span>
              <h2>Contact Information</h2>
          </div>
          <div class="form-row">
              <div class="form-group col-md-6">
                  <label for="phone">Phone Number <small>required</small></label>
                  <input type="text" class="form-control"  value="<?=$profileArray['phone']?>"  placeholder="phone number" pattern="^\+(?:[0-9]●?){6,14}[0-9]$" name="phone" id="phone" required>
                  <small>phone number must begin with country code</small>
              </div>
              <div class="form-group col-md-6">
                  <label for="email">Email Address <small>required</small></label>
                  <input type="email" class="form-control"  value="<?=$profileArray['email']?>"  placeholder="valid email address" name="email" id="email" required>
              </div>
          </div>
          <div class="form-row">
              <div class="form-group col-md-4">
                  <label for="home_phone">Home Phone</label>
                  <input type="text" class="form-control" placeholder="home phone" pattern="^\+(?:[0-9]●?){6,14}[0-9]$" name="home_phone"  value="<?=$profileArray['home_phone']?>"  id="home_phone" >
                  <small>Home phone must begin with country code</small>
              </div>
              <div class="form-group col-md-4">
                  <label for="postal">Postal Address <small>required</small></label>
                  <input type="text" class="form-control"  value="<?=$profileArray['postal']?>"  placeholder="postal code" name="postal" id="postal" required>
              </div>
              <div class="form-group col-md-4">
                  <label for="residential">Residential Address <small>required</small></label>
                  <input type="text" class="form-control"  value="<?=$profileArray['residential']?>"  placeholder="Residential address" name="residential" id="residential" required>
                  <small class="text-muted">e.g house number, street address</small>
              </div>
          </div>
          <div class="form-row">
             <div class="form-group col-6">
                <button type="button" onclick="$('.for-personal').trigger('click');" class="btn btn-secondary float-left">Previous</button>
            </div>
            <div class="form-group col-6">
             <button type="submit" class="btn btn-solid profile-btn color1 float-right">Save</button>
         </div>
     </div>
 </div>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
               <!-- end of student profile -->
               <div class="tab-pane fade" id="parents">
                <div class="single-section">

                   <div class="description-section tab-section">
                    <div class="menu-top menu-up">
                        <ul class="nav nav-tabs" id="top-tab" role="tablist">
                            <li class="nav-item"><a data-toggle="tab" class="nav-link active for-mother"
                                href="#mother">Mother</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link for-father" href="#father">Father</a>
                                </li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link for-sponsor" href="#sponsor">Sponsor</a>
                                </li>

                            </ul>
                        </div>
                        <form class="parents-form" method="post" enctype="multipart/form-data">
                            <div class="description-details tab-content" id="top-tabContent">
                                <div class="menu-part about tab-pane fade show active" id="mother">

 <div class="title-1">
  <span class="title-label">Part h</span>
  <h2>Mother's Details</h2>
                                </div>

                                <div class="form-row">

  <div class="form-group col-md-6">
      <label for="m_title">Title</label>
      <select class="form-control" name="m_title" id="m_title" required>
          <option value="" selected disabled>Choose title</option>

          <option <?php if($parentsArray['mother']['title'] == 'Mrs.') : echo "selected"; endif;?>>Mrs.</option>
          <option <?php if($parentsArray['mother']['title'] == 'Miss') : echo "selected"; endif;?>>Miss</option>
          <option <?php if($parentsArray['mother']['title'] == 'Rev') : echo "selected"; endif;?>>Rev</option>
          <option <?php if($parentsArray['mother']['title'] == 'Prof') : echo "selected"; endif;?>>Prof</option>
      </select>
  </div>
  <div class="form-group col-md-6">
      <label for="m_religion">Religion <small>required</small></label>
      <input type="text" name="m_religion"  value="<?=$parentsArray['mother']['religion']?>"  placeholder="e.g Christianity" required id="m_religion" class="form-control">
  </div>
                                </div>
                                <div class="form-row">
  <div class="form-group col-md-4">
      <label for="m_fname">First Name <small>required</small></label>
      <input type="text" name="m_fname" value="<?=$parentsArray['mother']['fname']?>" required placeholder="First Name" id="m_fname" class="form-control">
  </div>
  <div class="form-group col-md-4">
      <label for="m_mname">Middle Name</label>
      <input type="text" name="m_mname" value="<?=$parentsArray['mother']['mname']?>" placeholder="Middle Name" id="m_mname" class="form-control">
  </div> <div class="form-group col-md-4">
      <label for="m_sname">Surname(s) <small>required</small></label>
      <input type="text" name="m_sname" value="<?=$parentsArray['mother']['sname']?>"    required placeholder="Surname" id="m_sname" class="form-control">
  </div>
                                </div>
                                <div class="form-row">
  <div class="form-group col-md-4">
      <label for="m_dob">Date of Birth <small>required</small></label>
      <input type="text"  placeholder="YYYY-MM-DD" pattern="(?:19|20)(?:(?:[13579][26]|[02468][048])-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))|(?:[0-9]{2}-(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:29|30))|(?:(?:0[13578]|1[02])-31)))" class="form-control " value="<?=$parentsArray['mother']['dob']?>"  name="m_dob" id="m_dob" required  autocomplete="no">

  </div>
  <div class="form-group col-md-4">
      <label for="m_place">Place of Birth <small>required</small></label>
      <input type="text" name="m_place" value="<?=$parentsArray['mother']['place']?>" required placeholder="Place of Birth" id="m_place" class="form-control">
  </div> <div class="form-group col-md-4">
      <label for="m_hometown">Hometown <small>required</small></label>
      <input type="text" name="m_hometown"  value="<?=$parentsArray['mother']['hometown']?>"  placeholder="Hometown" required id="m_hometown" class="form-control">
  </div>
                                </div>

                                <div class="form-row">

  <div class="form-group col-md-6">
      <label for="m_marital">Marital Status <small>required</small></label>
      <select class="form-control" required id="m_marital" name="m_marital">
          <option value="" selected disabled>Select Marital Status</option>
          <option <?php if($parentsArray['mother']['marital'] == 'Single') : echo "selected"; endif;?>>Single</option>
          <option  <?php if($parentsArray['mother']['marital'] == 'Married') : echo "selected"; endif;?>>Married</option>
          <option  <?php if($parentsArray['mother']['marital'] == 'Divorced') : echo "selected"; endif;?>>Divorced</option>
          <option  <?php if($parentsArray['mother']['marital'] == 'Widowed') : echo "selected"; endif;?>>Widowed</option>
      </select>
  </div> 
  <div class="form-group col-md-6">
      <label for="m_nationality">Nationality <small>required</small></label>
      <input type="text" name="m_nationality"  value="<?=$parentsArray['mother']['nationality']?>"  required placeholder="e.g Ghanaian" id="m_nationality" class="form-control">
  </div>
                                </div>
                                <div class="form-group">
<button type="button" onclick="$('.for-father').trigger('click');" class="btn btn-solid color1 float-right">Next</button>
                              </div>
                          </div>
                          <div class="menu-part tab-pane fade" id="father">
                            <div class="title-1">
                                <h2>Father's Details</h2>
                            </div>
                            <div class="form-row">

                                <div class="form-group col-md-6">
  <label for="f_title">Title</label>
  <select class="form-control" name="f_title" id="f_title" required>
      <option value="" selected disabled>Choose title</option>

      <option <?php if($parentsArray['father']['title'] == 'Mr.') : echo "selected"; endif;?>>Mr.</option>
      <option <?php if($parentsArray['father']['title'] == 'Miss') : echo "selected"; endif;?>>Miss</option>
      <option <?php if($parentsArray['father']['title'] == 'Rev') : echo "selected"; endif;?>>Rev</option>
      <option <?php if($parentsArray['father']['title'] == 'Prof') : echo "selected"; endif;?>>Prof</option>
  </select>
                                </div>
                                <div class="form-group col-md-6">
  <label for="f_religion">Religion <small>required</small></label>
  <input type="text" name="f_religion"  value="<?=$parentsArray['father']['religion']?>"  placeholder="e.g Christianity" required id="f_religion" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
  <label for="f_fname">First Name <small>required</small></label>
  <input type="text" name="f_fname" value="<?=$parentsArray['father']['fname']?>" required placeholder="First Name" id="f_fname" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
  <label for="f_mname">Middle Name</label>
  <input type="text" name="f_mname" value="<?=$parentsArray['father']['mname']?>" placeholder="Middle Name" id="f_mname" class="form-control">
                                </div> <div class="form-group col-md-4">
  <label for="f_sname">Surname(s) <small>required</small></label>
  <input type="text" name="f_sname" value="<?=$parentsArray['father']['sname']?>"    required placeholder="Surname" id="f_sname" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
  <label for="f_dob">Date of Birth <small>required</small></label>
  <input type="text"  placeholder="YYYY-MM-DD" pattern="(?:19|20)(?:(?:[13579][26]|[02468][048])-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))|(?:[0-9]{2}-(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:29|30))|(?:(?:0[13578]|1[02])-31)))" class="form-control " value="<?=$parentsArray['father']['dob']?>"  name="f_dob" id="f_dob" required  >

                                </div>
                                <div class="form-group col-md-4">
  <label for="f_place">Place of Birth <small>required</small></label>
  <input type="text" name="f_place" value="<?=$parentsArray['father']['place']?>" required placeholder="Place of Birth" id="f_place" class="form-control">
                                </div> <div class="form-group col-md-4">
  <label for="f_hometown">Hometown <small>required</small></label>
  <input type="text" name="f_hometown"  value="<?=$parentsArray['father']['hometown']?>"  placeholder="Hometown" required id="f_hometown" class="form-control">
                                </div>
                            </div>

                            <div class="form-row">

                                <div class="form-group col-md-6">
  <label for="f_marital">Marital Status <small>required</small></label>
  <select class="form-control" required id="f_marital" name="f_marital">
      <option value="" selected disabled>Select Marital Status</option>
      <option <?php if($parentsArray['father']['marital'] == 'Single') : echo "selected"; endif;?>>Single</option>
      <option  <?php if($parentsArray['father']['marital'] == 'Married') : echo "selected"; endif;?>>Married</option>
      <option  <?php if($parentsArray['father']['marital'] == 'Divorced') : echo "selected"; endif;?>>Divorced</option>
      <option  <?php if($parentsArray['father']['marital'] == 'Widowed') : echo "selected"; endif;?>>Widowed</option>
  </select>
                                </div> 
                                <div class="form-group col-md-6">
  <label for="f_nationality">Nationality <small>required</small></label>
  <input type="text" name="f_nationality"  value="<?=$parentsArray['father']['nationality']?>"  required placeholder="e.g Ghanaian" id="f_nationality" class="form-control">
                                </div>
                            </div>
                            <d iv class="form-row">
                               <div class="form-group col-6">
<button type="button" onclick="$('.for-mother').trigger('click');" class="btn btn-secondary float-left">Previous</button>
                              </div>
                              <div class="form-group col-6">
<button type="button" onclick="$('.for-sponsor').trigger('click');" class="btn btn-solid float-right">Next</button>
                              </div>
          
     </div>
     <div class="menu-part tab-pane fade" id="sponsor">
      <div class="title-1">
  <span class="title-label">Part i</span>
          <h2>Sponsor's Details</h2>
      </div>
      <div class="form-row">

          <div class="form-group col-md-6">
              <label for="relationship">Relationship</label>
              <select class="form-control" name="relationship" id="relationship" required>
                  <option value="" selected disabled>Select Relation</option>

                  <option <?php if($parentsArray['sponsor']['relation'] == 'Employer') : echo "selected"; endif;?>>Employer</option>
                  <option <?php if($parentsArray['sponsor']['relation'] == 'Parent') : echo "selected"; endif;?>>Parent</option>
                  <option <?php if($parentsArray['sponsor']['relation'] == 'Guardian') : echo "selected"; endif;?>>Guardian</option>
                  
              </select>
          </div>
          <div class="form-group col-md-6">
              <label for="sp_name">Sponsor's Name <small>required</small></label>
              <input type="text" name="sp_name"  value="<?=$parentsArray['sponsor']['name']?>"  placeholder="e.g Christianity" required id="sp_name" class="form-control">
          </div>
      </div>
      <div class="form-row">
          <div class="form-group col-md-6">
              <label for="s_nationality">Nationality <small>required</small></label>
              <input type="text" name="s_nationality" value="<?=$parentsArray['sponsor']['nationality']?>" required placeholder="Sponsor's Nationality" id="s_nationality" class="form-control">
          </div>
          <div class="form-group col-md-6">
              <label for="s_residence">Country of Residence</label>
              <input type="text" name="s_residence" value="<?=$parentsArray['sponsor']['residence']?>" placeholder="Sponsor's Residence" id="s_residence" class="form-control">
          </div> 
      </div>
      <div class="form-group">
              <label for="s_address">Residential Address <small>required</small></label>
              <input type="text"  placeholder="Residential Address" class="form-control " value="<?=$parentsArray['sponsor']['address']?>"  name="s_address" id="s_address" required >

          </div>
      <div class="form-row">
          
          <div class="form-group col-md-6">
              <label for="s_phone">Phone Number <small>required</small></label>
              <input type="text" name="s_phone" value="<?=$parentsArray['sponsor']['phone']?>" required placeholder="Phone Number" pattern="^\+(?:[0-9]●?){6,14}[0-9]$" id="s_phone" class="form-control">
              <small class="text-muted">must begin with country code code</small>
          </div> <div class="form-group col-md-6">
              <label for="s_email">Email Address <small>required</small></label>
              <input type="email" name="s_email"  value="<?=$parentsArray['sponsor']['email']?>"  placeholder="Sponsor's Email Address" required id="s_email" class="form-control">
          </div>
      </div>

      
      <d iv class="form-row">
         <div class="form-group col-6">
          <button type="button" onclick="$('.for-father').trigger('click');" class="btn btn-secondary float-left">Previous</button>
      </div>

      <div class="form-group col-6">
       <button type="submit" class="btn btn-solid parents-btn color1 float-right">Save</button>
   </div>
                                 </div>
                             </div>
                        
                     </form>
                 </div>
             </div>
         </div>
         <!-- referral -->
         <div class="tab-pane fade" id="referral">
                <div class="single-section">

                   <div class="description-section">
                    
                        <form class="referral-form" method="post" enctype="multipart/form-data">
                            <div class="description-details">

 <div class="title-1">
  <span class="title-label">Part j</span>
  <h2>Referral Details (Recommendations)</h2>
                                </div>

                                <div class="form-row">

  <div class="form-group col-md-4">
      <label for="r_title">Title</label>
      <select class="form-control" name="r_title" id="r_title" required>
          <option value="" selected disabled>Choose title</option>
          <option <?php if($referralArray['title'] == 'Mr.') : echo "selected"; endif;?>>Mr.</option>
          <option <?php if($referralArray['title'] == 'Mrs.') : echo "selected"; endif;?>>Mrs.</option>
          <option <?php if($referralArray['title'] == 'Miss') : echo "selected"; endif;?>>Miss</option>
          <option <?php if($referralArray['title'] == 'Rev') : echo "selected"; endif;?>>Rev</option>
          <option <?php if($referralArray['title'] == 'Prof') : echo "selected"; endif;?>>Prof</option>
      </select>
  </div>
  <div class="form-group col-md-8">
      <label for="r_name">Full Name of Referee <small>required</small></label>
      <input type="text" name="r_name"  value="<?=$referralArray['name']?>"  placeholder="Referral's Full Name" required id="r_name" class="form-control">
  </div>
                                </div>
                                <div class="form-row">
   <div class="form-group col-md-6">
      <label for="r_nationality">Nationality <small>required</small></label>
      <input type="text" name="r_nationality"  value="<?=$referralArray['nationality']?>"  required placeholder="e.g Ghanaian" id="r_nationality" class="form-control">
  </div>
  <div class="form-group col-md-6">
      <label for="r_occupation">Occupation / Position <small>required</small></label>
      <input type="text" name="r_occupation" required value="<?=$referralArray['occupation']?>" placeholder="e.g Nurse/ CEO Coca Cola" id="r_occupation" class="form-control">
  </div> 
                                </div>
                                <div class="form-row">
 
  <div class="form-group col-md-6">
      <label for="r_work">Work Address <small>required</small></label>
      <input type="text" name="r_work" value="<?=$referralArray['work']?>" required placeholder="Work Address" id="r_work" class="form-control">
  </div> <div class="form-group col-md-6">
      <label for="r_residence">Residential Address <small>required</small></label>
      <input type="text" name="r_residence"  value="<?=$referralArray['residence']?>"  placeholder="Residential or Home Address" required id="r_residence" class="form-control">
  </div>
                                </div>

                                 <div class="form-row">
          
          <div class="form-group col-md-6">
              <label for="r_phone">Phone Number <small>required</small></label>
              <input type="text" name="r_phone" value="<?=$referralArray['phone']?>" required placeholder="Phone Number" pattern="^\+(?:[0-9]●?){6,14}[0-9]$" id="r_phone" class="form-control">
              <small class="text-muted">must begin with country code code</small>
          </div> <div class="form-group col-md-6">
              <label for="r_email">Email Address <small>required</small></label>
              <input type="email" name="r_email"  value="<?=$referralArray['email']?>"  placeholder="Referee's Email Address" required id="r_email" class="form-control">
          </div>
      </div>
      <div class="form-group">
  <label for="r_date">Date of Recommendation <small>required</small></label>
  <input type="text"  placeholder="YYYY-MM-DD" pattern="(?:19|20)(?:(?:[13579][26]|[02468][048])-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))|(?:[0-9]{2}-(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:29|30))|(?:(?:0[13578]|1[02])-31)))" class="form-control" value="<?=$referralArray['date']?>"  name="r_date" id="r_date" required>

                                </div>
                                <div class="form-group">
<button type="submit"  class="btn referral-btn btn-solid color1 float-right">Save</button>
                              </div>
                                
                             </div>
                        
                     </form>
                 </div>
             </div>
         </div>
         <!-- !end of referral -->
         <div class="tab-pane fade" id="academic">
           <div class="single-section">

               <div class="description-section tab-section">
                <div class="menu-top menu-up">
                    <ul class="nav nav-tabs" id="top-tab" role="tablist">
                        <li class="nav-item"><a data-toggle="tab" class="nav-link active for-jhs"
                            href="#jhs">JHS</a></li>
                            <li class="nav-item"><a data-toggle="tab" class="nav-link for-shs" href="#shs">SHS</a>
                            </li>
                            <li class="nav-item"><a data-toggle="tab" class="nav-link for-tertiary" href="#tertiary">Tertiary</a>
                            </li>

                        </ul>
                    </div>
                    <form class="academic-form" method="post" enctype="multipart/form-data">
                        <div class="description-details tab-content" id="top-tabContent">
                            <div class="menu-part about tab-pane fade show active" id="jhs">

                               <div class="title-1">
                                <span class="title-label">Part c</span>
                                <h2>Junior High School <small>recent</small></h2>
                            </div>
                            <div class="form-group">
                                <label for="jcertification"> Certification <small>*</small></label>
                                <input type="text" class="form-control" id="jcertification" value="<?=$academicArray['jhs']['certification']?>" name="jcertification" required placeholder="e.g BECE">
                            </div>
                            <div class="form-group">
                                <label for="jinstitution"> Name of Institution <small>*</small></label>
                                <input type="text" class="form-control" id="jinstitution" value="<?=$academicArray['jhs']['institution']?>" name="jinstitution" required placeholder="e.g Calvary Baptist">
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
  <label for="jqualification"> Qualifications <small>*</small></label>
  <input type="text" class="form-control" value="<?=$academicArray['jhs']['qualification']?>" id="jqualification" placeholder="Qualifications" name="jqualification" required>
                                </div>
                                <div class="form-group col-md-4">
  <label for="jfromyear"> From <small>*</small></label>
  <input type="number" class="form-control" id="jfromyear" value="<?=$academicArray['jhs']['from']?>" pattern="[0-9]{4}" placeholder="e.g 2002" name="jfromyear" required>
                                </div>
                                <div class="form-group col-md-4">
  <label for="jtoyear"> To <small>*</small></label>
  <input type="number" class="form-control" value="<?=$academicArray['jhs']['to']?>" pattern="[0-9]{4}" id="jtoyear" placeholder="e.g 2005" name="jtoyear" required>
                                </div>
                            </div>
                            <div class="form-group">
                              <button type="button" onclick="$('.for-shs').trigger('click');" class="btn btn-solid color1 float-right">Next</button>
                          </div>
                      </div> 
                      <div class="menu-part tab-pane fade" id="shs">
                         <div class="title-1">
                            <h2>Senior High School <small>recent</small></h2>
                        </div>
                        <div class="form-group">
                            <label for="scertification"> Certification <small>*</small></label>
                            <input type="text" class="form-control" id="scertification" value="<?=$academicArray['shs']['certification']?>" name="scertification" required placeholder="e.g WASSCE">
                        </div>
                        <div class="form-group">
                            <label for="sinstitution"> Name of Institution <small>*</small></label>
                            <input type="text" class="form-control" value="<?=$academicArray['shs']['institution']?>" id="sinstitution" name="sinstitution" required placeholder="e.g St. James Seminary">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="squalification"> Qualifications <small>*</small></label>
                                <input type="text" class="form-control" value="<?=$academicArray['shs']['qualification']?>" id="squalification" placeholder="Qualifications" name="squalification" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="sfromyear"> From <small>*</small></label>
                                <input type="number" class="form-control" value="<?=$academicArray['shs']['from']?>" id="sfromyear" pattern="[0-9]{4}" placeholder="e.g 2005" name="sfromyear" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="stoyear"> To <small>*</small></label>
                                <input type="number" class="form-control" pattern="[0-9]{4}" value="<?=$academicArray['shs']['to']?>" id="stoyear" placeholder="e.g 2009" name="stoyear" required>
                            </div>
                        </div>
                        <div class="form-row">
                           <div class="form-group col-6">
                              <button type="button" onclick="$('.for-jhs').trigger('click');" class="btn btn-secondary float-left">Previous</button>
                          </div>
                          <div class="form-group col-6">
                           <button type="button" onclick="$('.for-tertiary').trigger('click');" class="btn btn-solid color1 float-right">Next</button>
                       </div>
                   </div>
               </div>
               <div class="menu-part tab-pane fade" id="tertiary">
                 <div class="title-1">
                    <h2>Tertiary Institution <small>recent</small></h2>
                </div>
                <div class="form-group">
                    <label for="tinstitution"> Name of Institution </label>
                    <input type="text" class="form-control" id="tinstitution" value="<?=$academicArray['tertiary']['institution']?>" name="tinstitution" placeholder="e.g University of Energy and Natural Resources  ">
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="tqualification"> Qualifications </label>
                        <input type="text" class="form-control" value="<?=$academicArray['tertiary']['qualification']?>" id="tqualification" placeholder="Qualifications" name="tqualification" >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="tfromyear"> From </label>
                        <input type="number" class="form-control" value="<?=$academicArray['tertiary']['from']?>" id="tfromyear" pattern="[0-9]{4}" placeholder="e.g 2005" name="tfromyear" >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="ttoyear"> To </label>
                        <input type="number" class="form-control" value="<?=$academicArray['tertiary']['to']?>" pattern="[0-9]{4}" id="ttoyear" placeholder="e.g 2009" name="ttoyear" >
                    </div>
                </div>

                <div class="form-row">
                   <div class="form-group col-6">
                      <button type="button" onclick="$('.for-shs').trigger('click');" class="btn btn-secondary float-left">Previous</button>
                  </div>
                  <div class="form-group col-6">
                   <button type="submit" class="btn btn-solid academic-btn color1 float-right">Save</button>
               </div>
           </div>
       </div>
   </div> 
</form>
</div>
</div>
</div>
<div class="tab-pane fade" id="program">
  <div class="single-section">

   <div class="description-section tab-section">
    <div class="menu-top menu-up">
        <ul class="nav nav-tabs" id="top-tab" role="tablist">
            <li class="nav-item"><a data-toggle="tab" class="nav-link active for-program"
                href="#degree">Program</a></li>
                <li class="nav-item"><a data-toggle="tab" class="nav-link for-1st" href="#1st">1st School</a>
                </li>
                <li class="nav-item"><a data-toggle="tab" class="nav-link for-2nd" href="#2nd">2nd School</a>
                </li>
                <li class="nav-item"><a data-toggle="tab" class="nav-link for-3rd" href="#3rd">3rd School</a>
                </li>

            </ul>
        </div>
        <form class="program-form" method="post" enctype="multipart/form-data">
            <div class="description-details tab-content" id="top-tabContent">
                <div class="menu-part about tab-pane fade show active" id="degree">
                    <div class="title-1">
                        <span class="title-label">Part d</span>
                        <h2>Degree Programme</h2>
                        <h5>Select the intended program you want to pursue</h5>
                    </div>
                    <div class="form-group">
                        <label for="pos">Degree Programme <small>*</small></label>
                        <select class="form-control" id="pos" name="pos" required>
                            <option value="" >Select Program</option>
                            <option <?php if($programArray['program'] == 'Diploma') : echo "selected"; endif;?> >Diploma</option>
                            <option <?php if($programArray['program'] == 'Undergraduate') : echo "selected"; endif;?>>Undergraduate</option>
                            <option <?php if($programArray['program'] == 'Postgraduate') : echo "selected"; endif;?>>Postgraduate</option>
                            <option <?php if($programArray['program'] == 'Doctorate') : echo "selected"; endif;?>>Doctorate</option>
                        </select>
                    </div>
                    <div class="form-group">
                      <button type="button" onclick="$('.for-1st').trigger('click');" class="btn btn-solid color1 float-right">Next</button>
                  </div>
              </div>
              <div class="menu-part tab-pane fade" id="1st">
                 <div class="title-1">
                    <h2>Program of Study</h2>
                    <small>It is required to fill up this section </small>
                </div>
                <div class="form-group">
                    <label for="1st_school">Select School <small>*</small></label>
                    <select class="form-control" id="1st_school" name="1st_school" required>
                        <option value="" selected disabled>Select School</option>
                        <?php 
                        if (!empty($programArray['1st']['name'])) {
                            $pg = $programArray['1st']['name'];

                            $pql = "SELECT * FROM ng_schools WHERE id = ? ";
                            $pstmt = $db->prepare($pql);
                            $pstmt->bind_param('s',$pg);
                            $pstmt->execute();
                            $pres = $pstmt->get_result();
                            $prow = $pres->fetch_assoc();

                            echo "<option value='".encode($prow['id'],'e')."' selected>".test_output($prow['name'])."</option>";
                        }
                        ?>
                        <?php  $sql = "SELECT * FROM ng_schools WHERE enabled  = ? ORDER BY id DESC";
                        $stmt = $db->prepare($sql);
                        $enabled = 'yes';
                        $stmt->bind_param('s',$enabled);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($row = $res->fetch_assoc()) : ?>
                            <option value="<?=encode($row['id'],'e')?>"><?=test_output($row['name']); ?></option>

                        <?php endwhile; if($res->num_rows == 0) :?>
                        <option disabled value="">No schools available</option>
                    <?php endif;?>
                </select>
            </div>
            <div class="form-group">
                <label for="1st_choice_1st">1st Choice <small>*</small></label>
                <input type="text" class="form-control" value="<?=$programArray['1st']['1st_choice']?>" id="1st_choice_1st" name="1st_choice_1st" required>
            </div>
            <div class="form-group">
                <label for="1st_choice_2nd">2nd Choice <small>*</small></label>
                <input type="text" class="form-control" value="<?=$programArray['1st']['2nd_choice']?>"  id="1st_choice_2nd" name="1st_choice_2nd" required>
            </div>
            <div class="form-group">
                <label for="1st_choice_3rd">3rd Choice <small>*</small></label>
                <input type="text" class="form-control" value="<?=$programArray['1st']['3rd_choice']?>"  id="1st_choice_3rd" name="1st_choice_3rd" required>
            </div>
            <div class="form-row">
               <div class="form-group col-6">
                  <button type="button" onclick="$('.for-program').trigger('click');" class="btn btn-secondary float-left">Previous</button>
              </div>
              <div class="form-group col-6">
               <button type="button" onclick="$('.for-2nd').trigger('click');" class="btn btn-solid color1 float-right">Next</button>
           </div>
       </div>
   </div>
   <div class="menu-part tab-pane fade" id="2nd">
     <div class="title-1">
        <h2>Program of Study</h2>
        <small>You can choose a second school. School must be different from the the first school. </small>
        <p class="text-danger">If you choose a second school, it is required to fill up all the choices below from 1st to 3rd</p>
    </div>
    <div class="form-group">
        <label for="2nd_school">Select School <em>2nd</em></label>
        <select class="form-control" id="2nd_school" name="2nd_school" >
            <option value="nonefor2nd" selected>Select School</option>

            <?php 
            if (!empty($programArray['2nd']['name'])) {
             $pg = $programArray['2nd']['name'];

             $pql = "SELECT * FROM ng_schools WHERE id = ? ";
             $pstmt = $db->prepare($pql);
             $pstmt->bind_param('s',$pg);
             $pstmt->execute();
             $pres = $pstmt->get_result();
             $prow = $pres->fetch_assoc();

             echo "<option value='".encode($prow['id'],'e')."' selected>".test_output($prow['name'])."</option>";
         }
         ?>
         <?php  $sql = "SELECT * FROM ng_schools WHERE enabled  = ? ORDER BY id DESC";
         $stmt = $db->prepare($sql);
         $enabled = 'yes';
         $stmt->bind_param('s',$enabled);
         $stmt->execute();
         $res = $stmt->get_result();
         while ($row = $res->fetch_assoc()) : ?>
            <option value="<?=encode($row['id'],'e')?>"><?=test_output($row['name']); ?></option>

        <?php endwhile; if($res->num_rows == 0) :?>
        <option disabled value="">No schools available</option>
    <?php endif;?>
</select>
</div>
<div class="form-group">
    <label for="2nd_choice_1st">1st Choice </label>
    <input type="text" class="form-control" value="<?=$programArray['2nd']['1st_choice']?>"  id="2nd_choice_1st" name="2nd_choice_1st" >
</div>
<div class="form-group">
    <label for="2nd_choice_2nd">2nd Choice</label>
    <input type="text" class="form-control" value="<?=$programArray['2nd']['2nd_choice']?>"  id="2nd_choice_2nd" name="2nd_choice_2nd" >
</div>
<div class="form-group">
    <label for="2nd_choice_3rd">3rd Choice </label>
    <input type="text" class="form-control" value="<?=$programArray['2nd']['3rd_choice']?>"  id="2nd_choice_3rd" name="2nd_choice_3rd">
</div>
<div class="form-row">
   <div class="form-group col-6">
      <button type="button" onclick="$('.for-1st').trigger('click');" class="btn btn-secondary float-left">Previous</button>
  </div>
  <div class="form-group col-6">
   <button type="button" onclick="$('.for-3rd').trigger('click');" class="btn btn-solid color1 float-right">Next</button>
</div>
</div>
</div>
<div class="menu-part tab-pane fade" id="3rd">
 <div class="title-1">
    <h2>Program of Study</h2>
    <small>You can choose a third school. School must be different from the the first and second school. </small>
    <p class="text-danger">If you choose a third school, it is required to fill up all the choices below from 1st to 3rd</p>
</div>
<div class="form-group">
    <label for="3rd_school">Select School <em>3rd</em></label>
    <select class="form-control" id="3rd_school" name="3rd_school" >
        <option value="nonefor3rd" selected>Select School</option>


        <?php 
        if (!empty($programArray['3rd']['name'])) {
            $pg = $programArray['3rd']['name'];

            $pql = "SELECT * FROM ng_schools WHERE id = ? ";
            $pstmt = $db->prepare($pql);
            $pstmt->bind_param('s',$pg);
            $pstmt->execute();
            $pres = $pstmt->get_result();
            $prow = $pres->fetch_assoc();

            echo "<option value='".encode($prow['id'],'e')."' selected>".test_output($prow['name'])."</option>";
        }
        ?>
        <?php  $sql = "SELECT * FROM ng_schools WHERE enabled  = ? ORDER BY id DESC";
        $stmt = $db->prepare($sql);
        $enabled = 'yes';
        $stmt->bind_param('s',$enabled);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) : ?>
            <option value="<?=encode($row['id'],'e')?>"><?=test_output($row['name']); ?></option>

        <?php endwhile; if($res->num_rows == 0) :?>
        <option disabled value="">No schools available</option>
    <?php endif;?>
</select>
</div>
<div class="form-group">
    <label for="3rd_choice_1st">1st Choice </label>
    <input type="text" class="form-control" value="<?=$programArray['3rd']['1st_choice']?>"  id="3rd_choice_1st" name="3rd_choice_1st" >
</div>
<div class="form-group">
    <label for="3rd_choice_2nd">2nd Choice </label>
    <input type="text" class="form-control" value="<?=$programArray['3rd']['2nd_choice']?>"  id="3rd_choice_2nd" name="3rd_choice_2nd" >
</div>
<div class="form-group">
    <label for="3rd_choice_3rd">3rd Choice </label>
    <input type="text" class="form-control" value="<?=$programArray['3rd']['2nd_choice']?>"  id="3rd_choice_3rd" name="3rd_choice_3rd" >
</div>
<div class="form-row">
   <div class="form-group col-6">
      <button type="button" onclick="$('.for-2nd').trigger('click');" class="btn btn-secondary float-left">Previous</button>
  </div>
  <div class="form-group col-6">
   <button type="submit" class="btn btn-solid program-btn color1 float-right">Save</button>
</div>
</div>
</div>
</div>
</form>
</div>
</div>

</div>
<div class="tab-pane fade" id="documents">
   
    <div class="dashboard-box">
        <div class="dashboard-title">
            <h4>My Documents</h4>
        </div>
        <div class="product-wrapper-grid ratio2_1  special-section grid-box">
            <div class="row content grid">
                <form class="documents-form" style="width: 100%" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Passport</label>
                            <input type="file" name="passport" class="form-control"  id="passport" accept=".doc,.docx,.pdf,.jpeg,.jpg,.png">
                            <input type="hidden" name="passport_default" value="<?=base64_encode(json_encode(array('name'=> $documentsArray['passport']['name'], 'type'=> $documentsArray['passport']['type'],'path'=>$documentsArray['passport']['path'])))?>">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <?php if(!empty($documentsArray['passport']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

  switch (($documentsArray['passport']['type'])) {
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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['passport']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['passport']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['passport']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['passport']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                                <a href="#!" class="delete-document" data-doc="<?=encode('passport','e');?>" data-toggle="tooltip"
                                data-placement="top" title="Delete"><i
                                class="fas fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                        </div>
                    </div>      <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Birth Certificate </label>
                            <input type="file" name="birth_cert" class="form-control" id="birth_cert" accept=".doc,.docx,.pdf,.jpeg,.jpg,.png">
                            <input type="hidden" name="birthcert_default" value="<?=base64_encode(json_encode(array('name'=>$documentsArray['birthcert']['name'],'type'=>$documentsArray['birthcert']['type'],'path'=>$documentsArray['birthcert']['path'])))?>">
                        </div>
                        <input type="hidden" name="docsupload">
                        <div class="form-group col-md-4">
                            <?php if(!empty($documentsArray['birthcert']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['birthcert']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['birthcert']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['birthcert']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['birthcert']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                                <a href="#!" class="delete-document" data-doc="<?=encode('birthcert','e');?>" data-toggle="tooltip"
                                data-placement="top" title="Delete"><i
                                class="fas fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                        </div>
                    </div><div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Wassce Certificate</label>
                            <input type="file" name="wassce_cert" class="form-control" id="wassce_cert" accept=".doc,.docx,.pdf,.jpeg,.jpg,.png">
                            <input type="hidden" name="wasscecert_default" value="<?=base64_encode(json_encode(array('name'=>$documentsArray['wasscecert']['name'],'type'=>$documentsArray['wasscecert']['type'],'path'=>$documentsArray['wasscecert']['path'])))?>">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <?php if(!empty($documentsArray['wasscecert']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['wasscecert']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['wasscecert']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['wasscecert']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['wasscecert']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                                <a href="#!" class="delete-document" data-doc="<?=encode('wasscecert','e');?>" data-toggle="tooltip"
                                data-placement="top" title="Delete"><i
                                class="fas fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                        </div>
                    </div>
                   <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Academic Degree Certificate</label>
                            <input type="file" name="aca_cert" class="form-control" id="aca_cert" accept=".doc,.docx,.pdf,.jpeg,.jpg,.png">
                            <input type="hidden" name="acacert_default" value="<?=base64_encode(json_encode(array('name'=>$documentsArray['acacert']['name'],'type'=>$documentsArray['acacert']['type'],'path'=>$documentsArray['acacert']['path'])))?>">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <?php if(!empty($documentsArray['acacert']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['acacert']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['acacert']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['acacert']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['acacert']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                                <a href="#!" class="delete-document" data-doc="<?=encode('acacert','e');?>" data-toggle="tooltip"
                                data-placement="top" title="Delete"><i
                                class="fas fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Academic Transcript Records</label>
                            <input type="file" name="transcripts" class="form-control" id="transcripts" accept=".doc,.docx,.pdf">
                            <input type="hidden" name="transcripts_default" value="<?=base64_encode(json_encode(array('name'=>$documentsArray['transcripts']['name'],'type'=>$documentsArray['transcripts']['type'],'path'=>$documentsArray['transcripts']['path'])))?>">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <?php if(!empty($documentsArray['transcripts']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['transcripts']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['transcripts']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['transcripts']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['transcripts']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                                <a href="#!" class="delete-document" data-doc="<?=encode('transcripts','e');?>" data-toggle="tooltip"
                                data-placement="top" title="Delete"><i
                                class="fas fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>IELTS Results Form</label>
                            <input type="file" name="ielts" class="form-control" id="ielts" accept=".doc,.docx,.pdf">
                            <input type="hidden" name="ielts_default" value="<?=base64_encode(json_encode(array('name'=>$documentsArray['ielts']['name'],'type'=>$documentsArray['ielts']['type'],'path'=>$documentsArray['ielts']['path'])))?>">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <?php if(!empty($documentsArray['ielts']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['ielts']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['ielts']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['ielts']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['ielts']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                                <a href="#!" class="delete-document" data-doc="<?=encode('ielts','e');?>" data-toggle="tooltip"
                                data-placement="top" title="Delete"><i
                                class="fas fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                        </div>
                    </div><div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Bank Account Statement</label>
                            <input type="file" name="bank" class="form-control" id="bank" accept=".doc,.docx,.pdf">
                            <input type="hidden" name="bank_default" value="<?=base64_encode(json_encode(array('name'=>$documentsArray['bank']['name'],'type'=>$documentsArray['bank']['type'],'path'=>$documentsArray['bank']['path'])))?>">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <?php if(!empty($documentsArray['bank']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['bank']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['bank']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['bank']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['bank']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                                <a href="#!" class="delete-document" data-doc="<?=encode('bank','e');?>" data-toggle="tooltip"
                                data-placement="top" title="Delete"><i
                                class="fas fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                        </div>
                    </div>
                     <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Academic Reference</label>
                            <input type="file" name="reference" class="form-control" id="reference" accept=".doc,.docx,.pdf">
                            <input type="hidden" name="reference_default" value="<?=base64_encode(json_encode(array('name'=>$documentsArray['reference']['name'],'type'=>$documentsArray['reference']['type'],'path'=>$documentsArray['reference']['path'])))?>">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <?php if(!empty($documentsArray['reference']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['reference']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['reference']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['reference']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['reference']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                                <a href="#!" class="delete-document" data-doc="<?=encode('reference','e');?>" data-toggle="tooltip"
                                data-placement="top" title="Delete"><i
                                class="fas fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                        </div>
                    </div>
                     <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Personal Statement <small>required</small></label>
                            <input type="file" name="statement" class="form-control" id="statement" accept=".doc,.docx,.pdf">
                            <input type="hidden" name="statement_default" value="<?=base64_encode(json_encode(array('name'=>$documentsArray['statement']['name'],'type'=>$documentsArray['statement']['type'],'path'=>$documentsArray['statement']['path'])))?>">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <?php if(!empty($documentsArray['statement']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['statement']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['statement']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['statement']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['statement']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                                <a href="#!" class="delete-document" data-doc="<?=encode('statement','e');?>" data-toggle="tooltip"
                                data-placement="top" title="Delete"><i
                                class="fas fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                        </div>
                    </div>
                     
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Sponsorship Letter</label>
                            <input type="file" name="sponsorship" class="form-control" id="sponsorship" accept=".doc,.docx,.pdf">
                            <input type="hidden" name="sponsorship_default" value="<?=base64_encode(json_encode(array('name'=>$documentsArray['sponsorship']['name'],'type'=>$documentsArray['sponsorship']['type'],'path'=>$documentsArray['sponsorship']['path'])))?>">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <?php if(!empty($documentsArray['sponsorship']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['sponsorship']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['sponsorship']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['sponsorship']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['sponsorship']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                                <a href="#!" class="delete-document" data-doc="<?=encode('sponsorship','e');?>" data-toggle="tooltip"
                                data-placement="top" title="Delete"><i
                                class="fas fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                        </div>
                    </div>
                     
                    <div class="progress" style="display: none;">
  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
</div>
                    <div class="form-group mt-2">
   <button type="submit" class="btn btn-solid documents-btn color1 float-right">Save</button>
</div>
              </form>
            </div>
        </div>
    </div>
</div>
<div class="tab-pane fade" id="review">
    <div class="dashboard-box">
        
        <div class="dashboard-detail">
            <div class="row">
                <div class="col-md-6"><div class="dashboard-title">
            <h4>Profile</h4>
        </div>
                <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td><?=test_output($profileArray['title'] ." ". $profileArray['fname'] ." ". $profileArray['mname']." ".$profileArray['sname']) ?></td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td><?=test_output($profileArray['dob']) ?></td>
                    </tr>
                    <tr>
                        <th>Place of Birth</th>
                        <td><?=test_output($profileArray['place']) ?></td>
                    </tr>
                    <tr>
                        <th>Hometown</th>
                        <td><?=test_output($profileArray['hometown']) ?></td>
                    </tr>
                    <tr>
                        <th>Languages</th>
                        <td><?=test_output($profileArray['languages']) ?></td>
                    </tr>
                    <tr>
                        <th>Religion</th>
                        <td><?=test_output($profileArray['religion']) ?></td>
                    </tr>
                    <tr>
                        <th>Marital Status</th>
                        <td><?=test_output($profileArray['marital']) ?></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td><?=test_output($profileArray['gender']) ?></td>
                    </tr>
                    <tr>
                        <th>Nationality</th>
                        <td><?=test_output($profileArray['nationality']) ?></td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td><?=test_output($profileArray['phone']) ?></td>
                    </tr>
                    <tr>
                        <th>Email Address</th>
                        <td><?=test_output($profileArray['email']) ?></td>
                    </tr>
                    <tr>
                        <th>Home Phone</th>
                        <td><?=test_output($profileArray['home_phone']) ?></td>
                    </tr>
                    <tr>
                        <th>Postal Address</th>
                        <td><?=test_output($profileArray['postal']) ?></td>
                    </tr>
                    <tr>
                        <th>Residential Address</th>
                        <td><?=test_output($profileArray['residential']) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
         <div class="dashboard-title">
            <h4>Academic</h4>
        </div>
        <h5>Junior High School</h5>
         <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th>Certification</th>
                        <td><?=test_output($academicArray['jhs']['certification']) ?></td>
                    </tr>
                     <tr>
                        <th>Institution</th>
                        <td><?=test_output($academicArray['jhs']['institution']) ?></td>
                    </tr>
                     <tr>
                        <th>Qualifications</th>
                        <td><?=test_output($academicArray['jhs']['qualification']) ?></td>
                    </tr>
                     <tr>
                        <th>From</th>
                        <td><?=test_output($academicArray['jhs']['from']) ?></td>
                    </tr>
                     <tr>
                        <th>To</th>
                        <td><?=test_output($academicArray['jhs']['to']) ?></td>
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
                        <td><?=test_output($academicArray['shs']['certification']) ?></td>
                    </tr>
                     <tr>
                        <th>Institution</th>
                        <td><?=test_output($academicArray['shs']['institution']) ?></td>
                    </tr>
                     <tr>
                        <th>Qualifications</th>
                        <td><?=test_output($academicArray['shs']['qualification']) ?></td>
                    </tr>
                     <tr>
                        <th>From</th>
                        <td><?=test_output($academicArray['shs']['from']) ?></td>
                    </tr>
                     <tr>
                        <th>To</th>
                        <td><?=test_output($academicArray['shs']['to']) ?></td>
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
                        <td><?=test_output($academicArray['tertiary']['institution']) ?></td>
                    </tr>
                     <tr>
                        <th>Qualifications</th>
                        <td><?=test_output($academicArray['tertiary']['qualification']) ?></td>
                    </tr>
                     <tr>
                        <th>From</th>
                        <td><?=test_output($academicArray['tertiary']['from']) ?></td>
                    </tr>
                     <tr>
                        <th>To</th>
                        <td><?=test_output($academicArray['tertiary']['to']) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="dashboard-title">
            <h4>Program of Study</h4>
        </div>
            <div class="table-responsive">
            <table class="table">
                <tbody>
                     <tr>
                        <th>Degree Program</th>
                        <td><?=test_output($programArray['program']) ?></td>
                    </tr>
                     
                </tbody>
            </table>
        </div>
        <h5>School one</h5>
         <div class="table-responsive">
            <table class="table">
                <tbody>
                     <tr>
                        <th>School</th>
                        <td><?=test_output(fetchSchoolName($programArray['1st']['name'])) ?></td>
                    </tr>
                      <tr>
                        <th>1st choice</th>
                        <td><?=test_output($programArray['1st']['1st_choice']) ?></td>
                    </tr>
                     <tr>
                        <th>2nd choice</th>
                        <td><?=test_output($programArray['1st']['2nd_choice']) ?></td>
                    </tr>
                    <tr>
                        <th>3rd choice</th>
                        <td><?=test_output($programArray['1st']['3rd_choice']) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h5>School two</h5>
         <div class="table-responsive">
            <table class="table">
                <tbody>
                     <tr>
                        <th>School</th>
                        <td><?=test_output(fetchSchoolName($programArray['2nd']['name'])) ?></td>
                    </tr>
                      <tr>
                        <th>1st choice</th>
                        <td><?=test_output($programArray['2nd']['1st_choice']) ?></td>
                    </tr>
                     <tr>
                        <th>2nd choice</th>
                        <td><?=test_output($programArray['2nd']['2nd_choice']) ?></td>
                    </tr>
                    <tr>
                        <th>3rd choice</th>
                        <td><?=test_output($programArray['2nd']['3rd_choice']) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h5>School three</h5>
         <div class="table-responsive">
            <table class="table">
                <tbody>
                     <tr>
                        <th>School</th>
                        <td><?=test_output(fetchSchoolName($programArray['3rd']['name'])) ?></td>
                    </tr>
                      <tr>
                        <th>1st choice</th>
                        <td><?=test_output($programArray['3rd']['1st_choice']) ?></td>
                    </tr>
                     <tr>
                        <th>2nd choice</th>
                        <td><?=test_output($programArray['3rd']['2nd_choice']) ?></td>
                    </tr>
                    <tr>
                        <th>3rd choice</th>
                        <td><?=test_output($programArray['3rd']['3rd_choice']) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
            <div class="col-md-6">
                 <div class="dashboard-title">
            <h4>Parents & Sponsor</h4>
        </div>
        <h5>Mother's Details</h5>
         <div class="table-responsive">
            <table class="table">
                <tbody>
                     <tr>
                        <th>Name</th>
                        <td><?=test_output($parentsArray['mother']['title'] . " ". $parentsArray['mother']['fname'] . " ". $parentsArray['mother']['mname'] . " ". $parentsArray['mother']['sname']) ?></td>
                    </tr>
                      <tr>
                        <th>Date of Birth</th>
                        <td><?=test_output($parentsArray['mother']['dob']) ?></td>
                    </tr>
                     <tr>
                        <th>Place of Birth</th>
                        <td><?=test_output($parentsArray['mother']['place']) ?></td>
                    </tr>
                    <tr>
                        <th>Hometown</th>
                        <td><?=test_output($parentsArray['mother']['hometown']) ?></td>
                    </tr>
                     <tr>
                        <th>Marital</th>
                        <td><?=test_output($parentsArray['mother']['marital']) ?></td>
                    </tr>
                     <tr>
                        <th>Nationality</th>
                        <td><?=test_output($parentsArray['mother']['nationality']) ?></td>
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
                        <td><?=test_output($parentsArray['father']['title'] . " ". $parentsArray['father']['fname'] . " ". $parentsArray['father']['mname'] . " ". $parentsArray['father']['sname']) ?></td>
                    </tr>
                      <tr>
                        <th>Date of Birth</th>
                        <td><?=test_output($parentsArray['father']['dob']) ?></td>
                    </tr>
                     <tr>
                        <th>Place of Birth</th>
                        <td><?=test_output($parentsArray['father']['place']) ?></td>
                    </tr>
                    <tr>
                        <th>Hometown</th>
                        <td><?=test_output($parentsArray['father']['hometown']) ?></td>
                    </tr>
                     <tr>
                        <th>Marital</th>
                        <td><?=test_output($parentsArray['father']['marital']) ?></td>
                    </tr>
                     <tr>
                        <th>Nationality</th>
                        <td><?=test_output($parentsArray['father']['nationality']) ?></td>
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
                        <td><?=test_output($parentsArray['sponsor']['name']) ?></td>
                    </tr>
                      <tr>
                        <th>Relationship</th>
                        <td><?=test_output($parentsArray['sponsor']['relation']) ?></td>
                    </tr>
                     <tr>
                        <th>Nationality</th>
                        <td><?=test_output($parentsArray['sponsor']['nationality']) ?></td>
                    </tr>
                    <tr>
                        <th>Country of Residence</th>
                        <td><?=test_output($parentsArray['sponsor']['residence']) ?></td>
                    </tr>
                     <tr>
                        <th>Residential Address</th>
                        <td><?=test_output($parentsArray['sponsor']['address']) ?></td>
                    </tr>
                     <tr>
                        <th>Phone Number</th>
                        <td><?=test_output($parentsArray['sponsor']['phone']) ?></td>
                    </tr>
                    <tr>
                        <th>Email Address</th>
                        <td><?=test_output($parentsArray['sponsor']['email']) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
        <div class="dashboard-title">
            <h4>Referral</h4>
        </div>
            <div class="table-responsive">
            <table class="table">
                <tbody>
                     <tr>
                        <th>Name</th>
                        <td><?=test_output($referralArray['title']." ". $referralArray['name']) ?></td>
                    </tr>
                      <tr>
                        <th>Nationality</th>
                        <td><?=test_output($referralArray['nationality']) ?></td>
                    </tr>
                     <tr>
                        <th>Occupation/Position</th>
                        <td><?=test_output($referralArray['occupation']) ?></td>
                    </tr>
                    <tr>
                        <th>Work Address</th>
                        <td><?=test_output($referralArray['work']) ?></td>
                    </tr>
                     <tr>
                        <th>Residential Address</th>
                        <td><?=test_output($referralArray['residence']) ?></td>
                    </tr>
                     <tr>
                        <th>Phone Number</th>
                        <td><?=test_output($referralArray['phone']) ?></td>
                    </tr>
                    <tr>
                        <th>Email Address</th>
                        <td><?=test_output($referralArray['email']) ?></td>
                    </tr>
                    <tr>
                        <th>Date of Recommendation</th>
                        <td><?=test_output($referralArray['date']) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
            </div>
            <div class="col-12">
                 <div class="dashboard-title">
            <h4>Documents</h4>
        </div>
        <div class="special-section ratio3_2 product-wrapper-grid grid-box">
            <div class="row content grid">
                <div class="col-xl-4 col-sm-6 grid-item">
                <div class="dashboard-title"><h5>Passport Document</h5></div>
                    <?php if(!empty($documentsArray['passport']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

  switch (($documentsArray['passport']['type'])) {
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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['passport']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['passport']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['passport']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['passport']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                                
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                 </div>
                
                 <div class="col-xl-4 col-sm-6 grid-item">
                <div class="dashboard-title"><h5>Birth Certificate</h5></div>
            <?php if(!empty($documentsArray['birthcert']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['birthcert']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['birthcert']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['birthcert']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['birthcert']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                               
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                 </div>

                  <div class="col-xl-4 col-sm-6 grid-item">
                <div class="dashboard-title"><h5>Wassce Certificate</h5></div>
                 <?php if(!empty($documentsArray['wasscecert']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['wasscecert']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['wasscecert']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['wasscecert']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['wasscecert']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                               
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                 </div>

                  <div class="col-xl-4 col-sm-6 grid-item">
                <div class="dashboard-title"><h5>Academic Degree Certificate</h5></div>
                     <?php if(!empty($documentsArray['acacert']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['acacert']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['acacert']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['acacert']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['acacert']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                                
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                 </div>

                  <div class="col-xl-4 col-sm-6 grid-item">
                <div class="dashboard-title"><h5>Academic Transcript Records</h5></div>
                      <?php if(!empty($documentsArray['transcripts']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['transcripts']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['transcripts']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['transcripts']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['transcripts']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                               
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                 </div>

                  <div class="col-xl-4 col-sm-6 grid-item">
                <div class="dashboard-title"><h5>IELTS Results Form</h5></div>
                     <?php if(!empty($documentsArray['ielts']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['ielts']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['ielts']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['ielts']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['ielts']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                                
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                 </div>

                  <div class="col-xl-4 col-sm-6 grid-item">
                <div class="dashboard-title"><h5>Bank Account Statement</h5></div>
                     <?php if(!empty($documentsArray['bank']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['bank']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['bank']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['bank']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['bank']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                               
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                 </div>

                  <div class="col-xl-4 col-sm-6 grid-item">
                <div class="dashboard-title"><h5>Academic Reference</h5></div>
                 <?php if(!empty($documentsArray['reference']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['reference']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['reference']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['reference']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['reference']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                                
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                 </div>

                  <div class="col-xl-4 col-sm-6 grid-item">
                <div class="dashboard-title"><h5>Personal Statement</h5></div>
             <?php if(!empty($documentsArray['statement']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['statement']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['statement']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['statement']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['statement']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                                
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                 </div>

                  <div class="col-xl-4 col-sm-6 grid-item">
                <div class="dashboard-title"><h5>SPonsorship Letter</h5></div>
             <?php if(!empty($documentsArray['sponsorship']['name'])) { ?>
                            <div class="special-box">
                        <div class="special-img">
                            <a href="#">
                                <?php 

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
                                <img src="/assets/images/<?=$file?>"
                                class="img-fluid blur-up lazyload bg-img" alt="<?=$documentsArray['sponsorship']['name']?>">
                            </a>
                            <div class="content_inner">
                                <a href="#">
  <h5><?=$documentsArray['sponsorship']['name']?></h5>
                                </a>
                                <h6><?=fileSize_formatted("assets/files/".$documentsArray['sponsorship']['path'])?></h6>
                            </div>
                            <div class="top-icon">
                                <a href="/download/<?=$documentsArray['sponsorship']['path']?>"  data-toggle="tooltip"
                                data-placement="top" title="Download"><i
                                class="fas fa-download"></i></a>
                                
                            </div>
                        </div>
                    </div>
                <?php } else { ?> <div class="jumbotron"> <p class="text-center">Not uploaded</p></div> <?php } ?>
                 </div>                
        </div>
    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
             <div class="title-1">
                <span class="title-label">final</span>
                <h2>terms and conditions</h2>
            </div>

          <h4>inclusion</h4>
          <ul class="list-unstyled">
              <li> <b>1. &nbsp;</b>I fully recognize that Naam Global Educational Service a registered company in Ghana is committed to 
offering academic pursuit, developing human potential and to compete and lead changing needs in the 
global environment of higher learning.</li>
              <li><b>2. &nbsp;</b> I fully recognize  that  in signing  this  pledge, I  become  part  of  a  purpose  driven  community Institution, 
renewal and technological, bolstered by knowledge and ethical values.</li>
              <li><b>3. &nbsp;</b> I pledge to cultivate good social relationships, treating others as, I would have myself treated. I will refrain 
from lies, using improper language, fake/false documents in the course of this Application.</li>
              <li> <b>4. &nbsp;</b>Registration fee of £100.00 equivalent in GHS Non Refundable. </li>
              <li> <b>5. &nbsp;</b>Willful termination of our services by client. The client get a refund and a deduction of  £350 or its 
equivalent in GHS from the total money paid to Naam Global.  All work done, the cost involved and 
expenses is solely borne by the client.</li>
              <li> <b>6. &nbsp;</b> Normal Visa Charges of Schengen</li>
              <li> <b>7. &nbsp;</b> Any refund due the client will be paid within 48 working days from the date of notice.</li>
              <li> <b>8. &nbsp;</b> Any school fees paid to Naam will be refunded in accordance with the College/University refund policy.</li>
              <li><b>9. &nbsp;</b> We are not obliged to take clients to various institutions Airports and embassies Butas a good will gesture, 
we will do that only if the client agrees to pay for the Transportation for our worker.</li>
          </ul>
          <p class="mt-3"><em>I will  keep this pledge to the best of my ability. Failure to follow this Terms / Conditions would allow Naam 
Global Educational Service Ghana to terminate my Application process</em></p>

    <p class="font-weight-bold text-danger">Make sure you have fully reviewed your details before submitting. No changes can be made after submission </p>

            <form class="review-form" method="post" enctype="multipart/form-data">
            <div class="form-group form-check">
                <input type="hidden" name="finished" value="finished">
                <input type="checkbox" class="form-check-input" value="yes" name="agree" id="agree">
                <label class="form-check-label" for="agree">By submitting my application, I agree to the above terms and conditions</label>
            </div>
             <div class="button-bottom">
                <button type="submit" class="w-100 btn btn-solid review-btn">submit for processing</button>
                            </div>
            </form>
              </div>
        </div>
    </div>
    </div>
</div>

<div class="tab-pane fade" id="security">
    <div class="dashboard-box">
        <div class="dashboard-title">
            <h4>delete your accont</h4>
        </div>
        <div class="dashboard-detail">
        	<div class="delete-section">
        		<p>Hi <span class="text-bold"><?=test_output($arow['first_name']." ".$arow['other_names']) ?></span>,</p>
        		<p>we are sorry to here you would like to delete your account.</p>
        		<p><span class="text-bold">note:</span></p>
        		<p>deleting your account will permanently remove your profile, personal
        			settings, and all other associated information.
        			once your account is deleted, you will be logged out and will not be unable
        			to log back in.
        		</p>
        		<p>if you understand and agree to the above statement, and would still like
        		to delete your account, then click below</p>
        		<a href="#" data-toggle="modal" data-target="#delete-account"
        		class="btn btn-solid">delete my account</a>
        	</div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
 <!-- account termination -->
    <div class="modal fade edit-profile-modal" id="delete-account" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Account deletion request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-dark">Before you leave, please tell us why you'd like to delete your Naam account.
                        This information will help us improve. (optional)</p>
                    <form class="terminate-form" method="post">
                        <textarea class="form-control" id="terminate-reason" name="terminate_reason" rows="3"></textarea>
                        <input type="hidden" name="terminate_name" value="<?=encode($arow['first_name']. " ".$arow['other_names'], 'e')?>">
                        <input type="hidden" name="terminate_email" value="<?=encode($arow['email_address'], 'e')?>">
                        <input type="hidden" name="terminate_id" value="<?=encode($arow['id'], 'e')?>">


                        <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-solid terminate-btn">delete my account</button>
                </div>
                    </form>

                </div>
                
            </div>
        </div>
    </div>
    <!-- edit password modal start -->