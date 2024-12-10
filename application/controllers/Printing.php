<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Printing extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model(array('M_admission','M_keuangan'));
    }
    
    /* Pendaftaran */
    function hasil_pemeriksaan($id_pendaftaran){
        if ($id_pendaftaran !== null) {
            $data['title'] = 'Hasil Pemeriksaan';
            $data["clinic"] = $this->M_home->get_atribute_clinic();
            $pendaftaran = $this->M_admission->get_hasil_detail($id_pendaftaran);
            $data['pasien'] = $pendaftaran['pasien'];
            $this->load->view('printing/pendaftaran/hasil_pemeriksaan', $data);
        }
    }

    public function no_antri($id_pendaftaran, $id_layanan)
    {
        if ($id_pendaftaran !== NULL) {
            $data["title"] = "Cetak Nomor Antrian";
            $data["clinic"] = $this->M_home->get_atribute_clinic();
            $pendaftaran = $this->M_admission->get_pendaftaran_detail($id_pendaftaran, $id_layanan);
            $data["pasien"] = $pendaftaran["pasien"];
            $data["layanan"] = $pendaftaran["layanan"];
            $this->load->view("printing/pendaftaran/no_antri", $data);
        }
    }

    public function sks($id_sks)
    {
        if ($id_sks !== NULL) {
            $data["title"] = "Surat Keterangan Sakit";
            $data["clinic"] = $this->M_home->get_atribute_clinic();
            $data['sks'] = $this->M_admission->get_sks_pasien($id_sks);
            $this->load->view("printing/pendaftaran/surat_keterangan_sakit", $data);
        }
    }

    /* Pendaftaran */

    /* Keuangan */

    public function kwitansi_pembayaran($id_layanan)
    {
        if ($id_layanan !== NULL) {
            $data["title"] = "Kwitansi Pembayaran";
            $data["clinic"] = $this->M_home->get_atribute_clinic();
            $data['pembayaran'] = $this->M_keuangan->get_pembayaran_kwitansi($id_layanan);
            $this->load->view("printing/pembayaran/nota_pembayaran", $data);
        }
    }

    /* Keuangan */
   

}
