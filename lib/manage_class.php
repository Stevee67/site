<?php
require_once "config_class.php";
require_once "user_class.php";
require_once "checkvalid_class.php";
require_once "mail_class.php";
require_once "poll_class.php";
require_once "pollvariant_class.php";
require_once "comment_class.php";
require_once "editmenu_class.php";
require_once "section_class.php";
require_once "article_class.php";

class Manage{

    private $config;
    private $user;
    private $data;
    private $valid;
    private $emails;
    private $poll;
    private $poll_variant;
    private $comments;
    private $editmenu;
    private $section;
    private $article;

    public function __construct($db){
        session_start();
        $this->config = new Config();
        $this->valid = new CheckValid();
        $this->user = new User($db);
        $this->emails = new Mail();
        $this->poll = new Poll($db);
        $this->poll_variant = new PollVariant($db);
        $this->data = $this->secureData(array_merge($_POST, $_GET));
        $this->comments = new Comment($db);
        $this->editmenu = new EditMenu($db);
        $this->section = new Section($db);
        $this->article = new Article($db);

    }
    private function secureData($data){
        foreach ($data as $key=>$value) {
            if(is_array($value)) $this->secureData($value);
            else $data[$key] = htmlspecialchars($value);
        }
        return $data;
    }

    public function redirect($link){
        header("Location: $link");
        exit;
    }

    public function regUser(){
        if($_SESSION["login"]) return $this->config->address;
        $link_reg = $this->config->address."?view=reg";
        $captcha = $this->data["captcha"];
        if(($_SESSION["rand"] != $captcha) && ($_SESSION["rand"] != "")){
            return $this->returnMessage("ERROR_CAPTCHA", $link_reg);
        }
        $login = $this->data["login"];
        if($this->user->isExistsUser($login)) return $this->returnMessage("EXISTS_LOGIN", $link_reg);
        $secretword = $this->hashSecretWord($login);
        $recovery = $this->hashSecretWord($login);
        $password = $this->data["password"];

        if($password == "") return $this->uknownError($link_reg);
        $password = $this->hashPassword($password);
        //echo $password;
        $mail = $this->data["email"];
        //echo $mail;
        if($mail == "") return $this->returnEmailMessage("EMAIL_FALSE", $link_reg);
        if(!$this->valid->validEmail($mail)) return $this->returnEmailMessage("EMAIL_ERROR", $link_reg);

        $link_activation = $this->config->address."activate.php?hash=".$secretword;
        $messages = "Для активації вашого акаунту перейдіть по ссилці ".$link_activation;


        $result = $this->user->addUser($login, $mail, $secretword, $recovery, $password, time());
        //var_dump($result);
        $this->sendEmailTo($mail, $messages);

        if($result) return $this->returnPageMessage("ACTIVATION_REG", $this->config->address."?view=message");
        else return $this->uknownError($link_reg);


    }

    public function edit(){
        if(!$_SESSION["login"] === $this->user->getLoginOnId("1")) return false;
        $id = $_POST["hash"];
        $oldtitle = $this->editmenu->getTitleMenu($id);
        $title = $_POST["newtitle"];
        $result = $this->editmenu->setTitleMenu($title, $oldtitle);
        if($result) return $this->returnPageMessage("CHANGE_MENUSUCC", $this->config->address."?view=message");
        else return $this->uknownError($this->config->address."?view=editmenu");

    }

