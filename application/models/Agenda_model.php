<?php

/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 2/6/2017
 * Time: 10:23 AM
 */
defined("BASEPATH") OR exit("Akses script tidak diizinkan!");
class Agenda_model extends CI_Model {

    public function ambil() {
        $this->db->where("id_pengguna",$this->session->userdata("id_pengguna"));
        $this->db->order_by("id_agenda","desc");
        $data = $this->db->get("agenda")->result();
        return $data;
    }

    public function buat($deskripsi) {
        return $this->db->insert("agenda",array(
            "deskripsi" => $deskripsi,
            "id_pengguna" => $this->session->userdata("id_pengguna")
        ));
    }

    public function check_selesai($id_agenda) {
        return $this->db->where("id_agenda",$id_agenda)->update("agenda",array("selesai"=>1));
    }

    public function hapus($id_agenda) {
        return $this->db->where("id_agenda",$id_agenda)->delete("agenda");
    }

    public function edit($data) {
        $this->db->where("id_agenda",$data["id_agenda"]);
        unset($data["id_agenda"]);
        return $this->db->update("agenda",$data);
    }


}