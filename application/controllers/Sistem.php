<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sistem extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = "Home";
        $data['active'] = "Sistem";
		$data['module'] = $this->M_home->get_data_moduls($this->session->userdata('id_group'));
        $id_user = $this->session->userdata('id_user');
        
        if (!empty($id_user)) {
            $this->load->view('template', $data);
        } else {
            redirect('/');
        }
	}

	function account(){
		$data['list'] = "Setting Account";
        $this->load->view('sistem/account/account', $data); 
    }

    function group_user(){
        $this->load->view('sistem/account/group_user'); 
    }

    function users(){
        $this->load->view('sistem/account/users'); 
    }

}

/* End of file Sistem.php */
/* Location: ./application/controllers/Sistem.php */