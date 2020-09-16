<?php

class Aqmmaster_m extends CI_Model
{

	public function get_aqm_data($id = FALSE)
	{
		if ($id === FALSE) {
			$this->db->select('*');
			$this->db->from('aqm_data');
			$this->db->where('id IN (select max(id) from aqm_data group by id_stasiun)');
			$query = $this->db->get();
			return $query->result_array();
		}
		$query = $this->db->get_where('aqm_data', array('id_stasiun' => $id));
		return $query->row_array();
	}

	public function get_aqm_ispu_yesterday($id = FALSE)
	{
		if ($id === FALSE) {
			$this->db->select('*');
			$this->db->from('aqm_ispu');
			$this->db->where('waktu IN (select max(waktu) from aqm_ispu where waktu < (select max(waktu) from aqm_ispu) group by id_stasiun)');
			$query = $this->db->get();
			return $query->result_array();
		}
		$query = $this->db->get_where('aqm_ispu', array('id_stasiun' => $id));
		return $query->row_array();
	}

	public function get_aqm_ispu($id = FALSE)
	{
		if ($id === FALSE) {
			$this->db->select('*');
			$this->db->from('aqm_ispu');
			$this->db->where('id IN (select max(id) from aqm_ispu group by id_stasiun)');
			$query = $this->db->get();
			return $query->result_array();
		}
		$query = $this->db->get_where('aqm_ispu', array('id_stasiun' => $id));
		return $query->row_array();
	}

