<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Masterdata_auto extends REST_Controller{
    function __construct(){
        parent::__construct();
        $this->limit = 20;

        $this->load->model('M_masterdata');

        $id_user = $this->session->userdata('id_user');
        if (empty($id_user)) {
            $this->response(array('error' => 'Anda belum login'), 401);
        }
    }

    private function start($page){
        return (($page - 1) * $this->limit);
    }

    function unit_auto_get(){
        $q = get_safe('q');
        $start = $this->start(get_safe('page'));
        $data = $this->M_masterdata->get_auto_unit($q, $start, $this->limit);
        if ((get_safe('page') == 1) & ($q == '')) {
            $pilih[] = array('id'=>'', 'nama' =>' Semua Instalasi ');
            $data['data'] = array_merge($pilih, $data['data']);
            $data['total'] += 1;
        }
        $this->response($data, 200);
    }

    function pegawai_auto_get(){
        $q = get_safe('q');
        $start = $this->start(get_safe('page'));
        $var   = get_safe('param');
        $param = isset($var)?$var:NULL;
        $data = $this->M_masterdata->get_auto_pegawai($q, $start, $this->limit, $param);
        if ((get_safe('page') == 1) & ($q == '')) {
            $pilih[] = array('id'=>'', 'nama' =>' ');
            $data['data'] = array_merge($pilih, $data['data']);
            $data['total'] += 1;
        }
        $this->response($data, 200);
    }

    function provinsi_auto_get(){
        $q = get_safe('q');
        $start = $this->start(get_safe('page'));
        $data = $this->M_masterdata->get_auto_provinsi($q, $start, $this->limit);
        if ((get_safe('page') == 1) & ($q == '')) {
            $pilih[] = array('id'=>'', 'nama' =>' ');
            $data['data'] = array_merge($pilih, $data['data']);
            $data['total'] += 1;
        }
        $this->response($data, 200);
    }

    function kabupaten_kota_auto_get(){
        $q = get_safe('q');
        $start = $this->start(get_safe('page'));
        $data = $this->M_masterdata->get_auto_kabupaten_kota($q, $start, $this->limit);
        if ((get_safe('page') == 1) & ($q == '')) {
            $pilih[] = array('id'=>'', 'nama' =>' ', 'provinsi'=>'');
            $data['data'] = array_merge($pilih, $data['data']);
            $data['total'] += 1;
        }
        $this->response($data, 200);
    }

    function kecamatan_auto_get(){
        $q = get_safe('q');
        $start = $this->start(get_safe('page'));
        $data = $this->M_masterdata->get_auto_kecamatan($q, $start, $this->limit);
        if ((get_safe('page') == 1) & ($q == '')) {
            $pilih[] = array('id'=>'', 'nama' =>' ', 'kabupaten'=>'', 'provinsi'=>'');
            $data['data'] = array_merge($pilih, $data['data']);
            $data['total'] += 1;
        }
        $this->response($data, 200);
    }

    function kelurahan_auto_get(){
        $q = get_safe('q');
        $start = $this->start(get_safe('page'));
        $data = $this->M_masterdata->get_auto_kelurahan($q, $start, $this->limit);
        if ((get_safe('page') == 1) & ($q == '')) {
            $pilih[] = array('id'=>'', 'nama' =>' ', 'kecamatan'=>'', 'kabupaten'=>'', 'provinsi'=>'');
            $data['data'] = array_merge($pilih, $data['data']);
            $data['total'] += 1;
        }
        $this->response($data, 200);
    }

    function dokter_auto_get()
    {
        $q = get_safe("q");
        $start = $this->start(get_safe("page"));
        $data = $this->M_masterdata->get_auto_dokter($q, $start, $this->limit);
        if (get_safe("page") == 1 & $q == "") {
            $pilih[] = array("id" => "", "nama" => " ");
            $data["data"] = array_merge($pilih, $data["data"]);
            $data["total"] += 1;
        }
        $this->response($data, 200);
    }

}