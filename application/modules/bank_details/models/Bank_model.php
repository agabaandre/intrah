<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Bank_model extends CI_Model {

	private $_empID;
	private $_empDetailsID;
	private $_bankName;
	private $_branchName;
	private $_accountNumber;
	private $_branchCode;
	private $_bankCode;

	public function setEmpID($empID) {
		$this->_empID = $empID;
	}
	public function setEmpDetailsID($empDetailsID) {
		$this->_empDetailsID = $empDetailsID;
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

	// get Employee List
	var $table = 'bank_details';
	var $providertable = 'providerdata';
	var $activitiestable = 'activities';
	var $column_order = array(null, 'concat_ws(" ", e.firstname, e.surname , e.othername)', 'b.account_no', 'b.bank_name', 'b.branch_name','b.bank_code','b.branch_code');
	var $column_search = array('concat_ws(" ", e.firstname, e.surname)', 'b.account_no', 'b.bank_name', 'b.branch_name','b.bank_code','b.branch_code');
	var $order = array('bid' => 'DESC');

	private function getQuery() {

		//add custom filter here
		if ($this->input->post('fullname')) {
			$this->db->like('concat_ws(" ", e.firstname, e.surname)', $this->input->post('fullname'), 'both');
		}
		if ($this->input->post('account_no')) {
			$this->db->like('b.account_no', $this->input->post('account_no'), 'both');
		}
		if ($this->input->post('bank_name')) {
			$this->db->like('b.bank_name', $this->input->post('bank_name'), 'both');
		}
		if ($this->input->post('facility')) {
			$this->db->like('e.facility', $this->input->post('facility'), 'both');
		}
		if ($this->input->post('district')) {
			$this->db->like('e.district', $this->input->post('district'), 'both');
		}

		$this->db->select(array('e.pid', 'b.bid', 'concat_ws(" ", e.firstname, e.surname , e.othername) as fullname', 'b.account_no', 'b.bank_name', 'b.branch_name','b.bank_code','b.branch_code'));

		$this->db->from('bank_details as b');
		$this->db->join('providerdata as e', 'e.pid = b.pid', 'Right');
		if($this->input->post('activity'))
        {
			$this->db->join('person_activities as f', 'e.pid = f.pid', 'Right');
            $this->db->where('f.activity_id', $this->input->post('activity'));
        }
		$i = 0;

		foreach ($this->column_search as $item) // loop column
		{
			if ($_POST['search']['value']) // if datatable send POST for search
			{

				if ($i === 0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i) //last loop
				{
					$this->db->group_end();
				}
				//close bracket
			}
			$i++;
		}

		if ($_POST['order']) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if ($this->order) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function getEmpData() {
		$this->getQuery();
		if ($_POST['length'] && $_POST['length'] < 1) {
			$_POST['length'] = '10';
		} else {
			$_POST['length'] = $_POST['length'];
		}

		if ($_POST['start'] && $_POST['start'] > 1) {
			$_POST['start'] = $_POST['start'];
		}
		$this->db->limit($_POST['length'], $_POST['start']);
		//print_r($_POST);die;
		$query = $this->db->get();
		return $query->result_array();
	}

	public function countFiltered() {
		$this->getQuery();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function countAll() {
		$this->db->from($this->table . ' as b');
		$this->db->join($this->providertable .' as e', 'e.pid = b.pid', 'Right');
		return $this->db->count_all_results();
	}
	
	public function get_activities_list()
    {
        $this->db->select(array('activity_id', 'location', 'starts', 'ends'));
        $this->db->from($this->activitiestable);
        $this->db->order_by('activity_id','DESC');
        $query = $this->db->get();
        $result = $query->result();
        //log_message('debug', print_r($this->db->last_query(), TRUE));
        $activities = array();
        foreach ($result as $row) 
        {
            $activityname = $row->location ." - ". date("jS F Y", strtotime($row->starts)) . " - " . date("jS F Y", strtotime($row->ends));
            $activities[$row->activity_id] = $activityname;
        }
        return $activities;
    }

	// create new Employee
	public function createEmpDetails() {
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
	public function updateEmpDetails() {
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
	// for display Employee
	public function getEmpDetails() {
		$this->db->select(array('e.pid', 'b.bid', 'e.firstname', 'e.surname', 'e.othername', 'b.account_no', 'b.bank_name', 'b.branch_name','b.bank_code','b.branch_code'));
		$this->db->from('bank_details as b');
		$this->db->join('providerdata as e', 'e.pid = b.pid', 'Right');
		$this->db->where('e.pid', $this->_empID);
		if ($this->_empDetailsID != 0){
			$this->db->where('b.bid', $this->_empDetailsID);
		}
		$query = $this->db->get();

		log_message('debug', print_r($this->db->last_query(), TRUE));

		return $query->row_array();
	}

	// delete Employee
	public function deleteEmpDetails() {
		$this->db->where('bid', $this->_empDetailsID);

		if (!$this->db->delete('bank_details')) {
			$error = $this->db->error();
            $result = $error['message'];
		} else if (!$this->db->affected_rows()) {
			$result = 'Error! ID [' . $this->_empDetailsID . '] not found';
		} else {
			$result = 'Success';
		}
		return $result;
	}

}
?>