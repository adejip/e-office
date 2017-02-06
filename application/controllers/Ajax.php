<?php

/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 2/6/2017
 * Time: 10:19 AM
 */
defined("BASEPATH") OR exit("Akses script tidak diizinkan!");
class Ajax extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if(!$this->input->is_ajax_request()) {
            exit("Akses script tidak diizinkan!");
        }
        $this->load->helper("pengalih");
        proteksi_login($this->session->userdata());
        $this->load->model("Agenda_model","agenda");
    }

    public function tambah_agenda() {
        $deskripsi = $this->input->post("deskripsi");
        header("Content-Type: application/json;charset=utf-8");
        if($this->agenda->buat($deskripsi)) {
            echo json_encode(array("status"=>"ok"));
        } else {
            echo json_encode(array("status"=>"gagal"));
        }
    }

    public function ambil_agenda() {
        $data = $this->agenda->ambil();
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($data);
    }

    public function check_selesai() {
        $id_agenda = $this->input->post("id_agenda");
        $this->agenda->check_selesai($id_agenda);
    }

    public function hapus_agenda() {
        $id_agenda = $this->input->post("id_agenda");
        $this->agenda->hapus($id_agenda);
    }

    public  function edit_agenda() {
        $post = $this->input->post();
        $this->agenda->edit($post);
    }

}