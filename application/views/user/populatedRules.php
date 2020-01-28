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
				$caseTitle = $rulesData['caseTitle'];
				$motionDate = $rulesData['motionDate'];
				unset($rulesData['caseTitle']);
				unset($rulesData['motionDate']);
				unset($rulesData['userId']);
				 ?>
			<legend>Case: <?= $caseTitle?></legend>
			<small id="fileHelp" class="form-text">Motion Date: <?= date('m/d/Y', strtotime($motionDate)); ?></small>
			<input type="hidden" name="motionDate" value="<?= $motionDate ?>">
			<div class="category-container">
				<legend>Rules:</legend>
				<small id="rules" class="form-text text-muted">Click on the plus icon to see deadlines for the rule</small>
				<br>
				<?php foreach ($rulesData as $rules) :?>

				<div class="category-list row">
					<div class="category col-sm-12"><label class="dateRevised" style="float: right;">Deadline Date</label>
						<?php foreach ($rules as $rule) :?>
							<span class="collapsable-list"><?=$rule[0]->title ?></span>
							<ul class="list-panel">
		                	<?php ?>
		                    <div>
		                    	<?php
		                    		if(!empty($rule['deadlines'])){

		                    			foreach($rule['deadlines'] as $deadline){
		                    	?>
		                        <li>
								      <label>
								      		<?= $deadline->title ?>
								  	  </label>
								  	  <label style="float: right; cursor: default;">
								  	  	<?php if($deadline->day_type == "calendarDay") echo date('m/d/Y', strtotime($motionDate.'+'.$deadline->deadline_days.'days'));?>
								  	  	<?php if($deadline->day_type == "courtDay") echo date('m/d/Y', strtotime($motionDate.'+'.$deadline->deadline_days.'weekdays'));?>
										</label>
		                        </li>
		                        <?php
		                        	}
		                    		}

		                    		else{
		                    			?>
		                        <li>
							      No Document is Listed for this Category
		                        </li>
		                        <?php
		                    		}
		                        ?>
		                    </div>
		                </ul>
		                <?php endforeach ?>
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
