
    <!-- section start-->
    <section class="small-section dashboard-section bg-inner" data-sticky_parent>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="pro_sticky_info" data-sticky_column>
                        <div class="dashboard-sidebar">
                            <div class="profile-top">
                            <div class="profile-image">
                                <img src="/assets/images/profile/<?=$profileArray['avatar']?>" class="p-image img-fluid blur-up lazyload" alt="">
                                
                            </div>
                            <div class="profile-detail">
                                <h5><?=test_output($arow['first_name']." ". $arow['other_names']) ?></h5>
                                <h6><?=test_output($arow['phone_number']) ?></h6>
                                <h6><?=test_output($arow['email_address']) ?></h6>
                            </div>
                        </div>
                            <div class="faq-tab">
                                <ul class="nav nav-tabs" id="top-tab" role="tablist">
                                    <li class="nav-item"><a data-toggle="tab" class="nav-link active"
                                            href="#dashboard">dashboard</a></li>
                                    <li class="nav-item"><a data-toggle="tab" class="nav-link"
                                            href="#profile">profile <span class="fas <?php if(empty($profileArray['avatar'])){ echo 'fa-window-close float-right text-danger'; } else{ echo 'fa-check-square float-right text-success';}?> "></span></a></li>
                                             <li class="nav-item  <?php if(empty($profileArray['avatar'])) : echo 'bg-secondary'; endif;?>"><a data-toggle="tab" class="nav-link <?php if(empty($profileArray['avatar'])) : echo 'disabled'; endif;?>" href="#new-visa">New Visa Application</a></li>
                                    <li class="nav-item  <?php if(empty($profileArray['avatar'])) : echo 'bg-secondary'; endif;?>"><a data-toggle="tab" class="nav-link <?php if(empty($profileArray['avatar'])) : echo 'disabled'; endif;?>" href="#visa">Visa Applications</a></li>
                                    <li class="nav-item"><a data-toggle="tab" class="nav-link"
                                            href="#security">security</a></li>

                                            <li class="nav-item"><a class="nav-link"
                                            	href="/logout/<?=$token?>">Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="product_img_scroll" data-sticky_column>
                        <div class="faq-content tab-content" id="top-tabContent">
                            <div class="tab-pane fade show active" id="dashboard">
                                <div class="dashboard-main">
                                    <div class="dashboard-intro">
                                       <h5>welcome! <span><?=test_output($arow['first_name']. " ". $arow['other_names']) ?></span></h5>
                      <?php 
                      $comArray = array(10);
                      if ($arow['email_verified'] == 'yes') {
                        array_push($comArray, 30);
                      }
                       if ($arow['phone_verified'] == 'yes') {
                        array_push($comArray, 30);
                      }
                      if (!empty($profileArray['avatar'])) {
                        array_push($comArray, 30);
                      }

                      ?>
                      <p>you have completed <?=array_sum($comArray) ?>% of your profile. 
                      </p>
                                        <div class="complete-profile">
                          <div class="row">
                              <div class="col-xl-4">
<div class="complete-box <?php if ($arow['email_verified'] != 'yes') : echo 'not-complete'; endif;?>">
    <i class="far <?php if ($arow['email_verified'] != 'yes'){ echo 'fa-window-close'; } else { echo 'fa-check-square'; }?> "></i>
    <h6>verified email ID</h6>
</div>
                              </div>
                              <div class="col-xl-4">
<div class="complete-box  <?php if ($arow['phone_verified'] != 'yes') : echo 'not-complete'; endif;?>">
    <i class="far <?php if ($arow['phone_verified'] != 'yes'){ echo 'fa-window-close'; } else { echo 'fa-check-square'; }?>"></i>
    <h6>verified phone number</h6>
</div>
                              </div>
                              <div class="col-xl-4">
<div class="complete-box  <?php if (empty($profileArray['avatar'])) : echo 'not-complete'; endif;?>">
    <i class="far <?php if (empty($profileArray['avatar'])){ echo 'fa-window-close'; } else { echo 'fa-check-square'; }?>"></i>
    <h6>complete basic info</h6>
