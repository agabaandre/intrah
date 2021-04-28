<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_mdl extends CI_Model {

		public function __construct(){

		parent::__construct();

	}

//------------------------------------------------------------------------------------------
//------------------start SERVICES ---------------------------------------------------------

    public function get_blogs_dataByID($blog_id){
        $this->db->where('blogId',$blog_id);
        $qry=$this->db->get('blog');
        return $qry->row();
    }





	public function saveComment_services($postdata){
		$query=$this->db->insert('service_coments',$postdata);
		$rows=$this->db->affected_rows();

        if($rows>0){
            return "ok";
        }

        else{
            return $result;
        }
	}



}


