/**
 * This file is the main entry point for the customer section of the CRM application.
 * 
 * 
 * It includes the necessary configuration and layout files, and dynamically loads
 * the content based on the 'page' query parameter.
 * 
 * Included Files:
 * - ../config.php: Configuration settings.
 * - inc/header.php: Header section of the layout.
 * - inc/topBarNav.php: Top navigation bar.
 * - inc/navigation.php: Sidebar navigation.
 * - inc/footer.php: Footer section of the layout.
 * 
 * Functionality:
 * - Checks for a 'page' query parameter to determine which content to load.
 * - Displays a success message if available in the session flash data.
 * - Includes the appropriate content file or displays a 404 error if the file or directory does not exist.
 * - Contains modal dialogs for confirmation, universal modal, right-side modal, and viewer modal.
 * 
 * HTML Structure:
 * - Wrapper div containing the main layout.
 * - Content wrapper div for the main content area.
 * - Section for the main content.
 * - Modal dialogs for various interactions.
 * 
 * Data Attributes:
 * - data-new-gr-c-s-check-loaded: Used for Grammarly extension.
 * - data-gr-ext-installed: Used for Grammarly extension.
 * 
 * Styles:
 * - Various classes and inline styles for layout and appearance.
 */
<?php require_once('../config.php'); ?>
 <!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>
  <body class="layout-fixed layout-footer-fixed text-sm sidebar-mini control-sidebar-slide-open layout-navbar-fixed " data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">
    <div class="wrapper">
     <?php require_once('inc/topBarNav.php') ?>
     <?php require_once('inc/navigation.php') ?>
              
     <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home';  ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="min-height: 567.854px;">
        <!-- Content Header (Page header) -->
       
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
          <?php if(isset($_settings) && $_settings->chk_flashdata('success')): ?>
          <script>
            alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
          </script>
          <?php endif;?>
          <div class="container-fluid">
            <?php 
              if(!file_exists($page.".php") && !is_dir($page)){
                  include '404.html';
              }else{
                if(is_dir($page))
                  include $page.'/index.php';
                else
                  include $page.'.php';

              }
            ?>
          </div>
        </section>
        <!-- /.content -->
        <div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-right"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
              <img src="" alt="">
      </div>
    </div>
  </div>
      </div>
      <!-- /.content-wrapper -->
      <?php require_once('inc/footer.php') ?>
  </body>
</html>
