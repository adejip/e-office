<?php

/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 1/23/2017
 * Time: 9:28 PM
 */
defined("BASEPATH") OR exit("Akses ditolak!");

class Pengguna_model extends CI_Model {

    public function login($username,$password) {
        $this->db->select("pengguna.*");
        $this->db->select("jabatan.nama_jabatan");
        $this->db->select("dinas.nama_dinas");
        $this->db->from("pengguna");
        $this->db->join("jabatan","pengguna.id_jabatan = jabatan.id_jabatan","left");
        $this->db->join("dinas","pengguna.id_dinas = dinas.id_dinas","left");
        $data = $this->db->where("username",$username)->where("password",md5($password))->where("blokir",0)->get();
        if($data->num_rows() > 0) {
            return $data->row_array();
        } else return false;
    }

    public function ambil_per_grup() {
        $daftar_dinas = $this->db->get("dinas")->result();
        $detail_user = array();

        foreach($daftar_dinas as $dinas) {
            $detail_user[$dinas->nama_dinas] = $this->db->select("pengguna.id_pengguna,pengguna.nama_lengkap,jabatan.nama_jabatan")->join("jabatan","pengguna.id_jabatan = jabatan.id_jabatan")->where("pengguna.id_dinas",$dinas->id_dinas)->get("pengguna")->result();
        }

        return $detail_user;
    }

    public function tambah_penerima_otomatis() {
        $post = $this->input->post();
        $daftar_penerima = $post["penerima"];
        $this->db->where("id_pengguna",$this->session->userdata("id_pengguna"));
        $this->db->delete("penerima_otomatis");
        foreach($daftar_penerima as $key=>$pn) {
            $ins[$key]["penerima"] = $pn;
            $ins[$key]["id_pengguna"] = $this->session->userdata("id_pengguna");
        }
        return $this->db->insert_batch("penerima_otomatis",$ins);
    }

    public function ambil_penerima_otomatis() {
        $this->db->select("penerima");
        $this->db->where("id_pengguna",$this->session->userdata("id_pengguna"));
        $this->db->from("penerima_otomatis");
        return $this->db->get()->result();
    }

    public function ambil_semua() {
        $this->db->select("pengguna.id_pengguna,pengguna.nama_lengkap,pengguna.blokir,pengguna.nip,pengguna.disposisi,jabatan.nama_jabatan,dinas.nama_dinas");
        $this->db->from("pengguna");
        $this->db->join("jabatan","pengguna.id_jabatan = jabatan.id_jabatan","left");
        $this->db->join("dinas","pengguna.id_dinas = dinas.id_dinas");

        $data = $this->db->get()->result();
        return $data;
    }

    public function tambah() {
        $post = $this->input->post();
        unset($post["btnSubmit"]);

        if(isset($post["nama_lengkap"]) && isset($post["id_jabatan"]) && isset($post["id_dinas"]) && isset($post["username"]) && isset($post["password"])) {
            $post["disposisi"] = (isset($post["disposisi"])) ? 1 : 0;
            $post["password"] = md5($post["password"]);
            $post["blokir"] = 0;
            $num = $this->db->insert("pengguna",$post);
            return $num;
        } else return false;
    }

    public function ambil_berdasarkan_id($id)
    {
        $data = $this->db->where("id_pengguna", $id)->get("pengguna")->row();
        return $data;
    }

    public function edit() {
        $post = $this->input->post();
        unset($post["btnSubmit"]);

        if(isset($post["nama_lengkap"]) && isset($post["id_jabatan"]) && isset($post["id_dinas"]) && isset($post["username"])) {
            $post["disposisi"] = isset($post["disposisi"]) ? 1 : 0;
            $this->db->where("id_pengguna",$post["id_pengguna"]);
            unset($post["id_pengguna"]);
            $num = $this->db->update("pengguna",$post);
            return $num;
        } else return false;
    }

    public function edit_profil_pribadi() {
        $data = $this->input->post();
        if($data["username"] != "" && $data["cpassword"] != "") {
            if(md5($data["cpassword"]) == $this->session->userdata("password")) {
                // TO-DO : Update data user

                $this->db->where("id_pengguna",$this->session->userdata("id_pengguna"));
                unset($data["cpassword"]);

                if($data["password"] == ""){
                    unset($data["password"]);
                } else {
                    $data["password"] = md5($data["password"]);
                    $this->session->set_userdata("password",$data["password"]);
                }

                $this->session->set_userdata("username",$data["username"]);
                return ($this->db->update("pengguna",$data) == true) ? 3 : 0;

            } else {
                return 2;
            }
        } else {
            return 1;
        }
    }

    public function blokir($id) {
        $this->db->where("id_pengguna",$id)->update("pengguna",array("blokir"=>1));
    }

    public function buka($id) {
        $this->db->where("id_pengguna",$id)->update("pengguna",array("blokir"=>0));
    }

}