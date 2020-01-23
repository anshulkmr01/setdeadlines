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


		function listedRules()
		{
			//Loading Rule Page
			$rules = $this->AdminModel->getRules();
				$this->load->view('user/rules',['rules'=>$rules]);
		}

	}
?>