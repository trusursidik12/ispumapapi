<?php

class News_m extends CI_Model
{

	public function add_aqmnews()
	{
		$data = array(
			'title' 			=> $this->input->post('title'),
			'slug' 				=> $this->input->post('slug'),
			'content' 			=> $this->input->post('content'),
			'created_at' 		=> $this->input->post('created_at'),
			'created_by' 		=> $this->input->post('created_by')
		);
		return $this->db->insert('news', $data);
	}

	public function update_aqmnews($data, $id)
	{
		$this->db->update('news', $data, ['id' => $id]);
		return $this->db->affected_rows();
	}

	public function delete_aqmnews($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('news');
		return TRUE;
	}
}