    public function editsection(){
        if(!$_SESSION["login"] === $this->user->getLoginOnId("1")) return false;
        $idm = $_POST["hash"];
        $id = $_POST["newid"];
        if($this->section->isSection($id)) return $this->returnMessage("ERR_SECTIONIS", $this->config->address."?view=editsection");
        $title = $_POST["newtitle"];
        $description = "<p>".$_POST["newdescription"]."</p>";
        $metadesc = $_POST["newmetadesc"];
        $metakey = $_POST["newmetakey"];
        if($_POST["newimage"] == "") {
            $result = $this->section->editSectionWithoutImage($idm, $id, $title, $description, $metadesc, $metakey);
            if($result) return $this->returnPageMessage("EDIT_SECTIONSUCC", $this->config->address."?view=message");
            else return $this->returnPageMessage("EDIT_SECTIONERR", $this->config->address."?view=message");
        }
        $image = "<img src = 'image/".$_POST["newimage"]."'>";
        if($this->valid->validSection($id, $title, $description, $metadesc, $metakey, $image)) return false;

        $result = $this->section->editSection($idm, $id, $title, $description, $metadesc, $metakey, $image);
        if($result) return $this->returnPageMessage("EDIT_SECTIONSUCC", $this->config->address."?view=message");
        else return $this->returnPageMessage("EDIT_SECTIONERR", $this->config->address."?view=message");



    }
    public function editarticle(){
        if(!$_SESSION["login"] === $this->user->getLoginOnId("1")) return false;
        $idm = $_POST["hash"];
        $id = $_POST["newid"];
        if($id == $idm) $id = $_POST["newid"];
        elseif($this->article->isArticle($id)) return $this->returnMessage("ERR_ARTICLEIS", $this->config->address."?view=editarticle&id="."$idm");
        $section_id = $_POST["newsection_id"];
        $title = $_POST["newtitle"];
        if(!$this->valid->validText($title)) return $this->returnMessage("ERR_ARTICLETITLE", $this->config->address."?view=editarticle&id="."$idm");
        $intro_text = $_POST["newintro_text"];
        $full_text = $_POST["newfull_text"];
        $metadesc = $_POST["newmetadesc"];
        $metakey = $_POST["newmetakey"];
        if($_POST["newimage"] == "") {
            $result = $this->article->editArticleWithoutImage($idm, $id, $section_id, $title, $intro_text, $full_text, $metadesc, $metakey);
            if($result) return $this->returnPageMessage("EDIT_ARTICLESUCC", $this->config->address."?view=message");
            else return $this->returnPageMessage("EDIT_ARTICLEERR", $this->config->address."?view=message");
        }
        if(!$this->valid->validNameImage($_POST["newimage"])) return $this->returnMessage("ERR_IMAGENAME", $this->config->address."?view=editarticle&id="."$idm");
        $image = "<img src = 'image/".$_POST["newimage"]."'>";

        $result = $this->article->editArticle($idm, $id, $section_id, $title, $intro_text, $full_text, $metadesc, $metakey, $image);
        if($result) return $this->returnPageMessage("EDIT_ARTICLESUCC", $this->config->address."?view=message");
        else return $this->returnPageMessage("EDIT_ARTICLEERR", $this->config->address."?view=message");

    }
    public function editcomment(){
        if(!$_SESSION["login"] === $this->user->getLoginOnId("1")) return false;
        $id = $_POST["hash"];
        $comment = $_POST["comment"];
        if($comment == ""){
            $this->comments->delete($id);
            return $this->returnPageMessage("DELL_COMMENT", $this->config->address."?view=message");
        }
       else{
            $result = $this->comments->editComment($id, $comment);
           if(!$result) return $this->returnMessage("ERR_EDITCOMMENT", $this->config->address."?view=commentarticle&id="."$id");
           else return $this->returnPageMessage("EDIT_COMMENTSUCC", $this->config->address."?view=message");
       }

    }
    public function createsection(){
        if(!$_SESSION["login"] === $this->user->getLoginOnId("1")) return false;
        $id = $_POST["newid"];
        if($this->section->isSection($id)) return $this->returnMessage("ERR_SECTIONIS", $this->config->address."?view=createsections");
        $title = $_POST["newtitle"];
        $description = "<p>".$_POST["newdescription"]."</p>";
        $metadesc = $_POST["newmetadesc"];
        $metakey = $_POST["newmetakey"];
        $image = "<img src = 'image/".$_POST["newimage"]."'>";
        $result = $this->section->addSection($id, $title, $description, $metadesc, $metakey, $image);
        if($result) return $this->returnPageMessage("CREATE_SECTIONSUCC", $this->config->address."?view=message");
        else return $this->returnPageMessage("CREATE_SECTIONERR", $this->config->address."?view=message");

    }
    public function createarticle(){
        if(!$_SESSION["login"] === $this->user->getLoginOnId("1")) return false;
        $id = $_POST["id"];
        $_SESSION["id"] = $id;
        if($this->article->isArticle($id)) return $this->returnMessage("ERR_ARTICLEIS", $this->config->address."?view=createarticle");
        $section_id = $_POST["section_id"];
        $_SESSION["section_id"] = $section_id;
        $title = $_POST["title"];
        $_SESSION["title"] = $title;
        if(!$this->valid->validText($title)) return $this->returnMessage("ERR_ARTICLETITLE", $this->config->address."?view=createarticle");
        $intro_text = $_POST["intro_text"];
        $_SESSION["intro_text"] = $intro_text;
        $full_text = $_POST["full_text"];
        $_SESSION["full_text"] = $full_text;
        $metadesc = $_POST["metadesc"];
        $_SESSION["metadesc"] = $metadesc;
        $metakey = $_POST["metakey"];
        $_SESSION["metakey"] = $metakey;
        if(!$this->valid->validNameImage($_POST["image"])) return $this->returnMessage("ERR_IMAGENAME", $this->config->address."?view=createarticle");
        $image = "<img src = 'image/".$_POST["image"]."'>";

        $result = $this->article->addArticle($id, $section_id, $title, $intro_text, $full_text, $metadesc, $metakey, $image);


        if($result){
            unset($_SESSION["id"]);
            unset($_SESSION["section_id"]);
            unset($_SESSION["title"]);
            unset($_SESSION["intro_text"]);
            unset($_SESSION["full_text"]);
            unset($_SESSION["metadesc"]);
            unset($_SESSION["metakey"]);
            return $this->returnPageMessage("CREATE_ARTICLESUCC", $this->config->address."?view=message");
        }
        else return $this->returтMessage("CREATE_ARTICLEERR", $this->config->address."?view=createarticle");

    }

