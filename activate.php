<?php
    require_once "lib/checkvalid_class.php";
    require_once "lib/user_class.php";
    require_once "lib/config_class.php";
    require_once "lib/messagecontent_class.php";

    $db = new DataBase();

    class Activate{
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

        public function Content(){
            $hash = $_GET["hash"];
            if (!$this->valid->validHash($hash)) return false;
            if ($hash != "") {
                $res = $this->user->getUserOnHash($hash);

                if ($res) {
                    $id = $this->user->getIdOnHash($hash);
                    $this->user->delHash($id);
                    return $this->returnPageMessage("ACT_SUCCES", $this->config->address . "?view=message");
                }
                else return $this->returnPageMessage("ACT_FALSE", $this->config->address . "?view=message");
            }
            else return $this->returnPageMessage("ACT_WR", $this->config->address . "?view=message");
        }
    }
$act = new Activate($db);
$act->Content();
$content = new MessageContent($db);
echo $content->getContent();

?>