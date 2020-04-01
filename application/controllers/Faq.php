<?php
use chriskacerguis\RestServer\RestController;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

class Faq extends RestController {

    public function __construct()
    {
    	parent::__construct();
    }

	public function index_post()
	{
		if($this->faq_m->add_aqmfaq() > 0){
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
            if($this->faq_m->update_aqmfaq($data, $id) > 0){
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
            if($this->faq_m->delete_aqmfaq($id) > 0){
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
