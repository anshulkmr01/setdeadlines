<?php
	/**
	 * 
	 */
	class MainController extends CI_Controller
	{
		function __construct(){
			parent::__construct();
			if(!$this->session->userdata('userId'))
				return redirect('loginUser');

			if(!isset($_SESSION['access_token'])) {
					$this->session->set_flashdata('warning','Connect Google Account to Continue');
					 return redirect('user/UserProfile');
			}

			$this->load->model('AdminModel');
			$this->load->model('UserModel');
			$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
		}

		function index()
		{
			//load rules by admin on User Homepage
			$rules = $this->AdminModel->getRulesData();
			$userRules = $this->UserModel->getUserRules();

			$this->load->view('user/homepage',['rules'=>$rules,'userrules'=>$userRules]);
			//return redirect('userCases');
	    }

	    function userRules(){
			$userRules = $this->UserModel->getUserRules();
			$this->load->view('user/userRules',['rules'=>$userRules]);
	    }

		public function calendar($year = NULL , $month = NULL)
			{
				$data['calender'] = $this->UserModel->getcalender($year , $month);
				$this->load->view('user/calview', $data);
			}

	    function userCases(){
	    	//Load Listed Cases in User Home Page
			$cases = $this->UserModel->getUserCases();
			if($cases){
				$this->load->view('user/cases',['cases'=>$cases]);
			}
			else{
	    	$this->load->view('user/cases');
			}
	    }


		function listedRules($caseId)
		{
			//Loading Rule Page
			$rules = $this->UserModel->getUserRules();
			$rules['caseId'] = $caseId;
			$rules['caseTitle'] = $caseTitle = $this->input->get('case');
				$this->load->view('user/rules',['rules'=>$rules]);
		}
		function editUserRule(){
			if($this->form_validation->run('rule-update')){
			$ruleUpdatedData = $this->input->post();

			if($this->UserModel->editUserRule($ruleUpdatedData)){
				$this->session->set_flashdata('success', 'Rule Updated Successfully');
		        return redirect('userRules');
			}
			else{
				$this->session->set_flashdata('error', 'Error in Updating Rule');
		        return redirect('userRules');
				}
			}
			else{
				$this->session->set_flashdata('error', 'Fill Required Fields');
		        return redirect('userRules');
			}
		}

		function dublicateRule($ruleId){

			if($this->UserModel->dublicateUserRule($ruleId)){
				$this->session->set_flashdata('success', 'Rule cloned Successfully');
		        return redirect('userRules');
			}
			else{
				$this->session->set_flashdata('error', 'Error');
		        return redirect('userRules');
			}
		}

		function addUserRule(){

			if($this->form_validation->run('rule')){
				$ruleData = $this->input->post();
				if($this->UserModel->addUserRule($ruleData)){
					$this->session->set_flashdata('success',"Rule Added Successfully");
					return redirect('userRules');
				}
				else{
					$this->session->set_flashdata('error',"Adding Rule Failed");
					return redirect('userRules');
				}
			}
			else{
				$this->session->set_flashdata('error',"Fields Can't be empty");
				return redirect('userRules');
			}

		}

		function deleteUserRule($ruleId){
			if($this->UserModel->deleteUserRule($ruleId)){
				$this->session->set_flashdata('success', 'Rule Deleted Successfully');
		        return redirect('userRules');
			}
			else{
				$this->session->set_flashdata('error', 'Error in Deletion Case');
		        return redirect('userRules');
			}
		}



		function editUserDeadline(){

			if($ruleId = $this->session->userdata('ruleId'));
			if($this->form_validation->run('edit-deadline')){
			$deadlineUpdatedData = $this->input->post();
			if($this->UserModel->editUserDeadline($deadlineUpdatedData)){
				$this->session->set_flashdata('success', 'Deadline Updated Successfully');
					return redirect('user/MainController/userDeadlines/'.$ruleId);
			}
			else{
				$this->session->set_flashdata('error', 'Error in Updating Deadline');
					return redirect('user/MainController/userDeadlines/'.$ruleId);
				}
			}
				$this->session->set_flashdata('error', 'Fill Required Fields');
					return redirect('user/MainController/userDeadlines/'.$ruleId);
		}

		function addUserDeadline(){

			if($ruleId = $this->session->userdata('ruleId'));
			if($this->form_validation->run('deadline')){
				$deadlineData = $this->input->post();
				if($this->UserModel->addUserDeadline($deadlineData)){
					$this->session->set_flashdata('success',"Deadline Added Successfully");
					return redirect('user/MainController/userDeadlines/'.$ruleId);
				}
				else{
					$this->session->set_flashdata('error',"Adding Deadline Failed");
					return redirect('user/MainController/userDeadlines/'.$ruleId);
				}
			}
			else{
				$this->session->set_flashdata('error',"Fields Can't be empty");
				return redirect('user/MainController/userDeadlines/'.$ruleId);
			}

		}

		function deleteUserDeadline($deadlineId){
			if($ruleId = $this->session->userdata('ruleId'));
			if($this->UserModel->deleteUserDeadline($deadlineId)){
				$this->session->set_flashdata('success', 'Deadline Deleted Successfully');
		        return redirect('user/MainController/userDeadlines/'.$ruleId);
			}
			else{
				$this->session->set_flashdata('error', 'Error in Deletion Deadline');
		        return redirect('user/MainController/userDeadlines/'.$ruleId);
			}
		}

		
		function deleteSelectedUserDeadlines(){
			if($ruleId = $this->session->userdata('ruleId'));
			$deadlineIds = $this->input->post('deadlineIds');

			foreach ($deadlineIds as $deadline) {
				if(!$this->UserModel->deleteUserDeadline($deadline)){
					$this->session->set_flashdata('error', 'Error in Deletion Deadline');
		        return redirect('user/MainController/userDeadlines/'.$ruleId);
				}
			}
				$this->session->set_flashdata('success', 'Deadline Deleted Successfully');
		        return redirect('user/MainController/userDeadlines/'.$ruleId);
		}

	    function changePassword(){
	    	$this->form_validation->set_rules('currentPassword','Current Password','required',array('required'=>'%s is required'));
	    	$this->form_validation->set_rules('newPassword','New Password','required',array('required'=>'%s is required'));
	    	if($this->form_validation->run()){
	    		$changePasswordData = $this->input->post();
	    		
	    		if($this->UserModel->changePassword($changePasswordData)){
	    			$this->session->set_flashdata('success', 'Password Successfully Changed. Login Again');
	    			$this->session->unset_userdata('userId');
	    			return redirect('loginUser');
	    		}
	    		else {
	    			$this->session->set_flashdata('error','current password is incorrect');
	    			$userRules = $this->UserModel->getUserRules();
					$this->load->view('user/userProfile',['rules'=>$userRules,'settings'=>'on']);
	    		}
	    	}
	    	else{
	    		$userRules = $this->UserModel->getUserRules();
				$this->load->view('user/userProfile',['rules'=>$userRules,'settings'=>'on']);
	    	}
	    }


		function calculateDays(){
			$rulesData = $this->input->post();
			$caseId = $rulesData['caseId'];
			$motionDate = $rulesData['motionDate'];

			$this->form_validation->set_rules('motionDate','Motion Date','required',array('required'=>'%s is required'));
			$this->form_validation->set_rules('ruleIds[]','Rule','required',array('required'=>'Select a %s'));
			if($this->form_validation->run()){

			$ruleIDs = $rulesData['ruleIds'];
			$userId = $this->session->userData('userId');

			$caseTitle = $this->UserModel->getSelectedCases($caseId);
			foreach ($ruleIDs as $ruleID) {
				$rulesFromDB[] = $this->UserModel->getSelectedRuleData($ruleID);
			}
				$rulesFromDB['caseTitle'] = $caseTitle;
				$rulesFromDB['motionDate'] = $motionDate;
				$rulesFromDB['caseId'] = $caseId;
				if($rulesData['holiday']){
					$rulesFromDB['holiday'] = $rulesData['holiday']; // number of holidays	
				}
				$this->load->view('user/reviewCase',['caseData'=>$rulesFromDB]);
			}
			else{
				$rules = $this->UserModel->getUserRules();
				$rules['caseId'] = $caseId;
				$this->load->view('user/rules',['rules'=>$rules]);
			}
		}

		function importRule($ruleId){
			if($this->UserModel->importRule($ruleId)){
				$this->session->set_flashdata('success','Rule Added')	;
			}
			return redirect('home');
		}

		function saveCase(){
			$caseData = $this->input->post();
			$i = 0;
			foreach ($caseData['deadlineData'] as $deadlines) {
					 $deadlines = explode ("/amg/", $deadlines);
						$caseData['deadlineData'][$i] .= '/amg/'.$this->saveEventInGoogle($deadlines[0],date('Y-m-d', strtotime($deadlines[2])));
					$i++;
					}
					if($this->UserModel->saveCase($caseData)){
						$this->session->set_flashdata('success','Case Populated in profile');
						return redirect('userCases');
					}
					else{
						$this->session->set_flashdata('warning','Data have set in calendar but not in database');
						return redirect('userCases');
					}
		}

		function saveEventInGoogle($eventTitle,$eventDate){
			try {

				require_once('google-calendar-api.php');
				// Get event details
				$capi = new GoogleCalendarApi();

				// Get user calendar timezone
				$user_timezone = $capi->GetUserCalendarTimezone($_SESSION['access_token']);

				// Create event on primary calendar
				$event_id = $capi->CreateCalendarEvent('primary', $eventTitle, 1,$eventDate, $user_timezone, $_SESSION['access_token']);
				return $event_id;
				
				echo json_encode([ 'event_id' => $event_id ]);
				exit();
			}
			catch(Exception $e) {
				header('Bad Request', true, 400);
			    echo json_encode(array( 'error' => 1, 'message' => $e->getMessage() ));
			}
		}

		function deleteSavedCase($caseID){
			if($deadlineGoogleID = $this->UserModel->deleteSavedCase($caseID)){
				$capi = new GoogleCalendarApi();
				$access_token = $_SESSION['access_token'];
				// deleting event on the primary calendar
				$calendar_id = 'primary';
				foreach ($deadlineGoogleID as $event_id) {
					// Event on primary calendar
					$capi->DeleteCalendarEvent($event_id, $calendar_id, $access_token);
				}
				$this->session->set_flashdata("success","Case Deleted Successfully");
				return redirect('populatedCase');
			}
		}
		function populatedCase(){
			$cases = $this->UserModel->userCases();
			$this->load->view('user/populatedCase',['cases'=>$cases]);
		}

		function populatedRules($caseNo,$caseID){
			$userData = $this->UserModel->userSavedRules($caseNo,$caseID);
			$this->load->view('user/populatedRules',['rulesData'=>$userData]);
		}


		////////////////////////////////////////////////////////////////////
		// Adding Case by User


		function addCase(){

			if ($this->form_validation->run('addCase'))
			{
				$title = $this->input->post('caseTitle');
				if($this->UserModel->addCase($title)){
					$this->session->set_flashdata('success', 'Cases Added Successfully');
			        return redirect('userCases');
				}
			}
			else
			{
				$this->session->set_flashdata('error',"Fields Can't be empty");
			    return redirect('userCases');
			}
		}

		function editCase(){
			$caseId = $this->input->post('caseId');
			$caseTitle = $this->input->post('caseTitle');

			if($this->UserModel->editCase($caseId,$caseTitle)){
				$this->session->set_flashdata('success', 'Cases Updated Successfully');
		        return redirect('userCases');
			}
			else{
				$this->session->set_flashdata('error', 'Error in Updating Case');
		        return redirect('userCases');
			}
		}

		function deleteCase($caseId){
			if($this->UserModel->deleteCase($caseId)){
				$this->session->set_flashdata('success', 'Cases Deleted Successfully');
		        return redirect('userCases');
			}
			else{
				$this->session->set_flashdata('error', 'Error in Deletion Case');
		        return redirect('userCases');
			}
		}

		function deleteSelectedCases(){
			$caseIds = $this->input->post('caseIds');

			foreach ($caseIds as $caseId) {
				if(!$this->UserModel->deleteCase($caseId)){
					$this->session->set_flashdata('error', 'Error in Deletion Case');
			        return redirect('userCases');
				}
			}
				$this->session->set_flashdata('success', 'Case Deleted Successfully');
		        return redirect('userCases');
		}


		function deleteSelectedUserRules(){
			$ruleIds = $this->input->post('ruleIds');
			if($this->input->post('deleteRules')){

			foreach ($ruleIds as $ruleId) {
				if(!$this->UserModel->deleteUserRule($ruleId)){
					$this->session->set_flashdata('error', 'Error in Deletion Rule');
			        return redirect('userRules');
				}
			}
				$this->session->set_flashdata('success', 'Rules Deleted Successfully');
		        return redirect('userRules');
			}

			if($this->input->post('dublicateRules')){

			foreach ($ruleIds as $ruleId) {
				if(!$this->UserModel->dublicateUserRule($ruleId)){
				$this->session->set_flashdata('error', 'Error in Cloning');
		        return redirect('userRules');
				}
			}
			$this->session->set_flashdata('success', 'Rule cloned Successfully');
		   	return redirect('userRules');
			}
		}

		

		function googleDisconnect(){
			session_start();
			unset($_SESSION['access_token']);
			return redirect('user/UserProfile');
		}

		//Adding Cases by user
		//////////////////////////////////////////////////

		//////////////////////////////////////////////////
		// Adding Deadline by User

		function userDeadlines($ruleId)
		{
			//Loading Rule Page
			$this->session->set_userdata('ruleId',$ruleId);
			$rules = $this->UserModel->getDeadlines($ruleId);
				$this->load->view('user/userDeadlines',['deadlines'=>$rules]);
		}


	}
?>