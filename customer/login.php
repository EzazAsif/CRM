<?php
/**
 * This file is the login page for the CRM application.
 * 
 * 
 * It includes the following functionalities:
 * - Displays a login form for users to sign in.
 * - Provides a link for user registration.
 * - Uses Bootstrap for styling and layout.
 * - Uses jQuery for handling form submission and modal dialogs.
 * - Includes a modal dialog for user registration.
 * 
 * Included Files:
 * - ../config.php: Configuration file.
 * - inc/header.php: Header file.
 * 
 * JavaScript Functions:
 * - start_loader(): Starts the loading animation.
 * - end_loader(): Ends the loading animation.
 * - uni_modal(title, url, size): Displays a modal dialog with the specified title, URL, and size.
 * - _conf(msg, func, params): Displays a confirmation modal with the specified message, function, and parameters.
 * 
 * HTML Structure:
 * - A login box containing the login form.
 * - A modal dialog for user registration.
 * 
 * External Scripts:
 * - jQuery
 * - Bootstrap 4
 * - AdminLTE
 * 
 * Note: Some parts of the code are commented out and not currently in use.
 */
?>
<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>

<body class="hold-transition login-page">
  <script>
    start_loader()
  </script>
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="./" class="h1"><b>Login</b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form id="clogin-frm" action="" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="col-12">
            <?php

            require_once 'vendor/autoload.php';

            // init configuration
            $clientID = '256236500563-stdpk67frgaln84dkvi76lc06lo8plrc.apps.googleusercontent.com';
            $clientSecret = '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';
            $redirectUri = 'http://localhost/crm/customer/sess_auth /login.php';

            // create Client Request to access Google API
            $client = new Google_Client();
            $client->setClientId($clientID);
            $client->setClientSecret($clientSecret);
            $client->setRedirectUri($redirectUri);
            $client->addScope("email");
            $client->addScope("profile");

            // authenticate code from Google OAuth Flow
            if (isset($_GET['code'])) {
              $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
              $client->setAccessToken($token['access_token']);

              // get profile info
              $google_oauth = new Google_Service_Oauth2($client);
              $google_account_info = $google_oauth->userinfo->get();
              $email = $google_account_info->email;
              $name = $google_account_info->name;

              // now you can use this profile info to create account in your website and make user logged in.
              
            } else {
              echo "<a href='" . $client->createAuthUrl() . "'>Google Login</a>";
            }

            ?>
            <!DOCTYPE html>
            <html>

            <head>
              <title>Google Login Example</title>
            </head>

            <body>

              <a href="<?= $url ?>">Sign in with Google</a>

            </body>

            </html>
          </div>
          <div class="row">
            <div class="col-8">
              <a href="javascript:void(0)" id="create_user">Register</a>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <!-- /.social-auth-links -->

        <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> -->

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='submit'
            onclick="$('#uni_modal form').submit()">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <!-- jQuery -->
  <script src="<?php echo base_url ?>plugins/jquery/jquery.min.js" defer></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js" defer></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url ?>dist/js/adminlte.min.js" defer></script>
  <!-- <script src="<?php echo base_url ?>dist/js/script.js"></script> -->

  <script>
    $(document).ready(function () {
      end_loader();
      $('#create_user').click(function () {
        uni_modal("<span class='fa fa-plus text-primary'></span> Create New User", _base_url_ + 'customer/user/create_user.php', 'md-large');
      })
    })
    window.uni_modal = function ($title = '', $url = '', $size = "") {
      start_loader()
      $.ajax({
        url: $url,
        error: err => {
          console.log()
          alert("An error occured")
        },
        success: function (resp) {
          if (resp) {
            $('#uni_modal .modal-title').html($title)
            $('#uni_modal .modal-body').html(resp)
            if ($size != '') {
              $('#uni_modal .modal-dialog').addClass($size + '  modal-dialog-centered')
            } else {
              $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md modal-dialog-centered")
            }
            $('#uni_modal').modal({
              show: true,
              backdrop: 'static',
              keyboard: false,
              focus: true
            })
            end_loader()
          }
        }
      })
    }
    window._conf = function ($msg = '', $func = '', $params = []) {
      $('#confirm_modal #confirm').attr('onclick', $func + "(" + $params.join(',') + ")")
      $('#confirm_modal .modal-body').html($msg)
      $('#confirm_modal').modal('show')
    }
  </script>
</body>

</html>