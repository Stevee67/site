<?php
require_once "modules_class.php";

class ArticleContent extends Modules{
    private $article_info;

    public function __construct($db){
        parent:: __construct($db);

        $this->article_info = $this->article->get($this->data["id"]);
        if(!$this->article_info) $this->notFound();
    }

    protected function getTitle()
    {
        return $this->article_info["title"];
    }

    protected function getMetaDesc()
    {
        return $this->article_info["meta_desc"];
    }

    protected function getMetaKey()
    {
        return $this->article_info["meta_key"];
    }
    protected function getImage()
    {
        return $this->article_info["image"];
    }

    protected function getMiddle()
    {
        return $this->getArticle();
    }

    private function getArticle(){
        $sr["title"] = $this->article_info["title"];
        $sr["image"] = $this->article_info["image"];
        $sr["full_text"] = $this->article_info["full_text"];
        $sr["date"] = $this->formatDate($this->article_info["date"]);
        $sr["meessage"] = $this->getMessageArt();
        $sr["id"] = $this->article_info["id"];
        $sr["comments"] = $this->getComment();
        $sr["commare"] = $this->orIsComment();
        return $this->getReplaceTemplate($sr, "article");
    }

}


?>