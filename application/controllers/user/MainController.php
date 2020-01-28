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
			//load User Homepage
			//$this->load->view('user/homepage');
			return redirect('listedCases');
	    }


		public function calendar($year = NULL , $month = NULL)
			{
				$data['calender'] = $this->UserModel->getcalender($year , $month);
				$this->load->view('user/calview', $data);
			}

	    function listedCases(){
	    	//Load Listed Cases in User Home Page
			$cases = $this->AdminModel->getCases();
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
			$rules = $this->AdminModel->getRules();
			$rules['caseId'] = $caseId;
			$rules['caseTitle'] = $caseTitle = $this->input->get('case');
				$this->load->view('user/rules',['rules'=>$rules]);
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
				$rules = $this->AdminModel->getRules();
				$rules['caseId'] = $caseId;
				$this->load->view('user/rules',['rules'=>$rules]);
			}
		}

		function saveCase(){
				$caseData = $this->input->post();
				if($this->UserModel->saveCase($caseData)){
					$this->session->set_flashdata('success','Case Populated in profile');
					return redirect('listedCases');
				}
				else{
					$this->session->set_flashdata('error','An Error occured');
					return redirect('listedCases');
				}
		}

		function populatedCase(){
			$cases = $this->UserModel->userCases();
			$this->load->view('user/populatedCase',['cases'=>$cases]);
		}

		function populatedRules($caseID){
			$userData = $this->UserModel->userRules($caseID);
			$this->load->view('user/populatedRules',['rulesData'=>$userData]);
		}

	}
?>