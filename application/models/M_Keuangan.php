<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Keuangan extends CI_Model {

    function get_status_pembayaran()
    {
        $data = array(
            '' => 'Semua',
            'Tagihan' => 'Belum Lunas',
            'Terbayar' => 'Lunas' 
        );

        return $data;
    }

	function get_list_pembayaran($limit, $start, $search)
	{
		$q = '';
        $limitation = "";

        if (($search['akhir'] !== '') & ($search['akhir'] !== '') ){
            $q .= " and date(pd.waktu_daftar) between '". date2mysql($search['awal']) ."' and '". date2mysql($search['akhir']) ."' ";
        }

        if ($search['id'] !== '') {
            $q .= " and pd.id = '".$search['id']."' ";
        }

        if ($search['no_register'] !== '') {
            $q .= " and pd.no_register = '".$search['no_register']."' ";
        }

        if ($search['no_rm'] !== '') {
            $q .= " and p.id like '%".$search['no_rm']."%' ";
        }

        if ($search['nama'] !== '') {
            $q .= " and nama like '%".$search['nama']."%' ";
        }

        if ($search["status_pembayaran"] !== "") {
            $q .= " and pem.status = '" . $search["status_pembayaran"] . "' ";
        }

        if ($limit !== NULL) {
            $limitation = " limit " . $start . " , " . $limit;
        }

        // $limit = " limit $start , $limit";

        $sql = "select pd.*, 
        		p.nama, 
        		lp.id as id_layanan_pendaftaran, lp.cara_bayar, 
        		pem.status as status_pembayaran, pem.tanggal_bayar,
                pem.pemeriksaan, pem.tindakan, pem.obat_obatan, pem.laboratorium, pem. administrasi,
                pem.total, pem.kembalian, pem.terbayar, pem.status, pem.keterangan, pem.tanggal_bayar
        		from tb_pendaftaran pd 
        		join tb_pasien p on (pd.id_pasien = p.id) 
        		left join tb_layanan_pendaftaran lp on (lp.id_pendaftaran = pd.id) 
        		left join tb_pembayaran pem on (lp.id = pem.id_layanan_pendaftaran)
                where lp.id is not null $q 
                group by lp.id";


        $order = " order by pd.waktu_daftar desc";
        //echo $sql.$q.$order.$limit;
        $query = $this->db->query($sql.$order.$limitation);
        $result['data'] = $query->result();
        $result['jumlah'] = $this->db->query($sql)->num_rows();
        return $result;
	}

    function get_pembayaran_detail($id)
    {
        $q = '';
        // data pendaftaran
        $sql = "select pd.*, p.nama, p.alamat,
                p.telp, lp.no_antri 
                from tb_pendaftaran pd 
                join tb_layanan_pendaftaran lp on (lp.id_pendaftaran = pd.id) 
                join tb_pasien p on (pd.id_pasien = p.id)
                where lp.id = '".$id."'";
        $data['pendaftaran'] = $this->db->query($sql)->row();

        return $data;
    }

    function update_data_pembayaran($data)
    {
        $id = $data['id_layanan_pendaftaran'];
        $this->db->where('id_layanan_pendaftaran', $id)->update('tb_pembayaran', $data);
        return $id;
        
    }  

    function get_pembayaran_kwitansi($id)
     {
        $sql = "select pem.*,
                pd.no_register,
                p.nama
                from tb_pembayaran pem 
                join tb_pasien p on (pem.id_pasien = p.id)
                join tb_layanan_pendaftaran lp on (pem.id_layanan_pendaftaran = lp.id)
                join tb_pendaftaran pd on (pd.id = lp.id_pendaftaran)
                where pem.id_layanan_pendaftaran = '".$id."'";
        $data = $this->db->query($sql)->row();
        return $data;
     } 

}

/* End of file M_Keuangan.php */
/* Location: ./application/models/M_Keuangan.php */