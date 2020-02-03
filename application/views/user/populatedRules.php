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
				<li class="breadcrumb-item"><a href="<?=base_url('populatedCase')?>">Saved Cases</a></li>
				<li class="breadcrumb-item active"><?= $rules->caseTitle?></li>
			</ol>

			<legend>Case: <?= $rules->caseTitle?></legend>
			<small id="fileHelp" class="form-text">Motion Date: <?= date('m/d/Y', strtotime($rules->motionDate)); ?></small>
			<div class="category-container"><!-- 
				<legend>Rules:</legend>
				<small id="rules" class="form-text text-muted">Click on the plus icon to see deadlines for the rule</small>
				<br> -->

				<div class="category-list row">
					<div class="category col-sm-12"><label class="dateRevised" style="float: right;">Deadline Date</label>
						<span class="active-list" style="font-size: 18px; font-weight: 900"><?=$rules->ruleTitle ?></span>
						<br>
						<small class="form-text text-muted" ><?=$rules->ruleDescription ?></small>
							<ul class="list-panel" style="max-height:fit-content;">
		                	<?php ?>
		                    <div>
		                    	<?php
		                    		if(!empty($rules->caseDeadlines)){

		                    			foreach($rules->caseDeadlines as $deadline){
		                    	?>
		                        <li>
								      <label style="padding-bottom: 15px">
								      		<?= $deadline->deadlineTitle ?>
											<small class="form-text text-muted" ><?=$deadline->deadlineDescription ?></small>
								  	  </label>
								  	  <label style="float: right; cursor: default;">
								  	  	<?= $deadline->deadlineDate?>
										</label>
		                        </li>
		                        <?php
		                        	}
		                    		}

		                    		else{
		                    			?>
		                        <li>
							      No Deadline for this rule
		                        </li>
		                        <?php
		                    		}
		                        ?>
		                    </div>
		                </ul>
					</div>
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
