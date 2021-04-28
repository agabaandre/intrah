<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Templates extends MX_Controller {

	public function main_frame($data=FALSE)
	{
		$this->load->view('main-frame',$data);
	}

	
	public function main($data=FALSE)
	{
		$this->load->view('main',$data);
	}


	public function login($data=FALSE)
	{
		$this->load->view('login',$data);
	}

}
