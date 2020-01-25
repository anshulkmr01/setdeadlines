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
		<div class="container-fluid margin-top-25">
			<div class="container">
				<div class="row">
			<div class="col-sm-8">
					<!--<a data-toggle="modal" class="open-updateFields btn btn-primary btn-sm" href="#addCase">Add Case</a> -->
			</div>
			<div class="col-sm-3">
			<form class=" my-2 my-lg-0">
		      <input class="form-control mr-sm-2" type="text" placeholder="Search Case" id="myInput" onkeyup="myFunction()">
		    </form>
			</div>
			</div>
		    </div>
		</div>
	<!--/ Search Bar -->

	<div class="container-fluid table categories-table">
		<div class="message container">
			<div class="row">
				<div class="col-sm-5">
					<?php if($success = $this->session->flashdata('success')):?>
				    	<div class="alert alert-success">
				    		<?= $success; ?>
				    	</div>
				    <?php endif;?>

				    <?php if($error = $this->session->flashdata('error')):?>
				    	<div class="alert alert-danger">
				    		<?= $error; ?>
				    	</div>
				    <?php endif;?>
				</div>
				<div class="col-sm-7"></div>
			</div>
		</div>
		<div class="container">
			<?php if(isset($cases)){ ?>
			<table id="myTable" class="sortable-table">
				<tr class="sorter-header">
					<th class="no-sort">S.no</th>
					<th>Cases</th>
					<th colspan="1" class="no-sort"><center><center></th>
				</tr>
					<?php
						$i=0;
						foreach($cases as $case): $i++?>
						<tr class="case">
						<td><?= $i?></td>
						<td>
							<span class=""><a href="user/MainController/populatedRules/<?= $case->caseID ?>"><?= $case->caseTitle?></a></span>
								<small id="motionDate" class="form-text text-muted">
									Motion Date: <?= date('m/d/Y', strtotime( $case->motionDate)); ?>
								</small>
						</td>
						</tr>
					<?php endforeach  ?>
						<?= form_close();?>
			</table>
			<?php } else{echo "No data to show";} ?>
		</div>
	</div>
</body>
	<?php 
			globalJs(); 
	?>
</script>
</html>
