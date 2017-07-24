<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fileupload extends Admin_Controller
{
    public function __construct()
    {


        parent::__construct();
        //$this->controller_page_layout ='3_column';

    }

    function index()
    {

        $log = print_r($this->session->userdata['cat'],true);
        logit( $log,'check_session');

        //error_reporting(E_ALL | E_STRICT);
        $options['upload_dir'] = FCPATH.'uploads/files/';
        $options['upload_url'] = base_url('uploads/files/');
        $options['script_url'] = current_url();


        $title = $this->input->post_get('title');

        $options['print_response'] = true;

        if($this->session->userdata['cat']['id'] > 0){
            $options['cid'] = $this->session->userdata['cat']['id'];
            $options['upload_dir'] = FCPATH.($this->session->userdata['cat']['folder']);

            $options['upload_url'] = base_url($this->session->userdata['cat']['folder']);
            $cid = $this->session->userdata['cat']['id'];
        }

        mkdir_if_not_exist($options['upload_dir']);
        $this->load->library("Upload_handler",$options);

        switch(strtolower($this->input->server('REQUEST_METHOD'))){
            case "post":
                $files = $this->upload_handler->get_response();
                $this->insert_detail($files['files'][0]);
               // $log = "cid=".$cid;
                //$log .= print_r($files,true);
                   // logit($log,'file_upload');
                break;

            case "delete":

                $files = $this->upload_handler->get_response();
                $this->delete_file_row($files);
               // $log = "cid=".$cid;
               // $log .= print_r($files,true);
                //logit($log,'file_upload');
                break;
        }

    }


    function add($cid){
       // $cid = ($this->input->post('cid') > 0) ?$this->input->post('cid'):0;
        //$cid = 13;
        if($cid > 0){
            $rows = $this->File_model->get_categories("c.id=".$cid);
            $row['cat'] = $rows['rows'][0];
            $this->session->set_userdata( $row);
        }

//cidb($row);exit;

        $this->render('fileupload/add');
    }

    function insert_detail($file){

        if(isset($file->error)){
            return false;
        }

        $data = pathinfo($file->url);
        if(empty($data['filename']) || empty($file->size)){
            return true;
        }
        //$log = print_r($data,true);
        $insert = array(
            'name' =>$data['filename'],
            'dname' =>$data['filename'],
            'cid' => $this->session->userdata['cat']['id'],
            'ext' => $data['extension'],
            'thumbext' => $data['extension'],
            'size' => $file->size,
            'desc' => '',
            'download' => '0',
            'view' => '0',
            'newtag' => '0',
            'imagetype' => '1',
            'kram' => '0',
            'meta_keywords' => '',
            'meta_description' => '');
        $this->File_model->insert($insert);
        logit(print_r($insert,true),'insert');

    }

        function delete_file_row($file){
        $file_name = key($file);
        $data = pathinfo($file_name);
        $condition = 'cid='.$this->session->userdata['cat']['id'];
        $condition .= " AND name='".rawurlencode($data['filename'])."'";
        $this->File_model->delete($condition);
        $log = print_r($data,true);
        $log .= $condition." \n ";
        logit( $log,'delete_file_row');

    }

    function edit($cid,$name){
        //$file_name = key($name);
        $data = pathinfo($name);
        $condition = 'f.cid='.$cid;
        $condition .= " AND f.name='".$data['filename']."'";
        $this->mViewData['row'] = $this->File_model->get_files($condition);
        $row = $this->mViewData['row']['rows'][0];
        $this->load->library('../controllers/Jobs');
        $this->mViewData['mp3info'] = $this->jobs->mp3info(FCPATH.$row['folder'].rawurldecode($row['name']).".".$row['ext']);
        $this->render('fileupload/edit');
    }
}