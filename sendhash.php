<?php

require_once "lib/checkvalid_class.php";
require_once "lib/user_class.php";
require_once "lib/config_class.php";
require_once "lib/mail_class.php";
require_once "lib/messagecontent_class.php";
$db = new DataBase();

class SendMailHash{
    private $valid;
    private $user;
    private $config;
    private $emails;

    public function __construct($db){
        session_start();
        $this->valid = new CheckValid();
        $this->user = new User($db);
        $this->config = new Config();
        $this->emails = new Mail();
    }

    private function returnPageMessage($message, $r){
        $_SESSION["page_message"] = $message;
        return $r;
    }
    private function sendEmailTo($mail, $messages){
        $this->emails->sendEmail($mail, "Відновлення паролю", $messages);
    }

    public function SendHash(){
        $login = $_SESSION["getlogin"];
        unset($_SESSION["getlogin"]);
        $mail = $this->user->getMail($login);
        $hash = $this->user->getHash($login);
        $link_activation = $this->config->address."recovery.php?hash=".$hash;
        $messages = "Для активації вашого акаунту перейдіть по ссилці ".$link_activation;
        if($mail) {
            $this->sendEmailTo($mail, $messages);
            return $this->returnPageMessage("RECOV_PASS", $this->config->address . "?view=message");
        }
    }
}
$act = new SendMailHash($db);
$act->SendHash();
$content = new MessageContent($db);
echo $content->getContent();
?>