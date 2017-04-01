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


    private function log($s) {
        echo json_encode($s);
    }

}