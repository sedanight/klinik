<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Sistem extends REST_Controller{
    function __construct(){
        parent::__construct();
        $this->limit = 10;
        $this->limit_session = 5;
        $this->load->model(array('M_sistem'));

        $id_user = $this->session->userdata('id_user');
        if (empty($id_user)) {
            $this->response(array('error' => 'Anda belum login'), 401);
        }
    }

    /* Account */
    function group_users_get(){
        if(!$this->get('page')){
            $this->response(NULL, 400);
        }     

        $start = ($this->get('page') - 1) * $this->limit;
        $search = array(
            'pencarian' => get_safe('pencarian')
        );

        $data = $this->M_sistem->get_list_group_user($this->limit, $start, $search);
        $data['page'] = (int)$this->get('page');
        $data['limit'] = $this->limit;
        
        if($data){
            $this->response($data, 200); // 200 being the HTTP response code
        }else{
            $this->response(array('error' => 'Data tidak ditemukan!'), 404);
        }
    }

    function group_user_get(){
        if(!$this->get('id')){
            $this->response(NULL, 400);
        }
        
        $data['data'] = $this->db->where('id', $this->get('id'))->get('tb_group_users')->row();
        $data['page'] = 1;
        $data['limit'] = $this->limit;
        if($data){
            $this->response($data, 200); // 200 being the HTTP response code
        }else{
            $this->response(array('error' => 'Data tidak ditemukan'), 404);
        }
    }

    function group_user_post(){
        $add = array(
                'id' => $this->get('id'),
                'nama' => post_safe('nama_group')
            );
        $id = $this->M_sistem->update_data_group_user($add);
        $message = array('id' => $id);
        
        $this->response($message, 200); // 200 being the HTTP response code
    }

    function group_user_privileges_get(){
        if(!$this->get('id')){
            $this->response(NULL, 400);
        }
        
        $data = $this->M_sistem->get_group_user_privileges($this->get('id'));
   
        if($data){
            $this->response($data, 200); // 200 being the HTTP response code
        }else{
            $this->response(array('error' => 'Tidak ada data'), 404);
        }
    }

    function group_user_privileges_post(){
       $add = array(
            'id_group' => $this->get('id'),
            'privileges' => post_safe('data'),
        );
        $result = $this->M_sistem->update_data_group_user_privileges($add);
        $this->response(array('response'=>$result), 200);
    }

    function group_user_delete(){
        $this->M_sistem->delete_data_group_user($this->get('id'));
        
    }

    /* User */
    function user_get(){
        if(!$this->get('id')){
            $this->response(NULL, 400);
        }
        $data['data'] = $this->M_sistem->get_user($this->get('id'));
        $data['page'] = 1;
        $data['limit'] = $this->limit;
        if($data){
            $this->response($data, 200); // 200 being the HTTP response code
        }else{
            $this->response(array('error' => 'Tidak ada data'), 404);
        }
    }

    function users_get(){
        if(!$this->get('page')){
            $this->response(NULL, 400);
        }

        $search = array(
            'pencarian' => get_safe('pencarian')
        );

        $start = ($this->get('page') - 1) * $this->limit;

        $data = $this->M_sistem->get_list_users($this->limit, $start, $search);
        $data['page'] = (int)$this->get('page');
        $data['limit'] = $this->limit;
        
        if($data){
            $this->response($data, 200); // 200 being the HTTP response code
        }else{
            $this->response(array('error' => 'Couldn\'t find any users!'), 404);
        }
    }

    function user_post(){
        if (!$this->get('id')) {
             // insert
            $id_get = post_safe('id_pegawai');
            $tipe = 'insert';
           
        }else{
            // edit
            $id_get = $this->get('id');
            $tipe = 'edit';
        }
        $add = array(
                'id' => $id_get,
                'username' => post_safe('username'),
                'id_group_users' => post_safe('group'),
                'id_unit' => post_safe('unit')
            );
        $id = $this->M_sistem->update_data_user($add, $tipe);
        $message = array('id' => $id);
        
        $this->response($message, 200); // 200 being the HTTP response code
    }

    function user_delete(){
        $this->M_sistem->delete_data_user($this->get('id'));
        
    }

    function cek_username_get()
    {
        if(!$this->get('username')){
            $this->response(NULL, 400);
        }

        $data['data'] = $this->M_sistem->cek_username($this->get('username'));

        if($data){
            $this->response($data, 200); // 200 being the HTTP response code
        }else{
            $this->response(array('error' => 'Tidak ada data'), 404);
        }
    }

    function user_reset_password_get(){
        $this->M_sistem->user_reset_password($this->get('id'));
        
    }

    function list_data_session_get(){
        if(!$this->get('page')){
            $this->response(NULL, 400);
        }

        $start = ($this->get('page') - 1) * $this->limit;

        $data = $this->M_sistem->get_list_data_session($this->limit, $start);
        $data['page'] = (int)$this->get('page');
        $data['limit'] = $this->limit;
        
        if($data){
            $this->response($data, 200); // 200 being the HTTP response code
        }else{
            $this->response(array('error' => 'Couldn\'t find any users!'), 404);
        }
    }

}