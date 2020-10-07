 <footer class="footer">
        <div class="container">
          <nav class="float-left">
            <ul>
              <li>
                <a href="/admin-cp/dashboard">
                  Naam Global Educational Travel and Tour
                </a>
              </li>

            </ul>
          </nav>
          <div class="copyright float-right">
            &copy;
            <?=date('Y')?>, made with <i class="material-icons">favorite</i> by
            <a href="https://www.colorbrace.com/" target="_blank">Colorbrace LLC</a> for a better web.
          </div>
        </div>
      </footer>
    </div>
  </div>

  <div class="modal fade" id="loadResponse" tabindex="-1" role="dialog" aria-labelledby="loadResponse"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content loadResponse">
    
      
      </div>
      
        
     
    </div>
  </div>
</div>


  <script src="/assets/js/core/jquery.min.js"></script>
  <script src="/assets/js/core/popper.min.js"></script>
  <script src="/assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>

  <script src="/assets/js/plugins/bootstrap-selectpicker.js"></script>
 
  <script src="/assets/js/plugins/jquery.dataTables.min.js"></script>
 
  <script src="/assets/js/plugins/jasny-bootstrap.min.js"></script>
 
 
  <script src="/assets/js/iziToast.min.js"></script>
  <script src="/assets/js/dash-controller.js" type="text/javascript"></script>

  <script src="/assets/js/naam-dashboard.js?v=2.1.2" type="text/javascript"></script>

</body>
<?php 
if (isset($_SESSION['showError'])) {
    echo $_SESSION['showError'];
    unset($_SESSION['showError']);
}
if (isset($_SESSION['logoutError'])) {
    echo $_SESSION['logoutError'];
    unset($_SESSION['logoutError']);
}

if (isset($_SESSION['logoutSuccess'])) {
    echo $_SESSION['logoutSuccess'];
    unset($_SESSION['logoutSuccess']);
}

?>
</html>
