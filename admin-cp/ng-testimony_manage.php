<?php
session_name('naamglobal');
session_start();
$page = 'Testimony';
$subpage = 'tman';
include 'ng-header.php';


$testimonyslug = isset($_GET['testimonyslug']) ? $_GET['testimonyslug'] : ''; 

 ?>
      <div class="content">
        <div class="content">
          <div class="container-fluid">
           
          <?php if(!$testimonyslug) : ?>
            <h3>Manage Testimonies</h3>
            <br>
            <div class="row">
        <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">speaker_notes</i>
                  </div>
                 </div>
                <div class="card-body">
                  
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                         <th class="disabled-sorting">Image</th>
                          <th>Name</th>
                          <th>Testimony</th>
                          <th>Status</th>
                          <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Image</th>
                          <th>Name</th>
                          <th>Testimony</th>
                          <th>Status</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php 
                        $gql = "SELECT * FROM ng_testimonies";
                        $stmt = $db->prepare($gql);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        while ($row = $res->fetch_assoc()) :
                          $enabled = $row['enabled'];

                          switch ($enabled) {
                            case 'yes':
                              $subRes = '<button class="btn btn-success btn-sm"> Enabled</button>';
                              break;
                            case 'no':
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
                         <img src="/assets/images/testimonials/<?=$row['image']?>" alt="<?=test_output($row['testimony_by']) ?>">
                        </div>
                        
                      </div>
                            
                          </td>
                          <td><?=test_output($row['testimony_by']) ?></td>
                          <td><?=test_output($row['testimony']) ?></td>
                          <td><?=$subRes?></td>
                          <td class="text-right">
                            <a href="#!" class="btn btn-link btn-info btn-just-icon del-testimony" data-id="<?=encode($row['id'],"e")?>"><i class="material-icons">delete</i></a>
                            <a href="/admin-cp/testimony/manage/<?=encode($row['id'],"e")?>"  class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">create</i></a>
                          
                          </td>
                        </tr>
                       <?php endwhile; if($res->num_rows == 0) :?>
                        <tr>
                          <td colspan="7" class="text-center">No testimony has been added</td>
                        </tr>
                     <?php endif; ?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            </div>
            <?php endif; if ($testimonyslug) : 

              $testimonyslug = encode(trim($testimonyslug),'d');
              $uql = "SELECT * FROM ng_testimonies WHERE id = ?";
              $ustmt = $db->prepare($uql);
              $ustmt->bind_param('i',$testimonyslug);
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
                redirect("/admin-cp/testimony/manage");
                exit();
              }
            ?>

             <h3>Editing <?=test_output($urow['testimony_by']);?>'s Testimony </h3>
            <br>
             <div class="row">
            <div class="col-md-12 col-lg-6">
              <div class="card ">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">speaker_notes</i>
                  </div>
                  <h4 class="card-title">Update testimony</h4>
                </div>
                <div class="card-body ">
                  <form method="post" class="updatetestimony-form" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="e_t_name" class="bmd-label-floating">Testifier Name</label>
                      <input type="text" class="form-control" name="e_t_name" value="<?=test_output($urow['testimony_by']);?>" id="e_t_name" required>
                    </div>
                     <div class="form-group">
                      <label for="e_t_body" class="bmd-label-floating">Testimony</label>
                      <textarea class="form-control" rows="3" name="e_t_body" id="e_t_body" required><?=test_output($urow['testimony']);?></textarea>
                    </div>
                    
                    <div class="form-group">
                      <input type="hidden" name="testimony_id" value="<?=encode($urow['id'],'e')?>">
                    </div>
                     <div class="form-check">
                      <div class="col-sm-10 checkbox-radios">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="e_t_status" <?php if($urow['enabled'] == 'yes'): echo "checked"; endif;?> value="yes"> Enable
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="e_t_status" <?php if($urow['enabled'] == 'no'): echo "checked"; endif;?> value="no"> Disable
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                       
                      </div>
                    </div>

                    <div class="card-footer ">
                  <button type="submit" class="btn btn-fill btn-danger updatetestimony-btn">Update testimony</button>
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