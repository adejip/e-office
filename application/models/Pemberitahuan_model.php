<?php

/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 2/4/2017
 * Time: 11:10 PM
 */
class Pemberitahuan_model extends CI_Model {

    public function ambil() {
        $this->db->select("pemberitahuan.*,pengguna.nama_lengkap");
        $this->db->where("pemberitahuan.id_pengguna",$this->session->userdata("id_pengguna"));
        $this->db->join("pengguna","pemberitahuan.dari_pengguna = pengguna.id_pengguna","left");
        $this->db->order_by("waktu","desc");
        $notif = $this->db->get("pemberitahuan");
        return $notif->result();
    }

    public function buat(Array $konfig) {
        return $this->db->insert("pemberitahuan",$konfig);
    }

    public function baca($id) {
        $this->db->where("id_pemberitahuan",$id);
        $this->db->update("pemberitahuan",array(
            "dibaca" => 1
        ));
        return true;
    }

}