<?php
/**
 * Description of Curd Model: Datatables Add, View, Edit, Delete, Export and Custom Filter Using Codeigniter with Ajax
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Person_model extends CI_Model {

    private $_empID;
    private $_firstName;
	private $_surName;
	private $_otherName;
	private $_email;
	private $_gender;
	private $_cadre;
	private $_district;
    private $_mobile;
    private $_occupation;
    private $_organisation;
    private $_place;
    
    private $_bankName;
	private $_branchName;
	private $_accountNumber;
	private $_branchCode;
	private $_bankCode;

    public function setEmpID($empID) {
        $this->_empID = $empID;
    }
    public function setFirstName($firstName) {
		$this->_firstName = $firstName;
	}
	public function setSurName($surName) {
		$this->_surName = $surName;
	}
	public function setOtherName($otherName) {
		$this->_otherName = $otherName;
	}
	public function setEmail($email) {
		$this->_email = $email;
	}
	public function setCadre($cadre) {
		$this->_cadre = $cadre;
	}
	public function setGender($gender) {
		$this->_gender = $gender;
	}
	public function setContactNo($mobile) {
		$this->_mobile = $mobile;
	}
	public function setDistrict($district) {
		$this->_district = $district;
    }
    public function setDistrictID($districtid) {
		$this->_districtID = $districtid;
    }
    
    public function setBankName($bankName) {
		$this->_bankName = $bankName;
	}
	public function setBankCode($bankCode) {
		$this->_bankCode = $bankCode;
	}
	public function setBranchName($branchName) {
		$this->_branchName = $branchName;
	}
	public function setBranchCode($branchCode) {
		$this->_branchCode = $branchCode;
	}
	public function setAccountNumber($accountNumber) {
		$this->_accountNumber = $accountNumber;
	}

    public function setOccupationName($occupation) {
        $this->_occupation = $occupation;
    }
    public function setOrganisationName($organisation) {
        $this->_organisation = $organisation;
    }
    public function setPlaceName($place) {
        $this->_place = $place;
    }
	
    // get Employee List
    var $table = 'providerdata';
    var $bnk_table = 'bank_details';
	var $column_order = array(null,'fullname', 'e.gender', 'e.email', 'e.mobile', 'e.cadre', 'e.district');
	var $column_search = array('concat_ws(" ", e.firstname, e.surname)', 'e.mobile', 'e.cadre', 'e.district');
	var $order = array('pid' => 'ASC');

    private function getQuery()
    {

        //add custom filter here
        if ($this->input->post('fullname')) {
			$this->db->like('concat_ws(" ", e.firstname, e.surname)', $this->input->post('fullname'), 'both');
		}
		if ($this->input->post('cadre')) {
			$this->db->like('e.cadre', $this->input->post('cadre'), 'both');
		}
		if ($this->input->post('contact')) {
			$this->db->like('e.mobile', $this->input->post('contact'), 'both');
		}
		if ($this->input->post('district')) {
			$this->db->like('e.district', $this->input->post('district'), 'both');
		}

		$this->db->select(array('e.pid', 'e.firstname', 'e.surname', 'e.othername', 'e.gender', 'e.email', 'e.mobile', 'e.cadre', 'e.district'));

		$this->db->from('providerdata as e');

       // $this->db->from('participant_data as e');

        /*
        $i = 0;
    
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        } */
        
        if($_POST['order']) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if($this->order)
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getEmpData()
    {
        $this->getQuery();
        if($_POST['length'] && $_POST['length'] < 1) {
            $_POST['length']= '10';
        } else {
            $_POST['length']= $_POST['length'];
        }
        
        if($_POST['start'] && $_POST['start'] > 1) {
        $_POST['start']= $_POST['start'];
        }
        $this->db->limit($_POST['length'], $_POST['start']);
        //print_r($_POST);die;
        $query = $this->db->get();
        return $query->result_array();
    }
    public function countFiltered()
    {
        $this->getQuery();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAll()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }


    // create new Employee
    public function createEmp_() { 
        $data = array(
            'firstname' => $this->_firstName,
			'surname' => $this->_surName,
			'othername' => $this->_otherName,
			'email' => $this->_email,
			'gender' => $this->_gender,
			'mobile' => $this->_mobile,
			'cadre' => $this->_cadre,
            'district' => $this->_district,
            'occupation' => $this->_occupation,
            'organisation' => $this->_organisation,
            'place' => $this->_place

        );
        $this->db->insert('providerdata', $data);
        return $this->db->insert_id();
    }

    // create new Employee
    public function createEmp() { 
        $data = array(
            'firstname' => $this->_firstName,
            'surname' => $this->_surName,
            'othername' => $this->_otherName,
            'email' => $this->_email,
            'gender' => $this->_gender,
            'mobile' => $this->_mobile,
            'cadre' => $this->_cadre,
            'district' => $this->_district,
            'district_id' => $this->_districtID,
            'occupation' => $this->_occupation,
            'organisation' => $this->_organisation,
            'place' => $this->_place
        );
        $this->db->insert('providerdata', $data);
        //$this->db->insert('participant_data', $data);
        return $this->db->insert_id();
    }

    // update Employee
    public function updateEmp() { 
        $data = array(
            'firstname' => $this->_firstName,
            'surname' => $this->_surName,
            'othername' => $this->_otherName,
            'email' => $this->_email,
            'gender' => $this->_gender,
            'mobile' => $this->_mobile,
            'cadre' => $this->_cadre,
            'district' => $this->_district,
            'district_id' => $this->_districtID,
            'occupation' => $this->_occupation,
            'organisation' => $this->_organisation,
            'place' => $this->_place
        );
        $this->db->where('pid', $this->_empID);
        //$this->db->update('participant_data', $data);
        $this->db->update('providerdata', $data);
    }

    // create new Employee
	public function createBnkDetails() {
		$data = array(
			'pid' => $this->_empID,
			'account_no' => $this->_accountNumber,
			'bank_name' => $this->_bankName,
			'branch_name' => $this->_branchName,
			'bank_code' => $this->_bankCode,
			'branch_code' => $this->_branchCode,
		);
		$this->db->insert('bank_details', $data);
		return $this->db->insert_id();
    }
    
    // update Employee
	public function updateBnkDetails() {
		$data = array(
			'pid' => $this->_empID,
			'account_no' => $this->_accountNumber,
			'bank_name' => $this->_bankName,
			'branch_name' => $this->_branchName,
			'bank_code' => $this->_bankCode,
			'branch_code' => $this->_branchCode,
		);
		$this->db->where('bid', $this->_empDetailsID);
		$this->db->update('bank_details', $data);
		//return $this->db->affected_rows();
	}
    /* for display Employee
    public function getEmp() {        
        $this->db->select(array('e.pid', 'e.firstname', 'e.surname', 'e.othername', 'e.email', 'e.gender', 'e.mobile', 'e.cadre', 'e.district'));
		$this->db->from('providerdata e');
		$this->db->where('e.pid', $this->_empID);    
        $query = $this->db->get();
       return $query->row_array();
    }
    */
    // for display Employee
	public function getEmp_() {
		$this->db->select(array('e.pid', 'b.bid', 'e.firstname', 'e.surname', 'e.othername', 'e.email', 'e.gender', 'e.mobile', 'e.cadre', 'e.district', 'b.account_no', 'b.bank_name', 'b.branch_name','b.bank_code','b.branch_code'));
		$this->db->from('bank_details as b');
		$this->db->join('providerdata as e', 'e.pid = b.pid', 'Right');
		$this->db->where('e.pid', $this->_empID);
		if ($this->_empID != 0){
			$this->db->where('b.bid', $this->_empID);
		}
		$query = $this->db->get();

		//log_message('debug', print_r($this->db->last_query(), TRUE));

		return $query->row_array();
    }

    public function getEmp() {
        //$this->db->select(array('e.pid', 'b.bid', 'e.firstname', 'e.surname', 'e.othername', 'e.email', 'e.gender', 'e.mobile', 'e.cadre', 'e.district', 'b.account_no', 'b.bank_name', 'b.branch_name','b.bank_code','b.branch_code'));

        $this->db->select('*');
        //$this->db->from('participant_data');
        $this->db->from('providerdata');
        
        //$this->db->where('pid', $this->_empID);
        if ($this->_empID != 0){
            $this->db->where('pid', $this->_empID);
        }
        $query = $this->db->get();

        //log_message('debug', print_r($this->db->last_query(), TRUE));

        return $query->row_array();
    }

    // delete Employee
    public function deleteEmp() {         
        $this->db->where('pid', $this->_empID);
        //$this->db->delete('providerdata'); 

        if(!$this->db->delete('providerdata')){
            $error = $this->db->error();
            $result = $error['message'];
        } else if (!$this->db->affected_rows()) {
            $result = 'Error! ID [' . $this->_empID . '] not found';
        } else {
            $result = 'Success';
        }
        
		return $result; 
    }

    // email validation
    public function validateEmail($email)
    {
        return preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email)?TRUE:FALSE;
    }

    // mobile validation
    public function validateMobile($mobile)
    {
        return preg_match('/^[0-9]{10}+$/', $mobile)?TRUE:FALSE;
    }

    // mobile validation
    public function validateAccount($account)
    {
        $this->db->select(array('account_no'));
        $this->db->from('bank_details');
        $this->db->where('account_no', $account);
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            log_message('debug', $query->num_rows());
            return FALSE;
        } else {
            return TRUE;
        } 
    }
    
    public function get_district_list()
    {
        $this->db->select(array('id', 'district_name', 'region'));
        $this->db->from('districts');
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $result = $query->result();
        $districts = array();
        foreach ($result as $row) 
        {
            $districts[$row->id] = $row->district_name;
        }
        return $districts;
    }

    public function uploadData()
    {
        $count=0;
        if($_FILES['providerimport']['tmp_name']) {
            $fp = fopen($_FILES['providerimport']['tmp_name'],'r');
            if ($fp) {
                while($csv_line = fgetcsv($fp,1024))
                {   
                    $count++; 
                    if($count == 1)
                    {
                        continue;
                    }//keep this if condition if you want to remove the first row
                    for($i = 0, $j = count($csv_line); $i < $j; $i++)
                    {
                        $insert_csv = array();
                        $insert_csv['surname'] = $csv_line[0];
                        $insert_csv['firstname'] = $csv_line[1];
                        $insert_csv['othername'] = $csv_line[2];
                        $insert_csv['gender'] = $csv_line[3];
                        $insert_csv['mobile'] = $csv_line[4];
                        $insert_csv['email'] = $csv_line[5];
                        $insert_csv['cadre'] = $csv_line[6];
                        $insert_csv['district'] = $csv_line[7];
                        $insert_csv['account_no'] = $csv_line[8];
                        $insert_csv['bank_name'] = $csv_line[9];
                        $insert_csv['bank_code'] = $csv_line[10];
                        $insert_csv['branch_name'] = $csv_line[11];
                        $insert_csv['branch_code'] = $csv_line[12];

                    }
                    $i++;
                    $this->db->select('id');
                    $this->db->where('district_name', $insert_csv['district']);
                    $query = $this->db->get('districts');
                    $result = $query->row_array();
                    $data = array(
                        'surname' => $insert_csv['surname'],
                        'firstname' => $insert_csv['firstname'],
                        'othername' => $insert_csv['othername'],
                        'gender' => $insert_csv['gender'],
                        'mobile' => $insert_csv['mobile'],
                        'email' => $insert_csv['email'],
                        'cadre' => $insert_csv['cadre'],
                        'district' => $insert_csv['district'],
                        'district_id' => $result['id']);
                    $this->db->insert('providerdata', $data);
                    $last_id = $this->db->insert_id();
                    $bankdata = array(
                        'pid' => $last_id,
                        'account_no' => $insert_csv['account_no'],
                        'bank_name' => $insert_csv['bank_name'],
                        'bank_code' => $insert_csv['bank_code'],
                        'branch_name' => $insert_csv['branch_name'],
                        'branch_code' => $insert_csv['branch_code']);
                    $this->db->insert('bank_details', $bankdata); 
                }   
                fclose($fp) or die("can't close file");
                //$data['success']="success";
                $count = $count - 1;
                return "File Uploaded Successfuly. " . $count . " Provider Details added";             
            } else {
                return "Failed to open file. File not Uploaded";
            }
        } else {
            return "No File Uploaded" ; 
         
         }
    }
}
?>