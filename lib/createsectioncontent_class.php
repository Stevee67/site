<?php
require_once "modules_class.php";

class CreateSectionContent extends Modules{

    public function __construct($db){
        parent:: __construct($db);
    }

    protected function getTitle()
    {
        return "Створення розділу";
    }

    protected function getMetaDesc()
    {
        return "створення розділу";
    }

    protected function getMetaKey()
    {
        return "створення розділу, створити розділ";
    }
    protected function getMiddle()
    {
        if(!$this->isAdmin()) return $this->config->address;
        $sr["message"] = $this->getMessage();
        return $this->getReplaceTemplate($sr, "form_createsection");

    }

}
?>