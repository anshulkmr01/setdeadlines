<?php
	class UserProfile extends CI_Controller
	{
		function __construct(){
			parent::__construct();
			if(!$this->session->userdata('userId'))
				return redirect('loginUser');

		}
		
		function index(){
			$this->load->model('UserModel');
			$holidays = $this->UserModel->getUserHolidays($this->session->userData('userId'));
			$this->load->view('user/userProfile',['holidays'=>$holidays]);
		}
	}
?>