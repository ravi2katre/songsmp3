<?php 

class Pages_model extends MY_Model {
    public $table;
    public function __construct()
    {
        parent::__construct();
        //$this->table = get_Class($this);
        $this->table = preg_replace("/_model$/", '', strtolower(get_Class($this)) );
        //var_dump($this->table);
        $this->load->database();
    }
    public function find($id,$table_name="")
    {
        if($table_name=="")
            $table_name = $this->table;


        $row = $this->db->where('id',$id)->limit(1)->get($table_name);
        return $row->row_array();
    }
    public function save($data,$table_name="")
    {
        if($table_name=="")
        {
            $table_name = $this->table;
        }
        $op = 'update';
        $keyExists = FALSE;
        $fields = $this->db->field_data($table_name);

        foreach ($fields as $field)
        {
            if($field->primary_key==1)
            {
                $keyExists = TRUE;
                if(isset($data[$field->name]))
                {
                    $this->db->where($field->name, $data[$field->name]);
                }
                else
                {
                    $op = 'insert';
                }
            }
        }
        if($keyExists && $op=='update')
        {
            $this->db->set($data);
            $this->db->update($table_name);
            if($this->db->affected_rows()==1)
            {
                return $this->db->affected_rows();
            }
        }
        $this->db->insert($table_name,$data);
        return $this->db->affected_rows();
    }

    public function search($conditions=NULL,$table_name="",$limit=500,$offset=0)
    {
        if($table_name=="")
        {
            $table_name = $this->table;
        }
        if($conditions != NULL)
            $this->db->where($conditions);

        $query = $this->db->get($table_name,$limit,$offset=0);
        return $query->result();
    }

    public function insert($data,$table_name="")
    {
        if($table_name=="")
            $table_name = $this->table;
        $this->db->insert($table_name,$data);
        return $this->db->affected_rows();
    }

    public function update($data,$conditions,$table_name="")
    {
        if($table_name=="")
            $table_name = $this->table; $this->db->where($conditions);
        $this->db->update($table_name,$data);
        return $this->db->affected_rows();
    }

    public function delete($conditions,$table_name="")
    {
        if($table_name=="")
            $table_name = $this->table;
        $this->db->where($conditions);
        $this->db->delete($table_name);
        return $this->db->affected_rows();
    }

    public function get_category_tags($condition='', $limit=500, $offset=0, $sort_by = '', $sort_order = 'desc') {
        $this->db->cache_delete();
        $this->db->cache_on();

        $condition = rtrim($condition,' AND');
        $condition = (!empty($condition))?' WHERE '.$condition:' where 1 ';

       $sql = "SELECT 
		SQL_CALC_FOUND_ROWS
		  p.name,
		  p.slug,
		  catp.page_id
          FROM cat_pages catp                 
                  LEFT JOIN  pages p ON p.id = catp.cat_id 
                   
          {$condition}         
                
        group by p.id
        ";
        $limit = " limit ".$offset.",".$limit;
        $sql = $sql.$limit;
        $ret['rows'] = $this->db->query($sql)->result_array();

        $this->db->last_query();
        $result = $this->db->query("SELECT FOUND_ROWS() as totalItems")->row_array();
        $this->db->cache_off();
        $ret['num_rows'] = $result['totalItems'];


        if(count($ret['rows']) > 0){
            foreach($ret['rows'] as $key=>$val){
                $ret['rows'][$key]['tags'] = $this->get_pages_tags("tagp.page_id=".$val['page_id']);
            }
        }


        return $ret;

    }

    public function get_pages_tags($condition='', $limit=500, $offset=0, $sort_by = '', $sort_order = 'desc') {
        $this->db->cache_delete();
        $this->db->cache_on();

        $condition = rtrim($condition,' AND');
        $condition = (!empty($condition))?' WHERE '.$condition:' where 1 ';

        $sql = "SELECT 
		SQL_CALC_FOUND_ROWS
		  t.tag
		
          FROM tag_pages tagp                 
                  LEFT JOIN  tags t ON t.id = tagp.tag_id 
                   
          {$condition}         
                
        
        ";
        $limit = " limit ".$offset.",".$limit;
        $sql = $sql.$limit;
        $ret['rows'] = $this->db->query($sql)->result_array();

        $this->db->last_query();
        $result = $this->db->query("SELECT FOUND_ROWS() as totalItems")->row_array();
        $this->db->cache_off();
        $ret['num_rows'] = $result['totalItems'];



        return $ret;

    }

}