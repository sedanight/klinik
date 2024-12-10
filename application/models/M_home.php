<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_home extends CI_Model {

	public function get_atribute_clinic()
    {
        $sql = "select cl.*, 
        		k.nama as kelurahan, kb.nama as kabupaten, p.nama as propinsi
        		from tb_clinic cl
        		left join tb_kelurahan k on (cl.id_kelurahan = k.id)
        		left join tb_kecamatan kc on (k.id_kecamatan = kc.id)
        		left join tb_kabupaten_kota kb on (kc.id_kabupaten_kota = kb.id)
        		left join tb_provinsi p on (kb.id_provinsi = p.id)
        		where cl.aktif = 'Ya'";
        return $this->db->query($sql)->row();
    }

	function get_data_moduls($id_group) {
		$sql = "select m.* from tb_moduls m
				join tb_privileges p on (m.id = p.id_moduls)
				join tb_grant_privileges g on (p.id = g.id_privileges)
				where g.id_group_users = '" . $id_group . "'
				group by m.id order by m.urut";
		return $this->db->query($sql)->result();
	}

	function get_data_privileges($id_group, $id_moduls) {
		$sql = "select p.* from tb_privileges p
				join tb_grant_privileges g on (p.id = g.id_privileges)
				where g.id_group_users = '" . $id_group . "'
				and p.id_moduls = '" . $id_moduls . "'
				order by p.urutan asc, p.menu asc";
		return $this->db->query($sql)->result();
	}

	function get_foto_profil()
	{
		$sql = "select fp.nama, fp.id_pegawai
				from tb_foto_profil fp
				join tb_pegawai p on p.id = fp.id_pegawai
				where fp.id_pegawai = '".$this->session->userdata('id_user')."'";
		return $this->db->query($sql)->row();
	}

	function simpan_upload($image){
        $data = array(
        		'id_pegawai' => $this->session->userdata('id_user'),
                'nama' => $image
            );  
        $this->db->insert('tb_foto_profil', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function get_last_exist_data_pendaftaran()
    {
        $sql = "select date(waktu_daftar) as tanggal
        		from tb_pendaftaran order by id desc limit 1";
        return $this->db->query($sql);
    }

    public function data_pasien_lama_baru($tgl)
    {
        $data = array();
        foreach ($tgl as $key => $value) {
            $sqllama = "select count(*) as data from tb_pendaftaran
            			where id_pasien is not NULL and date(waktu_daftar) = '" . $value . "' and status = 'Lama'";
            $sqlbaru = "select count(*) as data from tb_pendaftaran
            			where id_pasien is not NULL and date(waktu_daftar) = '" . $value . "' and status = 'Baru'";
            $data["lama"][] = (int) $this->db->query($sqllama)->row()->data;
            $data["baru"][] = (int) $this->db->query($sqlbaru)->row()->data;
        }
        return $data;
    }

    public function jumlah_data_pasien()
    {
    	$sql = "select count(*) as jumlah_pasien from tb_pasien";
    	return $this->db->query($sql)->row();
    }

    public function jumlah_pendapatan_perhari()
    {
        $waktu = date('Y-m-d');
        $sql = "select sum(total) as total_perhari from tb_pembayaran where date(tanggal_bayar) = '".$waktu."'";
        return $this->db->query($sql)->row();
    }

    public function jumlah_pendapatan_all()
    {
        $sql = "select sum(total) as total from tb_pembayaran";
        return $this->db->query($sql)->row();
    }

}

/* End of file M_home.php */
/* Location: ./application/models/M_home.php */