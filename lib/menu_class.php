<?php
require_once "global_class.php";

class Menu extends GlobalClass{

    public function __construct($db){
        parent::__construct("menu", $db);
    }

    public function getFieldMenu($id){
        return $this->getField("title", "id", $id);
    }

    public function delItemMenu($id){
        return $this->delete($id);
    }

}

?>