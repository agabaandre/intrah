<?php
/**
 * @package Provider :  Datatables Add, View, Edit, Delete, Export and Custom Filter Using Codeigniter with Ajax
 *
 * @author Nobert
 *
 * @email  nobertmn@gmail.com
 *
 * Description of Provider Controller
 */
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Time_logs extends MX_Controller {

	public function __construct() {
		parent::__construct();
		//if not logged in, go to login page
		if (!$this->session->userdata('logged_in')) {
			redirect(base_url());
		}
		$this->load->model('login_model');
		$this->load->model('time_logs_model', 'tlm');
		$this->load->model('attendance_model');
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
        $data['title'] = 'View Time Logs ';

        $activities = $this->tlm->get_activities_list();
 
        $opt = array('' => 'All Campaigns');
        foreach ($activities as $activity_id => $activityname ) {
            $opt[$activity_id] = $activityname;
        }
 
        $data['form_activity'] = form_dropdown('',$opt,'','id="activity" class="form-control"');
        
		$this->load->view('time_logs/index', $data);
		//$this->load->view('home', $data);

	}

	public function getAllDetails() {

		$json = array();
		$list = $this->tlm->getData();
		$data = array();
		foreach ($list as $element) {
			$row = array();
			$row[] = $element['pid'];
            $row[] = $element['fullname'];
            $row[] = date("jS F Y", strtotime($element['date']));
			$row[] = $element['time_in'];
			$row[] = $element['time_out'];
			$row[] = $element['hours'];
			$row[] = $element['location'];
			$data[] = $row;
		}

		$json['data'] = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->tlm->countAll(),
			"recordsFiltered" => $this->tlm->countFiltered(),
			"data" => $data,
		);
		//output to json format
		//log_message('debug', print_r($json['data'], TRUE));
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($json['data']);
	}
}
?>