<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index() {
		$data['title'] = "Home";
		$data['active'] = 'Dashboard';
		$data['module'] = $this->M_home->get_data_moduls($this->session->userdata('id_group'));
		$data["profil"] = $this->M_home->get_foto_profil();
		$id_user = $this->session->userdata('id_user');

		if (!empty($id_user)) {
			$this->load->view('template', $data);
		} else {
			$this->login();
		}
	}

	function home_page()
	{
		$data['allpasien'] = $this->M_home->jumlah_data_pasien();
		$data['pendapatan_perhari'] = $this->M_home->jumlah_pendapatan_perhari();
		$data['pendapatan_all'] = $this->M_home->jumlah_pendapatan_all();
		$this->load->view('home_page', $data);
	}
	function login() {
		$data['shift'] = array(
			'1' => 'Shift 1',
			'2' => 'Shift 2',
			'3' => 'Shift 3',
		);
		$data["clinic"] = $this->M_home->get_atribute_clinic();
		// $data["page"] = "home_page";
		$data['shift_now'] = $this->get_shift_now();
		$this->load->view('login', $data);
	}

	function cek_shift($shift = null) {
		if ($shift !== null) {
			$shift_now = $this->get_shift_now();
			if ($shift !== $shift_now) {
				$status = false;
				$message = "Shift saat ini adalah shift <b>" . $shift_now . "</b><br/> Apakah anda akan tetap menggunakan shift yang anda pilih?";
			} else {
				$status = true;
				$message = "";
			}

			die(json_encode(array('status' => $status, 'shift' => $shift_now, 'message' => $message)));
		} else {
			die();
		}

	}
	private function get_shift_now() {
		$jam7 = strtotime("07:00:00");
		$jam15 = strtotime("15:00:00");
		$jam21 = strtotime("21:00:00");
		$jam6 = strtotime("06:00:00");
		$now = time();
		$shift = '1';
		if (($now >= $jam7) & ($now < $jam15)) {
			$shift = '1';
		} else if (($now >= $jam15) & ($now < $jam21)) {
			$shift = '2';
		} else if (($now >= $jam21) & ($now < $jam6)) {
			$shift = '3';
		}

		return $shift;
	}

	function ganti_password() {
		$data['id'] = $this->session->userdata("id_user");
		$this->load->view('ganti_password', $data);
	}

	function profile() {
		$data['id'] = $this->session->userdata("id_user");
		$data["profil"] = $this->M_home->get_foto_profil();
		$this->load->view('profile', $data);
	}

	function cek_password() {
		$username = filter_input(INPUT_POST, 'username');
		$password = filter_input(INPUT_POST, 'password');
		$data = $this->M_users->check_my_account($username)->row();
		if (isset($data->id)) {
			if (verifyHashedPassword($password, $data->password)) {
				die(json_encode(array('status' => TRUE)));
			} else {
				die(json_encode(array('status' => FALSE)));
			}
		} else {
			die(json_encode(array('status' => FALSE)));
		}
	}

	function save_password() {
		$data = array(
			'password' => getHashedPassword(post_safe('password_baru')),
		);

		$this->db->where('id', $this->session->userdata("id_user"))->update('tb_users', $data);

		die(json_encode(array('status' => true)));
	}

	function do_upload(){

		$this->db->delete('tb_foto_profil', array('id_pegawai' => $this->session->userdata('id_user')));

        $config['upload_path']="./assets/foto";
        $config['allowed_types']='gif|jpg|png';
        $config['encrypt_name'] = TRUE;
         
        $this->load->library('upload',$config);
        if($this->upload->do_upload("file")){
            $data = array('upload_data' => $this->upload->data());
            $image = $data['upload_data']['file_name'];  
            $result= $this->M_home->simpan_upload($image);
            echo json_decode($result);
        }
 
    }

    public function dashboard_data_pasien_lama_baru()
    {
        $data_exist = $this->M_home->get_last_exist_data_pendaftaran()->row();
        $prethel = explode("-", $data_exist->tanggal);
        $date = mktime(0, 0, 0, $prethel[1], $prethel[2] - 6, $prethel[0]);
        $start = date("Y-m-d", $date);
        $tgl = createRange($start, $data_exist->tanggal);
        $status = $this->M_home->data_pasien_lama_baru($tgl);
        $result["data"] = array(
        	array(
	        	"type" => "spline", 
	        	"name" => "Pasien Lama", 
	        	"data" => $status["lama"]
	        ), 
	        array(
	        	"type" => "spline", 
	        	"name" => "Pasien Baru", 
	        	"data" => $status["baru"]
	        )
	    );
        foreach ($tgl as $key => $value) {
            $result["tanggal"][] = date("d M", strtotime($value));
        }
        $result["title"] = "Grafik Status Kunjungan Pasien";
        exit(json_encode($result));
    }

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */