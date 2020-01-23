<?php
	/**
	 * 
	 */
	class AdminController extends CI_Controller
	{
		function __construct(){
			parent::__construct();
			$this->load->model('AdminModel');

			$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');			
			if(!$this->session->userdata('adminId')){
				$this->session->set_flashdata('warning','Login to Continue');
				return redirect('adminLogin');
			}
		}
		
		function index()
		{
			//$this->load->view('admin/dashboard');
			return redirect('cases');
		}

		function cases()
		{
			$cases = $this->AdminModel->getCases();
			if($cases){
				$this->load->view('admin/cases',['cases'=>$cases]);
			}
			else{
				$this->load->view('admin/cases');
			}
			
		}

		function addCase(){

			if ($this->form_validation->run('addCase'))
			{
				$title = $this->input->post('caseTitle');
				if($this->AdminModel->addCase($title)){
					$this->session->set_flashdata('success', 'Cases Added Successfully');
			        return redirect('cases');
				}
			}
			else
			{
				$this->session->set_flashdata('error',"Fields Can't be empty");
			    return redirect('cases');
			}
		}

		function editCase(){
			$caseId = $this->input->post('caseId');
			$caseTitle = $this->input->post('caseTitle');

			if($this->AdminModel->editCase($caseId,$caseTitle)){
				$this->session->set_flashdata('success', 'Cases Updated Successfully');
		        return redirect('cases');
			}
			else{
				$this->session->set_flashdata('error', 'Error in Updating Case');
		        return redirect('cases');
			}
		}

		function deleteCase($caseId){
			if($this->AdminModel->deleteCase($caseId)){
				$this->session->set_flashdata('success', 'Cases Deleted Successfully');
		        return redirect('cases');
			}
			else{
				$this->session->set_flashdata('error', 'Error in Deletion Case');
		        return redirect('cases');
			}
		}

		function deleteSelectedCases(){
			$caseIds = $this->input->post('caseIds');

			foreach ($caseIds as $caseId) {
				if(!$this->AdminModel->deleteCase($caseId)){
					$this->session->set_flashdata('error', 'Error in Deletion Case');
			        return redirect('cases');
				}
			}
				$this->session->set_flashdata('success', 'Case Deleted Successfully');
		        return redirect('cases');
		}

		function rules()
		{
			//Loading Rule Page
			$rules = $this->AdminModel->getRules();
				$this->load->view('admin/rules',['rules'=>$rules]);
		}

		function deadline($ruleId)
		{
			//Loading Rule Page
			$this->session->set_userdata('ruleId',$ruleId);
			$rules = $this->AdminModel->getDeadlines($ruleId);
				$this->load->view('admin/deadline',['deadlines'=>$rules]);
		}

		function addRule(){

			if($this->form_validation->run('rule')){
				$ruleData = $this->input->post();
				if($this->AdminModel->addRule($ruleData)){
					$this->session->set_flashdata('success',"Rule Added Successfully");
					return redirect('rules');
				}
				else{
					$this->session->set_flashdata('error',"Adding Rule Failed");
					return redirect('rules');
				}
			}
			else{
				$this->session->set_flashdata('error',"Fields Can't be empty");
				return redirect('rules');
			}

		}

		function addDeadline(){

			if($ruleId = $this->session->userdata('ruleId'));
			if($this->form_validation->run('deadline')){
				$deadlineData = $this->input->post();
				if($this->AdminModel->addDeadline($deadlineData)){
					$this->session->set_flashdata('success',"Deadline Added Successfully");
					return redirect('admin/AdminController/deadline/'.$ruleId);
				}
				else{
					$this->session->set_flashdata('error',"Adding Deadline Failed");
					return redirect('admin/AdminController/deadline/'.$ruleId);
				}
			}
			else{
				$this->session->set_flashdata('error',"Fields Can't be empty");
				return redirect('admin/AdminController/deadline/'.$ruleId);
			}

		}

		function editRule(){
			if($this->form_validation->run('rule-update')){
			$ruleUpdatedData = $this->input->post();

			if($this->AdminModel->editRule($ruleUpdatedData)){
				$this->session->set_flashdata('success', 'Cases Updated Successfully');
		        return redirect('rules');
			}
			else{
				$this->session->set_flashdata('error', 'Error in Updating Case');
		        return redirect('rules');
				}
			}
			else{
				$this->session->set_flashdata('error', 'Fill Required Fields');
		        return redirect('rules');
			}
		}

		function editDeadline(){

			if($ruleId = $this->session->userdata('ruleId'));
			if($this->form_validation->run('edit-deadline')){
			$deadlineUpdatedData = $this->input->post();
			if($this->AdminModel->editDeadline($deadlineUpdatedData)){
				$this->session->set_flashdata('success', 'Deadline Updated Successfully');
					return redirect('admin/AdminController/deadline/'.$ruleId);
			}
			else{
				$this->session->set_flashdata('error', 'Error in Updating Deadline');
					return redirect('admin/AdminController/deadline/'.$ruleId);
				}
			}
				$this->session->set_flashdata('error', 'Fill Required Fields');
					return redirect('admin/AdminController/deadline/'.$ruleId);
		}


		function deleteRule($ruleId){
			if($this->AdminModel->deleteRule($ruleId)){
				$this->session->set_flashdata('success', 'Rule Deleted Successfully');
		        return redirect('rules');
			}
			else{
				$this->session->set_flashdata('error', 'Error in Deletion Case');
		        return redirect('rules');
			}
		}

		function deleteDeadline($deadlineId){
			if($ruleId = $this->session->userdata('ruleId'));
			if($this->AdminModel->deleteDeadline($deadlineId)){
				$this->session->set_flashdata('success', 'Deadline Deleted Successfully');
		        return redirect('admin/AdminController/deadline/'.$ruleId);
			}
			else{
				$this->session->set_flashdata('error', 'Error in Deletion Deadline');
		        return redirect('admin/AdminController/deadline/'.$ruleId);
			}
		}


		function deleteSelectedRules(){
			$ruleIds = $this->input->post('ruleIds');

			foreach ($ruleIds as $ruleId) {
				if(!$this->AdminModel->deleteRule($ruleId)){
					$this->session->set_flashdata('error', 'Error in Deletion Rule');
			        return redirect('rules');
				}
			}
				$this->session->set_flashdata('success', 'Rules Deleted Successfully');
		        return redirect('rules');
		}

		function deleteSelectedDeadlines(){
			if($ruleId = $this->session->userdata('ruleId'));
			$deadlineIds = $this->input->post('deadlineIds');

			foreach ($deadlineIds as $deadline) {
				if(!$this->AdminModel->deleteDeadline($deadline)){
					$this->session->set_flashdata('error', 'Error in Deletion Deadline');
		        return redirect('admin/AdminController/deadline/'.$ruleId);
				}
			}
				$this->session->set_flashdata('success', 'Deadline Deleted Successfully');
		        return redirect('admin/AdminController/deadline/'.$ruleId);
		}

		function users()
		{
			$this->load->view('admin/users');
		}

		function adminSettings()
		{
			$this->load->view('admin/adminSettings');
		}

		function adduser()
		{
			$userdata = $this->input->post();
			$this->form_validation->set_rules('userName','Name','trim|required',
											array('required' => '%s is Required'));
			$this->form_validation->set_rules('userEmail','Email','trim|required',
											array('required' => '%s is Required'));
			if($this->form_validation->run()){
				if($this->AdminModel->addUser($userdata)){
				$this->session->set_flashdata('success','User Added Successfully');
				return redirect('users');
			}
			else{
				return redirect('users');
			}
		}
		else{
			$this->session->set_flashdata('modal','adduser');
			$this->load->view('admin/users');
		}
		}
		function changeAdminCredentials(){
			if($this->form_validation->run('admin-credentials')){
				$adminId = $this->input->post('adminId');
				$adminName = $this->input->post('newAdminName');
				$adminPassword = $this->input->post('newAdminPassword');

				if($this->AdminModel->changeAdminCredentials($adminId,$adminName,$adminPassword)){
						$this->session->set_flashdata('success','Credentials Changed Succesfully, Login Again');
						$this->session->unset_userdata('adminId');
						return redirect ('adminLogin');
				}
			}
			else{
				$this->load->view('admin/adminSettings');
			}
		}
}
?>