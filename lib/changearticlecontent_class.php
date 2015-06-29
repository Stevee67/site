<?php
require_once "modules_class.php";

class ChangeArticleContent extends Modules{

    public function __construct($db){
        parent:: __construct($db);
    }

    protected function getTitle()
    {
        return "Редагування статтей";
    }

    protected function getMetaDesc()
    {
        return "редагування статтей";
    }

    protected function getMetaKey()
    {
        return "редагування статтей, стаття редагувати";
    }
    protected function getMiddle()
    {
        if($_SESSION["login"] !== $this->user->getLoginOnId("1")) return $this->config->address;
        $sr["message"] = $this->getMessage();
        $article = $this->article->getAll();
        for($i=0; $i < count($article); $i++){
            $sr["title"] = $article[$i]["title"];
            $sr["id"] = $article[$i]["id"];
            $sr["articles"] .= $this->getReplaceTemplate($sr, "article_item");
        }
        return $this->getReplaceTemplate($sr, "form_changearticle");

    }

}
?>