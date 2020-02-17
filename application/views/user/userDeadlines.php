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
				<ol class="breadcrumb">
				  <li class="breadcrumb-item"><?= anchor('userCases','Cases')?></li>
				  <li class="breadcrumb-item"><?= anchor('userRules','Rules')?></li>
				  <li class="breadcrumb-item active">Deadlines</li>
				</ol>
		    </div>
		</div>
	<!--/ Search Bar -->

	<div class="container-fluid table categories-table">
		<div class="message container">
			<div class="row">
				<div class="col-5">
					
				</div>
				<div class="col-7"></div>
			</div>
		</div>
		<div class="container">
			<ul class="nav nav-tabs">
			  <li class="nav-item">
			    <a class="nav-link active" data-toggle="tab" href="#deadlines">Deadlines</a>
			  </li>
			</ul>
			<div id="myTabContent" class="tab-content">
			  <div class="tab-pane fade active show" id="deadlines">

	<!-- Search Bar -->
		<div class="container-fluid margin-top-25">
			<div class="container">
				<div class="row">
			<div class="col-sm-8">
					<a data-toggle="modal" class="open-updateFields btn btn-primary btn" href="#adddeadline">Add Deadline</a>
			</div>
			<div class="col-sm-3">
			<form class=" my-2 my-lg-0">
		      <input class="form-control mr-sm-2" type="text" placeholder="Search deadline" id="myInput" onkeyup="myFunction()">
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
				    <?php if($ruleId = $this->session->userdata('ruleId'));?>
				</div>
				<div class="col-sm-7"></div>
			</div>
		</div>
		<div class="container">
			<?php if($deadlines){ ?>
			<table id="myTable" class="sortable-table">
				<?= form_open('user/MainController/deleteSelectedUserDeadlines'); ?>
				<tr class="sorter-header">
					<th class="no-sort">S.no</th>
					<th>deadlines</th>
					<th class="no-sort" style="text-align: center;">Days</th>
					<th class="no-sort"><center>Action<center></th>
					<th class="no-sort"><center><label><input type="checkbox" name="sample" class="selectall" style="display:none;"/> <span style="cursor: pointer;">Select all</span></label></center></th>
				</tr>
					<?php
						$i=0;
						foreach($deadlines as $deadline): $i++?>
						<tr>
						<td><?= $i?></td>
						<td><?= $deadline->title;?><br>
			     			 <small id="newCategory" class="form-text text-muted"><?= $deadline->description;?></small>
						</td>
						<td style="text-align: center"><?= $deadline->deadline_days;?><br>
			     			 <small id="newCategory" class="form-text text-muted"><?= $deadline->day_type;?></small>
						</td>
						<td>
							<a data-toggle="modal" data-id="<?= $deadline->ID; ?>" data-title="<?= $deadline->title; ?>" data-desc="<?= $deadline->description; ?>"  data-days="<?= $deadline->deadline_days; ?>" data-item="<?= $deadline->day_type; ?>" href="#editdeadline" class="btn btn-primary editdeadline">Edit</a>
						</td>
						<!-- <td>
							<#?= anchor("user/MainController/deleteUserDeadline/{$deadline->ID}",'Delete',['class'=>'delete btn btn-danger']); ?>
						</td>  -->
						<td><center><input type="checkbox" value="<?=$deadline->ID ?>" name="deadlineIds[]"></center></td>
						</tr>
					<?php endforeach  ?>

						<tfoot>
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th><?= form_submit(['value'=>'Delete Selected','name'=>'submit','class'=>'delete btn btn-danger']) ?></th>
						</tr>
						</tfoot>
						<?= form_close();?>
			</table>
			<?php } else{echo "No data to show";} ?>
		</div>
	</div>
	<!-- Modal Popup -->
		<div class="modal fade" id="adddeadline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
			    <legend>Add Deadline</legend>
			    <span class="text-muted">Add new Deadline By filling this form</span>
				<?= form_open('addUserDeadline'); ?>
			    <div class="form-group margin-top-25">
			      <label for="deadlineTitle">Title*</label>
			      <?php echo form_input(['placeholder'=>'eg. Dedline','name'=>'deadlineTitle','required'=>'required','value'=>set_value('deadlineTitle'),'class'=>'form-control','id'=>'deadlineTitle','aria-describedby'=>'deadlineTitle']); ?>
				  <?php echo form_error('deadlineTitle');?>
			      <small id="newCategory" class="form-text text-muted">deadline Name</small>
			  	</div>

			    <div class="form-group margin-top-25">
			      <label for="deadlineDescription">Description</label>
			      <input type="hidden" name="ruleId" value="<?php echo($ruleId)?>">
			      <?php echo form_input(['placeholder'=>'(optional)','name'=>'deadlineDescription','value'=>set_value('deadlineDescription'),'class'=>'form-control','id'=>'deadlineDescription','aria-describedby'=>'deadlineDescription']); ?>
				  <?php echo form_error('deadlineDescription');?>
			      <small id="newCategory" class="form-text text-muted">A Decription about the Deadline</small>
			  	</div>
			  	<div class="row">
			    <div class="form-group margin-top-25 col-sm-3">
			      <label for="deadLineDays">Days for Deadline*</label>

			      <?php echo form_input(['placeholder'=>'Days in Number','name'=>'deadLineDays','type'=>'number','required'=>'required','value'=>set_value('deadLineDays'),'class'=>'form-control','id'=>'deadLineDays','aria-describedby'=>'deadLineDays']); ?>
				  <?php echo form_error('deadLineDays');?>
			      <small id="newCategory" class="form-text text-muted">Deadline days for Trigger Date</small>
			  	</div>

			    <div class="form-group margin-top-25 col-sm-4">
			      <label for="deadLineDays">Day Type*</label>
			       <div class="form-group">
					    <select class="custom-select" name="dayType" id="deadlineDayType">
					      <option value="calendarDay">Calendar Days</option>
					      <option value="courtDay">Court Days</option>
					    </select>
					 </div>
			      <small id="newCategory" class="form-text text-muted">Select Calendar Days if you want to include Saturday & Sunday</small>
			  	</div>
			  	<div class="col-sm-5"></div>
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

		<!-- Modal Popup -->
		<div class="modal fade" id="editdeadline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
			    <legend>Upadate deadline</legend>
				<?= form_open('editUserDeadline'); ?>
				<input type="hidden" name="deadlineId" id="deadlineId">
			     <div class="form-group margin-top-25">
			      <label for="deadlineUpdatedTitle">Title*</label>
			      <?= form_input(['placeholder'=>'eg. Dedline','name'=>'deadlineUpdatedTitle','required'=>'required','value'=>set_value('deadlineUpdatedTitle'),'class'=>'form-control','id'=>'deadlineUpdatedTitle','aria-describedby'=>'deadlineUpdatedTitle']); ?>
				  <?= form_error('deadlineUpdatedTitle');?>
			      <small id="newCategory" class="form-text text-muted">deadline Name</small>
			  	</div>

			    <div class="form-group margin-top-25">
			      <label for="deadlineDesc">Description</label>

			      <?= form_input(['placeholder'=>'(optional)','name'=>'deadlineDesc','value'=>set_value('deadlineDesc'),'class'=>'form-control','id'=>'deadlineDesc','aria-describedby'=>'deadlineDesc']); ?>
				  <?= form_error('deadlineDesc');?>
			      <small id="newCategory" class="form-text text-muted">A Decription about the deadline</small>
			  	</div>

			    <div class="form-group margin-top-25">
			      <label for="deadlineUpdatedDays">Days for Deadline*</label>

			      <?php echo form_input(['placeholder'=>'Days in Number','name'=>'deadlineUpdatedDays','type'=>'number','required'=>'required','value'=>set_value('deadlineUpdatedDays'),'class'=>'form-control','id'=>'deadlineUpdatedDays','aria-describedby'=>'deadlineUpdatedDays']); ?>
				  <?php echo form_error('deadlineUpdatedDays');?>
			      <small id="newCategory" class="form-text text-muted">Deadline days for Trigger Date</small>
			  	</div>

			    <div class="form-group margin-top-25">
			      <label for="dayUpdatedType">Day Type*</label>
			      	 <div class="form-group">
					    <select class="custom-select" name="dayUpdatedType" id="deadlineDayType">
					      <option value="calendarDay">Calendar Days</option>
					      <option value="courtDay">Court Days</option>
					    </select>
					 </div>
			      <small id="newCategory" class="form-text text-muted">Select Calendar Days if you want to include Saturday & Sunday</small>
			  	</div>
			    <?php echo form_submit(['value'=>'Update','class'=>'btn btn-primary']); ?>
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
			  </div>
			</div>
		</div>
	</div>
</body>
	<?php 
			globalJs(); 
	?>
		<script type="text/javascript">
	
		// Setting Value of Docnament in Modal for update//
			$(document).on("click", ".editdeadline", function () {
		     var deadlineId = $(this).data('id');
		     var deadlineTitle = $(this).data('title');
		     var deadlineDesc = $(this).data('desc');
		     var DeadlineDays = $(this).data('days');
		     var DeadlineDayType = $(this).data('item');
		     $("#deadlineId").val(deadlineId);
		     $("#deadlineUpdatedTitle").val(deadlineTitle);
		     $("#deadlineDesc").val(deadlineDesc);
		     $("#deadlineUpdatedDays").val(DeadlineDays);
		     $("#deadlineDayType").val(DeadlineDayType);
		});
		</script>
</html>
