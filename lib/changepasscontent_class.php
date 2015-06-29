<?php
require_once "modules_class.php";

class ChangePassContent extends Modules{

    public function __construct($db){
        parent:: __construct($db);
    }

    protected function getTitle()
    {
        return "Зміна паролю";
    }

    protected function getMetaDesc()
    {
        return "зміна паролю";
    }

    protected function getMetaKey()
    {
        return "зміна пароль, поміняти пароль, пароль інший";
    }
    protected function getMiddle()
    {
        if(!$_SESSION["login"]) return $this->config->address;
        $sr["message"] = $this->getMessage();
        return $this->getReplaceTemplate($sr, "form_changepass");
    }

}


?>
