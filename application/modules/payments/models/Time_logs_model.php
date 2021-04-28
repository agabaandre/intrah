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

class Time_logs_model extends CI_Model {

	private $_empID;
	private $_empDetailsID;
	private $_activityID;

	public function setEmpID($empID) {
		$this->_empID = $empID;
	}
	public function setEmpDetailsID($empDetailsID) {
		$this->_empDetailsID = $empDetailsID;
	}
	public function setActivityID($activityID) {
		$this->_activityID = $activityID;
	}
	

	// get Employee List
    var $table = 'clk_log';
	var $activitiestable = 'activities';
	var $providertable = 'providerdata';
	var $column_order = array(null, 'concat_ws(" ", e.firstname, e.surname , e.othername)', 'b.date', 'b.time_in', 'b.time_out', 'ROUND(TIME_TO_SEC(TIMEDIFF(time_out, time_in))/3600, 0) as hours', 'b.location');
	var $column_search = array('concat_ws(" ", e.firstname, e.surname, e.othername)');
	var $order = array('b.activity_id' => 'DESC', 'surname' => 'DESC' );

	private function getQuery() {

        //add custom filter here
		if ($this->input->post('fullname')) {
			$this->db->like('concat_ws(" ", e.firstname, e.surname , e.othername)', $this->input->post('fullname'), 'both');
		}
		if ($this->input->post('siteName')) {
			$this->db->like('s.siteName', $this->input->post('siteName'), 'both');
		}
		if ($this->input->post('date')) {
			$this->db->like('b.date', $this->input->post('date'), 'both');
		}
		$this->db->select(array('e.pid', 'concat_ws(" ", e.firstname, e.surname , e.othername) as fullname', 'b.date', 'b.time_in', 'b.time_out', 'ROUND(TIME_TO_SEC(TIMEDIFF(time_out, time_in))/3600, 0) as hours', 'b.location'));

		$this->db->from('clk_log as b');
		$this->db->join('providerdata as e', 'e.pid = b.pid', 'LEFT');
		$this->db->join('activity_sites as s', 'b.activity_id = s.sid', 'LEFT');
		
        if($this->input->post('activity'))
        {
            $this->db->where('b.activity_id', $this->input->post('activity'));
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

	public function getData() {
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
        $this->db->join($this->providertable . ' as e', 'e.pid = b.pid','Right');
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
			$datetime1 = date_create($row->starts);
			$datetime2 = date_create($row->ends);
			$interval = date_diff($datetime1, $datetime2);	
            $activityname = $row->location ." - ". date("jS F Y", strtotime($row->starts)) . " - " . date("jS F Y", strtotime($row->ends));
            $activities[$row->activity_id] = $activityname;
        }
        return $activities;
	}
	
	public function get_activity_days($activity_id)
    {
        $this->db->select(array('activity_id', 'location', 'starts', 'ends'));
		$this->db->from($this->activitiestable);
		$this->db->where('activity_id',$activity_id);
        $this->db->order_by('activity_id','DESC');
        $query = $this->db->get();
        $result = $query->result();
    //log_message('debug', print_r($this->db->last_query(), TRUE));
        $activities = array();
        foreach ($result as $row) 
        {
			$datetime1 = date_create($row->starts);
			$datetime2 = date_create($row->ends);
			$interval = date_diff($datetime1, $datetime2);	
            //$activityname = $row->location ." - ". date("jS F Y", strtotime($row->starts)) . " - " . date("jS F Y", strtotime($row->ends));
			
			$activities['number_of_days'] = $interval->format('%a') + 1;
			$activities['startdate'] = $row->starts;
			$activities['enddate'] = $row->ends;
			//log_message('debug', print_r("number of days = ".$activities, TRUE));
			
        }
        return $activities;
	}
	
	public function get_days($activity_id)
    {
        $this->db->select(array('activity_id', 'location', 'starts', 'ends'));
		$this->db->from($this->activitiestable);
		$this->db->where('activity_id',$activity_id);
        $this->db->order_by('activity_id','DESC');
        $query = $this->db->get();
        $result = $query->result();
    //log_message('debug', print_r($this->db->last_query(), TRUE));
        $activities = array();
        foreach ($result as $row) 
        {
			$activities['startdate'] = $row->starts;
			$activities['enddate'] = $row->ends;
			
        }
        return $activities;
    }

	//Get Rates
	public function getRates() {
		$this->db->select(array('content','short_name'));
		$this->db->from('variables');
		$this->db->where_in('short_name',array('provider','support'));
		$query = $this->db->get();
		return $query->result();
	}
	public function getDebitAccount() {
		$this->db->select(array('content','short_name'));
		$this->db->from('variables');
		$this->db->where_in('short_name',array('debit_account','city_code','country_code'));
		$query = $this->db->get();
		return $query->result();
	}
	public function get_activity_weekenddays($activity_id)
    {
        $this->db->select(array('activity_id', 'location', 'starts', 'ends'));
		$this->db->from($this->activitiestable);
		$this->db->where('activity_id',$activity_id);
        $this->db->order_by('activity_id','DESC');
        $query = $this->db->get();
        $result = $query->result();
    //log_message('debug', print_r($this->db->last_query(), TRUE));
        $num_of_days = 0;
        foreach ($result as $row) 
        {
			$startDate = strtotime($row->starts); 
			$endDate = strtotime($row->ends);
			while($startDate <= $endDate ){
				$what_day=date("N",$startDate);
				//log_message('debug', print_r("What day - ".$what_day, TRUE));
				if($what_day>5) { // 6 and 7 are weekend days
					//log_message('debug', print_r("Is Weekend - ".$what_day, TRUE));
					$num_of_days++;
				};
				$startDate+=86400; // +1 day
			}	
		}
		//log_message('debug', print_r("Total Weekend days - ".$num_of_days, TRUE));
        return $num_of_days;
	}
	public function get_public_holidays($start,$end)
    {
		$startDate = strtotime($start);
		$endDate = strtotime($end);
		$this->db->select(array('date'));
		$this->db->from('public_holidays');
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        $result = $query->result();
        $num_of_days = 0;
        foreach ($result as $row) 
        {
			$publicHoliday = strtotime($row->date);
			if($startDate <= $publicHoliday  && $publicHoliday <= $endDate ){
				$num_of_days++;
			}	
		}
        return $num_of_days;
    }

}
?>