<?php
session_name('naamglobal');
session_start();
$page = 'School';
$subpage = 'courses';
include 'ng-header.php';

 ?>
      <div class="content">
        <div class="content">
          <div class="container-fluid">
           
            <div class="row">
            <div class="col-md-5">
              <div class="card ">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">add</i>
                  </div>
                  <h4 class="card-title">Add course</h4>
                </div>
                <div class="card-body ">
                  <form method="post" class="course-form" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="cs_name" class="bmd-label-floating">Name <small>e.g computer science</small></label>
                      <input type="text" class="form-control" required name="cs_name"  id="cs_name">
                    </div>
                   <div class="form-group">
                      <label for="cs_des" class="bmd-label-floating">Description <small>e.g add some description</small></label>
                      <textarea class="form-control" rows="3" required name="cs_des"  id="cs_des"></textarea>
                    </div>
                    <div class="form-check">
                      <div class="col-sm-10 checkbox-radios">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="cs_status" checked value="yes"> Enabled
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="cs_status" value="no"> Disabled
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                       
                      </div>
                    </div>
                    
                     <div class="card-footer ">
                    <button type="submit" class="btn btn-fill btn-danger course-btn">Add</button>
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
                          <th>Name</th>
                          <th>Description</th>
                          <th>Status</th>
                          <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Name</th>
                          <th>Description</th>
                          <th>Status</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php 
                        $gql = "SELECT * FROM ng_courses";
                        $stmt = $db->prepare($gql);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        while ($row = $res->fetch_assoc()) :
                          $status = $row['enabled'];

                          switch ($status) {
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
                          <td><?=test_output($row['name']) ?></td>
                          <td><?=test_output($row['description']) ?></td>
                          <td><?=$subRes?></td>
                          <td class="text-right">
                            <a href="#!" data-id="<?=encode($row['id'],"e")?>" class="btn btn-link btn-info btn-just-danger del-course"><i class="material-icons">delete</i></a>
                            <a href="#!" data-id="<?=encode($row['id'],"e")?>" class="btn btn-link btn-warning btn-just-icon edit-course"><i class="material-icons">create</i></a>
                          
                          </td>
                        </tr>
                       <?php endwhile; if($res->num_rows == 0) :?>
                        <tr>
                          <td colspan="4" class="text-center">No courses have been added</td>
                        </tr>
                     <?php endif; ?>
                        
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
     <?php include 'ng-footer.php';?>