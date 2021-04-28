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

class Activity_details extends MX_Controller {

	public function __construct() {
		parent::__construct();
		//if not logged in, go to login page
		if (!$this->session->userdata('logged_in')) {
			redirect(base_url());
		}
		$this->load->model('login_model');
        $this->load->model('activity_model', 'act');
        $this->load->model('activity_details_model', 'act_details');
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
        $data['title'] = 'View Campaign Details';
        $result = $this->act_details->getActivityName($id);
        foreach ($result as $element) {
            $data['location'] = $element['location'];
            $data['starts'] = $element['starts'];
            $data['ends'] = $element['ends'];
        }
        $data['activity_id'] = $id;
		$this->load->view('activity_details/index', $data);

	}

	public function activity_site($id) {

		$data['users'] = $this->login_model->getusers();
		$data['username'] = $this->username;
		$data['mygroup'] = $this->mygroup;
		$data['page'] = 'emp-list';
        $data['title'] = 'View Campaign Site Details';
        $result = $this->act_details->getActivitySiteName($id);
        foreach ($result as $element) {
            $data['siteName'] = $element['siteName'];
            $data['activity_id'] = $element['activity_id'];
			$data['location'] = $element['location'];
			$data['starts'] = $element['starts'];
			$data['ends'] = $element['ends'];
        }
		$data['sid'] = $id;
		//log_message('debug', print_r($data , TRUE));
		$this->load->view('activity_details/activity_site', $data);

	}

