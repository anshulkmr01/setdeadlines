<!DOCTYPE html>
<html>
<head>
	<title>Law Calendar</title>
	<?php 
			globalCss(); 
	?>
</head>
<body>
	<div class="container-fluid main-container">
	<div class="user-signup-form container">
		<div class="row">
			<div class="col-sm-6">
			</div>
			<div class="col-sm-6">
				<?= form_open('validateUser'); ?>
				  <fieldset>
				    <legend>User Login</legend>

				    <?php if($error = $this->session->flashdata('error')):?>
				    	<div class="alert alert-danger">
				    		<?= $error; ?>
				    	</div>
				    <?php endif;?>

				    <?php if($warning = $this->session->flashdata('warning')):?>
				    	<div class="alert alert-warning">
				    		<?= $warning; ?>
				    	</div>
				    <?php endif;?>

				    <?php if($message = $this->session->flashdata('success')):?>
				    	<div class="alert alert-success">
				    		<?= $message; ?>
				    	</div>
				    <?php endif;?>

				    <div class="form-group">
				      <label for="exampleInputEmail1">Email*</label>

				      <?php echo form_input(['placeholder'=>'Email','name'=>'userEmail','value'=>set_value('userEmail'),'class'=>'form-control','id'=>'exampleInputEmail1','aria-describedby'=>'userEmail']); ?>
				      <small id="emailHelp" class="form-text text-muted"></small>
					  <?php echo form_error('userEmail');?>
				  	</div>

				    <div class="form-group">
				      <label for="exampleInputPassword1">Password*</label>

				      <?php echo form_password(['placeholder'=>'Password','name'=>'userPassword','value'=>set_value('userPassword'),'class'=>'form-control','id'=>'exampleInputPassword1','aria-describedby'=>'userPassword']); ?>
					  <?php echo form_error('userPassword');?>

				    </div>

				    <?php echo form_submit(['value'=>'Login','class'=>'btn btn-primary']); ?>
				  </fieldset>
				  <br>
				  <div class="form-group">
				      <label for="exampleInputEmail1"><?= anchor('recoverPassword','Recover Password')?></label>
				  </div>
				  <div class="form-group">
				      <label for="exampleInputEmail1">New User? <?= anchor('signupUser','signup here')?></label>
				  </div>
			</div>
	</div>
	<div class="row">
		<div class="col-sm-12 company">
			<h6><small class="text-muted">Developed & Designed by </small><?= anchor('https://Kbrostechno.com','KBros Technologies')?></h6>
		</div>
	</div>
	</div>

</body>
	<?php 
			globalJs(); 
	?>
</html>