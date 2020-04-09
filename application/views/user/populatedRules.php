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
	<div class="container-fluid categories-home">
		<div class="container">
			<?php if(isset($rulesData)){
				foreach ($rulesData as $rules) :
				 ?>

			<ol class="breadcrumb">
				<li class="breadcrumb-item"><?=anchor('userCases','Cases')?></li>
				<li class="breadcrumb-item"><a href="<?=base_url('populatedCase')?>">Saved Deadlines</a></li>
				<li class="breadcrumb-item active"><?= $rules->caseTitle?></li>
			</ol>

			<legend class="pull-left">Case: <?= $rules->caseTitle?></legend>
			<span class="pull-right"><?= anchor("user/MainController/deleteSavedCase/{$rules->ID}",'Delete',['class'=>'delete btn btn-danger btn-sm']);?></span>
			<small id="fileHelp" class="form-text">Trigger Date: <?= date('m/d/Y', strtotime($rules->motionDate)); ?></small>
			<div class="category-container"><!-- 
				<legend>Rules:</legend>
				<small id="rules" class="form-text text-muted">Click on the plus icon to see deadlines for the rule</small>
				<br> -->

				<div class="table">
					<table id="myTable" class="sortable-table">

						
						<tr class="sorter-header">
							<th class="no-sort">S.no</th>
							<th class="no-sort">Events</th>
							<th class="is-date">Deadline Date</th>
						</tr>
							<?php
	                    		if(!empty($rules->caseDeadlines)){
	                    				$i = 0;
	                    			foreach($rules->caseDeadlines as $deadline){
	                    				$i++;
	                    	?>
						<tr>
	                    	<td><?= $i; ?></td>
							<td><?= $deadline->deadlineTitle ?>
									<br>
									<small class="form-text text-muted" ><?=$deadline->deadlineDescription?></small>
							</td>
							<td>
								<?= date('m/d/Y', strtotime($deadline->deadlineDate)); ?>
							</td>
						</tr>
		                        <?php
		                        	}
		                    		}

		                    		else{
		                    			?>
							<td>No Deadline available for this rule</td>
							<td></td>

		                        <?php
		                    		}
		                        ?>
						</tr>
					</table>
				</div>
				<?php endforeach ?>
			</div>
			<?= form_close(); ?>
			<?php } else{echo "No data to show";} ?>
		</div>
	</div>
</body>
	<?php 
			globalJs(); 
	?>
</html>
