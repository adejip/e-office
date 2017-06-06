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
        $konfig["dibaca"] = 0;
        $konfig["waktu"] = "Baru saja";
        $konfig["nama_lengkap"] = $this->db
            ->select("nama_lengkap")
            ->where("id_pengguna",$konfig["id_pengguna"])
            ->get("pengguna")->row()->nama_lengkap;
        curl_post(SOCKET_URL . "/kirimNotif",$konfig);
        unset($konfig["nama_lengkap"]);
        unset($konfig["waktu"]);

        if(isset($konfig["id_pesan"]))
            unset($konfig["id_pesan"]);

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