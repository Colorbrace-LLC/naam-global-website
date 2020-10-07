<?php
session_name('naamglobal');
session_start();
$page = 'School';
$subpage = 'scmanage';
include 'ng-header.php';

$schoolslug = isset($_GET['schoolslug']) ? $_GET['schoolslug'] : ''; 

 ?>
      <div class="content">
        <div class="content">
          <div class="container-fluid">
           
          <?php if(!$schoolslug) : ?>
            <h3>Manage Schools</h3>
            <br>
            <div class="row">
               <div class="col-md-5">
              <div class="card ">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">add</i>
                  </div>
                  <h4 class="card-title">Add school</h4>
                </div>
                <div class="card-body ">
                  <form method="post" class="school-form">
                    
                    <div class="form-group">
                      <label for="school_name" class="bmd-label-floating">Name <small>e.g University of Oxford</small></label>
                      <input type="text" class="form-control" name="school_name" id="school_name" required>
                    </div>
                  <div class="form-group">
                     
                      <label for="school_slug" >Slug</label>
                      <input type="text" class="form-control" readonly id="school_slug" name="school_slug" required>
                    </div>
                 <div class="form-group">
                  <label for="school_des" class="bmd-label-floating">Description <small>add a description</small></label>
                   <textarea class="form-control " rows="3" name="school_des" id="school_des" required></textarea>
                 </div>
                 <div class="form-group">
                  <label for="school_loc" class="bmd-label-floating">Address <small>e.g old road, UK</small></label>
                  <input type="text" class="form-control" id="school_loc" name="school_loc" required>
                 </div>
                    <div class="form-group">
                      <label for="school_courses"  >Courses offered</label>
                      <select class=" form-control selectpicker" data-size="3"  data-style=" select-with-transition" multiple title="Select all courses" id="school_courses" required name="school_courses[]">
                       <?php 
                        $fql = "SELECT * FROM ng_courses WHERE enabled = ?";
                        $fstmt = $db->prepare($fql);
                        $enabled = 'yes';
                        $fstmt->bind_param('s',$enabled);
                        $fstmt->execute();
                        $fres = $fstmt->get_result();
                        while($frow = $fres->fetch_assoc()) :
                       ?>
                       <option value="<?=$frow['id']?>"><?=test_output($frow['name']) ?></option>
                     <?php endwhile; ?>
                      </select>
                    </div>
                 <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail">
                          <img src="/assets/images/image_placeholder.jpg" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                        <div>
                          <span class="btn btn-danger btn-round btn-file">
                            <span class="fileinput-new">Select image</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="school_image" accept=".jpg,.jpeg,.png" />
                          </span>
                          <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                      </div>
                     <div class="file-upload-wrapper">
                        <label for="school_images">Select other images <small>optional</small></label>
                        <input type="file"  id="school_images" name="school_images[]" accept=".jpg,.jpeg,.png" multiple />
                      </div>
                      <div class="form-check">
                      <div class="col-sm-10 checkbox-radios">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="school_status" checked value="yes"> Enabled
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="school_status" value="no"> Disabled
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                       
                      </div>
                    </div>
                     <div class="progress md-progress" style="display: none;height: 10px">
                         <div class="progress-bar bg-danger" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    <div class="card-footer ">
                  <button type="submit" class="btn btn-fill btn-danger school-btn">Add</button>
                </div>
                  </form>
                </div>
                
              </div>
            </div>
               <div class="col-md-7">
              <div class="card">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">school</i>
                  </div>
                 </div>
                <div class="card-body">
                  
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th class="disabled-sorting">Image</th>
                          <th>Name</th>
                          <th>Status</th>
                          <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Image</th>
                          <th>Name</th>
                          <th>Status</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php 
                        $gql = "SELECT * FROM ng_schools";
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
                          <td><div class="img-container">
                            <img src="/assets/images/schools/<?=$row['image']?>" alt="<?=test_output($row['name']) ?>">
                          </div></td>
                          <td><?=test_output($row['name']) ?></td>
                          <td><?=$subRes?></td>
                          <td class="text-right">
                            <a href="#!" class="btn btn-link btn-info btn-just-icon del-school" data-id="<?=encode($row['id'],"e")?>"><i class="material-icons">delete</i></a>
                            <a href="/admin-cp/school/manage/<?=encode($row['id'],"e")?>"  class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">create</i></a>
                          
                          </td>
                        </tr>
                       <?php endwhile; if($res->num_rows == 0) :?>
                        <tr>
                          <td colspan="7" class="text-center">No schools have been created</td>
                        </tr>
                     <?php endif; ?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            </div>
            <?php endif; if ($schoolslug) : 

              $schoolslug = encode(trim($schoolslug),'d');
              $uql = "SELECT * FROM ng_schools WHERE id = ?";
              $ustmt = $db->prepare($uql);
              $ustmt->bind_param('i',$schoolslug);
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
                redirect("/admin-cp/school/manage");
                exit();
              }
            ?>

             <h3>Editing <?=test_output($urow['name']);?> </h3>
            <br>
             <div class="row">
            <div class="col-md-12 col-lg-6">
              <div class="card ">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">school</i>
                  </div>
                  <h4 class="card-title">Update school</h4>
                </div>
                <div class="card-body ">
                  <form method="post" class="updatesch-form" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="e_school_name" class="bmd-label-floating">Name</label>
                      <input type="text" class="form-control" name="e_school_name" value="<?=test_output($urow['name']);?>" id="e_school_name" required>
                    </div>
                    <div class="form-group">
                      <input type="hidden" name="school_id" value="<?=encode($urow['id'],'e')?>">
                      <input type="hidden" name="schoolimage" value="<?=encode($urow['image'],'e')?>">
                    </div>
                    <div class="form-group">
                      <label for="e_school_des"  class="bmd-label-floating">Desription</label>
                      <textarea  id="e_school_des" class="form-control" rows="3"  name="e_school_des" required><?=test_output(strip_tags($urow['description']));?></textarea>
                    </div>
                    <div class="form-group" >
                      <label for="e_school_loc"  class="bmd-label-floating">Address</label>
                      <input type="text" class="form-control" id="e_school_loc" name="e_school_loc" required  value="<?=test_output($urow['location']);?>">
                    </div>
                     <div class="form-group">
                       <label for="e_school_courses"  >Courses offered</label>
                      <select class=" form-control selectpicker" data-size="3"  data-style=" select-with-transition" multiple title="Select all courses" id="e_school_courses" required name="e_school_courses[]">
                       <?php 
                        $fql = "SELECT * FROM ng_courses WHERE enabled = ?";
                        $fstmt = $db->prepare($fql);
                        $enabled = 'yes';
                        $fstmt->bind_param('s',$enabled);
                        $fstmt->execute();
                        $fres = $fstmt->get_result();
                        $selected = "";
                        while($frow = $fres->fetch_assoc()) :

                          if (in_array($frow['id'], explode(',', trim($urow['cid'],',')))) {
                            $selected = "selected";
                          }
                       ?>
                       <option value="<?=$frow['id']?>"<?=$selected?>><?=test_output($frow['name']) ?></option>
                     <?php endwhile; ?>
                      </select>
                    </div>
                     <div class="form-check">
                      <div class="col-sm-10 checkbox-radios">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="e_school_status" <?php if($urow['enabled'] == 'yes'): echo "checked"; endif;?> value="yes"> Enabled
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="e_school_status" <?php if($urow['enabled'] == 'no'): echo "checked"; endif;?> value="no"> Disabled
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
           <div class="col-md-12 col-lg-6">
            <div class="card ">
               
                <div class="card-body ">
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail">
                          <img src="/assets/images/schools/<?=$urow['image']?>" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                        <div>
                          <span class="btn btn-danger btn-round btn-file">
                            <span class="fileinput-new">change image</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="e_school_image" accept=".jpg,.jpeg,.png" />
                          </span>
                          <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                      </div>
                      <div class="file-upload-wrapper">
                        <label for="e_school_images">Add other images <small>optional</small></label>
                        <input type="file"  id="e_school_images" class="form-control" name="e_school_images[]" accept=".jpg,.jpeg,.png" multiple />
                    </div>
                    <?php if(!empty($urow['images'])) : ?>
                      <input type="hidden" name="schoolimages" value="<?=encode($urow['images'],'e')?>">

                    <div class="form-group">
                    <label for="del_others" class="bmd-label-floating"> Delete old images</label>
                    <div class="form-check">
                      <div class="col-sm-10 checkbox-radios">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="del_others" value="yes"> Yes
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="del_others" checked value="no"> No
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                       
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
                  
                   <div class="progress md-progress" style="display: none;height: 10px">
                         <div class="progress-bar bg-danger" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    <div class="card-footer ">
                  <button type="submit" class="btn btn-fill btn-danger updatesch-btn">Update school</button>
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