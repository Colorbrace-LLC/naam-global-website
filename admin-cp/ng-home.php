<?php
session_name('naamglobal');
session_start();
$page = 'Dashboard';
include 'ng-header.php';

 ?>
      <div class="content">
        <div class="content">
          <div class="container-fluid">
           
            <div class="row">
              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-warning card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons">school</i>
                    </div>
                    <p class="card-category">Students Application</p>
                    <h3 class="card-title"><?php $stuApp = getApplied("student"); echo $stuApp; ?></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <i class="material-icons">update</i> Last applied <?php if($stuApp != '0'){ echo timeAgo(getLastApplication('student'),date('Y-m-d H:i:s')); } else { echo "None";}?>
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons">credit_card</i>
                    </div>
                    <p class="card-category">Visa Application</p>
                    <h3 class="card-title"><?php $visApp = getApplied("visa"); echo $visApp;?></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <i class="material-icons">update</i> Last applied  <?php if($visApp != '0') { echo timeAgo(getLastApplication('visa'),date('Y-m-d H:i:s')); } else {echo "None";}?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons">tour</i>
                    </div>
                    <p class="card-category">Tour Bookings</p>
                    <h3 class="card-title"><?php $touApp = getApplied("tour"); echo $touApp; ?></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <i class="material-icons">update</i> Last booked <?php if($touApp != '0') { echo timeAgo(getLastApplication('tour'),date('Y-m-d H:i:s')); } else { echo "None";} ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                     <i class="material-icons">book_online</i>
                    </div>
                    <p class="card-category">Service Bookings</p>
                    <h3 class="card-title"><?=countAllBookings()?></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <i class="material-icons">update</i>Last booked <?=timeAgo(getLastBooking(),date('Y-m-d H:i:s'))?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <h3>Manage Users</h3>
            <br>
            <div class="row">
               <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary card-header-icon">
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
                            <a href="compose/<?=encode($row['email_address'],"e")?>/<?=encode($row['first_name']." ".$row['other_names'],"e")?>" class="btn btn-link btn-info btn-just-icon like"><i class="material-icons">email</i></a>
                            <a href="students/manage/<?=encode($row['id'],"e")?>" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">create</i></a>
                          
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
          </div>
        </div>
      </div>
     <?php include 'ng-footer.php';?>