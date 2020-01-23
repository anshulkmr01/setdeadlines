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
				<?= form_open('deleteSelectedRules'); ?>
				<tr class="sorter-header">
					<th class="no-sort">S.no</th>
					<th>Rules</th>
					<th class="no-sort" style="text-align: center;">Deadline in Days</th>
				</tr>
					<?php
						$i=0;
						foreach($rules as $rule): $i++?>
						<tr>
						<td><?= $i?></td>
						<td><?= $rule->title;?><br>
			     			 <small id="newCategory" class="form-text text-muted"><?= $rule->description;?></small>
						</td>
						<td style="text-align: center"><?= $rule->deadline_days;?><br>
			     			<small id="newCategory" class="form-text text-muted">
			     			 	<?php 	if($rule->day_type == "weekDay"){
			     			 			if($rule->deadline_days == "1") echo "Week Day";
			     			 			else echo "Week Days";
			     			 			}
			     			 			if($rule->day_type == "calendarDay"){
			     			 			if($rule->deadline_days == "1") echo "Calendar Day";
			     			 			else echo "Calendar Days";
			     			 			}?>
		     			 	</small>
						</td>
						</tr>
					<?php endforeach  ?>
						<?= form_close();?>
			</table>
			<?php } else{echo "No data to show";} ?>
		</div>
	</div>
	<!-- Modal Popup -->
		<div class="modal fade" id="addRule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
			    <legend>Add new Rule</legend>
			    <span class="text-muted">Add new Rule By filling this form</span>
				<?= form_open('addRule'); ?>
			    <div class="form-group margin-top-25">
			      <label for="ruleTitle">Title*</label>
			      <?php echo form_input(['placeholder'=>'eg. Dedline','name'=>'ruleTitle','required'=>'required','value'=>set_value('ruleTitle'),'class'=>'form-control','id'=>'ruleTitle','aria-describedby'=>'ruleTitle']); ?>
				  <?php echo form_error('ruleTitle');?>
			      <small id="newCategory" class="form-text text-muted">Rule Name</small>
			  	</div>

			    <div class="form-group margin-top-25">
			      <label for="ruleDescription">Description*</label>

			      <?php echo form_input(['placeholder'=>'Rule is about','name'=>'ruleDescription','required'=>'required','value'=>set_value('ruleDescription'),'class'=>'form-control','id'=>'ruleDescription','aria-describedby'=>'ruleDescription']); ?>
				  <?php echo form_error('ruleDescription');?>
			      <small id="newCategory" class="form-text text-muted">A Decription about the Rule</small>
			  	</div>

			    <div class="form-group margin-top-25">
			      <label for="deadLineDays">Days for Deadline*</label>

			      <?php echo form_input(['placeholder'=>'Days in Number','name'=>'deadLineDays','type'=>'number','required'=>'required','value'=>set_value('deadLineDays'),'class'=>'form-control','id'=>'deadLineDays','aria-describedby'=>'deadLineDays']); ?>
				  <?php echo form_error('deadLineDays');?>
			      <small id="newCategory" class="form-text text-muted">Deadline days for Motion Date</small>
			  	</div>

			    <div class="form-group margin-top-25">
			      <label for="deadLineDays">Day Type*</label>
			      	 <div class="custom-control custom-radio">
				      <input type="radio" id="customRadio1" name="dayType" value="calendarDay" class="custom-control-input" checked="">
				      <label class="custom-control-label" for="customRadio1">Calendar Days</label>
				    </div>
				    <div class="custom-control custom-radio">
				      <input type="radio" id="customRadio2" name="dayType" value="weekDay" class="custom-control-input">
				      <label class="custom-control-label" for="customRadio2">Week Days</label>
				    </div>
			      <small id="newCategory" class="form-text text-muted">Select Calendar Days if you want to include Saturday & Sunday</small>
			  	</div>
			    <?php echo form_submit(['value'=>'Add','class'=>'btn btn-primary']); ?>
			    <?= form_close(); ?>
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
</html>
