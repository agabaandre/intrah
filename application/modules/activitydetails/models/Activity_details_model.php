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

class Activity_details_model extends CI_Model {

	private $_activityID;
	private $_siteID;
	private $_siteName;

	public function setActivityID($activityID) {
		$this->_activityID = $activityID;
	}
	public function setSiteID($siteID) {
		$this->_siteID = $siteID;
	}
	public function setSiteName($siteName) {
		$this->_siteName = $siteName;
	}

	 // get  List
	 var $ptable = 'providerdata';
	 var $pcolumn_order = array(null, 'concat_ws(" ", e.firstname, e.surname , e.othername)', 'e.gender', 'e.email', 'e.mobile', 'e.cadre', 'e.facility', 'e.district');
	 var $pcolumn_search = array('concat_ws(" ", e.firstname, e.surname)', 'e.mobile', 'e.cadre', 'e.facility', 'e.district');
	 var $order = array('pid' => 'ASC');

	var $table = 'activity_sites';
	var $column_order = array(null, 's.activity_id', 's.siteName',);
	var $column_search = array('s.siteName');
	var $sorder = array('sid' => 'ASC');

	private function getQuery() {

		//add custom filter here
		if ($this->input->post('siteName')) {
			$this->db->like('s.siteName', $this->input->post('siteName'), 'both');
		}

		$this->db->select(array('s.sid', 's.activity_id', 's.siteName'));

		$this->db->from('activity_sites as s');
		$this->db->where('s.activity_id', $this->_activityID);

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
		} else if ($this->sorder) {
			$sorder = $this->sorder;
			$this->db->order_by(key($sorder), $sorder[key($sorder)]);
		}
	}

	public function getSiteData() {
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
	
	public function scountFiltered() {
		$this->getQuery();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function scountAll() {
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function getSite() {
		$this->db->select(array('s.sid', 's.activity_id', 's.siteName'));
		$this->db->from('activity_sites as s');
		$this->db->where('s.sid', $this->_siteID);
		$query = $this->db->get();

		//log_message('debug', print_r($this->_empID, TRUE));

		return $query->row_array();
	}
	public function createSite() {
		$data = array(
			'siteName' => $this->_siteName,
			'activity_id' => $this->_activityID,
		);
		$this->db->insert('activity_sites', $data);
		return $this->db->insert_id();
	}
	public function updateSite() {
		$data = array(
			'activity_id' => $this->_activityID,
			'sid' => $this->_siteID,
			'siteName' => $this->_siteName,
		);
		$this->db->where('sid', $this->_siteID);
		$this->db->update('activity_sites', $data);
		//return $this->db->affected_rows();
	}
    // delete site
	public function deleteSite() {
		$this->db->where('sid', $this->_siteID);

		if(!$this->db->delete('activity_sites')){
            $error = $this->db->error();
            $result = $error['message'];
        } else if (!$this->db->affected_rows()) {
            $result = 'Error! ID [' . $this->_siteID . '] not found';
        } else {
            $result = 'Success';
        }
		return $result;
	}
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
		 if ($this->input->post('district')) {
			 $this->db->like('e.district', $this->input->post('district'), 'both');
		 }
 
		 $this->db->select(array('e.pid', 'concat_ws(" ", e.firstname, e.surname , e.othername) as fullname', 'e.gender', 'e.email', 'e.mobile', 'e.cadre', 'e.facility', 'e.district'));
 
		 $this->db->from('providerdata as e');
		 
		 $i = 0;
	 
		 foreach ($this->pcolumn_search as $item) // loop column 
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
 
				 if(count($this->pcolumn_search) - 1 == $i) //last loop
					 $this->db->group_end(); //close bracket
			 }
			 $i++;
		 }
		 
		 if($_POST['order']) // here order processing
		 {
			 $this->db->order_by($this->pcolumn_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		 } 
		 else if($this->order)
		 {
			 $order = $this->order;
			 $this->db->order_by(key($order), $order[key($order)]);
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
    
    private function getAttendEmpQuery()
	 {
		 $this->db->select('activity_id');
		 $this->db->where('sid', $this->_siteID);
		 $query = $this->db->get('activity_sites');
		 $data = $query->row_array();
		 $this->_activityID = $data['activity_id'];
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
		 
 
		 $this->db->select(array('e.pid', 'concat_ws(" ", e.firstname, e.surname , e.othername) as fullname', 'e.gender', 'e.email', 'e.mobile', 'e.cadre', 'e.facility', 'e.district'));
 
         $this->db->from('providerdata as e');
         $this->db->join('person_activities as b', 'e.pid = b.pid', 'Left');
		 $this->db->where('b.activity_id', $this->_activityID);
		 $this->db->where('b.sid', $this->_siteID);
		 
		 $i = 0;
	 
		 foreach ($this->pcolumn_search as $item) // loop column 
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
 
				 if(count($this->pcolumn_search) - 1 == $i) //last loop
					 $this->db->group_end(); //close bracket
			 }
			 $i++;
		 }
		 
		 if($_POST['order']) // here order processing
		 {
			 $this->db->order_by($this->pcolumn_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		 } 
		 else if($this->order)
		 {
			 $order = $this->order;
			 $this->db->order_by(key($order), $order[key($order)]);
		 }
	 }

    public function getAttendEmpData()
    {
        //log_message('debug', print_r("Activity ID= " . $this->_activityID, TRUE));
        $this->getAttendEmpQuery();
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
	public function acountFiltered() {
		$this->getAttendEmpQuery();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function acountAll() {
		$this->db->from($this->ptable . ' as e');
		$this->db->join('person_activities as b', 'e.pid = b.pid', 'Left');
		return $this->db->count_all_results();
	}

	// for display Employee
	public function getActivity() {
		$this->db->select(array('a.activity_id', 'a.location', 'a.starts', 'a.ends'));
		$this->db->from('activities as a');
        $this->db->where('a.activity_id', $this->_activityID);
		$query = $this->db->get();

		//log_message('debug', print_r($this->_empID, TRUE));

		return $query->row_array();
	}

	public function getActivityName($id) {
		$this->db->select(array('a.location', 'a.starts', 'a.ends'));
		//$this->db->from('activities as a');
        $this->db->where('a.activity_id', $id);
        $this->db->limit(1);
		$query = $this->db->get('activities as a');

		//log_message('debug', print_r($query->row_array(), TRUE));

		return $query->result_array();
	}

	public function getActivitySiteName($id) {
		$this->db->select(array('a.activity_id','a.location', 'a.starts', 'a.ends' ,'s.siteName','s.sid'));
		$this->db->from('activities as a');
		$this->db->join('activity_sites as s','a.activity_id = s.activity_id', 'Left');
        $this->db->where('s.sid', $id);
        $this->db->limit(1);
		$query = $this->db->get();
		return $query->result_array();
	}
  
	public function add_by_id($id, $activity_id, $sid) {

        $this->db->where('pid', $id);
        $this->db->where('activity_id', $activity_id);
        $select_query = $this->db->get('person_activities');
        $this->db->reset_query();
        
        if ( $select_query->num_rows() > 0 ) 
        {
        //ignore
        } else {
            $data = array(
                'pid' => $id,
				'activity_id' => $activity_id,
				'sid' => $sid
            );
            $this->db->insert('person_activities', $data);
        }
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