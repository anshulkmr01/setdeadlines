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
			$userId = $this->session->userData('userId'); //Getting User Id form Session
			$holidays = $this->UserModel->getUserHolidays($userId); // Getting Holiday dates
			$this->load->view('user/userProfile',['holidays'=>$holidays]);
		}
	}
?>