<?php
  // require_once('sess_auth.php');/////session authentication and authorization
  
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- proper rendering of the webpage in different devices -->
  	<title><?php echo $_settings->info('title') != false ? $_settings->info('title').' | ' : '' ?><?php echo $_settings->info('name') ?></title>
    <link rel="icon" href="<?php echo validate_image($_settings->info('logo')) ?>" /> <!-- dynamically retrieves the website title -->

    <!-- Mobile Specific Metas
   ================================================== -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- CSS
    ================================================== -->
   <link rel="stylesheet" href="<?php echo base_url ?>profile_asset/css/default.css">
  <link rel="stylesheet" href="<?php echo base_url ?>profile_asset/css/layout.css">
   <link rel="stylesheet" href="<?php echo base_url ?>profile_asset/css/media-queries.css">
   <link rel="stylesheet" href="<?php echo base_url ?>profile_asset/css/magnific-popup.css">

   <!-- Script
   ================================================== -->
  <script src="<?php echo base_url ?>profile_asset/js/modernizr.js"></script>

   <!-- Favicons
  ================================================== -->

  </head>