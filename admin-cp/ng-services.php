<?php
session_name('naamglobal');
session_start();
$page = 'Services';
$subpage = 'serm';
include 'ng-header.php';

 ?>
      <div class="content">
        <div class="content">
          <div class="container-fluid">
           
            <div class="row">
            <div class="col-md-12 col-lg-5">
              <div class="card ">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">add</i>
                  </div>
                  <h4 class="card-title">Add service</h4>
                </div>
                <div class="card-body ">
                  <form method="post" class="services-form" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="ser_name" class="bmd-label-floating">Name <small>e.g Test preparation</small></label>
                      <input type="text" class="form-control" required name="ser_name"  id="ser_name">
                    </div>
                    <div class="form-group">
                      <label for="ser_icon" class="bmd-label-floating">Icon <small>e.g book-open</small></label>
                      <input type="text" class="form-control" required name="ser_icon" id="ser_icon">
                    </div>
                   <div class="form-group">
                      <label for="ser_des" class="bmd-label-floating">Description <small>e.g add some description</small></label>
                      <textarea class="form-control" rows="3" required name="ser_des"  id="ser_des"></textarea>
                    </div>
                    <div class="form-check">
                      <div class="col-sm-10 checkbox-radios">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="ser_status" checked value="yes"> Enabled
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="ser_status" value="no"> Disabled
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                       
                      </div>
                    </div>
                    
                     <div class="card-footer ">
                    <button type="submit" class="btn btn-fill btn-danger services-btn">Add</button>
                </div>
                  </form>
                </div>
               
              </div>
            </div>
            <div class="col-md-12 col-lg-7">
               <div class="card">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">home_repair_service</i>
                  </div>
                 </div>
                <div class="card-body">
                  
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th>Title</th>
                          <th class="disabled-sorting ">Icon</th>
                          <th>Description</th>
                          <th>Status</th>
                          <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Title</th>
                          <th>Icon</th>
                          <th>Description</th>
                          <th>Status</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php 
                        $gql = "SELECT * FROM ng_services";
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
                          <td><?=test_output($row['title']) ?></td>
                          <td><i class="fas fa-<?=$row['icon']?>"></i></td>
                          <td><?=test_output($row['description']) ?></td>
                          <td><?=$subRes?></td>
                          <td class="text-right">
                            <a href="#!" data-id="<?=encode($row['id'],"e")?>" class="btn btn-link btn-info btn-just-danger del-service"><i class="material-icons">delete</i></a>
                            <a href="#!" data-id="<?=encode($row['id'],"e")?>" class="btn btn-link btn-warning btn-just-icon edit-service"><i class="material-icons">create</i></a>
                          
                          </td>
                        </tr>
                       <?php endwhile; if($res->num_rows == 0) :?>
                        <tr>
                          <td colspan="4" class="text-center">No services have been added</td>
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