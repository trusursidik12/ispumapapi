<?php

class About_m extends CI_Model
{

	public function add_aqmabout()
	{
		$data = array(
			'title' 			=> $this->input->post('title'),
			'slug' 				=> $this->input->post('slug'),
			'content' 			=> $this->input->post('content'),
			'created_at' 		=> $this->input->post('created_at'),
			'created_by' 		=> $this->input->post('created_by')
		);
		return $this->db->insert('about', $data);
	}

	public function update_aqmabout($data, $id)
	{
		$this->db->update('about', $data, ['id' => $id]);
		return $this->db->affected_rows();
	}

	public function delete_aqmabout($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('about');
		return TRUE;
	}
}