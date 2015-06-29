<?php

    require_once "lib/checkvalid_class.php";
    require_once "lib/user_class.php";
    require_once "lib/config_class.php";
    require_once "lib/recov_class.php";
    require_once "lib/messagecontent_class.php";

    $db = new DataBase();

    class Recovery{
        private $valid;
        private $user;
        private $config;

        public function __construct($db){
            session_start();
            $this->valid = new CheckValid();
            $this->user = new User($db);
            $this->config = new Config();
        }

        private function returnPageMessage($message, $r){
            $_SESSION["page_message"] = $message;
            return $r;
        }

        public function Recov(){
            $db = new DataBase();
            $hash = $_GET["hash"];
            $_SESSION["gethash"] = $hash;
            if (!$this->valid->validHash($hash)) return false;
            if ($hash != "") {
                $login = $this->user->getUserOnRecHash($hash);
                $hash_user = $this->user->getHash($login);
                if ($hash === $hash_user) {
                    $content = new RecContent($db);
                    echo $content->getContent();
                }
                else{
                    exit;
                }
            }
        }
    }
$act = new Recovery($db);
$act->Recov();

?>