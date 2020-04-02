<?php
use chriskacerguis\RestServer\RestController;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

class Api extends RestController {

    public function __construct()
    {
    	parent::__construct();
    }

	public function aqmData_get()
	{

		$id = $this->get('id_stasiun');

		if ($id === null) {
			$data = $this->aqmmaster_m->get_aqm_data();
		} else {
			$data = $this->aqmmaster_m->get_aqm_data($id);			
		}

		if ($data) {
			$this->response([
                    'status' 	=> true,
                    'data' 		=> $data
                ], 200);
		} else {
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}

	public function aqmIspu_get()
	{

		$id = $this->get('id_stasiun');

		if ($id === null) {
			$data = $this->aqmmaster_m->get_aqm_ispu();
		} else {
			$data = $this->aqmmaster_m->get_aqm_ispu($id);			
		}

		if ($data) {
			$this->response([
                    'status' 	=> true,
                    'data' 		=> $data
                ], 200);
		} else {
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}

	public function aqmStasiun_get()
	{

		$id = $this->get('id');

		if ($id === null) {
			$data = $this->aqmmaster_m->get_aqm_stasiun();
		} else {
			$data = $this->aqmmaster_m->get_aqm_stasiun($id);			
		}

		if ($data) {
			$this->response([
                    'status' 	=> true,
                    'data' 		=> $data
                ], 200);
		} else {
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}

	public function aqmProvince_get()
	{

		$id = $this->get('provinsi');

		if ($id === null) {
			$data = $this->aqmmaster_m->get_aqm_province();
		} else {
			$data = $this->aqmmaster_m->get_aqm_province($id);		
		}

		if ($data) {
			$id_stasiuns = [];
			foreach($data as $province){
				$id_stasiuns[] = $province["id_stasiun"];
			}

			$worst_ispu = 0;
			$worst_param = "";
			$worst_stasiun_id = "";
			$ispu = $this->aqmmaster_m->get_ispu($id_stasiuns);
			foreach($ispu as $id_stasiun => $stasiun){
				$_worst_ispu = 0;
				$_worst_param = "";
				if($stasiun["pm25"] < 500 && $_worst_ispu < $stasiun["pm25"]){ $_worst_ispu = $stasiun["pm25"]; $_worst_param = "pm25"; }
				if($stasiun["pm10"] < 500 && $_worst_ispu < $stasiun["pm10"]){ $_worst_ispu = $stasiun["pm10"]; $_worst_param = "pm10"; }
				if($stasiun["so2"] < 500 && $_worst_ispu < $stasiun["so2"]){ $_worst_ispu = $stasiun["so2"]; $_worst_param = "so2"; }
				if($stasiun["co"] < 500 && $_worst_ispu < $stasiun["co"]){ $_worst_ispu = $stasiun["co"]; $_worst_param = "co"; }
				if($stasiun["o3"] < 500 && $_worst_ispu < $stasiun["o3"]){ $_worst_ispu = $stasiun["o3"]; $_worst_param = "o3"; }
				if($stasiun["no2"] < 500 && $_worst_ispu < $stasiun["no2"]){ $_worst_ispu = $stasiun["no2"]; $_worst_param = "no2"; }
				$ispu[$id_stasiun]["worst_ispu"] = $_worst_ispu;
				$ispu[$id_stasiun]["worst_param"] = $_worst_param;
				$ispu[$id_stasiun]["category"] = $category = $this->aqmmaster_m->get_category($_worst_ispu);
				$ispu[$id_stasiun]["effect"] = $category = $this->aqmmaster_m->get_effect($_worst_ispu,$_worst_param);
				$latlng = $category = $this->aqmmaster_m->get_LatLng($stasiun["id_stasiun"]);
				$ispu[$id_stasiun]["lat"] = $latlng["lat"];
				$ispu[$id_stasiun]["lng"] = $latlng["lng"];
				
				if($stasiun["pm25"] < 500 && $worst_ispu < $stasiun["pm25"]){ $worst_ispu = $stasiun["pm25"]; $worst_param = "pm25"; $worst_stasiun_id = $stasiun["id_stasiun"]; }
				if($stasiun["pm10"] < 500 && $worst_ispu < $stasiun["pm10"]){ $worst_ispu = $stasiun["pm10"]; $worst_param = "pm10"; $worst_stasiun_id = $stasiun["id_stasiun"]; }
				if($stasiun["so2"] < 500 && $worst_ispu < $stasiun["so2"]){ $worst_ispu = $stasiun["so2"]; $worst_param = "so2"; $worst_stasiun_id = $stasiun["id_stasiun"]; }
				if($stasiun["co"] < 500 && $worst_ispu < $stasiun["co"]){ $worst_ispu = $stasiun["co"]; $worst_param = "co"; $worst_stasiun_id = $stasiun["id_stasiun"]; }
				if($stasiun["o3"] < 500 && $worst_ispu < $stasiun["o3"]){ $worst_ispu = $stasiun["o3"]; $worst_param = "o3"; $worst_stasiun_id = $stasiun["id_stasiun"]; }
				if($stasiun["no2"] < 500 && $worst_ispu < $stasiun["no2"]){ $worst_ispu = $stasiun["no2"]; $worst_param = "no2"; $worst_stasiun_id = $stasiun["id_stasiun"]; }
			}
			
			$category = $this->aqmmaster_m->get_category($worst_ispu);
			$effect = $this->aqmmaster_m->get_effect($worst_ispu,$worst_param);
			$resumes = ["worst_ispu" => $worst_ispu,"worst_param" => $worst_param,"worst_stasiun_id" => $worst_stasiun_id, "category" => $category, "effect" => $effect, "ispu" => $ispu];
			
			
			$this->response([
                    'status' 	=> true,
                    'request_id' 	=> @$_GET["request_id"],
                    'resumes' 	=> $resumes,
                    'data' 		=> $data
                ], 200);
		} else {
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}

	public function aqmCitiesinfo_get(){
		$stasiuns = $this->aqmmaster_m->get_available_stasiuns();
		$id_stasiuns = [];
		foreach($stasiuns as $stasiun){
			$id_stasiuns[] = $stasiun["id_stasiun"];
			$stasiun_info = $this->aqmmaster_m->get_stasiun_info($stasiun["id_stasiun"]);
			$last_aqm_data = $this->aqmmaster_m->get_last_aqm_data($stasiun["id_stasiun"]);
			$ispu = $this->aqmmaster_m->get_ispu([$stasiun["id_stasiun"]])[0];
			
			$worst_ispu = 0;
			if($ispu["pm25"] < 500 && $worst_ispu < $ispu["pm25"]){ $worst_ispu = $ispu["pm25"];}
			if($ispu["pm10"] < 500 && $worst_ispu < $ispu["pm10"]){ $worst_ispu = $ispu["pm10"];}
			if($ispu["so2"] < 500 && $worst_ispu < $ispu["so2"]){ $worst_ispu = $ispu["so2"];}
			if($ispu["co"] < 500 && $worst_ispu < $ispu["co"]){ $worst_ispu = $ispu["co"];}
			if($ispu["o3"] < 500 && $worst_ispu < $ispu["o3"]){ $worst_ispu = $ispu["o3"];}
			if($ispu["no2"] < 500 && $worst_ispu < $ispu["no2"]){ $worst_ispu = $ispu["no2"];}
			
			if($worst_ispu <= 50) $category = "BAIK";
			else if($worst_ispu <= 100) $category = "SEDANG";
			else if($worst_ispu <= 199) $category = "TIDAK SEHAT";
			else if($worst_ispu <= 299) $category = "SANGAT TIDAK SEHAT";
			else $category = "BERBAHAYA";
			
			$data[$stasiun["id_stasiun"]] = [
			'status' 			=> true,
			'request_id'		=> @$_GET["request_id"] * 1,
			'id_stasiun'		=> $stasiun["id_stasiun"],
			'category'			=> $category,
			'stasiun_name'		=> $stasiun_info["nama"] . " - " . $stasiun_info["id_stasiun"],
			'city'				=> $stasiun_info["kota"],
			'province'			=> $stasiun_info["provinsi"],
			'pm25'				=> $ispu["pm25"],
			'pm10'				=> $ispu["pm10"],
			'so2'				=> $ispu["so2"],
			'co'				=> $ispu["co"],
			'o3'				=> $ispu["o3"],
			'no2'				=> $ispu["no2"],
			'pressure'			=> round($last_aqm_data["pressure"],1),
			'temperature'		=> round($last_aqm_data["temperature"],1),
			'wind_direction'	=> round($last_aqm_data["wd"],0),
			'wind_speed'		=> round($last_aqm_data["ws"],0),
			'humidity'			=> round($last_aqm_data["humidity"],0),
			'rain_rate'			=> round($last_aqm_data["rain_intensity"],1),
			'solar_radiation'	=> round($last_aqm_data["sr"],0)];
		}
		
		
		if ($ispu) {
			$this->response([
                    'status' 		=> true,
                    'id_stasiuns'	=> $id_stasiuns,
                    'data' 			=> $data
                ], 200);
		} else {
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}
	
	public function aqmProvinceweb_get()
	{

		$id = $this->get('provinsi');

		if ($id === null) {
			$data = $this->aqmmaster_m->get_aqm_province();
		} else {
			$data = $this->aqmmaster_m->get_aqm_province($id);		
		}

		if ($data) {
			$this->response([
                    'status' 	=> true,
                    'data' 		=> $data
                ], 200);
		} else {
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}

	public function aqmProvinceList_get()
	{

		$id = $this->get('provinsi');

		if ($id === null) {
			$data = $this->aqmmaster_m->get_aqm_province_list();
		} else {
			$data = $this->aqmmaster_m->get_aqm_province_list($id);		
		}

		if ($data) {
			$this->response([
                    'status' 	=> true,
                    'data' 		=> $data
                ], 200);
		} else {
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}
	
	public function aqmDetailStasiun_get()
	{
		$stasiuns = $this->aqmmaster_m->get_stasiun_id_by_latlng(["lat" => $this->get('lat'),"lon" => $this->get('lon')]);
		if ($stasiuns["id_stasiun"]) {
			$id_stasiuns[] = $stasiuns["id_stasiun"];
			$ispu = $this->aqmmaster_m->get_ispu($id_stasiuns)[0];
			$last_aqm_data = $this->aqmmaster_m->get_last_aqm_data($stasiuns["id_stasiun"]);
			
			$worst_ispu = 0;
			if($ispu["pm25"] < 500 && $worst_ispu < $ispu["pm25"]){ $worst_ispu = $ispu["pm25"];}
			if($ispu["pm10"] < 500 && $worst_ispu < $ispu["pm10"]){ $worst_ispu = $ispu["pm10"];}
			if($ispu["so2"] < 500 && $worst_ispu < $ispu["so2"]){ $worst_ispu = $ispu["so2"];}
			if($ispu["co"] < 500 && $worst_ispu < $ispu["co"]){ $worst_ispu = $ispu["co"];}
			if($ispu["o3"] < 500 && $worst_ispu < $ispu["o3"]){ $worst_ispu = $ispu["o3"];}
			if($ispu["no2"] < 500 && $worst_ispu < $ispu["no2"]){ $worst_ispu = $ispu["no2"];}
			
			if($worst_ispu <= 50) $category = "BAIK";
			else if($worst_ispu <= 100) $category = "SEDANG";
			else if($worst_ispu <= 199) $category = "TIDAK SEHAT";
			else if($worst_ispu <= 299) $category = "SANGAT TIDAK SEHAT";
			else $category = "BERBAHAYA";
			
			
			$this->response([
                    'status' 			=> true,
                    'request_id'		=> @$_GET["request_id"] * 1,
                    'category'			=> $category,
					'stasiun_name'		=> $stasiuns["nama"] . " - " . $stasiuns["id_stasiun"],
					'city'				=> $stasiuns["kota"],
					'province'			=> $stasiuns["provinsi"],
					'pm25'				=> $ispu["pm25"],
					'pm10'				=> $ispu["pm10"],
					'so2'				=> $ispu["so2"],
					'co'				=> $ispu["co"],
					'o3'				=> $ispu["o3"],
					'no2'				=> $ispu["no2"],
					'pressure'			=> round($last_aqm_data["pressure"],1),
					'temperature'		=> round($last_aqm_data["temperature"],1),
					'wind_direction'	=> round($last_aqm_data["wd"],0),
					'wind_speed'		=> round($last_aqm_data["ws"],0),
					'humidity'			=> round($last_aqm_data["humidity"],0),
					'rain_rate'			=> round($last_aqm_data["rain_intensity"],1),
					'solar_radiation'	=> round($last_aqm_data["sr"],0)
                ], 200);
		} else {
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}
	
	public function aqmOutdoor_get(){
		$id_stasiun = $this->get('id_stasiun');
		$stasiun_info = $this->aqmmaster_m->get_stasiun_info($id_stasiun);
		$last_aqm_data = $this->aqmmaster_m->get_last_aqm_data($id_stasiun);
		$ispu = $this->aqmmaster_m->get_ispu([$id_stasiun])[0];
				
		if ($ispu) {
			$this->response([
                    'status' 			=> true,
					'request_id'		=> @$_GET["request_id"] * 1,
					'id_stasiun'		=> $id_stasiun,
					'waktu'				=> $last_aqm_data["waktu"],
					'datetime'			=> date("Y-m-d H:i:s"),
					'stasiun_name'		=> $stasiun_info["nama"],
					'city'				=> $stasiun_info["kota"],
					'province'			=> $stasiun_info["provinsi"],
					'pm25'				=> $ispu["pm25"],
					'pm10'				=> $ispu["pm10"],
					'so2'				=> $ispu["so2"],
					'co'				=> $ispu["co"],
					'o3'				=> $ispu["o3"],
					'no2'				=> $ispu["no2"],
					'pressure'			=> round($last_aqm_data["pressure"],1),
					'temperature'		=> round($last_aqm_data["temperature"],1),
					'wind_direction'	=> round($last_aqm_data["wd"],0),
					'wind_speed'		=> round($last_aqm_data["ws"],0),
					'humidity'			=> round($last_aqm_data["humidity"],0),
					'rain_rate'			=> round($last_aqm_data["rain_intensity"],1),
					'solar_radiation'	=> round($last_aqm_data["sr"],0)
                ], 200);
		} else {
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}

	public function aqmCloserStasiun_get(){
		$lat = $this->get('lat');
		$lng = $this->get('lng');
		$data = $this->aqmmaster_m->get_closer_stasiun_id($lat,$lng);
		if ($data) {
			$this->response([
                    'status' 	=> true,
                    'data' 		=> $data
                ], 200);
		} else {
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}
	
	public function aqmNews_get()
	{

		$id = $this->get('slug');

		if ($id === null) {
			$data = $this->aqmmaster_m->get_aqm_news();
		} else {
			$data = $this->aqmmaster_m->get_aqm_news($id);			
		}

		if ($data) {
			$this->response([
                    'status' 	=> true,
                    'data' 		=> $data
                ], 200);
		} else {
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}

	public function aqmAbout_get()
	{

		$id = $this->get('slug');

		if ($id === null) {
			$data = $this->aqmmaster_m->get_aqm_about();
		} else {
			$data = $this->aqmmaster_m->get_aqm_about($id);			
		}

		if ($data) {
			$this->response([
                    'status' 	=> true,
                    'data' 		=> $data
                ], 200);
		} else {
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}	

	public function aqmFaqs_get()
	{

		$id = $this->get('slug');

		if ($id === null) {
			$data = $this->aqmmaster_m->get_aqm_faqs();
		} else {
			$data = $this->aqmmaster_m->get_aqm_faqs($id);			
		}

		if ($data) {
			$this->response([
                    'status' 	=> true,
                    'data' 		=> $data
                ], 200);
		} else {
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}

	public function aqmRankPm10_get()
	{
		$data = $this->aqmmaster_m->get_aqm_rank_pm10();

		if ($data) {
			$this->response([
                    'status' 	=> true,
                    'data' 		=> $data
                ], 200);
		} else {
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}

	public function aqmRankPm25_get()
	{
		$data = $this->aqmmaster_m->get_aqm_rank_pm25();

		if ($data) {
			$this->response([
                    'status' 	=> true,
                    'data' 		=> $data
                ], 200);
		} else {
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}

	public function aqmRankSo2_get()
	{
		$data = $this->aqmmaster_m->get_aqm_rank_so2();

		if ($data) {
			$this->response([
                    'status' 	=> true,
                    'data' 		=> $data
                ], 200);
		} else {
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}

	public function aqmRankCo_get()
	{
		$data = $this->aqmmaster_m->get_aqm_rank_co();

		if ($data) {
			$this->response([
                    'status' 	=> true,
                    'data' 		=> $data
                ], 200);
		} else {
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}

	public function aqmRanko3_get()
	{
		$data = $this->aqmmaster_m->get_aqm_rank_o3();

		if ($data) {
			$this->response([
                    'status' 	=> true,
                    'data' 		=> $data
                ], 200);
		} else {
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}

	public function aqmRankNo2_get()
	{
		$data = $this->aqmmaster_m->get_aqm_rank_no2();

		if ($data) {
			$this->response([
                    'status' 	=> true,
                    'data' 		=> $data
                ], 200);
		} else {
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}
}
