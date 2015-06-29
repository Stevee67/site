<?php
require_once "global_class.php";

class Section extends GlobalClass{

    public function __construct($db){
        parent::__construct("sections", $db);
    }

    public function editSection($idm, $id, $title, $description, $metadesc, $metakey, $image){
        return $this->edit($idm, array("id" => $id, "title" => $title, "description" => $description, "meta_desc" => $metadesc, "meta_key" => $metakey, "image" => $image) );
    }
    public function editSectionWithoutImage($idm, $id, $title, $description, $metadesc, $metakey){
        return $this->edit($idm, array("id" => $id, "title" => $title, "description" => $description, "meta_desc" => $metadesc, "meta_key" => $metakey) );
    }

    public function isSection($id){
        return $this->isExists("id", $id);
    }
    public function addSection($id, $title, $description, $metadesc, $metakey, $image){
        return $this->add(array("id"=>$id, "title"=>$title,"description"=>$description, "meta_desc"=>$metadesc, "meta_key"=>$metakey, "image"=>$image));
    }

}

?>