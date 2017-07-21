<?php

class Email extends CI_Controller
{

    private $auth_url;
    private $google_client;

    public function __construct()
    {
        parent::__construct();
        require_once $this->get_google_client_dir("/vendor/autoload.php");
        $this->google_client = new Google_Client();
        $this->google_client->setAuthConfig($this->get_google_client_dir("/client_secret.json"));
        $this->google_client->setScopes(array(
            Google_Service_Gmail::MAIL_GOOGLE_COM,
            Google_Service_Oauth2::USERINFO_EMAIL
        ));
        $this->auth_url = $this->google_client->createAuthUrl();
        if($this->session->has_userdata("google_access_token"))
            $this->google_client->setAccessToken($this->session->userdata("google_access_token"));
        header("Content-Type: application/json");
    }

    public function gmail_sign_in()
    {
        $url = $this->input->get("return");
        $this->session->set_userdata(array("url" => $url));
        redirect($this->auth_url);
    }

    public function gmail_success_callback()
    {
        if (!isset($_GET["error"]) && isset($_GET["code"])) {
            $this->google_client->authenticate($_GET["code"]);
            $access_token = $this->google_client->getAccessToken();
            $this->session->set_userdata("google_access_token", $access_token);
            $this->google_client->setAccessToken($this->session->userdata("google_access_token"));
            $oauth2_service = new Google_Service_Oauth2($this->google_client);
            $userinfo = $oauth2_service->userinfo;
            $this->session->set_userdata("google_userinfo", (array)$userinfo->get());
            $url = $this->session->userdata("url");
            $this->session->unset_userdata("url");
            $url = str_replace("#", "", $url);
            redirect($url . "?emailLoggedIn=" . $userinfo->get()->getEmail());
        } else {
            redirect(base_url("panel/"));
        }
//        $result = $this->gmail->sign_in();
//        if ($result["status"]) {
//            $this->session->set_userdata($result["result"]);
//            $url = $this->session->userdata("url");
//            $this->session->unset_userdata("url");
//            $url = str_replace("#", "", $url);
//            redirect($url . "?emailLoggedIn=" . $result["result"]["email"]);
//        } else {
//            redirect(base_url("panel/"));
//        }
    }

    public function gmail_send()
    {
        if(empty($_POST["subjek"]) || empty($_POST["penerima"]) || empty($_POST["isi"])) {
            echo json_encode(
                array(
                    "status" => false,
                    "errros" => "Isi semua fields"
                )
            );
            exit();
        }

        $gmail_service = new Google_Service_Gmail($this->google_client);
        $message = new Google_Service_Gmail_Message();

        $message->setRaw($this->make_raw($this->input->post("subjek"),$this->input->post("penerima"),$this->input->post("isi")));
        try {
            $return = $gmail_service->users_messages->send("me",$message);
            echo json_encode(
                array(
                    "status" => true,
                    "message_data" => $return
                )
            );
        } catch(Google_Service_Exception $e) {
            echo json_encode(
                array(
                    "status" => false,
                    "message" => $e->getMessage(),
                    "detailed" => $e->getErrors()
                )
            );
        }
    }

    public function gmail_cek_user()
    {
        if ($this->session->has_userdata("google_userinfo")) {
            echo json_encode(
                array(
                    "status" => true,
                    "data" => $this->session->userdata("google_userinfo")
                )
            );
        } else {
            echo json_encode(
                array(
                    "status" => false,
                    "data" => null
                )
            );
        }
    }

    public function gmail_inbox() {
        $gmail_service = new Google_Service_Gmail($this->google_client);
        $messages = $gmail_service->users_messages->listUsersMessages("me");
        $items = [];
        $inboxMessage = [];

        foreach($messages as $mlist){

            $optParamsGet2['format'] = 'full';
            $single_message = $gmail_service->users_messages->get('me',$mlist->id, $optParamsGet2);

            $message_id = $mlist->id;
            $headers = $single_message->getPayload()->getHeaders();
            $snippet = $single_message->getSnippet();

            foreach($headers as $single) {

                if ($single->getName() == 'Subject') {

                    $message_subject = $single->getValue();

                }

                else if ($single->getName() == 'Date') {

                    $message_date = $single->getValue();
                    $message_date = date('M jS Y h:i A', strtotime($message_date));
                }

                else if ($single->getName() == 'From') {

                    $message_sender = $single->getValue();
                    $message_sender = str_replace('"', '', $message_sender);
                }
            }


            $inboxMessage[] = [
                'messageId' => $message_id,
                'messageSnippet' => $snippet,
                'messageSubject' => $message_subject,
                'messageDate' => $message_date,
                'messageSender' => $message_sender
            ];

        }
        var_dump($inboxMessage);
    }

    private function make_raw($subject, $to, $message)
    {
        $line = "\n";
        $raw = "Content-Type: text/html; charset=charset=iso-8859-1" . $line;
        $raw .= "To: " . $to . $line;
        $raw .= "Subject: " . $subject . $line . $line;
        $raw .= $message;

        return rtrim(strtr(base64_encode($raw), '+/', '-_'), '=');

    }

    private function get_google_client_dir($target = "")
    {
        return APPPATH . "third_party/google-api-client" . $target;
    }

}