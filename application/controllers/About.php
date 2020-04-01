<?php
use chriskacerguis\RestServer\RestController;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

class About extends RestController {

    public function __construct()
    {
    	parent::__construct();
    }

	public function index_post()
	{
		if($this->about_m->add_aqmabout() > 0){
			$this->response([
                    'status' 	=> true,
                    'data' 		=> 'Data Berhasil Ditambah'
                ], 200);
		}else{
			$this->response([
                    'status' 	=> false,
                    'message' 	=> 'Data Tidak Ditemukan'
                ], 404);
		}
	}

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'title'             => $this->put('title'),
            'content'           => $this->put('content'),
            'edited_at'         => $this->put('edited_at'),
            'edited_by'         => $this->put('edited_by')
        ];
        if($id === null){
            $this->response([
                'status'    => false,
                'message'   => 'id tidak ada'
            ], 404);
        } else {
            if($this->about_m->update_aqmabout($data, $id) > 0){
                $this->response([
                    'status'    => true,
                    'data'      => 'Data Berhasil Diedit'
                ], 200);
            } else {
                $this->response([
                    'status'    => false,
                    'message'   => 'Data Tidak Ditemukan'
                ], 404);
            }
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');

        if($id === null){
            $this->response([
                'status'    => false,
                'message'   => 'id tidak ada'
            ], 404);
        } else {
            if($this->about_m->delete_aqmabout($id) > 0){
                $this->response([
                    'status'    => true,
                    'data'      => 'Data Berhasil Dihapus'
                ], 200);
            } else {
                $this->response([
                    'status'    => false,
                    'message'   => 'Data Tidak Ditemukan'
                ], 404);
            }
        }
    }

}
