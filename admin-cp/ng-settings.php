<?php
session_name('naamglobal');
session_start();
$page = 'Settings';
include 'ng-header.php';


 $uql = "SELECT * FROM ng_settings";
 $ustmt = $db->prepare($uql);
 $ustmt->execute();
 $ures = $ustmt->get_result();
 $urow = $ures->fetch_assoc();

 ?>
      <div class="content">
        <div class="content">
          <div class="container-fluid">
           
            <h3>Frontend Settings</h3>
            <br>
            
               <div class="row">
            <div class="col-md-12 col-lg-6">
              <div class="card ">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">settings</i>
                  </div>
                  <h4 class="card-title">Update site details</h4>
                </div>
                <div class="card-body ">
                  <form method="post" class="settings-form" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="site_name" class="bmd-label-floating">Site Name</label>
                      <input type="text" class="form-control" name="site_name" value="<?=test_output($urow['site_name']);?>" id="site_name" required>
                    </div>
                    <div class="form-group">
                      <label for="site_address"  class="bmd-label-floating">Address</label>
                      <textarea  id="site_address" class="form-control" rows="2"  name="site_address" required><?=test_output(strip_tags($urow['address']));?></textarea>
                    </div>
                    <div class="form-group" >
                      <label for="site_email"  class="bmd-label-floating">Support Email</label>
                      <input type="email" class="form-control" id="site_email" name="site_email" required  value="<?=test_output($urow['support_email']);?>">
                    </div>
                     <div class="form-group">
                      <label for="site_policy"  class="bmd-label-floating">Privacy Policy</label>
                      <textarea  id="site_policy" class="form-control" rows="9"  name="site_policy" required><?=test_output(strip_tags($urow['policies']));?></textarea>
                    </div>
                    
                </div>
                
              </div>
            </div>
           <div class="col-md-12 col-lg-6">
            <div class="card ">
               
                   
                <div class="card-body ">
                  <div class="form-group mb-5 ">
                    <label for="site_phone"  class="bmd-label-floating">Phone Number</label>
                      <input type="text" class="form-control" id="site_phone" pattern="^\+(?:[0-9]●?){6,14}[0-9]$" name="site_phone" required  value="<?=test_output($urow['phone_number']);?>">
                        <span class="bmd-help">Must begin with country code.</span>
                  </div>
                   <div class="form-group">
                      <label for="site_terms"  class="bmd-label-floating">Terms and Conditions</label>
                      <textarea  id="site_terms" class="form-control" rows="5"  name="site_terms" required><?=test_output(strip_tags($urow['terms']));?></textarea>
                    </div>
                    <input type="hidden" value="<?=encode($urow['site_logo'],'e')?>" name="siteimage">
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail">
                          <img src="/assets/images/<?=$urow['site_logo']?>" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                        <div>
                          <span class="btn btn-danger btn-round btn-file">
                            <span class="fileinput-new">change image</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="site_logo" accept=".jpg,.jpeg,.png" />
                          </span>
                          <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                      </div>
                     
                   <div class="progress md-progress" style="display: none;height: 10px">
                         <div class="progress-bar bg-danger" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    <div class="card-footer ">
                  <button type="submit" class="btn btn-fill btn-danger settings-btn">Update settings</button>
                </div>
                  </form>
                </div>
                
              </div>
           </div>
          </div>
            
          </div>
        </div>
      </div>
     <?php include 'ng-footer.php';?>