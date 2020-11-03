<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Custom Style CSS -->
	<link rel="stylesheet" href="<?php echo base_url("assets/css/style.css");?>">  
	 
    <!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	  
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Game Show</title>
  </head>
  <body>

  
<!-- Start Header -->
<header>
  <nav class="navbar navbar-expand-md bg_dark_blue p-0">
	  <div class="container">
		  
    		<!-- Logo -->
			<div class="my-0 mr-md-auto font-weight-normal">
				<a class="navbar-brand p-0" href="#">
					<img src="<?php echo base_url("assets/images/logo.png");?>" alt="">  
				</a>
			</div>

    		<!-- Header Button -->
			<div class="my-2 my-md-0 mr-md-3">

<?php 
if(isset($_SESSION['logged_in'])  && $_SESSION['logged_in']  == true):
?>
<a  href="<?php echo base_url('signin/logout/')?>" class="btn btn_light_blue text-uppercase my-2 my-sm-0" type="submit">Log out</a>

<?php endif; ?>				
			</div>
	  </div>
  	</nav>
</header>
