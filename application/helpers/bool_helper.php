<?php
/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 3/7/17
 * Time: 4:46 PM
 */

defined("BASEPATH") OR exit("Akses script langsung ditolak!");


if(!function_exists("termasuk_penerima")) {

    function termasuk_penerima($curUsr,$daftar_penerima) {
        foreach($daftar_penerima as $pn) {
            if($pn->penerima == $curUsr) {
                return true;
                break;
            } else {
                continue;
            }
        }
    }

}