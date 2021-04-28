<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Activity extends MX_Controller {

	public function __construct() {
		parent::__construct();
		//if not logged in, go to login page
		if (!$this->session->userdata('logged_in')) {
			redirect(base_url());
		}
		$this->module="activity";

		$this->load->model('login_model');
		$this->load->model('activity_model', 'act');
		$this->load->model('attendance_model');
		$this->load->helper('url');
		$this->load->library('pagination');

		$this->username = $this->session->userdata['names'];
		$this->uid = $this->session->userdata['uid'];
		$user_details = $this->aauth->get_user_groups($this->uid);
		foreach ($user_details as $detail) {
			$this->mygroup = $detail->id;
		
		}
	}


//---------------------------------------------------------------------------
//HOME PAGE >>>>>> Employee list method

	public function index() {

		$data['users'] = $this->login_model->getusers();
		$data['username'] = $this->username;
		$data['mygroup'] = $this->mygroup;
		$data['page'] = 'emp-list';
		$data['title'] = 'View Campaigns';

		$list = $this->act->getActivityData();
		$row ="";

		 foreach ($list as $e) { 

		   $row .= "<tr><td>".$e['activity_id']."</td><td>".$e['location']."</td><td>".$e['region']."</td><td>".date('jS F Y', strtotime($e['starts']))."</td><td>".date('jS F Y', strtotime($e['ends']))."</td><td>".$e['notes']."</td><td><a class='btn btn-sm btn-primary'><i class='glyphicon glyphicon-folder-open'></i>View</a>&nbsp;&nbsp;<a class='btn btn-sm btn-primary' href='javascript:void(0)'><i class='glyphicon glyphicon-pencil'></i>Edit</a>&nbsp;&nbsp;<a class='btn btn-sm btn-danger' href='javavscript:void(0)'><i class='glyphicon glyphicon-trash'></i>Delete</td></tr>";
		} 

		$data['rows'] =$row; 

		$data['module']=$this->module;
		$this->load->view('test', $data);

	}
	public function regions()
	{
		$json = [];
		if($this->input->get("q")){
			log_message('debug', print_r($this->input->get("q"), TRUE));
			$this->db->like('region', $this->input->get("q"));

			$query = $this->db->select('id, region as text')
						->limit(10)
						->get("regions");
			$json = $query->result();
		}

		echo json_encode($json);
	}
	public function snus()
	{
		$json = [];
		if($this->input->get("q")){
			log_message('debug', print_r($this->input->get("q"), TRUE));
			$this->db->like('snu', $this->input->get("q"));

			$query = $this->db->select('id, snu as text')
						->limit(10)
						->get("snus");
			$json = $query->result();
		}

		echo json_encode($json);
	}

	public function getAllDetails() {

		$json = array();
		$list = $this->act->getActivityData();

		$row = '<thead><tr><th scope="col" style="width: 5%;">#</th><th scope="col">Location</th><th scope="col">Region</th><th scope="col">Start Date</th><th scope="col">End Date</th><th scope="col">Notes</th><th scope="col">Action</th></tr></thead>';

		foreach ($list as $e) { 

		   $row .= "<tr><td>".$e['activity_id']."</td><td>".$e['location']."</td><td>".$e['region']."</td><td>".date('jS F Y', strtotime($e['starts']))."</td><td>".date('jS F Y', strtotime($e['ends']))."</td><td>".$e['notes']."</td><td><a class='btn btn-sm btn-primary'><i class='glyphicon glyphicon-folder-open'></i>View</a>&nbsp;<a class='btn btn-sm btn-primary' href='javascript:void(0)'><i class='glyphicon glyphicon-pencil'></i>Edit</a>&nbsp;<a class='btn btn-sm btn-danger' href='javavscript:void(0)'><i class='glyphicon glyphicon-trash'></i>Delete</td></tr>";
		} 

		$data['row']=$row;

		$this->load->view('row-data', $data);

		//return $row;

	}


	public function save() {
		$json = array();
		$location = $this->input->post('location');
		$desc = $this->input->post('notes');
		$starts = $this->input->post('starts');
		$ends = $this->input->post('ends');

		$query = $this->db->select('region')
						->where('id', $this->input->post('region'))
						->get("regions");
		$result = $query->row();
		$region = $result->region;
		$region_id = $this->input->post('region');

		$query = $this->db->select('district_name')
						->where('id', $this->input->post('district'))
						->get("districts");
		$res = $query->row();
		$district = $res->district_name;
		$district_id = $this->input->post('district');


		if (!(trim($location))) {
			$json['error']['location'] = 'Please enter Location';
		}
		if (!(trim($starts))) {
			$json['error']['starts'] = 'Please enter Start Date';
		}
		if (!(trim($ends))) {
			$json['error']['ends'] = 'Please enter End Date';
		}
		if (!($region)) {
			$json['error']['region'] = 'Please Select a region';
		}
		if (!$json['error']) {
			$this->act->setLocation($location);
			$this->act->setRegion($region);
			$this->act->setNotes($desc);
			$this->act->setDistrict($district);
			$this->act->setDistrictID($district_id);
			$this->act->setEndDate($ends);
			$this->act->setStartDate($starts);
			$this->act->setRegionID($region_id);
			try {
				$last_id = $this->act->createActivity();
				echo $last_id;
			} catch (Exception $e) {
				var_dump($e->getMessage());
		
			}
		}
	}

	// Employee edit method

	public function edit($id) {
		$this->act->setActivityID($id);
		$data = $this->act->getActivity();
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($data);
	}

	// Employee update method
	public function update() {
		$json = array();
		$activity_id = $this->input->post('activity_id');
		$location = $this->input->post('location');
		$starts = $this->input->post('starts');
		$ends = $this->input->post('ends');
		$desc = $this->input->post('notes');
		$query = $this->db->select('region')
						->where('id', $this->input->post('region'))
						->get("regions");
		$result = $query->row();
		$region = $result->region;
		$region_id = $this->input->post('region');
		
		$query = $this->db->select('districts')
						->where('id', $this->input->post('district'))
						->get("districts");
		$res = $query->row();
		$district = $res->district_name;
		$district_id = $this->input->post('district');


		if (!(trim($location))) {
			$json['error']['location'] = 'Please enter Location';
		}
		if (!(trim($starts))) {
			$json['error']['starts'] = 'Please enter Start Date';
		}

		if (!(trim($ends))) {
			$json['error']['ends'] = 'Please enter End Date';
		}
		if (!($region)) {
			$json['error']['region'] = 'Please Select a region';
		}

		if (!($json['error'])) {
			$this->act->setLocation($location);
			$this->act->setRegion($region);
			$this->act->setNotes($desc);
			$this->act->setDistrict($district);
			$this->act->setDistrictID($district_id);
			$this->act->setEndDate($ends);
			$this->act->setStartDate($starts);
			$this->act->setRegionID($region_id);
			try {
				$last_id = $this->act->updateActivity();
			} catch (Exception $e) {
				var_dump($e->getMessage());
			}

		}
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($json);
	}
	// Employee display method
	public function delete($id) {
		$json = array();
		$this->act->setActivityID($id);
		$json['status'] = $this->act->deleteActivity();
		$json['id'] = $id ;
		//log_message('debug', print_r($json['data'], TRUE));
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($json);

	}


	public function sendMail(){
		$this->load->library('phpmailer');
		$mail = $this->phpmailer;
		
		try {
		    //Server settings
		    $mail->SMTPDebug = 2;
		    $mail->isSMTP();
		    $mail->Host = 'smtp.gmail.com';
		    $mail->SMTPAuth = true;
		    $mail->Username = 'solvertech256@gmail.com';
		    $mail->Password = 'Solv$567';
		    $mail->SMTPSecure = 'tls';
		    $mail->Port = 587;
		 
		    $mail->setFrom('solvertech256@gmail.com', 'Admin');
		    $mail->addAddress('dembedenisjb@gmail.com', 'Recipient1');
		    //Content
		    $mail->isHTML(true); 
		    $mail->Subject = 'Test Mail Subject!';
		    $mail->Body    = 'This is SMTP Email Test';
		 
		    $mail->send();
		    echo 'Message 3 has been sent';
		} catch (Exception $e) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
	}

}
?>



