<?php
require_once "global_class.php";

class User extends GlobalClass{

    public function __construct($db){
        parent::__construct("users", $db);
    }

    public function addUser($login, $mail, $secretword, $recovery, $password, $regdate){
        //var_dump($mail);
        //var_dump($this->checkValid($login, $mail, $password, $regdate));
        if(!$this->checkValid($login, $mail, $password, $regdate)) return false;
        return $this->add(array("login" => $login, "email" =>$mail,"secretword" =>$secretword, "recovery_hash" => $recovery, "password" => $password, "regdate" => $regdate ));
    }

    public function delHash($id){
        $hash = "";
        return $this->edit($id, array("secretword"=>$hash));
    }

    public function editVote($login, $vote){
        $id = $this->getIdOnLogin($login);
        if($this->valid->validText($vote)) return false;
        return $this->edit($id, array("title_vote"=>$vote));
    }

    public function editPass($id, $newpassword){
        if(!$this->valid->validHash($newpassword)) return false;
        return $this->edit($id, array("password"=>$newpassword));
    }

    public function editUser($id, $login, $mail, $password, $regdate){
        if(!$this->checkValid($login, $mail, $password, $regdate)) return false;
        return $this->edit($id, array("login" => $login, "email" => $mail, "password" => $password, "regdate" => $regdate ));
    }
    public function isExistsUser($login){
        //var_dump($this->isExists("login", $login));
        return $this->isExists("login", $login);
    }

    public function getHashOnGet($hash){
        $login = $this->getUserOnRecHash($hash);
        return $this->getHash($login);
    }
    public function getVote($login){
        return $hash = $this->getField("title_vote", "login", $login);
    }

    public function getHash($login){
        return $hash = $this->getField("recovery_hash", "login", $login);
    }

    public function getLoginOnId($id){
        return $hash = $this->getField("login", "id", $id);
    }

    public function getHashOnId($id){
        return $hash = $this->getField("recovery_hash", "id", $id);
    }

    public function getMail($login){
        if($mail = $this->getField("email", "login", $login)) return $mail;
        else return false;
    }

    public function isAuth($login){
        $hash = $this->getField("secretword", "login", $login);
        return $hash;
    }

    private function getIdOnLogin($login){
        return $id = $this->getField("id", "login", $login);
    }

    public function getUserOnLogin($login){
        $id = $this->getField("id", "login", $login);
        //var_dump($id);
        return $this->get($id);
    }

    public function getIdOnRecHash($hash){
        return $this->getField("id", "recovery_hash", $hash);
    }

    public function getIdOnHash($hash)
    {
        return $this->getField("id", "secretword", $hash);
    }

    public function getUserOnRecHash($hash){
        $login = $this->getField("login", "recovery_hash", $hash);
        return $login;
    }

    public function getUserOnHash($hash){
        $id = $this->getField("id", "secretword", $hash);
            return $this->get($id);
    }

    public function checkUser($login){
        $user = $this->getUserOnLogin($login);
        if(!$user) return false;
        else return true;

        //return $user["password"] === $password;
    }

    public function ifPassWrong($login, $password){
        $user = $this->getUserOnLogin($login);
        return $user["password"] === $password;
    }

    public function getUs($id){
        return $this->get($id);
    }

    public function getAlll(){
        return $this->getAll();
    }


    private function checkValid($login, $mail, $password, $regdate){
        if(!$this->valid->validLogin($login)) return false;
        //var_dump($this->valid->validLogin($login));
        if(!$this->valid->validHash($password)) return false;
        //var_dump($this->valid->validHash($password));
        if(!$this->valid->validTimeStamp($regdate)) return false;
        //var_dump($this->valid->validTimeStamp($regdate));
        if(!$this->valid->validEmail($mail)) return false;
        return true;

    }
    public function getTables(){
        $this->getTable();
    }
}

?>