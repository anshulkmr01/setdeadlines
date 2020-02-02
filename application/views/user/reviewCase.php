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
			<?php if($caseData){
				$caseTitle = $caseData['caseTitle'];
				$motionDate = $caseData['motionDate'];
				$caseId = $caseData['caseId'];
				unset($caseData['caseTitle']);
				unset($caseData['motionDate']);
				unset($caseData['caseId']);
				 ?>

			<ol class="breadcrumb">
				<li class="breadcrumb-item"><?= anchor('userCases','Cases')?></li>
				<li class="breadcrumb-item"><a href="#" onclick="goBack()"><?= $caseTitle?></a></li>
				<li class="breadcrumb-item active">Review Case</li>
				<script>
				function goBack() {
				  window.history.back();
				}
				</script>
			</ol>
			<?= form_open('saveCase') ?>
			<input type="hidden" name="caseTitle" value="<?= $caseTitle ?>">
			<input type="hidden" name="caseID" value="<?= $caseId ?>">
			<center><legend>Review Case</legend></center>
			<legend><?= $caseTitle?></legend>
			<div class="motion-date">Motion Date: <?= date('m/d/Y', strtotime( $motionDate)); ?></div>
			<input type="hidden" name="motionDate" value="<?= $motionDate ?>">
			<div class="category-container">
				<?php foreach ($caseData as $case) : ?>
				<div class="category-list row">
						<input type="hidden" name="ruleID" value="<?= $case[0]->ID ?>">
						<input type="hidden" name="ruleTitle" value="<?= $case[0]->title?>">
						<input type="hidden" name="ruleDescription" value="<?= $case[0]->description?>">
					<div class="category col-sm-12"><label class="dateRevised" style="float: right;">Deadline Date</label>

						<span class="rule active-list"><?=$case[0]->title ?></span>
		                <ul class="list-panel" style="max-height: fit-content">
		                	<?php ?>
		                    <div>
		                    	<?php
		                    		if(!empty($case[0]->sub)){

		                    			foreach($case[0]->sub as $deadline){
		                    	?>
		                        <li>
								      <label>
								      		<?= $deadline->title ?>
								  	  </label>
								  		<label style="float: right; cursor: default;">
								  	  	<?php if($deadline->day_type == "calendarDay") $date = date('m/d/Y', strtotime($motionDate.'+'.$deadline->deadline_days.'days'));?>
								  	  	<?php if($deadline->day_type == "courtDay") $date = date('m/d/Y', strtotime($motionDate.'+'.$deadline->deadline_days.'weekdays'));?>
								  	  	<?= $date ?>
								      <input type="hidden" value="<?= $deadline->title ?>/amg/<?= $deadline->description ?>/amg/ <?= $date ?>" name="deadlineData[]">
										</label>
		                        </li>
		                        <?php
		                        	}
		                    		}

		                    		else{
		                    			?>
		                        <li>
							      No Deadline is Listed for this Rule
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
			<?= form_submit(['class'=>'btn btn-primary margin-bottom-50','value'=>'Save Deadlines']);?>
			<?= form_close(); ?>
			<?php } else{echo "No data to show";} ?>
		</div>
	</div>
</body>
	<?php 
			globalJs(); 
	?>
</html>
