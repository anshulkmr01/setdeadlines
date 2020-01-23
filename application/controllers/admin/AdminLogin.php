<?php
	class AdminLogin extends CI_Controller{

public function __construct(){

		parent::__construct();
				$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
				$this->load->model('AdminModel');
		}
		public function index()
		{
			
				if($this->session->userdata('adminId')){
				$this->session->set_flashdata('warning','Login to Continue');
				return redirect('admin');
			}
				$this->load->view('admin/login');
		}

		public function validate(){
			$this->form_validation->set_rules('adminemail','Email','trim|required',
											array('required' => '%s is Required'));
			$this->form_validation->set_rules('adminpassword','Password','trim|required',
											array('required' => '%s is Required'));
			if($this->form_validation->run())
			{
				$adminemail = $this->input->post('adminemail');
				$adminpassword = $this->input->post('adminpassword');
				$adminId = $this->AdminModel->isValidate($adminemail,$adminpassword);
				if($adminId){
					$this->session->set_userdata('adminId',$adminId);
					$this->session->set_userdata('adminemail',$adminemail);
					return redirect('admin');
				}
				else{
					$this->session->set_flashdata('error','Invalid Email or Password');
					return redirect('adminLogin');
				}
			}
			else
			{
				$this->load->view('admin/login');
			}
		}

		public function logout(){
			$this->session->unset_userdata('adminId');
			$this->session->set_flashdata('success',"Logout Successfully");
			return redirect ('adminLogin');
		}

		function recoverAdminPassword(){
			$this->load->view('admin/adminRecoverPassword');
		}

		function adminRecoverPasswordSendEmail(){
			$this->form_validation->set_rules('userEmail','Email','trim|required|valid_email',
												array('required'=>'%s is required'));
			if($this->form_validation->run()){
				$userEmail = $this->input->post('userEmail');
				if($this->AdminModel->sendRecoverEmail($userEmail)){

				$this->session->set_flashdata('success',"A reset link has sent to your registered email");
				return redirect('recoverAdminPassword');
				}
			}
			else{
				$this->load->view('admin/adminRecoverPassword');
			}
		}

		function resetPassword($userEmail,$recoveryKey){
			if($this->AdminModel->recoveryKey($userEmail,$recoveryKey)){
                return redirect('newAdminPassword');
			}
		}

		function newAdminPassword(){
			if(!$this->session->userdata('adminEmail') || !$this->session->userdata('recoveryKey')){
				$this->session->set_flashdata('warning',"Link Expired");
				return redirect('adminLogin');
			}
			//Load New Password Page
			$this->load->view('admin/newPassword');
		}

		//Setting new Password after recovering
		function setAdminNewPassword(){
			if(!$this->session->userdata('adminEmail') || !$this->session->userdata('recoveryKey')){
				$this->session->set_flashdata('warning',"Link Expired");
				return redirect('adminLogin');
			}
			$this->form_validation->set_rules('newPassword','Password','required|trim',
												['required'=>'%s is required']);
			if($this->form_validation->run()){
				$newPassword = $this->input->post('newPassword');
				if($this->AdminModel->setNewPassword($newPassword)){
					$this->session->set_flashdata('success','Your Password has changed successfully');
					return redirect('adminLogin');
				}
				else{
					$this->session->set_flashdata('error','Password could not updated');
					return redirect('adminLogin');
				}
			}
			else{
				$this->load->view('admin/newPassword');
			}
		}
}
?>