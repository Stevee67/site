<?php
    require_once "config_class.php";

    class CheckValid{
        private $config;

        public function __construct(){
            $this->config = new Config();
        }
        public function validID($id){
            if(!$this->isIntNumber($id)) return false;
            if($id <= 0) return false;
            return true;
        }
        public function validSectionID($id){
            if(!$this->isIntNumber($id)) return false;
            if($id <= 0) return false;
            return true;
        }

        public function validLogin($login){
            if($this->isContainQuotes($login)) return false;
            if(preg_match("/^\d*$/", $login)) return false;
            return $this->validString($login, $this->config->min_login, $this->config->max_login);
        }

        public function validNameMenu($name){
            if(!$this->validString($name, 3, 32)) return false;
            if(!$this->isOnlyLettersAndDigits($name)) return false;
            return true;
        }
        public function validSection($id, $title, $description, $metadesc, $metakey, $image){
            if(!$this->validSectionID($id)) return false;
            if(!$this->validText($title)) return false;
            if(!$this->validComment($description)) return false;
            if(!$this->validText($metadesc)) return false;
            if(!$this->validText($metakey)) return false;
            if(!$this->validNameImage($image)) return false;
            return true;
        }

        public function validPassword($password){
            if(!$this->validString($password, 3, 32)) return false;
            if(!$this->isOnlyLettersAndDigits($password)) return false;
            return true;
        }

        public function validHash($hash){
            if(!$this->validString($hash, 32, 32)) return false;
            if(!$this->isOnlyLettersAndDigits($hash)) return false;
            return true;

        }

        public function validNameImage($image){
            if(!$this->validString($image, 5, 255)) return false;
            if(!preg_match("/[a-z0-9]*\.[a-z]+/i",$image)) return false;
            return true;
        }

        public function validEmail($email){
            if(!$this->validString($email, 5, 255)) return false;
            if(!preg_match("/[a-z0-9][a-z0-9\.-_]*[a-z0-9]+@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i",$email)) return false;
            return true;
        }

        public function validComment($text){
            if(!$this->validString($text, 1, 1024)) return false;
            return true;
        }

        public function validText($text){
            if(!$this->validString($text, 3, 255)) return false;
            return true;
        }

        public function validTimeStamp($time){
            return $this->isNoNegativeInteger($time);
        }

        private function validString($string, $min_length, $max_length){
            if(!is_string($string)) return false;
            if (strlen($string) < $min_length) return false;
            if(strlen($string) > $max_length) return false;
            return true;
        }

        private function isContainQuotes($string){
            $array = array("\\", "'", "`", "&quot;", "&apos;" );
            foreach ($array as $key =>$value) {
                if(strpos($string, $value) !== false) return true;
            }
            return false;

        }
        private function isIntNumber($number){
            if(!is_int($number) && !is_string($number)) return false;
            if(!preg_match("/^-?(([1-9][0-9]*|0))$/", $number)) return false;
            return true;
        }

        public function validVotes($votes){
            return $this->isNoNegativeInteger($votes);
        }

        private function isNoNegativeInteger($number){
            if(!$this->isIntNumber($number)) return false;
            if ($number < 0) return false;
            return true;
        }

        private function isOnlyLettersAndDigits($string){
            if(!is_int($string) && !is_string($string)) return false;
            if(!preg_match("/[a-zа-я0-9]*/i", $string)) return false;
            return true;
        }
    }

?>