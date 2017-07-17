<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fileupload extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        //$this->controller_page_layout ='3_column';


    }

    function index()
    {

        error_reporting(E_ALL | E_STRICT);
        $options['upload_dir'] = FCPATH.'uploads/files/';
        $options['upload_url'] = base_url('uploads/files/');

        $this->load->library("UploadHandler",$options);

    }


    function add()
    {

        $this->render('fileupload/add', 'empty');
    }
}