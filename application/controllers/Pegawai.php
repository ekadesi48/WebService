<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class pegawai extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
    }

    //Menampilkan data Pegawai
    public function index_get()
    {
        $id_pegawai = $this->get('id_pegawai');
        if ($id_pegawai == '') {
            $data = $this->db->get('pegawai')->result();
        } else {
            $this->db->where('id_pegawai', $id_pegawai);
            $data = $this->db->get('pegawai')->result();
        }
        $result = [
            "took" => $_SERVER["REQUEST_TIME_FLOAT"],
            "code" => 200,
            "message" => "Response successfully",
            "data" => $data
        ];
        header('access-control-allow-mehtods:GET');
        header('access-control-allow-origin:*');
        $this->response($result, 200);
    }

    //Menambah data
    public function index_post()
    {
        $data = array(
            'nama_pegawai'       => $this->post('nama_pegawai'),
            'NIK'             => $this->post('NIK'),
            'alamat'              => $this->post('alamat')
        );
        $insert = $this->db->insert('pegawai', $data);
        if ($insert) {
            $result = [
                "took" => $_SERVER["REQUEST_TIME_FLOAT"],
                "code" => 201,
                "message" => "Data has successfully added",
                "data" => $data
            ];
            $this->response($result, 201);
        } else {
            $result = [
                "took" => $_SERVER["REQUEST_TIME_FLOAT"],
                "code" => 502,
                "message" => "Failed adding data",
                "data" => null
            ];
            $this->response($result, 502);
        }
    }

    //mengubah data
    public function index_put()
    {
        $id_pegawai  = $this->put('id_pegawai');
        $data = array(
            'nama_pegawai'       => $this->put('nama_pegawai'),
            'NIK'             => $this->put('NIK'),
            'alamat'              => $this->put('alamat')
        );
        $this->db->where('id_pegawai', $id_pegawai);
        $update = $this->db->update('pegawai', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    //Menghapus Data
    public function index_delete()
    {
        $id_pegawai = $this->delete('id_pegawai');
        $this->db->where('id_pegawai', $id_pegawai);
        $delete = $this->db->delete('pegawai');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