    public function create(){
        if(!$_SESSION["login"] === $this->user->getLoginOnId("1")) return false;
        $title = $_POST["title"];
        $id = $_POST["id"];
        if($this->editmenu->isMenu($id)) return $this->returnMessage("ERR_ISMENU", $this->config->address."?view=addnewitem");
        if(!$this->valid->validSectionID($id)) return $this->returnMessage("ERR_CREATEMENUID", $this->config->address."?view=addnewitem");
        $link = "/engine/?view=section&amp;id=".$_POST["id"];
        $result = $this->editmenu->AddMenu($title, $link);
        if($result) return $this->returnPageMessage("SUCCESS_ADDMENU", $this->config->address."?view=message");
        else return $this->returnPageMessage("ERR_ADDMENU", $this->config->address."?view=message");
    }

    public function login(){
        $login = $this->data["login"];
        $_SESSION["getlogin"] = $login;
        $password = $this->data["password"];
        $password = $this->hashPassword($password);
        $r = $_SERVER["HTTP_REFERER"];
        if(!$this->user->checkUser($login)) {
            $_SESSION["error_auth"] = 1;
            return $r;
        }
            if ($this->user->isAuth($login)) {
                $_SESSION["error_auth"] = 2;
                return $r;
            }
            if (!$this->user->ifPassWrong($login, $password)) {
                $_SESSION["error_auth"] = 3;
                return $r;
            }

        else{
            $_SESSION["login"] = $login;
            $_SESSION["password"] = $password;
            return $r;
        }
    }

