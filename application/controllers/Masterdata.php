<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterdata extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model(array('M_home', 'M_masterdata'));

	}

	function index() {
		$data['title'] = "Master Data";
		$data['active'] = 'Master Data';
		$data['module'] = $this->M_home->get_data_moduls($this->session->userdata('id_group'));
		$id_user = $this->session->userdata('id_user');

		if (!empty($id_user)) {
			$this->load->view('template', $data);
		} else {
			redirect('/');
		}
	}

	function units() {
		$data['list'] = 'List Data Units';
		$this->load->view('masterdata/unit/units', $data);
	}

	function pegawai() {
		$data['list'] = 'List Data Pegawai';
		$data['kelamin'] = $this->M_masterdata->get_jenis_kelamin();
		$data['agama'] = $this->M_masterdata->get_agama();
		$data['dokter'] = $this->M_masterdata->get_is_dokter();
		$this->load->view('masterdata/pegawai/pegawai', $data);
	}

	function wilayah() {
		$data['list'] = "List Data Wilayah";
		$this->load->view('masterdata/wilayah/wilayah', $data);
	}

	function provinsi() {
		$this->load->view('masterdata/wilayah/provinsi');
	}

	function kabupaten_kota() {
		$this->load->view('masterdata/wilayah/kabupaten_kota');
	}

	function kecamatan() {
		$this->load->view('masterdata/wilayah/kecamatan');
	}

	function kelurahan() {
		$this->load->view('masterdata/wilayah/kelurahan');
	}

	function tahun_akademik() {
		$data['list'] = 'List Data Tahun Akademik';
		$this->load->view('masterdata/tahun/tahun_akademik', $data);
	}

	function kelas() {
		$data['list'] = 'List Data Kelas';
		$this->load->view('masterdata/kelas/kelas', $data);
	}

	function mata_pelajaran() {
		$data['list'] = 'List Data Mata Pelajaran';
		$this->load->view('masterdata/pelajaran/mata_pelajaran', $data);
	}

	function kkm() {
		$data['list'] = 'List Data KKM';
		$this->load->view('masterdata/pelajaran/kkm', $data);
	}

	function jenjang() {
		$data['list'] = "List Data Pendidikan & Pekerjaan";
		$this->load->view('masterdata/jenjang/jenjang', $data);
	}

	function pendidikan() {
		$this->load->view('masterdata/jenjang/pendidikan');
	}

	function pekerjaan() {
		$this->load->view('masterdata/jenjang/pekerjaan');
	}

}

/* End of file Masterdata.php */
/* Location: ./application/controllers/Masterdata.php */