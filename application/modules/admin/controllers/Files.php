<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Files extends Admin_Controller {

    public function index()
    {

    }

    public function pages()
    {
        $crud = $this->generate_crud('pages');
        //$crud->set_relation('parent_id','pages','name');

        $crud->columns('name','slug','description', 'meta_tag' ,'meta_keywords ', 'meta_description','tags');
        $crud->fields('name','slug','description', 'meta_tag' ,'meta_keywords ', 'meta_description','tags');
        $crud->set_relation_n_n('tags', 'tag_pages', 'tags', 'page_id', 'tag_id', 'tag');
        $crud->unset_texteditor('meta_tag' ,'meta_keywords', 'meta_description');

        $crud->callback_before_insert(function ($post_array)  {
            if (empty($post_array['slug'])) {
                $post_array['slug'] = create_slug($post_array['name']);
            }
            // cidb($post_array);exit;
            return $post_array;
        });

        $crud->callback_before_update(function ($post_array)  {
            if (empty($post_array['slug'])) {
                $post_array['slug'] = create_slug($post_array['name']);
            }
            // cidb($post_array);exit;
            return $post_array;
        });

        // $crud->unset_add();
        //$crud->unset_delete();

        $this->mPageTitle = 'Pages';
        $this->render_crud();
    }




    public function tags()
    {
        $crud = $this->generate_crud('tags');

        //$crud->set_relation_n_n('tags', 'file_pages', 'pages', 'cat_id', 'page_id', 'name');
        //$crud->columns('name', 'slug','parent_id','description', 'meta_tag' ,'meta_keywords ', 'meta_description');

        //$crud->unset_texteditor('meta_tag' ,'meta_keywords', 'meta_description');

        // $crud->unset_add();
        //$crud->unset_delete();

        $this->mPageTitle = 'Tags';
        $this->render_crud();
    }


    public function category()
    {
        $crud = $this->generate_crud('category');
        $crud->set_relation('parentid','category','{name} :: {folder}');
        $crud->set_relation_n_n('tags', 'cat_pages', 'pages', 'cat_id', 'page_id', 'name');
        $crud->columns('name', 'parentid', 'folder' ,'thumb', 'date','tags');

        // $crud->unset_add();
        //$crud->unset_delete();
        $crud->fields('name', 'parentid' ,'thumb', 'date','tags');

        $crud->required_fields('name');
        $crud->unset_texteditor('folder');
        $this->mPageTitle = 'Category';
        $crud->set_field_upload('thumb','uploads/cat_images');

        $crud->callback_after_insert(array($this,'callback_category'));
        $crud->callback_after_update(array($this,'callback_category'));

        //$crud->add_action('More', '', 'admin/fileupload/add/13','ui-icon-plus');
        $crud->add_action('Files', "http://i.imgur.com/N8SN8ZS.png", 'Files','',array($this,'just_a_test'));
        $this->render_crud();
    }


    function just_a_test($primary_key , $row)
    {
        return site_url('admin/fileupload/add/').$primary_key;
    }

    function callback_category($post_array,$primary_key){
      //cidb($post_array);exit;
        $this->db->where('id', $primary_key);
        $table = $this->db->get('category');
        $this_row = $table->row_array();

       $update_data = array();

        if($post_array['parentid'] >0 ){
            $update_data['folder'] = '';

            $this->db->where('id', $post_array['parentid']);
            $table = $this->db->get('category');
            $parent_row = $table->row_array();

            $update_data['folder'] = $parent_row['folder'].$primary_key.DIRECTORY_SEPARATOR;

        }else{

            $update_data['folder'] = 'upload_files'.DIRECTORY_SEPARATOR.$primary_key.DIRECTORY_SEPARATOR;
        }

        mkdir_if_not_exist(FCPATH .$update_data['folder']);

        $log = FCPATH .$this_row['folder'];
        $log .= " \n ";
        $log .= FCPATH . $update_data['folder'];
        $log .= " \n ";
        logit($log, "move_files");

        if(!empty($this_row['folder'])){
            rcopy(FCPATH .$this_row['folder'],FCPATH . $update_data['folder']);
            if(FCPATH .$this_row['folder'] != FCPATH . $update_data['folder']){
                rrmdir(FCPATH .$this_row['folder']);
            }
        }

        $this->db->where('id', $primary_key);
        $this->db->update('category',$update_data);


        $somePath = FCPATH .  $update_data['folder'];
        $directories = glob_recursive($somePath);
        $log = '';
        $log .= " \n ";
        $log .= print_r($directories,true);
        $log .= " \n ";
        logit($log, "move_files");
        if(isset($directories[0])){

            foreach($directories as $key=>$val){
                 $child_cat_id = end(explode(DIRECTORY_SEPARATOR,$val));

                $update_child_categories['folder'] =  $update_data['folder'].end(explode($primary_key.DIRECTORY_SEPARATOR,$val)).DIRECTORY_SEPARATOR;
                $this->db->where('id', $child_cat_id);
                $this->db->update('category', $update_child_categories);
            }
        }


        return true;
    }

    public function file()
    {
        $crud = $this->generate_crud('file');
        $crud->columns('name','ext', 'dname ','file','cid','newtag','meta_keywords', 'meta_description');
        $crud->fields('name','ext', 'dname ','file','cid','newtag','meta_keywords', 'meta_description');
        $crud->set_relation('cid','category','folder');
        // $crud->unset_add();
        //$crud->unset_delete();
        //$crud->set_field_upload('dname',FCPATH.'uploads');
        $this->mPageTitle = 'File';


        $upload_path = 'uploads';
       switch($crud->getState()){
            case "edit":
                $state_info = $crud->getStateInfo();
                $state_info->primary_key;
                $row = $this->File_model->get_files("f.id=".$state_info->primary_key);
              //  $crud->set_field_upload('dname',$row['rows'][0]['folder']);
                $upload_path = $row['rows'][0]['folder'];
                break;

        }

       // print_r($state);
//print_r($state_info);
        mkdir_if_not_exist(FCPATH .$upload_path);
        $crud->set_field_upload('file',$upload_path);


        $this->render_crud();
    }

    function example_callback_before_upload($files_to_upload,$field_info){


       // $field_info['upload_path'] = 'uploads/files';
        //return $field_info;
    }
}