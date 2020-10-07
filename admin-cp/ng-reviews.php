<?php
session_name('naamglobal');
session_start();
$page = 'School';
$subpage = 'reviews';
include 'ng-header.php';

 ?>
        <div class="content">
          <div class="container-fluid">
           
            <div class="row">
            <div class="col-12">
              <div class="card ">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">school</i>
                  </div>
                  <h4 class="card-title">Manage reviews</h4>
                </div>
                <div class="card-body">
                  
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th>Student</th>
                          <th>School</th>
                          <th class="disabled-sorting">Title</th>
                          <th class="disabled-sorting">Message</th>
                          <th>Stars</th>
                          <th>Submitted</th>
                          <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Student</th>
                          <th>School</th>
                          <th>Title</th>
                          <th>Message</th>
                          <th>Stars</th>
                          <th>Submitted</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php 
                        $gql = "SELECT * FROM ng_reviews";
                        $stmt = $db->prepare($gql);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        while ($row = $res->fetch_assoc()) :
                          $joined = date_create($row['date_created']);
                          $enabled = $row['enabled'];
                          $stud = $row['sid'];
                          $scid = $row['scid'];

                          $fql = "SELECT first_name,other_names FROM ng_students WHERE id = ?";
                          $fstmt = $db->prepare($fql);
                          $fstmt->bind_param('i',$stud);
                          $fstmt->execute();
                          $fstmt->store_result();
                          $fstmt->bind_result($fname,$oname);
                          $fstmt->fetch();

                          $tql = "SELECT name FROM ng_schools WHERE id = ?";
                          $tstmt = $db->prepare($tql);
                          $tstmt->bind_param('i',$scid);
                          $tstmt->execute();
                          $tstmt->store_result();
                          $tstmt->bind_result($sname);
                          $tstmt->fetch();

                          switch ($enabled) {
                            case 'yes':
                              $subRes = '<div class="dropdown">
                            <button class="dropdown-toggle btn btn-success btn-block" type="button" id="'.$row["id"].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Approved
                            </button>
                            <div class="dropdown-menu" aria-labelledby="'.$row["id"].'">
                              <a class="dropdown-item rev-u" data-id ="'.encode($row["id"],'e').'" data-role="disable" data-position="'.$row["id"].'" href="#!">Disable</a>
                              <a class="dropdown-item rev-u" data-id ="'.encode($row["id"],'e').'" data-role="delete" data-position="'.$row["id"].'" href="#!">Delete</a>
                            </div>
                          </div>';
                              break;
                            case 'no':
                              $subRes = '<div class="dropdown">
                            <button class="dropdown-toggle btn btn-danger btn-block" type="button" id="'.$row["id"].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Disabled
                            </button>
                            <div class="dropdown-menu" aria-labelledby="'.$row["id"].'">
                               <a class="dropdown-item rev-u" data-id ="'.encode($row["id"],'e').'" data-role="approve" data-position="'.$row["id"].'" href="#!">Approve</a>
                              <a class="dropdown-item rev-u" data-id ="'.encode($row["id"],'e').'" data-role="delete" data-position="'.$row["id"].'" href="#!">Delete</a>
                            </div>
                          </div>';
                              break;
                            default:
                              # nothing
                              break;
                          }
                        ?>
                        <tr>
                          <td><?=test_output($fname." ". $oname) ?></td>
                          <td><?=test_output($sname) ?></td>
                          <td><?=test_output($row['title']) ?></td>
                          <td><?=test_output($row['message']) ?></td>
                          <td> <?=$row['stars'] ?></td>
                          <td><?=date_format($joined, "jS M Y"); ?></td>
                          <td><?=$subRes?></td>
                          
                        </tr>
                       <?php endwhile; if($res->num_rows == 0) :?>
                        <tr>
                          <td colspan="7" class="text-center">No reviews have been added</td>
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
     <?php include 'ng-footer.php';?>