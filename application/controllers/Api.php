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

		$id = $this->get('id');

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

		$id = $this->get('id');

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
				if($stasiun["pm25"] < 300 && $worst_ispu < $stasiun["pm25"]){ $worst_ispu = $stasiun["pm25"]; $worst_param = "pm25"; $worst_stasiun_id = $stasiun["id_stasiun"]; }
				if($stasiun["pm10"] < 300 && $worst_ispu < $stasiun["pm10"]){ $worst_ispu = $stasiun["pm10"]; $worst_param = "pm10"; $worst_stasiun_id = $stasiun["id_stasiun"]; }
				if($stasiun["so2"] < 300 && $worst_ispu < $stasiun["so2"]){ $worst_ispu = $stasiun["so2"]; $worst_param = "so2"; $worst_stasiun_id = $stasiun["id_stasiun"]; }
				if($stasiun["co"] < 300 && $worst_ispu < $stasiun["co"]){ $worst_ispu = $stasiun["co"]; $worst_param = "co"; $worst_stasiun_id = $stasiun["id_stasiun"]; }
				if($stasiun["o3"] < 300 && $worst_ispu < $stasiun["o3"]){ $worst_ispu = $stasiun["o3"]; $worst_param = "o3"; $worst_stasiun_id = $stasiun["id_stasiun"]; }
				if($stasiun["no2"] < 300 && $worst_ispu < $stasiun["no2"]){ $worst_ispu = $stasiun["no2"]; $worst_param = "no2"; $worst_stasiun_id = $stasiun["id_stasiun"]; }
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

}
