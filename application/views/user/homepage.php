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
					<label style="font-size: 20px">Rules Available</label> 
			</div>
			<div class="col-sm-3">
			<form class=" my-2 my-lg-0">
		      <input class="form-control mr-sm-2" type="text" placeholder="Search Rule" id="myInput" onkeyup="myFunction()">
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
			<?php if($rules){ ?>
			<table id="myTable" class="sortable-table">
				<tr class="sorter-header">
					<th class="no-sort">S.no</th>
					<th>Rules</th>
					<th colspan="" class="no-sort"><center>Action<center></th>
					<th class="no-sort"><center><label><input type="checkbox" name="sample" class="selectall" style="display:none;"/> <span style="cursor: pointer;"><!-- Select all --></span></label></center></th>
				</tr>
					<?php
						$i=0;
						foreach($rules as $rule): $i++?>
						<tr>
						<td style="font-weight: 900"><?= $i?></td>
						<td><?= $rule->title;?><br>
			     			 <small id="newCategory" class="form-text text-muted"><?= $rule->description;?></small>
						</td>
						<td style="text-align: center;">
							<?= anchor("user/MainController/importRule/{$rule->ID}",'Import',['class'=>'btn btn-primary']); ?>
						</td>
						<td><center><!-- <input type="checkbox" value="<?=$rule->ID ?>" name="ruleIds[]"> --></center></td>
						</tr>
							<?php
								if(!empty($rule->sub)){
									foreach ($rule->sub as $deadline) {
										?>
									<tr>
										<td></td>
										<td style="padding:10px 10px 10px 70px;"><?= $deadline->title?><br>
											<small id="newCategory" class="form-text text-muted"><?= $deadline->description;?></small>
										</td>
										<td style="padding:10px 10px 10px 70px; text-align: center;"><?= $deadline->deadline_days?><br>
											<small id="newCategory" class="form-text text-muted"><?= $deadline->day_type;?></small>
										</td>
									</tr>

										<?php
									}
									?>
									<?php
								}
								?>
					<?php endforeach  ?>
			</table>
			<?php } else{echo "No data to show";} ?>
		</div>
	</div>

		<!-- Modal Popup -->
		<div class="modal fade" id="viewDeadlines" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLongTitle">Law Calendar</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
			  <fieldset>
			    <label id="ruleTitle" style="font-size: 20px"></label>
			    		<table class="table">
			    			<tbody>
			    			<tr><th>S.no</th>
			    				<th>Deadline</th>
			    				<th>Days</th>
			    			</tr>

						    <?php $deadlineData = $this->session->userdata('deadlineData');
						    	$i = 0;
						    	foreach ($deadlineData as $daedline) {
						    		$i++;
						    		?>
						    			<tr><td><?= $i;?></td>
						    				<td><?= $daedline->title?><br>
						    					<small id="newCategory" class="form-text text-muted"><?= $daedline->description?></small>
						    				</td>
						    				<td><?= $daedline->deadline_days?><br>
						    					<small id="newCategory" class="form-text text-muted"><?= $daedline->day_type?></small>
						    				</td>
						    			</tr>
						    		</tbody>
						    		<?php
						    	}
						     ?>

			    		</table>
			  </fieldset>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		  </div>
		</div>
		<!--/ Moal Popup -->
</body>
	<?php 
			globalJs(); 
	?>
	<script type="text/javascript">
	
// Setting Value of Docnament in Modal for update//
	$(document).on("click", ".viewDeadlines", function () {
     var ruleTitle = $(this).data('title');
     var deadlineObject = $(this).data('obj');
     $("#ruleId").val(deadlineObject);
     $("#ruleTitle").html(ruleTitle);
});
</script>
</html>
