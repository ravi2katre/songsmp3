<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home page
 */
class Pages extends MY_Controller {
    var $static_page_layout ='';
	public function __construct()
	{
		parent::__construct();
        $this->static_page_layout ='default';
	}

	public function index()
	{
		$this->render('home', $this->static_page_layout);
	}
	public function about_us()
	{
		$this->render('pages/about_us', $this->static_page_layout);
	}

    public function vision_and_mission()
    {
        $this->render('pages/vision_and_mission', $this->static_page_layout);
    }

    public function aim_and_objective()
    {
        $this->render('pages/aim_and_objective', $this->static_page_layout);
    }

    public function about_bhagirathi()
    {
        $this->render('pages/about_bhagirathi', $this->static_page_layout);
    }

    public function local_managing_committee()
    {
        $this->render('pages/local_managing_committee', $this->static_page_layout);
    }

    public function training_and_placement()
    {
        $this->render('pages/training_and_placement', $this->static_page_layout);
    }

    public function centralized_training_and_placement_cell()
    {
        $this->render('pages/centralized_training_and_placement_cell', $this->static_page_layout);
    }

    public function addmission_criteria()
    {
        $this->render('pages/addmission_criteria', $this->static_page_layout);
    }

    public function facilities()
    {
        $this->render('pages/facilities', $this->static_page_layout);
    }

    public function library()
    {
        $this->render('pages/library', $this->static_page_layout);
    }

    public function computer_lab()
    {
        $this->render('pages/computer_lab', $this->static_page_layout);
    }

    public function photo_gallery()
    {
        $this->render('pages/photo_gallery', $this->static_page_layout);
    }

    public function contact_us()
    {
        $this->render('pages/contact_us', $this->static_page_layout);
    }

}
