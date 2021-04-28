<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Activities_mdl extends CI_Model {

	public function __construct() {

		parent::__construct();

	}

	public function getactivities($activity_id = null) {
		$this->db->select('*');
		$this->db->from('providerdata');
		$this->db->join('clk_log', 'providerdata.pid = clk_log.pid', 'Left');
		if($activity_id != null){
			$this->db->where('activity_id' , $activity_id);
		}
		$this->db->group_by('clk_log.date');
		$ppQry = $this->db->get();
		$people = $ppQry->result();

		//log_message('debug', print_r($this->db->last_query(), TRUE));
		
		$activitiesArray = array();

		foreach ($people as $person) {
			$this->db->select('time_in,time_out,date');
			$this->db->where('pid', $person->pid);
			if($activity_id != null){
				$this->db->where('activity_id' , $activity_id);
			}
			$this->db->group_by('date');
			$actQry = $this->db->get('clk_log');

			$this->db->select('account_no,bank_name,bank_code,branch_name,branch_code');
			$this->db->where('pid', $person->pid);
			$bankQry = $this->db->get('bank_details');
			$act = array("data" => $person, "activity" => $actQry->result_array(), "bank_details" => $bankQry->result_array());
			$activitiesArray[$person->pid] = $act;

		}

		return $activitiesArray;
	}

}

?>