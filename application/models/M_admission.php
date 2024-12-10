<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admission extends CI_Model {

    /* Pasien */

    public function get_pasien($id)
    {
        $sql = "select p.*,
                IFNULL(kel.nama, '') as kelurahan,
                IFNULL(kec.nama, '') as kecamatan,
                IFNULL(kab.nama, '') as kabupaten,
                IFNULL(prov.nama, '') as provinsi,
                IFNULL(pd.nama, '') as pendidikan,
                IFNULL(pk.nama, '') as pekerjaan
                from tb_pasien p
                left join tb_kelurahan kel on (kel.id = p.id_kelurahan)
                left join tb_kecamatan kec on (kec.id = kel.id_kecamatan)
                left join tb_kabupaten_kota kab on (kab.id = kec.id_kabupaten_kota)
                left join tb_provinsi prov on (prov.id = kab.id_provinsi)
                left join tb_pendidikan pd on (pd.id = p.id_pendidikan)
                left join tb_pekerjaan pk on (pk.id = p.id_pekerjaan)
                where p.id = '" . $id . "'";
        $result = $this->db->query($sql)->row();
        return $result;
    }

    public function get_list_pasien($limit, $start, $search)
    {
        $limitation = "";
        $q = "";
        if ($search["id"] !== "") {
            $q .= " and p.id like '%" . $search["id"] . "' ";
        }
        if ($search["nama"] !== "") {
            $q .= " and p.nama like '" . $search["nama"] . "%' ";
        }
        if ($search["kelamin"] !== "") {
            $q .= " and p.kelamin = '" . $search["kelamin"] . "' ";
        }
        if ($search["umur"] !== "") {
            $year_now = date("Y");
            $selisih = $year_now - $search["umur"];
            $new_param = $selisih . "-" . date("m") . "-" . date("d");
            $last_param = $selisih - 1 . "-" . date("m") . "-" . date("d");
            $q .= " and p.tanggal_lahir between '" . $last_param . "' and '" . $new_param . "'";
        }
        if ($search["alamat"] !== "") {
            $q .= " and p.alamat like '" . $search["alamat"] . "%' ";
        }
        if ($search["telp"] !== "") {
            $q .= " and p.telp like '" . $search["telp"] . "%' ";
        }
       
        if ($limit !== NULL) {
            $limitation = " limit " . $start . " , " . $limit;
        }
        $select =   "select p.*,
                    p.nama,
                    IFNULL(kel.nama, '') as kelurahan,
                    IFNULL(kec.nama, '') as kecamatan,
                    IFNULL(kab.nama, '') as kabupaten,
                    IFNULL(pd.nama, '') as pendidikan,
                    IFNULL(pk.nama, '') as pekerjaan ";
        $count = "select count(p.id) as count from tb_pasien p where p.id is not null " . $q . " ";
        $sql = "from tb_pasien p
                left join tb_kelurahan kel on (kel.id = p.id_kelurahan)
                left join tb_kecamatan kec on (kec.id = kel.id_kecamatan)
                left join tb_kabupaten_kota kab on (kab.id = kec.id_kabupaten_kota)
                left join tb_pendidikan pd on (pd.id = p.id_pendidikan)
                left join tb_pekerjaan pk on (pk.id = p.id_pekerjaan)
                where p.id is not null " . $q;
        $order = " order by p.id ";
        $query = $this->db->query($select . $sql . $q . $order . $limitation);
        $result["data"] = $query->result();
        $result["jumlah"] = $this->db->query($count)->row()->count;
        return $result;
    }


    /* Pendaftaran */
	function generate_no_register() {
		$format = date('y') . date('m') . date('d');

		$sql = "select count(*) as jumlah from tb_pendaftaran
                where date(waktu_daftar) = '" . date('Y-m-d') . "' ";
		$db = $this->db->query($sql)->row();
		return $format . str_pad($db->jumlah + 1, 4, "0", STR_PAD_LEFT);
	}

    function get_status_pasien($no_rm){
        $sql = "select count(*) as jumlah from tb_pendaftaran where id_pasien = '".$no_rm."'";
        $status = 'Baru';
        $query = $this->db->query($sql)->row();

        if ($query !== null) {
            if ($query->jumlah > 0) {
                $status = 'Lama';
            }
        }

        return $status;
    }

    function get_last_no_rm(){
        $sql = "select c.id from tb_pasien c
                inner join (
                select max(inc) as inc_max from tb_pasien
                ) mx on (mx.inc_max = c.inc )
                ";
        $no_max = $this->db->query($sql)->row();
        //return str_pad($db->no_rm+1, 8,"0",STR_PAD_LEFT);
        

        // komponen no rm
        if (isset($no_max->id)) {
            $c1 = (int)substr($no_max->id, 0,2);
            $c2 = (int)substr($no_max->id, 2,4);
            $c3 = (int)substr($no_max->id, 6,2);

       
            $no_rm = '00';

            if (($c2+1) > 9999) {
                $c2 = 1;
                $c3++;
            }else{
                $c2++;
            }

            $no_rm .= str_pad($c2, 4,"0",STR_PAD_LEFT);
        

        }else{
            // rm pertama
            $no_rm = '000001';
        }


        return $no_rm;
    }

    function get_next_antrian($data) {
        $sql = "select max(no_antri) as no_antri from 
        		tb_layanan_pendaftaran 
                where date(waktu) = '".$data['tanggal']."' ";
        //echo $sql;
        $query = $this->db->query($sql);
        $next_antrian = 0;

        if ($query->row() != null) {
            $unit = $query->row();
            $next_antrian = $unit->no_antri + 1;
        } else {
            $next_antrian = 1;
        }
        return $next_antrian;
    }

	function get_list_pendaftaran($limit, $start, $search) {
		$q = '';

		if (($search['akhir'] !== '') & ($search['akhir'] !== '')) {
			$q .= " and date(pd.waktu_daftar) between '" . date2mysql($search['awal']) . "' and '" . date2mysql($search['akhir']) . "' ";
		}

		if ($search['id'] !== '') {
			$q .= " and pd.id = '" . $search['id'] . "' ";
		}

        if ($search["no_rm"] !== "") {
            $q .= " and pd.id like '%" . $search["no_rm"] . "' ";
        }

		if ($search['no_register'] !== '') {
			$q .= " and pd.no_register = '" . $search['no_register'] . "' ";
		}

		if ($search['nama'] !== '') {
			$q .= " and p.nama like '%" . $search['nama'] . "%' ";
		}
        if ($search["status"] !== "") {
            $q .= " and lp.status = '" . $search["status"] . "' ";
        }

		$limitation = "";
		if ($limit !== NULL and $start !== NULL) {
			$limitation = " limit $start, $limit";
		}
		// $limit = " limit $start , $limit";

		$sql = "select pd.*, 
                p.nama, p.kelamin, p.alamat,
                lp.id as id_layanan, lp.no_antri, lp.status as status_pemeriksaan, lp.cara_bayar, lp.id_sks,
                u.username,
                IFNULL(lp.waktu_periksa, '') as waktu_periksa,
                IFNULL(v.anamnesa, '') as anamnesa,
                IFNULL(v.diagnosa, '') as diagnosa,
                IFNULL(v.tindakan, '') as tindakan
                from tb_pendaftaran pd
                join tb_pasien p on (pd.id_pasien = p.id)
                left join tb_layanan_pendaftaran lp on (lp.id_pendaftaran = pd.id)
                left join tb_users u on (pd.id_users = u.id)
                left join tb_visitasi v on (v.id_layanan_pendaftaran = lp.id)
                where pd.id is not null $q
                group by pd.id";

		$order = " order by pd.waktu_daftar desc";
		//echo $sql.$q.$order.$limit;
		$query = $this->db->query($sql . $order . $limitation);
		$result['data'] = $query->result();
		$result['jumlah'] = $this->db->query($sql)->num_rows();
		return $result;
	}

    function update_data_pasien($data, $upt_last_active = false){
        // if ($data['id'] === false) {
        //     // insert
        //     $data['id'] = $this->get_last_no_rm();
        //     $id = $data['id'];
        //     $this->db->insert('tb_pasien', $data);
        //     $id = $data['id'];
        // }else{
        //     // Update
        //     $id = $data['id'];
        //     $this->db->where('id', $data['id'])->update('tb_pasien', $data);
        // }

        // return $id;

        if ($data["id"] === false) {
            $data["id"] = $this->get_last_no_rm();
            $id = $data["id"];
            $data["last_active"] = date("Y-m-d");
            $this->db->insert("tb_pasien", $data);
            $id = $data["id"];
            $rekam_medis_pasien = array(
                "id" => $id, 
                "history" => NULL, 
                "last_update" => date("Y-m-d H:i:s")
            );

            $count = $this->db->where("id", $id)->get("tb_rekam_medis")->num_rows();
            if ($count < 1) {
                $this->db->insert("tb_rekam_medis", $rekam_medis_pasien);
            }
        } else {
            $id = $data["id"];
            if (substr($data["id"], 0, 2) === "14" | substr($data["id"], 0, 2) === "04" | substr($data["id"], 0, 2) === "13") {
                $data["rm_lama"] = $data["id"];
                $data["id"] = $this->get_last_no_rm();
            }
            if ($upt_last_active) {
                $data["last_active"] = date("Y-m-d");
            }
            
            $this->db->where("id", $id)->update("tb_pasien", $data);
            $id = $data["id"];
        }
        return $id;
    }

    function insert_pendaftaran($data){
        $this->db->insert('tb_pendaftaran', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function insert_layanan_pendaftaran($data){
        $this->db->insert('tb_layanan_pendaftaran', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function insert_data_pembayaran($data){
        $this->db->insert('tb_pembayaran', $data);
        $id = $this->db->insert_id();
        return $id;
    }

	public function get_auto_pasien($q, $start, $limit)
    {
        $limit = " limit " . $start . ", " . $limit;
        $w = "";
        if ($q !== "") {
            $w = "where ";
            if (is_numeric($q)) {
                $w .= "p.id like ('%" . $q . "')";
            } else {
                $w .= "p.nama like ('" . $q . "%')";
            }
        }
        $count = "select count(p.id) as count ";
        $select = "select p.*, p.nama, pd.nama as pendidikan, pk.nama as pekerjaan ";
        $sql = "from tb_pasien p 
                left join tb_pendidikan pd on (pd.id = p.id_pendidikan) 
                left join tb_pekerjaan pk on (pk.id = p.id_pekerjaan) 
                " . $w . " ";
        $order = " order by p.id";
        $data["data"] = $this->db->query($select . $sql . $order . $limit)->result();
        $data["total"] = $this->db->query($count . $sql)->row()->count;
        return $data;
    }

    public function get_pendaftaran_detail($id_pendaftaran, $id_layanan = NULL)
    {
        $q = "";
        $sql = "select pd.*, 
                p.nama, p.kelamin, p.alamat, p.telp, p.agama, p.no_identitas,
                IFNULL(kel.nama, '') as kelurahan,
                IFNULL(kec.nama, '') as kecamatan,
                IFNULL(kabb.nama, '') as kabupaten,
                IFNULL(prov.nama, '') as provinsi,
                IFNULL(pk.nama, '') as pekerjaan,               
                p.tanggal_lahir, 
                p.gol_darah
                from tb_pendaftaran pd
                join tb_pasien p on (pd.id_pasien = p.id)
                left join tb_kelurahan kel on (kel.id = p.id_kelurahan)
                left join tb_kecamatan kec on (kec.id = kel.id_kecamatan)
                left join tb_kabupaten_kota kabb on (kabb.id = kec.id_kabupaten_kota)
                left join tb_provinsi prov on (prov.id = kabb.id_provinsi)
                left join tb_pekerjaan pk on (pk.id = p.id_pekerjaan)
                where pd.id = '" . $id_pendaftaran . "' ";
        $data["pasien"] = $this->db->query($sql)->row();
        $sql_layanan = "select lp.*,
                        IFNULL(p.nama, '') as dokter,
                        IFNULL(v.anamnesa, '') as anamnesa,
                        IFNULL(v.diagnosa, '') as diagnosa,
                        IFNULL(v.tindakan, '') as tindakan
                        from tb_layanan_pendaftaran lp
                        left join tb_pegawai p on (p.id = lp.id_dokter)
                        left join tb_visitasi v on (v.id_layanan_pendaftaran = lp.id)
                        where lp.id_pendaftaran = '" . $id_pendaftaran . "' ";
        if ($id_layanan !== NULL) {
            $q = "and lp.id = '" . $id_layanan . "'";
            $layanan = $this->db->query($sql_layanan . $q)->row();
        } else {
            $layanan = $this->db->query($sql_layanan)->result();
        }
        $data["layanan"] = $layanan;
        return $data;
    }

    public function update_layanan_pendaftaran($data)
    {
        $this->db->where("id", $data["id"])->update("tb_layanan_pendaftaran", $data);
    }

    public function insert_visitasi($data)
    {
        $waktu = date("Y-m-d H:i:s");
        return $this->db->insert("tb_visitasi", $data);
        
    }

    public function update_waktu_periksa($data)
    {
        $sql = "update tb_layanan_pendaftaran set waktu_periksa='" . $data["waktu"] . "' where id='" . $data["id_layanan_pendaftaran"] . "' ";
        $this->db->query($sql);
    }

    public function update_waktu_keluar($data)
    {
        $sql = "update tb_pendaftaran set waktu_keluar='" . $data["waktu"] . "' where id='" . $data["id_pendaftaran"] . "' ";
        $this->db->query($sql);
    }

    function get_hasil_detail($id_pendaftaran) {
        $q = '';
        // data pendaftaran pasien
        $sql = "select p.id as no_rm, pd.no_register, p.nama, p.alamat, p.kelamin, pd.id, 
                pd.waktu_daftar, pd.status as status_pasien, pg.nama as dokter, 
                lp.id as id_layanan, lp. cara_bayar, lp.waktu_periksa, lp.status as status_pemeriksaan, 
                pgw.nama as users, v.anamnesa, v.diagnosa, v.tindakan 
                from tb_pasien p 
                join tb_pendaftaran pd on p.id = pd.id_pasien
                join tb_layanan_pendaftaran lp on lp.id_pendaftaran = pd.id
                left join tb_pegawai pg on pg.id = lp.id_dokter
                left join tb_pegawai pgw on pgw.id = lp.id_users
                left join tb_visitasi v on v.id_layanan_pendaftaran = lp.id
                where pd.id = '" . $id_pendaftaran . "'";

        $data['pasien'] = $this->db->query($sql)->row();
        return $data;
    }

    public function batal_pendaftaran($id)
    {
        $sql = "select count(v.id) as jumlah
                from tb_visitasi v
                join tb_layanan_pendaftaran lp on (lp.id = v.id_layanan_pendaftaran)
                join tb_pendaftaran pd on (pd.id = lp.id_pendaftaran)
                where pd.id = '" . $id . "'";
        $query = $this->db->query($sql)->row();
        $status = false;
        $message = "";
        if (0 < $query->jumlah) {
            $status = false;
            $message = "Tidak dapat membatalkan pendaftaran, pasien sudah mendapatkan tindakan";
        } 
        else {
            $this->db->trans_begin();
            $this->db->where("id", $id)->update("tb_pendaftaran", array("waktu_keluar" => date("Y-m-d H:i:s")));
            $this->db->where("id_pendaftaran", $id)->update("tb_layanan_pendaftaran", array("status" => "Batal", "id_users" => $this->session->userdata('id_user')));
            $lp = $this->db->where("id_pendaftaran", $id)->select("id")->get("tb_layanan_pendaftaran")->result();
            $id_lp = NULL;
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $status = false;
                $message = "Gagal melakukan pembatalan pendaftaran";
            } else {
                $this->db->trans_commit();
                $status = true;
                $message = "Berhasil melakukan pembatalan pendaftaran";
            }
        }
        return array("status" => $status, "message" => $message);
    }

    function update_sks($data){
        if ($data['id'] === false) {
            // insert
            $this->db->insert('tb_sks', $data);
            $id = $this->db->insert_id();
        }else{
            // Update
            $id = $data['id'];
            $this->db->where('id', $data['id'])->update('tb_sks', $data);
        }

        return $id;

        // $this->db->insert('tb_sks', $data);
        // $id = $this->db->insert_id();
        // return $id;
    }

    function get_sks_pasien($id_sks) {
        // data pendaftaran pasien
        $sql = "select p.nama, p.alamat, p.tanggal_lahir,
                IFNULL(kel.nama, '') as kelurahan,
                IFNULL(kec.nama, '') as kecamatan,
                IFNULL(kk.nama, '') as kabupaten_kota,
                IFNULL(pk.nama, '') as pekerjaan,
                sk.*, lp.id as id_layanan
                from tb_pasien p
                join tb_pendaftaran pd on (pd.id_pasien = p.id)
                left join tb_pekerjaan pk on (p.id_pekerjaan = pk.id)
                left join tb_layanan_pendaftaran lp on (pd.id = lp.id_pendaftaran)
                left join tb_kelurahan kel on (p.id_kelurahan = kel.id)
                left join tb_kecamatan kec on (kel.id_kecamatan = kec.id)
                left join tb_kabupaten_kota kk on (kec.id_kabupaten_kota = kk.id)
                left join tb_sks sk on (lp.id_sks = sk.id)
                where sk.id = '" . $id_sks . "'";

        $data = $this->db->query($sql)->row();
        return $data;
    }

    function get_list_sks($limit, $start, $search) {
        $q = '';

        if (($search['akhir'] !== '') & ($search['akhir'] !== '')) {
            $q .= " and date(pd.waktu_daftar) between '" . date2mysql($search['awal']) . "' and '" . date2mysql($search['akhir']) . "' ";
        }

        if ($search['id'] !== '') {
            $q .= " and pd.id = '" . $search['id'] . "' ";
        }

        if ($search["no_rm"] !== "") {
            $q .= " and pd.id like '%" . $search["no_rm"] . "' ";
        }

        if ($search['no_register'] !== '') {
            $q .= " and pd.no_register = '" . $search['no_register'] . "' ";
        }

        if ($search['nama'] !== '') {
            $q .= " and p.nama like '%" . $search['nama'] . "%' ";
        }

        $limitation = "";
        if ($limit !== NULL and $start !== NULL) {
            $limitation = " limit $start, $limit";
        }
        // $limit = " limit $start , $limit";

        $sql = "select p.nama, p.id as no_rm,
                pd.no_register, pd.waktu_daftar,
                sk.* 
                from tb_pendaftaran pd
                join tb_pasien p on (pd.id_pasien = p.id)
                left join tb_layanan_pendaftaran lp on (lp.id_pendaftaran = pd.id)
                left join tb_sks sk on (lp.id_sks = sk.id)
                where sk.id is not null $q
                group by sk.id";

        $order = " order by pd.waktu_daftar desc";
        //echo $sql.$q.$order.$limit;
        $query = $this->db->query($sql . $order . $limitation);
        $result['data'] = $query->result();
        $result['jumlah'] = $this->db->query($sql)->num_rows();
        return $result;
    }

    public function get_sks_by_id($id_sks)
    {
        $sql = "select sk.*
                from tb_sks sk
                where sk.id = '" . $id_sks . "' ";
        $data["sks"] = $this->db->query($sql)->row();
        return $data;
    }

    public function hapus_sks($id)
    {
        $status = false;
        $message = "";
        $this->db->trans_begin();
        $query = $this->db->where('id', $id)->delete('tb_sks');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $status = false;
            $message = "Gagal melakukan penghapusan sks";
        } else {
            $this->db->trans_commit();
            $status = true;
            $message = "Berhasil melakukan penghapusan sks";
        }
        return array("status" => $status, "message" => $message);
    }

    public function merge_pasien($param)
    {
        $message = "";
        $this->db->trans_begin();
        foreach ($param["pasien_merge"] as $key => $value) {
            $update = array("id_pasien" => $param["pasien_utama"]);
            $this->db->where("id_pasien", $value)->update("tb_pendaftaran", $update);
            $this->db->where("id_pasien", $value)->update("tb_pembayaran", $update);
            $this->db->where("id", $value)->delete("tb_rekam_medis");
            $this->db->where("id", $value)->delete("tb_pasien");
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $status = false;
            $message = "Gagal menggabungkan pasien";
        } else {
            $this->db->trans_commit();
            $status = true;
            $message = "Berhasil menggabungkan pasien";
        }
        $result = array("status" => $status, "message" => $message);
        return $result;
    }

}

/* End of file M_admission.php */
/* Location: ./application/models/M_admission.php */