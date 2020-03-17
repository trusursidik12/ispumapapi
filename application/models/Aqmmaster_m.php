<?php

class Aqmmaster_m extends CI_Model
{

	public function get_aqm_data($id = FALSE)
	{
		if($id === FALSE){
			$this->db->order_by('id', 'DESC');
			$this->db->limit('1');
			$query = $this->db->get('aqm_data');
			return $query->result_array();
		}
		$query = $this->db->get_where('aqm_data', array('id' => $id));
		return $query->row_array();
	}

	public function get_aqm_ispu($id = FALSE)
	{
		if($id === FALSE){
			$this->db->order_by('id', 'DESC');
			$this->db->limit('1');
			$query = $this->db->get('aqm_ispu');
			return $query->result_array();
		}
		$query = $this->db->get_where('aqm_ispu', array('id' => $id));
		return $query->row_array();
	}

	public function get_aqm_stasiun($id = FALSE)
	{
		if($id === FALSE){
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get('aqm_stasiun');
			return $query->result_array();
		}
		$query = $this->db->get_where('aqm_stasiun', array('id' => $id));
		return $query->row_array();
	}

	public function get_province($id = FALSE)
	{
		if($id === FALSE){
			$this->db->join('aqm_stasiun', 'aqm_stasiun.id_stasiun = indoor_groups.id_stasiun');
			$query = $this->db->get('indoor_groups');
			return $query->result_array();
		}
		$query = $this->db->get_where('indoor_groups', array('id_group' => $id));
		return $query->row_array();
	}
}