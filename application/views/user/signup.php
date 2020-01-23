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
			<div class="col-sm-3">
			</div>
			<div class="col-sm-5">
				<?= form_open('registerUser'); ?>
				  <fieldset>
				    <legend>User Signup</legend>

				    <?php if($error = $this->session->flashdata('error')):?>
				    	<div class="alert alert-danger">
				    		<?= $error; ?>
				    	</div>
				    <?php endif;?>

				    <?php if($message = $this->session->flashdata('success')):?>
				    	<div class="alert alert-success">
				    		<?= $message; ?>
				    	</div>
				    <?php endif;?>

				    <div class="form-group">
				      <label for="exampleInputEmail1">Full Name*</label>

				      <?php echo form_input(['placeholder'=>'Full Name','name'=>'fullName','value'=>set_value('fullName'),'class'=>'form-control','id'=>'exampleInputEmail1','aria-describedby'=>'fullName']); ?>
				      <small id="emailHelp" class="form-text text-muted"></small>
					  <?php echo form_error('fullName');?>
				  	</div>

				    <div class="form-group">
				      <label for="exampleInputEmail1">Email*</label>

				      <?php echo form_input(['placeholder'=>'Email','name'=>'userEmail','value'=>set_value('userEmail'),'class'=>'form-control','id'=>'exampleInputEmail1','aria-describedby'=>'userEmail']); ?>
				      <small id="emailHelp" class="form-text text-muted"></small>
					  <?php echo form_error('userEmail');?>
				  	</div>

				    <div class="form-group">
				      <label for="exampleInputEmail1">Telephone No.*</label>

				      <?php echo form_input(['placeholder'=>'Telephone number','name'=>'telephone','value'=>set_value('telephone'),'class'=>'form-control','id'=>'exampleInputEmail1','aria-describedby'=>'telephone']); ?>
				      <small id="emailHelp" class="form-text text-muted"></small>
					  <?php echo form_error('telephone');?>
				  	</div>

				    <div class="form-group">
				      <label for="exampleInputPassword1">Password*</label>

				      <?php echo form_password(['placeholder'=>'Password','name'=>'password','value'=>set_value('Password'),'class'=>'form-control','id'=>'exampleInputPassword1','aria-describedby'=>'Password']); ?>
					  <?php echo form_error('Password');?>

				    </div>

				    <?php echo form_submit(['value'=>'Sign up','class'=>'btn btn-primary']); ?>
				  </fieldset>
				  <br>
				  <div class="form-group">
				      <label for="exampleInputEmail1">Already Registered? <?= anchor('loginUser','Login here')?></label>
				  </div>
			</div>
			<div class="col-sm-4">
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