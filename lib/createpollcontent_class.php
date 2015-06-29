<?php
require_once "modules_class.php";

class CreatePollContent extends Modules{

    public function __construct($db){
        parent:: __construct($db);
    }

    protected function getTitle()
    {
        return "Створення опитування";
    }

    protected function getMetaDesc()
    {
        return "створення опитування";
    }

    protected function getMetaKey()
    {
        return "створення опитування, створити опитування";
    }
    protected function getMiddle()
    {
        if(!$this->isAdmin()) return $this->config->address;
        $sr["message"] = $this->getMessage();
        return $this->getReplaceTemplate($sr, "form_createpoll");

    }

}
?>