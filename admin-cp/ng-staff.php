<?php
session_name('naamglobal');
session_start();
$page = 'Staff';
$subpage = 'sadd';
include 'ng-header.php';

if ($arow['role'] != 'admin') {
   $_SESSION['showError'] = "<script>function showError() {
     iziToast.warning({
         title: 'Action Required!',
         message: 'Unauthorized! You can not access this page.',
         position: 'bottomRight'  });
     } showError(); </script>";

     redirect('/admin-cp/dashboard');
     exit();
}

 ?>
      <div class="content">
        <div class="content">
          <div class="container-fluid">
          
             <h3>Add Staff </h3>
            <br>
             <div class="row">
            <div class="col-md-12 col-lg-6">
              <div class="card ">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">add</i>
                  </div>
                  <h4 class="card-title">Add new staff</h4>
                </div>
                <div class="card-body ">
                  <form method="post" class="staff-form" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="s_fname" class="bmd-label-floating">First Name</label>
                      <input type="text" class="form-control" name="s_fname"  id="s_fname" required>
                    </div>
                    <div class="form-group">
                        <label for="s_onames" class="bmd-label-floating" >Other Names</label>
                      <input type="text" class="form-control" name="s_onames"  id="s_onames" required>
                    </div>
                      <div class="form-group">
                        <label for="s_email" class="bmd-label-floating" >Email address</label>
                      <input type="email" class="form-control" name="s_email"  id="s_email" required>
                    </div>
                  
                    <div class="form-group">
                  <label for="s_role" class="bmd-label-floating">Select role </label>
                  <select class=" form-control selectpicker" data-size="3"  data-style=" select-with-transition"  title="Select role" id="s_role" required name="s_role">
                  <option value="admin">Administrator</option>
                  <option value="staff">Staff</option>
                 </select>
               </div>
                </div>
                
              </div>
            </div>
           <div class="col-md-12 col-lg-6">
            <div class="card ">
               
                <div class="card-body ">
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail">
                          <img src="/assets/images/image_placeholder.jpg" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                        <div>
                          <span class="btn btn-danger btn-round btn-file">
                            <span class="fileinput-new">Select avatar</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="staff_image" accept=".jpg,.jpeg,.png" />
                          </span>
                          <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                      </div>
                     
                    <div class="form-group">
                    <div class="form-check">
                      <div class="col-sm-10 checkbox-radios">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="staff_status"checked value="enabled"> Enable
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="staff_status"  value="enabled"> Disable
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                       
                      </div>
                    </div>
                  </div>

                   <div class="progress md-progress" style="display: none;height: 10px">
                         <div class="progress-bar bg-danger" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    <div class="card-footer ">
                  <button type="submit" class="btn btn-fill btn-danger staff-btn">Add</button>
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