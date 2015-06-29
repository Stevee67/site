<?php
    require_once "config_class.php";
    require_once "checkvalid_class.php";

    class Mail{

        protected $mail;
        private $config;
        private $valid;
        protected $subject;
        protected $message;

        public function __construct(){
            $this->config = new Config();
            $this->valid = new CheckValid();
        }
        private function codSubject($subject){
            $subject = "=?utf-8?B?".base64_encode($subject)."?=";
            return $subject;
        }

        public function sendEmail($mail,$subject,$message){
            $subject = $this->codSubject($subject);
            $headers = "From:".$this->config->admemail."\r\nReply-to:".$this->config->admemail."\r\nContent-type:text/plain;charset=utf-8\r\n";
            if(!$this->valid->validEmail($mail)) return false;
            else mail($mail, $subject, $message, $headers);
        }
    }
?>