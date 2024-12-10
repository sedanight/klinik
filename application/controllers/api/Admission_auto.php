<?php

defined("BASEPATH") or exit("No direct script access allowed");
require APPPATH . "/libraries/REST_Controller.php";
class Admission_auto extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->limit = 20;
        $this->load->model(array("M_admission"));
        $id_user = $this->session->userdata("id_user");
        if (empty($id_user)) {
            $this->response(array("error" => "Anda belum login"), 401);
        }
    }
    private function start($page)
    {
        return ($page - 1) * $this->limit;
    }
    public function pasien_auto_get()
    {
        $q = get_safe("q");
        $start = $this->start(get_safe("page"));
        $data = $this->M_admission->get_auto_pasien($q, $start, $this->limit);
        $this->response($data, 200);
    }
}

?>