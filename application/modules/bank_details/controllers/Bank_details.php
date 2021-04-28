<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Bank_details extends MX_Controller {

	public function __construct() {
		parent::__construct();
		//if not logged in, go to login page
		if (!$this->session->userdata('logged_in')) {
			redirect(base_url());
		}
		$this->load->model('login_model');
		$this->load->model('bank_model', 'bnk');
		//$this->load->model('attendance_model');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('pagination');

		$this->username = $this->session->userdata['names'];
		$this->uid = $this->session->userdata['uid'];
		$user_details = $this->aauth->get_user_groups($this->uid);
		foreach ($user_details as $detail) {

			$this->mygroup = $detail->id;
		
		}
	}
	// Employee list method
	public function index() {

		$data['users'] = $this->login_model->getusers();
		$data['username'] = $this->username;
		$data['mygroup'] = $this->mygroup;
		$data['page'] = 'emp-list';
		$data['title'] = 'View Bank Details';

		$activities = $this->bnk->get_activities_list();
 
        $opt = array('' => 'All Campaigns');
        foreach ($activities as $activity_id => $activityname ) {
            $opt[$activity_id] = $activityname;
        }
 
        $data['form_activity'] = form_dropdown('',$opt,'','id="activity" class="form-control"');
		$this->load->view('test', $data);

	}

	public function activity() {

		$data['users'] = $this->login_model->getusers();
		$data['username'] = $this->username;
		$data['mygroup'] = $this->mygroup;
		$data['page'] = 'emp-list';
		$data['title'] = 'View Bank Details';

		$activities = $this->bnk->get_activities_list();
 
        $opt = array('' => 'All Campaigns');
        foreach ($activities as $activity_id => $activityname ) {
            $opt[$activity_id] = $activityname;
        }
 
        $data['form_activity'] = form_dropdown('',$opt,'','id="activity" class="form-control"');
		$this->load->view('activity', $data);

	}


	public function getAllDetails() {

		$json = array();
		$list = $this->bnk->getEmpData();
		$data = array();
		foreach ($list as $element) {
			$row = array();
			$row[] = $element['pid'];
			$row[] = $element['fullname'];
			$row[] = $element['account_no'];
			$row[] = $element['bank_name'];
			$row[] = $element['bank_code'];
			$row[] = $element['branch_name'];
			$row[] = $element['branch_code'];
			if($this->aauth->is_group_allowed("managebank",$this->mygroup) ){ 
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_record(' . "'" . $element['bid'] . "','" . $element['pid'] . "'" . ')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_record(' . "'" . $element['bid'] . "'" . ')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			} else {
				$row[] = '';
			
			}
			$data[] = $row;
		}

		$json['data'] = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->bnk->countAll(),
			"recordsFiltered" => $this->bnk->countFiltered(),
			"data" => $data,
		);
		//output to json format
		//log_message('debug', print_r($json['data'], TRUE));
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($json['data']);
	}

	// Employee save method
	public function save() {
		$json = array();
		$pid = $this->input->post('pid');
		$bank_name = $this->input->post('bank_name');
		$branch_name = $this->input->post('branch_name');
		$bank_code = $this->input->post('bank_code');
		$branch_code = $this->input->post('branch_code');
		$account_no = $this->input->post('account_no');

		if (!(trim($bank_name))) {
			$json['error']['bank_name'] = 'Please enter bank name';
		}
		if (!(trim($branch_name))) {
			$json['error']['branch_name'] = 'Please enter branch name';
		}
		if (!(trim($bank_code))) {
			$json['error']['bank_code'] = 'Please enter bank code';
		}
		if (!(trim($branch_code))) {
			$json['error']['branch_code'] = 'Please enter branch code';
		}
		if (!(trim($account_no))) {
			$json['error']['account_no'] = 'Please enter Account No';
		}

		if (!($json['error'])) {
			$this->bnk->setAccountNumber($account_no);
			$this->bnk->setBankName($bank_name);
			$this->bnk->setBranchName($branch_name);
			$this->bnk->setBankCode($bank_code);
			$this->bnk->setBranchCode($branch_code);
			$this->bnk->setEmpID($pid);
			try {
				$last_id = $this->bnk->createEmpDetails();
			} catch (Exception $e) {
				var_dump($e->getMessage());
			}

			if ($last_id && $last_id > 0) {
				$empDetailsID = $last_id;
				$this->bnk->setEmpDetailsID($empDetailsID);
				$empDetailsInfo = $this->bnk->getEmpDetails();
				$json['id'] = $empDetailsInfo['bid'];
				$json['pid'] = $empDetailsInfo['pid'];
				$json['account_no'] = $empDetailsInfo['account_no'];
				$json['bank_name'] = $empDetailsInfo['bank_name'];
				$json['branch_name'] = $empDetailsInfo['branch_name'];
				$json['bank_code'] = $empDetailsInfo['bank_code'];
				$json['branch_code'] = $empDetailsInfo['branch_code'];
				$json['fullname'] = $empDetailsInfo['fullname'];
				$json['status'] = 'success';
			}
		}
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($json);
	}

	// Employee edit method

	public function edit($id, $pid) {
		$this->bnk->setEmpDetailsID($id);
		$this->bnk->setEmpID($pid);
		$data = $this->bnk->getEmpDetails();
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($data);
	}

	// Employee update method
	public function update() {
		$json = array();
		$pid = $this->input->post('pid');
		$bid = $this->input->post('id');
		$bank_name = $this->input->post('bank_name');
		$branch_name = $this->input->post('branch_name');
		$bank_code = $this->input->post('bank_code');
		$branch_code = $this->input->post('branch_code');
		$account_no = $this->input->post('account_no');

		if (!(trim($bank_name))) {
			$json['error']['bank_name'] = 'Please enter bank name';
		}
		if (!(trim($branch_name))) {
			$json['error']['branch_name'] = 'Please enter branch name';
		}
		if (!(trim($bank_code))) {
			$json['error']['bank_code'] = 'Please enter bank code';
		}
		if (!(trim($branch_code))) {
			$json['error']['branch_code'] = 'Please enter branch code';
		}
		if (!(trim($account_no))) {
			$json['error']['account_no'] = 'Please enter Account No';
		}

		if (!($json['error'])) {
			$this->bnk->setAccountNumber($account_no);
			$this->bnk->setBankName($bank_name);
			$this->bnk->setBranchName($branch_name);
			$this->bnk->setBankCode($bank_code);
			$this->bnk->setBranchCode($branch_code);
			$this->bnk->setEmpID($pid);
			$this->bnk->setEmpDetailsID($bid);
			try {
				$last_id = $this->bnk->updateEmpDetails();
			} catch (Exception $e) {
				var_dump($e->getMessage());
			}

			if ($bid && $bid > 0) {
				//$empDetailsID = $last_id;
				$this->bnk->setEmpDetailsID($bid);
				$empDetailsInfo = $this->bnk->getEmpDetails();
				$json['id'] = $empDetailsInfo['bid'];
				$json['pid'] = $empDetailsInfo['pid'];
				$json['account_no'] = $empDetailsInfo['account_no'];
				$json['bank_name'] = $empDetailsInfo['bank_name'];
				$json['branch_name'] = $empDetailsInfo['branch_name'];
				$json['bank_code'] = $empDetailsInfo['bank_code'];
				$json['branch_code'] = $empDetailsInfo['branch_code'];
				$json['fullname'] = $empDetailsInfo['fullname'];
				$json['status'] = 'success';
			}
		}
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($json);
	}

	// Employee display method
	public function display() {
		$json = array();
		$empID = $this->input->post('pid');
		$empDetailsID = $this->input->post('id');
		$this->bnk->setEmpID($empDetailsID);
		$json['empInfo'] = $this->bnk->getEmpDetails();

		$this->output->set_header('Content-Type: application/json');
		$this->load->view('bank_details/popup/renderDisplay', $json);
	}

	// Employee display method
	public function delete($id) {
		$json = array();
		$empDetailsID = $this->input->post('id');
		$this->bnk->setEmpDetailsID($id);
		$json['status'] = $this->bnk->deleteEmpDetails();
		log_message('debug', print_r($json, TRUE));
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($json);

	}

}
?>