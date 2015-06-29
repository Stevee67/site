<?php
require_once "global_class.php";

class EditMenu extends GlobalClass{

    public function __construct($db){
        parent::__construct("menu", $db);
    }

    public function setTitleMenu($value, $value_in){
        return $this->setField("title", $value,"title", $value_in );
    }

    public function getTitleMenu($id){
        return $this->getFieldOnID($id, "title");
    }

    public function AddMenu($title,$link){
        if(!$this->valid->validNameMenu($title)) return false;
        return $this->add(array("title" => $title, "link" => $link));
    }

    public function isMenu($id){
        return $this->isExists("id", $id + 1);
    }
}

?>