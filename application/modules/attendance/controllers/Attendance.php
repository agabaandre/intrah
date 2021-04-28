<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends MX_Controller {

	public function __construct() {

		parent::__construct();

		//if not logged in, go to login page
		if (!$this->session->userdata('logged_in')) {
			redirect(base_url());
		}
		$this->module = "attendance";
		$this->load->model('login_model');
		$this->load->model('attendance_model');
		$this->load->model('activity_model');
		$this->load->library('pagination');

		$this->username = $this->session->userdata['names'];
		$this->staff = $this->attendance_model->get_providers();
		$this->activities = $this->activity_model->get_activities();

		$this->uid = $this->session->userdata['uid'];

	}

	public function index1() {

		$data['module']=$this->module;
		
		$this->load->view('test',$data);

	}

	public function index() {
		
		$data['users'] = $this->login_model->getusers();
		$data['checks'] = $this->checks;

		$data['widgets'] = $this->attendance_model->widget_data();

		$data['username'] = $this->username;
		$data['uid'] = $this->uid;

		$data['result'] = $this->db->get("activities")->result();
   
        foreach ($data['result'] as $key => $value) {
            $data['data'][$key]['title'] = $value->location . "Campaign";
            $data['data'][$key]['start'] = $value->starts;
            $data['data'][$key]['end'] = $value->ends;
            $data['data'][$key]['backgroundColor'] = "#00a65a";
        } 

		//$this->load->view('home', $data);

		$data['module']=$this->module;
		
		$this->load->view('test',$data);

	}


	public function activities() {

		$data['activities'] = $this->activities;
		$data['username'] = $this->username;
		$data['checks'] = $this->checks;
		$this->load->view('activities', $data);

	}

	public function add_activity() {

		$result = $this->attendance_model->add_activities();

		echo $result;

	}

	public function delete_activity($id) {

		$result = $this->attendance_model->delete_activities($id);

		echo $result;

	}

	public function staff() {

		$data['staffs'] = $this->staff;
		$data['username'] = $this->username;
		$data['checks'] = $this->checks;
		$this->load->view('staff', $data);

	}

	public function getDistricts() {

		$districts = $this->attendance_model->get_districts();

		$districts_array = array();

		foreach ($districts as $district):

			$districts_array[$district['district']] = $district['district_id'];

		endforeach;

		//print_r($districts_array);

		return $districts_array;

	}

	public function fingerprints() {

		$search_data = $this->input->post();

		if ($search_data) {
			$data['name'] = $search_data['name'];
		} else {

			$data['name'] = "";

		}

		$config = array();
		$config['base_url'] = base_url() . "attendance/fingerprints";
		$config['total_rows'] = $this->attendance_model->count_fingerprints();
		$config['per_page'] = 20; //records per page
		$config['uri_segment'] = 3; //segment in url

		//pagination links styling
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';

		$config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';

		$config['next_link'] = '<i class="fa fa-long-arrow-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0; //default starting point for limits

		$data['fingerprints'] = $this->attendance_model->fingerprints($config['per_page'], $page, $search_data);

		$data['links'] = $this->pagination->create_links();
		$data['users'] = $this->login_model->getusers();
		$data['checks'] = $this->checks;

		$data['widgets'] = $this->attendance_model->widget_data();

		$data['username'] = $this->username;

		$this->load->view('fingerprints', $data);

	}

	public function deleteFinger() {
		$id = $this->uri->segment(3);
		$id = urldecode($id);
		$this->attendance_model->deleteFinger($id);
		redirect('/attendance/fingerprints');
	}


} //end of class
