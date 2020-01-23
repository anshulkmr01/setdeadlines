<!DOCTYPE html>
<html>
<head>
	<title>Law Calendar</title>
	<!-- Global Css using Helper -->
	<?php 
			globalCss(); 
	?>
	<!--/ Global Css using Helper -->
</head>
<body>
	<!-- Navbar -->
		<?php include 'navbar.php'?>
	<!--/ Navbar -->
	<!-- Search Bar -->
		<div class="container-fluid margin-top-25 row">
			<div class="col-sm-8"></div>
			<div class="col-sm-3">
			<form class=" my-2 my-lg-0">
		      <input class="form-control mr-sm-2" type="text" placeholder="Input Category Name for Search" id="myInput" onkeyup="myFunction()">
		    </form>
		    </div>
		</div>
	<!--/ Search Bar -->

	<div class="container-fluid table categories-table">
		<div class="container">
		</div>
	</div>

</body>
	<?php 
			globalJs(); 
	?>
</html>
