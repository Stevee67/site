<?php
require_once "modules_class.php";

class CreateArticleContent extends Modules{

    public function __construct($db){
        parent:: __construct($db);
    }

    protected function getTitle()
    {
        return "Створення статті";
    }

    protected function getMetaDesc()
    {
        return "створення статті";
    }

    protected function getMetaKey()
    {
        return "створення статті, створити статтю";
    }
    protected function getMiddle()
    {
        if(!$this->isAdmin()) return $this->config->address;
        $sr["message"] = $this->getMessage();
        $sr["id"] = $_SESSION["id"];
        $sr["section_id"] = $_SESSION["section_id"];
        $sr["title"] = $_SESSION["title"];
        $sr{"intro_text"} = $_SESSION["intro_text"];
        $sr["full_text"] = $_SESSION["full_text"];
        $sr["metadesc"] = $_SESSION["metadesc"];
        $sr["metakey"] = $_SESSION["metakey"];
        return $this->getReplaceTemplate($sr, "form_createarticle");

    }

}
?>