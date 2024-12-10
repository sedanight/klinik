<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Masterdata extends REST_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model(array('M_masterdata'));

		$this->limit = 10;

		$id_user = $this->session->userdata('id_user');
		if (empty($id_user)) {
			$this->response(array('error' => 'Anda belum login'), 401);
		}
	}

	private function start($page) {
		return (($page - 1) * $this->limit);
	}

	/* Units */

	function units_get() {
		if (!$this->get('id')) {
			$this->response(NULL, 400);
		}
		$data['data'] = $this->M_masterdata->get_units($this->get('id'));
		$data['page'] = 1;
		$data['limit'] = $this->limit;
		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Tidak ada data'), 404);
		}
	}

	function units_post() {
		$add = array(
			'id' => $this->get('id'),
			'nama' => post_safe('nama'),
		);

		$id = $this->M_masterdata->update_data_units($add);
		$message = array('id' => $id);

		$this->response($message, 200); // 200 being the HTTP response code
	}

	function units_delete() {
		$this->M_masterdata->delete_data_units($this->get('id'));

	}

	function units_list_get() {
		if (!$this->get('page')) {
			$this->response(NULL, 400);
		}

		$search = array(
			'pencarian' => get_safe('pencarian'),
		);

		$start = $this->start($this->get('page'));

		$data = $this->M_masterdata->get_list_units($this->limit, $start, $search);
		$data['page'] = (int) $this->get('page');
		$data['limit'] = $this->limit;

		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Data tidak ditemukan'), 404);
		}
	}

	/* Units */

	/* pegawai */

	function pegawai_get() {
		if (!$this->get('id')) {
			$this->response(NULL, 400);
		}
		$data['data'] = $this->M_masterdata->get_pegawai($this->get('id'));
		$data['page'] = 1;
		$data['limit'] = $this->limit;
		if ($data) {
			$this->response($data, 200);
		} else {
			$this->response(array('error' => 'Tidak ada data'), 404);
		}
	}

	function pegawai_post() {
		$add = array(
			'id' => $this->get('id'),
			'nip' => post_safe('nip'),
			'nama' => post_safe('nama'),
			'alamat' => post_safe('alamat'),
			'kelamin' => post_safe('kelamin'),
			'tanggal_lahir' => (post_safe('tanggal_lahir') !== '') ? date2mysql(post_safe('tanggal_lahir')) : NULL,
			'agama' => (post_safe('agama') !== '') ? post_safe('agama') : NULL,
			'telp' => post_safe('telp'),
			'is_dokter' => post_safe('dokter'),
		);

		$id = $this->M_masterdata->update_data_pegawai($add);
		$message = array('id' => $id);

		$this->response($message, 200);
	}

	function pegawai_delete() {
		$this->M_masterdata->delete_data_pegawai($this->get('id'));
	}

	function pegawai_list_get() {
		if (!$this->get('page')) {
			$this->response(NULL, 400);
		}

		$search = array(
			'pencarian' => get_safe('pencarian'),
		);

		$start = $this->start($this->get('page'));

		$data = $this->M_masterdata->get_list_pegawai($this->limit, $start, $search);
		$data['page'] = (int) $this->get('page');
		$data['limit'] = $this->limit;

		if ($data) {
			$this->response($data, 200);
		} else {
			$this->response(array('error' => 'Data tidak ditemukan'), 404);
		}
	}

	/* pegawai */

	/* Provinsi */

	function provinsi_get() {
		if (!$this->get('page')) {
			$this->response(NULL, 400);
		}

		$start = ($this->get('page') - 1) * $this->limit;
		$search = array(
			'pencarian' => get_safe('pencarian'),
		);

		$data = $this->M_masterdata->get_list_provinsi($this->limit, $start, $search);
		$data['page'] = (int) $this->get('page');
		$data['limit'] = $this->limit;

		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Data tidak ditemukan!'), 404);
		}
	}

	function provinsi_by_id_get() {
		if (!$this->get('id')) {
			$this->response(NULL, 400);
		}

		$data['data'] = $this->db->where('id', $this->get('id'))->get('tb_provinsi')->row();
		$data['page'] = 1;
		$data['limit'] = $this->limit;
		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Data tidak ditemukan'), 404);
		}
	}

	function provinsi_post() {
		$add = array(
			'id' => $this->get('id'),
			'nama' => post_safe('nama'),
		);
		$id = $this->M_masterdata->update_data_provinsi($add);
		$message = array('id' => $id);

		$this->response($message, 200); // 200 being the HTTP response code
	}

	function provinsi_delete() {
		$this->M_masterdata->delete_data_provinsi($this->get('id'));

	}

	/* Provinsi */

	/* Kabupaten/Kota */
	function kabupaten_kota_get() {
		if (!$this->get('id')) {
			$this->response(NULL, 400);
		}
		$data['data'] = $this->M_masterdata->get_kabupaten_kota($this->get('id'));
		$data['page'] = 1;
		$data['limit'] = $this->limit;
		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Tidak ada data'), 404);
		}
	}

	function kabupaten_kota_post() {
		$add = array(
			'id' => $this->get('id'),
			'id_provinsi' => post_safe('id_provinsi'),
			'nama' => post_safe('nama'),
		);
		$id = $this->M_masterdata->update_data_kabupaten_kota($add);
		$message = array('id' => $id);

		$this->response($message, 200); // 200 being the HTTP response code
	}
	function kabupaten_kota_delete() {
		$this->M_masterdata->delete_data_kabupaten_kota($this->get('id'));

	}

	function kabupaten_kota_list_get() {
		if (!$this->get('page')) {
			$this->response(NULL, 400);
		}

		$search = array(
			'pencarian' => get_safe('pencarian'),
		);

		$start = $this->start($this->get('page'));

		$data = $this->M_masterdata->get_list_kabupaten_kota($this->limit, $start, $search);
		$data['page'] = (int) $this->get('page');
		$data['limit'] = $this->limit;

		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Data tidak ditemukan'), 404);
		}
	}

	/* Kabupaten/Kota */

	/* Kecamatan */
	function kecamatan_get() {
		if (!$this->get('id')) {
			$this->response(NULL, 400);
		}
		$data['data'] = $this->M_masterdata->get_kecamatan($this->get('id'));
		$data['page'] = 1;
		$data['limit'] = $this->limit;
		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Tidak ada data'), 404);
		}
	}

	function kecamatan_post() {
		$add = array(
			'id' => $this->get('id'),
			'id_kabupaten_kota' => (post_safe('id_kabupaten_kota') !== '') ? post_safe('id_kabupaten_kota') : NULL,
			'nama' => post_safe('kecamatan'),
		);
		$id = $this->M_masterdata->update_data_kecamatan($add);
		$message = array('id' => $id);

		$this->response($message, 200); // 200 being the HTTP response code
	}

	function kecamatan_delete() {
		$this->M_masterdata->delete_data_kecamatan($this->get('id'));
	}

	function kecamatan_list_get() {
		if (!$this->get('page')) {
			$this->response(NULL, 400);
		}

		$search = array(
			'pencarian' => get_safe('pencarian'),
		);

		$start = $this->start($this->get('page'));

		$data = $this->M_masterdata->get_list_kecamatan($this->limit, $start, $search);
		$data['page'] = (int) $this->get('page');
		$data['limit'] = $this->limit;

		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Data tidak ditemukan'), 404);
		}
	}

	/* Kecamatan */

	/* Kelurahan */
	function kelurahan_get() {
		if (!$this->get('id')) {
			$this->response(NULL, 400);
		}
		$data['data'] = $this->M_masterdata->get_kelurahan($this->get('id'));
		$data['page'] = 1;
		$data['limit'] = $this->limit;
		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Tidak ada data'), 404);
		}
	}

	function kelurahan_post() {

		$add = array(
			'id' => $this->get('id'),
			'id_kecamatan' => post_safe('id_kecamatan'),
			'nama' => post_safe('kelurahan'),
		);
		$id = $this->M_masterdata->update_data_kelurahan($add);
		$message = array('id' => $id);

		$this->response($message, 200); // 200 being the HTTP response code
	}
	function kelurahan_delete() {
		$this->M_masterdata->delete_data_kelurahan($this->get('id'));

	}

	function kelurahan_list_get() {
		if (!$this->get('page')) {
			$this->response(NULL, 400);
		}

		$search = array(
			'pencarian' => get_safe('pencarian'),
		);

		$start = $this->start($this->get('page'));

		$data = $this->M_masterdata->get_list_kelurahan($this->limit, $start, $search);
		$data['page'] = (int) $this->get('page');
		$data['limit'] = $this->limit;

		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Data tidak ditemukan'), 404);
		}
	}

	/* Kelurahan */

	/* Tahun Akademik */

	function tahun_akademik_get() {
		if (!$this->get('id')) {
			$this->response(NULL, 400);
		}
		$data['data'] = $this->M_masterdata->get_tahun_akademik($this->get('id'));
		$data['page'] = 1;
		$data['limit'] = $this->limit;
		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Tidak ada data'), 404);
		}
	}

	function tahun_akademik_post() {
		$add = array(
			'id' => $this->get('id'),
			'tahun' => post_safe('tahun'),
			'semester' => post_safe('semester'),
			'status' => 'Aktif',
		);

		$id = $this->M_masterdata->update_data_tahun_akademik($add);
		$message = array('id' => $id);

		$this->response($message, 200); // 200 being the HTTP response code
	}

	function tahun_akademik_delete() {
		$this->M_masterdata->delete_data_tahun_akademik($this->get('id'));

	}

	function tahun_akademik_list_get() {
		if (!$this->get('page')) {
			$this->response(NULL, 400);
		}

		$search = array(
			'pencarian' => get_safe('pencarian'),
		);

		$start = $this->start($this->get('page'));

		$data = $this->M_masterdata->get_list_tahun_akademik($this->limit, $start, $search);
		$data['page'] = (int) $this->get('page');
		$data['limit'] = $this->limit;

		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Data tidak ditemukan'), 404);
		}
	}

	function ganti_status_tahun_post() {

		$status = $this->get('status');

		if ($status == 'Aktif') {
			$status = 'Tidak Aktif';
		} else {
			$status = 'Aktif';
		}

		$add = array(
			'id' => $this->get('id'),
			'status' => $status,
		);

		$id = $this->M_masterdata->update_status_tahun_akademik($add);
		$message = array('id' => $id, 'status' => $status);

		$this->response($message, 200); // 200 being the HTTP response code
	}

	/* Tahun Akademik */

	/* Kelas */

	function kelas_get() {
		if (!$this->get('id')) {
			$this->response(NULL, 400);
		}
		$data['data'] = $this->M_masterdata->get_kelas($this->get('id'));
		$data['page'] = 1;
		$data['limit'] = $this->limit;
		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Tidak ada data'), 404);
		}
	}

	function kelas_post() {
		$add = array(
			'id' => $this->get('id'),
			'tingkat' => post_safe('tingkat'),
			'nama_kelas' => post_safe('nama_kelas'),
			'status' => 'Aktif',
		);

		$id = $this->M_masterdata->update_data_kelas($add);
		$message = array('id' => $id);

		$this->response($message, 200); // 200 being the HTTP response code
	}

	function kelas_delete() {
		$id = $this->M_masterdata->delete_data_kelas($this->get('id'));
		$message = array('id' => $id);

		$this->response($message, 200); // 200 being the HTTP response code

	}

	function kelas_list_get() {
		if (!$this->get('page')) {
			$this->response(NULL, 400);
		}

		$search = array(
			'pencarian' => get_safe('pencarian'),
		);

		$start = $this->start($this->get('page'));

		$data = $this->M_masterdata->get_list_kelas($this->limit, $start, $search);
		$data['page'] = (int) $this->get('page');
		$data['limit'] = $this->limit;

		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Data tidak ditemukan'), 404);
		}
	}

	function ganti_status_kelas_post() {

		$status = $this->get('status');

		if ($status == 'Aktif') {
			$status = 'Tidak Aktif';
		} else {
			$status = 'Aktif';
		}

		$add = array(
			'id' => $this->get('id'),
			'status' => $status,
		);

		$id = $this->M_masterdata->update_status_kelas($add);
		$message = array('id' => $id, 'status' => $status);

		$this->response($message, 200); // 200 being the HTTP response code
	}

	/* Kelas */

	/* Mata Pelajaran */

	function mata_pelajaran_get() {
		if (!$this->get('id')) {
			$this->response(NULL, 400);
		}
		$data['data'] = $this->M_masterdata->get_mata_pelajaran($this->get('id'));
		$data['page'] = 1;
		$data['limit'] = $this->limit;
		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Tidak ada data'), 404);
		}
	}

	function mata_pelajaran_post() {
		$add = array(
			'id' => $this->get('id'),
			'kode' => post_safe('kode'),
			'nama' => post_safe('nama'),
			'status' => 'Aktif',
		);

		$id = $this->M_masterdata->update_data_mata_pelajaran($add);
		$message = array('id' => $id);

		$this->response($message, 200); // 200 being the HTTP response code
	}

	function mata_pelajaran_delete() {
		$id = $this->M_masterdata->delete_data_mata_pelajaran($this->get('id'));
		$message = array('id' => $id);

		$this->response($message, 200); // 200 being the HTTP response code

	}

	function mata_pelajaran_list_get() {
		if (!$this->get('page')) {
			$this->response(NULL, 400);
		}

		$search = array(
			'pencarian' => get_safe('pencarian'),
		);

		$start = $this->start($this->get('page'));

		$data = $this->M_masterdata->get_list_mata_pelajaran($this->limit, $start, $search);
		$data['page'] = (int) $this->get('page');
		$data['limit'] = $this->limit;

		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Data tidak ditemukan'), 404);
		}
	}

	function ganti_status_mata_pelajaran_post() {

		$status = $this->get('status');

		if ($status == 'Aktif') {
			$status = 'Tidak Aktif';
		} else {
			$status = 'Aktif';
		}

		$add = array(
			'id' => $this->get('id'),
			'status' => $status,
		);

		$id = $this->M_masterdata->update_status_mata_pelajaran($add);
		$message = array('id' => $id, 'status' => $status);

		$this->response($message, 200); // 200 being the HTTP response code
	}

	/* Mata Pelajaran */

	/* KKM */
	function kkm_get() {
		if (!$this->get('id')) {
			$this->response(NULL, 400);
		}
		$data['data'] = $this->M_masterdata->get_kkm($this->get('id'));
		$data['page'] = 1;
		$data['limit'] = $this->limit;
		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Tidak ada data'), 404);
		}
	}

	function kkm_post() {
		$add = array(
			'id' => $this->get('id'),
			'id_mata_pelajaran' => post_safe('id_mata_pelajaran'),
			'kkm' => post_safe('kkm'),
		);
		$id = $this->M_masterdata->update_data_kkm($add);
		$message = array('id' => $id);

		$this->response($message, 200); // 200 being the HTTP response code
	}

	function kkm_delete() {
		$this->M_masterdata->delete_data_kkm($this->get('id'));

	}

	function kkm_list_get() {
		if (!$this->get('page')) {
			$this->response(NULL, 400);
		}

		$search = array(
			'pencarian' => get_safe('pencarian'),
		);

		$start = $this->start($this->get('page'));

		$data = $this->M_masterdata->get_list_kkm($this->limit, $start, $search);
		$data['page'] = (int) $this->get('page');
		$data['limit'] = $this->limit;

		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Data tidak ditemukan'), 404);
		}
	}

	/* KKM */

	/* Pendidikan */

	function pendidikan_get() {
		if (!$this->get('page')) {
			$this->response(NULL, 400);
		}

		$start = ($this->get('page') - 1) * $this->limit;
		$search = array(
			'pencarian' => get_safe('pencarian'),
		);

		$data = $this->M_masterdata->get_list_pendidikan($this->limit, $start, $search);
		$data['page'] = (int) $this->get('page');
		$data['limit'] = $this->limit;

		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Data tidak ditemukan!'), 404);
		}
	}

	function pendidikan_by_id_get() {
		if (!$this->get('id')) {
			$this->response(NULL, 400);
		}

		$data['data'] = $this->db->where('id', $this->get('id'))->get('tb_pendidikan')->row();
		$data['page'] = 1;
		$data['limit'] = $this->limit;
		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Data tidak ditemukan'), 404);
		}
	}

	function pendidikan_post() {
		$add = array(
			'id' => $this->get('id'),
			'nama' => post_safe('nama'),
		);
		$id = $this->M_masterdata->update_data_pendidikan($add);
		$message = array('id' => $id);

		$this->response($message, 200); // 200 being the HTTP response code
	}

	function pendidikan_delete() {
		$this->M_masterdata->delete_data_pendidikan($this->get('id'));

	}

	/* Pendidikan */

	/* Pekerjaan*/
	function pekerjaan_get() {
		if (!$this->get('page')) {
			$this->response(NULL, 400);
		}

		$start = ($this->get('page') - 1) * $this->limit;
		$search = array(
			'pencarian' => get_safe('pencarian'),
		);

		$data = $this->M_masterdata->get_list_pekerjaan($this->limit, $start, $search);
		$data['page'] = (int) $this->get('page');
		$data['limit'] = $this->limit;

		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Data tidak ditemukan!'), 404);
		}
	}

	function pekerjaan_by_id_get() {
		if (!$this->get('id')) {
			$this->response(NULL, 400);
		}

		$data['data'] = $this->db->where('id', $this->get('id'))->get('tb_pekerjaan')->row();
		$data['page'] = 1;
		$data['limit'] = $this->limit;
		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Data tidak ditemukan'), 404);
		}
	}

	function pekerjaan_post() {
		$add = array(
			'id' => $this->get('id'),
			'nama' => post_safe('nama'),
		);
		$id = $this->M_masterdata->update_data_pekerjaan($add);
		$message = array('id' => $id);

		$this->response($message, 200); // 200 being the HTTP response code
	}

	function pekerjaan_delete() {
		$this->M_masterdata->delete_data_pekerjaan($this->get('id'));

	}

	/* Pekerjaan*/

}