<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
date_default_timezone_set("Asia/Jakarta");

class Api extends RestController
{

	function __construct()
	{
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method == "OPTIONS") {
			die();
		}
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



	public function aqmIspuAll_get()
	{
		$data = $this->aqmmaster_m->get_aqm_ispu_all();

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
			foreach ($data as $province) {
				$id_stasiuns[] = $province["id_stasiun"];
			}

			$worst_ispu = 0;
			$worst_param = "";
			$worst_stasiun_id = "";
			$ispu = $this->aqmmaster_m->get_ispu($id_stasiuns);
			foreach ($ispu as $id_stasiun => $stasiun) {
				$_worst_ispu = 0;
				$_worst_param = "";
				if ($stasiun["pm25"] < 500 && $_worst_ispu < $stasiun["pm25"]) {
					$_worst_ispu = $stasiun["pm25"];
					$_worst_param = "pm25";
				}
				if ($stasiun["pm10"] < 500 && $_worst_ispu < $stasiun["pm10"]) {
					$_worst_ispu = $stasiun["pm10"];
					$_worst_param = "pm10";
				}
				if ($stasiun["so2"] < 500 && $_worst_ispu < $stasiun["so2"]) {
					$_worst_ispu = $stasiun["so2"];
					$_worst_param = "so2";
				}
				if ($stasiun["co"] < 500 && $_worst_ispu < $stasiun["co"]) {
					$_worst_ispu = $stasiun["co"];
					$_worst_param = "co";
				}
				if ($stasiun["o3"] < 500 && $_worst_ispu < $stasiun["o3"]) {
					$_worst_ispu = $stasiun["o3"];
					$_worst_param = "o3";
				}
				if ($stasiun["no2"] < 500 && $_worst_ispu < $stasiun["no2"]) {
					$_worst_ispu = $stasiun["no2"];
					$_worst_param = "no2";
				}
				$ispu[$id_stasiun]["worst_ispu"] = $_worst_ispu;
				$ispu[$id_stasiun]["worst_param"] = $_worst_param;
				$ispu[$id_stasiun]["category"] = $category = $this->aqmmaster_m->get_category($_worst_ispu);
				$ispu[$id_stasiun]["effect"] = $category = $this->aqmmaster_m->get_effect($_worst_ispu, $_worst_param);
				$latlng = $category = $this->aqmmaster_m->get_LatLng($stasiun["id_stasiun"]);
				$ispu[$id_stasiun]["lat"] = $latlng["lat"];
				$ispu[$id_stasiun]["lng"] = $latlng["lng"];

				if ($stasiun["pm25"] < 500 && $worst_ispu < $stasiun["pm25"]) {
					$worst_ispu = $stasiun["pm25"];
					$worst_param = "pm25";
					$worst_stasiun_id = $stasiun["id_stasiun"];
				}
				if ($stasiun["pm10"] < 500 && $worst_ispu < $stasiun["pm10"]) {
					$worst_ispu = $stasiun["pm10"];
					$worst_param = "pm10";
					$worst_stasiun_id = $stasiun["id_stasiun"];
				}
				if ($stasiun["so2"] < 500 && $worst_ispu < $stasiun["so2"]) {
					$worst_ispu = $stasiun["so2"];
					$worst_param = "so2";
					$worst_stasiun_id = $stasiun["id_stasiun"];
				}
				if ($stasiun["co"] < 500 && $worst_ispu < $stasiun["co"]) {
					$worst_ispu = $stasiun["co"];
					$worst_param = "co";
					$worst_stasiun_id = $stasiun["id_stasiun"];
				}
				if ($stasiun["o3"] < 500 && $worst_ispu < $stasiun["o3"]) {
					$worst_ispu = $stasiun["o3"];
					$worst_param = "o3";
					$worst_stasiun_id = $stasiun["id_stasiun"];
				}
				if ($stasiun["no2"] < 500 && $worst_ispu < $stasiun["no2"]) {
					$worst_ispu = $stasiun["no2"];
					$worst_param = "no2";
					$worst_stasiun_id = $stasiun["id_stasiun"];
				}
			}

			$category = $this->aqmmaster_m->get_category($worst_ispu);
			$effect = $this->aqmmaster_m->get_effect($worst_ispu, $worst_param);
			$resumes = ["worst_ispu" => $worst_ispu, "worst_param" => $worst_param, "worst_stasiun_id" => $worst_stasiun_id, "category" => $category, "effect" => $effect, "ispu" => $ispu];


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

	public function aqmCitiesinfo_get()
	{
		$lat = $this->get('lat');
		$lng = $this->get('lng');
		$limit = $this->get('limit');
		$xx = 0;
		if ($lat == "" && $lng == "") {
			$stasiuns = $this->aqmmaster_m->get_available_stasiuns();
		} else {
			$stasiuns = $this->aqmmaster_m->get_available_stasiuns($lat, $lng);
		}
		$id_stasiuns = [];
		$content_exist = false;

		foreach ($stasiuns as $stasiun) {
			$stasiun_info = $this->aqmmaster_m->get_stasiun_info($stasiun["id_stasiun"]);
			if ($stasiun_info["id"] * 1 > 0) {
				$id_stasiuns[] = $stasiun["id_stasiun"];
				$content_exist = true;
				$last_aqm_data = $this->aqmmaster_m->get_last_aqm_data($stasiun["id_stasiun"]);
				$ispu = @$this->aqmmaster_m->get_ispu([$stasiun["id_stasiun"]])[0];

				$worst_ispu = 0;
				if ($ispu["pm25"] < 500 && $worst_ispu < $ispu["pm25"]) {
					$worst_ispu = $ispu["pm25"];
				}
				if ($ispu["pm10"] < 500 && $worst_ispu < $ispu["pm10"]) {
					$worst_ispu = $ispu["pm10"];
				}
				if ($ispu["so2"] < 500 && $worst_ispu < $ispu["so2"]) {
					$worst_ispu = $ispu["so2"];
				}
				if ($ispu["co"] < 500 && $worst_ispu < $ispu["co"]) {
					$worst_ispu = $ispu["co"];
				}
				if ($ispu["o3"] < 500 && $worst_ispu < $ispu["o3"]) {
					$worst_ispu = $ispu["o3"];
				}
				if ($ispu["no2"] < 500 && $worst_ispu < $ispu["no2"]) {
					$worst_ispu = $ispu["no2"];
				}

				if ($worst_ispu <= 50) $category = "BAIK";
				else if ($worst_ispu <= 100) $category = "SEDANG";
				else if ($worst_ispu <= 199) $category = "TIDAK SEHAT";
				else if ($worst_ispu <= 299) $category = "SANGAT TIDAK SEHAT";
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
					'pressure'			=> round($last_aqm_data["pressure"], 1),
					'temperature'		=> round($last_aqm_data["temperature"], 1),
					'wind_direction'	=> round($last_aqm_data["wd"], 0),
					'wind_speed'		=> round($last_aqm_data["ws"], 0),
					'humidity'			=> round($last_aqm_data["humidity"], 0),
					'rain_rate'			=> round($last_aqm_data["rain_intensity"], 1),
					'solar_radiation'	=> round($last_aqm_data["sr"], 0)
				];
				$xx++;
				if (@$limit > 0) if ($xx >= @$limit) break;
			}
		}


		if ($content_exist) {
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
		$stasiuns = $this->aqmmaster_m->get_stasiun_id_by_latlng(["lat" => $this->get('lat'), "lon" => $this->get('lon')]);
		if ($stasiuns["id_stasiun"]) {
			$id_stasiuns[] = $stasiuns["id_stasiun"];
			$ispu = $this->aqmmaster_m->get_ispu($id_stasiuns)[0];
			$last_aqm_data = $this->aqmmaster_m->get_last_aqm_data($stasiuns["id_stasiun"]);

			$worst_ispu = 0;
			if ($ispu["pm25"] < 500 && $worst_ispu < $ispu["pm25"]) {
				$worst_ispu = $ispu["pm25"];
			}
			if ($ispu["pm10"] < 500 && $worst_ispu < $ispu["pm10"]) {
				$worst_ispu = $ispu["pm10"];
			}
			if ($ispu["so2"] < 500 && $worst_ispu < $ispu["so2"]) {
				$worst_ispu = $ispu["so2"];
			}
			if ($ispu["co"] < 500 && $worst_ispu < $ispu["co"]) {
				$worst_ispu = $ispu["co"];
			}
			if ($ispu["o3"] < 500 && $worst_ispu < $ispu["o3"]) {
				$worst_ispu = $ispu["o3"];
			}
			if ($ispu["no2"] < 500 && $worst_ispu < $ispu["no2"]) {
				$worst_ispu = $ispu["no2"];
			}

			if ($worst_ispu <= 50) $category = "BAIK";
			else if ($worst_ispu <= 100) $category = "SEDANG";
			else if ($worst_ispu <= 199) $category = "TIDAK SEHAT";
			else if ($worst_ispu <= 299) $category = "SANGAT TIDAK SEHAT";
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
				'pressure'			=> round($last_aqm_data["pressure"], 1),
				'temperature'		=> round($last_aqm_data["temperature"], 1),
				'wind_direction'	=> round($last_aqm_data["wd"], 0),
				'wind_speed'		=> round($last_aqm_data["ws"], 0),
				'humidity'			=> round($last_aqm_data["humidity"], 0),
				'rain_rate'			=> round($last_aqm_data["rain_intensity"], 1),
				'solar_radiation'	=> round($last_aqm_data["sr"], 0)
			], 200);
		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Data Tidak Ditemukan'
			], 404);
		}
	}

	public function aqmDetailStasiunById_get()
	{
		$stasiun = $this->aqmmaster_m->get_stasiun_info($this->get('id_stasiun'));
		$ispu = $this->aqmmaster_m->get_ispu($this->get('id_stasiun'))[0];
		$last_aqm_data = $this->aqmmaster_m->get_last_aqm_data($this->get('id_stasiun'));
		if ($ispu["id"] > 0) {
			$worst_ispu = 0;
			if ($ispu["pm25"] < 500 && $worst_ispu < $ispu["pm25"]) {
				$worst_ispu = $ispu["pm25"];
			}
			if ($ispu["pm10"] < 500 && $worst_ispu < $ispu["pm10"]) {
				$worst_ispu = $ispu["pm10"];
			}
			if ($ispu["so2"] < 500 && $worst_ispu < $ispu["so2"]) {
				$worst_ispu = $ispu["so2"];
			}
			if ($ispu["co"] < 500 && $worst_ispu < $ispu["co"]) {
				$worst_ispu = $ispu["co"];
			}
			if ($ispu["o3"] < 500 && $worst_ispu < $ispu["o3"]) {
				$worst_ispu = $ispu["o3"];
			}
			if ($ispu["no2"] < 500 && $worst_ispu < $ispu["no2"]) {
				$worst_ispu = $ispu["no2"];
			}

			if ($worst_ispu <= 50) $category = "BAIK";
			else if ($worst_ispu <= 100) $category = "SEDANG";
			else if ($worst_ispu <= 199) $category = "TIDAK SEHAT";
			else if ($worst_ispu <= 299) $category = "SANGAT TIDAK SEHAT";
			else $category = "BERBAHAYA";


			$this->response([
				'status' 			=> true,
				'request_id'		=> @$_GET["request_id"] * 1,
				'category'			=> $category,
				'stasiun_name'		=> $stasiun["nama"] . " - " . $this->get('id_stasiun'),
				'city'				=> $stasiun["kota"],
				'province'			=> $stasiun["provinsi"],
				'pm25'				=> $ispu["pm25"],
				'pm10'				=> $ispu["pm10"],
				'so2'				=> $ispu["so2"],
				'co'				=> $ispu["co"],
				'o3'				=> $ispu["o3"],
				'no2'				=> $ispu["no2"],
				'pressure'			=> round($last_aqm_data["pressure"], 1),
				'temperature'		=> round($last_aqm_data["temperature"], 1),
				'wind_direction'	=> round($last_aqm_data["wd"], 0),
				'wind_speed'		=> round($last_aqm_data["ws"], 0),
				'humidity'			=> round($last_aqm_data["humidity"], 0),
				'rain_rate'			=> round($last_aqm_data["rain_intensity"], 1),
				'solar_radiation'	=> round($last_aqm_data["sr"], 0)
			], 200);
		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Data Tidak Ditemukan'
			], 404);
		}
	}

	public function aqmEffectByStasiun_get()
	{
		$id_stasiun = $this->get('id_stasiun');
		$ispu = $this->aqmmaster_m->get_ispu([$id_stasiun])[0];
		if ($ispu) {
			$worst_ispu = 0;
			$worst_param = "";
			if ($ispu["pm25"] < 500 && $worst_ispu < $ispu["pm25"]) {
				$worst_ispu = $ispu["pm25"];
				$worst_param = "pm25";
			}
			if ($ispu["pm10"] < 500 && $worst_ispu < $ispu["pm10"]) {
				$worst_ispu = $ispu["pm10"];
				$worst_param = "pm10";
			}
			if ($ispu["so2"] < 500 && $worst_ispu < $ispu["so2"]) {
				$worst_ispu = $ispu["so2"];
				$worst_param = "so2";
			}
			if ($ispu["co"] < 500 && $worst_ispu < $ispu["co"]) {
				$worst_ispu = $ispu["co"];
				$worst_param = "co";
			}
			if ($ispu["o3"] < 500 && $worst_ispu < $ispu["o3"]) {
				$worst_ispu = $ispu["o3"];
				$worst_param = "o3";
			}
			if ($ispu["no2"] < 500 && $worst_ispu < $ispu["no2"]) {
				$worst_ispu = $ispu["no2"];
				$worst_param = "no2";
			}
			$effect = $this->aqmmaster_m->get_effect($worst_ispu, $worst_param);
			$this->response([
				'status' 			=> true,
				'request_id'		=> @$_GET["request_id"] * 1,
				'worst_ispu'		=> $worst_ispu,
				'worst_param'		=> $worst_param,
				'effect'			=> $effect,
				'pm25'				=> $ispu["pm25"],
				'pm10'				=> $ispu["pm10"],
				'so2'				=> $ispu["so2"],
				'co'				=> $ispu["co"],
				'o3'				=> $ispu["o3"],
				'no2'				=> $ispu["no2"]
			], 200);
		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Data Tidak Ditemukan'
			], 404);
		}
	}

	public function aqmOutdoor_get()
	{
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
				'pm25_val'			=> $last_aqm_data["pm25"],
				'pm10_val'			=> $last_aqm_data["pm10"],
				'so2_val'			=> $last_aqm_data["so2"],
				'co_val'			=> $last_aqm_data["co"],
				'o3_val'			=> $last_aqm_data["o3"],
				'no2_val'			=> $last_aqm_data["no2"],
				'hc_val'			=> $last_aqm_data["hc"],
				'pressure'			=> round($last_aqm_data["pressure"], 1),
				'temperature'		=> round($last_aqm_data["temperature"], 1),
				'wind_direction'	=> round($last_aqm_data["wd"], 0),
				'wind_speed'		=> round($last_aqm_data["ws"], 0),
				'humidity'			=> round($last_aqm_data["humidity"], 0),
				'rain_rate'			=> round($last_aqm_data["rain_intensity"], 1),
				'solar_radiation'	=> round($last_aqm_data["sr"], 0)
			], 200);
		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Data Tidak Ditemukan'
			], 404);
		}
	}

	public function aqmCloserStasiun_get()
	{
		$lat = $this->get('lat');
		$lng = $this->get('lng');
		$data = $this->aqmmaster_m->get_closer_stasiun_id($lat, $lng);
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

	public function aqmAppsVersion_get()
	{
		$this->response([
			'status' 	=> true,
			'version' 		=> "12"
		], 200);
	}

	public function aqmNews_get()
	{
		$keyword = $this->get('k');
		$data = $this->aqmmaster_m->get_aqm_news($keyword);
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

	public function aqmNewsTop_get()
	{
		$limit = @$this->get('limit');
		if (!$limit) $limit = 6;
		$data = $this->aqmmaster_m->get_aqm_news_top($limit);
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

	public function aqmRankPm10yesterday_get()
	{
		$data = $this->aqmmaster_m->get_aqm_rank_pm10_yesterday();

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

	public function aqmRankPm25yesterday_get()
	{
		$data = $this->aqmmaster_m->get_aqm_rank_pm25_yesterday();

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

	public function aqmRankSo2yesterday_get()
	{
		$data = $this->aqmmaster_m->get_aqm_rank_so2_yesterday();

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

	public function aqmRankCoyesterday_get()
	{
		$data = $this->aqmmaster_m->get_aqm_rank_co_yesterday();

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

	public function aqmRanko3yesterday_get()
	{
		$data = $this->aqmmaster_m->get_aqm_rank_o3_yesterday();

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

	public function aqmRankNo2yesterday_get()
	{
		$data = $this->aqmmaster_m->get_aqm_rank_no2_yesterday();

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

	public function aqmnewsslug_get()
	{

		$id = $this->get('slug');

		if ($id === null) {
			$data = $this->aqmmaster_m->get_newsslug();
		} else {
			$data = $this->aqmmaster_m->get_newsslug($id);
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

	public function aqmWindroseById_get()
	{
		$speeds[] = 0;
		$speeds[] = 3;
		$speeds[] = 6;
		$speeds[] = 10;
		foreach ($speeds as $key => $speed) {
			$data[$key][0] = 0;
			$data[$key][1] = 0;
			$data[$key][2] = 0;
			$data[$key][3] = 0;
			$data[$key][4] = 0;
			$data[$key][5] = 0;
			$data[$key][6] = 0;
			$data[$key][7] = 0;
			$data[$key][8] = 0;
			$data[$key][9] = 0;
			$data[$key][10] = 0;
			$data[$key][11] = 0;
			$data[$key][12] = 0;
			$data[$key][13] = 0;
			$data[$key][14] = 0;
			$data[$key][15] = 0;
			if (isset($speed[$key + 1])) $speed2 = $speed[$key + 1];
			else $speed2 = 99999999999999;
			$winds = $this->aqmmaster_m->get_winds($this->get('id_stasiun'), $speed, $speed2);
			foreach ($winds as $wind) {
				if ($wind["wd"] >= 0  && $wind["wd"] <= 22.5 || $wind["wd"] == 360)
					$data[$key][0]++;
				if ($wind["wd"] > 22.5 && $wind["wd"] <= 45)
					$data[$key][1]++;
				if ($wind["wd"] > 45 && $wind["wd"] <= 67.5)
					$data[$key][2]++;
				if ($wind["wd"] > 67.5 && $wind["wd"] <= 90)
					$data[$key][3]++;
				if ($wind["wd"] > 90 && $wind["wd"] <= 112.5)
					$data[$key][4]++;
				if ($wind["wd"] > 112.5 && $wind["wd"] <= 135)
					$data[$key][5]++;
				if ($wind["wd"] > 135 && $wind["wd"] <= 157.5)
					$data[$key][6]++;
				if ($wind["wd"] > 157.5 && $wind["wd"] <= 180)
					$data[$key][7]++;
				if ($wind["wd"] > 180 && $wind["wd"] <= 202.5)
					$data[$key][8]++;
				if ($wind["wd"] > 202.5 && $wind["wd"] <= 225)
					$data[$key][9]++;
				if ($wind["wd"] > 225 && $wind["wd"] <= 247.5)
					$data[$key][10]++;
				if ($wind["wd"] > 247.5 && $wind["wd"] <= 270)
					$data[$key][11]++;
				if ($wind["wd"] > 270 && $wind["wd"] <= 292.5)
					$data[$key][12]++;
				if ($wind["wd"] > 292.5 && $wind["wd"] <= 315)
					$data[$key][13]++;
				if ($wind["wd"] > 315 && $wind["wd"] <= 337.5)
					$data[$key][14]++;
				if ($wind["wd"] > 337.5 && $wind["wd"] < 360)
					$data[$key][15]++;
			}
		}
		$grandtotal = 0;
		foreach ($data as $key => $_data) {
			$total[$key] = 0;
			foreach ($_data as $__data) {
				$total[$key] += $__data;
				$grandtotal += $__data;
			}
		}
		if ($grandtotal > 0) {
			foreach ($data as $key => $_data) {
				foreach ($_data as $key2 => $__data) {
					$percentage[$key][$key2] = number_format($__data / $grandtotal * 100, 2) * 1;
				}
			}

			$this->response([
				'status'	=> true,
				'data'		=> $percentage
			], 200);
		} else {
			$this->response([
				'status' 	=> false,
				'data'		=> [],
				'message' 	=> 'Data Tidak Ditemukan'
			], 404);
		}
	}
}
