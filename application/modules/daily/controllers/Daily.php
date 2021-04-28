<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daily extends MX_Controller {



	public function __construct(){

        parent::__construct();
        //if not logged in, go to login page
		if (!$this->session->userdata('logged_in')) {
			redirect(base_url());
		}

        $this->load->model('login_model');
        $this->load->model('activities_mdl','activitiesHandler');
        $this->load->model('attendance_model');
        $this->load->model('time_logs_model', 'tlm');

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('pagination');

        $this->username = $this->session->userdata['names'];
        $this->uid = $this->session->userdata['uid'];
        $user_details = $this->aauth->get_user_groups($this->uid);
		foreach ($user_details as $detail) {

			$this->mygroup = $detail->id;
		
		}
     

	}

	public function index() {
        $data['users'] = $this->login_model->getusers();
		$data['username'] = $this->username;
        $data['mygroup'] = $this->mygroup;
		$data['page'] = 'emp-list';
        $data['title'] = 'View Campaign Daily Attendance';
        
        $activities = $this->tlm->get_activities_list();
 
        $opt = array('' => 'All Campaigns');
        foreach ($activities as $activity_id => $activityname ) {
            $opt[$activity_id] = $activityname;
        }
        $data['form_activity'] = form_dropdown('',$opt,'','id="activity" class="form-control" onChange="getActivities();"');

		$this->load->view('daily/index', $data);

	}

    public function view_activities($activity_id = null){
        //log_message('debug', print_r("Activity ID = ".$activity_id, TRUE)); 
          if($activity_id != null){
            $data = $this->activitiesHandler->getactivities($activity_id);
          }else{
            $data = $this->activitiesHandler->getactivities();
          }

        echo json_encode($data);

    }
    public function get_activity_days($activity_id){
        //log_message('debug', print_r("Activity ID = ".$activity_id, TRUE)); 
         
        $data = $this->tlm->get_activity_days($activity_id);
        //log_message('debug', print_r($data, TRUE));
        echo json_encode($data);

    }

}


