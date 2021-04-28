<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_model extends CI_Model {

	public function __construct() {

		parent::__construct();

		//if not logged in, go to login page
		if (!$this->session->userdata('logged_in')) {
			redirect(base_url());
		}

		$this->username = $this->session->userdata['names'];

	}


	public function get_facility() {
		$district = $_SESSION['district'];

		if ($district !== "") {
			$query = $this->db->query("select distinct facility_id,facility,district_id from providerdata where district_id='$district' order by facility asc");

		} else {
			$query = $this->db->query("select distinct facility_id,facility,district_id from providerdata order by facility asc");

		}

		$res = $query->result_array();

		return $res;

	}

	public function get_districts() {

		$query = $this->db->query("select distinct district_id,district from providerdata order by district_id asc");

		$res = $query->result_array();

		return $res;

	}

	public function get_providers() {

		$query = $this->db->query("select pid,surname,firstname,othername,cadre,mobile,facility,facility_id from  providerdata");

		$result = $query->result_array();

		return $result;

	}

	public function template_data() {

		$facility = $this->facility;

		$query = $this->db->query("select providerdata.pid,concat(providerdata.surname,' ',providerdata.surname) as names from providerdata where (providerdata.facility_id='$facility') group by providerdata.pid ");

		$result = $query->result_array();

		return $result;
	}

	public function widget_data() {

		$facility = $this->facility;

		if ($_SESSION['role'] !== 'sadmin') {

			$query1 = $this->db->query("select count(activity_id) as activities from activities ");

			$result1 = $query1->result_array();

			$schedules = $result1[0]['activities'];

			$query2 = $this->db->query("select count(user.username) as users from user ");

			$result2 = $query2->result_array();

			$users = $result2[0]['users'];

			$query3 = $this->db->query("select count(providerdata.pid) as staff from providerdata");

			$result3 = $query3->result_array();

			$staff = $result3[0]['staff'];

			$date = date('Y-m'); // this month for gettting schedules

			$result = array("activities" => $schedules, "users" => $users, "staff" => $staff);
		} else {

			$query1 = $this->db->query("select count(activity_id) as activities from activities ");

			$result1 = $query1->result_array();

			$activities = $result1[0]['activities'];

			$query2 = $this->db->query("select count(user.username) as users from user ");

			$result2 = $query2->result_array();

			$users = $result2[0]['users'];

			$query3 = $this->db->query("select count(providerdata.pid) as staff from providerdata  ");

			$result3 = $query3->result_array();

			$staff = $result3[0]['staff'];

			$date = date('Y-m'); // this month for gettting schedules

			$result = array("activities" => $activities, "users" => $users, "staff" => $staff);

		}

		return $result;
	}

	function get_vars() {

		$this->db->from("variables");
		$this->db->order_by("variable", "desc");
		$this->db->group_by('rowid');
		$query = $this->db->get();
		return $query->result_array();

	}

	
	//get total rows to use in pagination of timelogs
	public function count_timelogs() {
		//$this->db->where('activity_id', $this->activity);
		$query = $this->db->get('clk_log');
		return $query->num_rows();

	}

	public function fetchTimeLogs($limit, $start, $search_data = FALSE) {
		$query = $this->db->query("INSERT INTO actuals (date, entry_id, pid, activity_id)
		SELECT clk_log.date, clk_log.entry_id, clk_log.pid, activities.activity_id
		FROM clk_log,activities where clk_log.entry_id NOT IN (select entry_id from actuals)");

		//$activity = $this->activity; //current activity

		$search_data = $this->input->post();

		if ($search_data) {
			$date_from = $search_data['date_from'];
			$date_to = $search_data['date_to'];
			$name = $search_data['name'];

			if ($name) {

				$ids = $this->getIds($name);

				if (count($ids) > 0) {

					$this->db->where_in('clk_log.pid', $ids);
				}
			}

		} else {
			$date_from = date('Y-m-d');
			$date_to = date('Y-m-d');

		}
		$this->db->where("date >= '$date_from' AND date <= '$date_to'");
		$this->db->limit($limit, $start);
		//$this->db->where('clk_log.activity_id', $activity);
		// $this->db->query->order_by ('date', 'asc');
		$this->db->join("providerdata", "providerdata.pid=clk_log.pid");
		$query = $this->db->get("clk_log");
		return $query->result();
	}
	public function count_fingerprints() {
		$this->db->where('fingerprint is NOT NULL', NULL, FALSE);
		//$this->db->where('fingerprint', $this->activity);
		$query = $this->db->get('providerdata');
		return $query->num_rows();

	}
	public function deleteFinger($id) {
		//$activity = $this->activity;
		$this->db->set('fingerprint', null);
		$this->db->where('pid', $id);
		//$this->db->where('activity_id', $activity);
		$this->db->delete('providerdata');

	}

	public function fingerprints($limit, $start, $search_data = FALSE) {

		$search_data = $this->input->post();

		if ($search_data) {
			$name = $search_data['name'];

			if ($name) {

				$ids = $this->getIds($name);

				if (count($ids) > 0) {

					$this->db->where_in('providerdata.pid', $ids);
				}
			}

		}
		$this->db->where('fingerprint <> ', '');
		$this->db->limit($limit, $start);
		//$this->db->where('fingerprints.activity_id', $activity);
		// $this->db->query->order_by ('date', 'asc');
		$query = $this->db->get("providerdata");
		log_message('debug', print_r($this->db->last_query(), TRUE));
		
		return $query->result();
	}

	public function getIds($name) {

		//$activity = $this->activity; //current $activity
		$this->db->select('pid');
		//$this->db->where('providerdata.activity_id', $activity);
		$this->db->where("firstname like '%$name%'");
		$this->db->or_where("surname like '%$name' ");
		$query = $this->db->get('providerdata');
		$result = $query->result();
		$ids = array();
		foreach ($result as $row) {

			array_push($ids, $row->pid);
		}

		return $ids;

	}

}
