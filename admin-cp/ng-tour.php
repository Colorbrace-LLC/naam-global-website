<?php
session_name('naamglobal');
session_start();
$page = 'Tours';
$subpage = 'tbooking';
include 'ng-header.php';

$tourslug = isset($_GET['tourslug']) ? $_GET['tourslug'] : ''; 

 ?>
      <div class="content">
        <div class="content">
          <div class="container-fluid">
           
          <?php if(!$tourslug) : ?>
            <h3>Manage Tour Bookings</h3>
            <br>
            <div class="row">
               <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">tour</i>
                  </div>
                 </div>
                <div class="card-body">
                  
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th >Name</th>
                          <th class="disabled-sorting">Email</th>
                          <th class="disabled-sorting">Phone</th>
                          <th>Submitted on</th>
                          <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Submitted on</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php 
                        $gql = "SELECT * FROM ng_tour_bookings";
                        $stmt = $db->prepare($gql);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        while ($row = $res->fetch_assoc()) :
                          $sid = $row['sid'];

                          $fql = "SELECT first_name,other_names,email_address,phone_number FROM ng_students WHERE id  = ?";
                          $fstmt  = $db->prepare($fql);
                          $fstmt->bind_param('i',$sid);
                          $fstmt->execute();
                          $fstmt->store_result();
                          $fstmt->bind_result($fname,$oname,$email,$phone);
                          $fstmt->fetch();

                          $submitted = date_create($row['last_updated']);
                         
                        ?>
                        <tr>
                          <td><?=test_output($fname." ". $oname) ?></td>
                          <td><?=test_output($email) ?></td>
                          <td><?=test_output($phone) ?></td>
                          <td><?=date_format($submitted, "jS M Y"); ?></td>
                          <td class="text-right">
                            <a href="/admin-cp/tours/booking/<?=encode($row['id'],"e")?>"  class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">create</i></a>
                          
                          </td>
                        </tr>
                       <?php endwhile; if($res->num_rows == 0) :?>
                        <tr>
                          <td colspan="5" class="text-center">No tour bookings submitted</td>
                        </tr>
                     <?php endif; ?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            </div>
            <?php endif; if ($tourslug) : 

              $tourslug = encode(trim($tourslug),'d');
              $uql = "SELECT * FROM ng_tour_bookings WHERE id = ?";
              $ustmt = $db->prepare($uql);
              $ustmt->bind_param('i',$tourslug);
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
                redirect("/admin-cp/tours/booking");
                exit();
              }

              $tourArray = $urow['tour_details'];

              $tourArray = unserialize($tourArray);

              $sql = "SELECT email_address,phone_number,profile_info FROM ng_students WHERE id = ?";
              $stmt = $db->prepare($sql);
              $sid = $urow['sid'];
              $stmt->bind_param('i',$sid);
              $stmt->execute();
              $stmt->store_result();
              $stmt->bind_result($email,$phone,$profileArray);
              $stmt->fetch();


              if ($stmt->num_rows == 0) {
                 $_SESSION['showError'] =  "<script>function showError() {
     iziToast.warning({
         title: 'Known error!',
         message: 'This user account has been terminated',
         position: 'bottomRight'  });
 } showError(); </script>";
                redirect("/admin-cp/tours/booking");
                exit();
              }

              $profileArray = unserialize($profileArray);
              $exp = test_output($tourArray['expected_start']);
              $exp = date_create($exp);

            ?>

             <h3>Viewing <?=test_output($profileArray['fname']." ".$profileArray['mname']." ".$profileArray['sname']);?> </h3>
            <br>
             <div class="row">
          <div class="col-md-12">
              <div class="card ">
                <div class="card-header ">
                  <h4 class="card-title">Booking details -
                    <small class="description"><?=test_output($profileArray['fname']." ".$profileArray['mname']." ".$profileArray['sname']);?></small>
                  </h4>
                </div>
                <div class="card-body ">
                  <div class="row">
                    <div class="col-lg-4 col-md-6">
                     
                      <ul class="nav nav-pills nav-pills-danger nav-pills-icons flex-column" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link " data-toggle="tab" href="#profileInfo" role="tablist">
                            <i class="material-icons">person</i> Profile
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#tourInfo" role="tablist">
                            <i class="material-icons">tour</i> Tour details
                          </a>
                        </li>
                        
                      </ul>
                    </div>
                    <div class="col-md-8">
                      <div class="tab-content">
                        <div class="tab-pane " id="profileInfo">
                         <div class="table-responsive">
                          <table class="table">
                            <tbody>
                               <tr>
                                <th>Photo</th>
                                <td> <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail img-circle">
                          <img src="/assets/images/profile/<?=$profileArray['avatar']?>" alt="...">
                        </div>
                        <a class="btn btn-danger btn-file" href="/assets/images/profile/<?=$profileArray['avatar']?>" download="<?=test_output($profileArray['fname'] ." ". $profileArray['mname']." ".$profileArray['sname']) ?>_<?=$profileArray['avatar']?>" >
                           <i class="material-icons">get_app</i> 
                          </a>
                            <span class="text-muted"><?=fileSize_formatted("../assets/images/profile/".$profileArray['avatar'])?></span> 
                       
                      </div></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><?=test_output($profileArray['title'] ." ". $profileArray['fname'] ." ". $profileArray['mname']." ".$profileArray['sname']) ?></td>
                    </tr>
                   
                    <tr>
                        <th>Hometown</th>
                        <td><?=test_output($profileArray['hometown']) ?></td>
                    </tr>
                    
                    <tr>
                        <th>Gender</th>
                        <td><?=test_output($profileArray['gender']) ?></td>
                    </tr>
                    <tr>
                        <th>Nationality</th>
                        <td><?=test_output($profileArray['nationality']) ?></td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td><?=test_output($phone) ?></td>
                    </tr>
                    <tr>
                        <th>Email Address</th>
                        <td><?=test_output($email) ?></td>
                    </tr>
                    
                    <tr>
                        <th>Postal Address</th>
                        <td><?=test_output($profileArray['postal']) ?></td>
                    </tr>
                    <tr>
                        <th>Residential Address</th>
                        <td><?=test_output($profileArray['residential']) ?></td>
                    </tr>
                            </tbody>
                          </table>
                         </div>
                        </div>
                        <div class="tab-pane" id="tourInfo">
                          <span class="pull-right"><button type="button" class="btn btn-sm btn-danger tour-progress" data-its="<?=encode($urow['id'],'e')?>" data-tourist="<?=encode($urow['sid'],'e')?>">Update progress</button></span>
         <div class="table-responsive">
            <table class="table">
                <tbody>
                     <tr>
                        <th>Destination</th>
                        <td><?=test_output($tourArray['destination']) ?></td>
                    </tr>
                      <tr>
                        <th>Expected start date</th>
                        <td><?=date_format($exp,"jS M Y")?></td>
                    </tr>
                     <tr>
                        <th>Accomodation</th>
                        <td><?=test_output($tourArray['accomodation']['supported']) ?></td>
                    </tr>
                    <tr>
                        <th>No. of Rooms</th>
                        <td><?=test_output($tourArray['accomodation']['rooms']) ?></td>
                    </tr>
                     <tr>
                        <th>No. of Children</th>
                        <td><?=test_output($tourArray['accomodation']['children']) ?></td>
                    </tr>
                     <tr>
                        <th>No. of Adults</th>
                        <td><?=test_output($tourArray['accomodation']['adults']) ?></td>
                    </tr>
                    <tr>
                        <th>Duration</th>
                        <td><?=test_output($tourArray['duration']) ?></td>
                    </tr>
                      <tr>
                        <th>Additional Notes</th>
                        <td><?=test_output($tourArray['notes']) ?></td>
                      </tr>
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

</div>

          <?php endif; ?>
          </div>
        </div>
      </div>
     <?php include 'ng-footer.php';?>