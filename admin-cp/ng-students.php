<?php
session_name('naamglobal');
session_start();
$page = 'Students';
$subpage = 'smanage';
include 'ng-header.php';

$studentslug = isset($_GET['studentslug']) ? $_GET['studentslug'] : ''; 

 ?>
      <div class="content">
        <div class="content">
          <div class="container-fluid">
           
          <?php if(!$studentslug) : ?>
            <h3>Manage Users</h3>
            <br>
            <div class="row">
               <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">person</i>
                  </div>
                 </div>
                <div class="card-body">
                  
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th >Name</th>
                          <th>Type</th>
                          <th class="disabled-sorting">Email</th>
                          <th class="disabled-sorting">Phone</th>
                          <th>Joined</th>
                          <th>Submitted</th>
                          <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Name</th>
                          <th>Type</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Joined</th>
                          <th>Submitted</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php 
                        $gql = "SELECT * FROM ng_students";
                        $stmt = $db->prepare($gql);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        while ($row = $res->fetch_assoc()) :
                          $joined = date_create($row['date_joined']);
                          $submitted = $row['submitted'];

                          switch ($submitted) {
                            case 'yes':
                              $subRes = '<button class="btn btn-success btn-sm"> Yes</button>';
                              break;
                            case 'no':
                             $subRes = '<button class="btn btn-danger btn-sm"> No</button>';
                              break;
                            default:
                              # nothing
                              break;
                          }
                        ?>
                        <tr>
                          <td><?=test_output($row['first_name']." ". $row['other_names']) ?></td>
                          <td><?=test_output($row['account_type']) ?></td>
                          <td><?=test_output($row['email_address']) ?></td>
                          <td><?=test_output($row['phone_number']) ?></td>
                          <td><?=date_format($joined, "jS M Y"); ?></td>
                          <td><?=$subRes?></td>
                          <td class="text-right">
                            <a href="/admin-cp/compose/<?=encode($row['email_address'],"e")?>" class="btn btn-link btn-info btn-just-icon like"><i class="material-icons">email</i></a>
                            <a href="/admin-cp/students/manage/<?=encode($row['id'],"e")?>"  class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">create</i></a>
                          
                          </td>
                        </tr>
                       <?php endwhile; if($res->num_rows == 0) :?>
                        <tr>
                          <td colspan="7" class="text-center">No accounts have been created</td>
                        </tr>
                     <?php endif; ?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            </div>
            <?php endif; if ($studentslug) : 

              $studentslug = encode(trim($studentslug),'d');
              $uql = "SELECT * FROM ng_students WHERE id = ?";
              $ustmt = $db->prepare($uql);
              $ustmt->bind_param('i',$studentslug);
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
                redirect("/admin-cp/students/manage");
                exit();
              }
            ?>

             <h3>Editing <?=test_output($urow['first_name']." ". $urow['other_names']);?> <span class="d-flex justify-content-end"><button type="button" class="delete-user btn btn-danger" data-id="<?=encode($urow['id'],'e')?>">Delete user</button></span></h3>
            <br>
             <div class="row">
            <div class="col-12">
              <div class="card ">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">person</i>
                  </div>
                  <h4 class="card-title">Update user</h4>
                </div>
                <div class="card-body ">
                  <form method="post" class="update-form">
                    <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="first_name" class="bmd-label-floating">First Name</label>
                      <input type="text" class="form-control" name="first_name" value="<?=test_output($urow['first_name']);?>" id="first_name" required>
                    </div>
                    <div class="form-group col-md-6">
                      <input type="hidden" name="user_id" value="<?=encode($urow['id'],'e')?>">
                      <input type="hidden" name="user_email" value="<?=encode($urow['email_address'],'e')?>">

                      <label for="other_names" class="bmd-label-floating">Other Names</label>
                      <input type="text" class="form-control"  value="<?=test_output($urow['other_names']);?>" id="other_names" name="other_names" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="email_address"  class="bmd-label-floating">Email Address</label>
                      <input type="email" id="email_address" class="form-control"  name="email_address" required value="<?=test_output($urow['email_address']);?>">
                    </div>
                    <div class="form-group col-md-6" >
                      <label for="phone_number"  class="bmd-label-floating">Phone Number</label>
                      <input type="text" class="form-control" id="phone_number" pattern="^\+(?:[0-9]●?){6,14}[0-9]$" name="phone_number" required  value="<?=test_output($urow['phone_number']);?>">
                        <span class="bmd-help">Must begin with country code.</span>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="account_type"  class="bmd-label-floating">Account type</label>
                      <select class="selectpicker" data-size="3" data-style="btn btn-purple" title="Select type" id="account_type" required name="account_type">
                        <option value="student" <?php if($urow['account_type'] == 'student'): echo "selected"; endif;?>>Student</option>
                        <option value="tour" <?php if($urow['account_type'] == 'tour'): echo "selected"; endif;?>>Tour</option>
                        <option value="visa" <?php if($urow['account_type'] == 'visa'): echo "selected"; endif;?>>Visa</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="email_verified"  class="bmd-label-floating">Email Verified</label>
                      <select class="selectpicker" data-size="2" data-style="btn btn-purple" title="Select status" id="email_verified" required name="email_verified">
                        <option value="yes" <?php if($urow['email_verified'] == 'yes'): echo "selected"; endif;?>>Yes</option>
                        <option value="no" <?php if($urow['email_verified'] == 'no'): echo "selected"; endif;?>>No</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="phone_verified"  class="bmd-label-floating">Phone Verified</label>
                      <select class="selectpicker" data-size="2" data-style="btn btn-purple" title="Select status" id="phone_verified" required name="phone_verified">
                        <option value="yes" <?php if($urow['phone_verified'] == 'yes'): echo "selected"; endif;?>>Yes</option>
                        <option value="no" <?php if($urow['phone_verified'] == 'no'): echo "selected"; endif;?>>No</option>
                      </select>
                    </div>
                  </div>
                     <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="password"  class="bmd-label-floating">New Password (optional)</label>
                      <input type="password" id="password" class="form-control"  name="password" >
                    </div>
                    <div class="form-group col-md-6" >
                     <label for="password_c"  class="bmd-label-floating">Confirm Password</label>
                      <input type="password" id="password_c" class="form-control"  name="password_c" >
                    </div>
                  </div>
                   <div class="form-group" >
                      <label for="user_status" class="bmd-label-floating">User satus</label></br>
                     <select class="selectpicker" data-size="2" data-style="btn btn-purple" title="Select status" id="user_status" required name="user_status">
                        <option value="yes" <?php if($urow['enabled'] == 'yes'): echo "selected"; endif;?>>Enabled</option>
                        <option value="no" <?php if($urow['enabled'] == 'no'): echo "selected"; endif;?>>Disabled</option>
                      </select>
                    </div>
                    <div class="card-footer ">
                  <button type="submit" class="btn btn-fill btn-danger update-btn">Update user</button>
                </div>
                  </form>
                </div>
                
              </div>
            </div>
           
          </div>

          <?php endif; ?>
          </div>
        </div>
      </div>
     <?php include 'ng-footer.php';?>