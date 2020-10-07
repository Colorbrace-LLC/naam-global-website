<?php
session_name('naamglobal');
session_start();
$page = 'Services';
$subpage = 'serb';
include 'ng-header.php';

 ?>
      <div class="content">
        <div class="content">
          <div class="container-fluid">
           
            <h3>Manage Service Bookings</h3>
            <br>
            <div class="row">
               <div class="col-md-12">
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
                          <th >Name</th>
                          <th>Service</th>
                          <th>Category</th>
                         <th class="disabled-sorting">Email</th>
                          <th class="disabled-sorting">Phone</th>
                          <th>Notes</th>
                          <th>Submitted</th>
                          <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th >Name</th>
                          <th>Service</th>
                          <th>Category</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Notes</th>
                          <th>Submitted</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php 
                        $gql = "SELECT * FROM ng_bookings";
                        $stmt = $db->prepare($gql);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        while ($row = $res->fetch_assoc()) :
                          $sid = $row['sid'];
                          $cid = $row['cid'];
                          $submitted = date_create($row['date_added']);
                          $status = $row['status'];

                          $iql = "SELECT title FROM ng_services WHERE id = ?";
                          $istmt = $db->prepare($iql);
                          $istmt->bind_param('i',$sid);
                          $istmt->execute();
                          $istmt->store_result();
                          $istmt->bind_result($title);
                          $istmt->fetch();

                           $cql = "SELECT name FROM ng_service_category WHERE id = ?";
                          $cstmt = $db->prepare($cql);
                          $cstmt->bind_param('i',$cid);
                          $cstmt->execute();
                          $cstmt->store_result();
                          $cstmt->bind_result($category);
                          $cstmt->fetch();


                          switch ($status) {
                            case 'reviewing':
                               $subRes = '<div class="dropdown">
                            <button class="dropdown-toggle btn btn-info btn-block" type="button" id="'.$row["id"].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Reviewing
                            </button>
                            <div class="dropdown-menu" aria-labelledby="'.$row["id"].'">
                              <a class="dropdown-item serv-u" data-id ="'.encode($row["id"],'e').'" data-role="processing" data-position="'.$row["id"].'" data-name="'.$row["first_name"].'" data-service="'.$title.'" data-category="'.$category.'" data-email = "'.$row["email_address"].'"  href="#!">Processing</a>
                              <a class="dropdown-item serv-u" data-id ="'.encode($row["id"],'e').'" data-role="completed" data-position="'.$row["id"].'" data-name="'.$row["first_name"].'" data-service="'.$title.'" data-category="'.$category.'" data-email = "'.$row["email_address"].'" href="#!">Completed</a>
                              <a class="dropdown-item serv-u" data-id ="'.encode($row["id"],'e').'" data-role="cancelled" data-position="'.$row["id"].'" data-name="'.$row["first_name"].'" data-service="'.$title.'" data-category="'.$category.'" data-email = "'.$row["email_address"].'" href="#!">Cancelled</a>
                            </div>
                          </div>';
                              break;
                            case 'processing':
                             $subRes = '<div class="dropdown">
                            <button class="dropdown-toggle btn btn-info btn-block" type="button" id="'.$row["id"].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Processing
                            </button>
                            <div class="dropdown-menu" aria-labelledby="'.$row["id"].'">
                              <a class="dropdown-item serv-u" data-id ="'.encode($row["id"],'e').'" data-role="reviewing" data-position="'.$row["id"].'" data-name="'.$row["first_name"].'" data-service="'.$title.'" data-category="'.$category.'" data-email = "'.$row["email_address"].'"  href="#!">Reviewing</a>
                              <a class="dropdown-item serv-u" data-id ="'.encode($row["id"],'e').'" data-role="completed" data-position="'.$row["id"].'" data-name="'.$row["first_name"].'" data-service="'.$title.'" data-category="'.$category.'" data-email = "'.$row["email_address"].'"  href="#!">Completed</a>
                              <a class="dropdown-item serv-u" data-id ="'.encode($row["id"],'e').'" data-role="cancelled" data-position="'.$row["id"].'" data-name="'.$row["first_name"].'" data-service="'.$title.'" data-category="'.$category.'" data-email = "'.$row["email_address"].'"  href="#!">Cancelled</a>
                            </div>
                          </div>';
                              break;
                            default:
                            case 'completed':
                               $subRes = '<div class="dropdown">
                            <button class="dropdown-toggle btn btn-success btn-block" type="button" id="'.$row["id"].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Completed
                            </button>
                            <div class="dropdown-menu" aria-labelledby="'.$row["id"].'">
                              <a class="dropdown-item serv-u" data-id ="'.encode($row["id"],'e').'" data-role="processing" data-position="'.$row["id"].'" data-name="'.$row["first_name"].'" data-service="'.$title.'" data-category="'.$category.'" data-email = "'.$row["email_address"].'"  href="#!">Processing</a>
                              <a class="dropdown-item serv-u" data-id ="'.encode($row["id"],'e').'" data-role="reviewing" data-position="'.$row["id"].'" data-name="'.$row["first_name"].'" data-service="'.$title.'" data-category="'.$category.'" data-email = "'.$row["email_address"].'"  href="#!">Reviewing</a>
                              <a class="dropdown-item serv-u" data-id ="'.encode($row["id"],'e').'" data-role="cancelled" data-position="'.$row["id"].'"  data-name="'.$row["first_name"].'" data-service="'.$title.'" data-category="'.$category.'" data-email = "'.$row["email_address"].'"  href="#!">Cancelled</a>
                            </div>
                          </div>';
                              break;
                            case 'cancelled':
                                $subRes = '<div class="dropdown">
                            <button class="dropdown-toggle btn btn-danger btn-block" type="button" id="'.$row["id"].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Cancelled
                            </button>
                            <div class="dropdown-menu" aria-labelledby="'.$row["id"].'">
                              <a class="dropdown-item serv-u" data-id ="'.encode($row["id"],'e').'" data-role="processing" data-position="'.$row["id"].'" data-name="'.$row["first_name"].'" data-service="'.$title.'" data-category="'.$category.'" data-email = "'.$row["email_address"].'"  href="#!">Processing</a>
                              <a class="dropdown-item serv-u" data-id ="'.encode($row["id"],'e').'" data-role="reviewing" data-position="'.$row["id"].'" data-name="'.$row["first_name"].'" data-service="'.$title.'" data-category="'.$category.'" data-email = "'.$row["email_address"].'"  href="#!">Reviewing</a>
                              <a class="dropdown-item serv-u" data-id ="'.encode($row["id"],'e').'" data-role="completed" data-position="'.$row["id"].'" data-name="'.$row["first_name"].'" data-service="'.$title.'" data-category="'.$category.'" data-email = "'.$row["email_address"].'"  href="#!">Completed</a>
                            </div>
                          </div>';
                              break;
                              
                          }
                        ?>
                        <tr>
                          <td><?=test_output($row['first_name']." ". $row['other_names']) ?></td>
                          <td><?=test_output($title) ?></td>
                          <td><?=test_output($category) ?></td>
                          <td><?=test_output($row['email_address']) ?></td>
                          <td><?=test_output($row['phone_number']) ?></td>
                          <td><?=test_output($row['notes']) ?></td>
                          <td><?=date_format($submitted, 'jS M Y \a\t g:ia'); ?></td>
                          <td><?=$subRes?></td>
                         
                        </tr>
                       <?php endwhile; if($res->num_rows == 0) :?>
                        <tr>
                          <td colspan="7" class="text-center">No service bookings have been made</td>
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