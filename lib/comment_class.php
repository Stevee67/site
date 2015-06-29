<?php
require_once "global_class.php";

class Comment extends GlobalClass{

    public function __construct($db){
        parent::__construct("comments", $db);
    }

    public function addComments($id, $login, $date, $comment){
        return $this->add(array("id_article" =>$id, "login" => $login, "date" =>$date, "comment" => $comment ));
    }
    private function isExistLogin($login){
        return $this->isExists("login", $login);
    }

    public function getCommentOnId($id){
        return $this->getAllOnField("id_article", $id);
    }

    public function editComment($id, $comment){
        $this->valid->validComment($comment);
        return $this->edit($id, array("comment"=>$comment));
    }

    public function deleteComment($id){
        return $this->delete($id);
    }


}

?>