<?php
require_once "modules_class.php";

class EditArticleContent extends Modules{

    public function __construct($db){
        parent:: __construct($db);
    }

    protected function getTitle()
    {
        return "Редагування статті";
    }

    protected function getMetaDesc()
    {
        return "редагування статті";
    }

    protected function getMetaKey()
    {
        return "редагування статті, стаття редагувати";
    }
    protected function getMiddle()
    {
        if(!$this->isAdmin()) return $this->config->address;
        $sr["message"] = $this->getMessage();
        $id = $_GET["id"];
        $article = $this->article->get($id);
        if(!$article) return false;
        $sr["section_id"] = $article["section_id"];
        $sr["idm"] = $article["id"];
        $sr["id"] = $article["id"];
        $sr["title"] = $article["title"];
        $sr["intro_text"] = $article["intro_text"];
        $sr["full_text"] = $article["full_text"];
        $sr["metadesc"] = $article["meta_desc"];
        $sr["metakey"] = $article["meta_key"];

        $text .= $this->getReplaceTemplate($sr, "article_itemedit");

        $sr["article"] = $text;
        return $this->getReplaceTemplate($sr, "form_articleedit");

    }

}
?>