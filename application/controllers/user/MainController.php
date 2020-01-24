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
			$this->load->view('user/homepage');
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
				$this->load->view('user/rules',['rules'=>$rules]);
		}

		function calculateDays(){
			$rulesData = $this->input->post();
			$caseId = $rulesData['caseId'];
			$motionDate = $rulesData['motionDate'];

			$this->form_validation->set_rules('motionDate','Motion Date','required',array('required'=>'%s is required'));
			if($this->form_validation->run()){

			$ruleIDs = $rulesData['ruleIds'];
			$userId = $this->session->userData('userId');

			$caseTitle = $this->UserModel->getSelectedCases($caseId);
			foreach ($ruleIDs as $ruleID) {
				$rulesFromDB[] = $this->UserModel->getSelectedRuleData($ruleID);
			}
				$rulesFromDB['caseTitle'] = $caseTitle;
				$rulesFromDB['motionDate'] = $motionDate;
				$this->load->view('user/reviewCase',['caseData'=>$rulesFromDB]);
			}
			else{
				$rules = $this->AdminModel->getRules();
				$rules['caseId'] = $caseId;
				$this->load->view('user/rules',['rules'=>$rules]);
			}
		}

	}
?>