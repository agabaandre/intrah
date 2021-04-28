<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends MX_Controller {



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
        $data['title'] = 'View Payments';
        
        $activities = $this->tlm->get_activities_list();
 
        $opt = array('' => 'All Activities');
        foreach ($activities as $activity_id => $activityname ) {
            $opt[$activity_id] = $activityname;
        }
        
        $data['form_activity'] = form_dropdown('',$opt,'','id="activity" class="form-control" onChange="load_row()" name="activity_id"' );

        // onChange="load_row()"; 

		$this->load->view('index', $data);

	}

    public function view_activities($activity_id = null){

        $this->db->select('*');
        $this->db->from('providerdata');
        $this->db->join('vclk_logs', 'providerdata.pid = vclk_logs.pid', 'Left');
        if($activity_id != null){
            $this->db->where('activity_id' , $activity_id);
        }
        $this->db->group_by('vclk_logs.date');
        $ppQry = $this->db->get();
        $data['people'] = $ppQry->result_array();

        $this->load->view('row-data', $data); 

    }

    public function payment_index() {
        $data['users'] = $this->login_model->getusers();
        $data['username'] = $this->username;
        $data['mygroup'] = $this->mygroup;
        $data['page'] = 'emp-list';
        $data['title'] = 'View Payments';
        
        $activities = $this->tlm->get_activities_list();
 
        $opt = array('' => 'All Activities');
        foreach ($activities as $activity_id => $activityname ) {
            $opt[$activity_id] = $activityname;
        }
        
        $data['form_activity'] = form_dropdown('',$opt,'','id="activity" class="form-control" onChange="load_activty()" name="activity_id"' );

        // onChange="load_row()"; 

        $this->load->view('payment_details', $data);

    }
 

    public function payment_details($activity_id = null){

        $this->db->select('*');
        $this->db->from('providerdata');
        $this->db->join('payments_data', 'payments_data.pid = providerdata.pid', 'Left');
        if($activity_id != null){
            $this->db->where('activity_id' , $activity_id);
        }
        $ppQry = $this->db->get();
        $data['people'] = $ppQry->result_array();

        $this->load->view('payment_details_row', $data); 

    }

    public function get_activity_days($activity_id){
         
        $data = $this->tlm->get_days($activity_id);
        echo json_encode($data);

    }
    public function get_rates(){ 
         
        $data = $this->tlm->getRates();

        echo json_encode($data);

    }

    public function save_payements(){ 

        $data = $this->input->post();

        for ($i = 0; $i < count($data['num']); $i++) {

            $save = array(
                    'pid' => $data['pid'][$i], 
                    'activity_id' => $data['activity_id'], 
                    'transport' => $data['transport'][$i],
                    'accommodation' => $data['accommodation'][$i]
                );

            $res =   $this->db->insert('payments_data', $save);
        }

        return $res;
    }
    

    public function get_debit_account(){ 
         
        $data = $this->tlm->getDebitAccount();

        echo json_encode($data);

    }
    public function get_activity_weekend_days($activity_id){
         
        $data = $this->tlm->get_activity_weekenddays($activity_id);

        echo $data;

    }
    public function get_public_holidays($start,$end){
         
        $data = $this->tlm->get_public_holidays($start,$end);
        echo $data;

    }

}


