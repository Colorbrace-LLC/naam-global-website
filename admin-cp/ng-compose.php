<?php
session_name('naamglobal');
session_start();
$page = 'Mail';
$subpage = 'compose';
include 'ng-header.php';


$composeslug = isset($_GET['composeslug']) ? $_GET['composeslug'] : ''; 

$nameslug = isset($_GET['nameslug']) ? $_GET['nameslug'] : ''; 

 ?>
      <div class="content">
        <div class="content">
          <div class="container-fluid">
           
          <?php if($composeslug) : $composeslug = encode(trim($composeslug),'d'); endif; if($nameslug) : $nameslug = encode(trim($nameslug),'d'); endif;?>
            <h3>Send messages</h3>
            <br>
            <div class="row d-flex justify-content-center">
           <div class="col-md-12 col-lg-7">
              <div class="card ">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">mail</i>
                  </div>
                  <h4 class="card-title">Compose</h4>
                </div>
                <div class="card-body ">
                  <form method="post" class="compose-form" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="receivers_name" class="bmd-label-floating">Receivers name</label>
                      <input type="text" class="form-control" name="receivers_name" value="<?=test_output($nameslug)?>" id="receivers_name" required>
                    </div>
                    <div class="form-group">
                      <label for="receivers_email" class="bmd-label-floating">Receivers email</label>
                      <input type="email" class="form-control" name="receivers_email" value="<?=test_output($composeslug)?>" id="receivers_email" required>
                    </div>
                    <div class="form-group">
                      <label for="subject" class="bmd-label-floating">Subject</label>
                      <input type="text" class="form-control" name="subject" id="subject" required>
                    </div>
                    <div class="form-group">
                      <label for="message_body" class="bmd-label-floating">Message body</label>
                      <textarea class="form-control" rows="10" name="message_body" id="message_body" required></textarea>
                    </div>
                    <div class="card-footer ">
                  <button type="submit" class="btn btn-fill btn-danger compose-btn">Send Message</button>
                </div>

                   
                  </form>
                   </div>
                
              </div>
            </div>
            </div>
            

          </div>
        </div>
      </div>
     <?php include 'ng-footer.php';?>