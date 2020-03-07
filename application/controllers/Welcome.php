<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

		function __construct(){
			parent::__construct();
			if($this->session->userdata('userId'))
				return redirect('userCases');
		}

	public function index()
	{
		$this->load->view('user/login');
	}
}
