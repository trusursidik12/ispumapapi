<?php

class Faq_m extends CI_Model
{

	public function add_aqmfaq()
	{
		$data = array(
			'title' 			=> $this->input->post('title'),
			'slug' 				=> $this->input->post('slug'),
			'content' 			=> $this->input->post('content'),
			'created_at' 		=> $this->input->post('created_at'),
			'created_by' 		=> $this->input->post('created_by')
		);
		return $this->db->insert('faqs', $data);
	}

	public function update_aqmfaq($data, $id)
	{
		$this->db->update('faqs', $data, ['id' => $id]);
		return $this->db->affected_rows();
	}

	public function delete_aqmfaq($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('faqs');
		return TRUE;
	}
}