<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Sistem_auto extends REST_Controller{
    function __construct(){
        parent::__construct();
        $this->limit = 20;
        $this->load->model('M_sistem');
        $id_user = $this->session->userdata('id_user');
        if (empty($id_user)) {
            $this->response(array('error' => 'Anda belum login'), 401);
        }
    }

    private function start($page){
        return (($page - 1) * $this->limit);
    }
    
    function users_auto_get(){
        $q = get_safe('q');
        $group = get_safe('group');
        $start = $this->start(get_safe('page'));
        $data = $this->M_sistem->get_auto_users($q, $group, $start, $this->limit);
        if ((get_safe('page') == 1) & ($q == '')) {
            $pilih[] = array('id'=>'', 'nama' =>' ', 'grup' => '');
            $data['data'] = array_merge($pilih, $data['data']);
            $data['total'] += 1;
        }
        $this->response($data, 200);
    }
    
    function group_user_auto_get() {
        $q = get_safe('q');
        $start = $this->start(get_safe('page'));
        $data = $this->M_sistem->get_group_user($q, $start, $this->limit);
        if ((get_safe('page') == 1) & ($q == '')) {
            $pilih[] = array('id'=>'', 'nama' =>' ');
            $data['data'] = array_merge($pilih, $data['data']);
            $data['total'] += 1;
        }
        $this->response($data, 200);
    }


}