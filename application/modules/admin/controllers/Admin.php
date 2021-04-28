<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Admin extends MX_Controller
{
    public function __construct()
    {
        parent::__Construct();

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url());
        }

        $this->load->library('pagination');
        $this->load->model('admin_model');
        $this->load->model('attendance_model');

        $this->username = $this->session->userdata['names'];
        $this->uid = $this->session->userdata['uid'];
        $user_details = $this->aauth->get_user_groups($this->uid);
        foreach ($user_details as $detail) {
            $this->mygroup = $detail->id;
        }
    }

    private function ajax_checking()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url());
        }
    }

    public function regions_list()
    {
        $key = $this->input->post('search_key');
        if (empty($key)) {
            $key = false;
        }

        $config = [];
        $config['base_url'] = base_url() . "admin/regions_list";
        $config['total_rows'] = $this->admin_model->countregionsList($key);
        $config['per_page'] = 15; //records per page
        $config['uri_segment'] = 3; //segment in url
        $data['key'] = $key;

        //pagination links styling
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = '<i class="fa fa-long-arrow-right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = $this->uri->segment(3) ? $this->uri->segment(3) : 0; //default starting point for limits

        $data = [
            'title' => 'Regions',
            'regions' => $this->admin_model->get_regions_list(
                $page,
                $config["per_page"],
                $key
            ),
            'links' => $this->pagination->create_links(),
            'username' => $this->username,
            //'switches'=>$this->switches()
        ];

        $this->load->view('regions', $data);
    }
    function add_region()
    {
        $this->ajax_checking();

        $postData = $this->input->post();

        $insert = $this->admin_model->insert_region($postData);

        echo json_encode($insert);
    }

    function edit_region()
    {
        $this->ajax_checking();

        $postData = $this->input->post();
        $update = $this->admin_model->update_region($postData);

        if ($update['status'] == 'success') {
            echo json_encode($update);
        }
    }

    public function districts_list()
    {
        $key = $this->input->post('search_key');
        if (empty($key)) {
            $key = false;
        }

        $config = [];
        $config['base_url'] = base_url() . "admin/districts_list";
        $config['total_rows'] = $this->admin_model->countdistrictsList($key);
        $config['per_page'] = 15; //records per page
        $config['uri_segment'] = 3; //segment in url
        $data['key'] = $key;

        //pagination links styling
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = '<i class="fa fa-long-arrow-right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = $this->uri->segment(3) ? $this->uri->segment(3) : 0; //default starting point for limits

        $data = [
            'title' => 'Districts',
            'districts' => $this->admin_model->get_districts_list(
                $page,
                $config["per_page"],
                $key
            ),
            'links' => $this->pagination->create_links(),
            'username' => $this->username,
            //'switches'=>$this->switches()
        ];

        $this->load->view('districts', $data);
        //$this->load->view('districts_test', $data);
    }
    function add_district()
    {
        $this->ajax_checking();

        $postData = $this->input->post();

        $insert = $this->admin_model->insert_district($postData);

        echo json_encode($insert);
    }

    function edit_district()
    {
        $this->ajax_checking();

        $postData = $this->input->post();
        $update = $this->admin_model->update_district($postData);

        if ($update['status'] == 'success') {
            echo json_encode($update);
        }
    }

    public function snus_list()
    {
        $key = $this->input->post('search_key');
        if (empty($key)) {
            $key = false;
        }

        $config = [];
        $config['base_url'] = base_url() . "admin/snus_list";
        $config['total_rows'] = $this->admin_model->countsnusList($key);
        $config['per_page'] = 15; //records per page
        $config['uri_segment'] = 3; //segment in url
        $data['key'] = $key;

        //pagination links styling
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = '<i class="fa fa-long-arrow-right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = $this->uri->segment(3) ? $this->uri->segment(3) : 0; //default starting point for limits

        $data = [
            'title' => 'SNUs',
            'snus' => $this->admin_model->get_snus_list(
                $page,
                $config["per_page"],
                $key
            ),
            'links' => $this->pagination->create_links(),
            'username' => $this->username,
            //'switches'=>$this->switches()
        ];

        $this->load->view('snus', $data);
    }
    function add_snu()
    {
        $this->ajax_checking();

        $postData = $this->input->post();

        $insert = $this->admin_model->insert_snu($postData);

        echo json_encode($insert);
    }

    function edit_snu()
    {
        $this->ajax_checking();

        $postData = $this->input->post();
        $update = $this->admin_model->update_snu($postData);

        if ($update['status'] == 'success') {
            echo json_encode($update);
        }
    }

    public function public_holidays()
    {
        $key = $this->input->post('search_key');
        if (empty($key)) {
            $key = false;
        }

        $config = [];
        $config['base_url'] = base_url() . "admin/snus_list";
        $config['total_rows'] = $this->admin_model->countpholidayList($key);
        $config['per_page'] = 15; //records per page
        $config['uri_segment'] = 3; //segment in url
        $data['key'] = $key;

        //pagination links styling
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = '<i class="fa fa-long-arrow-right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = $this->uri->segment(3) ? $this->uri->segment(3) : 0; //default starting point for limits

        $data = [
            'title' => 'Public Holidays',
            'public_holidays' => $this->admin_model->get_public_holidays_list(
                $page,
                $config["per_page"],
                $key
            ),
            'links' => $this->pagination->create_links(),
            'username' => $this->username,
            //'switches'=>$this->switches()
        ];

        $this->load->view('public_holidays', $data);
    }
    function add_public_holiday()
    {
        $this->ajax_checking();

        $postData = $this->input->post();

        $insert = $this->admin_model->insert_public_holiday($postData);

        echo json_encode($insert);
    }

    function edit_public_holiday()
    {
        $this->ajax_checking();

        $postData = $this->input->post();
        $update = $this->admin_model->update_public_holiday($postData);

        if ($update['status'] == 'success') {
            echo json_encode($update);
        }
    }

    public function user_list()
    {
        $key = $this->input->post('search_key');
        if (empty($key)) {
            $key = false;
        }

        $config = [];
        $config['base_url'] = base_url() . "admin/user_list";
        $config['total_rows'] = $this->admin_model->countuserList($key);
        $config['per_page'] = 15; //records per page
        $config['uri_segment'] = 3; //segment in url
        $data['key'] = $key;

        //pagination links styling
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = '<i class="fa fa-long-arrow-right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = $this->uri->segment(3) ? $this->uri->segment(3) : 0; //default starting point for limits

        $data = [
            'title' => 'User Management',
            'users' => $this->admin_model->get_user_list(
                $page,
                $config["per_page"],
                $key
            ),
            'links' => $this->pagination->create_links(),
            'username' => $this->username,
            'mygroup' => $this->mygroup,
            //'switches'=>$this->switches()
        ];

        $this->load->view('users', $data);
    }

    public function settings()
    {
        $data = [
            'title' => 'System Variables',
            'vars' => $this->admin_model->get_vars(),
            'username' => $this->username,
            'mygroup' => $this->mygroup,
        ];

        $this->load->view('config', $data);
    }

    public function configure()
    {
        $postData = $this->input->post();

        $res = $this->admin_model->save_config($postData);

        print_r($res);
    }

    public function showLogs()
    {
        $data = [
            'title' => 'User Activity Logs',
            'logs' => $this->admin_model->get_logs(),
            'username' => $this->username,
            'mygroup' => $this->mygroup,
        ];

        $this->load->view('user_logs', $data);
    }

    public function clearLogs()
    {
        $this->admin_model->clearLogs();

        $this->showLogs();
    }

    public function select()
    {
        $data = [
            'username' => $this->username,
        ];

        $this->load->view('select', $data);
    }

    function add_user()
    {
        $this->ajax_checking();

        $postData = $this->input->post();

        if ($postData['email'] == "") {
            $postData['email'] = $postData['username'] . "_noemail@vmmc.com";
        }
        $user = $this->aauth->create_user(
            $postData['email'],
            $postData['password'],
            $postData['name']
        );

        $users = $this->aauth->list_users();

        foreach ($users as $user) {
            if ($user->email == $postData['email']) {
                $uid = $user->id;
            }
        }

        $this->aauth->add_member($uid, $postData['role']);

        $insert = $this->admin_model->insert_user($postData, $uid);

        echo json_encode($insert);
    }

    function edit_user()
    {
        $this->ajax_checking();

        $postData = $this->input->post();
        $update = $this->admin_model->update_user_details($postData);

        if ($update['status'] == 'success') {
            echo json_encode($update);
        }
    }

    function deactivate_user($username, $id)
    {
        $update = $this->admin_model->deactivate_user($username, $id);

        if ($update['status'] == 'success') {
            echo "User successfully deactivated";
        }
    }

    function activate_user($username, $id)
    {
        $update = $this->admin_model->activate_user($username, $id);

        if ($update['status'] == 'success') {
            echo "User successfully activated";
        }
    }

    public function activities_scheduled_report()
    {
        $year = $this->input->post('year');
        $month = $this->input->post('month');

        $data = [
            'title' => 'Activities that Scheduled',
            //'districts' => $this->attendance_model->get_districts(),
            'activities' => $this->admin_model->list_activities_scheduled(
                $month,
                $year
            ),
            'username' => $this->username,
        ];

        // print_r($data);

        $this->load->view('scheduled', $data);
    }

    public function groups()
    {
        $data = [
            'title' => 'Groups Management',
            'username' => $this->username,
            'mygroup' => $this->mygroup,
            //'switches'=>$this->switches()
        ];

        $this->load->view('groups', $data);
    }

    public function resetpass($user)
    {
        $variables = $this->admin_model->get_vars();

        $pass = "";
        foreach ($variables as $vars) {
            if ($vars['variable'] == "Default Password") {
                $pass = $vars['content'];
            }
        }

        //log_message('debug', print_r("User is " .$user, TRUE));
        //log_message('debug', print_r("password is " .$pass, TRUE));

        $data = [
            'password' => md5($pass),
        ];

        $this->db->where('user_id', $user);
        $this->db->update('user', $data);

        $this->session->set_flashdata(
            'msg',
            '<div class="alert alert-info alert-dismissable col-md-12"style="width:90%; margin-left:3em;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Password has been reset to default. </div>'
        );

        redirect("admin/user_list");
    }

    public function block($user, $username)
    {
        $data = [
            'status' => 0,
        ];

        $this->db->where('user_id', $user);
        $this->db->update('user', $data);

        $module = "User Management";

        $activity = "Blocked user " . $username;

        $this->admin_model->insert_log($activity, $module);

        $this->session->set_flashdata(
            'msg',
            '<div class="alert alert-info alert-dismissable col-md-12"style="width:90%; margin-left:3em;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>User has been Deactivated. </div>'
        );

        redirect("admin/user_list");
    }

    ///user management

    function add_member()
    {
        $group = $this->input->post('group');

        $id = $this->input->post('member');

        $a = $this->aauth->add_member($id, $group);
    }

    //create a permission
    function create_perm()
    {
        $a = $this->aauth->create_perm("deneme", "def");
    }

    //allow group to do some thing
    function groupAllow()
    {
        $data = $this->input->post();
        $group = $this->input->post('group');

        $permissions = $_POST['permissions'];

        $this->db->where('group_id', $group);
        $this->db->delete('aauth_perm_to_group');

        foreach ($permissions as $permission) {
            $this->aauth->create_perm($permission);

            $a = $this->aauth->allow_group($group, $permission);
        }

        if ($a) {
            echo 'OK';
        }
    }

    //

    function deny_group()
    {
        $a = $this->aauth->deny_group("deneme", "deneme");
    }

    function allow_user()
    {
        //allow user id =9 to do something=deneme
        $a = $this->aauth->allow_user(9, "deneme");
    }

    function deny_user()
    {
        $a = $this->aauth->deny_user(9, "deneme");
    }

    function addgrp()
    {
        $group = $this->input->post('group');
        $this->aauth->create_group($group);

        $this->session->set_flashdata(
            "msg",
            "<font color='green'>Group Added</font>"
        );

        redirect('admin/groups');
    }
}

/* End of file */
