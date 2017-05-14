<?php

defined("BASEPATH") OR exit("Akses ditolak!");

if(!function_exists("is_doc")) {
    function is_doc($file) {
        $ext = explode(".",$file);
        $ext = strtolower(end($ext));
        $tipe_gambar = array("jpg","png","jpeg","bmp","gif");
        return
            (!in_array($ext,$tipe_gambar))
            ? true : false;
    }
}