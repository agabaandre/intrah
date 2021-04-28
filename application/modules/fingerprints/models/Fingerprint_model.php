<?php
/**
 * Description of Curd Model: Datatables Add, View, Edit, Delete, Export and Custom Filter Using Codeigniter with Ajax
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 */
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Fingerprint_model extends CI_Model {

	private $_enrollID;

	public function setEnrollID($enrollID) {
		$this->_enrollID = $enrollID;
	}

	// get Employee List
	var $table = 'fingerprints';
	var $column_order = array('a.entry_id','a.siteId','a.pid','a.fingerprint','a.enroll_date');
	var $column_search = array('a.entry_id','a.fingerprint','a.pid', 'a.siteId','a.location', 'a.enroll_date');
	var $order = array('entry_id' => 'DESC');

	private function getQuery() {

		//add custom filter here
		if ($this->input->post('pid')) {
			$this->db->like('a.pid', $this->input->post('pid'), 'both');
		}
		if ($this->input->post('siteId')) {
			$this->db->like('a.siteId', $this->input->post('siteId'), 'both');
		}
		if ($this->input->post('enroll_date')) {
			$this->db->like('a.enroll_date', $this->input->post('enroll_date'), 'both');
		}
		$this->db->select(array('a.entry_id','concat_ws(" ", b.firstname, b.surname , b.othername) as fullname','s.siteName','a.fingerprint','a.pid', 'a.siteId','a.location', 'a.enroll_date'));

		$this->db->from('fingerprints as a');
		$this->db->join('providerdata as b', 'b.pid = a.pid', 'LEFT');
		$this->db->join('activity_sites as s', 'a.siteId = s.sid', 'LEFT');
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

	public function getEnrollData() {
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
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}


    
	// delete Activity
	public function deleteEnroll() {
		$this->db->where('entry_id', $this->_enrollID);

		if(!$this->db->delete('fingerprints')){
            $error = $this->db->error();
            $result = $error['message'];
        } else if (!$this->db->affected_rows()) {
            $result = 'Error! ID [' . $this->_enrollID . '] not found';
        } else {
            $result = 'Success';
        }
		return $result;
	}

}
?>