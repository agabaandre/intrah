<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Authentication extends MX_Controller {

	public function __Construct() {
		parent::__Construct();
		$this->load->model("authentication_model");
		$this->module = "authentication";
		$this->uid = $this->session->userdata['uid'];

	}

	public function index() {

			$data['alert']=false;
			$data['module']=$this->module;
			$data['view']="sign-in";
			echo Modules::run('templates/login',$data);
	
	}

/*	public function index() {

		//if ($this->session->userdata('logged_in')) {
		//	redirect(base_url("attendance"));
		//} else {
			$data = array('alert' => false);
			//$this->load->view('sign-in', $data);

			$data['module']=$this->module;
			$data['sign-in']="home";

			echo Modules::run('templates/login',$data);
		//}
	} */

	private function ajax_checking() {
		if (!$this->input->is_ajax_request()) {
			redirect(base_url());
		}
	}

	public function login() {

		$postData = $this->input->post();
		$validate = $this->authentication_model->validate_login($postData);

		if ($validate) {
			$newdata = array(
				'email' => $validate[0]->email,
				'role' => $validate[0]->role,
				'user_id' => $validate[0]->user_id,
				'names' => $validate[0]->names,
				'uid' => $validate[0]->auth_id,
				'logged_in' => TRUE,
				'passo' => $validate[0]->password,
				'pass_changed' => $validate[0]->password_state,

			);

			$this->session->set_userdata($newdata);

			$this->aauth->login($newdata['email'], $newdata['passo'], true);

			if ($newdata['role'] == 'Finance-Officer') {

				redirect(base_url("daily/index"));

			} else if ($newdata['role'] == 'Field-Officer') {

				redirect(base_url("activity/index"));

			}else {

				//redirect(base_url("attendance"));

				redirect('authentication/system');
			} 

		} else {

			$data = array('alert' => true);

			$this->load->view('sign-in', $data);
		}

	}

	public function system() {

		$this->username = $this->session->userdata['names'];
		$data['username'] = $this->username;

		$data['module']=$this->module;
		echo Modules::run('templates/main_frame',$data);
	}

	function change_password() {
		$this->ajax_checking();

		$postData = $this->input->post();

		$postData['changed'] = 1;

		$update = $this->authentication_model->change_password($postData);

		if ($update['status'] == 'success') {

			$this->session->set_flashdata('success', 'Your password has been successfully changed!');

			$this->aauth->reset_password($this->uid, md5($postData['new'])); //reset aaauth pass

			echo "OK";

		} else {
			echo "Failed";
		}
	}

	public function logout() {

		$this->aauth->logout();
		$this->session->sess_destroy();
		redirect(base_url());
	}



}

/* End of file */
