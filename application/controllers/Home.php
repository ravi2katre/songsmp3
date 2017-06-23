<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home page
 */
class Home extends MY_Controller {

	public function index()
	{
		$this->render('home', 'full_width');
	}

	public function test(){
        $this->render('home', '3_column');
    }
}
