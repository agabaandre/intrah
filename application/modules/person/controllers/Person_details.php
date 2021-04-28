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

class Person_details extends MX_Controller {

	public function __construct() {
		parent::__construct();
		//if not logged in, go to login page
		if (!$this->session->userdata('logged_in')) {
			redirect(base_url());
		}
		$this->load->model('login_model');
        //$this->load->model('activity_model', 'act');
        $this->load->model('person_details_model', 'person_details');
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
	// Employee list method
	public function index($id) {

		$data['users'] = $this->login_model->getusers();
		$data['username'] = $this->username;
		$data['mygroup'] = $this->mygroup;
		$data['page'] = 'emp-list';
        $data['title'] = 'View Person Campaign Details';
        $result = $this->person_details->getPerson($id);
        foreach ($result as $element) {
            $data['person'] = $element['person'];
            $data['gender'] = $element['gender'];
            $data['cadre'] = $element['cadre'];
            $data['contact'] = $element['mobile'];
            $data['district'] = $element['district'];
            $data['email'] = $element['email'];
        }
        $data['person_id'] = $id;
        //$this->load->view('activity_details/index', $data);
        $this->load->view('persons/person_details', $data);
	}

    public function getActivityDetails($id) {

        //log_message('debug', print_r("Activity ID= " . $id, TRUE));
		$json = array();
		$this->person_details->setPersonID($id);
		$list =  $this->person_details->getActivityData();
		$data = array();
		foreach ($list as $element) {
            $row = array();
            $row[] = $element['activity_id'];
			$row[] = $element['location'];
			$row[] = $element['region'];
			$row[] = $element['starts'];
			$row[] = $element['ends'];
			$data[] = $row;
		}

		$json['data'] = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->person_details->countAll(),
			"recordsFiltered" => $this->person_details->countFiltered(),
			"data" => $data,
		);
		//output to json format
		//log_message('debug', print_r($json['data'], TRUE));
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($json['data']);
    }
    
}
?>