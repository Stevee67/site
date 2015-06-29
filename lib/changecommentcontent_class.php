<?php
require_once "modules_class.php";

class ChangeCommentContent extends Modules{

    public function __construct($db){
        parent:: __construct($db);
    }

    protected function getTitle()
    {
        return "Редагування коментарів";
    }

    protected function getMetaDesc()
    {
        return "редагування коментарів";
    }

    protected function getMetaKey()
    {
        return "редагування коментарів, коментарі редагувати";
    }
    protected function getMiddle()
    {
        if($_SESSION["login"] !== $this->user->getLoginOnId("1")) return $this->config->address;
        $sr["message"] = $this->getMessage();
        $article = $this->article->getAll();
        for($i=0; $i < count($article); $i++){
            $sr["title"] = $article[$i]["title"];
            $sr["id"] = $article[$i]["id"];
            $sr["article"] .= $this->getReplaceTemplate($sr, "comment_item");
        }
        return $this->getReplaceTemplate($sr, "form_changecomment");

    }

}
?>