<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rssnews extends CI_Controller {

	public function index()
	{
		// $data['news'] 		= $this->news_m->get_aqmnews();

		$data[] = "";
		$this->load->view('Rssnews_v', $data);
	}

}
