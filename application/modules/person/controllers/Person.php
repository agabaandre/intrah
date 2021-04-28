<?php
/**
 * @package Curd :  Datatables Add, View, Edit, Delete, Export and Custom Filter Using Codeigniter with Ajax
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 *   
 * Description of Curd Controller
 */
if (!defined('BASEPATH')){
    exit('No direct script access allowed');
}

class Person extends MX_Controller {

    public function __construct() {
        parent::__construct();

        //if not logged in, go to login page
		if (!$this->session->userdata('logged_in')) {
			redirect(base_url());
        }
        $this->load->model('login_model');
        $this->load->model('Person_model', 'emp');
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
		$data['uid'] = $this->uid;
		$data['mygroup'] = $this->mygroup;
        $data['page'] = 'emp-list';
		$data['title'] = 'View Person';
		$row_data ="";

		$search = $this->input->post('search'); 

		if ($search) {

			$data['search']=$search;
			$this->db->like('surname',$search);
			$this->db->or_like('firstname',$search);
			$this->db->or_like('othername',$search);
			$this->db->or_like('gender',$search);
			$this->db->or_like('cadre',$search);
			$this->db->or_like('email',$search);
			$this->db->or_like('mobile',$search);

			$res = $this->db->get('providerdata');
			$list = $res->result_array();

		}else{

			$data['search']="";

			$list = $this->emp->getEmpData();
		}
        
        foreach ($list as $e) {

        	//$e['fullname'] = $e['surname']." ".$e['othername']." ".$e['firstname'];

            $row_data .= "<tr><td>".$e['pid']."</td><td>".$e['surname']." ".$e['othername']." ".$e['firstname']."</td><td>".$e['gender']."</td><td>".$e['cadre']."</td><td>".$e['district']."</td><td>".$e['mobile']."</td><td>".$e['email']."</td><td><a class='btn btn-sm btn-success' onclick='person_details(". $e['pid'] .")'><i class='glyphicon glyphicon-folder-open' ></i>View</a>&nbsp;&nbsp;<a class='btn btn-sm btn-primary' href='javascript:void(0)' onclick='edit_person(". $e['pid'] .")'><i class='glyphicon glyphicon-pencil'></i> Edit</a>&nbsp;&nbsp;<a class='btn btn-sm btn-danger' href='javascript:void(0)' onclick='delete_person(". $e['pid'] .")'><i class='glyphicon glyphicon-trash'></i> Delete</a></td></tr>"; 
        }
        $data['row_data']=$row_data;

		$this->load->view('test', $data);
	}

	// Employee list method
	public function reson_datals($id) {

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
        //$this->load->view('person_details', $data);
	}

	public function search_data()
    {
    	$search = $this->input->post('search');

		$this->db->select('*')
				->from('providerdata')
				->where('surname','like', '%'.$search.'%')
				->or_where('firstname','like', '%'.$search.'%')
				->or_where('othername','like', '%'.$search.'%')
				->or_where('email','like', '%'.$search.'%')
				->or_where('mobile','like', '%'.$search.'%');
				$query = $this->db->get();
        
        $data['page'] = 'emp-list';
		$data['title'] = 'View Person';
		$this->load->view('test', $data);
	}



	public function uploadData()
    {
		$data['msg'] = $this->emp->uploadData();
		//$data['users'] = $this->login_model->getusers();
		$data['username'] = $this->username;
		$data['uid'] = $this->uid;
        
        $data['page'] = 'emp-list';
		$data['title'] = 'View Person';
		$this->load->view('test', $data);
	}
	
