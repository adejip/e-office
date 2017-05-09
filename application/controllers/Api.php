<?php

/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 4/1/17
 * Time: 4:20 PM
 */
defined("BASEPATH") OR exit("Akses ditolak!");

class Api extends CI_Controller {


    public function __construct() {
        parent::__construct();
        $this->load->model("Agenda_model","agenda");
        $this->load->model("Pengguna_model","pengguna");
        $this->load->model("Surat_model","surat");
        $this->load->model("Disposisi_model","disposisi");
        header("Content-Type: application/json;charset=utf-8");
    }

    public function login() {
        $post = $this->input->post();

        $user = $this->pengguna->login($post["username"],$post["password"]);
        if($user != false) {
            $this->kirimJSON(array(
                "status" => 1,
                "userdata" => $user
            ));
        } else {
            $this->kirimJSON(array(
                "status" => 0
            ));
        }
    }

    public function edit_data_pengguna() {
        if(isset($_POST["sesspassword"]) && isset($_POST["id_pengguna"])) {
            $_SESSION["password"] = $_POST["sesspassword"];
            $_SESSION["id_pengguna"] = $_POST["id_pengguna"];
            unset($_POST["sesspassword"]);
            unset($_POST["id_pengguna"]);
        }

        $code = $this->pengguna->edit_profil_pribadi();
        $this->kirimJSON(array("statusCode" => $code, "postdata"=>$this->input->post()));
    }

    public function ambil_surat_masuk() {
        $daftar_surat = $this->surat->ambil_daftar_surat_masuk($_POST["id_pengguna"]);
        $this->kirimJSON($daftar_surat);
    }

    public function ambil_satu_surat() {
        $id_pesan = $this->input->post("id_pesan");
        $id_user = $this->input->post("id_pengguna");
        $this->surat->baca_surat($id_pesan,$id_user);
        $surat = $this->surat->ambil_surat_berdasarkan_id($id_pesan,"ke_user",$id_user);
        $this->kirimJSON($surat);
    }

    public function debug() {
        $_SESSION = array("test"=>"ajag");
        var_dump($this->session->userdata("test"));
    }

    private function kirimJSON($s) {
        echo json_encode($s);
    }

}