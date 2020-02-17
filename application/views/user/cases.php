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
					<a data-toggle="modal" class="open-updateFields btn btn-primary btn-sm" href="#addCase">Add Case</a>
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
				<?= form_open('deleteSelectedCases'); ?>
				<tr class="sorter-header">
					<th class="no-sort">S.no</th>
					<th>Cases</th>
					<th colspan="2" class="no-sort"><center>Action<center></th>
					<th class="no-sort"><center><label><input type="checkbox" name="sample" class="selectall" style="display:none;"/> <span style="cursor: pointer;">Select</span></label></center></th>
				</tr>
					<?php
						$i=0;
						foreach($cases as $case): $i++?>
						<tr>
						<td><?= $i?></td>
						<td><?= $case->title; ?></td>
						<td>
							<a data-toggle="modal" data-id="<?= $case->ID; ?>" data-item="<?= $case->title; ?>"  href="#editCase" class="btn btn-primary editCase">Rename</a>
						</td>
						<td>
							<?= anchor("user/MainController/listedRules/{$case->ID}/?case={$case->title}","Add Deadline", ['class'=>'btn btn-primary'])?>
						</td>
						<!-- 
						<td>
							<#?=anchor("user/MainController/deleteCase/{$case->ID}",'Delete',['class'=>'delete btn btn-danger']); ?>
						</td> -->
						<td><center><input type="checkbox" value="<?=$case->ID ?>" name="caseIds[]"></center></td>
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
		<div class="modal fade" id="addCase" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
			    <legend>Add new Case</legend>
			    <span class="text-muted">Add new Case By filling this form</span>
				<?= form_open('addCase'); ?>
			    <div class="form-group margin-top-25">
			      <label for="caseTitle">Title*</label>

			      <?php echo form_input(['placeholder'=>'eg. Alex Divorce','name'=>'caseTitle','required'=>'required','value'=>set_value('caseTitle'),'class'=>'form-control','id'=>'caseTitle','aria-describedby'=>'caseTitle']); ?>
				  <?php echo form_error('caseTitle');?>
			      <small id="newCategory" class="form-text text-muted">Case Name</small>
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
		<div class="modal fade" id="editCase" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
			    <legend>Upadate Case</legend>
				<?= form_open('editCase'); ?>
			    <div class="form-group margin-top-25">
			      <label for="caseTitle">Title*</label>

			      <?php echo form_input(['placeholder'=>'eg. Alex Divorce','name'=>'caseTitle','required'=>'required','value'=>set_value('caseTitle'),'class'=>'form-control','id'=>'caseUpdateTitle','aria-describedby'=>'caseTitle']); ?>
			      <input type="hidden" name="caseId" id="caseUpdateId">
				  <?php echo form_error('caseTitle');?>
			      <small id="newCategory" class="form-text text-muted">Case Name</small>
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
</body>
	<?php 
			globalJs(); 
	?>
	<script type="text/javascript">
	
// Setting Value of Docnament in Modal for update//
	$(document).on("click", ".editCase", function () {
     var caseId = $(this).data('id');
     var caseTitle = $(this).data('item');
     $("#caseUpdateTitle").val(caseTitle);
     $("#caseUpdateId").val(caseId);
});

</script>
</html>
