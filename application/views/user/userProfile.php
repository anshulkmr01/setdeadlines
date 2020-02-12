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
	$isGooogleConnected = false;
	// Google passes a parameter 'code' in the Redirect Url
	if(isset($_GET['code'])) {
		try {
			$capi = new GoogleCalendarApi();
			
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
		$login_url = 'https://accounts.google.com/o/oauth2/auth?scope='
		.urlencode('https://www.googleapis.com/auth/calendar')
		. '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL)
		. '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online';

	?>
</head>
<body>
	<!-- Navbar -->
		<?php include 'navbar.php'?>
	<!--/ Navbar -->
	<!-- Search Bar -->
		<div class="container-fluid margin-top-25">
			<div class="container">
				<ol class="breadcrumb">
				  <li class="breadcrumb-item"><a href="#">Home</a></li>
				  <li class="breadcrumb-item active">Profile</li>
				</ol>
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
			<ul class="nav nav-tabs" id="myTab">
			  <li class="nav-item">
			    <a class="nav-link active" data-toggle="tab" id="home-tab" href="#home">My Rules</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" data-toggle="tab" id="settings-tab" href="#profile">Settings</a>
			  </li>
			</ul>
			<div id="myTabContent" class="tab-content">
			  <div class="tab-pane fade active show" id="home">
			   	<!-- Search Bar -->
		<div class="container-fluid margin-top-25">
			<div class="container">
				<div class="row">
			<div class="col-8">
					<a data-toggle="modal" class="open-updateFields btn btn-primary btn" href="#addRule">Add Rule</a>
			</div>
			<div class="col-3">
			<form class=" my-2 my-lg-0">
		      <input class="form-control mr-2" type="text" placeholder="Search Rule" id="myInput" onkeyup="myFunction()">
		    </form>
			</div>
			</div>
		    </div>
		</div>
	<!--/ Search Bar -->

	<div class="container-fluid table categories-table">
		<div class="message container">
			<div class="row">
				<div class="col-7"></div>
			</div>
		</div>
		<div class="container">
			<?php if($rules){ ?>
			<table id="myTable" class="sortable-table">
				<?= form_open('deleteSelectedUserRules'); ?>
				<tr class="sorter-header">
					<th class="no-sort">S.no</th>
					<th>Rules</th>
					<th colspan="4" class="no-sort"><center>Action<center></th>
					<th class="no-sort"><center><label><input type="checkbox" name="sample" class="selectall" style="display:none;"/> <span style="cursor: pointer;">Select all</span></label></center></th>
				</tr>
					<?php
						$i=0;
						foreach($rules as $rule): $i++?>
						<tr>
						<td><?= $i?></td>
						<td><?= $rule->title;?><br>
			     			 <small id="newCategory" class="form-text text-muted"><?= $rule->description;?></small>
						</td>
						<td>
							<?= anchor("user/MainController/userDeadlines/{$rule->ID}",'Deadlines',['class'=>'btn btn-primary']); ?>
						</td>
						<td>
							<a data-toggle="modal" data-id="<?= $rule->ID; ?>" data-title="<?= $rule->title; ?>" data-desc="<?= $rule->description; ?>" href="#editRule" class="btn btn-primary editRule">Edit</a>
						</td>
						<td>
							<?= anchor("user/MainController/dublicateRule/{$rule->ID}",'Dublicate',['class'=>'btn btn-primary']); ?>
						</td>
						<td>
							<?= anchor("user/MainController/deleteUserRule/{$rule->ID}",'Delete',['class'=>'delete btn btn-danger']); ?>
						</td>
						<td><center><input type="checkbox" value="<?=$rule->ID ?>" name="ruleIds[]"></center></td>
						</tr>
					<?php endforeach  ?>
						<tfoot>
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th><?= form_submit(['value'=>'Dublicate','name'=>'dublicateRules','class'=>'btn btn-primary']) ?>
								<?= form_submit(['value'=>'Delete','name'=>'deleteRules','class'=>'delete btn btn-danger']) ?></th>
						</tr>
						</tfoot>
						<?= form_close();?>
			</table>
			<?php } else{echo "No data to show";} ?>
		</div>
	</div>
	<!-- Modal Popup -->
		<div class="modal fade" id="addRule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLongTitle">Law Calendar</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
			  <fieldset>
			    <legend>Add new Rule</legend>
			    <span class="text-muted">Add new Rule By filling this form</span>
				<?= form_open('addUserRule'); ?>
			    <div class="form-group margin-top-25">
			      <label for="ruleTitle">Title*</label>
			      <?php echo form_input(['placeholder'=>'eg. Dedline','name'=>'ruleTitle','required'=>'required','value'=>set_value('ruleTitle'),'class'=>'form-control','id'=>'ruleTitle','aria-describedby'=>'ruleTitle']); ?>
				  <?php echo form_error('ruleTitle');?>
			      <small id="newCategory" class="form-text text-muted">Rule Name</small>
			  	</div>

			    <div class="form-group margin-top-25">
			      <label for="ruleDescription">Description*</label>

			      <?php echo form_input(['placeholder'=>'Rule is about','name'=>'ruleDescription','required'=>'required','value'=>set_value('ruleDescription'),'class'=>'form-control','id'=>'ruleDescription','aria-describedby'=>'ruleDescription']); ?>
				  <?php echo form_error('ruleDescription');?>
			      <small id="newCategory" class="form-text text-muted">A Decription about the Rule</small>
			  	</div>
			    <?php echo form_submit(['value'=>'Add','class'=>'btn btn-primary']); ?>
			    <?= form_close(); ?>
			  </fieldset>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		  </div>
		</div>
		<!--/ Moal Popup -->

				<!-- Modal Popup -->
				<div class="modal fade" id="editRule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLongTitle">Law Calendar</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
					  <fieldset>
					    <legend>Upadate Rule</legend>
						<?= form_open('editUserRule'); ?>
						<input type="hidden" name="ruleId" id="ruleId">
					     <div class="form-group margin-top-25">
					      <label for="ruleUpdatedTitle">Title*</label>
					      <?= form_input(['placeholder'=>'eg. Dedline','name'=>'ruleUpdatedTitle','required'=>'required','value'=>set_value('ruleUpdatedTitle'),'class'=>'form-control','id'=>'ruleUpdatedTitle','aria-describedby'=>'ruleUpdatedTitle']); ?>
						  <?= form_error('ruleUpdatedTitle');?>
					      <small id="newCategory" class="form-text text-muted">Rule Name</small>
					  	</div>

					    <div class="form-group margin-top-25">
					      <label for="ruleDesc">Description*</label>

					      <?= form_input(['placeholder'=>'Rule is about','name'=>'ruleDesc','required'=>'required','value'=>set_value('ruleDesc'),'class'=>'form-control','id'=>'ruleDesc','aria-describedby'=>'ruleDesc']); ?>
						  <?= form_error('ruleDesc');?>
					      <small id="newCategory" class="form-text text-muted">A Decription about the Rule</small>
					  	</div>
					    <?php echo form_submit(['value'=>'Update','class'=>'btn btn-primary']); ?>
					    <?= form_close(); ?>
					  </fieldset>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				      </div>
				    </div>
				  </div>
				</div>
				<!--/ Moal Popup -->
			  </div>

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
	</div>
</body>
	<?php 
			globalJs(); 
	?>
<script type="text/javascript">
	
// Setting Value of Docnament in Modal for update//
	$(document).on("click", ".editRule", function () {
     var RuleId = $(this).data('id');
     var RuleTitle = $(this).data('title');
     var RuleDesc = $(this).data('desc');
     var DeadlineDays = $(this).data('days');
     var DeadlineDayType = $(this).data('item');
     $("#ruleId").val(RuleId);
     $("#ruleUpdatedTitle").val(RuleTitle);
     $("#ruleDesc").val(RuleDesc);
});

//--------------------------------------

/*
$(document).ready(function(){
var val = "<?= $settings ?>";
if (val) {
	$('#home-tab').removeClass( "active");
	$('#settings-tab').addClass( "active");
	$('#home').removeClass( "active show");
	$('#profile').addClass( "active show");
}
});
*/
</script>
</html>
