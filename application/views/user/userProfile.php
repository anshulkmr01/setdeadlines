<!DOCTYPE html>
<html>
<head>
	<title>Law Calendar</title>
	<!-- Global Css using Helper -->
	<?php 
			globalCss(); 
	?>
	<!--/ Global Css using Helper -->
	<?php
	//session_start();

	require_once('google-calendar-api.php');
	require_once('settings.php');
	$capi = new GoogleCalendarApi();
	$isGooogleConnected = false;
	$error = "";
	// Google passes a parameter 'code' in the Redirect Url
	if(isset($_GET['code'])) {
		try {
			// Get the access token 
			$data = $capi->GetAccessToken(CLIENT_ID, CLIENT_REDIRECT_URL, CLIENT_SECRET, $_GET['code']);
			
			// Save the access token as a session variable
			$_SESSION['access_token'] = $data['access_token'];

			// Redirect to the page where user can create event
			header('Location: userProfile');
			exit();
		}
		catch(Exception $e) {
			echo $e->getMessage();
			exit();
		}
	}

	if(isset($_SESSION['access_token'])) {
	$isGooogleConnected = true;
	}

		//Login Url
		$login_url = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/calendar') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online';

	?>
</head>
<body>
	<!-- Navbar -->
		<?php include 'navbar.php'?>
	<!--/ Navbar -->
		<?php 
		if(isset($_SESSION['access_token'])){
		try{
		$user_info = $capi->GetUserProfileInfo($_SESSION['access_token']);
		}
		catch(Exception $e){
			$error = $e->getMessage();
		}}
	?>
	<!-- Search Bar -->
		<div class="container-fluid margin-top-25">
			<div class="container">
				<ol class="breadcrumb">
				  <li class="breadcrumb-item"><a href="home">Home</a></li>
				  <li class="breadcrumb-item active">Settings</li>
				 </ol>
				  <?php
				  if (isset($user_info['email'])) {
				  	?>
				  	<strong style="font-weight: 900"><?= $user_info['email']?></strong>
				  	<?php
				  }
				  else{
				  	echo $error;
				  }
				  ?>
		    </div>
		</div>
	<!--/ Search Bar -->

	<div class="container-fluid table categories-table">
		<div class="message container">
			<div class="row">
				<div class="col-5">
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
				    <?php if($warning = $this->session->flashdata('warning')):?>
				    	<div class="alert alert-warning">
				    		<?= $warning; ?>
				    	</div>
				    <?php endif;?>
				</div>
				<div class="col-7"></div>
			</div>
		</div>
		<div class="container">
			  <div class="tab-pane fade show" id="profile">
			    <div><label>Google Account</label> 
				</div>
				<?php if(!$isGooogleConnected){?>
					<div><a href="<?= $login_url ?>" class="btn btn-primary">Connect</a>
			   		 <small class="form-text text-muted">Connected Google Account will be used to save Motion Date into Google Calendar</small></div>
			   		 <?php } else {?>
			   		 	<div><a href="<?= base_url('user/MainController/googleDisconnect')?>" class="btn btn-primary">Disconnect</a>
			   		 <small class="form-text text-muted">Disconnect From Connected Google</small></div>
			   		 <?php }?>
			  <hr>
			  <div class="col-sm-6">
				<?= form_open('user/MainController/changePassword'); ?>
				  <fieldset>
				    <legend>Change Password</legend>
				    <div class="form-group">
				      <label for="password">Current Password*</label>
				      <?= form_input(['placeholder'=>'Current Password','name'=>'currentPassword','class'=>'form-control','id'=>'currentPassword','aria-describedby'=>'currentPassword']); ?>
					  <?= form_error('currentPassword');?>
				  	</div>

				    <div class="form-group">
				      <label for="password">New Password*</label>
				      <?= form_input(['placeholder'=>'New Password','name'=>'newPassword','class'=>'form-control','id'=>'newPassword','aria-describedby'=>'newPassword']); ?>
				      <small id="newPassword" class="form-text text-muted"></small>
					  <?php echo form_error('newPassword');?>
				  	</div>

				    <div class="form-group">
				  	</div>
				    <?= form_submit(['value'=>'Change','class'=>'btn btn-primary']); ?>
				  </fieldset>
				</div>
			</div>
		</div>
	</div>
</body>
	<?php 
			globalJs(); 
	?>
</script>
</html>
