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
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><?= anchor('userCases','Cases')?></li>
				<li class="breadcrumb-item active"><?= $rules['caseTitle']?></li>
			</ol>
		</div>
		<div class="container">
		<div class="row">
			<div class="col-sm-8">
				
		<div class="container"><h3><div class="category-label">Select Rules for Case</div></h3>
			<?php if(isset($rules[0])){
				$caseId = $rules['caseId'];
				unset($rules['caseId']);
				unset($rules['caseTitle']);
				 ?>
			<?= form_open('user/MainController/calculateDays'); ?>
			<div class="row">
			<div class="form-group col-sm-3" style="max-width: 20%; line-height: 45px">
		      <label for="exampleInputEmail1">Trigger Date*</label>
			</div>
			<div class="form-group col-sm-4">
		      <input type="hidden" name="caseId" value="<?=$caseId?>">
		      <?php echo form_input(['placeholder'=>'MM/YYYY','name'=>'motionDate','required'=>'required', 'type'=>'date','class'=>'form-control','id'=>'docRevisedDate','aria-describedby'=>'docRevisedDate']); ?>
		      <small id="editCategory" class="form-text text-muted"></small>
		      <?php echo form_error('motionDate');?><?php echo form_error('ruleIds[]');?>
			</div>
			</div>
			<table id="myTable" class="sortable-table">
				<tr class="sorter-header">
					<th class="no-sort">S.no</th>
					<th>Rules</th>
					<th class="no-sort"></th>
				</tr>
					<?php
						$i=0;
						foreach($rules as $rule): $i++?>
						<tr>
						<td><?= $i?></td>
						<td><?= $rule->title;?><br>
			     			 <small id="ruleDescription" class="form-text text-muted"><?= $rule->description;?></small>
						</td>
						<td><center><input type="radio" value="<?=$rule->ID ?>" name="ruleIds[]" required="required"></center></td>
						</tr>
					<?php endforeach  ?>

						<tfoot>
						<tr>
							<th></th>
							<th></th>
							<th><center><?= form_submit(['value'=>'Next','class'=>'btn btn-primary']) ?></center></th>
						</tr>
						</tfoot>
			</table>
						<?= form_close();?>
			<?php } else{echo "No Rules have been added by User";} ?>
		</div>
			</div><div class="col-sm-4">
				<?php
					if ($holidays) {
						?>
						<div><h3>Holidays</h3></div>
						<?php
						foreach ($holidays as $holiday) {
							?>
							<div class="row"><label class="col-sm-6" style="font-weight: 900"><?= $holiday->title?></label><label class="col-sm-6"><?= date("F d, Y", strtotime($holiday->date)) ?></label></div>
							<?php
						}
					}
					else{
						echo "No Holiday to show";
					}
				?>
			</div>
		</div>
	</div>
	</div>
</body>
	<?php 
			globalJs(); 
	?>
</html>
