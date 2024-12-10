<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keuangan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('M_home', 'M_keuangan'));
		
	}

	public function index()
	{
		$data['title'] = "Admission";
    	$data['active'] = "Admission";
        $data['module'] = $this->M_home->get_data_moduls($this->session->userdata('id_group'));
        $id_user = $this->session->userdata('id_user');
        
        if (!empty($id_user)) {
            $this->load->view('template', $data);
        } else {
            redirect('/');
        }
	}

	public function pembayaran()
	{
		$data['list'] = 'List Data Pembayaran';
		$data['status_pembayaran'] = $this->M_keuangan->get_status_pembayaran();
		$this->load->view('keuangan/keuangan/pembayaran', $data);
	}

}

/* End of file Billing.php */
/* Location: ./application/controllers/Billing.php */