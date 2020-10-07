<?php
session_name('naamglobal');
session_start();
$page = 'Profile';
include 'ng-header.php';


 $uql = "SELECT * FROM ng_admin WHERE id = ?";
 $aid = $arow['id'];
 $ustmt = $db->prepare($uql);
 $ustmt->bind_param('i',$aid);
 $ustmt->execute();
 $ures = $ustmt->get_result();
 $urow = $ures->fetch_assoc();

 ?>
      <div class="content">
        <div class="content">
          <div class="container-fluid">
           
            <h3>My Profile</h3>
            <br>
            <div class="row">
            <div class="col-md-12 col-lg-6">
              <div class="card ">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">admin_panel_settings</i>
                  </div>
                  <h4 class="card-title">Update staff details</h4>
                </div>
                <div class="card-body ">
                  <form method="post" class="profile-form" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="my_f_name" class="bmd-label-floating">First name</label>
                      <input type="text" class="form-control" name="my_f_name" value="<?=test_output($urow['first_name']);?>" id="my_f_name" required>
                    </div>
                     <div class="form-group">
                      <label for="my_o_name" class="bmd-label-floating">Other names</label>
                      <input type="text" class="form-control" name="my_o_name" value="<?=test_output($urow['other_names']);?>" id="my_o_name" required>
                    </div>
                     <div class="form-group">
                      <label for="my_email" class="bmd-label-floating">Email address</label>
                      <input type="text" class="form-control" name="my_email" value="<?=test_output($urow['email_address']);?>" id="my_email" required>
                    </div>
                    <div class="form-group">
                      <input type="hidden" name="my_id" value="<?=encode($urow['id'],'e')?>">
                      <input type="hidden" name="my_pic" value="<?=encode($urow['avatar'],'e')?>">
                      <input type="hidden" name="myemail" value="<?=encode($urow['email_address'],'e')?>">

                    </div>
                     <div class="form-group mb-3">
                    <label for="my_password" class="bmd-label-floating">Password (optional)</label>
                    <input type="password" id="my_password" class="form-control" name="my_password">
                    <span class="bmd-help">Should be at least 8 alphanumeric charecters long</span>
                   </div>
                    <div class="form-group">
                    <label for="my_password_c" class="bmd-label-floating">Password (optional)</label>
                    <input type="password" id="my_password_c" class="form-control" name="my_password_c">
                   </div>
                   </div>
                
              </div>
            </div>
           <div class="col-md-12 col-lg-6">
            <div class="card ">
               
                <div class="card-body ">
                   <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail img-circle">
                          <img src="/assets/images/avatar/<?=$urow['avatar']?>" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                        <div>
                          <span class="btn btn-round btn-rose btn-file">
                            <span class="fileinput-new">Change avatar</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="my_image" accept=".jpg,.jpeg,.png" />
                          </span>
                          <br />
                          <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                      </div>
                  
              <div class="progress md-progress" style="display: none;height: 10px">
                         <div class="progress-bar bg-danger" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    <div class="card-footer ">
                  <button type="submit" class="btn btn-fill btn-danger profile-btn">Update profile</button>
                </div>
              </div>
                  
                </div>
                
              </div>
              </form>
           </div>
          </div>
          </div>
        </div>
      </div>
     <?php include 'ng-footer.php';?>