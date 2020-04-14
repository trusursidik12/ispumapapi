<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rssnews extends CI_Controller {

	public function index()
	{
		if(isset($_GET["keyword"])) $data['news'] 		= $this->news_m->get_aqmnews($_GET["keyword"]);
		else $data['news'] 		= $this->news_m->get_aqmnews();
		
		$this->load->view('Rssnews_v', $data);
	}

}
