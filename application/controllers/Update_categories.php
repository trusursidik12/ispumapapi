<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_categories extends CI_Controller {

	public function update(){
		$data['iconbar'] 		= $this->global_m->get_iconbar();

		$this->form_validation->set_rules('id_stasiun', 'Id Stasiun', 'required');
		$this->form_validation->set_rules('lvl_desc', 'Level Description', 'max_length[240]');

		$this->form_validation->set_message('required', '%s Empty, Please Input..');
		$this->form_validation->set_message('is_unique', '%s Already Exist, Please Input Another Level Name..');

		if($this->form_validation->run() === FALSE){
			$this->temp_backend->load('backend/theme/template', 'backend/accounts/levels/levels_form_add', $data);
			$this->session->set_flashdata('error', "Data failed to save");
		} else {
			$this->acc_levels_m->add_levels();
			$this->session->set_flashdata('sukses', "Data saved successfully");
			redirect('accounts/levels/list');
		}		
	}

	// public function edit($slug = NULL){
	// 	$data['levels'] 		= $this->acc_levels_m->get_levelsview($slug);
	// 	$data['iconbar'] 		= $this->global_m->get_iconbar();
	// 	$data['title_header'] 	= "Edit Levels";
	// 	$data['title_menu'] 	= "List Levels";
	// 	$data['controllers'] 	= "levels";

	// 	if(empty($data['levels'])){
	// 		show_404();
	// 	}

	// 	$this->form_validation->set_rules('lvl_name', 'Level Name', 'required|callback_levels_check|max_length[50]');
	// 	$this->form_validation->set_rules('lvl_desc', 'Level Description', 'max_length[240]');

	// 	$this->form_validation->set_message('required', '%s Empty, Please Input..');

	// 	if($this->form_validation->run() === FALSE){
	// 		$this->temp_backend->load('backend/theme/template', 'backend/accounts/levels/levels_form_edit', $data);
	// 	} else {
	// 		$this->acc_levels_m->update_levels();
	// 		redirect('accounts/levels/list');
	// 	}
	// }
}
