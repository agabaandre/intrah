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

class Activity_model extends CI_Model {

	private $_activityID;
	private $_location;
	private $_district;
	private $_district_id;
	private $_starts;
	private $_ends;

	public function setActivityID($activityID) {
		$this->_activityID = $activityID;
	}
	public function setLocation($location) {
		$this->_location = $location;
	}
	public function setStartDate($starts) {
		$this->_starts = $starts;
	}
	public function setEndDate($ends) {
		$this->_ends = $ends;
	}
	public function setSnu($snu) {
		$this->_snu = $snu;
	}

	public function setDistrict($dis) {
		$this->_district = $dis;
	}
	public function setDistrictID($dis) {
		$this->_district_id = $dis;
	}	
	public function setSnuID($snuid) {
		$this->_snuID = $snuid;
	}
	public function setNotes($notes) {
		$this->_notes = $notes;
	}
	public function setRegion($region) {
		$this->_region = $region;
    }
    public function setRegionID($regionid) {
		$this->_regionID = $regionid;
	}

	// get Employee List
	var $table = 'activities';
	var $column_order = array(null, 'a.location', 'a.region','a.district','a.district_id', 'a.snu', 'a.starts', 'a.ends', 'a.region_id','a.snu_id','a.notes');
	var $column_search = array('a.location', 'a.region','a.district','a.district_id', 'a.snu', 'a.starts', 'a.ends', 'a.region_id','a.snu_id','a.notes');
	var $order = array('activity_id' => 'DESC');

	private function getQuery() {

		//add custom filter here
		if ($this->input->post('location')) {
			$this->db->like('a.location', $this->input->post('location'), 'both');
		}
		if ($this->input->post('starts')) {
			$this->db->like('a.starts', $this->input->post('starts'), 'both');
		}
		if ($this->input->post('ends')) {
			$this->db->like('a.ends', $this->input->post('ends'), 'both');
		}
		if ($this->input->post('region')) {
			$this->db->like('a.region', $this->input->post('region'), 'both');
		}
		if ($this->input->post('district')) {
			$this->db->like('a.district', $this->input->post('district'), 'both');
		}
		$this->db->select(array('a.activity_id', 'a.location', 'a.region','a.district','a.district_id', 'a.snu', 'a.starts', 'a.ends','a.region_id','a.snu_id', 'a.notes'));

		$this->db->from('activities as a');
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

	public function getActivityData() {
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

	 // get  List
	 var $ptable = 'providerdata';
	 var $pcolumn_order = array(null, 'concat_ws(" ", e.firstname, e.surname , e.othername)', 'e.gender', 'e.email', 'e.mobile', 'e.cadre', 'e.facility', 'e.district', 'e.region');
	 var $pcolumn_search = array('concat_ws(" ", e.firstname, e.surname)', 'e.mobile', 'e.cadre', 'e.facility', 'e.district');
	 var $porder = array('pid' => 'DESC');
 
	 private function getEmpQuery()
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
		 if ($this->input->post('facility')) {
			 $this->db->like('e.facility', $this->input->post('facility'), 'both');
		 }
		 if ($this->input->post('district')) {
			 $this->db->like('e.district', $this->input->post('district'), 'both');
		 }
 
		 $this->db->select(array('e.pid', 'concat_ws(" ", e.firstname, e.surname , e.othername) as fullname', 'e.gender', 'e.email', 'e.mobile', 'e.cadre', 'e.facility', 'e.district', 'e.region'));
 
		 $this->db->from('providerdata as e');
		 
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
		 }
		 
		 if($_POST['order']) // here order processing
		 {
			 $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		 } 
		 else if($this->porder)
		 {
			 $porder = $this->porder;
			 $this->db->order_by(key($porder), $porder[key($porder)]);
		 }
	 }

	public function getEmpData()
    {
        $this->getEmpQuery();
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
        return $query->result_array();
	}
	public function pcountFiltered() {
		$this->getEmpQuery();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function pcountAll() {
		$this->db->from($this->ptable);
		return $this->db->count_all_results();
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

	
	public function createActivity() {
		$data = array(
			'ends' => $this->_ends,
			'location' => $this->_location,
			'district' => $this->_district,
			'district_id' => $this->_district_id,
			'region' => $this->_region,
			'region_id' => $this->_regionID,
			'notes' => $this->_notes,
			'starts' => $this->_starts,
		);
		$this->db->insert('activities', $data);
		return $this->db->insert_id();
	}

	// update Employee
	public function updateActivity() {
		$data = array(
			'activity_id' => $this->_activityID,
			'ends' => $this->_ends,
			'location' => $this->_location,
			'district' => $this->_district,
			'district_id' => $this->_district_id,
			'region' => $this->_region,
			'region_id' => $this->_regionID,
			'notes' => $this->_notes,
			'starts' => $this->_starts,
		);
		$this->db->where('activity_id', $this->_activityID);
		$this->db->update('activities', $data);
		//return $this->db->affected_rows();
	}
	// for display Employee
	public function getActivity() {
		$this->db->select(array('a.activity_id','a.location', 'a.region', 'a.snu', 'a.starts', 'a.ends','a.region_id', 'a.snu_id','a.district','a.district_id', 'a.notes'));
		$this->db->from('activities as a');
		$this->db->where('a.activity_id', $this->_activityID);
		$query = $this->db->get();

		//log_message('debug', print_r($this->_empID, TRUE));

		return $query->row_array();
	}

	public function get_activities() {
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	
	public function getActivityName() {
		$this->db->select('concat_ws(" - ", a.location, a.starts, a.ends) as activityname');
		$this->db->from('activities as a');
		$this->db->where('a.activity_id', $this->_activityID);
		$query = $this->db->get();

		//log_message('debug', print_r($this->_empID, TRUE));

		return $query->result_array();
	}
    
	// delete Activity
	public function deleteActivity() {
		$this->db->where('activity_id', $this->_activityID);

		if(!$this->db->delete('activities')){
            $error = $this->db->error();
            $result = $error['message'];
        } else if (!$this->db->affected_rows()) {
            $result = 'Error! ID [' . $this->_activityID . '] not found';
        } else {
            $result = 'Success';
        }
		return $result;
	}

	public function delete_by_id($id, $activity_id) {
		$this->db->where('pid', $id);
		$this->db->where('activity_id', $activity_id);

		if(!$this->db->delete('person_activities')){
            $error = $this->db->error();
            $result = $error['message'];
        } else if (!$this->db->affected_rows()) {
            $result = 'Error! ID [' . $this->_activityID . '] not found';
        } else {
            $result = 'Success';
        }
		return $result;
	}

}
?>