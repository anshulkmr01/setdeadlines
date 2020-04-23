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
			<div class="motion-date">Trigger Date: <?= date('m/d/Y', strtotime( $motionDate)); ?></div>
			<input type="hidden" name="motionDate" value="<?= $motionDate ?>">
			<div class="category-container">
				<?php foreach ($caseData as $case) : ?>
				<div class="category-list row">
						<input type="hidden" name="ruleID" value="<?= $case[0]->ID ?>">
						<input type="hidden" name="ruleTitle" value="<?= $case[0]->title?>">
						<input type="hidden" name="ruleDescription" value="<?= $case[0]->description?>">
					<div class="category col-sm-12"><label class="dateRevised" style="float: right;">Deadline Date</label>

						<legend class="rule active-list"><?=$case[0]->title ?></legend>
						<small>Click on Deadline to edit</small>
		                <ul class="list-panel" style="max-height: fit-content">
		                    <div>
		                    	<?php
		                    		if(!empty($case[0]->sub)){

		                    			foreach($case[0]->sub as $deadline){
		                    	?>
		                        <li>
								      <label>
								      	<!-- onkeypress="this.style.width = ((this.value.length + 1) * 8) + 'px';" -->
								      	<input  type="text" id="txt" name="deadlineTitle[]" required="required" style="border: 0px" value="<?= $deadline->title ?>" style="outline:none; border: 0px;">
								      	<style type="text/css">
								      		input:focus {
												background-color: yellow;
												}
								      	</style>
								      		<!-- <?= $deadline->title ?> -->
								  	  </label>
								  	  <?php $date = "" ?>
								  	  <?php $numberOfDays =  $deadline->deadline_days; ?>
								  		<label style="float: right; cursor: default;">
								  	  	<?php if($deadline->day_type == "calendarDay") $date = date('m/d/Y', strtotime($motionDate.'+'.$numberOfDays.'days'));?>

								  	  	<?php if($deadline->day_type == "courtDay"){
								  	  		$date = date('m/d/Y', strtotime($motionDate.'+'.$numberOfDays.'weekdays'));

								  	  		$newDate = checkHolidays($holidays,$motionDate,$date);
								  	  		$date = checkHolidays($holidays,$date,$newDate);
								  	  		if($newDate != $date){
								  	  			$date = checkHolidays($holidays,$newDate,$date);
								  	  		}
								  	  		}
								  	  	?>
								  	  	<?= $date ?>
								      <input type="hidden" value="<?= $deadline->description ?>/amg/ <?= $date ?>" name="deadlineData[]">
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
	<?php

  	function checkHolidays($holidays,$motionDate,$date){
  	$count = 0;
  	foreach ($holidays as $holiday) {
	if(strtotime($holiday->date) > strtotime($motionDate) && strtotime($holiday->date) <= strtotime($date)){
		$count++;
		if(date('D',strtotime($holiday->date)) == "Sun" || date('D',strtotime($holiday->date)) == "Sat"){
			$count--;
		}
		}

	if(strtotime($holiday->date) < strtotime($motionDate) && strtotime($holiday->date) >= strtotime($date)){
		$count--;
		if(date('D',strtotime($holiday->date)) == "Sun" || date('D',strtotime($holiday->date)) == "Sat"){
			$count--;
		}
		}

		}
		$newDate = date('m/d/Y', strtotime($date.'+'.$count.'weekdays'));
		return $newDate;
  	}
	?>
</body>
	<?php 
			globalJs(); 
	?>
	<script type="text/javascript">
		
			function resizable (el, factor) {
			  var int = Number(factor) || 7.7;
			  function resize() {el.style.width = ((el.value.length+1) * int) + 'px'}
			  var e = 'keyup,keypress,focus,blur,change'.split(',');
			  for (var i in e) el.addEventListener(e[i],resize,false);
			  resize();
			}
			resizable(document.getElementById('txt'),8);
	</script>
</html>
