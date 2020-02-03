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

			$this->load->model('AdminModel');
			$this->load->model('UserModel');
			$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
		}

		function index()
		{
			//load rules by admin on User Homepage
			$rules = $this->AdminModel->getRulesData();
			$this->load->view('user/homepage',['rules'=>$rules]);
			//return redirect('userCases');
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

		function userProfile(){
			$userRules = $this->UserModel->getUserRules();
			$this->load->view('user/userProfile',['rules'=>$userRules]);
		}

		function editUserRule(){
			if($this->form_validation->run('rule-update')){
			$ruleUpdatedData = $this->input->post();

			if($this->UserModel->editUserRule($ruleUpdatedData)){
				$this->session->set_flashdata('success', 'Rule Updated Successfully');
		        return redirect('userProfile');
			}
			else{
				$this->session->set_flashdata('error', 'Error in Updating Rule');
		        return redirect('userProfile');
				}
			}
			else{
				$this->session->set_flashdata('error', 'Fill Required Fields');
		        return redirect('userProfile');
			}
		}

		function dublicateRule($ruleId){

			if($this->UserModel->dublicateUserRule($ruleId)){
				$this->session->set_flashdata('success', 'Rule cloned Successfully');
		        return redirect('userProfile');
			}
			else{
				$this->session->set_flashdata('error', 'Error');
		        return redirect('userProfile');
			}
		}

		function addUserRule(){

			if($this->form_validation->run('rule')){
				$ruleData = $this->input->post();
				if($this->UserModel->addUserRule($ruleData)){
					$this->session->set_flashdata('success',"Rule Added Successfully");
					return redirect('userProfile');
				}
				else{
					$this->session->set_flashdata('error',"Adding Rule Failed");
					return redirect('userProfile');
				}
			}
			else{
				$this->session->set_flashdata('error',"Fields Can't be empty");
				return redirect('userProfile');
			}

		}

		function deleteUserRule($ruleId){
			if($this->UserModel->deleteUserRule($ruleId)){
				$this->session->set_flashdata('success', 'Rule Deleted Successfully');
		        return redirect('userProfile');
			}
			else{
				$this->session->set_flashdata('error', 'Error in Deletion Case');
		        return redirect('userProfile');
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
				if($this->UserModel->saveCase($caseData)){
					$this->session->set_flashdata('success','Case Populated in profile');
					return redirect('userCases');
				}
				else{
					$this->session->set_flashdata('error','An Error occured');
					return redirect('userCases');
				}
		}

		function populatedCase(){
			$cases = $this->UserModel->userCases();
			$this->load->view('user/populatedCase',['cases'=>$cases]);
		}

		function populatedRules($caseID){
			$userData = $this->UserModel->userSavedRules($caseID);
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
			        return redirect('userProfile');
				}
			}
				$this->session->set_flashdata('success', 'Rules Deleted Successfully');
		        return redirect('userProfile');
			}

			if($this->input->post('dublicateRules')){

			foreach ($ruleIds as $ruleId) {
				if(!$this->UserModel->dublicateUserRule($ruleId)){
				$this->session->set_flashdata('error', 'Error in Cloning');
		        return redirect('userProfile');
				}
			}
			$this->session->set_flashdata('success', 'Rule cloned Successfully');
		   	return redirect('userProfile');
			}
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