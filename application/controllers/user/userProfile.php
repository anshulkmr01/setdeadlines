<?php
	class UserProfile extends CI_Controller
	{
		function __construct(){
			parent::__construct();
			if(!$this->session->userdata('userId'))
				return redirect('loginUser');
			$this->load->model('UserModel');

		}
		
		function index(){

			$this->saveRefreshToken();
			
			$holidays = $this->UserModel->getUserHolidays($this->session->userData('userId'));
			$this->load->view('user/userProfile',['holidays'=>$holidays]);
		}

		function saveRefreshToken(){
			$this->UserModel->saveRefreshToken($this->session->userData('refresh_token'));
		}
	}
?>