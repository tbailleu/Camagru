<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="camagru.css" />
	<title>home</title>
</head>
<body>
	<script type="text/javascript" src="galery.js"></script>
		<div class="row">
			<img src="chat_icon.png" class="col-lg-1 col-xs-4 col-sm-3 col-md-2"/>
			<h1 class="col-lg-5 col-xs-8 col-sm-7 col-md-6">Camagru</h1>
		</div>
	<div class="navbar navbar-default">
	  <ul class="nav navbar-nav nav-tabs nav-justified">
	  	<li><a href="home.html">Home</a></li>
	    <li class="active"><a href="#">Galery</a></li>
	    <li><a href="web.php">Webcam</a></li>
	  </ul>
	</div>
	<div class="container">
	  <ul class="pagination">
			<?php 
				include "pagination.php"; 
			?>
	  </ul>
	</div>
	<hr>
	<footer>
		<p id="foot">Copyright &copy 2018 All rigths Reserved</p>
	</footer>

</body>
</html>