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
