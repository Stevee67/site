<?php
require_once "modules_class.php";

class ChangeSectionContent extends Modules{

    public function __construct($db){
        parent:: __construct($db);
    }

    protected function getTitle()
    {
        return "Редагування розділів";
    }

    protected function getMetaDesc()
    {
        return "редагування розділів";
    }

    protected function getMetaKey()
    {
        return "редагування розділів, розділи редагувати";
    }
    protected function getMiddle()
    {
        if($_SESSION["login"] !== $this->user->getLoginOnId("1")) return $this->config->address;
        $sr["message"] = $this->getMessage();
        $sections = $this->section->getAll();
        for($i=0; $i < count($sections); $i++){
            $sr["title"] = $sections[$i]["title"];
            $sr["id"] = $sections[$i]["id"];
            $sr["sections"] .= $this->getReplaceTemplate($sr, "section_item");
        }
        return $this->getReplaceTemplate($sr, "form_changesection");
    }

}
?>