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

        $crud->callback_before_insert(array($this,'callback_category'));
        $crud->callback_before_update(array($this,'callback_category'));

        $this->render_crud();
    }

    function callback_category($post_array){
      // cidb($post_array);exit;
        /*if($post_array['parentid'] >0 ){

        }else{
            $post_array['folder'] = 'upload_files'.DIRECTORY_SEPARATOR.$post_array['id'];
        }*/
    }

    public function file()
    {
        $crud = $this->generate_crud('file');
        $crud->columns('name','ext', 'dname ','cid','newtag','meta_keywords', 'meta_description');
        $crud->set_relation('cid','category','{name} ({folder})');
        // $crud->unset_add();
        //$crud->unset_delete();

        $this->mPageTitle = 'File';
        $this->render_crud();
    }

}