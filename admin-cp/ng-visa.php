<?php
session_name('naamglobal');
session_start();
$page = 'Visa';
$subpage = 'mvisa';
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
                  <h4 class="card-title">Add visa type</h4>
                </div>
                <div class="card-body ">
                  <form method="post" class="visa-form" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="vis_name" class="bmd-label-floating">Name <small>e.g student visa</small></label>
                      <input type="text" class="form-control" name="vis_name"  id="vis_name">
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
                            <input type="file" name="vis_image" accept=".jpg,.jpeg,.png" />
                          </span>
                          <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                      </div>
                    <div class="form-check">
                      <div class="col-sm-10 checkbox-radios">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="vis_status" checked value="yes"> Enabled
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="vis_status" value="no"> Disabled
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
                    <button type="submit" class="btn btn-fill btn-danger visa-btn">Add</button>
                </div>
                  </form>
                </div>
               
              </div>
            </div>
            <div class="col-md-7">
               <div class="card">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">credit_card</i>
                  </div>
                 </div>
                <div class="card-body">
                  
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th class="disabled-sorting">Image</th>
                          <th>Visa type</th>
                          <th>Status</th>
                          <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Image</th>
                          <th>Visa type</th>
                          <th>Status</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php 
                        $gql = "SELECT * FROM ng_visas";
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
                          <td><div class="img-container">
                              <img src="/assets/images/visas/<?=$row['image']?>" alt="<?=test_output($row['name']) ?>">
                            </div></td>
                          <td><?=test_output($row['name']) ?></td>
                          <td><?=$subRes?></td>
                          <td class="text-right">
                            <a href="#!" data-id="<?=encode($row['id'],"e")?>" class="btn btn-link btn-info btn-just-danger del-vis"><i class="material-icons">delete</i></a>
                            <a href="#!" data-id="<?=encode($row['id'],"e")?>" class="btn btn-link btn-warning btn-just-icon edit-vis"><i class="material-icons">create</i></a>
                          
                          </td>
                        </tr>
                       <?php endwhile; if($res->num_rows == 0) :?>
                        <tr>
                          <td colspan="4" class="text-center">No visa types have been added</td>
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