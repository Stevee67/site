<?php
require_once "modules_class.php";

class ChangeCommentArticleContent extends Modules{

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
        $id = $_GET["id"];
        $comment = $this->comment->getCommentOnId($id);
        if(!$comment) {
            $sr["desc"] = "До цієї статті немає коментарів!";
            $sr['comments'] = "";
            return $this->getReplaceTemplate($sr, "form_changearticlecomment");
        }
        for($i=0; $i < count($comment); $i++){
            $sr["desc"] = "Щоб видалити коментар залишіть текстове поле пустим!";
            $sr["comment"] = $comment[$i]["comment"];
            $sr["id"] = $comment[$i]["id"];
            $sr["comments"] .= $this->getReplaceTemplate($sr, "commentarticle_item");
        }
        return $this->getReplaceTemplate($sr, "form_changearticlecomment");

    }

}
?>