    public function districts()
	{
		$json = [];
		if($this->input->get("q")){
			log_message('debug', print_r($this->input->get("q"), TRUE));
			$this->db->like('district_name', $this->input->get("q"));

			$query = $this->db->select('id, district_name as text')
						->limit(10)
						->get("districts");
			$json = $query->result();
		}

		echo json_encode($json);
	}
    public function getAllPersons()
    {
		$json = array();    
        $list = $this->emp->getEmpData();
        $data = array();
        foreach ($list as $element) {
            $row = array();
            $row[] = $element['pid'];
			$row[] = $element['fullname'];
			$row[] = $element['gender'];
			$row[] = $element['cadre'];
			$row[] = $element['district'];
			$row[] = $element['mobile'];
			$row[] = $element['email'];

			if($this->aauth->is_group_allowed("manageusers",$this->mygroup) ){ 
				$row[] = '<a class="btn btn-sm btn-primary" href="../person_details/index/' . $element['pid'] .'" title="View" ><i class="glyphicon glyphicon-folder-open"></i>View</a>&nbsp;&nbsp;<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person(' . "'" . $element['pid'] . "'" . ')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>&nbsp;&nbsp;<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person(' . "'" . $element['pid'] . "'" . ')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			} else {
				$row[] = '<a class="btn btn-sm btn-primary" href="../person_details/index/' . $element['pid'] .'" title="View" ><i class="glyphicon glyphicon-folder-open"></i>View</a>';
			
			}
            $data[] = $row;
        }
        /*
        $json['data'] = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->emp->countAll(),
            "recordsFiltered" => $this->emp->countFiltered(),
            "data" => $data,
        ); */
		//output to json format
       // $this->output->set_header('Content-Type: application/json');
        //echo json_encode($json['data']);
        return $json['data'];
    }

    // Employee save method
    public function save() {

        $json = array();        
        $firstname = $this->input->post('firstname');
		$surname = $this->input->post('surname');
		$othername = $this->input->post('othername');
		$email = $this->input->post('email');
		$cadre = $this->input->post('cadre');

		$query = $this->db->select('district_name')
						->where('id', $this->input->post('district'))
						->get("districts");
		$result = $query->row();

		$district = $result->district_name;
		$district_id = $this->input->post('district');

		$gender = $this->input->post('gender');

		$place = $this->input->post('place');
		$mobile = $this->input->post('mobile');
		$occupation = $this->input->post('occupation');
		$organisation = $this->input->post('organisation');

		if (!(trim($firstname))) {
			$json['error']['firstname'] = 'Please enter first name';
		}
		if (!(trim($surname))) {
			$json['error']['surname'] = 'Please enter last name';
		}
		if ($this->emp->validateEmail($email) == FALSE) {
			$json['error']['email'] = 'Please enter valid email address';
		}
		if (!($cadre)) {
			$json['error']['cadre'] = 'Please enter cadre';
		}
		
		if ($this->emp->validateMobile($mobile) == FALSE) {
			$json['error']['mobile'] = 'Please enter valid contact no';
		}

		if (!($district)) {
			$json['error']['district'] = 'Please Select a district';
		}

		if (!(trim($occupation))) {
			$json['error']['occupation'] = 'Please enter occupation name';
		}
		if (!(trim($place))) {
			$json['error']['place'] = 'Please enter place name';
		}
		if (!(trim($organisation))) {
			$json['error']['organisation'] = 'Please enter organisation name';
		}
		
        if(!($json['error'])){
            $this->emp->setFirstName($firstname);
			$this->emp->setSurName($surname);
			$this->emp->setOtherName($othername);
			$this->emp->setEmail($email);
			$this->emp->setCadre($cadre);
			$this->emp->setDistrict($district);
			$this->emp->setDistrictID($district_id);
			$this->emp->setGender($gender);
			$this->emp->setContactNo($mobile);
			$this->emp->setOccupationName($occupation);
			$this->emp->setOrganisationName($organisation);
			$this->emp->setPlaceName($place);

            try {
                $last_id = $this->emp->createEmp();
                echo  json_encode($last_id);

            } catch (Exception $e) {
                //var_dump($e->getMessage());

                echo json_encode($e->getMessage());
            }
            
    }

}

