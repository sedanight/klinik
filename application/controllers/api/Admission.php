<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admission extends REST_Controller {
	function __construct() {
		parent::__construct();
		$this->limit = 10;
		$this->load->model(array('M_admission'));

		$id_user = $this->session->userdata('id_user');
		if (empty($id_user)) {
			$this->response(array('error' => 'Anda belum login'), 401);
		}
	}

	private function start($page) {
		return (($page - 1) * $this->limit);
	}

    /* Pasien */
    
    public function pasien_get()
    {
        if (!$this->get("id")) {
            $this->response(NULL, 400);
        }
        $data["data"] = $this->M_admission->get_pasien($this->get("id"));
        $data["page"] = 1;
        $data["limit"] = $this->limit;
        if ($data) {
            $this->response($data, 200);
        } else {
            $this->response(array("error" => "Tidak ada data"), 404);
        }
    }

    public function pasien_post()
    {
        $add = array(
            "id" => $this->get("id"), 
            "tanggal_daftar" => date("Y-m-d"), 
            "nama" => post_safe("nama"), 
            "kelamin" => post_safe("kelamin"), 
            "id_kelurahan" => post_safe("kelurahan") != "" ? post_safe("kelurahan") : NULL, 
            "alamat" => post_safe("alamat"), 
            "tanggal_lahir" => post_safe("tanggal_lahir") != "" ? date2mysql(post_safe("tanggal_lahir")) : NULL, 
            "tempat_lahir" => post_safe("tempat_lahir"), 
            "agama" => post_safe("agama") !== "" ? post_safe("agama") : "Lain-lain", 
            "gol_darah" => post_safe("gol_darah") !== "" ? post_safe("gol_darah") : NULL, 
            "id_pendidikan" => post_safe("pendidikan") != "" ? post_safe("pendidikan") : NULL, 
            "id_pekerjaan" => post_safe("pekerjaan") != "" ? post_safe("pekerjaan") : NULL, 
            "status_pernikahan" => post_safe("pernikahan") != "" ? post_safe("pernikahan") : "Lajang", 
            "telp" => post_safe("telp"), 
            "jenis_identitas" => post_safe('jenis_identitas'), 
            "no_identitas" => post_safe("no_identitas"), 
            "nama_ayah" => post_safe("nama_ayah"), 
            "nama_ibu" => post_safe("nama_ibu")
        );

        $id = $this->M_admission->update_data_pasien($add);
        $message = array("id" => $id);
        $this->response($message, 200);
    }

    public function pasien_list_get()
    {
        if (!$this->get("page")) {
            $this->response(NULL, 400);
        }
        $search = array(
            "id" => get_safe("no_rm"), 
            "nama" => get_safe("nama"), 
            "kelamin" => get_safe("kelamin"), 
            "umur" => get_safe("umur"), 
            "alamat" => get_safe("alamat"), 
            "telp" => get_safe("telp")
        );

        $start = $this->start($this->get("page"));
        $data = $this->M_admission->get_list_pasien($this->limit, $start, $search);
        $data["page"] = (int) $this->get("page");
        $data["limit"] = $this->limit;
        if ($data) {
            $this->response($data, 200);
        } else {
            $this->response(array("error" => "Data tidak ditemukan"), 404);
        }
    }

    public function pasien_merge_post()
    {
        if (post_safe("pasien_utama") === "") {
            $response = array("status" => false, "message" => "Parameter pasien utama tidak ada");
            $this->response($response, 200);
        }
        $param = array(
            "pasien_utama" => post_safe("pasien_utama"), 
            "pasien_merge" => post_safe("pasien_merge")
        );
        $result = $this->M_admission->merge_pasien($param);
        $response = array("status" => $result["status"], "message" => $result["message"]);
        $this->response($response, 200);
    }

    /* Pasien */

	/* Pendaftaran */
	function list_pendaftaran_get() {
		if (!$this->get('page')) {
			$this->response(NULL, 400);
		}

		$search = array(
			'id' => get_safe('id'),
			'awal' => get_safe('awal'),
			'akhir' => get_safe('akhir'),
			'no_rm' => get_safe('no_rm'), 
			'no_register' => get_safe('no_register'),
			'nama' => get_safe('nama'),
			"status" => get_safe("status")
		);

		$start = $this->start($this->get('page'));

		$data = $this->M_admission->get_list_pendaftaran($this->limit, $start, $search);
		$data['page'] = (int) $this->get('page');
		$data['limit'] = $this->limit;

		if ($data) {
			$this->response($data, 200); // 200 being the HTTP response code
		} else {
			$this->response(array('error' => 'Data tidak ditemukan'), 404);
		}
	}

	function pendaftaran_post() {
		$this->db->trans_begin();
		$waktu = date('Y-m-d h:i:s');

		//data pasien
		if (post_safe('no_rm') == '') {
			$id_pasien = false;
		} else {
			$id_pasien = post_safe('no_rm');
		}

		if (post_safe("tanggal_lahir") !== "") {
            $tanggal_lahir = date2mysql(post_safe("tanggal_lahir"));
        } else {
            if (post_safe("umur") !== "") {
                $tanggal_lahir = birthByAge(post_safe("umur"));
            }
        }

		$add = array(
			'id' => $id_pasien,
			'tanggal_daftar' => date('Y-m-d'), 
			"nama" => trim(strtoupper(trim(post_safe("nama"))) . " " . post_safe("status_pasien")), 
			'kelamin' => post_safe('kelamin'),
			'alamat' => post_safe('alamat'),
			"id_kelurahan" => post_safe("kelurahan") != "" ? post_safe("kelurahan") : NULL, 
			'tempat_lahir' => post_safe('tempat_lahir'),
            "tanggal_lahir" => $tanggal_lahir, 
			// 'id_kabupaten' => post_safe('tempat_lahir'),
			'agama' => post_safe('agama'),
			'gol_darah' => post_safe('gol_darah'),
			"id_pendidikan" => post_safe("pendidikan") != "" ? post_safe("pendidikan") : NULL, 
            "id_pekerjaan" => post_safe("pekerjaan") != "" ? post_safe("pekerjaan") : NULL, 
            "status_pernikahan" => post_safe("pernikahan") != "" ? post_safe("pernikahan") : "Belum Menikah",
			"telp" => post_safe("telp"), 
			"jenis_identitas" => post_safe("jenis_identitas") != "" ? post_safe("jenis_identitas") : NULL, 
			"no_identitas" => post_safe("no_identitas"), 
			'nama_ayah' => post_safe('nama_ayah'),
			'nama_ibu' => post_safe('nama_ibu'),
		);

		//validasi data pasien
		$no_rm = $this->M_admission->update_data_pasien($add, true);

		$pendaftaran = array(
			'no_register' => $this->M_admission->generate_no_register(),
			'id_pasien' => $no_rm,
			'waktu_daftar' => $waktu,
			'status' => $this->M_admission->get_status_pasien($no_rm),
			'id_users' => $this->session->userdata('id_user')
		);

		$id_pendaftaran = $this->M_admission->insert_pendaftaran($pendaftaran);

		$layanan_pendaftaran = array(
			'id_pendaftaran' => $id_pendaftaran,
			'waktu' => $waktu,
			'no_antri' => $this->M_admission->get_next_antrian(array('tanggal' => date('Y-m-d'))),
			"id_dokter" => post_safe("id_dokter") != "" ? post_safe("id_dokter") : NULL, 
			"cara_bayar" => 'Tunai' 
		);

		$id_layanan_pendaftaran = $this->M_admission->insert_layanan_pendaftaran($layanan_pendaftaran);

		$data_pembayaran = array(
        	'id_pasien' => $no_rm,
        	'id_layanan_pendaftaran' => $id_layanan_pendaftaran,
            'tanggal_bayar' => NULL,
        );

        $id_pembayaran = $this->M_admission->insert_data_pembayaran($data_pembayaran);

		if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $status = FALSE;
        } else {
            $this->db->trans_commit();
            $status = TRUE;
        }

        $message = array('id' => $id_pendaftaran, 'status'=>$status, 'message' => '');
        
        $this->response($message, 200); // 200 being the HTTP response code
	}

	function pendaftaran_get_antrian_get(){
        $data = array(
            'id_pasien' => get_safe('id_pasien'),
            'tanggal' => (get_safe('tanggal') !== '')?date2mysql(get_safe('tanggal')):date('Y-m-d')
        );
        $antrian = $this->M_admission->get_next_antrian($data);
        die(json_encode(array('antrian' => $antrian)));
    }

    public function layanan_pendaftaran_detail_get()
    {
        if (!$this->get("id")) {
            $this->response(NULL, 400);
        }
        $data = $this->M_admission->get_pendaftaran_detail($this->get("id"), $this->get("id_layanan"));
       
        if ($data) {
            $this->response($data, 200);
        } else {
            $this->response(array("error" => "Tidak ada data"), 404);
        }
    }

    public function pemeriksaan_save_post()
    {
        $waktu = date("Y-m-d H:i:s");
        $this->db->trans_begin();

        $layanan = array(
        	"id" => post_safe("id_layanan"), 
        	"id_dokter" => post_safe('dokter'), 
        	"status" => "Sudah",
        	"id_users" => $this->session->userdata('id_user')
        );
        
        $this->M_admission->update_layanan_pendaftaran($layanan);
        
        $visitasi = array(
        	"id_layanan_pendaftaran" => $layanan["id"], 
        	"waktu" => $waktu, 
        	"anamnesa" => post_safe("anamnesa"), 
        	"diagnosa" => post_safe("diagnosa"), 
        	"tindakan" => post_safe("tindakan")
        );
       
        $this->M_admission->insert_visitasi($visitasi);
        
        $waktu_periksa = array("id_layanan_pendaftaran" => $layanan["id"], "waktu" => $waktu);
        $this->M_admission->update_waktu_periksa($waktu_periksa);

        $waktu_keluar = array("id_pendaftaran" => post_safe('id_pendaftaran'), "waktu" => $waktu);
        $this->M_admission->update_waktu_keluar($waktu_keluar);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $status = false;
        } else {
            $this->db->trans_commit();
            $status = true;
        }

        $message = array("status" => $status, "id" => $layanan["id"]);
        $this->response($message, 200);
    }

    public function batal_pendaftaran_delete()
    {
        if (!$this->get("id")) {
            $this->response(array("status" => false), 200);
        }
        $response = $this->M_admission->batal_pendaftaran($this->get("id"));
        $this->response($response, 200);
    }

    function sks_post()
    {
    	$waktu = date('Y-m-d H:i:s');

        if (post_safe('id') == '') {
            $id = false;
        } else {
            $id = post_safe('id');
        }

    	$data = array(
            'id' => $id,
    		'dari' => date2mysql(post_safe("dari")),
    		'sampai' => date2mysql(post_safe("sampai")),
    		'hari' => post_safe('selama'),
    	);

    	$id_sks = $this->M_admission->update_sks($data);

    	$layanan_pendaftaran = array(
    		'id' => post_safe('id_layanan2'),
    		'id_sks' => $id_sks
    	);
    	$this->M_admission->update_layanan_pendaftaran($layanan_pendaftaran);

    	if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $status = false;
        } else {
            $this->db->trans_commit();
            $status = true;
        }

        $message = array("status" => $status, "id" => $id_sks);
        $this->response($message, 200);
    }

    /* SKS */

    function list_sks_get()
    {
        if (!$this->get('page')) {
            $this->response(NULL, 400);
        }

        $search = array(
            'id' => get_safe('id'),
            'awal' => get_safe('awal'),
            'akhir' => get_safe('akhir'),
            'no_rm' => get_safe('no_rm'), 
            'no_register' => get_safe('no_register'),
            'nama' => get_safe('nama')
        );

        $start = $this->start($this->get('page'));

        $data = $this->M_admission->get_list_sks($this->limit, $start, $search);
        $data['page'] = (int) $this->get('page');
        $data['limit'] = $this->limit;

        if ($data) {
            $this->response($data, 200); // 200 being the HTTP response code
        } else {
            $this->response(array('error' => 'Data tidak ditemukan'), 404);
        }
    }

    public function edit_sks_get()
    {
        if (!$this->get("id")) {
            $this->response(NULL, 400);
        }
        $data = $this->M_admission->get_sks_by_id($this->get("id"));
       
        if ($data) {
            $this->response($data, 200);
        } else {
            $this->response(array("error" => "Tidak ada data"), 404);
        }
    }

    public function hapus_sks_delete()
    {
        if (!$this->get("id")) {
            $this->response(array("status" => false), 200);
        }
        $response = $this->M_admission->hapus_sks($this->get("id"));
        $this->response($response, 200);
    }

    /* SKS */

}