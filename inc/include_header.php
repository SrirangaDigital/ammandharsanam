<?php include("cnf.php");?>
<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="<?php echo $base_url; ?>php/img/aplogo.ico">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Kannada:wght@100..900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

	<link rel="stylesheet" href="<?php echo $base_url; ?>php/css/font.css"> <!-- Font style -->
	<link rel="stylesheet" href="<?php echo $base_url; ?>php/css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="<?php echo $base_url; ?>php/css/style.css?v=1.5"> <!-- Resource style -->
	<link rel="stylesheet" href="<?php echo $base_url; ?>php/css/jquery-ui.css" /> <!-- jQuery UI style -->
	<link rel="shortcut icon" type="image/ico" href="<?php echo $base_url; ?>php/img/logo.gif" />

	<link href="<?php echo $base_url; ?>php/css/font-awesome-4.1.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css" /> <!-- Icon gallery (fontAwesome) style -->

	<script type="text/javascript" src="<?php echo $base_url; ?>php/js/jquery-2.1.1.js"></script> 
	<script type="text/javascript" src="<?php echo $base_url; ?>php/js/jquery-ui.js"></script>
	<script type="text/javascript" src="<?php echo $base_url; ?>php/js/main.js?v=1.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>  	
	<title>அம்மன் தரிசனம்</title>
</head>
<body>

<header>

	<nav class="navbar navbar-expand-lg fixed-top">
	  <div class="container-fluid">
		<a class="navbar-brand" href="<?php echo $base_url; ?>index.php">
		      <img src="<?php echo $base_url; ?>php/img/logo.gif" class="img-fluid" alt="Sringeri Sharada peetham logo" />
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		  <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
			<li class="nav-item">
			  <a class="nav-link active" aria-current="page" href="<?php echo $base_url; ?>index.php">முகப்பு</a>
			</li>
			<!-- <li class="nav-item">
			  <a class="nav-link" href="#">ಒಳನೋಟ</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="#">ಸಂಪಾದಕರು</a>
			</li> -->
			<li class="nav-item dropdown">
          		<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            		மலர்கள்
          		</a>
		          <ul class="dropdown-menu bg-body-tertiary text-align: right">
		            <li><a class="dropdown-item " href="<?php echo $base_url; ?>php/volumes.php">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;மலர்கள் | Volumes</a></li>
		            <li><a class="dropdown-item " href="<?php echo $base_url; ?>php/articles.php">&nbsp;&nbsp;கட்டுரைகள் | Articles</a></li>
		            <li><a class="dropdown-item " href="<?php echo $base_url; ?>php/authors.php">ஆசிரியர்கள் | Authors</a></li>
		            <li><a class="dropdown-item " href="<?php echo $base_url; ?>php/features.php"> &nbsp;&nbsp;&nbsp;&nbsp;அம்சங்கள் | Features</a></li>
		          </ul>
        	</li>
			<li class="nav-item">
			  <a class="nav-link" href="<?php echo $base_url; ?>php/search.php">தேடல்</a>
			</li>
			<li class="nav-item">
			  <a><i id="theme-toggler" class="fa fa-sun-o" aria-hidden="true"></i></a>
			</li>
		  </ul>
		</div>
	  </div>
	</nav>


</header>
