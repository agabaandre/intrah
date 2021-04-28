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

class Person_details_model extends CI_Model {

	private $_personID;
	

	public function setPersonID($personID) {
		$this->_personID = $personID;
	}

	 // get  List
	 var $ptable = 'activities';
	 var $column_order = array('a.activity_id', 'a.location', 'a.region', 'a.starts', 'a.ends');
	 var $column_search = array('a.activity_id', 'a.location', 'a.region', 'a.ends');
	 var $order = array('activity_id' => 'DESC');
 
	 private function getQuery() {

		//add custom filter here
		if ($this->input->post('location')) {
			$this->db->like('a.location', $this->input->post('location'), 'both');
		}
		if ($this->input->post('region')) {
			$this->db->like('a.region', $this->input->post('region'), 'both');
		}
		if ($this->input->post('starts')) {
			$this->db->like('a.starts', $this->input->post('starts'), 'both');
		}
		if ($this->input->post('ends')) {
			$this->db->like('a.ends', $this->input->post('ends'), 'both');
		}
        $this->db->select(array('a.activity_id', 'a.location', 'a.region','a.starts', 'a.ends'));
        
		$this->db->from('activities as a');
        $this->db->join('person_activities as b', 'a.activity_id = b.activity_id', 'Left');
        $this->db->where('b.pid', $this->_personID);
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

	public function getActivityData()
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
        $query = $this->db->get();
        log_message('debug', print_r($this->db->last_query(), TRUE));
        return $query->result_array();
	}
	public function countFiltered() {
		$this->getQuery();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function countAll() {
        $this->db->from('activities as a');
        $this->db->join('person_activities as b', 'a.activity_id = b.activity_id', 'Left');
        $this->db->where('b.pid', $this->_personID);
		return $this->db->count_all_results();
	}
 
	// for display Employee
	public function getActivity() {
		$this->db->select(array('a.activity_id', 'a.location', 'a.region', 'a.starts', 'a.ends'));
		$this->db->from('activities as a');
        $this->db->where('a.activity_id', $this->_activityID);
		$query = $this->db->get();

		//log_message('debug', print_r($this->_empID, TRUE));

		return $query->row_array();
	}

	public function getPerson($id) {
        $this->db->select(array('e.pid', 'concat_ws(" ", e.firstname, e.surname , e.othername) as person', 'e.gender', 'e.email', 'e.mobile', 'e.cadre', 'e.district'));
        $this->db->where('e.pid', $id);
        $this->db->limit(1);
		$query = $this->db->get('providerdata as e');

		//log_message('debug', print_r($query->row_array(), TRUE));

		return $query->result_array();
	}

}
?>