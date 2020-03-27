<?php

class Aqmmaster_m extends CI_Model
{

	public function get_aqm_data($id = FALSE)
	{
		if($id === FALSE){
			$this->db->select('*');
			$this->db->from('aqm_data');
			$this->db->where('id IN (select max(id) from aqm_data group by id_stasiun)');
			$query = $this->db->get();
			return $query->result_array();
		}
		$query = $this->db->get_where('aqm_data', array('id_stasiun' => $id));
		return $query->row_array();
	}

	public function get_aqm_ispu($id = FALSE)
	{
		if($id === FALSE){
			$this->db->select('*');
			$this->db->from('aqm_ispu');
			$this->db->where('id IN (select max(id) from aqm_ispu group by id_stasiun)');
			$query = $this->db->get();
			return $query->result_array();
		}
		$query = $this->db->get_where('aqm_ispu', array('id_stasiun' => $id));
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
		$waktu = $this->db->select('waktu')->order_by('waktu',"desc")->limit(1)->get('aqm_ispu')->row()->waktu;
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
	
	public function get_LatLng($id_stasiun){
		$this->db->where("id_stasiun",$id_stasiun);
		$query = $this->db->get("aqm_stasiun");
		$result = $query->row_array();
		return ["lat" => $result["lat"],"lng" => $result["lon"]];
	}

	public function get_aqm_province_list($id = FALSE)
	{
		if($id === FALSE){
			$this->db->select('DISTINCT(provinsi), id_stasiun, nama, lat, lon, alamat, kota, geojson, use_internet, dbsource, old_id, xtimetimes');
			$this->db->group_by('provinsi'); 
			$this->db->order_by('provinsi', 'ASC');
			$query = $this->db->get('aqm_stasiun');
			return $query->result_array();
		}
		$query = $this->db->get_where('aqm_stasiun', array('provinsi' => $id));
		return $query->result_array();
	}

	public function get_last_aqm_data($id_stasiun){
		$this->db->order_by('waktu', 'DESC');
		$query = $this->db->get_where('aqm_data', ["id_stasiun" => $id_stasiun]);
		return $query->row_array();
	}
	
	public function get_stasiun_id_by_latlng($latlng){
		$query = $this->db->get_where('aqm_stasiun', $latlng);
		return $query->row_array();
	}

	public function get_aqm_news($id = FALSE)
	{
		if($id === FALSE){
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get('news');
			return $query->result_array();
		}
		$query = $this->db->get_where('news', array('slug' => $id));
		return $query->row_array();
	}

	public function get_aqm_about($id = FALSE)
	{
		if($id === FALSE){
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get('about');
			return $query->result_array();
		}
		$query = $this->db->get_where('about', array('slug' => $id));
		return $query->row_array();
	}
}