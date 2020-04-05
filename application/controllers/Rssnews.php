<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rssnews extends CI_Controller {

	public function index(){
		$data = [];
		
		$this->load->view('Rssnews_v', $data);
	}

}
