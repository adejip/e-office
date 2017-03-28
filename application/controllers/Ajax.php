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
//        if(!$this->input->is_ajax_request()) {
//            exit("Akses script tidak diizinkan!");
//        }
        $this->load->helper("pengalih");
        proteksi_login($this->session->userdata());
        $this->load->model("Agenda_model","agenda");
        $this->load->model("Pengguna_model","pengguna");
        $this->load->model("Surat_model","surat");
        $this->load->model("Disposisi_model","disposisi");
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

    public function ambil_data_pengguna() {
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($this->session->userdata());
    }

    public function edit_data_pengguna() {
        $code = $this->pengguna->edit_profil_pribadi();
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode(array("statusCode" => $code));
    }

    public function update_star() {
        $this->surat->update_star($_POST["id_relasi_pesan"],$_POST["starred"]);
        echo 1;
    }

    public function update_star_disposisi() {
        $this->disposisi->update_star($_POST["id_relasi_disposisi"],$_POST["starred"]);
    }

    public function hitung_surat_per_tanggal() {
        header("Content-Type: application/json;charset=utf-8");
        $tanggal = json_decode($_POST["tanggal"]);

        foreach($tanggal as $tgl) {
            $hitungan["surat"][] = $this->surat->ambil_surat_per_tanggal($tgl);
            $hitungan["disposisi"][] = $this->disposisi->ambil_disposisi_per_tanggal($tgl);
        }

        echo json_encode($hitungan);
    }

    public function ambil_userdata() {
        var_dump($this->session->userdata());
    }

}