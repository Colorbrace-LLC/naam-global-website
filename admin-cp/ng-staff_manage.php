<?php
session_name('naamglobal');
session_start();
$page = 'Staff';
$subpage = 'sman';
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
$staffslug = isset($_GET['staffslug']) ? $_GET['staffslug'] : ''; 

 ?>
      <div class="content">
        <div class="content">
          <div class="container-fluid">
           
          <?php if(!$staffslug) : ?>
            <h3>Manage Staff</h3>
            <br>
            <div class="row">
        <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">admin_panel_settings</i>
                  </div>
                 </div>
                <div class="card-body">
                  
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                         <th class="disabled-sorting">Image</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Role</th>
                          <th>Status</th>
                          <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Image</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Role</th>
                          <th>Status</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php 
                        $gql = "SELECT * FROM ng_admin WHERE id != ?";
                        $idd = $arow['id'];
                        $stmt = $db->prepare($gql);
                        $stmt->bind_param('i',$idd);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        while ($row = $res->fetch_assoc()) :
                          $enabled = $row['status'];

                          switch ($enabled) {
                            case 'enabled':
                              $subRes = '<button class="btn btn-success btn-sm"> Enabled</button>';
                              break;
                            case 'disabled':
                             $subRes = '<button class="btn btn-danger btn-sm"> Disabled</button>';
                              break;
                            default:
                              # nothing
                              break;
                          }
                        ?>
                        <tr>
                          <td> <div class="fileinput fileinput-new text-center">
                        <div class="fileinput-new thumbnail img-circle">
                        <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                         <img src="/assets/images/avatar/<?=$row['avatar']?>" alt="<?=test_output($row['title']) ?>">
                        </div>
                        
                      </div>
                            
                          </td>
                          <td><?=test_output($row['first_name'] ." ". $row['other_names']) ?></td>
                          <td><?=test_output($row['email_address']) ?></td>
                          <td><?=$row['role']?></td>
                          <td><?=$subRes?></td>
                          <td class="text-right">
                            <a href="#!" class="btn btn-link btn-info btn-just-icon del-staff" data-id="<?=encode($row['id'],"e")?>"><i class="material-icons">delete</i></a>
                            <a href="/admin-cp/staff/manage/<?=encode($row['id'],"e")?>"  class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">create</i></a>
                          
                          </td>
                        </tr>
                       <?php endwhile; if($res->num_rows == 0) :?>
                        <tr>
                          <td colspan="7" class="text-center">No staff has been added</td>
                        </tr>
                     <?php endif; ?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            </div>
            <?php endif; if ($staffslug) : 

              $staffslug = encode(trim($staffslug),'d');
              $uql = "SELECT * FROM ng_admin WHERE id = ?";
              $ustmt = $db->prepare($uql);
              $ustmt->bind_param('i',$staffslug);
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
                redirect("/admin-cp/staff/manage");
                exit();
              }
            ?>

             <h3>Editing <?=test_output($urow['first_name'] ." ". $urow['other_names']);?> </h3>
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
                  <form method="post" class="updatestaff-form" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="e_s_fname" class="bmd-label-floating">First name</label>
                      <input type="text" class="form-control" name="e_s_fname" value="<?=test_output($urow['first_name']);?>" id="e_s_fname" required>
                    </div>
                     <div class="form-group">
                      <label for="e_s_onames" class="bmd-label-floating">Other name</label>
                      <input type="text" class="form-control" name="e_s_onames" value="<?=test_output($urow['other_names']);?>" id="e_s_onames" required>
                    </div>
                     <div class="form-group">
                      <label for="e_s_email" class="bmd-label-floating">Email address</label>
                      <input type="text" class="form-control" name="e_s_email" value="<?=test_output($urow['email_address']);?>" id="e_s_email" required>
                    </div>
                    <div class="form-group">
                      <input type="hidden" name="staff_id" value="<?=encode($urow['id'],'e')?>">
                      <input type="hidden" name="staff_emailid" value="<?=encode($urow['email_address'],'e')?>">
                    </div>
                     <div class="form-group">
                  <label for="e_s_role" class="bmd-label-floating">Select role </label>
                  <select class=" form-control selectpicker" data-size="3"  data-style=" select-with-transition"  title="Select role" id="e_s_role" required name="e_s_role">
                  <option value="admin"  <?php if($urow['role'] == 'admin') : echo "selected"; endif; ?>>Administrator</option>
                  <option value="staff"  <?php if($urow['role'] == 'staff') : echo "selected"; endif; ?>>Staff</option>
                 </select>
               </div>
                    
                   </div>
                
              </div>
            </div>
           <div class="col-md-12 col-lg-6">
            <div class="card ">
               
                <div class="card-body ">
                   <div class="form-group">
                    <label for="password" class="bmd-label-floating">Password (optional)</label>
                    <input type="password" id="password" class="form-control" name="password">
                    <span class="bmd-help">Should be at least 8 alphanumeric charecters long</span>
                   </div>
                    <div class="form-group">
                    <label for="password_c" class="bmd-label-floating">Password (optional)</label>
                    <input type="password" id="password_c" class="form-control" name="password_c">
                   </div>
             
                     <div class="form-check">
                      <div class="col-sm-10 checkbox-radios">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="e_staff_status" <?php if($urow['status'] == 'enabled'): echo "checked"; endif;?> value="enabled"> Enable
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="e_staff_status" <?php if($urow['status'] == 'disabled'): echo "checked"; endif;?> value="disabled"> Disable
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                       
                      </div>
                    </div>
                  
                   
                    <div class="card-footer ">
                  <button type="submit" class="btn btn-fill btn-danger updatestaff-btn">Update staff</button>
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