    public function saveParticipantData(){
   /* 	$name = $this->input->post('name');
		$title = $this->input->post('title');
		$organisation = $this->input->post('organisation');
		$telephone = $this->input->post('telephone');
		$time_in = $this->input->post('time_in');
		$signature1 = $this->input->post('signature1');
		$time_out = $this->input->post('time_out');
		$signature2 = $this->input->post('signature2');

		$data = array(
            'name' => $name,
            'title' => $title,
            'organisation' => $organisation,
            'telephone' => $telephone,
            'time_in' => $time_in,
            'signature1' => $signature1,
            'time_out' => $time_out,
            'signature2' => $signature2
        );   

	$this->db->insert('clk_log', $data);
    $last_id = $this->db->insert_id()
*/

    }




	public function edit($id) {
		$this->emp->setEmpID($id);
		$data = $this->emp->getEmp();
		$this->output->set_header('Content-Type: application/json');
		echo json_encode($data);
	}


    // Employee save method
    public function update() {

        $json = array();   
        $emp_id = $this->input->post('pid');     
        $firstname = $this->input->post('firstname');
		$surname = $this->input->post('surname');
		$othername = $this->input->post('othername');
		$email = $this->input->post('email');
		$cadre = $this->input->post('cadre');

		$query = $this->db->select('district_name')
						->where('id', $this->input->post('district'))
						->get("districts");
		$result = $query->row();

		$district = $result->district_name;
		$district_id = $this->input->post('district');

		$gender = $this->input->post('gender');

		$place = $this->input->post('place');
		$mobile = $this->input->post('mobile');
		$occupation = $this->input->post('occupation');
		$organisation = $this->input->post('organisation');

		if (!(trim($firstname))) {
			$json['error']['firstname'] = 'Please enter first name';
		}
		if (!(trim($surname))) {
			$json['error']['surname'] = 'Please enter last name';
		}
		if ($this->emp->validateEmail($email) == FALSE) {
			$json['error']['email'] = 'Please enter valid email address';
		}
		if (!($cadre)) {
			$json['error']['cadre'] = 'Please enter cadre';
		}
		
		if ($this->emp->validateMobile($mobile) == FALSE) {
			$json['error']['mobile'] = 'Please enter valid contact no';
		}

		if (!($district)) {
			$json['error']['district'] = 'Please Select a district';
		}

		if (!(trim($occupation))) {
			$json['error']['occupation'] = 'Please enter occupation name';
		}
		if (!(trim($place))) {
			$json['error']['place'] = 'Please enter place name';
		}
		if (!(trim($organisation))) {
			$json['error']['organisation'] = 'Please enter organisation name';
		}
		
        if(!($json['error'])){
            $this->emp->setFirstName($firstname);
			$this->emp->setSurName($surname);
			$this->emp->setOtherName($othername);
			$this->emp->setEmail($email);
			$this->emp->setCadre($cadre);
			$this->emp->setDistrict($district);
			$this->emp->setDistrictID($district_id);
			$this->emp->setGender($gender);
			$this->emp->setContactNo($mobile);
			$this->emp->setOccupationName($occupation);
			$this->emp->setOrganisationName($organisation);
			$this->emp->setPlaceName($place);

            try {
                $last_id = $this->emp->updateEmp();
                echo  json_encode($last_id);

            } catch (Exception $e) {
                //var_dump($e->getMessage());

                echo json_encode($e->getMessage());
            }
            
    }

}
    // Employee update method
    public function update_() {
        $json = array();        
        $emp_id = $this->input->post('pid');
        $first_name = $this->input->post('firstName');
		$last_name = $this->input->post('lastName');
		$other_name = $this->input->post('otherName');
		$email = $this->input->post('email');
		$cadre = $this->input->post('cadre');
		$contact_no = $this->input->post('mobile');
		$query = $this->db->select('district_name')
						->where('id', $this->input->post('district'))
						->get("districts");	
		$result = $query->row();
		$district = $result->district_name;
		$district_id = $this->input->post('district');
		$gender = $this->input->post('gender');    
		
		$bank_name = $this->input->post('bank_name');
		$branch_name = $this->input->post('branch_name');
		$bank_code = $this->input->post('bank_code');
		$branch_code = $this->input->post('branch_code');
		$account_no = $this->input->post('account_no');
            
        if (!(trim($first_name))) {
			$json['error']['firstname'] = 'Please enter first name';
		}
		if (!(trim($last_name))) {
			$json['error']['lastname'] = 'Please enter last name';
		}
		if ($this->emp->validateEmail($email) == FALSE) {
			$json['error']['email'] = 'Please enter valid email address';
		}
		if (!($cadre)) {
			$json['error']['cadre'] = 'Please enter cadre';
		}
		if ($this->emp->validateMobile($contact_no) == FALSE) {
			$json['error']['mobile'] = 'Please enter valid contact no';
		}

		if (!$district) {
			$json['error']['district'] = 'Please Select district';
		}

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

		if ($this->emp->validateAccount($account_no) == FALSE) {
			$json['error']['account_no'] = 'Account Number Already in the system. Record must already exist for this person. User Search function';
		}
		
        if(!($json['error'])){
            $this->emp->setEmpID($emp_id);
            $this->emp->setFirstName($first_name);
			$this->emp->setSurName($last_name);
			$this->emp->setOtherName($other_name);
			$this->emp->setEmail($email);
			$this->emp->setCadre($cadre);
			$this->emp->setDistrict($district);
			$this->emp->setDistrictID($district_id);
			$this->emp->setGender($gender);
			$this->emp->setContactNo($contact_no);
            try {
                $last_id = $this->emp->updateEmp();
            } catch (Exception $e) {
                var_dump($e->getMessage());
            }
                
            if ($emp_id && $emp_id > 0) { 
				$this->emp->setEmpID($emp_id);
				$this->emp->setAccountNumber($account_no);
				$this->emp->setBankName($bank_name);
				$this->emp->setBranchName($branch_name);
				$this->emp->setBankCode($bank_code);
				$this->emp->setBranchCode($branch_code);
				try {
					$bank_last_id = $this->emp->updateBnkDetails();
				} catch (Exception $e) {
					var_dump($e->getMessage());
				}
				$empInfo = $this->emp->getEmp(); 
				                   
                $json['emp_id'] = $empInfo['pid'];
                $json['firstname'] = $empInfo['firstname'];
				$json['lastname'] = $empInfo['lastname'];
				$json['othername'] = $empInfo['othername'];
				$json['email'] = $empInfo['email'];
				$json['cadre'] = $empInfo['cadre'];
				$json['contact_no'] = $empInfo['mobile'];
				$json['district'] = $empInfo['district'];
				$json['gender'] = $empInfo['gender'];
				$json['account_no'] = $empInfo['account_no'];
				$json['bank_name'] = $empInfo['bank_name'];
				$json['branch_name'] = $empInfo['branch_name'];
				$json['bank_code'] = $empInfo['bank_code'];
				$json['branch_code'] = $empInfo['branch_code'];
				$json['status'] = 'success';
            }
        }
        $this->output->set_header('Content-Type: application/json');
        echo json_encode($json);
    }

    // Employee display method
    public function display() {
        $json = array();
        $empID = $this->input->post('emp_id');
        $this->emp->setEmpID($empID);
        $json['empInfo'] = $this->emp->getEmp();

        $this->output->set_header('Content-Type: application/json');
        $this->load->view('persons/popup/renderDisplay', $json);
    }

    // Employee display method
    public function delete($id) {
        $json = array();       
		$this->emp->setEmpID($id);
		$json['status'] = $this->emp->deleteEmp();
		$json['pid'] = $id;
		//log_message('debug', print_r($json, TRUE));
        $this->output->set_header('Content-Type: application/json');
        echo json_encode($json);
        
    }

}
?>