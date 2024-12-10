<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_masterdata extends CI_Model {

	public function get_jenis_identitas()
    {
        return array("" => "Pilih", "KTP" => "KTP", "SIM" => "SIM", "Paspor" => "Paspor");
    }
    
	function get_agama() {
		$data = array(
			'' => 'Pilih',
			'ISLAM' => 'ISLAM',
			'KRISTEN' => 'KRISTEN',
			'KATHOLIK' => 'KATHOLIK',
			'HINDU' => 'HINDU',
			'BUDHA' => 'BUDHA',
		);

		return $data;
	}

	function get_is_dokter() {
		$data = array(
			'' => 'Pilih',
			'Ya' => 'Ya',
			'Tidak' => 'Tidak'
		);

		return $data;
	}

	function get_kewarganegaraan() {
		$data = array(
			'' => 'Pilih',
			'WNI' => 'WNI',
			'WNA' => 'WNA',
		);

		return $data;
	}

	function get_status_pasien() {
		$data = array(
			'' => 'Pilih',
			'AN' => 'AN',
			'NY' => 'NY',
			'NN' => 'NN',
			'TN' => 'TN',
			'BY' => 'BY',
			'BY NY' => 'BY NY',
		);

		return $data;
	}

	function get_status_keluarga() {
		$data = array(
			'' => 'Pilih',
			'ANAK KANDUNG' => 'ANAK KANDUNG',
			'ANAK TIRI' => 'ANAK TIRI',
			'DLL' => 'DLL',
		);

		return $data;
	}

	function get_saudara() {
		$data = array(
			'' => 'Pilih',
			'KANDUNG' => 'KANDUNG',
			'TIRI' => 'TIRI',
			'ANGKAT' => 'ANGKAT',
		);

		return $data;
	}

	function get_transportasi() {
		$data = array(
			'' => 'Pilih',
			'KENDARAAN UMUM' => 'KENDARAAN UMUM',
			'JALAN KAKI' => 'JALAN KAKI',
		);

		return $data;
	}

	function get_pendidikan() {
		$query = $this->db->order_by('id')->get('tb_pendidikan')->result();
		$data = array();
		$data[''] = 'Pilih';
		foreach ($query as $key => $value) {
			$data[$value->id] = $value->nama;
		}

		return $data;
	}

	function get_pekerjaan() {
		$query = $this->db->order_by('id')->get('tb_pekerjaan')->result();
		$data = array();
		$data[''] = 'Pilih';
		foreach ($query as $key => $value) {
			$data[$value->id] = $value->nama;
		}

		return $data;
	}

	function get_tinggal() {
		$data = array(
			'' => 'Pilih',
			'ORANG TUA' => 'ORANG TUA',
			'WALI' => 'WALI',
			'DIASRAMA' => 'DIASRAMA',
		);

		return $data;
	}

	function get_jenis_kelamin() {
		return array(
			'' => 'Pilih',
			'L' => 'LAKI-LAKI',
			'P' => 'PEREMPUAN',
		);
	}

	public function get_golongan_darah()
    {
        return array(
        	"" => "Pilih", 
        	"A Rh+" => "A Rh+", 
        	"A Rh-" => "A Rh-", 
        	"B Rh+" => "B Rh+", 
        	"B Rh-" => "B Rh-", 
        	"AB Rh+" => "AB Rh+", 
        	"AB Rh-" => "AB Rh-", 
        	"O Rh+" => "O Rh+", 
        	"O Rh-" => "O Rh-"
        );
    }
    public function get_status_pernikahan()
    {
        return array(
        	"" => "Pilih", 
        	"Belum Menikah" => "Belum Menikah", 
        	"Menikah" => "Menikah", 
        	"Duda" => "Duda", 
        	"Janda" => "Janda"
        );
    }

    public function status_pemeriksaan($with_blank = false)
    {
        $blank = array("" => "Semua");
        $data = array("Belum" => "Belum Diperiksa", "Sudah" => "Sudah Diperiksa", "Batal" => "Batal");
        if ($with_blank) {
            return array_merge($blank, $data);
        }
        return $data;
    }

	/* Units */

	function get_units($id) {
		$sql = "select * from tb_units where id = '" . $id . "'";
		return $this->db->query($sql)->row();
	}

	function get_list_units($limit, $start, $search) {
		$q = '';

		if ($search['pencarian'] !== '') {
			$q = " and nama like '%" . $search['pencarian'] . "%' ";
		}

		$limit = " limit $start , $limit";

		$sql = "select * from tb_units where id is not null";
		$order = " order by nama ";
		$query = $this->db->query($sql . $q . $order . $limit);
		$result['data'] = $query->result();
		$result['jumlah'] = $this->db->query($sql . $q)->num_rows();
		return $result;
	}

	function update_data_units($data) {
		if ($data['id'] === false) {
			//insert
			$this->db->insert('tb_units', $data);
			$id = $this->db->insert_id();
		} else {
			// update
			$id = $data['id'];
			$this->db->where('id', $data['id'])->update('tb_units', $data);
		}

		return $id;

	}

	function delete_data_units($id) {
		$this->db->where('id', $id)->delete('tb_units');
	}

	function get_auto_unit($q, $start, $limit) {
		$limit = " limit $start, $limit";
		$sql = "select * from tb_units
            where nama like ('%$q%')  order by nama";
		$data['data'] = $this->db->query($sql . $limit)->result();
		$data['total'] = $this->db->query($sql)->num_rows();
		return $data;
	}

	/* Units */

	/* pegawai */

	function get_pegawai($id) {
		$sql = "select p.*
				from tb_pegawai p
				where p.id = '" . $id . "'";
		return $this->db->query($sql)->row();
	}

	function get_list_pegawai($limit, $start, $search) {
		$q = '';

		if ($search['pencarian'] !== '') {
			$q = " and p.nama like '%" . $search['pencarian'] . "%'";
		}

		$limit = " limit $start , $limit";

		$sql = "select p.*
				from tb_pegawai p
				where id is not null";
		$order = " order by nama ";
		$query = $this->db->query($sql . $q . $order . $limit);
		$result['data'] = $query->result();
		$result['jumlah'] = $this->db->query($sql . $q)->num_rows();
		return $result;
	}

	function update_data_pegawai($data) {
		if ($data['id'] === false) {
			//insert
			$this->db->insert('tb_pegawai', $data);
			$id = $this->db->insert_id();
		} else {
			// update
			$id = $data['id'];
			$this->db->where('id', $data['id'])->update('tb_pegawai', $data);
		}

		return $id;

	}

	function delete_data_pegawai($id) {
		$this->db->where('id', $id)->delete('tb_pegawai');
	}

	function get_auto_pegawai($q, $start, $limit, $param = NULL) {
		$limit = " limit $start, $limit";
		$p = NULL;
		if ($param !== '') {
			$p = " and p.id not in (select id from tb_users)";
		}
		$sql = "select p.*
                from tb_pegawai p
            	where p.nama like ('%$q%') $p  order by p.nama";
		$data['data'] = $this->db->query($sql . $limit)->result();
		$data['total'] = $this->db->query($sql)->num_rows();
		return $data;
	}

	/* pegawai */

	/* Provinsi */

	function get_list_provinsi($limit, $start, $search) {
		$limit = " limit $start , $limit";
		$q = "";
		if ($search['pencarian'] !== '') {
			$q .= " and nama like '%" . $search['pencarian'] . "%' ";
		}

		$sql = "select * from tb_provinsi where id is not null $q";
		$order = " order by id ";
		$query = $this->db->query($sql . $order . $limit);
		$result['data'] = $query->result();
		$result['jumlah'] = $this->db->query($sql)->num_rows();
		return $result;
	}

	function update_data_provinsi($data) {
		if ($data['id'] === false) {
			// insert
			$this->db->insert('tb_provinsi', $data);
			$id = $this->db->insert_id();
		} else {
			// Update
			$id = $data['id'];
			$this->db->where('id', $data['id'])->update('tb_provinsi', $data);
		}

		return $id;

	}

	function delete_data_provinsi($id) {
		$this->db->where('id', $id)->delete('tb_provinsi');
	}

	function get_auto_provinsi($q, $start, $limit) {
		$limit = " limit $start, $limit";
		$sql = "select * from tb_provinsi
            where nama like ('%$q%')  order by nama ";
		$data['data'] = $this->db->query($sql . $limit)->result();
		$data['total'] = $this->db->query($sql)->num_rows();
		return $data;
	}

	/* Provinsi */

	/* Kabupaten/Kota */

	function get_kabupaten_kota($id) {
		$sql = "select k.*, IFNULL(p.nama, '') as provinsi from tb_kabupaten_kota k
                join tb_provinsi p on (k.id_provinsi = p.id)
                where k.id = '" . $id . "'";
		return $this->db->query($sql)->row();
	}

	function get_list_kabupaten_kota($limit, $start, $search) {
		$q = '';

		if ($search['pencarian'] !== '') {
			$q = " and k.nama like '%" . $search['pencarian'] . "%' or p.nama like '%" . $search['pencarian'] . "%' ";
		}

		$limit = " limit $start , $limit";

		$sql = "select k.*, IFNULL(p.nama, '') as provinsi from tb_kabupaten_kota k
                join tb_provinsi p on (k.id_provinsi = p.id)
                where k.id is not null";
		$order = " order by k.id ";
		$query = $this->db->query($sql . $q . $order . $limit);
		$result['data'] = $query->result();
		$result['jumlah'] = $this->db->query($sql . $q)->num_rows();
		return $result;
	}

	function update_data_kabupaten_kota($data) {
		if ($data['id'] === false) {
			// insert
			$this->db->insert('tb_kabupaten_kota', $data);
			$id = $this->db->insert_id();
		} else {
			// Update
			$id = $data['id'];
			$this->db->where('id', $data['id'])->update('tb_kabupaten_kota', $data);
		}

		return $id;
	}

	function delete_data_kabupaten_kota($id) {
		$this->db->where('id', $id)->delete('tb_kabupaten_kota');
	}

	function get_auto_kabupaten_kota($q, $start, $limit) {
		$limit = " limit $start, $limit";
		$sql = "select k.*, IFNULL(p.nama,'') as provinsi  from tb_kabupaten_kota k
            join tb_provinsi p on (p.id = k.id_provinsi)
            where k.nama like ('%$q%')  order by k.nama";
		$data['data'] = $this->db->query($sql . $limit)->result();
		$data['total'] = $this->db->query($sql)->num_rows();
		return $data;
	}
	/* Kabupaten/Kota */

	/* Kecamatan */

	function get_kecamatan($id) {
		$sql = "select c.*, IFNULL(k.nama, '') as kabupaten,
                IFNULL(p.nama, '') as provinsi
                from tb_kecamatan c
                join tb_kabupaten_kota k on (c.id_kabupaten_kota = k.id)
                join tb_provinsi p on (p.id = k.id_provinsi)
                where c.id = '" . $id . "'";
		return $this->db->query($sql)->row();
	}

	function get_list_kecamatan($limit, $start, $search) {
		$q = '';

		if ($search['pencarian'] !== '') {
			$q = " and c.nama like '%" . $search['pencarian'] . "%' or k.nama like '%" . $search['pencarian'] . "%' ";
		}

		$limit = " limit $start , $limit";

		$sql = "select c.*, IFNULL(k.nama, '') as kabupaten,
                IFNULL(p.nama, '') as provinsi
                from tb_kecamatan c
                join tb_kabupaten_kota k on (c.id_kabupaten_kota = k.id)
                join tb_provinsi p on (p.id = k.id_provinsi)
                where c.id is not null";
		$order = " order by c.id ";
		$query = $this->db->query($sql . $q . $order . $limit);
		$result['data'] = $query->result();
		$result['jumlah'] = $this->db->query($sql . $q)->num_rows();
		return $result;
	}

	function update_data_kecamatan($data) {
		if ($data['id'] === false) {
			// insert
			$this->db->insert('tb_kecamatan', $data);
			$id = $this->db->insert_id();
		} else {
			// Update
			$id = $data['id'];
			$this->db->where('id', $data['id'])->update('tb_kecamatan', $data);
		}

		return $id;
	}

	function delete_data_kecamatan($id) {
		$this->db->where('id', $id)->delete('tb_kecamatan');
	}

	function get_auto_kecamatan($q, $start, $limit) {
		$limit = " limit $start , $limit";
		$sql = "select c.*, IFNULL(k.nama, '') as kabupaten,
            IFNULL(p.nama, '') as provinsi
            from tb_kecamatan c
            join tb_kabupaten_kota k on (k.id = c.id_kabupaten_kota)
            join tb_provinsi p on (p.id = k.id_provinsi)
            where c.nama like ('%$q%')  order by c.nama";
		$data['data'] = $this->db->query($sql . $limit)->result();
		$data['total'] = $this->db->query($sql)->num_rows();
		return $data;
	}

	/* Kecamatan */

	/* Kelurahan */

	function get_kelurahan($id) {
		$sql = "select kl.*, IFNULL(c.nama, '') as kecamatan,
                IFNULL(k.nama, '') as kabupaten, IFNULL(p.nama, '') as provinsi
                from tb_kelurahan kl
                join tb_kecamatan c on (kl.id_kecamatan = c.id)
                join tb_kabupaten_kota k on (k.id = c.id_kabupaten_kota)
                join tb_provinsi p on (p.id = k.id_provinsi)
                where kl.id = '" . $id . "'";
		return $this->db->query($sql)->row();
	}
	function get_list_kelurahan($limit, $start, $search) {
		$q = '';

		if ($search['pencarian'] !== '') {
			$q = " and kl.nama like '%" . $search['pencarian'] . "%' or c.nama like '%" . $search['pencarian'] . "%' ";
		}

		$limit = " limit $start , $limit";

		$sql = "select kl.*, IFNULL(c.nama, '') as kecamatan,
                IFNULL(k.nama, '') as kabupaten, IFNULL(p.nama, '') as provinsi
                from tb_kelurahan kl
                join tb_kecamatan c on (kl.id_kecamatan = c.id)
                join tb_kabupaten_kota k on (k.id = c.id_kabupaten_kota)
                join tb_provinsi p on (p.id = k.id_provinsi)
                where kl.id is not null";
		$order = " order by kl.id ";
		$query = $this->db->query($sql . $q . $order . $limit);
		$result['data'] = $query->result();
		$result['jumlah'] = $this->db->query($sql . $q)->num_rows();
		return $result;
	}

	function update_data_kelurahan($data) {
		if ($data['id'] === false) {
			// insert
			$this->db->insert('tb_kelurahan', $data);
			$id = $this->db->insert_id();
		} else {
			// Update
			$id = $data['id'];
			$this->db->where('id', $data['id'])->update('tb_kelurahan', $data);
		}

		return $id;
	}

	function delete_data_kelurahan($id) {
		$this->db->where('id', $id)->delete('tb_kelurahan');
	}

	function get_auto_kelurahan($q, $start, $limit) {
		$limit = " limit $start , $limit";
		$sql = "select kl.*, IFNULL(c.nama, '') as kecamatan, k.id as id_kabupaten,
            IFNULL(k.nama, '') as kabupaten, IFNULL(p.nama, '') as provinsi
            from tb_kelurahan kl
            join tb_kecamatan c on (kl.id_kecamatan = c.id)
            join tb_kabupaten_kota k on (k.id = c.id_kabupaten_kota)
            join tb_provinsi p on (p.id = k.id_provinsi)
            where (kl.nama like ('%$q%')) and (k.id = 3603 or k.id = 3671 or k.id = 3674) order by kl.nama";
		$data['data'] = $this->db->query($sql . $limit)->result();
		$data['total'] = $this->db->query($sql)->num_rows();
		return $data;
	}

	function generate_id_kelurahan() {

		$sql = "select max(id) as jumlah from tb_kelurahan";
		$db = $this->db->query($sql)->row();
		return str_pad($db->jumlah + 1, 4, "0", STR_PAD_LEFT);
	}

	/* Kelurahan */

	/* Pendidikan */

	function get_list_pendidikan($limit, $start, $search) {
		$limit = " limit $start , $limit";
		$q = "";
		if ($search['pencarian'] !== '') {
			$q .= " and nama like '%" . $search['pencarian'] . "%' ";
		}

		$sql = "select * from tb_pendidikan where id is not null $q";
		$order = " order by nama ";
		$query = $this->db->query($sql . $order . $limit);
		$result['data'] = $query->result();
		$result['jumlah'] = $this->db->query($sql)->num_rows();
		return $result;
	}

	function update_data_pendidikan($data) {
		if ($data['id'] === false) {
			// insert
			$this->db->insert('tb_pendidikan', $data);
			$id = $this->db->insert_id();
		} else {
			// Update
			$id = $data['id'];
			$this->db->where('id', $data['id'])->update('tb_pendidikan', $data);
		}

		return $id;

	}

	function delete_data_pendidikan($id) {
		$this->db->where('id', $id)->delete('tb_pendidikan');
	}

	function get_auto_pendidikan($q, $start, $limit) {
		$limit = " limit $start, $limit";
		$sql = "select * from tb_pendidikan
            where nama like ('%$q%')  order by nama ";
		$data['data'] = $this->db->query($sql . $limit)->result();
		$data['total'] = $this->db->query($sql)->num_rows();
		return $data;
	}

	/* Pendidikan */

	/* Pekerjaan */

	function get_list_pekerjaan($limit, $start, $search) {
		$limit = " limit $start , $limit";
		$q = "";
		if ($search['pencarian'] !== '') {
			$q .= " and nama like '%" . $search['pencarian'] . "%' ";
		}

		$sql = "select * from tb_pekerjaan where id is not null $q";
		$order = " order by nama ";
		$query = $this->db->query($sql . $order . $limit);
		$result['data'] = $query->result();
		$result['jumlah'] = $this->db->query($sql)->num_rows();
		return $result;
	}

	function update_data_pekerjaan($data) {
		if ($data['id'] === false) {
			// insert
			$this->db->insert('tb_pekerjaan', $data);
			$id = $this->db->insert_id();
		} else {
			// Update
			$id = $data['id'];
			$this->db->where('id', $data['id'])->update('tb_pekerjaan', $data);
		}

		return $id;

	}

	function delete_data_pekerjaan($id) {
		$this->db->where('id', $id)->delete('tb_pekerjaan');
	}

	function get_auto_pekerjaan($q, $start, $limit) {
		$limit = " limit $start, $limit";
		$sql = "select * from tb_pekerjaan
            where nama like ('%$q%')  order by nama ";
		$data['data'] = $this->db->query($sql . $limit)->result();
		$data['total'] = $this->db->query($sql)->num_rows();
		return $data;
	}
	/* Pekerjaan */

	public function get_auto_dokter($q, $start, $limit)
    {
        $limit = " limit " . $start . ", " . $limit;
        $select = "select p.*";
        $count = "select count(p.id) as count ";
        $sql = "from tb_pegawai p 
        		where p.nama like ('%" . $q . "%') and (p.is_dokter = 'Ya')
        		order by p.nama";
        $data["data"] = $this->db->query($select . $sql . $limit)->result();
        $data["total"] = $this->db->query($count . $sql)->row()->count;
        return $data;
    }

}

/* End of file M_masterdata.php */
/* Location: ./application/models/M_masterdata.php */