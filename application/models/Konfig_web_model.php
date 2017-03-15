<?php

/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 3/15/17
 * Time: 11:03 AM
 */
defined("BASEPATH") OR exit("Akses ditolak");

class Konfig_web_model extends CI_Model {

    public function status_maintenance() {
        $kondisiWeb = $this->db->get("konfig_web")->row();
        return ($kondisiWeb->maintenance == 1) ? true : false;
    }

    public function ubah_status_maintenance($k) {
        $this->db->update("konfig_web",array(
            "maintenance" => $k
        ));
        return true;
    }

}