    public function getAttendActivityDetails($id) {

        //log_message('debug', print_r("Activity ID= " . $id, TRUE));
		$json = array();
		$this->act_details->setSiteID($id);
		$list =  $this->act_details->getAttendEmpData();
		$data = array();
		foreach ($list as $element) {
            $row = array();
            $row[] = $element['pid'];
			$row[] = $element['fullname'];
			$row[] = $element['gender'];
			$row[] = $element['cadre'];
			$row[] = $element['district'];
            $row[] = $element['mobile'];
            //$row[] = '<input type="checkbox" class="data-check" value="' . $element['pid'] . '">';
			//$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Delete" onclick="delete_from_activity(' . "'" . $element['pid'] . "'" . ')"><i class="glyphicon glyphicon-pencil"></i> Delete</a>';
			
			$data[] = $row;
		}

		$json['data'] = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->act_details->acountAll(),
			"recordsFiltered" => $this->act_details->acountFiltered(),
			"data" => $data,
		);
		//output to json format
		//log_message('debug', print_r($json['data'], TRUE));
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($json['data']);
    }
    
	public function getActivityDetails() {

        //log_message('debug', print_r("Activity ID= " . $id, TRUE));
		$json = array();
		$list =  $this->act_details->getEmpData();
		$data = array();
		foreach ($list as $element) {
            $row = array();
            $row[] = $element['pid'];
			$row[] = $element['fullname'];
			$row[] = $element['gender'];
			$row[] = $element['cadre'];
			$row[] = $element['district'];
            $row[] = $element['mobile'];
            //$row[] = '<input type="checkbox" class="data-check" value="' . $element['pid'] . '">';
			//$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Delete" onclick="delete_from_activity(' . "'" . $element['pid'] . "'" . ')"><i class="glyphicon glyphicon-pencil"></i> Delete</a>';
			
			$data[] = $row;
		}

		$json['data'] = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->act_details->pcountAll(),
			"recordsFiltered" => $this->act_details->pcountFiltered(),
			"data" => $data,
		);
		//output to json format
		//log_message('debug', print_r($json['data'], TRUE));
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($json['data']);
	}

    public function bulk_add($activity_id, $sid) {
		$list_id = $this->input->post('id');
		foreach ($list_id as $id) {
			$this->act_details->add_by_id($id,$activity_id,$sid);
		}
		echo json_encode(array("status" => TRUE));
    }
    
	public function delete_selected($activity_id)
	{
		$list_id = $this->input->post('id');
		foreach ($list_id as $id) {
			$this->act_details->delete_by_id($id, $activity_id);
		}
		echo json_encode(array("status" => TRUE));
	}
	// Site save method
	public function save_site() {
		$json = array();
		$siteName = $this->input->post('siteName');
		$activity_id = $this->input->post('activity_id');

		if (!(trim($siteName))) {
			$json['error']['location'] = 'Please enter Location';
		}
		if (!(trim($activity_id))) {
			$json['error']['activity_id'] = 'No Campaign ID';
		}
		
		if (!$json['error']) {
			$this->act_details->setSiteName($siteName);
			$this->act_details->setActivityID($activity_id);
			try {
				$last_id = $this->act_details->createSite();
			} catch (Exception $e) {
				var_dump($e->getMessage());
			}

			if ($last_id && $last_id > 0) {
				$siteID = $last_id;
				$this->act_details->setSiteID($siteID);
				$siteDetailsInfo = $this->act_details->getSite();
				$json['activity_id'] = $siteDetailsInfo['activity_id'];
				$json['siteName'] = $siteDetailsInfo['siteName'];
				$json['sid'] = $siteDetailsInfo['sid'];
				$json['status'] = 'success';
			}
		}
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($json);
	}

	public function update_site() {
		$json = array();
		$activity_id = $this->input->post('activity_id');
		$sid = $this->input->post('sid');
		$siteName = $this->input->post('siteName');

		if (!(trim($siteName))) {
			$json['error']['siteName'] = 'Please enter Site Name';
		}
		if (!(trim($activity_id))) {
			$json['error']['starts'] = 'No Campaign ID';
		}

		if (!($json['error'])) {
			$this->act_details->setSiteName($siteName);
			$this->act_details->setSiteID($sid);
			$this->act_details->setActivityID($activity_id);
			try {
				$last_id = $this->act_details->updateSite();
			} catch (Exception $e) {
				var_dump($e->getMessage());
			}

			if ($sid && $sid > 0) {
				//$empDetailsID = $last_id;
				$this->act_details->setSiteID($sid);
				$siteDetailsInfo = $this->act_details->getSite();
				$json['activity_id'] = $siteDetailsInfo['activity_id'];
				$json['siteName'] = $siteDetailsInfo['siteName'];
				$json['sid'] = $siteDetailsInfo['sid'];
				$json['status'] = 'success';
			}
		}
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($json);
	}

	public function edit_site($id) {
		$this->act_details->setSiteID($id);
		$data = $this->act_details->getSite();
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($data);
	}
    public function delete_site($id) {
		$json = array();
		$this->act_details->setSiteID($id);
		$json['status'] = $this->act_details->deleteSite();
		$json['id'] = $id ;
		//log_message('debug', print_r($json['data'], TRUE));
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($json);

	}
	public function getAllSiteDetails($id) {

		$json = array();
		$this->act_details->setActivityID($id);
		$list = $this->act_details->getSiteData();
		$data = array();
		foreach ($list as $element) {
			$row = array();
			$row[] = $element['sid'];
			$row[] = $element['siteName'];
			if($this->aauth->is_group_allowed("managesites",$this->mygroup) ){ 
				$row[] = '<a class="btn btn-sm btn-primary" href="../activity_site/' . $element['sid'] .'" title="View" ><i class="glyphicon glyphicon-folder-open"></i>View</a>
			      <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_site(' . "'" . $element['sid'] . "'" . ')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javavscript:void(0)" title="Hapus" onclick="delete_site(' . "'" . $element['sid'] . "'" . ')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			
			} else {
				$row[] = '<a class="btn btn-sm btn-primary" href="../activity_site/' . $element['sid'] .'" title="View" ><i class="glyphicon glyphicon-folder-open"></i>View</a>';
			
			}
			$data[] = $row;
		}

		$json['data'] = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->act_details->scountAll(),
			"recordsFiltered" => $this->act_details->scountFiltered(),
			"data" => $data,
		);
		//output to json format
		//log_message('debug', print_r($json['data'], TRUE));
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($json['data']);
	}
}
?>