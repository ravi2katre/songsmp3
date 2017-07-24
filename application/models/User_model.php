<?php 

class User_model extends MY_Model {
    public function get($id)
    {

            $table_name = 'users';


        $row = $this->db->where('id',$id)->limit(1)->get($table_name);
        return $row->row_array();
    }
}