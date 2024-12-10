<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admission extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('M_home', 'M_admission', 'M_masterdata'));
		
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

	public function pasien()
    {
    	$data['list'] = 'List Data Induk Pasien';
        $data["jenis_identitas"] = $this->M_masterdata->get_jenis_identitas();
        $data["kelamin"] = $this->M_masterdata->get_jenis_kelamin();
        $data["gol_darah"] = $this->M_masterdata->get_golongan_darah();
        $data["agama"] = $this->M_masterdata->get_agama();
        $data["pendidikan"] = $this->M_masterdata->get_pendidikan();
        $data["pekerjaan"] = $this->M_masterdata->get_pekerjaan();
        $data["pernikahan"] = $this->M_masterdata->get_status_pernikahan();
        $this->load->view("admission/pasien/pasien", $data);
    }

	public function pendaftaran()
	{
		$data['list'] = 'List Data Pendaftaran';
		$data['kelamin'] = $this->M_masterdata->get_jenis_kelamin();
		$data['agama'] = $this->M_masterdata->get_agama();
		$data['pendidikan'] = $this->M_masterdata->get_pendidikan();
		$data['pekerjaan'] = $this->M_masterdata->get_pekerjaan();
		$data['status_pasien'] = $this->M_masterdata->get_status_pasien();
		$data["jenis_identitas"] = $this->M_masterdata->get_jenis_identitas();
		$data["gol_darah"] = $this->M_masterdata->get_golongan_darah();
		$data["pernikahan"] = $this->M_masterdata->get_status_pernikahan();
		$data["status_pemeriksaan"] = $this->M_masterdata->status_pemeriksaan(true);
		$this->load->view('admission/pendaftaran/pendaftaran', $data);
	}

	public function sks()
	{
		$data['list'] = 'List Data Surat Keterangan Sakit';
		$data['agama'] = $this->M_masterdata->get_agama();
		$data['pekerjaan'] = $this->M_masterdata->get_pekerjaan();
		$this->load->view('admission/sks/sks', $data);
	}
	

}

/* End of file Pendaftaran.php */
/* Location: ./application/controllers/Pendaftaran.php */