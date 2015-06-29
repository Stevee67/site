<?php
require_once "modules_class.php";

class DeleteMenuContent extends Modules{

    public function __construct($db){
        parent:: __construct($db);
    }

    protected function getTitle()
    {
        return "Видалення меню";
    }

    protected function getMetaDesc()
    {
        return "видалення меню";
    }

    protected function getMetaKey()
    {
        return "видалення меню, видалити меню";
    }
    protected function getMiddle()
    {
        if(!$this->isAdmin()) return $this->config->address;
        $id = $_GET["id"];

        if($id == 1) {
            $sr["title"] = "Видалення пункту меню!";
            $sr["text"] = "Цей пункт меню видалити не можна!";
            return $this->getReplaceTemplate($sr, "message");
        }
        $result = $this->menu->delete($id);
        if($result){
            $sr["title"] = "Видалення пункту меню!";
            $sr["text"] = "Меню видалено успішно!";
            return $this->getReplaceTemplate($sr, "message");
        }
        else {
            $sr["title"] = "Видалення пункту меню!";
            $sr["text"] = "При видаленні виникла помилка!";
            return $this->getReplaceTemplate($sr, "message");
        }
    }

}
?>