</div>
                              </div>
                          </div>
                      </div>
                                    </div>
                                    <div class="counter-section">
                      <div class="row">
                          <div class="col-xl-3 col-sm-6">
                              <div class="counter-box">
                              	<span class="fas fa-passport fa-2x blur-up lazyload mb-3 text-danger"></span>

                              	<h3><?php  
                              			$bql = "SELECT COUNT(*) FROM ng_visa_application WHERE sid = ?";

                              			$bstmt = $db->prepare($bql);
                              			$aid = $arow['id'];
                              			$bstmt->bind_param('i',$aid);
                              			$bstmt->execute();
                              			$bstmt->store_result();
                              			$bstmt->bind_result($booked);
                              			$bstmt->fetch();
                              			
                              			echo $booked;
                              		 ?></h3>
                              	<h5>Applied</h5>
                              </div>
                          </div>
                          <div class="col-xl-3 col-sm-6">
                          	<div class="counter-box">
                          		<span class="fas fa-thumbs-up fa-2x blur-up lazyload mb-3 text-success"></span>
                          		<h3><?php  
                              			$bql = "SELECT COUNT(*) FROM ng_visa_application WHERE sid = ? AND status = ?";

                              			$bstmt = $db->prepare($bql);
                              			$status = 'completed';
                              			$bstmt->bind_param('is',$aid,$status);
                              			$bstmt->execute();
                              			$bstmt->store_result();
                              			$bstmt->bind_result($completed);
                              			$bstmt->fetch();
                              			
                              			echo $completed;
                              		 ?></h3>
                          		<h5>Completed</h5>
                          	</div>
                          </div>
                          <div class="col-xl-3 col-sm-6">
                              <div class="counter-box">
                              	<span class="fas fa-frown fa-2x blur-up lazyload mb-3 text-warning"></span>
                              	<h3><?php  
                              			$bql = "SELECT COUNT(*) FROM ng_visa_application WHERE sid = ? AND status = ?";

                              			$bstmt = $db->prepare($bql);
                              			$status = 'cancelled';
                              			$bstmt->bind_param('is',$aid,$status);
                              			$bstmt->execute();
                              			$bstmt->store_result();
                              			$bstmt->bind_result($approved);
                              			$bstmt->fetch();
                              			
                              			echo $approved;
                              		 ?></h3>
                              	<h5>Declined/Cancelled</h5>
                              </div>
                          </div>
                          <div class="col-xl-3 col-sm-6">
                              <div class="counter-box">  
                                 <span class="fas fa-sync fa-2x blur-up lazyload mb-3 text-info"></span>

                                 <h3><?php  
                              			$bql = "SELECT COUNT(*) FROM ng_visa_application WHERE sid = ? AND status = ?";

                              			$bstmt = $db->prepare($bql);
                              			$status = 'processing';
                              			$bstmt->bind_param('is',$aid,$status);
                              			$bstmt->execute();
                              			$bstmt->store_result();
                              			$bstmt->bind_result($approved);
                              			$bstmt->fetch();
                              			
                              			echo $approved;
                              		 ?></h3>
                                 <h5>Processing</h5>
                             </div>
                         </div>
                     </div>
                 </div>
                                    <div class="dashboard-info">
                                        <div class="row">
                                         
                                            <div class="col-md-12">
                                                <div class="activity-box">
                                                    <h6>recent activity</h6>
                                                     <ul>
                            <?php 

                            $tql = "SELECT * FROM ng_activities WHERE sid = ?  AND type = ?";
                            $tstmt = $db->prepare($tql);
                            $sid = $arow['id'];
                            $type = 'visa';

                            $tstmt->bind_param('is',$sid,$type);
                            $tstmt->execute();
                            $tres = $tstmt->get_result();

                            while($trow = $tres->fetch_assoc()) :

                            ?>
                              <li>
                                <i class="fas fa-info-circle"></i>
                                    <?=test_output($trow['message']) ?>
                                <span><?=timeAgo($trow['date_added'], date('Y-m-d H:i:s'))?></span>
                              </li>
                          <?php endwhile;  if($tres->num_rows == 0) :?>
                              <li class="blue-line">
                                <i class="fas fa-info-circle"></i>
                               No new activity recorded.
                              </li>

                          <?php endif; ?>
                              
                          </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile">
                                <div class="dashboard-box">
                                    <div class="dashboard-title">
                                        <h4>profile</h4>
                                        <span data-toggle="modal" data-target="#edit-profile">edit</span>
                                    </div>
                                    <div class="dashboard-detail">
                                        <ul>
                                            <li>
                                                <div class="details">
                                                    <div class="left">
                                                        <h6>name</h6>
                                                    </div>
                                                    <div class="right">
                                                        <h6><?=test_output($profileArray['fname']." ". $profileArray['mname']." ". $profileArray['sname']);?></h6>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="details">
                                                    <div class="left">
                                                        <h6>nationality</h6>
                                                    </div>
                                                    <div class="right">
                                                        <h6><?=$profileArray['nationality']?></h6>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="details">
                                                    <div class="left">
                                                        <h6>gender</h6>
                                                    </div>
                                                    <div class="right">
                                                        <h6><?=$profileArray['gender']?></h6>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="details">
                                                    <div class="left">
                                                        <h6>residential address</h6>
                                                    </div>
                                                    <div class="right">
                                                        <h6><?=$profileArray['residential']?></h6>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="details">
                                                    <div class="left">
                                                        <h6>hometown</h6>
                                                    </div>
                                                    <div class="right">
                                                        <h6><?=$profileArray['hometown']?></h6>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="details">
                                                    <div class="left">
                                                        <h6>postal</h6>
                                                    </div>
                                                    <div class="right">
                                                        <h6><?=$profileArray['postal']?></h6>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="dashboard-box">
                                    <div class="dashboard-title">
                                        <h4>security details</h4>
                                    </div>
                                    <div class="dashboard-detail">
                                        <ul>
                                            <li>
                                                <div class="details">
                                                    <div class="left">
                                                        <h6>email address</h6>
                                                    </div>
                                                    <div class="right">
                                                        <h6 class="text-lowercase"><?=$arow['email_address']?></h6>
                                                        <span data-toggle="modal"
                                                            data-target="#edit-address">edit</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="details">
                                                    <div class="left">
                                                        <h6>phone no:</h6>
                                                    </div>
                                                    <div class="right">
                                                        <h6><?=$arow['phone_number']?></h6>
                                                        <span data-toggle="modal" data-target="#edit-phone">edit</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="details">
                                                    <div class="left">
                                                        <h6>password</h6>
                                                    </div>
                                                    <div class="right">
                                                        <h6>&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;</h6>
                                                        <span data-toggle="modal"
                                                            data-target="#edit-password">edit</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="visa">
                                <div class="dashboard-box">
                                    <div class="dashboard-title">
                                        <h4>Submitted applications</h4>
                                    </div>
                                    <?php 

                                    	$kql = "SELECT * FROM ng_visa_application WHERE sid = ? AND status = ?";
                                    	$kstmt = $db->prepare($kql);
                                    	$b_stat = 'submitted';
                                    	$kstmt->bind_param('is',$sid,$b_stat);
                                    	$kstmt->execute();
                                    	$kres = $kstmt->get_result();
                                    	while ($krow = $kres->fetch_assoc()) :
                                    		$dated = date_create($krow['last_updated']);
                                    		$visaArray = $krow['visa_details'];

                                    		$visaArray = unserialize($visaArray);
                                    ?>
                                    <div class="dashboard-detail">
                                        <div class="booking-box">
                                            <div class="date-box">
                                                <span class="day"><?=date_format($dated, 'D'); ?></span>
                                                <span class="date"><?=date_format($dated, 'j'); ?></span>
                                                <span class="month"><?=date_format($dated, 'M'); ?></span>
                                            </div>
                                            <div class="detail-middle">
                                                <div class="media">
                                                    <div class="icon">
                                                        <i class="fab fa-cc-visa"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="media-heading"><?=test_output($visaArray['type']) ?></h6>
                                                        
                                                    </div>
                                                    <div class="media-body">
                                                        
                                                        <p>priority: <span><?=test_output($visaArray['priority']) ?></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="detail-last">
                                                <a href="#!" data-id = "<?=encode($krow['id'],'e')?>" class="cancel-visa" ><i class="fas fa-window-close" data-toggle="tooltip"
                                                        data-placement="top" title="cancel visa application"></i></a>
                                                <span class="badge badge-info">Submitted</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; if($kres->num_rows == 0) : ?>
                                <div class="dashboard-detail">
                                        <div class="booking-box">
                                        	<p>No applications submitted </p>
                                        </div>
                                    </div>
                            <?php endif; ?>
                                    
                                </div>

                                  <div class="dashboard-box">
                                    <div class="dashboard-title">
                                        <h4>Processing Applications</h4>
                                    </div>
                                    <?php 

                                    	$kql = "SELECT * FROM ng_visa_application WHERE sid = ? AND status = ?";
                                    	$kstmt = $db->prepare($kql);
                                    	$b_stat = 'processing';
                                    	$kstmt->bind_param('is',$sid,$b_stat);
                                    	$kstmt->execute();
                                    	$kres = $kstmt->get_result();
                                    	while ($krow = $kres->fetch_assoc()) :
                                    		$dated = date_create($krow['last_updated']);
                                    		$visaArray = $krow['visa_details'];

                                    		$visaArray = unserialize($visaArray);
                                    ?>
                                    <div class="dashboard-detail">
                                        <div class="booking-box">
                                            <div class="date-box">
                                                <span class="day"><?=date_format($dated, 'D'); ?></span>
                                                <span class="date"><?=date_format($dated, 'j'); ?></span>
                                                <span class="month"><?=date_format($dated, 'M'); ?></span>
                                            </div>
                                            <div class="detail-middle">
                                                <div class="media">
                                                    <div class="icon">
                                                        <i class="fab fa-cc-visa"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="media-heading"><?=test_output($visaArray['type']) ?></h6>
                                                        
                                                    </div>
                                                    <div class="media-body">
                                                        
                                                        <p>priority: <span><?=test_output($visaArray['priority']) ?></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="detail-last">
                                                
                                                <span class="badge badge-info">Processing</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; if($kres->num_rows == 0) : ?>
                                <div class="dashboard-detail">
                                        <div class="booking-box">
                                        	<p>No applications are being processed </p>
                                        </div>
                                    </div>
                            <?php endif; ?>
                                    
                                </div>
                                <div class="dashboard-box">
                                    <div class="dashboard-title">
                                        <h4>Completed applications</h4>
                                    </div>
                                    <?php 

                                    	$kql = "SELECT * FROM ng_visa_application WHERE sid = ? AND status = ?";
                                    	$kstmt = $db->prepare($kql);
                                    	$b_stat = 'completed';
                                    	$kstmt->bind_param('is',$sid,$b_stat);
                                    	$kstmt->execute();
                                    	$kres = $kstmt->get_result();
                                    	while ($krow = $kres->fetch_assoc()) :
                                    		$dated = date_create($krow['last_updated']);
                                    		$visaArray = $krow['visa_details'];

                                    		$visaArray = unserialize($visaArray);
                                    ?>
                                    <div class="dashboard-detail">
                                        <div class="booking-box">
                                            <div class="date-box">
                                                <span class="day"><?=date_format($dated, 'D'); ?></span>
                                                <span class="date"><?=date_format($dated, 'j'); ?></span>
                                                <span class="month"><?=date_format($dated, 'M'); ?></span>
                                            </div>
                                            <div class="detail-middle">
                                                <div class="media">
                                                    <div class="icon">
                                                        <i class="fab fa-cc-visa"></i>
                                                    </div>
                                                     <div class="media-body">
                                                        <h6 class="media-heading"><?=test_output($visaArray['type']) ?></h6>
                                                        
                                                    </div>
                                                    <div class="media-body">
                                                        
                                                        <p>priority: <span><?=test_output($visaArray['priority']) ?></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="detail-last">
                                                <span class="badge badge-success">Completed</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; if($kres->num_rows == 0) : ?>
                                <div class="dashboard-detail">
                                        <div class="booking-box">
                                        	<p>No applications completed </p>
                                        </div>
                                    </div>
                            <?php endif; ?>
                                   
                                </div>
                                <div class="dashboard-box">
                                    <div class="dashboard-title">
                                        <h4>cancelled applications</h4>
                                    </div>
                                           <?php 

                                    	$kql = "SELECT * FROM ng_visa_application WHERE sid = ? AND status = ?";
                                    	$kstmt = $db->prepare($kql);
                                    	$b_stat = 'cancelled';
                                    	$kstmt->bind_param('is',$sid,$b_stat);
                                    	$kstmt->execute();
                                    	$kres = $kstmt->get_result();
                                    	while ($krow = $kres->fetch_assoc()) :
                                    		$dated = date_create($krow['last_updated']);
                                    		$visaArray = $krow['visa_details'];

                                    		$visaArray = unserialize($visaArray);
                                    ?>
                                    <div class="dashboard-detail">
                                        <div class="booking-box">
                                            <div class="date-box">
                                                <span class="day"><?=date_format($dated, 'D'); ?></span>
                                                <span class="date"><?=date_format($dated, 'j'); ?></span>
                                                <span class="month"><?=date_format($dated, 'M'); ?></span>
                                            </div>
                                            <div class="detail-middle">
                                                <div class="media">
                                                    <div class="icon">
                                                        <i class="fab fa-cc-visa"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="media-heading"><?=test_output($visaArray['type']) ?></h6>
                                                        
                                                    </div>
                                                    <div class="media-body">
                                                        
                                                        <p>priority: <span><?=test_output($visaArray['priority']) ?></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="detail-last">
                                                <span class="badge badge-danger">Cancelled</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; if($kres->num_rows == 0) : ?>
                                <div class="dashboard-detail">
                                        <div class="booking-box">
                                        	<p>No applications cancelled </p>
                                        </div>
                                    </div>
                            <?php endif; ?>
                                    
                                </div>
                            </div>
                            <div class="tab-pane fade" id="new-visa">
                                <div class="single-section">

   									<div class="description-section tab-section">
   										<div class="menu-top menu-up">
       									 <ul class="nav nav-tabs" id="top-tab" role="tablist">
           									 <li class="nav-item"><a data-toggle="tab" class="nav-link active"
               								 href="#newbook">New Visa Application</a></li>
               								 </ul>
               								</div>
               								<form class="visa-form" method="post" enctype="multipart/form-data">
               									 <div class="description-details tab-content" id="top-tabContent">
                									<div class="menu-part about tab-pane fade show active" id="newbook">
                										 <div class="title-1">
                										 	<span class="title-label">Part a</span>
                										 	<h2>Apply for Visa</h2>
                										 	<h5>Fill out the form to apply for a visa</h5>
                										 </div>
                										 <div class="form-row">
                										 <div class="form-group col-md-6">
                										 	<label for="visa_type">Select Visa type <small>Required</small></label>
                										 	<select class="form-control" id="visa_type" name="visa_type" required>
                										 		<option value="" selected disabled>Select Visa type</option>

                										 		<?php  $sql = "SELECT * FROM ng_visas WHERE enabled  = ? ORDER BY id DESC";
                										 		$stmt = $db->prepare($sql);
                										 		$enabled = 'yes';
                										 		$stmt->bind_param('s',$enabled);
                										 		$stmt->execute();
                										 		$res = $stmt->get_result();
                										 		while ($row = $res->fetch_assoc()) : ?>
                										 			<option value="<?=encode($row['name'],'e')?>"><?=test_output($row['name']); ?></option>

                										 		<?php endwhile; if($res->num_rows == 0) :?>
                										 		<option disabled value="">No visa types available</option>
                										 	<?php endif;?>
                										 </select>
                										</div>
                										 <div class="form-group col-md-6">
                										 	<input type="hidden" name="vid" value="<?=encode($arow['id'],'e')?>">
                										 	<label for="priority">Priority <small>Required</small></label>
                										 	<select class="form-control" id="priority" name="priority" required>
                										 		<option value="" selected disabled>Select priority</option>
                										 		<option value="emergency">Emergency</option>
                										 		<option value="regular">Regular</option>
                										 </select>
                										</div>
                									</div>
                									
                									<div class="form-group">
                										<label for="add_notes">Additional information</label>
                										<textarea class="form-control" rows="4" id="add_notes" name="add_notes" placeholder="Optional information giving more details"></textarea>
                									</div>
                									<div class="form-group">
                										<button type="submit" class="btn btn-solid color1 visa-btn float-right">Add</button>
                									</div>
                									</div>
                								</div>
               								</form>
            						
   									</div>
   								</div>
                            </div>
                           
                            <div class="tab-pane fade" id="security">
                                <div class="dashboard-box">
                                    <div class="dashboard-title">
                                        <h4>delete your accont</h4>
                                    </div>
                                    <div class="dashboard-detail">
                                    	<div class="delete-section">
                                    		<p>Hi <span class="text-bold"><?=test_output($arow['first_name']." ".$arow['other_names']) ?></span>,</p>
                                    		<p>we are sorry to here you would like to delete your account.</p>
                                    		<p><span class="text-bold">note:</span></p>
                                    		<p>deleting your account will permanently remove your profile, personal
                                    			settings, and all other associated information.
                                    			once your account is deleted, you will be logged out and will not be unable
                                    			to log back in.
                                    		</p>
                                    		<p>if you understand and agree to the above statement, and would still like
                                    		to delete your account, then click below</p>
                                    		<a href="#" data-toggle="modal" data-target="#delete-account"
                                    		class="btn btn-solid">delete my account</a>
                                    	</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section end-->

    <!-- edit profile modal start -->
    <div class="modal fade edit-profile-modal" id="edit-profile" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="tour-form" method="post" enctype="multipart/form-data">
                    	<div class="form-row">
                    		<div class="form-group col-md-6">
                    			<div class="profile-image">
                    				<img src="/assets/images/profile/<?=$profileArray['avatar']?>" class="img-fluid p-image blur-up lazyload" alt="">
                    				<a class="profile-img p-file" href="javascript:void(0)" data-toggle="tooltip" data-title= "Edit Image">
                    					<input type="file" name="profile_image" accept=".jpg,.png,.jpeg" id="profile_image">
                    					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    					viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    					stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                    					<path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34">
                    					</path>
                    					<polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                    				</svg>
                    			</a>
                    		</div>
                    	</div>
                    	<div class="form-group col-md-6">
                    		<label for="title">Title</label>
                    		<select class="form-control" name="title" id="title" required>
                    			<option value="" selected disabled>Choose title</option>
                    			<option <?php if($profileArray['title'] == 'Mr.') : echo "selected"; endif;?>>Mr.</option>
                    			<option <?php if($profileArray['title'] == 'Mrs.') : echo "selected"; endif;?>>Mrs.</option>
                    			<option <?php if($profileArray['title'] == 'Miss') : echo "selected"; endif;?>>Miss</option>
                    			<option <?php if($profileArray['title'] == 'Rev') : echo "selected"; endif;?>>Rev</option>
                    			<option <?php if($profileArray['title'] == 'Prof') : echo "selected"; endif;?>>Prof</option>
                    		</select>
                    	</div>
                    </div>
                  <input type="hidden" name="default_image" value="<?=$profileArray['avatar']?>">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="first">first name <small>Required</small></label>
                                <input type="text" class="form-control" value="<?=$profileArray['fname']?>" name="t_fname" id="first" required placeholder="first name">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="middle">Middle Name</label>
                                <input type="text" class="form-control" value="<?=$profileArray['mname']?>" id="middle" name="t_mname" placeholder="middle name">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="last">last name  <small>Required</small></label>
                                <input type="text" class="form-control" id="last" name="t_sname" value="<?=$profileArray['sname']?>"  required placeholder="last name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="gender">gender <small>Required</small></label>
                                <select id="gender" name="gender" class="form-control">
                                    <option value="" selected disabled>Choose...</option>
                                    <option value="female" <?php if($profileArray['gender'] == 'female') : echo "selected"; endif;?>>female</option>
                                    <option value="male" <?php if($profileArray['gender'] == 'male') : echo "selected"; endif;?>>male</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nationality">nationality <small>Required</small></label>
                                <input type="text" class="form-control" name="nationality"  value="<?=$profileArray['nationality']?>"  required placeholder="e.g Ghanaian" id="nationality" />
                            </div>
                            <div class="form-group col-12">
                                <label for="residential">Residential Address <small>Required</small></label>
                               <input type="text" class="form-control"  value="<?=$profileArray['residential']?>"  placeholder="Residential address" name="residential" id="residential" required>
                            </div>
                            <div class="form-group col-md-6">
                            	<label for="hometown">Hometown <small>required</small></label>
                            	<input type="text" name="hometown"  value="<?=$profileArray['hometown']?>"  placeholder="Hometown" required id="hometown" class="form-control">
                            </div>
                          
                            <div class="form-group col-md-6">
                            	<label for="postal">Postal Address <small>required</small></label>
                            	<input type="text" class="form-control"  value="<?=$profileArray['postal']?>"  placeholder="postal code" name="postal" id="postal" required>
                            </div>
                        </div>
                         <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-solid tour-btn">Save changes</button>
                </div>
                    </form>
                </div>
               
            </div>
        </div>
    </div>
    <!-- edit profile modal start -->


    <!-- edit address modal start -->
    <div class="modal fade edit-profile-modal" id="edit-address" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">change email address </h5> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                	 <p class="text-danger text-center"><small>you will be logout after changing your email address</small></p>
                    <form method="post" class="mail-form">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="old">old email</label>
                                <input type="email" class="form-control" name="old_mail" id="old">
                            </div>
                            <div class="form-group col-12">
                                <label for="new">enter new email</label>
                                <input type="email" class="form-control" name="new_mail" id="new">
                            </div>
                            <input type="hidden" name="o_mail_id" value="<?=encode($arow['email_address'],'e')?>">

                            <div class="form-group col-12">
                                <label for="comfirm">confirm your email</label>
                                <input type="email" class="form-control" name="confirm_mail" id="comfirm">
                            </div>
                        </div>
                         <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-solid mail-btn">Save changes</button>
                </div>
                    </form>
                </div>
               
            </div>
        </div>
    </div>
    <!-- edit address modal start -->


    <!-- edit phone no modal start -->
    <div class="modal fade edit-profile-modal" id="edit-phone" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">change phone no</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="phone-form" method="post">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="ph-o">old phone no</label>
                                <input type="number" class="form-control" name="ph-o" id="ph-o">
                            </div>
                            <div class="form-group col-12">
                            <input type="hidden" name="o_ph_id" value="<?=encode($arow['phone_number'],'e')?>">

                                <label for="ph-n">enter new phone no</label>

                                <input type="number" class="form-control" name="ph-n" id="ph-n" pattern="^\+(?:[0-9]●?){6,14}[0-9]$">
                                <small class="text-muted">must begin with country code</small>
                            </div>
                            <div class="form-group col-12">
                                <label for="ph-c">confirm your phone no</label>
                                <input type="number" class="form-control" name="ph-c" id="ph-c" pattern="^\+(?:[0-9]●?){6,14}[0-9]$">
                            </div>
                        </div>
                        <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-solid phone-btn">Save changes</button>
                </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
    <!-- edit phone no modal start -->


    <!-- edit password modal start -->
    <div class="modal fade edit-profile-modal" id="edit-password" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">change email address</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="password-form" method="post">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="p-o">old password</label>
                                <input type="password" class="form-control" name="p-o" id="p-o">
                            </div>
                            <div class="form-group col-12">
                            	<input type="hidden" name="o_pass_id" value="<?=encode($arow['email_address'],'e')?>">
                                <label for="p-n">enter new password</label>
                                <input type="password" class="form-control" name="p-n" id="p-n">
                            </div>
                            <div class="form-group col-12">
                                <label for="p-c">confirm your password</label>
                                <input type="password" class="form-control" name="p-c" id="p-c">
                            </div>
                        </div>
                        <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-solid password-btn">Save changes</button>
                </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
    <!-- edit password modal start -->


    <!-- account termination -->
    <div class="modal fade edit-profile-modal" id="delete-account" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Account deletion request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-dark">Before you leave, please tell us why you'd like to delete your Naam account.
                        This information will help us improve. (optional)</p>
                    <form class="terminate-form" method="post">
                        <textarea class="form-control" id="terminate-reason" name="terminate_reason" rows="3"></textarea>
                        <input type="hidden" name="terminate_name" value="<?=encode($arow['first_name']. " ".$arow['other_names'], 'e')?>">
                        <input type="hidden" name="terminate_email" value="<?=encode($arow['email_address'], 'e')?>">
                        <input type="hidden" name="terminate_id" value="<?=encode($arow['id'], 'e')?>">


                        <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-solid terminate-btn">delete my account</button>
                </div>
                    </form>

                </div>
                
            </div>
        </div>
    </div>
    <!-- edit password modal start -->
