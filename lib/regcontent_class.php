<?php
require_once "modules_class.php";

class RegContent extends Modules{

    public function __construct($db){
        parent:: __construct($db);

    }

    protected function getTitle()
    {
        return "Реєстрація на сайті";
    }

    protected function getMetaDesc()
    {
        return "Реєстрація користувача на сайті.";
    }

    protected function getMetaKey()
    {
        return "реєстрація сайт, реєстрація користувача сайт";
    }

    protected function getMiddle()
    {
        $sr["message"] = $this->getMessage();
        $sr["email"] = $this->getEmailMessage();
        $sr["login"] = $_SESSION["login"];
        $sr["e-mail"] = $_SESSION["e-mail"];
        return $this->getReplaceTemplate($sr, "form_reg");
    }

}


?>