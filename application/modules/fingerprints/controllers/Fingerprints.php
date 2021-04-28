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

class Fingerprints extends MX_Controller {

	public function __construct() {
		parent::__construct();
		//if not logged in, go to login page
		if (!$this->session->userdata('logged_in')) {
			redirect(base_url());
		}
		$this->load->model('login_model');
		$this->load->model('fingerprint_model', 'fpt');
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
	public function index() {

		$data['users'] = $this->login_model->getusers();
		$data['username'] = $this->username;
		$data['mygroup'] = $this->mygroup;
		$data['page'] = 'emp-list';
		$data['title'] = 'View Enrollements';
		$this->load->view('enroll/index', $data);
		//$this->load->view('home', $data);

	}
	
	public function getAllDetails() {

		$json = array();
		$list = $this->fpt->getEnrollData();
		$data = array();
		foreach ($list as $element) {
			$row = array();
			$row[] = $element['entry_id'];
			$row[] = $element['fullname'];
            $row[] = $element['fingerprint'];
			$row[] = $element['pid'];
			$row[] = $element['siteName'];
            $row[] = $element['siteId'];
			$row[] = date("jS F Y", strtotime($element['enroll_date']));
			$row[] = $element['location'];
			if($this->aauth->is_group_allowed("configure",$this->mygroup) ){ 
				$row[] = '<a class="btn btn-sm btn-danger" href="javavscript:void(0)" title="Hapus" onclick="delete_fpt(' . "'" . $element['entry_id'] . "'" . ')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			} else {
				$row[] = '<a class="btn btn-sm btn-primary" href="" title="View" ><i class="glyphicon glyphicon-folder-open"></i>View</a>';
			      
			}
			$data[] = $row;
		}

		$json['data'] = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->fpt->countAll(),
			"recordsFiltered" => $this->fpt->countFiltered(),
			"data" => $data,
		);
		//output to json format
		//log_message('debug', print_r($json['data'], TRUE));
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($json['data']);
	}

	// Employee display method
	public function delete($id) {
		$json = array();
		$this->fpt->setEnrollID($id);
		$json['status'] = $this->fpt->deleteEnroll();
		$json['id'] = $id ;
		//log_message('debug', print_r($json['data'], TRUE));
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($json);

	}

}
?>