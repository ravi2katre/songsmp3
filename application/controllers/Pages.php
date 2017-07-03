<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home page
 */
class Pages extends MY_Controller {
    var $controller_page_layout ='';
	public function __construct()
	{
		parent::__construct();

        $this->controller_page_layout ='3_column';


	}

	public function index()
	{
	   //print_r($this->input->get_post());
        //$this->output->cache(1);
	    //$this->mViewData['list'] = $this->File_model->get_files();
        //cidb($this->db); exit;
	    //cidb($this->mViewData['list']);
		$this->render('pages/home', $this->controller_page_layout);
	}

	public function category($id,$slug,$offset = 1){
        $limit = 20;
        $this->mPageTitle = $this->mViewData['mPageTitle'] = str_replace("-", " ", $slug);
            //get query string
        $this->_load_session('category');
        $query_array = array();
        if ($this->input->post()) {
            foreach ($this->input->post() as $key => $val) {
                $query_array[$key] = $val;
            }
        }


	    //echo "ggggg";exit;
        //$this->output->cache(1);
        $condition = "c.parentid = ".$id;
        $this->mViewData['list'] = $this->File_model->get_categories($condition,$limit, ($offset * $limit) - $limit);
        //print_r($this->mViewData['list']);exit;

        if($this->mViewData['list']['num_rows']==0){
            //$this->mViewData['cat_detail'] = $this->mViewData['list']['rows'][0];
            $condition = "f.cid = ".$id;
            $this->mViewData['list'] = $this->File_model->get_files($condition,$limit, ($offset * $limit) - $limit);


            //pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url('category/'.$id."/".$slug);
            $config['page_query_string'] = FALSE;
            $config['use_page_numbers'] = TRUE;
            $config['total_rows'] = $this->mViewData['list']['num_rows'];
            $config['per_page'] = $limit;
            $config['uri_segment'] = 4;
            $this->pagination->initialize($config);
            $this->mViewData['pagination'] = $this->pagination->create_links();

            $this->render('pages/files', $this->controller_page_layout);
        }else{

            //pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url('category/'.$id."/".$slug);
            $config['page_query_string'] = FALSE;
            $config['use_page_numbers'] = TRUE;
            $config['total_rows'] = $this->mViewData['list']['num_rows'];
            $config['per_page'] = $limit;
            $config['uri_segment'] = 4;
            $this->pagination->initialize($config);
            $this->mViewData['pagination'] = $this->pagination->create_links();

            $this->render('pages/category', $this->controller_page_layout);
        }
        //cidb($this->db); exit;
        //cidb($this->mViewData['list']);exit;
       // $this->mViewData['list'] = $this->File_model->get_files();

    }

    public function files($file_id,$slug){
        //echo "ggggg";exit;
        //$this->output->cache(1);
        //$condition = "f.id = ".$file_id;
        //$this->mViewData['list'] = $this->File_model->left_categories($condition);
        //cidb($this->db); exit;

        $this->mViewData['list'] = $this->File_model->get_files('f.id='.$file_id);
        $this->mViewData['list'] = $this->mViewData['list']['rows'][0];
        $this->mPageTitle = $this->mViewData['mPageTitle'] = str_replace("-", " ", $slug);

        //cidb($this->mViewData['list']);exit;
        $this->render('pages/file_show', $this->controller_page_layout);
    }

    /**
     *
     */
    function search($report) {
        $query_array = array();
        if ($this->input->post()) {
            foreach ($this->input->post() as $key => $val) {
                $query_array[$key] = $val;
            }
        }
        //$query_array['start_date']= (empty($this->input->post('start_date')))?date("2000/m/d H:i:s"):$this->input->post('start_date');
        //$query_array['end_date'] = (empty($this->input->post('end_date')))?date("Y/m/d H:i:s"):$this->input->post('end_date');

        $this->_save_session($query_array);


        redirect("admin/customers/" . $report . "/search/");
    }

    /**
     * @param $query_array
     */
    function _save_session($query_array) {
        $this->session->set_userdata('search', http_build_query($query_array));
    }

    /**
     * @param $search_query
     */
    function _load_session($search_query) {
        if (!is_null($search_query) && $search_query == 'search') {

            $search = $this->session->userdata('search');

            if (isset($search)) {
                parse_str($search, $_POST);
            }
        }
    }

    public function download() {
        $this->load->helper('download');
        $id = unserialize_data($this->input->post('download_key'));
        $condition = "f.id=".$id;
        $result = $this->File_model->get_files($condition);
        $list= $result['rows'][0];
//cidb($result);exit;
        $fileName= $list['name'].".".$list['ext'];
        if ($fileName) {
            $file = download_url ( $list['folder'])  . $fileName;
            // check file exists
            if (file_exists ( $file )) {

                // get file content
                $data = file_get_contents ( $file );

                //force download
                force_download ( $fileName, $data );
            } else {
                echo "ffffff";exit;
                // Redirect to base url
                redirect ( base_url () );
            }
        }
    }


    function search_files(){

    }
}