    public function recPass(){
        $hash = $_SESSION["gethash"];
        unset($_SESSION["gethash"]);
        $phash = $_POST["hash"];
        $id = $this->user->getIdOnRecHash($phash);

        $password1 = $this->data["password1"];
        $password2 = $this->data["password2"];

        if($hash !== $phash) return $this->returnPageMessage("ERROR_HASH", $this->config->address."?view=message");
        if($password1 !== $password2) return $this->returnMessage("DIF_PASS", $this->config->address."recovery.php?hash=".$hash);
        $result = $this->user->editPass($id, $this->hashPassword($password2));
        if($result) return $this->returnPageMessage("SUCCESS_DIF", $this->config->address."?view=message");


    }

    public function logout()
    {
        unset($_SESSION["login"]);
        unset($_SESSION["password"]);
        return $_SERVER["HTTP_REFERER"];
    }

    public function poll(){
        $r = $_SERVER["HTTP_REFERER"];
        if(!$_SESSION["login"]) return $this->returnMessagePoll("FALSE_POLL", $r);
        $id = $this->data["variant"];
        $variant = $this->poll_variant->get($id);
        $poll_id = $variant["poll_id"];
        if($this->user->getVote($_SESSION["login"]) !== $poll_id) {
            $this->user->editVote($_SESSION["login"], $poll_id);
            $this->poll_variant->setVotes($id, $variant["votes"] + 1);
            return $this->config->address . "?view=poll&id=$poll_id";
        }else return $this->returnMessagePoll("ALREADY_VOTE", $r);
    }

    public function comment(){
        $r = $_SERVER["HTTP_REFERER"];
        if(!$_SESSION["login"]) return $this->returnMessageArt("FALSE_SENDCOMM", $r);
        $comment = $_POST["comment"];
        if(!$this->valid->validComment($comment)) return $this->returnMessageArt("ERR_SENDCOMM", $r);
        $id = $_POST["id"];
        $login = $_SESSION["login"];
        $results = $this->comments->addComments($id, $login, time(), $comment);
        if(!$results) return $this->uknownError($r);
        return $r;

    }

    public function changepass(){
        $link_change = $this->config->address."?view=changepass";
        if(!$_SESSION["login"]) return false;
        $login = $_SESSION["login"];
        $user = $this->user->getUserOnLogin($login);
        $oldpass = $this->hashPassword($_POST["password0"]);
        $password1 = $this->hashPassword($_POST["password1"]);
        $password2 = $this->hashPassword($_POST["password2"]);
        if($oldpass != $user["password"]) return $this->returnMessage("ERR_CHANGE", $link_change);
        if(!$this->valid->validPassword($_POST["password1"])) return $this->returnMessage("PASSIS_NOCORRECT", $link_change);
        //if($password1 = "") return $this->returnMessage("NON_PASS", $link_change);
        if($password1 != $password2) return $this->returnMessage("WRONG_CHANGEPASS", $link_change);
        $result = $this->user->editPass($user["id"], $password1);
        if($result) return $this->returnPageMessage("SUCCESS_CHANGEPASS",$this->config->address."?view=message");
        else return $this->uknownError($link_change);

    }

    private function sendEmailTo($mail, $messages){
        $this->emails->sendEmail($mail, "Підтвердження реєстрації", $messages);
    }

    private function hashSecretWord($login){
        return md5($login.$this->config->secret);
    }

    private function hashPassword($password){
        return md5($password.$this->config->secret);
    }

    private function returnEmailMessage($email, $r){
        $_SESSION["message"] = $email;
        return $r;
    }
    private function returnMessagePoll($message, $r){
        $_SESSION["messagepoll"] = $message;
        return $r;
    }
    private function returnMessageArt($message, $r){
        $_SESSION["meessage"] = $message;
        return $r;
    }

    private function returnMessage($message, $r){
        $_SESSION["message"] = $message;
        return $r;
    }

    private function returnPageMessage($message, $r){
        $_SESSION["page_message"] = $message;
        return $r;
    }

    private function uknownError($r){
        return $this->returnMessage("UKNOWN_ERROR", $r);
    }
}

?>