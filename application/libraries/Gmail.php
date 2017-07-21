<?php

defined("BASEPATH") or exit("No direct script access allowed");

class Gmail
{

    private $scope;
    private $redirect_uri;
    private $client_id;
    private $client_secret;
    private $errors = [];
    private $session;
    private $input;

    public function __construct() {
        $CI = &get_instance();
        $this->session = $CI->session;
        $this->input = $CI->input;
    }

    /**
     * @param mixed $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    /**
     * @return mixed
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param mixed $redirect_uri
     */
    public function setRedirectUri($redirect_uri)
    {
        $this->redirect_uri = $redirect_uri;
    }

    /**
     * @return mixed
     */
    public function getRedirectUri()
    {
        return $this->redirect_uri;
    }

    /**
     * @param mixed $client_id
     */
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @param mixed $client_secret
     */
    public function setClientSecret($client_secret)
    {
        $this->client_secret = $client_secret;
    }

    /**
     * @return mixed
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     * @return mixed
     */
    public function getLoginUrl()
    {
        return "https://accounts.google.com/o/oauth2/v2/auth?"
            . "scope=" . $this->scope . "&"
            . "response_type=code&"
            . "redirect_uri=" . $this->redirect_uri . "&"
            . "client_id=" . $this->client_id . "&";
    }

    private function pushError($error)
    {
        array_push($this->errors, $error);
    }

    public function getErrors() {
        return $this->errors;
    }

    public function sign_in()
    {
        if (!isset($_GET['code']) or $this->session->has_userdata("access_token")) {
            //
        }
        $header = array("Content-Type: application/x-www-form-urlencoded");

        $data = http_build_query(
            array(
                'code' => str_replace("#", null, $_GET['code']),
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'redirect_uri' => $this->redirect_uri,
                'grant_type' => 'authorization_code'
            )
        );

        $url = "https://www.googleapis.com/oauth2/v4/token";

        $result = $this->Qassim_HTTP(1, $url, $header, $data);

        if (!empty($result['error'])) {
            return array(
                "status" => false,
                "result" => $result["error"]
            );
        } else {
            $info = $this->Qassim_HTTP(0, "https://www.googleapis.com/gmail/v1/users/me/profile", array("Authorization: Bearer " . $result["access_token"]), 0);
            return array(
                "status" => true,
                "result" => array(
                    "email" => $info["emailAddress"],
                    "access_token" => $result["access_token"]
                )
            );
        }
    }

    public function send()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST" and $this->session->has_userdata("access_token")) {
            $access_token = $this->session->userdata("access_token");
            $url = "https://www.googleapis.com/gmail/v1/users/me/messages/send";
            $header = array('Content-Type: application/json', "Authorization: Bearer ".$access_token);

            if (empty($_POST['subjek']) or empty($_POST['penerima']) or empty($_POST['isi'])) {
                $this->pushError("Isi semua field");
                return false;
            }

            $subject = $this->input->post('subjek');
            $to = $this->input->post('penerima');
            $message = $this->input->post('isi');

            $line = "\n";
            $raw = "Content-Type: text/html; charset=charset=iso-8859-1".$line;
            $raw .= "To: $to" . $line;
            $raw .= "Subject: $subject" . $line . $line;
            $raw .= $message;

            $base64 = $this->base64url_encode($raw);
            $data = '{ "raw" : "' . $base64 . '" }';
            $send = $this->Qassim_HTTP(1, $url, $header, $data);

            if (!empty($send['id'])) {
                return true;
            } else {
                if (!empty($send['error']['errors'][0]['reason'])) {
                    $this->pushError($send["error"]["errors"]);
                    return false;
                } else {
                    $this->pushError("Error!");
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public function inbox() {
        $return = $this->request_for_data("https://www.googleapis.com/gmail/v1/users/me/messages/");
        $list = [];
        foreach($return->messages as $message) {
            $list[] = $this->request_for_data("https://www.googleapis.com/gmail/v1/users/me/messages/".$message->id);
        }
        return $list;
    }

    private function request_for_data($url) {
        $opts = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"Content-Type: application/json\r\n" .
                    "Authorization: Bearer ".$this->session->userdata("access_token")."\r\n"
            )
        );
        $context = stream_context_create($opts);
        return json_decode(file_get_contents($url,false,$context));
    }

    private function base64url_encode($mime) {
        return rtrim(strtr(base64_encode($mime), '+/', '-_'), '=');
    }

    public function Qassim_HTTP($method, $url, $header, $data)
    {

        if ($method == 1) {
            $method_type = 1; // POST
        } elseif ($method == 2) {
            $method_type = 2; // DELETE
        } else {
            $method_type = 0; // GET
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_HEADER, 0);

        if ($header !== 0) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }

        if ($method_type == 1 or $method_type == 0) {
            curl_setopt($curl, CURLOPT_POST, $method_type);
        } else {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        }

        if ($data !== 0) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        $response = curl_exec($curl);
        $json = json_decode($response, true);
        curl_close($curl);

        return $json;

    }

}