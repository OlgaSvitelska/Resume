<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="">

    <title>OLGA SVITELSKA</title>

    
    <link href="<?=PATH_ROOT?>css/bootstrap.min.css" rel="stylesheet">
   	<link href="<?=PATH_ROOT?>css/bootstrap-theme.css" rel="stylesheet">
   	<link href="<?=PATH_ROOT?>css/bootstrap-notify.css" rel="stylesheet">
   	<link type="text/css" href="<?=PATH_ROOT?>less/styles.less" rel="stylesheet/less" >
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel='stylesheet' type='text/css'>
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">



    <script src="<?=PATH_ROOT?>js/jquery-1.7.1.min.js"></script>
    <script src="<?=PATH_ROOT?>js/bootstrap.min.js"></script>
    <script src="<?=PATH_ROOT?>js/less.js"></script>
	<script src="<?=PATH_ROOT?>js/jquery.address-1.5.min.js"></script>
    <script src="<?=PATH_ROOT?>js/jquery.form.js"></script>
    <script src="<?=PATH_ROOT?>js/script.js"></script>
	<script src="<?=PATH_ROOT?>js/modals.js"></script>
	<script src="<?=PATH_ROOT?>js/bootstrap-notify.js"></script>

	<script type="text/javascript" src="<?=PATH_ROOT?>js/jquery.stellar.min.js"></script>
	<script type="text/javascript" src="<?=PATH_ROOT?>js/waypoints.min.js"></script>
	<script type="text/javascript" src="<?=PATH_ROOT?>js/jquery.easing.1.3.js"></script>
		

	
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

  </head>

  <body>
 

		<div class="navbar navbar-default navbar-fixed-top top_header" role="navigation" >
		    <div class="container header_c">

		        <div class="navbar-header">
		          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		            <span class="sr-only">Toggle navigation</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		          </button>
		          <a class="ajax navbar-brand" href="<?=PATH?>?page=1">
		          	<div class="name">
						<img src="<?=PATH?>images/logo.jpg">
						OLGA SVITELSKA
					</div>
					<div class="status">
						Project Manager
					</div>
					</a>
		        </div>

		        <div class="navbar-collapse collapse" id="navbarmain">
		        	 <?php include 'application/views/header_menu.php'; ?>
		        </div>

		    </div>
		  

		</div>


		<section class="container section">
	      <?php include 'application/views/'.$content_view.'.php'; ?>
	    </section>
		

		<div id="footer">
	      <div class="container">
	        <div class="copywright"><center>2014 - © Olga Svitelska - All rights reserved</center></div>
	      </div>
	    </div>

	    <div class='notifications bottom-right'></div>
  </body>
</html>
