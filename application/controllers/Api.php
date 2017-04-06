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
            $this->log(array(
                "status" => 1,
                "userdata" => $user
            ));
        } else {
            $this->log(array(
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
        $this->log(array("statusCode" => $code, "postdata"=>$this->input->post()));
    }

    public function debug() {
        $_SESSION = array("test"=>"ajag");
        var_dump($this->session->userdata("test"));
    }


    private function log($s) {
        echo json_encode($s);
    }

}