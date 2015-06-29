<?php
require_once "modules_class.php";

class CreateMenuContent extends Modules{

    public function __construct($db){
        parent:: __construct($db);
    }

    protected function getTitle()
    {
        return "Створення меню";
    }

    protected function getMetaDesc()
    {
        return "створення меню";
    }

    protected function getMetaKey()
    {
        return "створення меню, створити меню";
    }
    protected function getMiddle()
    {
        if(!$this->isAdmin()) return $this->config->address;
        $sr["message"] = $this->getMessage();
        return $this->getReplaceTemplate($sr, "form_createmenu");
    }

}
?>