<?php

/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 2/4/2017
 * Time: 11:10 PM
 */
class Pemberitahuan_model extends CI_Model {

    public function ambil() {
        $notif = $this->db->get("pemberitahuan");
        return $notif->result();
    }

    public function buat(Array $konfig) {
        return $this->db->insert("pemberitahuan",$konfig);
    }

}