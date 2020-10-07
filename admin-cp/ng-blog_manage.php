<?php
session_name('naamglobal');
session_start();
$page = 'Blog';
$subpage = 'bman';
include 'ng-header.php';

$blogslug = isset($_GET['blogslug']) ? $_GET['blogslug'] : ''; 

 ?>
      <div class="content">
        <div class="content">
          <div class="container-fluid">
           
          <?php if(!$blogslug) : ?>
            <h3>Manage Blog Posts</h3>
            <br>
            <div class="row">
        <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">rss_feed</i>
                  </div>
                 </div>
                <div class="card-body">
                  
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th class="disabled-sorting">Image</th>
                          <th>Title</th>
                          <th class="disabled-sorting">Excerpts</th>
                          <th>Status</th>
                          <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Image</th>
                          <th>Title</th>
                          <th>Excerpts</th>
                          <th>Status</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php 
                        $gql = "SELECT * FROM ng_blog";
                        $stmt = $db->prepare($gql);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        while ($row = $res->fetch_assoc()) :
                          $enabled = $row['status'];

                          switch ($enabled) {
                            case 'published':
                              $subRes = '<button class="btn btn-success btn-sm"> Published</button>';
                              break;
                            case 'draft':
                             $subRes = '<button class="btn btn-danger btn-sm"> Draft</button>';
                              break;
                            default:
                              # nothing
                              break;
                          }
                        ?>
                        <tr>
                          <td><div class="img-container">
                            <img src="/assets/images/blog/<?=$row['image']?>" alt="<?=test_output($row['title']) ?>">
                          </div></td>
                          <td><?=test_output($row['title']) ?></td>
                          <td><?=test_output($row['excerpt']) ?></td>
                          <td><?=$subRes?></td>
                          <td class="text-right">
                            <a href="#!" class="btn btn-link btn-info btn-just-icon del-blog" data-id="<?=encode($row['id'],"e")?>"><i class="material-icons">delete</i></a>
                            <a href="/admin-cp/blog/manage/<?=encode($row['id'],"e")?>"  class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">create</i></a>
                          
                          </td>
                        </tr>
                       <?php endwhile; if($res->num_rows == 0) :?>
                        <tr>
                          <td colspan="7" class="text-center">No blog posts have been created</td>
                        </tr>
                     <?php endif; ?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            </div>
            <?php endif; if ($blogslug) : 

              $blogslug = encode(trim($blogslug),'d');
              $uql = "SELECT * FROM ng_blog WHERE id = ?";
              $ustmt = $db->prepare($uql);
              $ustmt->bind_param('i',$blogslug);
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
                redirect("/admin-cp/blog/manage");
                exit();
              }
            ?>

             <h3>Editing <?=test_output($urow['title']);?> </h3>
            <br>
             <div class="row">
            <div class="col-md-12 col-lg-6">
              <div class="card ">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">rss_feed</i>
                  </div>
                  <h4 class="card-title">Update blog post</h4>
                </div>
                <div class="card-body ">
                  <form method="post" class="updateblog-form" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="e_blog_title" class="bmd-label-floating">Title</label>
                      <input type="text" class="form-control" name="e_blog_title" value="<?=test_output($urow['title']);?>" id="e_blog_title" required>
                    </div>
                    <div class="form-group">
                      <input type="hidden" name="blog_id" value="<?=encode($urow['id'],'e')?>">
                      <input type="hidden" name="blogimage" value="<?=encode($urow['image'],'e')?>">
                    </div>
                    <div class="form-group">
                      <label for="e_blog_excerpt"  class="bmd-label-floating">Excerpt</label>
                      <textarea  id="e_blog_excerpt" class="form-control" rows="2"  name="e_blog_excerpt" required><?=test_output(strip_tags($urow['excerpt']));?></textarea>
                        <span class="bmd-help">Must be less than 250 characters.</span>
                    </div>
                    <div class="form-group">
                      <label for="e_blog_body"  class="bmd-label-floating">Blog Body</label>
                      <textarea  id="e_blog_body" class="form-control" rows="4"  name="e_blog_body" required><?=test_output(strip_tags($urow['description']));?></textarea>
                    </div>
                   </div>
                
              </div>
            </div>
           <div class="col-md-12 col-lg-6">
            <div class="card ">
               
                <div class="card-body ">
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail">
                          <img src="/assets/images/blog/<?=$urow['image']?>" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                        <div>
                          <span class="btn btn-danger btn-round btn-file">
                            <span class="fileinput-new">change image</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="e_blog_image" accept=".jpg,.jpeg,.png" />
                          </span>
                          <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                      </div>
             
                     <div class="form-check">
                      <div class="col-sm-10 checkbox-radios">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="e_blog_status" <?php if($urow['status'] == 'draft'): echo "checked"; endif;?> value="draft"> Draft
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="e_blog_status" <?php if($urow['status'] == 'published'): echo "checked"; endif;?> value="published"> Published
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
                  <button type="submit" class="btn btn-fill btn-danger updateblog-btn">Update post</button>
                </div>
                  </form>
                </div>
                
              </div>
           </div>
          </div>

          <?php endif; ?>
          </div>
        </div>
      </div>
     <?php include 'ng-footer.php';?>