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

	// public function get_province($id = FALSE)
	// {
	// 	if($id === FALSE){
	// 		$this->db->join('aqm_stasiun', 'aqm_stasiun.id_stasiun = indoor_groups.id_stasiun');
	// 		$query = $this->db->get('indoor_groups');
	// 		return $query->result_array();
	// 	}
	// 	$query = $this->db->get_where('indoor_groups', array('id_group' => $id));
	// 	return $query->row_array();
	// }

	public function get_aqm_province($id = FALSE)
	{
		if($id === FALSE){
			$this->db->order_by('id', 'ASC');
			$query = $this->db->get('aqm_stasiun');
			return $query->result_array();
		}
		$query = $this->db->get_where('aqm_stasiun', array('provinsi' => $id));
		return $query->result_array();
	}

	public function get_ispu($id_stasiuns)
	{
		if(date("H") * 1 < 15)
			$waktu = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1));
		else
			$waktu = date("Y-m-d",mktime(0,0,0,date("m"),date("d")));
		
		$this->db->where_in('id_stasiun', $id_stasiuns);
		$this->db->like('waktu', $waktu, 'after'); 
		$query = $this->db->get("aqm_ispu");
		return $query->result_array();
	}
	
	public function get_category($ispu,$param = ""){
		if($param != "") $this->db->where("param",$param);
		$this->db->where("'$ispu' BETWEEN ispu_a AND ispu_b");
		$query = $this->db->get("categories");
		return $query->row_array()["category"];
	}
	
	public function get_effect($ispu,$param){
		$this->db->where("param",$param);
		$this->db->where("'$ispu' BETWEEN ispu_a AND ispu_b");
		$query = $this->db->get("categories");
		return $query->row_array()["effect"];
	}
}