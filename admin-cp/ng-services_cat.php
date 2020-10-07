<?php
session_name('naamglobal');
session_start();
$page = 'Services';
$subpage = 'serc';
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
              <h4 class="card-title">Add category</h4>
            </div>
            <div class="card-body ">
              <form method="post" class="category-form" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="cat_service" class="bmd-label-floating">Select Service </label>
                  <select class=" form-control selectpicker" data-size="3"  data-style=" select-with-transition"  title="Select service" id="cat_service" required name="cat_service">
                   <?php 
                   $fql = "SELECT * FROM ng_services WHERE enabled = ?";
                   $fstmt = $db->prepare($fql);
                   $enabled = 'yes';
                   $fstmt->bind_param('s',$enabled);
                   $fstmt->execute();
                   $fres = $fstmt->get_result();
                   while($frow = $fres->fetch_assoc()) :
                     ?>
                     <option value="<?=encode($frow['id'])?>"><?=test_output($frow['title']) ?></option>
                   <?php endwhile; ?>
                 </select>
               </div>
               <div class="form-group">
                <label for="cat_name" class="bmd-label-floating">Category name <small>e.g maths & science</small></label>
                <input type="text" class="form-control" required name="cat_name" id="cat_name">
              </div>

              <div class="form-check">
                <div class="col-sm-10 checkbox-radios">
                  <div class="form-check form-check-inline">
                    <label class="form-check-label">
                      <input class="form-check-input" type="radio" name="cat_status" checked value="yes"> Enabled
                      <span class="circle">
                        <span class="check"></span>
                      </span>
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <label class="form-check-label">
                      <input class="form-check-input" type="radio" name="cat_status" value="no"> Disabled
                      <span class="circle">
                        <span class="check"></span>
                      </span>
                    </label>
                  </div>

                </div>
              </div>

              <div class="card-footer ">
                <button type="submit" class="btn btn-fill btn-danger category-btn">Add</button>
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
                  <th>Category Name</th>
                  <th >Service</th>
                  <th>Status</th>
                  <th class="disabled-sorting text-right">Actions</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Title</th>
                  <th>Service</th>
                  <th>Status</th>
                  <th class="text-right">Actions</th>
                </tr>
              </tfoot>
              <tbody>
                <?php 
                $mql = "SELECT * FROM ng_service_category";
                $mstmt = $db->prepare($mql);
                $mstmt->execute();
                $mres = $mstmt->get_result();

                while ($row = $mres->fetch_assoc()) :
                  $id = $row['sid'];
                  $gql = "SELECT title FROM ng_services WHERE id = ?";
                  $stmt = $db->prepare($gql);
                  $stmt->bind_param("i",$id);
                  $stmt->execute();
                  $stmt->store_result();
                  $stmt->bind_result($title);
                  $stmt->fetch();

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
                    <td><?=test_output($title) ?></td>
                    <td><?=$subRes?></td>
                    <td class="text-right">
                      <a href="#!" data-id="<?=encode($row['id'],"e")?>" class="btn btn-link btn-info btn-just-danger del-category"><i class="material-icons">delete</i></a>
                      <a href="#!" data-id="<?=encode($row['id'],"e")?>" class="btn btn-link btn-warning btn-just-icon edit-category"><i class="material-icons">create</i></a>

                    </td>
                  </tr>
                <?php endwhile; if($res->num_rows == 0) :?>
                <tr>
                  <td colspan="4" class="text-center">No service category have been added</td>
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