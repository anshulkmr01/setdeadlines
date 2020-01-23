<!DOCTYPE html>
<html>
<head>
	<title>Title</title>
	<?php 
			globalCss(); 
	?>
</head>
<body>
	<div class="container-fluid main-container">
	<div class="user-signup-form container">
		<div class="row">
			<div class="col-sm-6">
				<?= form_open('validate'); ?>
				  <fieldset>
				    <legend>Admin Login</legend>

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

				      <?php echo form_input(['placeholder'=>'Email','name'=>'adminemail','value'=>set_value('adminemail'),'class'=>'form-control','id'=>'exampleInputEmail1','aria-describedby'=>'adminemail']); ?>
				      <small id="emailHelp" class="form-text text-muted"></small>
					  <?php echo form_error('adminemail');?>
				  	</div>

				    <div class="form-group">
				      <label for="exampleInputPassword1">Password*</label>

				      <?php echo form_password(['placeholder'=>'Password','name'=>'adminpassword','value'=>set_value('adminpassword'),'class'=>'form-control','id'=>'exampleInputPassword1','aria-describedby'=>'adminpassword']); ?>
					  <?php echo form_error('adminpassword');?>

				    </div>

				    <?php echo form_submit(['value'=>'Login','class'=>'btn btn-primary']); ?>
				  </fieldset>
				  <br>
				  <div class="form-group">
				      <label for="exampleInputEmail1"><?= anchor('recoverAdminPassword','Recover Password')?></label>
				  </div>
			</div>
			<div>
			<div class="col-sm-6">
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