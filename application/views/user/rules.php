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
		<div class="container"><h3><div class="category-label">Secelt Rules for Case</div></h3>
			<?php if($rules){
				$caseId = $rules['caseId'];
				unset($rules['caseId']);
				 ?>
			<?= form_open('user/MainController/calculateDays'); ?>
			<div class="row">
			<div class="form-group col-sm-3">
		      <label for="exampleInputEmail1">Motion Date*</label>
		      <input type="hidden" name="caseId" value="<?=$caseId?>">
		      <?php echo form_input(['placeholder'=>'MM/YYYY','name'=>'motionDate','type'=>'date','class'=>'form-control','id'=>'docRevisedDate','aria-describedby'=>'docRevisedDate']); ?>
		      <small id="editCategory" class="form-text text-muted">Select a Motion Date for the Case</small>
		      <?php echo form_error('motionDate');?><?php echo form_error('ruleIds[]');?>
			</div>
			</div>
			<table id="myTable" class="sortable-table">
				<tr class="sorter-header">
					<th class="no-sort">S.no</th>
					<th>Rules</th>
					<th class="no-sort"><center><label><input type="checkbox" class="selectall" style="display:none;"/> <span style="cursor: pointer;">Select all</span></label></center></th>
				</tr>
					<?php
						$i=0;
						foreach($rules as $rule): $i++?>
						<tr>
						<td><?= $i?></td>
						<td><?= $rule->title;?><br>
			     			 <small id="ruleDescription" class="form-text text-muted"><?= $rule->description;?></small>
						</td>
						<td><center><input type="checkbox" value="<?=$rule->ID ?>" name="ruleIds[]"></center></td>
						</tr>
					<?php endforeach  ?>

						<tfoot>
						<tr>
							<td></td>
							<td></td>
							<td><center><?= form_submit(['value'=>'Go','class'=>'btn btn-primary']) ?></center></td>
						</tr>
						</tfoot>
			</table>
						<?= form_close();?>
			<?php } else{echo "No data to show";} ?>
		</div>
	</div>
</body>
	<?php 
			globalJs(); 
	?>
</html>
