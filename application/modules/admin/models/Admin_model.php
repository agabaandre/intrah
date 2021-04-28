<?php

/******************************************
 *      Codeigniter 3 Simple Login         *
 *   Developer  :  rudiliucs1@gmail.com    *
 *        Copyright © 2017 Rudi Liu        *
 */

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Admin_model extends CI_Model {

	function __construct() {

		parent::__construct();

	}

	function list_activities_scheduled($month = FALSE, $year = FALSE) {

		$date = $year . "-" . $month;

		if ($date) {

			$this->db->select('activity_id', 'location', 'starts', 'ends');
			$this->db->like('starts', $date);
			$this->db->or_like('ends', $date);
			$query = $this->db->get('activities');

			//$query = $this->db->query("select distinct(providerdata.facility),providerdata.district from duty_rosta,providerdata where duty_rosta.duty_date like '$date%' and duty_rosta.facility_id=providerdata.facility_id");

		} else {

			$this->db->select('activity_id', 'location', 'starts', 'ends');
			//$this->db->like('starts', $date);
			//$this->db->or_like('ends', $date);
			$query = $this->db->get('activities');

			//$query = $this->db->query("select distinct providerdata.facility ,providerdata.district from providerdata,duty_rosta where duty_rosta.duty_date like '$date%' and providerdata.district_id='$district' and duty_rosta.facility_id=providerdata.facility_id");
			//  $this->db->select(providerdata.facility)
			//  $this->db->where('time_log.facility_id',$facility);
			//  $this->db->join("providerdata","providerdata.ihris_pid=time_log.ihris_pid");
			//     $query=$this->db->get("time_log");

		}

		return $query->result();
	}

	function get_user_list($start, $limit, $key = FALSE) {
		if ($key) {
			$this->db->where("username like '$key%'");
		}

		$this->db->select('*');
		$this->db->from('user');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result_array();
	}

	function countuserList($key = FALSE) {
		if ($key) {
			$this->db->where("username like '$key%'");
		}

		$query = $this->db->get('user');
		$count = $query->num_rows();
		return $count;
	}

	function get_vars() {
		$this->db->select('*');
		$this->db->from('variables');
		$query = $this->db->get();
		return $query->result_array();
	}

	function save_config($postData) {

		$this->db->select('*');
		$this->db->from('variables');
		$query = $this->db->get();

		$vars = $query->result_array();

		$changes = "<font color='red'>";

		foreach ($vars as $var) {

			$row = $var['rowid'];
			$value = $postData[$row];

			$this->db->query("UPDATE `variables` SET `content` = '$value' WHERE `variables`.`rowid`='$row'");

			if (!($var['content'] == $value)) {

				$changes .= $var['content'] . " to " . $value . " | ";

			}

		}

		$changes .= "</font>";

		$module = "System Configuration";
		$activity = "Made Changes to the system variables, changed: " . $changes;
		$this->insert_log($activity, $module);

		return "Changes Saved";

	}

	function get_user_by_id($userID) {
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user_id', $userID);
		$query = $this->db->get();
		return $query->result_array();
	}

	function validate_email($postData) {
		$this->db->where('email', $postData['email']);
		$this->db->where('status', 1);
		$this->db->from('user');
		$query = $this->db->get();

		if ($query->num_rows() == 0) {
			return true;
		} else {
			return false;
		}

	}

	function countregionsList($key = FALSE) {
		if ($key) {
			$this->db->where("region like '$key%'");
		}

		$query = $this->db->get('regions');
		$count = $query->num_rows();
		return $count;
	}

	function get_regions_list($start, $limit, $key = FALSE) {
		if ($key) {
			$this->db->where("region like '$key%'");
		}

		$this->db->select('*');
		$this->db->from('regions');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result_array();
	}

	function insert_region($postData) {

			$data = array(
				'region' => $postData['region'],
			);
			$this->db->insert('regions', $data);

			$module = "Regions";
			$activity = "add new region " . $postData['region'];
			$this->insert_log($activity, $module);

			return array('status' => 'success', 'message' => '');
	}
	function update_region($postData) {

			$data = array(
				'region' => $postData['region'],
			);

			$this->db->where('id', $postData['id']);
			$this->db->update('regions', $data);

			$module = "Region";
			$activity = "update Region " . $postData['region'] . "`s details " ;
			$this->insert_log($activity, $module);
			return array('status' => 'success', 'message' => '');
	}

	
	function countdistrictsList($key = FALSE) {
		if ($key) {
			$this->db->where("district like '$key%'");
		}

		$query = $this->db->get('districts');
		$count = $query->num_rows();
		return $count;
	}

	function get_districts_list($start, $limit, $key = FALSE) {
		if ($key) {
			$this->db->where("district like '$key%'");
		}

		$this->db->select('*');
		$this->db->from('districts');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result_array();
	}

	function insert_district($postData) {

			$data = array(
				'district_name' => $postData['district'],
			);
			$this->db->insert('districts', $data);

			$module = "Districts";
			$activity = "add new district " . $postData['district'];
			$this->insert_log($activity, $module);

			return array('status' => 'success', 'message' => '');
	}
	function update_district($postData) {

			$data = array(
				'district_name' => $postData['district'],
			);

			$this->db->where('id', $postData['id']);
			$this->db->update('districts', $data);

			$module = "District";
			$activity = "update District " . $postData['district'] . "`s details " ;
			$this->insert_log($activity, $module);
			return array('status' => 'success', 'message' => '');
	}

	function countsnusList($key = FALSE) {
		if ($key) {
			$this->db->where("snu like '$key%'");
		}

		$query = $this->db->get('snus');
		$count = $query->num_rows();
		return $count;
	}

	function get_snus_list($start, $limit, $key = FALSE) {
		if ($key) {
			$this->db->where("snu like '$key%'");
		}

		$this->db->select('*');
		$this->db->from('snus');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result_array();
	}

	function insert_snu($postData) {

			$data = array(
				'snu' => $postData['snu'],
			);
			$this->db->insert('snus', $data);

			$module = "SNU";
			$activity = "add new SNU " . $postData['snu'];
			$this->insert_log($activity, $module);

			return array('status' => 'success', 'message' => '');
	}
	function update_snu($postData) {

			$data = array(
				'snu' => $postData['snu'],
			);

			$this->db->where('id', $postData['id']);
			$this->db->update('snus', $data);

			$module = "SNU";
			$activity = "update SNU " . $postData['snu'] . "`s details " ;
			$this->insert_log($activity, $module);
			return array('status' => 'success', 'message' => '');
	}

	function countpholidayList($key = FALSE) {
		if ($key) {
			$this->db->where("public_holiday like '$key%'");
		}

		$query = $this->db->get('public_holidays');
		$count = $query->num_rows();
		return $count;
	}

	function get_public_holidays_list($start, $limit, $key = FALSE) {
		if ($key) {
			$this->db->where("public_holiday like '$key%'");
		}

		$this->db->select('*');
		$this->db->from('public_holidays');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result_array();
	}

	function insert_public_holiday($postData) {

			$data = array(
				'public_holiday' => $postData['public_holiday'],
				'date' => $postData['date'],
			);
			$this->db->insert('public_holidays', $data);

			$module = "Public Holiday";
			$activity = "add new Public Holiday " . $postData['public_holiday'];
			$this->insert_log($activity, $module);

			return array('status' => 'success', 'message' => '');
	}
	function update_public_holiday($postData) {

			$data = array(
				'public_holiday' => $postData['public_holiday'],
				'date' => $postData['date'],
			);

			$this->db->where('id', $postData['id']);
			$this->db->update('public_holidays', $data);

			$module = "Public Holiday";
			$activity = "update Public Holiday " . $postData['public_holiday'] . "`s details " ;
			$this->insert_log($activity, $module);
			return array('status' => 'success', 'message' => '');
	}

	function insert_user($postData, $uid) {

		$validate = $this->validate_email($postData);

		if ($validate) {
			//$password = $this->generate_password();

			$password = $postData['password'];

			$data = array(
				'email' => $postData['email'],
				'name' => $postData['name'],
				'username' => $postData['username'],
				'role' => $postData['role'],
				'password' => md5($postData['password']),
				'created_at' => date('Y\-m\-d\ H:i:s A'),
				'auth_id' => $uid,
			);
			$this->db->insert('user', $data);

			$module = "User Management";
			$activity = "add new user " . $postData['email'];
			$this->insert_log($activity, $module);

			return array('status' => 'success', 'message' => '');

		} else {
			return array('status' => 'exist', 'message' => '');
		}

	}

	function update_user_details($postData) {

		$oldData = $this->get_user_by_id($postData['id']);

		if ($oldData[0]['email'] == $postData['email']) {
			$validate = true;
		} else {
			$validate = $this->validate_email($postData);
		}

		if ($validate) {
			$data = array(
				'email' => $postData['email'],
				'name' => $postData['name'],
				'role' => $postData['role'],
				'username' => $postData['username'],
			);

			$this->db->where('user_id', $postData['id']);
			$this->db->update('user', $data);

			$record = "(" . $oldData[0]['email'] . " to " . $postData['email'] . ", " . $oldData[0]['name'] . " to " . $postData['name'] . "," . $oldData[0]['role'] . " to " . $postData['role'] . ")";

			$module = "User Management";
			$activity = "update user " . $oldData[0]['email'] . "`s details " . $record;
			$this->insert_log($activity, $module);
			return array('status' => 'success', 'message' => $record);
		} else {
			return array('status' => 'fail', 'message' => '');
		}

	}

	function deactivate_user($username, $id) {

		$data = array(
			'status' => 0,
		);

		$this->db->where('user_id', $id);
		$this->db->update('user', $data);

		$module = "User Management";

		$activity = "Block user " . $username;

		$this->insert_log($activity, $module);

		return array('status' => 'success', 'message' => '');

	}

	function activate_user($username, $id) {

		$data = array(
			'status' => 1,
		);

		$this->db->where('user_id', $id);
		$this->db->update('user', $data);

		$module = "User Management";

		$activity = "Activate user " . $username;

		$this->insert_log($activity, $module);

		return array('status' => 'success', 'message' => '');

	}

	function reset_user_password($email, $id) {

		$password = $this->input->post();
		$data = array(
			'password' => md5($password),
		);
		$this->db->where('user_id', $id);
		$this->db->update('user', $data);

		return array('status' => 'success', 'message' => '');

	}

	function generate_password() {
		$chars = "abcdefghjkmnopqrstuvwxyzABCDEFGHJKMNOPQRSTUVWXYZ023456789!@#$%^&*()_=";
		$password = substr(str_shuffle($chars), 0, 10);

		return $password;
	}

	function insert_log($activity, $module) {

		$id = $this->session->userdata('user_id');

		$data = array(
			'fk_user_id' => $id,
			'activity' => $activity,
			'module' => $module,
			'created_at' => date('Y\-m\-d\ H:i:s A'),
		);
		$this->db->insert('activity_log', $data);
	}

	public function get_logs() {

		$this->db->join("user", "user.user_id=activity_log.fk_user_id");
		$query = $this->db->get("activity_log");

		return $query->result();

	}

	public function clearLogs() {
		$this->db->empty_table('activity_log');

		$module = "Activity Logs";
		$activity = "Cleared all activity Logs";
		$this->insert_log($activity, $module);

	}

}

/* End of file */
