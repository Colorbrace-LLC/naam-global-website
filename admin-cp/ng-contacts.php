<?php
session_name('naamglobal');
session_start();
$page = 'Mail';
$subpage ='contacts';
include 'ng-header.php';

 ?>
      <div class="content">
        <div class="content">
          <div class="container-fluid">
           
            <h3>Manage Contact Messages</h3>
            <br>
            <div class="row">
        <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">contact_mail</i>
                  </div>
                 </div>
                <div class="card-body">
                  
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Date Sent</th>
                          <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                        <th>Name</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Message</th>
                          <th>Date Sent</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php 
                        $gql = "SELECT * FROM ng_contact";
                        $stmt = $db->prepare($gql);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        while ($row = $res->fetch_assoc()) :
                         
                        ?>
                        <tr>
                          
                          <td><?=test_output($row['name']) ?></td>
                          <td><?=test_output($row['phone']) ?></td>
                          <td><?=test_output($row['email']) ?></td>
                          <td><?=test_output($row['message']) ?></td>
                          <td><?=timeAgo($row['date_sent'], date('Y-m-d H:i:s'))?></td>
                          <td class="text-right">
                            <a href="/admin-cp/compose/<?=encode($row['email'],"e")?>/<?=encode($row['name'],"e")?>" class="btn btn-link btn-info btn-just-icon"><i class="material-icons">mail</i></a>
                            <a href="#!"  data-id="<?=encode($row['id'],"e")?>" class="btn btn-link btn-warning btn-just-icon del-contact"><i class="material-icons">delete</i></a>
                          
                          </td>
                        </tr>
                       <?php endwhile; if($res->num_rows == 0) :?>
                        <tr>
                          <td colspan="4" class="text-center">No contact form messages </td>
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