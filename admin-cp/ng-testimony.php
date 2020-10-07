<?php
session_name('naamglobal');
session_start();
$page = 'Testimony';
$subpage = 'tadd';
include 'ng-header.php';

 ?>
      <div class="content">
        <div class="content">
          <div class="container-fluid">
          
             <h3>Add Testimony </h3>
            <br>
             <div class="row">
            <div class="col-md-12 col-lg-6">
              <div class="card ">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">add</i>
                  </div>
                  <h4 class="card-title">Add new testimony</h4>
                </div>
                <div class="card-body ">
                  <form method="post" class="testimony-form" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="t_name" class="bmd-label-floating">Testifier Name</label>
                      <input type="text" class="form-control" name="t_name"  id="t_name" required>
                    </div>
                    <div class="form-group">
                        <label for="t_body" class="bmd-label-floating" >Testimony</label>
                      <textarea class="form-control" rows="3" name="t_body" id="t_body" required></textarea>
                    </div>
                     
                   <div class="form-group">
                    <div class="form-check">
                      <div class="col-sm-10 checkbox-radios">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="t_status"checked value="yes"> Enable
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="t_status"  value="no"> Disable
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                       
                      </div>
                    </div>
                  </div>

                </div>
                
              </div>
            </div>
           <div class="col-md-12 col-lg-6">
            <div class="card ">
               
                <div class="card-body ">
                   
                   <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail img-circle">
                          <img src="/assets/images/placeholder.jpg" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                        <div>
                          <span class="btn btn-round btn-rose btn-file">
                            <span class="fileinput-new">Add Photo</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="testimony_image" accept=".jpg,.jpeg,.png" />
                          </span>
                          <br />
                          <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                      </div>
                   <div class="progress md-progress" style="display: none;height: 10px">
                         <div class="progress-bar bg-danger" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    <div class="card-footer ">
                  <button type="submit" class="btn btn-fill btn-danger testimony-btn">Add</button>
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