	public function get_aqm_ispu_all()
	{
		$this->db->from('aqm_ispu');
		$this->db->where('id_stasiun IN (SELECT id_stasiun FROM aqm_stasiun WHERE calculate_ispu = 1) AND id IN (select max(id) from aqm_ispu group by id_stasiun)');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_aqm_stasiun($id = FALSE)
	{
		if ($id === FALSE) {
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get('aqm_stasiun');
			return $query->result_array();
		}
		$query = $this->db->get_where('aqm_stasiun', array('id' => $id));
		return $query->row_array();
	}

	public function get_aqm_province($id = FALSE)
	{
		if ($id === FALSE) {
			$this->db->order_by('id', 'ASC');
			$query = $this->db->get('aqm_stasiun');
			return $query->result_array();
		}
		$query = $this->db->get_where('aqm_stasiun', array('provinsi' => $id));
		return $query->result_array();
	}

	public function get_ispu($id_stasiuns)
	{
		$waktu = $this->db->select('waktu')->where_in('id_stasiun', $id_stasiuns)->order_by('waktu', "desc")->limit(1)->get('aqm_ispu')->row()->waktu;
		$this->db->where_in('id_stasiun', $id_stasiuns);
		$this->db->like('waktu', $waktu, 'after');
		$query = $this->db->get("aqm_ispu");
		return $query->result_array();
	}

	public function get_category($ispu, $param = "")
	{
		if ($param != "") $this->db->where("param", $param);
		$this->db->where("'$ispu' BETWEEN ispu_a AND ispu_b");
		$query = $this->db->get("categories");
		return $query->row_array()["category"];
	}

	public function get_effect($ispu, $param)
	{
		$this->db->where("param", $param);
		$this->db->where("'$ispu' BETWEEN ispu_a AND ispu_b");
		$query = $this->db->get("categories");
		return $query->row_array()["effect"];
	}

	public function get_LatLng($id_stasiun)
	{
		$this->db->where("id_stasiun", $id_stasiun);
		$query = $this->db->get("aqm_stasiun");
		$result = $query->row_array();
		return ["lat" => $result["lat"], "lng" => $result["lon"]];
	}

	public function get_aqm_province_list($id = FALSE)
	{
		if ($id === FALSE) {
			$this->db->select('DISTINCT(provinsi), id_stasiun, nama, lat, lon, alamat, kota, geojson, use_internet, dbsource, old_id, xtimetimes');
			$this->db->group_by('provinsi');
			$this->db->order_by('provinsi', 'ASC');
			$query = $this->db->get('aqm_stasiun');
			return $query->result_array();
		}
		$query = $this->db->get_where('aqm_stasiun', array('provinsi' => $id));
		return $query->result_array();
	}

	public function get_last_aqm_data($id_stasiun)
	{
		$this->db->order_by('waktu', 'DESC');
		$query = $this->db->get_where('aqm_data', ["id_stasiun" => $id_stasiun]);
		return $query->row_array();
	}

	public function get_stasiun_id_by_latlng($latlng)
	{
		$query = $this->db->get_where('aqm_stasiun', $latlng);
		return $query->row_array();
	}

	public function get_closer_stasiun_id($lat, $lng)
	{
		$closer = 99999999999999999999;
		$id_stasiun = "";
		$this->db->select("id_stasiun,(lat - $lat) as lat_x, (lon - $lng) as lon_x, SQRT(POW((lat - $lat),2) + POW((lon - $lng),2)) as jarak");
		$this->db->where("(lat - $lat) >= 0 AND (lon - $lng) >= 0");
		$this->db->order_by("SQRT(POW((lat - $lat),2) + POW((lon - $lng),2))");
		$result1 = $this->db->get('aqm_stasiun')->row_array();
		if (@$result1["jarak"] < $closer && isset($result1["id_stasiun"])) {
			$id_stasiun = $result1["id_stasiun"];
			$closer = @$result1["jarak"];
		}

		$this->db->select("id_stasiun,($lat - lat) as lat_x, (lon - $lng) as lon_x, SQRT(POW(($lat - lat),2) + POW((lon - $lng),2)) as jarak");
		$this->db->where("($lat - lat) >= 0 AND (lon - $lng) >= 0");
		$this->db->order_by("SQRT(POW(($lat - lat),2) + POW((lon - $lng),2))");
		$result2 = $this->db->get('aqm_stasiun')->row_array();
		if (@$result2["jarak"] < $closer && isset($result2["id_stasiun"])) {
			$id_stasiun = $result2["id_stasiun"];
			$closer = @$result2["jarak"];
		}

		$this->db->select("id_stasiun,($lat - lat) as lat_x, ($lng - lon) as lon_x, SQRT(POW(($lat - lat),2) + POW(($lng - lon),2)) as jarak");
		$this->db->where("($lat - lat) >= 0 AND ($lng - lon) >= 0");
		$this->db->order_by("SQRT(POW(($lat - lat),2) + POW(($lng - lon),2))");
		$result3 = $this->db->get('aqm_stasiun')->row_array();
		if (@$result3["jarak"] < $closer && isset($result3["id_stasiun"])) {
			$id_stasiun = $result3["id_stasiun"];
			$closer = @$result3["jarak"];
		}

		$this->db->select("id_stasiun,(lat - $lat) as lat_x, ($lng - lon) as lon_x, SQRT(POW((lat - $lat),2) + POW(($lng - lon),2)) as jarak");
		$this->db->where("(lat - $lat) >= 0 AND ($lng - lon) >= 0");
		$this->db->order_by("SQRT(POW((lat - $lat),2) + POW(($lng - lon),2))");
		$result4 = $this->db->get('aqm_stasiun')->row_array();
		if (@$result4["jarak"] < $closer && isset($result4["id_stasiun"])) {
			$id_stasiun = $result4["id_stasiun"];
			$closer = @$result4["jarak"];
		}

		return ["id_stasiun" => $id_stasiun, "closer" => $closer, "stasiuns" => [$result1, $result2, $result3, $result4]];
	}

	public function get_available_stasiuns($lat = "", $lng = "")
	{
		if ($lat != "" || $lng != "") {
			$closer_stasiun_id = $this->get_closer_stasiun_id($lat, $lng)["id_stasiun"];
			if ($closer_stasiun_id != "") $this->db->order_by("id_stasiun = '" . $closer_stasiun_id . "' DESC, id_stasiun ASC");
		}
		$this->db->group_by('id_stasiun');
		$query = $this->db->get('aqm_ispu');
		return $query->result_array();
	}

	public function get_stasiun_info($id_stasiun)
	{
		$this->db->where(["id_stasiun" => $id_stasiun]);
		$query = $this->db->get('aqm_stasiun');
		return $query->row_array();
	}

	public function get_aqm_news($keyword)
	{
		if ($keyword != "") {
			$this->db->like('title', $keyword, 'both');
			$this->db->or_like('slug', $keyword, 'both');
			$this->db->or_like('short_content', $keyword, 'both');
			$this->db->or_like('content', $keyword, 'both');
		}
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('news');
		return $query->result_array();
	}

	public function get_newsslug($slug = FALSE)
	{
		if ($slug === FALSE) {
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get('news');
			return $query->result_array();
		}
		$query = $this->db->get_where('news', array('slug' => $slug));
		return $query->row_array();
	}

	public function get_aqm_about($id = FALSE)
	{
		if ($id === FALSE) {
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get('about');
			return $query->result_array();
		}
		$query = $this->db->get_where('about', array('slug' => $id));
		return $query->row_array();
	}

	public function get_aqm_faqs($id = FALSE)
	{
		if ($id === FALSE) {
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get('faqs');
			return $query->result_array();
		}
		$query = $this->db->get_where('faqs', array('slug' => $id));
		return $query->row_array();
	}

	public function get_aqm_rank_pm10()
	{
		$this->db->select('pm10, id_stasiun, waktu');
		$this->db->from('aqm_ispu');
		$this->db->where('id IN (select max(id) from aqm_ispu group by id_stasiun)');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_aqm_rank_pm10_yesterday()
	{
		$this->db->select('pm10, id_stasiun, waktu');
		$this->db->from('aqm_ispu');
		$this->db->where('waktu IN (select max(waktu) from aqm_ispu where waktu < (select max(waktu) from aqm_ispu) group by id_stasiun)');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_aqm_rank_pm25()
	{
		$this->db->select('pm25, id_stasiun, waktu');
		$this->db->from('aqm_ispu');
		$this->db->where('id IN (select max(id) from aqm_ispu group by id_stasiun)');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_aqm_rank_pm25_yesterday()
	{
		$this->db->select('pm25, id_stasiun, waktu');
		$this->db->from('aqm_ispu');
		$this->db->where('waktu IN (select max(waktu) from aqm_ispu where waktu < (select max(waktu) from aqm_ispu) group by id_stasiun)');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_aqm_rank_so2()
	{
		$this->db->select('so2, id_stasiun, waktu');
		$this->db->from('aqm_ispu');
		$this->db->where('id IN (select max(id) from aqm_ispu group by id_stasiun)');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_aqm_rank_so2_yesterday()
	{
		$this->db->select('so2, id_stasiun, waktu');
		$this->db->from('aqm_ispu');
		$this->db->where('waktu IN (select max(waktu) from aqm_ispu where waktu < (select max(waktu) from aqm_ispu) group by id_stasiun)');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_aqm_rank_co()
	{
		$this->db->select('co, id_stasiun, waktu');
		$this->db->from('aqm_ispu');
		$this->db->where('id IN (select max(id) from aqm_ispu group by id_stasiun)');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_aqm_rank_co_yesterday()
	{
		$this->db->select('co, id_stasiun, waktu');
		$this->db->from('aqm_ispu');
		$this->db->where('waktu IN (select max(waktu) from aqm_ispu where waktu < (select max(waktu) from aqm_ispu) group by id_stasiun)');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_aqm_rank_o3()
	{
		$this->db->select('o3, id_stasiun, waktu');
		$this->db->from('aqm_ispu');
		$this->db->where('id IN (select max(id) from aqm_ispu group by id_stasiun)');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_aqm_rank_o3_yesterday()
	{
		$this->db->select('o3, id_stasiun, waktu');
		$this->db->from('aqm_ispu');
		$this->db->where('waktu IN (select max(waktu) from aqm_ispu where waktu < (select max(waktu) from aqm_ispu) group by id_stasiun)');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_aqm_rank_no2()
	{
		$this->db->select('no2, id_stasiun, waktu');
		$this->db->from('aqm_ispu');
		$this->db->where('id IN (select max(id) from aqm_ispu group by id_stasiun)');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_aqm_rank_no2_yesterday()
	{
		$this->db->select('no2, id_stasiun, waktu');
		$this->db->from('aqm_ispu');
		$this->db->where('waktu IN (select max(waktu) from aqm_ispu where waktu < (select max(waktu) from aqm_ispu) group by id_stasiun)');
		$query = $this->db->get();
		return $query->result_array();
	}
}
