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

    public function ambil_surat_keluar() {
        $daftar_surat = $this->surat->ambil_data_surat_dikirim($_POST["id_pengguna"]);
        $this->kirimJSON($daftar_surat);
    }

    public function ambil_satu_surat_keluar() {
        $daftar_surat = $this->surat->baca_data_surat_dikirim($_POST["id_pesan"],$_POST["id_pengguna"]);
        $this->kirimJSON($daftar_surat);
    }

    public function update_bintang() {
        $post = $this->input->post();
        $this->surat->update_star($post["id_relasi_pesan"],$post["starred"]);
        echo 1;
    }

    public function update_bintang_disposisi() {
        $post = $this->input->post();
        $this->disposisi->update_star($post["id_relasi_disposisi"],$post["starred"]);
        echo 1;
    }

    public function ambil_disposisi_masuk() {
        $daftar_disposisi = $this->disposisi->ambil_disposisi_masuk($_POST["id_pengguna"]);
        $this->kirimJSON($daftar_disposisi);
    }

    public function ambil_satu_disposisi_masuk() {
        $post = $this->input->post();
        $disposisi = $this->disposisi->ambil_satu_disposisi_masuk($post["id_disposisi"],$post["kode_disposisi"],$post["id_pengguna"]);
        $disposisi->follow_up = $this->disposisi->ambil_follow_up($post["id_disposisi"]);
        $this->disposisi->baca_disposisi($post["id_disposisi"],$post["kode_disposisi"],$post["id_pengguna"]);
        $this->kirimJSON($disposisi);
    }

    public function ambil_pengguna() {
        $daftar_pengguna = $this->pengguna->ambil_semua();
        $this->kirimJSON($daftar_pengguna);
    }

    public function kirim_surat() {
        $post = $this->input->post();
        $post["penerima"] = json_decode($post["penerima"]);
        if(isset($_FILES["file"])) {
            $gambar = $this->upload_files($_FILES["file"]);
            if($gambar === false) {
                $this->kirimJSON(array(
                    "status" => 0,
                    "pesan" => "File gagal terupload!"
                ));
                exit();
            }
            $post["lampiran"] = json_encode($gambar);
        }
        $id_pengguna = $post["id_pengguna"];
        unset($post["id_pengguna"]);
        $kirim = $this->surat->kirim($post,$id_pengguna);
        if($kirim) {
            $this->kirimJSON(array(
                "status" => 1,
                "pesan" => "Surat terkirim"
            ));
        } else {
            $this->kirimJSON(array(
                "status" => 0,
                "pesan" => "Surat gagal terkirim"
            ));
        }
    }

    public function kirim_disposisi() {
        $post = $this->input->post();
        $post["penerima"] = json_decode($post["penerima"]);
        if(isset($_FILES["file"])) {
            $gambar = $this->upload_files($_FILES["file"]);
            if($gambar === false) {
                $this->kirimJSON(array(
                    "status" => 0,
                    "pesan" => "File gagal terupload!"
                ));
                exit();
            }
            $post["lampiran"] = json_encode($gambar);
        }
        $id_pesan = $post["idpesan"];
        $id_pengguna = $post["idpengguna"];
        unset($post["idpesan"]);
        unset($post["idpengguna"]);
        $kirim = $this->disposisi->kirim($post,$id_pesan,$id_pengguna);
        if($kirim) {
            $this->kirimJSON(array(
                "status" => 1,
                "pesan" => "Disposisi terkirim"
            ));
        } else {
            $this->kirimJSON(array(
                "status" => 0,
                "pesan" => "Disposisi gagal terkirim"
            ));
        }
    }

    public function kirim_follow_up() {
        $post = $this->input->post();
        $id_disposisi = $post["id_disposisi"];
        $kode_disposisi = $post["kode_disposisi"];
        unset($post["kode_disposisi"]);
        $id_pengguna = $post["id_pengguna"];
        $follow_up = $this->disposisi->follow_up($post,$id_disposisi,$kode_disposisi,null,$id_pengguna);
        $this->kirimJSON($follow_up);
    }

    public function ambil_disposisi_keluar() {
        $post = $this->input->post();
        $daftar_disposisi = $this->disposisi->ambil_disposisi_keluar($post["id_pengguna"]);
        $this->kirimJSON($daftar_disposisi);
    }

    public function ambil_satu_disposisi_keluar() {
        $post = $this->input->post();
        $disposisi = $this->disposisi->ambil_satu_disposisi($post["id_disposisi"],$post["kode_disposisi"]);
        $disposisi->follow_up = $this->disposisi->ambil_follow_up($post["id_disposisi"]);
        $this->kirimJSON($disposisi);
    }

    private function upload_files($files,$path = "assets/uploads/lampiran/") {
        $config = array(
            'upload_path'   => $path,
            'allowed_types' => 'jpg|png|pdf|jpeg|bmp|gif|doc|docx|xls|xlsx|ppt|pptx',
            'overwrite'     => 1,
        );

        $this->load->library('upload', $config);

        $images = array();

        $split = explode(".",$files["name"]);
        $ext = end($split);

        $fileName = uniqid() .'_'. md5($files["name"]) . "." . $ext;

        $obj = new stdClass();
        $obj->file = $fileName;
        $obj->judul = $files["name"];
        $images[] = $obj;

        $config['file_name'] = $fileName;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('file')) {
            $this->upload->data();
        } else {
            return false;
            exit();
        }

        return $images;
    }

    private function kirimJSON($s) {
        echo json_encode($s);
    }

}