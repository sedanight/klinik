<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('M_admission','M_keuangan'));
	}

	function export_data_pendaftaran()
	{
		$search = array(
           'id' => get_safe('id'),
           'awal' => get_safe('awal'),
           'akhir' => get_safe('akhir'),
           'no_rm' => get_safe('no_rm'),
           'no_register' => get_safe('no_register'),
           'nama' => get_safe('nama'),
           'status' => get_safe('status')
        );

		$data = $this->M_admission->get_list_pendaftaran(NULL, NULL, $search);
        $data['clinic'] = $this->M_home->get_atribute_clinic();
        $data['judul'] = 'Data Pendaftaran dan Pemeriksaan Pasien Tanggal '.$search['awal'].' sd '.$search['akhir']; 

        $this->load->view('export/pendaftaran/export_pendaftaran', $data);
	}

	function export_data_pembayaran()
	{
		$search = array(
           'id' => get_safe('id'),
           'awal' => get_safe('awal'),
           'akhir' => get_safe('akhir'),
           'no_rm' => get_safe('no_rm'),
           'no_register' => get_safe('no_register'),
           'nama' => get_safe('nama'),
           'status_pembayaran' => get_safe('status_pembayaran')
        );

		$data = $this->M_keuangan->get_list_pembayaran(NULL, NULL, $search);
        $data['clinic'] = $this->M_home->get_atribute_clinic();
        $data['judul'] = 'Data Rekap Pembayaran Tanggal '.$search['awal'].' sd '.$search['akhir']; 

        $this->load->view('export/pembayaran/export_data_pembayaran', $data);
	}
	
	

}

/* End of file Export.php */
/* Location: ./application/controllers/Export.php */