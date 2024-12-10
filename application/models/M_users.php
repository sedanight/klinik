<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_users extends CI_Model {

	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}

	function validate_my_account($username) {
		$sql = "select u.*, gu.nama as profesi, p.nama, p.alamat,
        	IFNULL(un.nama, '') as unit
        	from tb_users u
            join tb_group_users gu on (u.id_group_users = gu.id)
            join tb_pegawai p on (u.id = p.id)
            left join tb_units un on (un.id = u.id_unit)
            where u.username = '$username'";
		$query = $this->db->query($sql);
		return $query->row();
	}

	function check_my_account($id_user) {
		$sql = "select u.*
            from tb_users u
            where u.id = '$id_user'";
		return $this->db->query($sql);
	}

}

/* End of file M_user.php */
/* Location: ./application/models/M_user.php */