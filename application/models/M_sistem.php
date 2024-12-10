<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_sistem extends CI_Model {

	function get_list_group_user($limit, $start, $search){
        $limit = " limit $start , $limit";
        $q = "";
        if ($search['pencarian'] !== '') {
            $q .= " and nama like '%".$search['pencarian']."%' ";
        }

        $sql = "select * from tb_group_users where id is not null $q";
        $order = " order by nama ";
        $query = $this->db->query($sql.$order.$limit);
        $result['data'] = $query->result();
        $result['jumlah'] = $this->db->query($sql)->num_rows();
        return $result;
    }

    function get_group_user_privileges($id_group){
        $sql = "select p.*,m.nama as module, g.id_group_users from tb_privileges p
                join tb_moduls m on (m.id = p.id_moduls)
                left join tb_grant_privileges g on 
                (p.id = g.id_privileges and g.id_group_users = '".$id_group."')
                order by m.id, p.menu";

        return $this->db->query($sql)->result();
    }

    function update_data_group_user($data){
        if ($data['id'] === false) {
            // insert
            $this->db->insert('tb_group_users', $data);
            $id = $this->db->insert_id();
        }else{
            // Update
            $id = $data['id'];
            $this->db->where('id', $data['id'])->update('tb_group_users', $data);
        }

        return $id;
    
    }

    function update_data_group_user_privileges($data){
        $this->db->trans_begin();
        $this->db->where('id_group_users', $data['id_group'])->delete('tb_grant_privileges');

        // insert tabel tb_grant_privileges
        if (is_array($data['privileges'])) {
            foreach ($data['privileges'] as $key => $value) {
                $add = array(
                        'id_group_users' => $data['id_group'],
                        'id_privileges' => $value
                    );

                $this->db->insert('tb_grant_privileges', $add);
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 'failed';
        } else {
            $this->db->trans_commit();
            return 'success';
        }
    }

    function delete_data_group_user($id){
        $this->db->where('id', $id)->delete('tb_group_users');
    }

    /* User */
    function get_user($id)
    {
        $sql = "select u.id, u.username, p.nama, un.nama as unit,  
                g.nama as group_user, u.id_group_users
                from tb_users u 
                join tb_pegawai p on (p.id = u.id) 
                join tb_group_users g on (u.id_group_users = g.id) 
                join tb_units un on (u.id_unit = un.id) 
                where u.id = '".$id."'";
        return $this->db->query($sql)->row();
    }

    function get_list_users($limit, $start, $search){
        $q = '';
        $limit = " limit $start , $limit";

        if ($search['pencarian'] !== '') {
            $q = " and u.username like '%".$search['pencarian']."%' or p.nama like '%".$search['pencarian']."%' 
                   or g.nama like '%".$search['pencarian']."%' ";
        }

        $sql = "select u.id, u.username, p.nama, un.nama as unit,
                g.nama as group_user, u.id_group_users
                from tb_users u 
                join tb_pegawai p on (p.id = u.id) 
                join tb_group_users g on (u.id_group_users = g.id) 
                join tb_units un on (u.id_unit = un.id) 
                where u.id is not null $q";
        $order = " order by u.username ";
        $query = $this->db->query($sql.$order.$limit);
        $result['data'] = $query->result();
        $result['jumlah'] = $this->db->query($sql)->num_rows();
        return $result;
    }

    function hash_string($string)
    {
        $hash_string = password_hash($string, PASSWORD_BCRYPT, ['cost' => 9]);
        return $hash_string;
    }

    function hash_verify($plain_text, $hashed_string)
    {
        $hashed_string = password_verify($plain_text, $hashed_string);
        return $hashed_string;
    }

    function update_data_user($data , $tipe){
        if ($tipe === 'insert') {
            // insert
            $data['password'] = getHashedPassword('1234');
            $this->db->insert('tb_users', $data);
        }else{
            // Update
            $this->db->where('id', $data['id'])->update('tb_users', $data);
        }

        return $data['id'];
    }

    function delete_data_user($id){
        $this->db->where('id', $id)->delete('tb_users');
    }

    function get_auto_users($q, $group, $start, $limit){
        $limit = " limit $start, $limit";

        $gr = "";
        if($group !== ''){
            $gr = " and g.nama like ('%$group%') ";
        }

        $sql = "select u.id, u.username, p.nama,  
                g.nama as group_user, u.id_unit, u.id_group_users
                from tb_users u
                join tb_pegawai p on (p.id = u.id)
                join tb_group_users g on (u.id_group_users =  g.id) 
                where p.nama like ('%$q%') 
                $gr
                order by p.nama";
        $data['data'] = $this->db->query($sql.$limit)->result();
        $data['total'] = $this->db->query($sql)->num_rows();
        return $data;
    }

    function get_group_user($q, $start, $limit){
        $limit = " limit $start, $limit";
        $sql = "select * from tb_group_users where nama like ('%$q%') order by nama";
        $data['data'] = $this->db->query($sql.$limit)->result();
        $data['total'] = $this->db->query($sql)->num_rows();
        return $data;
    }

    function user_reset_password($id){
        $data = array('password' => getHashedPassword('1234'));
        $this->db->where('id', $id)->update('tb_users', $data);
    }

    function cek_username($username)
    {
        $sql = "select * from tb_users 
                where username = '".$username."'";
        return $this->db->query($sql)->row();
    }

    function get_list_data_session($limit, $start){
        $q = '';
        $limit = " limit $start , $limit";

        $sql = "select * from tb_session";
        $order = " order by tanggal_login desc";
        $query = $this->db->query($sql.$order.$limit);
        $result['data'] = $query->result();
        $result['jumlah'] = $this->db->query($sql)->num_rows();
        return $result;
    }
}

/* End of file M_sistem.php */
/* Location: ./application/models/M_sistem.php */


