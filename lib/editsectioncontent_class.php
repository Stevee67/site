<?php
require_once "modules_class.php";

class EditSectionContent extends Modules{

    public function __construct($db){
        parent:: __construct($db);
    }

    protected function getTitle()
    {
        return "Редагування розділу";
    }

    protected function getMetaDesc()
    {
        return "редагування розділу";
    }

    protected function getMetaKey()
    {
        return "редагування розділу, розділ редагувати";
    }
    protected function getMiddle()
    {
            if(!$this->isAdmin()) return $this->config->address;
            $sr["message"] = $this->getMessage();
            $id = $_GET["id"];
            $section = $this->section->get($id);
            if(!$section) return false;
            $sr["idm"] = $section["id"];
            $sr["id"] = $section["id"];
            $sr["title"] = $section["title"];
            $sr["description"] = $section["description"];
            $sr["metadesc"] = $section["meta_desc"];
            $sr["metakey"] = $section["meta_key"];
            $sr["image"] = $section["image"];

            $text .= $this->getReplaceTemplate($sr, "section_itemedit");
            $sr["section"] = $text;
            return $this->getReplaceTemplate($sr, "form_sectionedit");

    }

}
?>