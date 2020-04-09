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
			<div class="col-sm-6">
				<form method="post" action="searchCasesForDate">
					<div class="row">
						<div class="form-group col-sm-3" style=" line-height: 45px">
					      <label for="exampleInputEmail1">Search By Date</label>
						</div>
						<div class="form-group col-sm-5">
					      <input type="date" name="dateForCases" class="form-control">
					      <small id="editCategory" class="form-text text-muted">Search Case for the Date</small>
		      			</div>
						<div class="form-group col-sm-3">
					      <input type="submit" value="Search" class="form-control btn btn-primary">
		      			</div>
						</div>
				</form>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-2"></div>
				<form class="col-sm-5">
			      <input class="form-control mr-sm-2" type="text" placeholder="Search Case" id="myInput1" onkeyup="myFunction1()">
			    </form>
				<form class="col-sm-5">
			      <input class="form-control mr-sm-2" type="text" placeholder="Search Event" id="myInput" onkeyup="myFunction()">
			    </form>
				
				</div>
		    </div>
			</div>
		    </div>
		</div>
	<!--/ Search Bar -->

	<div class="container-fluid table categories-table borderless">
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
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><?=anchor('populatedCase','See All Events')?></li>
				<li class="breadcrumb-item active">Search Results</li>
			</ol>
			<?php if($deadlines){
				?>

			<table id="myTable" class="sortable-table">
				<tr class="sorter-header">
					<th class="no-sort">Case Name</th>
					<th>Events</th>
					<th class="is-date"><center>Date<center></th>
					<th class="no-sort"><center>Action<center></th>
				</tr>
					<?php
						foreach($deadlines as $deadline):?> <?php if ($deadline->sub) {
						foreach($deadline->sub as $case){ ?>
							<tr>
									<td>
										<a href="user/MainController/populatedRules/<?= $case->ID ?>"><?= $case->caseTitle?></a>
									</td>
									<td>
										<?= $deadline->deadlineTitle?>
									</td>
									<td>
										<?= date('m/d/Y', strtotime( $deadline->deadlineDate)); ?>
									</td>
									<td><center>
										<?= anchor("user/MainController/deleteSavedDeadline/{$deadline->ID}/{$deadline->deadlineGoogleID}",'Delete',['class'=>'btn btn-danger delete']);?>
									</center>
									</td>
							</tr>
									<?php	}	}?>
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
