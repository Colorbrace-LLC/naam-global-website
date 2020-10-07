<?php
session_name('naamglobal');
session_start();
$page = 'Blog';
$subpage = 'badd';
include 'ng-header.php';

 ?>
      <div class="content">
        <div class="content">
          <div class="container-fluid">
          
             <h3>Blog Posts </h3>
            <br>
             <div class="row">
            <div class="col-md-12 col-lg-6">
              <div class="card ">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">add</i>
                  </div>
                  <h4 class="card-title">Add new post</h4>
                </div>
                <div class="card-body ">
                  <form method="post" class="blog-form" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="blog_title" class="bmd-label-floating">Title</label>
                      <input type="text" class="form-control" name="blog_title"  id="blog_title" required>
                    </div>
                    <div class="form-group">
                        <label for="blog_slug" >Slug</label>
                      <input type="text" class="form-control" name="blog_slug" readonly  id="blog_slug" required>
                    </div>
                    <div class="form-group">
                      <label for="blog_excerpt"  class="bmd-label-floating">Excerpt</label>
                      <textarea  id="blog_excerpt" class="form-control" rows="2"  name="blog_excerpt" required></textarea>
                        <span class="bmd-help">Must be less than 250 characters.</span>

                    </div>
                     <div class="form-group">
                      <label for="blog_body"  class="bmd-label-floating">Body</label>
                      <textarea  id="blog_body" class="form-control" rows="4"  name="blog_body" required></textarea>
                    </div>
                   
                </div>
                
              </div>
            </div>
           <div class="col-md-12 col-lg-6">
            <div class="card ">
               
                <div class="card-body ">
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail">
                          <img src="/assets/images/image_placeholder.jpg" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                        <div>
                          <span class="btn btn-danger btn-round btn-file">
                            <span class="fileinput-new">Select image</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="blog_image" accept=".jpg,.jpeg,.png" />
                          </span>
                          <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                      </div>
                     
                    <div class="form-group">
                    <div class="form-check">
                      <div class="col-sm-10 checkbox-radios">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="blog_status" value="draft"> Draft
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="blog_status" checked value="published"> Publish
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                       
                      </div>
                    </div>
                  </div>

                   <div class="progress md-progress" style="display: none;height: 10px">
                         <div class="progress-bar bg-danger" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    <div class="card-footer ">
                  <button type="submit" class="btn btn-fill btn-danger blog-btn">Add</button>
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