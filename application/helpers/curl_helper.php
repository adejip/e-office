<?php
/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 5/5/17
 * Time: 6:18 PM
 */

if(!function_exists("curl_post")) {
    function curl_post($url,$data) {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($data));

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        curl_exec($ch);

        curl_close($ch);

    }
}