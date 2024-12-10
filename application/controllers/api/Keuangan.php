<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Keuangan extends REST_Controller{
    function __construct(){
        parent::__construct();
        $this->limit = 10;
        $this->load->model(array('M_keuangan'));

        $id_user = $this->session->userdata('id_user');
        if (empty($id_user)) {
            $this->response(array('error' => 'Anda belum login'), 401);
        }
    }

    private function start($page){
        return (($page - 1) * $this->limit);
    }

    /* Pembayaran */
    function pembayaran_list_get(){
        if(!$this->get('page')){
            $this->response(NULL, 400);
        }

        $search = array(
               'id' => get_safe('id'),
               'awal' => get_safe('awal'),
               'akhir' => get_safe('akhir'),
               'no_register' => get_safe('no_register'),
               'no_rm' => get_safe('no_rm'),
               'nama' => get_safe('nama'),
               'status_pembayaran' => get_safe('status_pembayaran')

            );

        $start = $this->start($this->get('page'));

        $data = $this->M_keuangan->get_list_pembayaran($this->limit, $start, $search);
        $data['page'] = (int)$this->get('page');
        $data['limit'] = $this->limit;
        
        if($data){
            $this->response($data, 200); // 200 being the HTTP response code
        }else{
            $this->response(array('error' => 'Data tidak ditemukan'), 404);
        }
    }

    function pembayaran_detail_get(){
        if(!$this->get('id')){
            $this->response(NULL, 400);
        }
        
        $data = $this->M_keuangan->get_pembayaran_detail($this->get('id'));
        if($data){
            $this->response($data, 200); // 200 being the HTTP response code
        }else{
            $this->response(array('error' => 'Tidak ada data'), 404);
        }
    }

    function pembayaran_post()
    {
    	$waktu = date('Y-m-d H:i:s');
        $id = $this->get('id');
        $pemeriksaan = ((post_safe('pemeriksaan') !== '')?currencyToNumber(post_safe('pemeriksaan')):0);
        $tindakan = ((post_safe('tindakan') !== '')?currencyToNumber(post_safe('tindakan')):0);
        $obat_obatan = ((post_safe('obat_obatan') !== '')?currencyToNumber(post_safe('obat_obatan')):0);
        $laboratorium = ((post_safe('laboratorium') !== '')?currencyToNumber(post_safe('laboratorium')):0);
        $administrasi = ((post_safe('administrasi') !== '')?currencyToNumber(post_safe('administrasi')):0);
        $kembalian = ((post_safe('kembalian') !== '')?currencyToNumber(post_safe('kembalian')):0);
        $total = ((post_safe('total') !== '')?currencyToNumber(post_safe('total')):0);
        $terbayar = ((post_safe('terbayar') !== '')?currencyToNumber(post_safe('terbayar')):0);

        $add = array(
            'id_layanan_pendaftaran' => $id,
            'sudah_diterima_dari' => post_safe('sudah_diterima'), 
            'pemeriksaan' => $pemeriksaan, 
            'tindakan' => $tindakan, 
            'obat_obatan' => $obat_obatan, 
            'laboratorium' => $laboratorium, 
            'administrasi' => $administrasi, 
            'total' => $total, 
            'kembalian' => $kembalian, 
            'terbayar' => $terbayar, 
            'status' => 'Terbayar', 
            'keterangan' => post_safe('keterangan'), 
            'tanggal_bayar' => $waktu 
        );  

        // var_dump($add);
        $id = $this->M_keuangan->update_data_pembayaran($add);
        $message = array('id' => $id);

        $this->response($message, 200);  
    }

   

}