<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('M_sistem');
	}

	function logmein() {
		$username = filter_input(INPUT_POST, 'username');
		$password = filter_input(INPUT_POST, 'password');
		$shift = filter_input(INPUT_POST, 'shift');
		$waktu = date('Y-m-d H:i:s');

		$data = $this->M_users->validate_my_account($username);

		if (isset($data->id)) {
			if (verifyHashedPassword($password, $data->password)) {
				$data_session = array(
					'id_user' => $data->id,
					'username' => $data->username,
					'nama' => $data->nama,
					"profesi" => $data->profesi,
					'alamat' => $data->alamat,
					'id_group' => $data->id_group_users,
					'id_unit' => $data->id_unit,
					'unit' => $data->unit,
					'shift' => $shift,
					'tanggal_login' => $waktu,
				);

				$data_session2 = array(
					'id_user' => $data->id,
					'username' => $data->username,
					'nama' => $data->nama,
					'alamat' => $data->alamat,
					'id_group' => $data->id_group_users,
					'id_unit' => $data->id_unit,
					'unit' => $data->unit,
					'shift' => $shift,
					'tanggal_login' => $waktu,
				);

				$this->db->insert('tb_session', $data_session2);
				$this->session->set_userdata($data_session);
			} else {
				die(json_encode(array('passwrong' => FALSE)));
			}
			die(json_encode(array('status' => TRUE)));
		} else {
			die(json_encode(array('status' => FALSE)));
		}
	}

	function logout() {
		$this->session->sess_destroy();
		redirect(base_url());
	}

}

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */